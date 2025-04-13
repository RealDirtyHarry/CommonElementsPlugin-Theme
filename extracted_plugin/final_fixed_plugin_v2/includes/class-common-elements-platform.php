<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package Common_Elements_Platform
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */
class Common_Elements_Platform {

        /**
         * The loader that's responsible for maintaining and registering all hooks that power
         * the plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      Common_Elements_Platform_Loader    $loader    Maintains and registers all hooks for the plugin.
         */
        protected $loader;

        /**
         * The unique identifier of this plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      string    $plugin_name    The string used to uniquely identify this plugin.
         */
        protected $plugin_name;

        /**
         * The current version of the plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @var      string    $version    The current version of the plugin.
         */
        protected $version;

        /**
         * Define the core functionality of the plugin.
         *
         * Set the plugin name and the plugin version that can be used throughout the plugin.
         * Load the dependencies, define the locale, and set the hooks for the admin area and
         * the public-facing side of the site.
         *
         * @since    1.0.0
         */
        public function __construct() {
                if ( defined( 'COMMON_ELEMENTS_PLATFORM_VERSION' ) ) {
                        $this->version = COMMON_ELEMENTS_PLATFORM_VERSION;
                } else {
                        $this->version = '1.0.0';
                }
                $this->plugin_name = 'common-elements-platform';

                $this->load_dependencies();
                $this->set_locale();
                $this->define_admin_hooks();
                $this->define_public_hooks();
                $this->define_post_types();
                $this->define_dashboard_hooks();
                $this->define_rfp_hooks();
                $this->define_directory_hooks();
                $this->define_forum_hooks();
                $this->define_membership_hooks();
                $this->define_theme_integration_hooks();
                $this->define_learning_hooks();

        }
                $this->define_widget_hooks();


        /**
         * Load the required dependencies for this plugin.
         *
         * Include the following files that make up the plugin:
         *
         * - Common_Elements_Platform_Loader. Orchestrates the hooks of the plugin.
         * - Common_Elements_Platform_i18n. Defines internationalization functionality.
         * - Common_Elements_Platform_Admin. Defines all hooks for the admin area.
         * - Common_Elements_Platform_Public. Defines all hooks for the public side of the site.
         * - Common_Elements_Platform_Post_Types. Registers custom post types and taxonomies.
         * - Common_Elements_Platform_Dashboard. Handles dashboard functionality.
         * - Common_Elements_Platform_RFP. Handles RFP system functionality.
         * - Common_Elements_Platform_Directory. Handles directory functionality.
         * - Common_Elements_Platform_Forum. Handles forum functionality.
         * - Common_Elements_Platform_Membership. Handles membership functionality.
         * - Common_Elements_Platform_Theme_Integration. Handles theme integration.
         *
         * Create an instance of the loader which will be used to register the hooks
         * with WordPress.
         *
         * @since    1.0.0
         * @access   private
         */
        private function load_dependencies() {

                /**
                 * The class responsible for orchestrating the actions and filters of the
                 * core plugin.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-loader.php';

                /**
                 * The class responsible for defining internationalization functionality
                 * of the plugin.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-i18n.php';

                /**
                 * The class responsible for defining all actions that occur in the admin area.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'admin/class-common-elements-platform-admin.php';

                /**
                 * The class responsible for defining all actions that occur in the public-facing
                 * side of the site.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'public/class-common-elements-platform-public.php';

                /**
                 * The class responsible for registering custom post types and taxonomies.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-post-types.php';

                /**
                 * The class responsible for dashboard functionality.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-dashboard.php';

                /**
                 * The class responsible for dashboard widget management.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-dashboard-widget-manager.php';

                /**
                 * The class responsible for RFP system functionality.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-rfp.php';

                /**
                 * The class responsible for RFP post types and taxonomies.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-rfp-post-types.php';

                /**
                 * The class responsible for directory functionality.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-directory.php';

                /**
                 * The class responsible for forum functionality.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-forum.php';

                /**
                 * The class responsible for learning functionality.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-learning.php';

                /**
                 * The class responsible for membership functionality.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-membership.php';

                /**
                 * The class responsible for theme integration.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-theme-integration.php';

                /**
                 * The class responsible for card components.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-cards.php';

                /**
                 * The class responsible for third-party integrations.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-integrations.php';

                /**
                 * GravityForms integration.
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/gravityforms-integration.php';

                /**
                 * Widget classes
                 */
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'widgets/class-common-elements-dashboard-widget.php';
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'widgets/class-common-elements-rfp-widget.php';
                require_once COMMON_ELEMENTS_PLATFORM_DIR . 'widgets/class-common-elements-directory-widget.php';

                $this->loader = new Common_Elements_Platform_Loader();
        }

