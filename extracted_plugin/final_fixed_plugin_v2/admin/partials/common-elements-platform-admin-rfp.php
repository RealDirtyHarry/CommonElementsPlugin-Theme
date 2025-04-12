<?php
/**
 * Provide a admin area view for the RFP system
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
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <div class="common-elements-rfp-admin">
        <div class="rfp-header">
            <h2><?php _e( 'RFP System Management', 'common-elements-platform' ); ?></h2>
            <p><?php _e( 'Manage your Request for Proposals and submissions.', 'common-elements-platform' ); ?></p>
        </div>
        
        <div class="rfp-tabs">
            <ul class="nav-tab-wrapper">
                <li><a href="#active-rfps" class="nav-tab nav-tab-active"><?php _e( 'Active RFPs', 'common-elements-platform' ); ?></a></li>
                <li><a href="#pending-rfps" class="nav-tab"><?php _e( 'Pending RFPs', 'common-elements-platform' ); ?></a></li>
                <li><a href="#closed-rfps" class="nav-tab"><?php _e( 'Closed RFPs', 'common-elements-platform' ); ?></a></li>
                <li><a href="#settings" class="nav-tab"><?php _e( 'Settings', 'common-elements-platform' ); ?></a></li>
            </ul>
            
            <div id="active-rfps" class="tab-content">
                <h3><?php _e( 'Active RFPs', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'These RFPs are currently active and accepting proposals.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Title', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Posted Date', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Closing Date', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Proposals', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5"><?php _e( 'No active RFPs found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="pending-rfps" class="tab-content" style="display: none;">
                <h3><?php _e( 'Pending RFPs', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'These RFPs are awaiting approval before being published.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Title', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Submitted Date', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Submitted By', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4"><?php _e( 'No pending RFPs found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="closed-rfps" class="tab-content" style="display: none;">
                <h3><?php _e( 'Closed RFPs', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'These RFPs have passed their closing date and are no longer accepting proposals.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Title', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Posted Date', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Closed Date', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Proposals', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5"><?php _e( 'No closed RFPs found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="settings" class="tab-content" style="display: none;">
                <h3><?php _e( 'RFP System Settings', 'common-elements-platform' ); ?></h3>
                <form method="post" action="options.php">
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e( 'Enable RFP System', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="checkbox" name="common_elements_platform_options[enable_rfp]" value="on" checked>
                                <p class="description"><?php _e( 'Enable or disable the RFP system functionality.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Require Approval', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="checkbox" name="common_elements_platform_options[rfp_require_approval]" value="on" checked>
                                <p class="description"><?php _e( 'Require admin approval before RFPs are published.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Notification Email', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="email" name="common_elements_platform_options[rfp_notification_email]" value="<?php echo get_option( 'admin_email' ); ?>" class="regular-text">
                                <p class="description"><?php _e( 'Email address to receive notifications about new RFPs and proposals.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                    </table>
                    <p class="submit">
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'common-elements-platform' ); ?>">
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
