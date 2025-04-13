<?php
/**
 * Template Name: CAM Professional Dashboard
 *
 * @package Common_Elements
 */

get_header();
?>

<div class="ce-dashboard-container cam-dashboard">
    <?php if ( function_exists( 'common_elements_dashboard_header' ) ) : ?>
        <?php common_elements_dashboard_header(); ?>
    <?php else : ?>
        <div class="ce-dashboard-header">
            <div class="container">
                <div class="ce-dashboard-header-inner">
                    <div class="ce-dashboard-welcome">
                        <h2><?php printf( esc_html__( 'Welcome, %s', 'common-elements' ), esc_html( wp_get_current_user()->display_name ) ); ?></h2>
                        <p class="ce-dashboard-role"><?php esc_html_e( 'CAM Professional Dashboard', 'common-elements' ); ?></p>
                    </div>
                    <div class="ce-dashboard-actions">
                        <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-primary"><i class="fas fa-plus-circle"></i> <?php esc_html_e( 'Create New RFP', 'common-elements' ); ?></a>
                        <a href="<?php echo esc_url(home_url('/directory/')); ?>" class="btn btn-secondary"><i class="fas fa-search"></i> <?php esc_html_e( 'Vendor Directory', 'common-elements' ); ?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="ce-dashboard-content">
        <div class="container">
            <div class="ce-dashboard-layout">
                <div class="ce-dashboard-sidebar">
                    <?php if ( is_active_sidebar( 'dashboard-sidebar' ) ) : ?>
                        <?php dynamic_sidebar( 'dashboard-sidebar' ); ?>
                    <?php else : ?>
                        <div class="ce-dashboard-widget">
                            <div class="ce-dashboard-widget-header">
                                <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Quick Links', 'common-elements' ); ?></h3>
                                <div class="ce-dashboard-widget-actions">
                                    <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                </div>
                            </div>
                            <div class="ce-dashboard-widget-content">
                                <ul class="ce-quick-links">
                                    <li><a href="<?php echo esc_url( home_url( '/rfp/' ) ); ?>"><i class="fas fa-file-contract"></i> <?php esc_html_e( 'RFP System', 'common-elements' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/directory/' ) ); ?>"><i class="fas fa-address-book"></i> <?php esc_html_e( 'Vendor Directory', 'common-elements' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/forums/' ) ); ?>"><i class="fas fa-comments"></i> <?php esc_html_e( 'Community Forums', 'common-elements' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/learning-hub/' ) ); ?>"><i class="fas fa-graduation-cap"></i> <?php esc_html_e( 'Learning Hub', 'common-elements' ); ?></a></li>
                                    <li><a href="<?php echo esc_url( home_url( '/documents/' ) ); ?>"><i class="fas fa-file-alt"></i> <?php esc_html_e( 'Documents', 'common-elements' ); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="ce-dashboard-content">
                    <?php if ( is_active_sidebar( 'dashboard-content-top' ) ) : ?>
                        <?php dynamic_sidebar( 'dashboard-content-top' ); ?>
                    <?php endif; ?>
                    
                    <div class="ce-dashboard-columns">
                        <div class="ce-dashboard-column" data-column="1">
                            <div class="ce-dashboard-widgets-container">
                                <!-- Widget: Communities Overview -->
                                <div id="ce-widget-overview" class="ce-dashboard-widget" data-widget-id="overview">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Communities Overview', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="stats-grid">
                                            <div class="stat-item">
                                                <div class="stat-icon">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h4 class="stat-value">5</h4>
                                                    <p class="stat-label"><?php esc_html_e( 'Managed Communities', 'common-elements' ); ?></p>
                                                </div>
                                            </div>
                                            <div class="stat-item">
                                                <div class="stat-icon">
                                                    <i class="fas fa-file-contract"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h4 class="stat-value">18</h4>
                                                    <p class="stat-label"><?php esc_html_e( 'Active RFPs', 'common-elements' ); ?></p>
                                                </div>
                                            </div>
                                            <div class="stat-item">
                                                <div class="stat-icon">
                                                    <i class="fas fa-clipboard-list"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h4 class="stat-value">124</h4>
                                                    <p class="stat-label"><?php esc_html_e( 'Vendor Proposals', 'common-elements' ); ?></p>
                                                </div>
                                            </div>
                                            <div class="stat-item">
                                                <div class="stat-icon">
                                                    <i class="fas fa-certificate"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <h4 class="stat-value">32</h4>
                                                    <p class="stat-label"><?php esc_html_e( 'CE Credits', 'common-elements' ); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Widget: Managed Communities -->
                                <div id="ce-widget-communities" class="ce-dashboard-widget" data-widget-id="communities">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Managed Communities', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="communities-list">
                                            <div class="community-item">
                                                <div class="community-details">
                                                    <h3 class="community-name"><a href="#"><?php esc_html_e( 'Oakwood Heights', 'common-elements' ); ?></a></h3>
                                                    <div class="community-meta">
                                                        <span class="community-units"><?php esc_html_e( '124 Units', 'common-elements' ); ?></span>
                                                        <span class="community-location"><?php esc_html_e( 'Atlanta, GA', 'common-elements' ); ?></span>
                                                    </div>
                                                </div>
                                                <div class="community-stats">
                                                    <div class="community-stat">
                                                        <span class="stat-label"><?php esc_html_e( 'RFPs', 'common-elements' ); ?></span>
                                                        <span class="stat-value">5</span>
                                                    </div>
                                                    <div class="community-stat">
                                                        <span class="stat-label"><?php esc_html_e( 'Tasks', 'common-elements' ); ?></span>
                                                        <span class="stat-value">12</span>
                                                    </div>
                                                </div>
                                                <div class="community-actions">
                                                    <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                                </div>
                                            </div>
                                            <div class="community-item">
                                                <div class="community-details">
                                                    <h3 class="community-name"><a href="#"><?php esc_html_e( 'Riverside Gardens', 'common-elements' ); ?></a></h3>
                                                    <div class="community-meta">
                                                        <span class="community-units"><?php esc_html_e( '86 Units', 'common-elements' ); ?></span>
                                                        <span class="community-location"><?php esc_html_e( 'Marietta, GA', 'common-elements' ); ?></span>
                                                    </div>
                                                </div>
                                                <div class="community-stats">
                                                    <div class="community-stat">
                                                        <span class="stat-label"><?php esc_html_e( 'RFPs', 'common-elements' ); ?></span>
                                                        <span class="stat-value">3</span>
                                                    </div>
                                                    <div class="community-stat">
                                                        <span class="stat-label"><?php esc_html_e( 'Tasks', 'common-elements' ); ?></span>
                                                        <span class="stat-value">8</span>
                                                    </div>
                                                </div>
                                                <div class="community-actions">
                                                    <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                                </div>
                                            </div>
                                            <div class="community-item">
                                                <div class="community-details">
                                                    <h3 class="community-name"><a href="#"><?php esc_html_e( 'Maple Ridge Estates', 'common-elements' ); ?></a></h3>
                                                    <div class="community-meta">
                                                        <span class="community-units"><?php esc_html_e( '210 Units', 'common-elements' ); ?></span>
                                                        <span class="community-location"><?php esc_html_e( 'Roswell, GA', 'common-elements' ); ?></span>
                                                    </div>
                                                </div>
                                                <div class="community-stats">
                                                    <div class="community-stat">
                                                        <span class="stat-label"><?php esc_html_e( 'RFPs', 'common-elements' ); ?></span>
                                                        <span class="stat-value">7</span>
                                                    </div>
                                                    <div class="community-stat">
                                                        <span class="stat-label"><?php esc_html_e( 'Tasks', 'common-elements' ); ?></span>
                                                        <span class="stat-value">15</span>
                                                    </div>
                                                </div>
                                                <div class="community-actions">
                                                    <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <a href="#" class="btn btn-text"><i class="fas fa-list"></i> <?php esc_html_e( 'View All Communities', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <div class="ce-dashboard-column" data-column="2">
                            <div class="ce-dashboard-widgets-container">
                                <!-- Widget: Recent RFPs -->
                                <div id="ce-widget-rfps" class="ce-dashboard-widget" data-widget-id="rfps">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Recent RFPs', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="rfp-list">
                                            <div class="rfp-item">
                                                <div class="rfp-status rfp-status-open"><?php esc_html_e( 'Open', 'common-elements' ); ?></div>
                                                <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Pool Maintenance Services', 'common-elements' ); ?></a></h3>
                                                <div class="rfp-meta">
                                                    <span class="rfp-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Oakwood Heights', 'common-elements' ); ?></span>
                                                    <span class="rfp-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Posted: Apr 2, 2025', 'common-elements' ); ?></span>
                                                    <span class="rfp-proposals"><i class="fas fa-clipboard-list"></i> <?php esc_html_e( '12 Proposals', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                            <div class="rfp-item">
                                                <div class="rfp-status rfp-status-open"><?php esc_html_e( 'Open', 'common-elements' ); ?></div>
                                                <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Landscaping Contract', 'common-elements' ); ?></a></h3>
                                                <div class="rfp-meta">
                                                    <span class="rfp-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Riverside Gardens', 'common-elements' ); ?></span>
                                                    <span class="rfp-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Posted: Mar 28, 2025', 'common-elements' ); ?></span>
                                                    <span class="rfp-proposals"><i class="fas fa-clipboard-list"></i> <?php esc_html_e( '8 Proposals', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                            <div class="rfp-item">
                                                <div class="rfp-status rfp-status-closed"><?php esc_html_e( 'Closed', 'common-elements' ); ?></div>
                                                <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Security System Upgrade', 'common-elements' ); ?></a></h3>
                                                <div class="rfp-meta">
                                                    <span class="rfp-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Maple Ridge Estates', 'common-elements' ); ?></span>
                                                    <span class="rfp-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Posted: Mar 15, 2025', 'common-elements' ); ?></span>
                                                    <span class="rfp-proposals"><i class="fas fa-clipboard-list"></i> <?php esc_html_e( '15 Proposals', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                            <div class="rfp-item">
                                                <div class="rfp-status rfp-status-awarded"><?php esc_html_e( 'Awarded', 'common-elements' ); ?></div>
                                                <h3 class="rfp-title"><a href="#"><?php esc_html_e( 'Clubhouse Renovation', 'common-elements' ); ?></a></h3>
                                                <div class="rfp-meta">
                                                    <span class="rfp-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Sunset Villas', 'common-elements' ); ?></span>
                                                    <span class="rfp-date"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Posted: Feb 28, 2025', 'common-elements' ); ?></span>
                                                    <span class="rfp-proposals"><i class="fas fa-clipboard-list"></i> <?php esc_html_e( '9 Proposals', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <a href="<?php echo esc_url(home_url('/rfp/')); ?>" class="btn btn-text"><i class="fas fa-list"></i> <?php esc_html_e( 'View All RFPs', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Widget: Task Management -->
                                <div id="ce-widget-tasks" class="ce-dashboard-widget" data-widget-id="tasks">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Task Management', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="task-list">
                                            <div class="task-item">
                                                <div class="task-checkbox">
                                                    <input type="checkbox" id="task1" name="task1">
                                                    <label for="task1"><i class="fas fa-check"></i></label>
                                                </div>
                                                <div class="task-details">
                                                    <h3 class="task-title"><?php esc_html_e( 'Review pool maintenance proposals', 'common-elements' ); ?></h3>
                                                    <div class="task-meta">
                                                        <span class="task-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Oakwood Heights', 'common-elements' ); ?></span>
                                                        <span class="task-due"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Due: Apr 10, 2025', 'common-elements' ); ?></span>
                                                        <span class="task-priority task-priority-high"><i class="fas fa-exclamation-circle"></i> <?php esc_html_e( 'High Priority', 'common-elements' ); ?></span>
                                                    </div>
                                                </div>
                                                <div class="task-actions">
                                                    <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                                </div>
                                            </div>
                                            <div class="task-item">
                                                <div class="task-checkbox">
                                                    <input type="checkbox" id="task2" name="task2">
                                                    <label for="task2"><i class="fas fa-check"></i></label>
                                                </div>
                                                <div class="task-details">
                                                    <h3 class="task-title"><?php esc_html_e( 'Schedule board meeting', 'common-elements' ); ?></h3>
                                                    <div class="task-meta">
                                                        <span class="task-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Riverside Gardens', 'common-elements' ); ?></span>
                                                        <span class="task-due"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Due: Apr 15, 2025', 'common-elements' ); ?></span>
                                                        <span class="task-priority task-priority-medium"><i class="fas fa-exclamation-circle"></i> <?php esc_html_e( 'Medium Priority', 'common-elements' ); ?></span>
                                                    </div>
                                                </div>
                                                <div class="task-actions">
                                                    <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                                </div>
                                            </div>
                                            <div class="task-item">
                                                <div class="task-checkbox">
                                                    <input type="checkbox" id="task3" name="task3">
                                                    <label for="task3"><i class="fas fa-check"></i></label>
                                                </div>
                                                <div class="task-details">
                                                    <h3 class="task-title"><?php esc_html_e( 'Prepare financial report', 'common-elements' ); ?></h3>
                                                    <div class="task-meta">
                                                        <span class="task-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Maple Ridge Estates', 'common-elements' ); ?></span>
                                                        <span class="task-due"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Due: Apr 20, 2025', 'common-elements' ); ?></span>
                                                        <span class="task-priority task-priority-high"><i class="fas fa-exclamation-circle"></i> <?php esc_html_e( 'High Priority', 'common-elements' ); ?></span>
                                                    </div>
                                                </div>
                                                <div class="task-actions">
                                                    <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                                </div>
                                            </div>
                                            <div class="task-item">
                                                <div class="task-checkbox">
                                                    <input type="checkbox" id="task4" name="task4">
                                                    <label for="task4"><i class="fas fa-check"></i></label>
                                                </div>
                                                <div class="task-details">
                                                    <h3 class="task-title"><?php esc_html_e( 'Inspect playground equipment', 'common-elements' ); ?></h3>
                                                    <div class="task-meta">
                                                        <span class="task-community"><i class="fas fa-building"></i> <?php esc_html_e( 'Sunset Villas', 'common-elements' ); ?></span>
                                                        <span class="task-due"><i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'Due: Apr 25, 2025', 'common-elements' ); ?></span>
                                                        <span class="task-priority task-priority-medium"><i class="fas fa-exclamation-circle"></i> <?php esc_html_e( 'Medium Priority', 'common-elements' ); ?></span>
                                                    </div>
                                                </div>
                                                <div class="task-actions">
                                                    <a href="#" class="btn btn-sm"><i class="fas fa-eye"></i> <?php esc_html_e( 'View', 'common-elements' ); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <a href="#" class="btn btn-text"><i class="fas fa-list"></i> <?php esc_html_e( 'View All Tasks', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Widget: Professional Development -->
                                <div id="ce-widget-development" class="ce-dashboard-widget" data-widget-id="development">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'Professional Development', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="learning-progress">
                                            <div class="progress-summary">
                                                <div class="progress-item">
                                                    <span class="progress-label"><i class="fas fa-certificate"></i> <?php esc_html_e( 'CE Credits Earned', 'common-elements' ); ?></span>
                                                    <span class="progress-value">32 / 40</span>
                                                    <div class="progress-bar">
                                                        <div class="progress" style="width: 80%;"></div>
                                                    </div>
                                                </div>
                                                <div class="progress-item">
                                                    <span class="progress-label"><i class="fas fa-graduation-cap"></i> <?php esc_html_e( 'Courses Completed', 'common-elements' ); ?></span>
                                                    <span class="progress-value">5 / 8</span>
                                                    <div class="progress-bar">
                                                        <div class="progress" style="width: 62.5%;"></div>
                                                    </div>
                                                </div>
                                                <div class="progress-item">
                                                    <span class="progress-label"><i class="fas fa-id-card"></i> <?php esc_html_e( 'License Renewal', 'common-elements' ); ?></span>
                                                    <span class="progress-value"><?php esc_html_e( 'Due in 120 days', 'common-elements' ); ?></span>
                                                    <div class="progress-bar">
                                                        <div class="progress" style="width: 67%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="current-courses">
                                                <h3><i class="fas fa-book"></i> <?php esc_html_e( 'Current Courses', 'common-elements' ); ?></h3>
                                                <div class="course-item">
                                                    <div class="course-image">
                                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder.jpg" alt="<?php esc_attr_e( 'Course Image', 'common-elements' ); ?>">
                                                    </div>
                                                    <div class="course-details">
                                                        <h4 class="course-title"><a href="#"><?php esc_html_e( 'Advanced Financial Management for CAMs', 'common-elements' ); ?></a></h4>
                                                        <div class="course-meta">
                                                            <span class="course-lessons"><i class="fas fa-list"></i> <?php esc_html_e( '10 Lessons', 'common-elements' ); ?></span>
                                                            <span class="course-progress"><i class="fas fa-tasks"></i> <?php esc_html_e( '60% Complete', 'common-elements' ); ?></span>
                                                            <span class="course-credits"><i class="fas fa-certificate"></i> <?php esc_html_e( '8 CE Credits', 'common-elements' ); ?></span>
                                                        </div>
                                                        <div class="progress-bar">
                                                            <div class="progress" style="width: 60%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="course-item">
                                                    <div class="course-image">
                                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/course-placeholder.jpg" alt="<?php esc_attr_e( 'Course Image', 'common-elements' ); ?>">
                                                    </div>
                                                    <div class="course-details">
                                                        <h4 class="course-title"><a href="#"><?php esc_html_e( 'Conflict Resolution in Community Management', 'common-elements' ); ?></a></h4>
                                                        <div class="course-meta">
                                                            <span class="course-lessons"><i class="fas fa-list"></i> <?php esc_html_e( '6 Lessons', 'common-elements' ); ?></span>
                                                            <span class="course-progress"><i class="fas fa-tasks"></i> <?php esc_html_e( '33% Complete', 'common-elements' ); ?></span>
                                                            <span class="course-credits"><i class="fas fa-certificate"></i> <?php esc_html_e( '4 CE Credits', 'common-elements' ); ?></span>
                                                        </div>
                                                        <div class="progress-bar">
                                                            <div class="progress" style="width: 33%;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <a href="<?php echo esc_url(home_url('/learning-hub/')); ?>" class="btn btn-text"><i class="fas fa-external-link-alt"></i> <?php esc_html_e( 'View Learning Hub', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Widget: CAM Professional Forum -->
                                <div id="ce-widget-forum" class="ce-dashboard-widget" data-widget-id="forum">
                                    <div class="ce-dashboard-widget-header">
                                        <h3 class="ce-dashboard-widget-title"><?php esc_html_e( 'CAM Professional Forum', 'common-elements' ); ?></h3>
                                        <div class="ce-dashboard-widget-actions">
                                            <button class="ce-dashboard-widget-settings"><i class="fas fa-cog"></i></button>
                                            <button class="ce-dashboard-widget-toggle"><i class="fas fa-chevron-up"></i></button>
                                            <button class="ce-dashboard-widget-remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="ce-dashboard-widget-content">
                                        <div class="forum-topics">
                                            <div class="forum-topic">
                                                <h3 class="topic-title"><a href="#"><?php esc_html_e( 'Best practices for handling delinquent accounts', 'common-elements' ); ?></a></h3>
                                                <div class="topic-meta">
                                                    <span class="topic-author"><i class="fas fa-user"></i> <?php esc_html_e( 'Started by: Jennifer Lee', 'common-elements' ); ?></span>
                                                    <span class="topic-replies"><i class="fas fa-comments"></i> <?php esc_html_e( '18 Replies', 'common-elements' ); ?></span>
                                                    <span class="topic-date"><i class="fas fa-clock"></i> <?php esc_html_e( 'Last activity: 1 day ago', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                            <div class="forum-topic">
                                                <h3 class="topic-title"><a href="#"><?php esc_html_e( 'Software recommendations for community management', 'common-elements' ); ?></a></h3>
                                                <div class="topic-meta">
                                                    <span class="topic-author"><i class="fas fa-user"></i> <?php esc_html_e( 'Started by: David Wilson', 'common-elements' ); ?></span>
                                                    <span class="topic-replies"><i class="fas fa-comments"></i> <?php esc_html_e( '24 Replies', 'common-elements' ); ?></span>
                                                    <span class="topic-date"><i class="fas fa-clock"></i> <?php esc_html_e( 'Last activity: 3 days ago', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                            <div class="forum-topic">
                                                <h3 class="topic-title"><a href="#"><?php esc_html_e( 'Handling difficult board members', 'common-elements' ); ?></a></h3>
                                                <div class="topic-meta">
                                                    <span class="topic-author"><i class="fas fa-user"></i> <?php esc_html_e( 'Started by: Sarah Johnson', 'common-elements' ); ?></span>
                                                    <span class="topic-replies"><i class="fas fa-comments"></i> <?php esc_html_e( '32 Replies', 'common-elements' ); ?></span>
                                                    <span class="topic-date"><i class="fas fa-clock"></i> <?php esc_html_e( 'Last activity: 4 days ago', 'common-elements' ); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-footer">
                                            <a href="<?php echo esc_url(home_url('/forums/cam-professional-corner/')); ?>" class="btn btn-text"><i class="fas fa-external-link-alt"></i> <?php esc_html_e( 'Visit CAM Forums', 'common-elements' ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ( is_active_sidebar( 'dashboard-content-bottom' ) ) : ?>
                        <?php dynamic_sidebar( 'dashboard-content-bottom' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
