<?php
/**
 * Dashboard functions for Common Elements theme
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register dashboard page templates
 */
function common_elements_register_dashboard_templates() {
    // Board Member Dashboard Template
    add_filter( 'theme_page_templates', function( $templates ) {
        $templates['templates/dashboard-board.php'] = __( 'Board Member Dashboard', 'common-elements' );
        return $templates;
    });

    // CAM Dashboard Template
    add_filter( 'theme_page_templates', function( $templates ) {
        $templates['templates/dashboard-cam.php'] = __( 'CAM Dashboard', 'common-elements' );
        return $templates;
    });

    // Vendor Dashboard Template
    add_filter( 'theme_page_templates', function( $templates ) {
        $templates['templates/dashboard-vendor.php'] = __( 'Vendor Dashboard', 'common-elements' );
        return $templates;
    });
}
add_action( 'init', 'common_elements_register_dashboard_templates' );

/**
 * Add dashboard widgets
 */
function common_elements_add_dashboard_widgets() {
    // Register dashboard widgets
    register_sidebar(
        array(
            'name'          => esc_html__( 'Dashboard Sidebar', 'common-elements' ),
            'id'            => 'dashboard-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in dashboard sidebar.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget dashboard-widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
    
    // Register dashboard content areas
    register_sidebar(
        array(
            'name'          => esc_html__( 'Dashboard Content Top', 'common-elements' ),
            'id'            => 'dashboard-content-top',
            'description'   => esc_html__( 'Add widgets here to appear at the top of dashboard content.', 'common-elements' ),
            'before_widget' => '<div id="%1$s" class="dashboard-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
    
    register_sidebar(
        array(
            'name'          => esc_html__( 'Dashboard Content Bottom', 'common-elements' ),
            'id'            => 'dashboard-content-bottom',
            'description'   => esc_html__( 'Add widgets here to appear at the bottom of dashboard content.', 'common-elements' ),
            'before_widget' => '<div id="%1$s" class="dashboard-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
    
    if ( class_exists( 'Common_Elements_Platform_Dashboard_Widget_Manager' ) ) {
        add_action( 'wp_enqueue_scripts', 'common_elements_enqueue_dashboard_scripts' );
    }
}
add_action( 'widgets_init', 'common_elements_add_dashboard_widgets' );

/**
 * Get user dashboard type based on role
 */
function common_elements_get_dashboard_type() {
    $user = wp_get_current_user();
    
    if ( in_array( 'board_member', (array) $user->roles, true ) ) {
        return 'board';
    } elseif ( in_array( 'cam_professional', (array) $user->roles, true ) ) {
        return 'cam';
    } elseif ( in_array( 'vendor', (array) $user->roles, true ) ) {
        return 'vendor';
    }
    
    // Default to board dashboard
    return 'board';
}

/**
 * Redirect users to appropriate dashboard after login
 */
function common_elements_login_redirect( $redirect_to, $request, $user ) {
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        // Check for board members
        if ( in_array( 'board_member', (array) $user->roles, true ) ) {
            $board_dashboard = get_page_by_path( 'dashboard-board' );
            if ( $board_dashboard ) {
                return get_permalink( $board_dashboard->ID );
            }
        }
        
        // Check for CAM professionals
        if ( in_array( 'cam_professional', (array) $user->roles, true ) ) {
            $cam_dashboard = get_page_by_path( 'dashboard-cam' );
            if ( $cam_dashboard ) {
                return get_permalink( $cam_dashboard->ID );
            }
        }
        
        // Check for vendors
        if ( in_array( 'vendor', (array) $user->roles, true ) ) {
            $vendor_dashboard = get_page_by_path( 'dashboard-vendor' );
            if ( $vendor_dashboard ) {
                return get_permalink( $vendor_dashboard->ID );
            }
        }
    }
    
    return $redirect_to;
}
add_filter( 'login_redirect', 'common_elements_login_redirect', 10, 3 );

/**
 * Register dashboard shortcodes
 */
function common_elements_register_dashboard_shortcodes() {
    // Recent activity shortcode
    add_shortcode( 'ce_recent_activity', 'common_elements_recent_activity_shortcode' );
    
    // Upcoming events shortcode
    add_shortcode( 'ce_upcoming_events', 'common_elements_upcoming_events_shortcode' );
    
    // User stats shortcode
    add_shortcode( 'ce_user_stats', 'common_elements_user_stats_shortcode' );
}
add_action( 'init', 'common_elements_register_dashboard_shortcodes' );

/**
 * Recent activity shortcode callback
 */
function common_elements_recent_activity_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'limit' => 5,
        'type'  => 'all',
    ), $atts, 'ce_recent_activity' );
    
    ob_start();
    ?>
    <div class="ce-recent-activity">
        <h3><?php esc_html_e( 'Recent Activity', 'common-elements' ); ?></h3>
        <div class="activity-list">
            <?php
            // This would be replaced with actual activity data
            for ( $i = 1; $i <= $atts['limit']; $i++ ) :
            ?>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text"><?php printf( esc_html__( 'Activity item %d', 'common-elements' ), $i ); ?></p>
                        <p class="activity-time"><?php echo esc_html( human_time_diff( time() - ( $i * 3600 ), time() ) . ' ago' ); ?></p>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Upcoming events shortcode callback
 */
function common_elements_upcoming_events_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'limit' => 3,
    ), $atts, 'ce_upcoming_events' );
    
    ob_start();
    ?>
    <div class="ce-upcoming-events">
        <h3><?php esc_html_e( 'Upcoming Events', 'common-elements' ); ?></h3>
        <div class="events-list">
            <?php
            // This would be replaced with actual events data
            for ( $i = 1; $i <= $atts['limit']; $i++ ) :
                $days_ahead = $i * 2;
                $event_date = strtotime( "+{$days_ahead} days" );
            ?>
                <div class="event-item">
                    <div class="event-date">
                        <span class="event-day"><?php echo esc_html( date( 'd', $event_date ) ); ?></span>
                        <span class="event-month"><?php echo esc_html( date( 'M', $event_date ) ); ?></span>
                    </div>
                    <div class="event-content">
                        <h4 class="event-title"><?php printf( esc_html__( 'Event %d Title', 'common-elements' ), $i ); ?></h4>
                        <p class="event-time"><?php echo esc_html( date( 'g:i A', $event_date ) ); ?></p>
                        <p class="event-location"><?php esc_html_e( 'Event Location', 'common-elements' ); ?></p>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * User stats shortcode callback
 */
function common_elements_user_stats_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'show_courses' => 'yes',
        'show_forums'  => 'yes',
        'show_rfps'    => 'yes',
    ), $atts, 'ce_user_stats' );
    
    ob_start();
    ?>
    <div class="ce-user-stats">
        <h3><?php esc_html_e( 'Your Statistics', 'common-elements' ); ?></h3>
        <div class="stats-grid">
            <?php if ( 'yes' === $atts['show_courses'] ) : ?>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-content">
                    <h4 class="stat-value">3</h4>
                    <p class="stat-label"><?php esc_html_e( 'Courses In Progress', 'common-elements' ); ?></p>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ( 'yes' === $atts['show_forums'] ) : ?>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-content">
                    <h4 class="stat-value">12</h4>
                    <p class="stat-label"><?php esc_html_e( 'Forum Posts', 'common-elements' ); ?></p>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if ( 'yes' === $atts['show_rfps'] ) : ?>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="stat-content">
                    <h4 class="stat-value">5</h4>
                    <p class="stat-label"><?php esc_html_e( 'Active RFPs', 'common-elements' ); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Enqueue dashboard scripts and styles
 */