        /**
         * Define the locale for this plugin for internationalization.
         *
         * Uses the Common_Elements_Platform_i18n class in order to set the domain and to register the hook
         * with WordPress.
         *
         * @since    1.0.0
         * @access   private
         */
        private function set_locale() {
                $plugin_i18n = new Common_Elements_Platform_i18n();
                $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
        }

        /**
         * Register all of the hooks related to the admin area functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_admin_hooks() {
                $plugin_admin = new Common_Elements_Platform_Admin( $this->get_plugin_name(), $this->get_version() );
                $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
                $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
                $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
                $this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
        }

        /**
         * Register all of the hooks related to the public-facing functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_public_hooks() {
                $plugin_public = new Common_Elements_Platform_Public( $this->get_plugin_name(), $this->get_version() );
                $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
                $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
                $this->loader->add_filter( 'body_class', $plugin_public, 'add_body_classes' );
                $this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );
        }

        /**
         * Register all of the hooks related to custom post types and taxonomies.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_post_types() {
                $plugin_post_types = new Common_Elements_Platform_Post_Types();
                $this->loader->add_action( 'init', $plugin_post_types, 'register_post_types' );
                $this->loader->add_action( 'init', $plugin_post_types, 'register_taxonomies' );
        }

        /**
         * Register all of the hooks related to dashboard functionality.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_dashboard_hooks() {
                $plugin_dashboard = new Common_Elements_Platform_Dashboard();
                $this->loader->add_action( 'init', $plugin_dashboard, 'register_dashboard_endpoints' );
                $this->loader->add_action( 'wp_ajax_get_dashboard_data', $plugin_dashboard, 'get_dashboard_data' );
                
                $widget_manager = new Common_Elements_Platform_Dashboard_Widget_Manager();
                $this->loader->add_action( 'wp_ajax_ce_ajax_save_widget_position', $widget_manager, 'ajax_save_widget_position' );
                $this->loader->add_action( 'wp_ajax_ce_ajax_get_widget_settings', $widget_manager, 'ajax_get_widget_settings' );
                $this->loader->add_action( 'wp_ajax_ce_ajax_save_widget_settings', $widget_manager, 'ajax_save_widget_settings' );
                $this->loader->add_action( 'wp_ajax_ce_ajax_add_widget', $widget_manager, 'ajax_add_widget' );
                $this->loader->add_action( 'wp_ajax_ce_ajax_remove_widget', $widget_manager, 'ajax_remove_widget' );
                $this->loader->add_action( 'wp_ajax_ce_ajax_refresh_widget', $widget_manager, 'ajax_refresh_widget' );
        }

        /**
         * Register all of the hooks related to RFP system functionality.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_rfp_hooks() {
                $plugin_rfp = new Common_Elements_Platform_RFP();
                $this->loader->add_action( 'init', $plugin_rfp, 'register_rfp_endpoints' );
                $this->loader->add_action( 'wp_ajax_submit_rfp', $plugin_rfp, 'submit_rfp' );
                $this->loader->add_action( 'wp_ajax_submit_proposal', $plugin_rfp, 'submit_proposal' );
                
                $plugin_rfp_post_types = new Common_Elements_Platform_RFP_Post_Types();
                $this->loader->add_action( 'init', $plugin_rfp_post_types, 'register_post_types' );
                $this->loader->add_action( 'add_meta_boxes', $plugin_rfp_post_types, 'add_rfp_metaboxes' );
                $this->loader->add_action( 'save_post_rfp', $plugin_rfp_post_types, 'save_rfp_metabox', 10, 2 );
                $this->loader->add_action( 'save_post_proposal', $plugin_rfp_post_types, 'save_proposal_metabox', 10, 2 );
                $this->loader->add_action( 'wp_ajax_ce_ajax_update_proposal_status', $plugin_rfp_post_types, 'update_proposal_status' );
        }

        /**
         * Register all of the hooks related to directory functionality.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_directory_hooks() {
                $plugin_directory = new Common_Elements_Platform_Directory();
                $this->loader->add_action( 'init', $plugin_directory, 'register_directory_endpoints' );
                $this->loader->add_action( 'wp_ajax_search_directory', $plugin_directory, 'search_directory' );
                $this->loader->add_action( 'wp_ajax_nopriv_search_directory', $plugin_directory, 'search_directory' );

        }

        /**
         * Register all of the hooks related to forum functionality.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_forum_hooks() {
                $plugin_forum = new Common_Elements_Platform_Forum();
                $this->loader->add_action( 'init', $plugin_forum, 'register_forum_endpoints' );

        }

        /**
         * Register all of the hooks related to membership functionality.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_membership_hooks() {
                $plugin_membership = new Common_Elements_Platform_Membership();
                $this->loader->add_action( 'init', $plugin_membership, 'register_membership_endpoints' );

                
                // MemberPress Courses integration
                if ( class_exists( 'MeprCourse' ) ) {
                    $this->loader->add_filter( 'mpcs_course_template', $plugin_membership, 'course_template' );
                    $this->loader->add_filter( 'mpcs_lesson_template', $plugin_membership, 'lesson_template' );
                    $this->loader->add_filter( 'mpcs_quiz_template', $plugin_membership, 'quiz_template' );
                    $this->loader->add_filter( 'mpcs_certificate_template', $plugin_membership, 'certificate_template' );
                }
        }

        /**
         * Register all of the hooks related to learning hub functionality.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_learning_hooks() {
                $plugin_learning = new Common_Elements_Platform_Learning();
                $this->loader->add_action( 'init', $plugin_learning, 'register_learning_post_types' );
                $this->loader->add_action( 'init', $plugin_learning, 'register_learning_taxonomies' );
                $this->loader->add_action( 'init', $plugin_learning, 'register_learning_endpoints' );
                $this->loader->add_action( 'add_meta_boxes', $plugin_learning, 'add_learning_meta_boxes' );
                $this->loader->add_action( 'save_post_course', $plugin_learning, 'save_course_meta_box_data' );
                $this->loader->add_action( 'save_post_lesson', $plugin_learning, 'save_lesson_meta_box_data' );
                $this->loader->add_action( 'save_post_quiz', $plugin_learning, 'save_quiz_meta_box_data' );
                $this->loader->add_action( 'wp_ajax_enroll_course', $plugin_learning, 'enroll_course' );
                $this->loader->add_action( 'wp_ajax_complete_lesson', $plugin_learning, 'complete_lesson' );
                $this->loader->add_action( 'wp_ajax_submit_quiz', $plugin_learning, 'submit_quiz' );
        }


        /**
         * Register all of the hooks related to theme integration.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_theme_integration_hooks() {
                $plugin_theme_integration = new Common_Elements_Platform_Theme_Integration();
                $this->loader->add_action( 'after_setup_theme', $plugin_theme_integration, 'theme_support' );
                $this->loader->add_filter( 'template_include', $plugin_theme_integration, 'maybe_override_template', 20 );
                
                // Add template path filter to check plugin templates first
                                
                $this->loader->add_action( 'wp_enqueue_scripts', $plugin_theme_integration, 'enqueue_assets' );
                // Add custom template redirect for plugin pages
                $this->loader->add_action( 'template_redirect', $plugin_theme_integration, 'template_redirect' );
        }


        /**
         * Register all of the hooks related to widget registration.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_widget_hooks() {
                $this->loader->add_action( 'widgets_init', $this, 'register_core_widgets' );
        }

        /**
         * Register core plugin widgets.
         *
         * @since    1.0.0
         */
        public function register_core_widgets() {
                register_widget('Common_Elements_Dashboard_Widget');
                register_widget('Common_Elements_RFP_Widget');
                register_widget('Common_Elements_Directory_Widget');
        }

        /**
         * Run the loader to execute all of the hooks with WordPress.
         *
         * @since    1.0.0
         */
        public function run() {
                $this->loader->run();
        }

        /**
         * The name of the plugin used to uniquely identify it within the context of
         * WordPress and to define internationalization functionality.
         *
         * @since     1.0.0
         * @return    string    The name of the plugin.
         */
        public function get_plugin_name() {
                return $this->plugin_name;
        }

        /**
         * The reference to the class that orchestrates the hooks with the plugin.
         *
         * @since     1.0.0
         * @return    Common_Elements_Platform_Loader    Orchestrates the hooks of the plugin.
         */
        public function get_loader() {
                return $this->loader;
        }

        /**
         * Retrieve the version number of the plugin.
         *
         * @since     1.0.0
         * @return    string    The version number of the plugin.
         */
        public function get_version() {
                return $this->version;
        }
}
