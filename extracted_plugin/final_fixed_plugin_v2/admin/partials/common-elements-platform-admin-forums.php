<?php
/**
 * Provide a admin area view for the Forums management
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
    <div class="common-elements-forums-admin">
        <div class="forums-header">
            <h2><?php _e( 'Forums Management', 'common-elements-platform' ); ?></h2>
            <p><?php _e( 'Manage your community forums and discussions.', 'common-elements-platform' ); ?></p>
        </div>
        
        <div class="forums-tabs">
            <ul class="nav-tab-wrapper">
                <li><a href="#forums" class="nav-tab nav-tab-active"><?php _e( 'Forums', 'common-elements-platform' ); ?></a></li>
                <li><a href="#topics" class="nav-tab"><?php _e( 'Topics', 'common-elements-platform' ); ?></a></li>
                <li><a href="#moderation" class="nav-tab"><?php _e( 'Moderation', 'common-elements-platform' ); ?></a></li>
                <li><a href="#settings" class="nav-tab"><?php _e( 'Settings', 'common-elements-platform' ); ?></a></li>
            </ul>
            
            <div id="forums" class="tab-content">
                <h3><?php _e( 'Manage Forums', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'Create and manage forum categories and subcategories.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Forum Name', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Description', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Topics', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Status', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5"><?php _e( 'No forums found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
                
                <h4><?php _e( 'Add New Forum', 'common-elements-platform' ); ?></h4>
                <form method="post" action="">
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e( 'Forum Name', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="text" name="forum_name" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Forum Slug', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="text" name="forum_slug" class="regular-text">
                                <p class="description"><?php _e( 'The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Parent', 'common-elements-platform' ); ?></th>
                            <td>
                                <select name="forum_parent">
                                    <option value="0"><?php _e( 'None (Top Level Forum)', 'common-elements-platform' ); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Description', 'common-elements-platform' ); ?></th>
                            <td>
                                <textarea name="forum_description" rows="5" class="large-text"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Status', 'common-elements-platform' ); ?></th>
                            <td>
                                <select name="forum_status">
                                    <option value="open"><?php _e( 'Open', 'common-elements-platform' ); ?></option>
                                    <option value="closed"><?php _e( 'Closed', 'common-elements-platform' ); ?></option>
                                    <option value="private"><?php _e( 'Private', 'common-elements-platform' ); ?></option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <p class="submit">
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Add New Forum', 'common-elements-platform' ); ?>">
                    </p>
                </form>
            </div>
            
            <div id="topics" class="tab-content" style="display: none;">
                <h3><?php _e( 'Manage Topics', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'View and manage forum topics and replies.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Topic', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Forum', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Author', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Replies', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Last Activity', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6"><?php _e( 'No topics found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="moderation" class="tab-content" style="display: none;">
                <h3><?php _e( 'Moderation Queue', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'Review and moderate reported content and spam.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Content', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Author', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Reported By', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Reason', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Date', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6"><?php _e( 'No reported content found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="settings" class="tab-content" style="display: none;">
                <h3><?php _e( 'Forum Settings', 'common-elements-platform' ); ?></h3>
                <form method="post" action="options.php">
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e( 'Enable Forums', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="checkbox" name="common_elements_platform_options[enable_forum]" value="on" checked>
                                <p class="description"><?php _e( 'Enable or disable the forums functionality.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Topics Per Page', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="number" name="common_elements_platform_options[forum_topics_per_page]" value="20" min="1" max="100">
                                <p class="description"><?php _e( 'Number of topics to display per page.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Replies Per Page', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="number" name="common_elements_platform_options[forum_replies_per_page]" value="15" min="1" max="100">
                                <p class="description"><?php _e( 'Number of replies to display per page.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Moderation', 'common-elements-platform' ); ?></th>
                            <td>
                                <select name="common_elements_platform_options[forum_moderation]">
                                    <option value="none"><?php _e( 'No moderation', 'common-elements-platform' ); ?></option>
                                    <option value="new_users" selected><?php _e( 'Moderate new users only', 'common-elements-platform' ); ?></option>
                                    <option value="all"><?php _e( 'Moderate all posts', 'common-elements-platform' ); ?></option>
                                </select>
                                <p class="description"><?php _e( 'Set moderation level for forum posts.', 'common-elements-platform' ); ?></p>
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