function common_elements_enqueue_dashboard_scripts() {
    if ( is_page_template( array( 'templates/dashboard-board.php', 'templates/dashboard-cam.php', 'templates/dashboard-vendor.php' ) ) ) {
        wp_enqueue_script( 'jquery-ui-sortable' );
        
        wp_enqueue_style(
            'common-elements-dashboard',
            get_template_directory_uri() . '/assets/css/dashboard.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );
        
        wp_localize_script( 'common-elements-main', 'ceDashboard', array(
            'dashboardType' => common_elements_get_dashboard_type(),
            'userId'        => get_current_user_id(),
        ));
    }
}

/**
 * Dashboard header function
 */
function common_elements_dashboard_header() {
    $dashboard_type = common_elements_get_dashboard_type();
    $user = wp_get_current_user();
    
    ?>
    <div class="ce-dashboard-header">
        <div class="container">
            <div class="ce-dashboard-header-inner">
                <div class="ce-dashboard-welcome">
                    <h2><?php printf( esc_html__( 'Welcome, %s', 'common-elements' ), esc_html( $user->display_name ) ); ?></h2>
                    <p class="ce-dashboard-role">
                        <?php 
                        switch ( $dashboard_type ) {
                            case 'board':
                                esc_html_e( 'Board Member Dashboard', 'common-elements' );
                                break;
                            case 'cam':
                                esc_html_e( 'CAM Dashboard', 'common-elements' );
                                break;
                            case 'vendor':
                                esc_html_e( 'Vendor Dashboard', 'common-elements' );
                                break;
                            default:
                                esc_html_e( 'Dashboard', 'common-elements' );
                        }
                        ?>
                    </p>
                </div>
                
                <div class="ce-dashboard-actions">
                    <a href="#" class="ce-dashboard-add-widget-button">
                        <i class="fas fa-plus-circle"></i> <?php esc_html_e( 'Add Widget', 'common-elements' ); ?>
                    </a>
                    <div class="ce-dashboard-add-widget-dropdown">
                        <ul>
                            <li><a href="#" data-widget-type="recent_activity"><i class="fas fa-bell"></i> <?php esc_html_e( 'Recent Activity', 'common-elements' ); ?></a></li>
                            <li><a href="#" data-widget-type="upcoming_events"><i class="fas fa-calendar"></i> <?php esc_html_e( 'Upcoming Events', 'common-elements' ); ?></a></li>
                            <li><a href="#" data-widget-type="user_stats"><i class="fas fa-chart-bar"></i> <?php esc_html_e( 'User Statistics', 'common-elements' ); ?></a></li>
                            <?php if ( 'board' === $dashboard_type ) : ?>
                                <li><a href="#" data-widget-type="board_documents"><i class="fas fa-file-alt"></i> <?php esc_html_e( 'Board Documents', 'common-elements' ); ?></a></li>
                                <li><a href="#" data-widget-type="financial_summary"><i class="fas fa-dollar-sign"></i> <?php esc_html_e( 'Financial Summary', 'common-elements' ); ?></a></li>
                            <?php elseif ( 'cam' === $dashboard_type ) : ?>
                                <li><a href="#" data-widget-type="property_list"><i class="fas fa-building"></i> <?php esc_html_e( 'Property List', 'common-elements' ); ?></a></li>
                                <li><a href="#" data-widget-type="maintenance_requests"><i class="fas fa-tools"></i> <?php esc_html_e( 'Maintenance Requests', 'common-elements' ); ?></a></li>
                            <?php elseif ( 'vendor' === $dashboard_type ) : ?>
                                <li><a href="#" data-widget-type="active_contracts"><i class="fas fa-file-contract"></i> <?php esc_html_e( 'Active Contracts', 'common-elements' ); ?></a></li>
                                <li><a href="#" data-widget-type="payment_history"><i class="fas fa-money-bill-wave"></i> <?php esc_html_e( 'Payment History', 'common-elements' ); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
