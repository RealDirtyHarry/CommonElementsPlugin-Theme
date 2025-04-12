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
