<?php

/**
 * Fired during plugin activation and upgrade
 *
 * @link       https://www.adback.co
 * @since      2.4.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 */

/**
 * Fired during plugin activation and upgrade
 *
 * This class defines all code necessary to run during the plugin's upgrade
 *
 * @since      2.4.0
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 * @author     AdBack <contact@adback.co>
 */
class Ad_Back_Updator
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function update()
    {
        global $wpdb;

        $currentVersion = (int)get_option("adback_solution_to_adblock_db_version");

        if (null === $currentVersion || $currentVersion < 2) {
            $currentVersion = 3;
            if (is_multisite()) {
                $sites = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

                foreach ($sites as $blogId) {
                    switch_to_blog($blogId);
                    self::createFullTagAndEndPointDatabase();
                    restore_current_blog();
                }
            } else {
                self::createFullTagAndEndPointDatabase();
            }
            update_option("adback_solution_to_adblock_db_version", $currentVersion);
        }
    }

    /**
     * On update from version 2
     *
     * @since    1.0.0
     */
    public static function onUpdateFromOldVersion()
    {
        global $wpdb;
        $currentVersion = (int)get_option('adback_solution_to_adblock_db_version');

        if (2 === $currentVersion) {
            update_option('adback_integration', '1');
            update_option('adback_solution_to_adblock_db_version', 3);
        }
        if (3 === $currentVersion) {
            update_option('adback_solution_to_adblock_db_version', 4);
            $adback_account = $wpdb->prefix . 'adback_account';
            $wpdb->replace(
                $adback_account,
                array(
                    'id' => get_current_blog_id(),
                    'username' => get_bloginfo('admin_email'),
                )
            );
        }
    }

    /**
     * Update full tag and endpoint database
     */
    public static function createFullTagAndEndPointDatabase()
    {
        global $wpdb;

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        require_once(dirname(__FILE__) . '/ad-back-rewrite-rule-validator.php');

        $charset_collate = $wpdb->get_charset_collate();

        $blogId = get_current_blog_id();

        // List tables names
        $table_name_full_tag = $wpdb->prefix . 'adback_full_tag';
        $table_name_end_point = $wpdb->prefix . 'adback_end_point';
        $table_name_token = $wpdb->prefix . 'adback_token';

        $sql = '';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_full_tag'") != $table_name_full_tag) {
            $sql = "CREATE TABLE " . $table_name_full_tag . " (
                `id` mediumint(9) NOT NULL,
                `blog_id` mediumint(9) NOT NULL,
                `type` varchar(100) DEFAULT '' NOT NULL,
                `value` mediumtext DEFAULT '' NOT NULL,
                `update_time` DATETIME NULL,
                UNIQUE KEY id (id)
            ) " . $charset_collate . ";";
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_end_point'") != $table_name_end_point) {
            $sql .= "CREATE TABLE " . $table_name_end_point . " (
                `id` mediumint(9) NOT NULL,
                `old_end_point` varchar(64) DEFAULT '' NOT NULL,
                `end_point` varchar(64) DEFAULT '' NOT NULL,
                `next_end_point` varchar(64) DEFAULT '' NOT NULL,
                UNIQUE KEY id (id)
            ) " . $charset_collate . ";";
        }

        if ('' !== $sql) {
            dbDelta($sql);
        }

        $savedToken = $wpdb->get_row("SELECT * FROM " . $table_name_token . " WHERE id = " . $blogId);

        if (null !== $savedToken && '' !== $savedToken->access_token) {
            if (self::isRewriteRouteEnabled()) {
                // loop while endpoints (next) conflict with rewrite rules, if not, insert all endpoint data
                for ($i = 0; $i < 5; $i++) {
                    $url = $i === 0 ? "https://www.adback.co/api/end-point/me?access_token=" : "https://www.adback.co/api/end-point/refresh?access_token=";
                    $endPointData = Ad_Back_Get::execute($url . $savedToken->access_token);
                    $endPoints = json_decode($endPointData, true);

                    if (
                        is_array($endPoints)
                        && array_key_exists('old_end_point', $endPoints)
                        && array_key_exists('end_point', $endPoints)
                        && array_key_exists('next_end_point', $endPoints)
                        && !Ad_Back_Rewrite_Rule_Validator::validate($endPoints['next_end_point'])
                    ) {
                        $wpdb->insert(
                            $table_name_end_point,
                            array(
                                'id' => $blogId,
                                'old_end_point' => $endPoints['old_end_point'],
                                'end_point' => $endPoints['end_point'],
                                'next_end_point' => $endPoints['next_end_point'],
                            )
                        );
                        break;
                    }
                }
            }

            $fullScriptData = Ad_Back_Get::execute("https://www.adback.co/api/script/me/full?access_token=" . $savedToken->access_token);
            $fullScripts = json_decode($fullScriptData, true);

            $genericScriptData = Ad_Back_Get::execute("https://www.adback.co/api/script/me/generic?access_token=" . $savedToken->access_token);
            $genericScript = json_decode($genericScriptData, true);

            $fullScripts['script_codes']['generic'] = $genericScript;
            $types = self::getTypes();
            if (is_array($fullScripts) && !empty($fullScripts) && array_key_exists('script_codes', $fullScripts)) {
                foreach ($types as $key => $type) {
                    if (array_key_exists($type, $fullScripts['script_codes'])) {
                        $wpdb->insert(
                            $table_name_full_tag,
                            array(
                                'id' => $key,
                                'blog_id' => $blogId,
                                'type' => $type,
                                'value' => $fullScripts['script_codes'][$type]['code'],
                                'update_time' => current_time('mysql', 1),
                            )
                        );
                    }
                }
            }
        }
    }

    public static function isRewriteRouteEnabled()
    {
        return (bool)get_option('permalink_structure');
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        $types = array();
        if (Integration_Checker::isFullIntegration()) {
            $types = array(
                'analytics',
                'message',
                'product',
                'banner',
                'catcher',
                'iab_banner',
            );
        }

        if (Integration_Checker::isLiteIntegration()) {
            $types = array(
                'analytics',
                'iab_banner',
                'generic',
            );
        }

        return $types;
    }
}
