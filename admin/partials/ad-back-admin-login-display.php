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
<h1><?php _e( 'AdBack', 'ad-back' ); ?></h1>

<div id="ab-login">
    <div class="ab-col-md-12">
            <div class="ab-login-box">
                <center><a href="https://www.adback.co" target="_blank"><div class="ab-login-logo" style="background-image:url('<?php echo plugin_dir_url( __FILE__ ); ?>images/_dback.png');"></div></a></center>
                <center>
                    <?php if (get_option('adback_registration_error', false) == 'adback_oauth.registration.existing_user') { ?>
                        <span class="ab-registration-error">
                            <?php esc_html_e('You already have an AdBack account. Connect to your account by clicking on the "Log in" link below the button :', 'adback-solution-to-adblock'); ?>
                        </span>
                    <?php } elseif (get_option('adback_registration_error', false)) { ?>
                        <span class="ab-registration-error">
                            <?php esc_html_e('An error occured during your registration. Click on the "Create my AdBack account" button to try again.', 'adback-solution-to-adblock'); ?>
                        </span>
                        <div class="ab-registration-advantages-box">
                            <h4 class="ab-title"><?php esc_html_e('Why create an AdBack account ?', 'adback-solution-to-adblock'); ?></h4>
                            <p class="ab-registration-advantages-intro"><?php esc_html_e('AdBack is an analytics and monetization tool of your adblock audience. It is 100&#37; free and without obligation. By authorizing AdBack, you will access:', 'adback-solution-to-adblock'); ?></p>
                            <ul>
                                <li><?php esc_html_e('A unique and unblockable technology', 'adback-solution-to-adblock'); ?></li>
                                <li><?php esc_html_e('Detailed statistics directly on your WordPress and AdBack interface', 'adback-solution-to-adblock'); ?></li>
                                <li><?php esc_html_e('Unique and user-friendly monetization solutions', 'adback-solution-to-adblock'); ?></li>
                            </ul>
                        </div>
                        <div class="ab-registration-advantages-box">
                            <p class="ab-registration-advantages-intro"><?php esc_html_e('By activating the plugin:', 'adback-solution-to-adblock'); ?></p>
                            <ul>
                                <li><?php esc_html_e('You accept the AdBack Terms of Service', 'adback-solution-to-adblock'); ?></li>
                                <li><?php esc_html_e('The application will install the AdBack script, necessary to display the analytics and monetization solutions', 'adback-solution-to-adblock'); ?></li>
                            </ul>
                            <center>
                                <p><?php _e('<a href="https://landing.adback.co/en/legal-notice/">Terms of Service</a>', 'adback-solution-to-adblock'); ?> - <?php _e('<a href="https://landing.adback.co/en/privacy-policy/">Privacy Policy</a>', 'adback-solution-to-adblock'); ?></p>
                            </center>
                        </div>
                    <?php } else { ?>
                        <div class="ab-registration-advantages-box">
                            <p class="ab-registration-advantages-intro"><?php esc_html_e('AdBack is an analytics and monetization tool of your adblock audience. It is 100&#37; free and without obligation. By authorizing AdBack, you will access:', 'adback-solution-to-adblock'); ?></p>
                            <ul>
                                <li><?php esc_html_e('A unique and unblockable technology', 'adback-solution-to-adblock'); ?></li>
                                <li><?php esc_html_e('Detailed statistics directly on your WordPress and AdBack interface', 'adback-solution-to-adblock'); ?></li>
                                <li><?php esc_html_e('Unique and user-friendly monetization solutions', 'adback-solution-to-adblock'); ?></li>
                            </ul>
                        </div>
                        <div class="ab-registration-advantages-box">
                            <p class="ab-registration-advantages-intro"><?php esc_html_e('By activating the plugin:', 'adback-solution-to-adblock'); ?></p>
                            <ul>
                                <li><?php esc_html_e('You accept the AdBack Terms of Service', 'adback-solution-to-adblock'); ?></li>
                                <li><?php esc_html_e('The application will install the AdBack script, necessary to display the analytics and monetization solutions', 'adback-solution-to-adblock'); ?></li>
                            </ul>
                            <center>
                                <p><?php _e('<a href="https://landing.adback.co/en/legal-notice/">Terms of Service</a>', 'adback-solution-to-adblock'); ?> - <?php _e('<a href="https://landing.adback.co/en/privacy-policy/">Privacy Policy</a>', 'adback-solution-to-adblock'); ?></p>
                            </center>
                        </div>
                    <?php } ?>
                </center>
                <div class="ab-email-div">
                    <p class="ab-email-p"><?php esc_html_e('Email (You will receive a link to this address to create your password and informations about this plugin)', 'adback-solution-to-adblock'); ?></p>
                    <input class="ab-email-input" type="text" id="true_email" value="<?php echo get_bloginfo('admin_email') ?>" onkeypress="this.style.width = ((this.value.length) * 8) + 'px';">
                </div>
                <center>
                    <button
                            class="ab-button ab-button-primary"
                        <?php if (get_option('adback_registration_error', false) === false) { ?>
                            id="ab-register-adback"
                        <?php } else { ?>
                            id="ab-force-register-adback"
                        <?php } ?>
                            style="margin-top: 30px;"
                            data-site-url="<?php echo get_site_url(get_current_blog_id()) ?>"
                            data-locale="<?php echo (get_locale() === 'fr_FR') ? 'fr':'en'; ?>"
                    >
                        <?php if (get_option('adback_registration_error', false) === false) { ?>
                            <?php esc_html_e('Create my account in one click', 'adback-solution-to-adblock'); ?>
                        <?php } else { ?>
                            <?php esc_html_e('Create my AdBack account', 'adback-solution-to-adblock'); ?>
                        <?php } ?>
                    </button>
                </center>
                <br/>
                <center>
                    <a href="#" id="ab-login-adback" style="width:100%;margin-top: 30px;"><?php esc_html_e('Log in', 'adback-solution-to-adblock'); ?></a>
                </center>
                <br/>
                <?php if (get_option('adback_registration_error', false) !== 'adback_oauth.registration.existing_user') { ?>
                <center>
                    <a href="/wp-admin/plugins.php" class="ab-refuse-adback"><?php esc_html_e('Refuse (you won’t be able to use AdBack solutions)', 'adback-solution-to-adblock'); ?></a>
                </center>
                <?php } ?>
            </div>
    </div>
</div>
