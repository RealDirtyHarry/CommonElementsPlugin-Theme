<?php
/**
 * Provide a admin area view for the Learning Hub management
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
    <div class="common-elements-learning-admin">
        <div class="learning-header">
            <h2><?php _e( 'Learning Hub Management', 'common-elements-platform' ); ?></h2>
            <p><?php _e( 'Manage your learning resources and courses.', 'common-elements-platform' ); ?></p>
        </div>
        
        <div class="learning-tabs">
            <ul class="nav-tab-wrapper">
                <li><a href="#courses" class="nav-tab nav-tab-active"><?php _e( 'Courses', 'common-elements-platform' ); ?></a></li>
                <li><a href="#lessons" class="nav-tab"><?php _e( 'Lessons', 'common-elements-platform' ); ?></a></li>
                <li><a href="#students" class="nav-tab"><?php _e( 'Students', 'common-elements-platform' ); ?></a></li>
                <li><a href="#settings" class="nav-tab"><?php _e( 'Settings', 'common-elements-platform' ); ?></a></li>
            </ul>
            
            <div id="courses" class="tab-content">
                <h3><?php _e( 'Manage Courses', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'Create and manage learning courses.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Course Title', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Instructor', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Lessons', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Students', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Status', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6"><?php _e( 'No courses found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
                
                <h4><?php _e( 'Add New Course', 'common-elements-platform' ); ?></h4>
                <form method="post" action="">
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e( 'Course Title', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="text" name="course_title" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Course Slug', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="text" name="course_slug" class="regular-text">
                                <p class="description"><?php _e( 'The "slug" is the URL-friendly version of the title. It is usually all lowercase and contains only letters, numbers, and hyphens.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Instructor', 'common-elements-platform' ); ?></th>
                            <td>
                                <select name="course_instructor">
                                    <option value="0"><?php _e( 'Select Instructor', 'common-elements-platform' ); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Description', 'common-elements-platform' ); ?></th>
                            <td>
                                <textarea name="course_description" rows="5" class="large-text"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Status', 'common-elements-platform' ); ?></th>
                            <td>
                                <select name="course_status">
                                    <option value="draft"><?php _e( 'Draft', 'common-elements-platform' ); ?></option>
                                    <option value="published"><?php _e( 'Published', 'common-elements-platform' ); ?></option>
                                    <option value="private"><?php _e( 'Private', 'common-elements-platform' ); ?></option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <p class="submit">
                        <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Add New Course', 'common-elements-platform' ); ?>">
                    </p>
                </form>
            </div>
            
            <div id="lessons" class="tab-content" style="display: none;">
                <h3><?php _e( 'Manage Lessons', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'Create and manage course lessons and content.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Lesson Title', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Course', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Order', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Status', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5"><?php _e( 'No lessons found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="students" class="tab-content" style="display: none;">
                <h3><?php _e( 'Manage Students', 'common-elements-platform' ); ?></h3>
                <p><?php _e( 'View and manage student enrollments and progress.', 'common-elements-platform' ); ?></p>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e( 'Student', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Enrolled Courses', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Progress', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Last Activity', 'common-elements-platform' ); ?></th>
                            <th><?php _e( 'Actions', 'common-elements-platform' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5"><?php _e( 'No students found.', 'common-elements-platform' ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="settings" class="tab-content" style="display: none;">
                <h3><?php _e( 'Learning Hub Settings', 'common-elements-platform' ); ?></h3>
                <form method="post" action="options.php">
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e( 'Enable Learning Hub', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="checkbox" name="common_elements_platform_options[enable_learning]" value="on" checked>
                                <p class="description"><?php _e( 'Enable or disable the learning hub functionality.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Course Display Mode', 'common-elements-platform' ); ?></th>
                            <td>
                                <select name="common_elements_platform_options[learning_display_mode]">
                                    <option value="grid" selected><?php _e( 'Grid', 'common-elements-platform' ); ?></option>
                                    <option value="list"><?php _e( 'List', 'common-elements-platform' ); ?></option>
                                </select>
                                <p class="description"><?php _e( 'How to display courses on the main learning hub page.', 'common-elements-platform' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php _e( 'Courses Per Page', 'common-elements-platform' ); ?></th>
                            <td>
                                <input type="number" name="common_elements_platform_options[learning_courses_per_page]" value="12" min="1" max="100">
                                <p class="description"><?php _e( 'Number of courses to display per page.', 'common-elements-platform' ); ?></p>
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
