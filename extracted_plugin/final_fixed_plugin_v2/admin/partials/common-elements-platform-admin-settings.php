<?php
/**
 * Provide a admin area view for the plugin settings
 *
 * @link       https://commonelements.com
 * @since      1.0.0
 *
 * @package    Common_Elements_Platform
 * @subpackage Common_Elements_Platform/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <div class="common-elements-admin-page">
        <div class="common-elements-admin-header">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        </div>
        
        <div class="common-elements-admin-content">
            <div class="common-elements-admin-notice info">
                <p><?php _e( 'Configure global settings for the Common Elements Platform.', 'common-elements-platform' ); ?></p>
            </div>
            
            <div class="common-elements-admin-tabs">
                <a href="#general" class="nav-tab nav-tab-active"><?php _e( 'General', 'common-elements-platform' ); ?></a>
                <a href="#modules" class="nav-tab"><?php _e( 'Modules', 'common-elements-platform' ); ?></a>
                <a href="#integrations" class="nav-tab"><?php _e( 'Integrations', 'common-elements-platform' ); ?></a>
            </div>
            
            <form method="post" action="options.php" class="common-elements-admin-form">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'common_elements_platform_options' );
                do_settings_sections( 'common_elements_platform_settings' );
                ?>
                
                <div id="general" class="common-elements-admin-card">
                    <div class="common-elements-admin-card-header">
                        <h2><?php _e( 'General Settings', 'common-elements-platform' ); ?></h2>
                    </div>
                    <div class="common-elements-admin-card-content">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e( 'Platform Name', 'common-elements-platform' ); ?></th>
                                <td>
                                    <input type="text" name="common_elements_platform_options[platform_name]" value="Common Elements">
                                    <p class="description"><?php _e( 'The name of your platform as displayed to users.', 'common-elements-platform' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e( 'Platform Logo', 'common-elements-platform' ); ?></th>
                                <td>
                                    <input type="text" name="common_elements_platform_options[platform_logo]" value="">
                                    <button class="common-elements-admin-button secondary"><?php _e( 'Select Image', 'common-elements-platform' ); ?></button>
                                    <p class="description"><?php _e( 'URL to your platform logo image.', 'common-elements-platform' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e( 'Admin Email', 'common-elements-platform' ); ?></th>
                                <td>
                                    <input type="email" name="common_elements_platform_options[admin_email]" value="<?php echo get_option( 'admin_email' ); ?>">
                                    <p class="description"><?php _e( 'Email address for platform notifications and alerts.', 'common-elements-platform' ); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div id="modules" class="common-elements-admin-card">
                    <div class="common-elements-admin-card-header">
                        <h2><?php _e( 'Module Settings', 'common-elements-platform' ); ?></h2>
                    </div>
                    <div class="common-elements-admin-card-content">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e( 'Enabled Modules', 'common-elements-platform' ); ?></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span><?php _e( 'Enabled Modules', 'common-elements-platform' ); ?></span></legend>
                                        <label for="enable_dashboard">
                                            <input type="checkbox" id="enable_dashboard" name="common_elements_platform_options[enable_dashboard]" value="on" checked>
                                            <?php _e( 'Dashboard', 'common-elements-platform' ); ?>
                                        </label><br>
                                        <label for="enable_rfp">
                                            <input type="checkbox" id="enable_rfp" name="common_elements_platform_options[enable_rfp]" value="on" checked>
                                            <?php _e( 'RFP System', 'common-elements-platform' ); ?>
                                        </label><br>
                                        <label for="enable_directory">
                                            <input type="checkbox" id="enable_directory" name="common_elements_platform_options[enable_directory]" value="on" checked>
                                            <?php _e( 'Directory', 'common-elements-platform' ); ?>
                                        </label><br>
                                        <label for="enable_forum">
                                            <input type="checkbox" id="enable_forum" name="common_elements_platform_options[enable_forum]" value="on" checked>
                                            <?php _e( 'Forums', 'common-elements-platform' ); ?>
                                        </label><br>
                                        <label for="enable_learning">
                                            <input type="checkbox" id="enable_learning" name="common_elements_platform_options[enable_learning]" value="on" checked>
                                            <?php _e( 'Learning Hub', 'common-elements-platform' ); ?>
                                        </label>
                                    </fieldset>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div id="integrations" class="common-elements-admin-card">
                    <div class="common-elements-admin-card-header">
                        <h2><?php _e( 'Integration Settings', 'common-elements-platform' ); ?></h2>
                    </div>
                    <div class="common-elements-admin-card-content">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php _e( 'Google Analytics ID', 'common-elements-platform' ); ?></th>
                                <td>
                                    <input type="text" name="common_elements_platform_options[ga_id]" value="">
                                    <p class="description"><?php _e( 'Your Google Analytics tracking ID (e.g., UA-XXXXX-Y).', 'common-elements-platform' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e( 'Mailchimp API Key', 'common-elements-platform' ); ?></th>
                                <td>
                                    <input type="text" name="common_elements_platform_options[mailchimp_api]" value="">
                                    <p class="description"><?php _e( 'Your Mailchimp API key for newsletter integration.', 'common-elements-platform' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e( 'reCAPTCHA Site Key', 'common-elements-platform' ); ?></th>
                                <td>
                                    <input type="text" name="common_elements_platform_options[recaptcha_site_key]" value="">
                                    <p class="description"><?php _e( 'Google reCAPTCHA site key for form protection.', 'common-elements-platform' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php _e( 'reCAPTCHA Secret Key', 'common-elements-platform' ); ?></th>
                                <td>
                                    <input type="text" name="common_elements_platform_options[recaptcha_secret_key]" value="">
                                    <p class="description"><?php _e( 'Google reCAPTCHA secret key for form protection.', 'common-elements-platform' ); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="common-elements-admin-button" value="<?php _e( 'Save Changes', 'common-elements-platform' ); ?>">
                </p>
            </form>
            
            <script>
            jQuery(document).ready(function($) {
                // Tab functionality
                $('.common-elements-admin-tabs a').on('click', function(e) {
                    e.preventDefault();
                    
                    // Hide all sections
                    $('#general, #modules, #integrations').hide();
                    
                    // Show the selected section
                    $($(this).attr('href')).show();
                    
                    // Update active tab
                    $('.common-elements-admin-tabs a').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active');
                });
                
                // Show the first tab by default
                $('#general').show();
                $('#modules, #integrations').hide();
            });
            </script>
        </div>
    </div>
</div>
