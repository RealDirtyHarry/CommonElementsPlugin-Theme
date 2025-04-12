<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
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
                <p><?php _e( 'Welcome to the Common Elements Platform. This dashboard provides an overview of your platform activity.', 'common-elements-platform' ); ?></p>
            </div>
            
            <div class="common-elements-dashboard-widgets">
                <div class="common-elements-dashboard-widget">
                    <div class="common-elements-dashboard-widget-header">
                        <h3><?php _e( 'RFP System', 'common-elements-platform' ); ?></h3>
                    </div>
                    <div class="common-elements-dashboard-widget-content">
                        <p><?php _e( 'Manage your Request for Proposals and submissions.', 'common-elements-platform' ); ?></p>
                        <a href="<?php echo admin_url( 'edit.php?post_type=rfp' ); ?>" class="common-elements-admin-button"><?php _e( 'Manage RFPs', 'common-elements-platform' ); ?></a>
                    </div>
                </div>
                
                <div class="common-elements-dashboard-widget">
                    <div class="common-elements-dashboard-widget-header">
                        <h3><?php _e( 'Directory', 'common-elements-platform' ); ?></h3>
                    </div>
                    <div class="common-elements-dashboard-widget-content">
                        <p><?php _e( 'Manage your directory listings and categories.', 'common-elements-platform' ); ?></p>
                        <a href="<?php echo admin_url( 'edit.php?post_type=directory_listing' ); ?>" class="common-elements-admin-button"><?php _e( 'Manage Directory', 'common-elements-platform' ); ?></a>
                    </div>
                </div>
                
                <div class="common-elements-dashboard-widget">
                    <div class="common-elements-dashboard-widget-header">
                        <h3><?php _e( 'Forums', 'common-elements-platform' ); ?></h3>
                    </div>
                    <div class="common-elements-dashboard-widget-content">
                        <p><?php _e( 'Manage your community forums and discussions.', 'common-elements-platform' ); ?></p>
                        <a href="<?php echo admin_url( 'admin.php?page=common-elements-platform-forums' ); ?>" class="common-elements-admin-button"><?php _e( 'Manage Forums', 'common-elements-platform' ); ?></a>
                    </div>
                </div>
                
                <div class="common-elements-dashboard-widget">
                    <div class="common-elements-dashboard-widget-header">
                        <h3><?php _e( 'Learning Hub', 'common-elements-platform' ); ?></h3>
                    </div>
                    <div class="common-elements-dashboard-widget-content">
                        <p><?php _e( 'Manage your learning resources and courses.', 'common-elements-platform' ); ?></p>
                        <a href="<?php echo admin_url( 'admin.php?page=common-elements-platform-learning' ); ?>" class="common-elements-admin-button"><?php _e( 'Manage Learning Hub', 'common-elements-platform' ); ?></a>
                    </div>
                </div>
            </div>
            
            <div class="common-elements-admin-card">
                <div class="common-elements-admin-card-header">
                    <h2><?php _e( 'Recent Activity', 'common-elements-platform' ); ?></h2>
                </div>
                <div class="common-elements-admin-card-content">
                    <table class="common-elements-admin-table">
                        <thead>
                            <tr>
                                <th><?php _e( 'Type', 'common-elements-platform' ); ?></th>
                                <th><?php _e( 'Title', 'common-elements-platform' ); ?></th>
                                <th><?php _e( 'Date', 'common-elements-platform' ); ?></th>
                                <th><?php _e( 'Status', 'common-elements-platform' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Get recent posts from all custom post types
                            $recent_posts = get_posts(array(
                                'post_type' => array('rfp', 'proposal', 'directory_listing'),
                                'posts_per_page' => 5,
                                'orderby' => 'date',
                                'order' => 'DESC'
                            ));
                            
                            if ($recent_posts) {
                                foreach ($recent_posts as $post) {
                                    $post_type_obj = get_post_type_object($post->post_type);
                                    ?>
                                    <tr>
                                        <td><?php echo esc_html($post_type_obj->labels->singular_name); ?></td>
                                        <td><a href="<?php echo get_edit_post_link($post->ID); ?>"><?php echo esc_html($post->post_title); ?></a></td>
                                        <td><?php echo get_the_date('M j, Y', $post->ID); ?></td>
                                        <td><?php echo esc_html(get_post_status_object($post->post_status)->label); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4"><?php _e('No recent activity found.', 'common-elements-platform'); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
