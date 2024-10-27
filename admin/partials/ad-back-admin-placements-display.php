<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.adback.co
 * @since      1.0.0
 *
 * @package    Ad_Back
 * @subpackage Ad_Back/admin/partials
 */

?>
<?php include "ad-back-admin-header.php" ?>
<div id="ab-full-app" style="overflow: hidden;">
    <grid>
        <div col="5/6">
            <div id="adb-monetization-configuration"></div>
        </div>
        <div col="1/6">
            <div id="adb-sidebar-standalone"
                 data-reviewlink="https://wordpress.org/support/plugin/adback-solution-to-adblock/reviews/"
                 data-supportlink="https://wordpress.org/support/plugin/adback-solution-to-adblock"></div>
        </div>
    </grid>

</div>

<script type="text/javascript">
    window.onload = function () {
        if (typeof adbackjs === 'object') {
            adbackjs.init({
                token: '<?php echo Ad_Back_Generic::getToken()->access_token; ?>',
                url: 'https://<?php echo $this->getDomain(); ?>/api/',
                language: '<?php echo str_replace('_', '-', get_locale()); ?>',
                version: 2
            });
        }
    }
</script>
