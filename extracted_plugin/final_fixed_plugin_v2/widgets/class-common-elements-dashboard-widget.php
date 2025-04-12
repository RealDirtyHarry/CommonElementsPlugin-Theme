<?php
/**
 * Dashboard Widget Class
 * 
 * This class defines the Common Elements Dashboard Widget
 * that is registered in the theme integration class.
 *
 * @package Common_Elements_Platform
 * @subpackage Widgets
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Common Elements Dashboard Widget Class
 * 
 * Implements a dashboard widget for the Common Elements Platform
 */
class Common_Elements_Dashboard_Widget extends WP_Widget {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct(
            'common_elements_dashboard_widget', // Base ID
            __( 'Common Elements Dashboard', 'common-elements-platform' ), // Name
            array( 
                'description' => __( 'Displays dashboard information for Common Elements Platform', 'common-elements-platform' ),
                'classname' => 'common-elements-dashboard-widget',
            ) // Args
        );
    }

    /**
     * Front-end display of widget
     *
     * @param array $args     Widget arguments
     * @param array $instance Saved values from database
     */
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        
        // Widget content
        echo '<div class="common-elements-dashboard-widget-content">';
        
        // Check if user is logged in
        if ( is_user_logged_in() ) {
            $this->display_dashboard_content();
        } else {
            $this->display_login_form();
        }
        
        echo '</div>';
        
        echo $args['after_widget'];
    }

    /**
     * Display dashboard content for logged-in users
     */
    private function display_dashboard_content() {
        $current_user = wp_get_current_user();
        
        echo '<div class="dashboard-welcome">';
        echo '<h4>' . sprintf( __( 'Welcome, %s!', 'common-elements-platform' ), $current_user->display_name ) . '</h4>';
        echo '</div>';
        
        echo '<div class="dashboard-links">';
        echo '<ul>';
        echo '<li><a href="' . esc_url( home_url( '/dashboard/' ) ) . '">' . __( 'My Dashboard', 'common-elements-platform' ) . '</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/rfp/' ) ) . '">' . __( 'RFP System', 'common-elements-platform' ) . '</a></li>';
        echo '<li><a href="' . esc_url( home_url( '/directory/' ) ) . '">' . __( 'Directory', 'common-elements-platform' ) . '</a></li>';
        echo '</ul>';
        echo '</div>';
    }

    /**
     * Display login form for guests
     */
    private function display_login_form() {
        echo '<p>' . __( 'Please log in to access your dashboard.', 'common-elements-platform' ) . '</p>';
        
        // Display login form
        wp_login_form( array(
            'redirect' => home_url( '/dashboard/' ),
            'form_id' => 'common-elements-login-form',
            'label_username' => __( 'Username or Email', 'common-elements-platform' ),
            'label_password' => __( 'Password', 'common-elements-platform' ),
            'label_remember' => __( 'Remember Me', 'common-elements-platform' ),
            'label_log_in' => __( 'Log In', 'common-elements-platform' ),
        ) );
    }

    /**
     * Back-end widget form
     *
     * @param array $instance Previously saved values from database
     */
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Dashboard', 'common-elements-platform' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'common-elements-platform' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved
     *
     * @param array $new_instance Values just sent to be saved
     * @param array $old_instance Previously saved values from database
     *
     * @return array Updated safe values to be saved
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        return $instance;
    }
}
