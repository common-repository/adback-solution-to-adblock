<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ad_Back
 * @subpackage Ad_Back/includes
 * @author     AdBack <contact@adback.co>
 */
class Ad_Back_Activator
{
    const DB_VERSION = 1;

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate($networkwide)
    {
        global $wpdb;

        add_option( 'adback_solution_to_adblock_db_version', self::DB_VERSION);

        if (is_multisite() && $networkwide) {
            $sites = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

            foreach ($sites as $blogId) {
                switch_to_blog($blogId);
                self::initializeBlog();
                restore_current_blog();
            }
        } else {
            self::initializeBlog();
        }
    }

    public static function initializeBlog()
    {
        global $wpdb;

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        $charset_collate = $wpdb->get_charset_collate();

        $blogId = get_current_blog_id();

        //create tables
        $table_name_account = $wpdb->prefix . 'adback_account';
        $table_name_token = $wpdb->prefix . 'adback_token';
        $table_name_info = $wpdb->prefix . 'adback_myinfo';

        $sql = '';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_account'") != $table_name_account) {
            $sql = "CREATE TABLE " . $table_name_account . " (
                `id` mediumint(9) NOT NULL,
                `username` varchar(100) DEFAULT '' NOT NULL,
                `key` varchar(100) DEFAULT '' NOT NULL,
                `secret` varchar(100) DEFAULT '' NOT NULL,
                UNIQUE KEY id (id)
            ) " . $charset_collate . ";";
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name_token'") != $table_name_token) {
            $sql .= "CREATE TABLE " . $table_name_token . " (
                `id` mediumint(9) NOT NULL,
                `access_token` varchar(64) DEFAULT '' NOT NULL,
                `refresh_token` varchar(64) DEFAULT '' NOT NULL,
                UNIQUE KEY id (id)
            ) " . $charset_collate . ";";
        }

        if($wpdb->get_var("SHOW TABLES LIKE '$table_name_info'") != $table_name_info) {
            $sql .= "CREATE TABLE ".$table_name_info." (
                `id` mediumint(9) NOT NULL,
                `myinfo` text DEFAULT '' NOT NULL,
                `domain` text DEFAULT '' NOT NULL,
                `update_time` DATETIME NULL,
                UNIQUE KEY id (id)
            ) ".$charset_collate.";";
        }

        if ('' !== $sql) {
            dbDelta( $sql );
        }

        $sql = <<<SQL
INSERT INTO $table_name_info
  (id,myinfo,domain,update_time) VALUES (%d,%s,%s,%s)
  ON DUPLICATE KEY UPDATE myinfo = %s, domain = %s, update_time = %s;
SQL;
        $sql = $wpdb->prepare(
            $sql,
            $blogId,
            "",
            "",
            "",
            "",
            "",
            ""
        );
        $wpdb->query($sql);

        $sql = <<<SQL
INSERT INTO $table_name_token
  (id,access_token,refresh_token) values (%d,%s,%s)
  ON DUPLICATE KEY UPDATE access_token = %s, refresh_token = %s;
SQL;
        $sql = $wpdb->prepare(
            $sql,
            $blogId,
            '',
            '',
            '',
            ''
        );
        $wpdb->query($sql);
    }
}
