<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://commonelements.com
 * @since      1.0.0
 *
 * @package    Common_Elements_Platform
 * @subpackage Common_Elements_Platform/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Common_Elements_Platform
 * @subpackage Common_Elements_Platform/public
 * @author     Common Elements Team
 */
class Common_Elements_Platform_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        // Load Google Fonts
        wp_enqueue_style(
            'common-elements-google-fonts',
            'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap',
            array(),
            $this->version
        );

        // Load Font Awesome
        wp_enqueue_style(
            'common-elements-fontawesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
            array(),
            '5.15.4'
        );

        // Load main plugin CSS
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . '../assets/css/common-elements-platform-public.css',
            array(),
            $this->version,
            'all'
        );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/common-elements-platform-public.js',
            array( 'jquery' ),
            $this->version,
            false
        );

        // Localize the script with new data
        $script_data = array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'common_elements_platform_nonce' ),
            'site_url' => site_url(),
            'colors'   => array(
                'primary'   => '#0063CE',
                'secondary' => '#FF8A00',
            ),
        );
        wp_localize_script( $this->plugin_name, 'common_elements_platform', $script_data );

        // Add dashboard-specific scripts if on dashboard page
        if ( is_page( 'dashboard' ) ) {
            wp_enqueue_script(
                $this->plugin_name . '-dashboard',
                plugin_dir_url( __FILE__ ) . 'js/common-elements-platform-dashboard.js',
                array( 'jquery', $this->plugin_name ),
                $this->version,
                false
            );
        }

        // Add RFP-specific scripts if on RFP page
        if ( is_page( 'rfp' ) || is_singular( 'rfp' ) ) {
            wp_enqueue_script(
                $this->plugin_name . '-rfp',
                plugin_dir_url( __FILE__ ) . 'js/common-elements-platform-rfp.js',
                array( 'jquery', $this->plugin_name ),
                $this->version,
                false
            );
        }

        // Add directory-specific scripts if on directory page
        if ( is_page( 'directory' ) || is_singular( 'directory_listing' ) ) {
            wp_enqueue_script(
                $this->plugin_name . '-directory',
                plugin_dir_url( __FILE__ ) . 'js/common-elements-platform-directory.js',
                array( 'jquery', $this->plugin_name ),
                $this->version,
                false
            );
        }

        // Add forum-specific scripts if on forum page
        if ( is_page( 'forum' ) || is_singular( 'forum_topic' ) ) {
            wp_enqueue_script(
                $this->plugin_name . '-forum',
                plugin_dir_url( __FILE__ ) . 'js/common-elements-platform-forum.js',
                array( 'jquery', $this->plugin_name ),
                $this->version,
                false
            );
        }

        // Add learning hub scripts if on course pages
        if ( is_singular( 'mpcs-course' ) || is_singular( 'mpcs-lesson' ) || is_singular( 'mpcs-quiz' ) ) {
            wp_enqueue_script(
                $this->plugin_name . '-learning',
                plugin_dir_url( __FILE__ ) . 'js/common-elements-platform-learning.js',
                array( 'jquery', $this->plugin_name ),
                $this->version,
                false
            );
        }
    }

    /**
     * Add custom body classes based on page type
     *
     * @since    1.0.0
     * @param    array    $classes    The body classes.
     * @return   array                The modified body classes.
     */
    public function add_body_classes( $classes ) {
        // Add dashboard-specific class
        if ( is_page( 'dashboard' ) ) {
            $classes[] = 'ce-dashboard-page';
            
            // Add user role-specific class
            $user = wp_get_current_user();
            $roles = (array) $user->roles;
            
            if ( in_array( 'administrator', $roles ) || in_array( 'editor', $roles ) ) {
                $classes[] = 'ce-dashboard-board';
            } elseif ( in_array( 'author', $roles ) ) {
                $classes[] = 'ce-dashboard-cam';
            } elseif ( in_array( 'contributor', $roles ) ) {
                $classes[] = 'ce-dashboard-vendor';
            } else {
                $classes[] = 'ce-dashboard-member';
            }
        }
        
        // Add RFP-specific class
        if ( is_page( 'rfp' ) || is_singular( 'rfp' ) ) {
            $classes[] = 'ce-rfp-page';
        }
        
        // Add directory-specific class
        if ( is_page( 'directory' ) || is_singular( 'directory_listing' ) ) {
            $classes[] = 'ce-directory-page';
        }
        
        // Add forum-specific class
        if ( is_page( 'forum' ) || is_singular( 'forum_topic' ) ) {
            $classes[] = 'ce-forum-page';
        }
        
        // Add learning hub classes
        if ( is_singular( 'mpcs-course' ) ) {
            $classes[] = 'ce-course-page';
        } elseif ( is_singular( 'mpcs-lesson' ) ) {
            $classes[] = 'ce-lesson-page';
        } elseif ( is_singular( 'mpcs-quiz' ) ) {
            $classes[] = 'ce-quiz-page';
        }
        
        return $classes;
    }

    /**
     * Register shortcodes for the plugin
     *
     * @since    1.0.0
     */
    public function register_shortcodes() {
        // Dashboard shortcode
        add_shortcode( 'ce_dashboard', array( $this, 'dashboard_shortcode' ) );
        
        // RFP shortcodes
        add_shortcode( 'ce_rfp_list', array( $this, 'rfp_list_shortcode' ) );
        add_shortcode( 'ce_rfp_form', array( $this, 'rfp_form_shortcode' ) );
        
        // Directory shortcodes
        add_shortcode( 'ce_directory_list', array( $this, 'directory_list_shortcode' ) );
        add_shortcode( 'ce_directory_search', array( $this, 'directory_search_shortcode' ) );
        
        // Forum shortcodes
        add_shortcode( 'ce_forum_list', array( $this, 'forum_list_shortcode' ) );
        add_shortcode( 'ce_forum_topics', array( $this, 'forum_topics_shortcode' ) );
        
        // Learning hub shortcodes
        add_shortcode( 'ce_courses', array( $this, 'courses_shortcode' ) );
        add_shortcode( 'ce_my_courses', array( $this, 'my_courses_shortcode' ) );
    }

    /**
     * Dashboard shortcode callback
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            Shortcode output.
     */
    public function dashboard_shortcode( $atts ) {
        // Parse attributes
        $atts = shortcode_atts( array(
            'type' => 'auto', // auto, board, cam, vendor, member
        ), $atts, 'ce_dashboard' );
        
        // Check if user is logged in
        if ( ! is_user_logged_in() ) {
            return '<div class="ce-alert ce-alert-warning">Please log in to view your dashboard.</div>';
        }
        
        // Determine dashboard type
        $dashboard_type = $atts['type'];
        
        if ( $dashboard_type === 'auto' ) {
            $user = wp_get_current_user();
            $roles = (array) $user->roles;
            
            if ( in_array( 'administrator', $roles ) || in_array( 'editor', $roles ) ) {
                $dashboard_type = 'board';
            } elseif ( in_array( 'author', $roles ) ) {
                $dashboard_type = 'cam';
            } elseif ( in_array( 'contributor', $roles ) ) {
                $dashboard_type = 'vendor';
            } else {
                $dashboard_type = 'member';
            }
        }
        
        // Load the appropriate dashboard template
        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/dashboard/dashboard-' . $dashboard_type . '.php';
        return ob_get_clean();
    }

    /**
     * RFP list shortcode callback
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            Shortcode output.
     */
    public function rfp_list_shortcode( $atts ) {
        // Parse attributes
        $atts = shortcode_atts( array(
            'limit' => 10,
            'status' => 'open', // open, closed, all
            'category' => '',
        ), $atts, 'ce_rfp_list' );
        
        // Build query args
        $args = array(
            'post_type' => 'rfp',
            'posts_per_page' => intval( $atts['limit'] ),
            'orderby' => 'date',
            'order' => 'DESC',
        );
        
        // Filter by status
        if ( $atts['status'] !== 'all' ) {
            $args['meta_query'] = array(
                array(
                    'key' => 'rfp_status',
                    'value' => $atts['status'],
                    'compare' => '=',
                ),
            );
        }
        
        // Filter by category
        if ( ! empty( $atts['category'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'rfp_category',
                    'field' => 'slug',
                    'terms' => explode( ',', $atts['category'] ),
                ),
            );
        }
        
        // Get RFPs
        $query = new WP_Query( $args );
        
        // Output
        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/rfp/rfp-list.php';
        return ob_get_clean();
    }

    /**
     * RFP form shortcode callback
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            Shortcode output.
     */
    public function rfp_form_shortcode( $atts ) {
        // Parse attributes
        $atts = shortcode_atts( array(
            'type' => 'submit', // submit, proposal
            'rfp_id' => 0,
        ), $atts, 'ce_rfp_form' );
        
        // Check if user is logged in
        if ( ! is_user_logged_in() ) {
            return '<div class="ce-alert ce-alert-warning">Please log in to submit an RFP or proposal.</div>';
        }
        
        // Load the appropriate form template
        ob_start();
        if ( $atts['type'] === 'submit' ) {
            include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/rfp/rfp-form.php';
        } else {
            $rfp_id = intval( $atts['rfp_id'] );
            if ( $rfp_id > 0 ) {
                include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/rfp/proposal-form.php';
            } else {
                echo '<div class="ce-alert ce-alert-danger">Invalid RFP ID specified.</div>';
            }
        }
        return ob_get_clean();
    }

    /**
     * Directory list shortcode callback
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            Shortcode output.
     */
    public function directory_list_shortcode( $atts ) {
        // Parse attributes
        $atts = shortcode_atts( array(
            'limit' => 12,
            'category' => '',
            'featured' => 'false',
            'columns' => 3,
        ), $atts, 'ce_directory_list' );
        
        // Build query args
        $args = array(
            'post_type' => 'directory_listing',
            'posts_per_page' => intval( $atts['limit'] ),
            'orderby' => 'title',
            'order' => 'ASC',
        );
        
        // Filter by category
        if ( ! empty( $atts['category'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'directory_category',
                    'field' => 'slug',
                    'terms' => explode( ',', $atts['category'] ),
                ),
            );
        }
        
        // Filter by featured
        if ( $atts['featured'] === 'true' ) {
            $args['meta_query'] = array(
                array(
                    'key' => '_directory_featured',
                    'value' => '1',
                    'compare' => '=',
                ),
            );
        }
        
        // Get listings
        $query = new WP_Query( $args );
        
        // Output
        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/directory/directory-list.php';
        return ob_get_clean();
    }

    /**
     * Directory search shortcode callback
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            Shortcode output.
     */
    public function directory_search_shortcode( $atts ) {
        // Parse attributes
        $atts = shortcode_atts( array(
            'show_categories' => 'true',
            'show_locations' => 'true',
        ), $atts, 'ce_directory_search' );
        
        // Output
        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/directory/directory-search.php';
        return ob_get_clean();
    }

    /**
     * Forum list shortcode callback
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            Shortcode output.
     */
    public function forum_list_shortcode( $atts ) {
        // Parse attributes
        $atts = shortcode_atts( array(
            'category' => '',
        ), $atts, 'ce_forum_list' );
        
        // Build query args
        $args = array(
            'post_type' => 'forum_board',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        );
        
        // Filter by category
        if ( ! empty( $atts['category'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'forum_category',
                    'field' => 'slug',
                    'terms' => explode( ',', $atts['category'] ),
                ),
            );
        }
        
        // Get boards
        $query = new WP_Query( $args );
        
        // Output
        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/forum/forum-list.php';
        return ob_get_clean();
    }

    /**
     * Forum topics shortcode callback
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            Shortcode output.
     */
    public function forum_topics_shortcode( $atts ) {
        // Parse attributes
        $atts = shortcode_atts( array(
            'board_id' => 0,
            'limit' => 10,
        ), $atts, 'ce_forum_topics' );
        
        // Build query args
        $args = array(
            'post_type' => 'forum_topic',
            'posts_per_page' => intval( $atts['limit'] ),
            'orderby' => 'date',
            'order' => 'DESC',
        );
        
        // Filter by board
        if ( intval( $atts['board_id'] ) > 0 ) {
            $args['meta_query'] = array(
                array(
                    'key' => '_forum_board_id',
                    'value' => intval( $atts['board_id'] ),
                    'compare' => '=',
                ),
            );
        }
        
        // Get topics
        $query = new WP_Query( $args );
        
        // Output
        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/forum/forum-topics.php';
        return ob_get_clean();
    }

    /**
     * Courses shortcode callback
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            Shortcode output.
     */
    public function courses_shortcode( $atts ) {
        // Parse attributes
        $atts = shortcode_atts( array(
            'limit' => 12,
            'category' => '',
            'columns' => 3,
        ), $atts, 'ce_courses' );
        
        // Check if MemberPress Courses is active
        if ( ! class_exists( 'MeprCourse' ) ) {
            return '<div class="ce-alert ce-alert-warning">MemberPress Courses is required for this shortcode.</div>';
        }
        
        // Build query args
        $args = array(
            'post_type' => 'mpcs-course',
            'posts_per_page' => intval( $atts['limit'] ),
            'orderby' => 'title',
            'order' => 'ASC',
        );
        
        // Filter by category
        if ( ! empty( $atts['category'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'mpcs-course-category',
                    'field' => 'slug',
                    'terms' => explode( ',', $atts['category'] ),
                ),
            );
        }
        
        // Get courses
        $query = new WP_Query( $args );
        
        // Output
        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/learning/course-list.php';
        return ob_get_clean();
    }

    /**
     * My courses shortcode callback
     *
     * @since    1.0.0
     * @param    array    $atts    Shortcode attributes.
     * @return   string            Shortcode output.
     */
    public function my_courses_shortcode( $atts ) {
        // Parse attributes
        $atts = shortcode_atts( array(
            'limit' => 12,
            'status' => 'all', // all, in-progress, completed
            'columns' => 3,
        ), $atts, 'ce_my_courses' );
        
        // Check if MemberPress Courses is active
        if ( ! class_exists( 'MeprCourse' ) ) {
            return '<div class="ce-alert ce-alert-warning">MemberPress Courses is required for this shortcode.</div>';
        }
        
        // Check if user is logged in
        if ( ! is_user_logged_in() ) {
            return '<div class="ce-alert ce-alert-warning">Please log in to view your courses.</div>';
        }
        
        // Get current user
        $current_user = MeprUtils::get_currentuserinfo();
        
        // Get user's courses
        $args = array(
            'post_type' => 'mpcs-course',
            'posts_per_page' => intval( $atts['limit'] ),
            'orderby' => 'title',
            'order' => 'ASC',
        );
        
        // Filter by user access
        $mepr_user = new MeprUser( $current_user->ID );
        $accessible_courses = array();
        
        $all_courses = get_posts( array(
            'post_type' => 'mpcs-course',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ) );
        
        foreach ( $all_courses as $course ) {
            if ( $mepr_user->can_access( $course->ID ) ) {
                $accessible_courses[] = $course->ID;
            }
        }
        
        if ( empty( $accessible_courses ) ) {
            return '<div class="ce-alert ce-alert-info">You do not have access to any courses.</div>';
        }
        
        $args['post__in'] = $accessible_courses;
        
        // Filter by course status if specified
        if ( $atts['status'] === 'in-progress' ) {
            $in_progress_courses = array();
            foreach ( $accessible_courses as $course_id ) {
                $course = new MeprCourse( $course_id );
                $progress = $course->get_user_progress( $current_user->ID );
                if ( $progress > 0 && $progress < 100 ) {
                    $in_progress_courses[] = $course_id;
                }
            }
            
            if ( empty( $in_progress_courses ) ) {
                return '<div class="ce-alert ce-alert-info">You do not have any courses in progress.</div>';
            }
            
            $args['post__in'] = $in_progress_courses;
        } elseif ( $atts['status'] === 'completed' ) {
            $completed_courses = array();
            foreach ( $accessible_courses as $course_id ) {
                $course = new MeprCourse( $course_id );
                $progress = $course->get_user_progress( $current_user->ID );
                if ( $progress >= 100 ) {
                    $completed_courses[] = $course_id;
                }
            }
            
            if ( empty( $completed_courses ) ) {
                return '<div class="ce-alert ce-alert-info">You have not completed any courses yet.</div>';
            }
            
            $args['post__in'] = $completed_courses;
        }
        
        // Get courses
        $query = new WP_Query( $args );
        
        // Output
        ob_start();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/learning/my-courses.php';
        return ob_get_clean();
    }
}
