<?php
/**
 * Provide a admin area view for the Directory management
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
    <div class="common-elements-directory-admin">
        <div class="directory-header">
            <h2><?php _e( 'Directory Management', 'common-elements-platform' ); ?></h2>
            <p><?php _e( 'Manage your directory listings and categories.', 'common-elements-platform' ); ?></p>
        </div>
        
        <div class="directory-tabs">
            <ul class="nav-tab-wrapper">
                <li><a href="#listings" class="nav-tab nav-tab-active"><?php _e( 'Listings', 'common-elements-platform' ); ?></a></li>
                <li><a href="#categories" class="nav-tab"><?php _e( 'Categories', 'common-elements-platform' ); ?></a></li>
                <li><a href="#settings" class="nav-tab"><?php _e( 'Settings', 'common-elements-platform' ); ?></a></li>
            </ul>
            
            <div id="listings" class="tab-content">
                <h3><?php _e( 'Directory Listings', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'Manage all directory listings.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Title', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Category', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Status', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Date', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5"><?php _e( 'No directory listings found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="categories" class="tab-content" style="display: none;">
                <h3><?php _e( 'Directory Categories', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'Manage directory categories and subcategories.', 'common-elements-platform' ); ?></p>
                <div class="category-manager">
                    <div class="category-list">
                        <h4><?php _e( 'Existing Categories', 'common-elements-platform' ); ?></h4>
                        <ul>
                            <li><?php _e( 'No categories found.', 'common-elements-platform' ); ?></li>
                        </ul>
                    </div>
                    <div class="category-form">
                        <h4><?php _e( 'Add New Category', 'common-elements-platform' ); ?></h4>
                        <form method="post" action="">
                            <p>
                                <label for="category-name"><?php _e( 'Name', 'common-elements-platform' ); ?></label>
                                <input type="text" id="category-name" name="category_name" class="regular-text">
                            </p>
                            <p>
                                <label for="category-slug"><?php _e( 'Slug', 'common-elements-platform' ); ?></label>
                                <input type="text" id="category-slug" name="category_slug" class="regular-text">
                            </p>
                            <p>
                                <label for="category-parent"><?php _e( 'Parent Category', 'common-elements-platform' ); ?></label>
                                <select id="category-parent" name="category_parent">
                                    <option value="0"><?php _e( 'None (Top Level)', 'common-elements-platform' ); ?></option>
                                </select>
                            </p>
                            <p>
                                <label for="category-description"><?php _e( 'Description', 'common-elements-platform' ); ?></label>
                                <textarea id="category-description" name="category_description" rows="5" class="large-text"></textarea>
                            </p>
                            <p class="submit">
                                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Add Category', 'common-elements-platform' ); ?>">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            
            <div id="settings" class="tab-content" style="display: none;">
                <h3><?php _e( 'Directory Settings', 'common-elements-platform' ); ?></h3>
                <form method="post" action="options.php">
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e( 'Enable Directory', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="checkbox" name="common_elements_platform_options[enable_directory]" value="on" checked>
                                <p class="description"><?php _e( 'Enable or disable the directory functionality.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Listings Per Page', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="number" name="common_elements_platform_options[directory_per_page]" value="10" min="1" max="100">
                                <p class="description"><?php _e( 'Number of listings to display per page.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Default Sort Order', 'common-elements-platform' ); ?></th>
                            <td>
                                <select name="common_elements_platform_options[directory_sort_order]">
                                    <option value="title_asc"><?php _e( 'Title (A-Z)', 'common-elements-platform' ); ?></option>
                                    <option value="title_desc"><?php _e( 'Title (Z-A)', 'common-elements-platform' ); ?></option>
                                    <option value="date_desc" selected><?php _e( 'Date (Newest First)', 'common-elements-platform' ); ?></option>
                                    <option value="date_asc"><?php _e( 'Date (Oldest First)', 'common-elements-platform' ); ?></option>
                                </select>
                                <p class="description"><?php _e( 'Default sort order for directory listings.', 'common-elements-platform' ); ?></p>
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
