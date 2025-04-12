<?php
/**
 * Theme-Plugin Integration Class
 * 
 * This class handles the integration between the Common Elements Theme and Plugin,
 * allowing the plugin to control theme functions similar to BuddyBoss.
 *
 * @package Common_Elements_Platform
 */

class Common_Elements_Platform_Theme_Integration {

    /**
     * Initialize the theme integration
     */
    public function __construct() {
        // Register theme support
        add_action('after_setup_theme', array($this, 'register_theme_support'));
        
        // Add theme compatibility functions
        add_action('init', array($this, 'add_theme_compatibility'));
        
        // Register template directory
        add_filter('template_include', array($this, 'maybe_override_template'), 20);
        
        // Add body classes
        add_filter('body_class', array($this, 'add_body_classes'));
        
        // Add custom template locations
        add_filter('theme_page_templates', array($this, 'add_plugin_templates'));
        
        // Add plugin settings to theme customizer
        add_action('customize_register', array($this, 'add_customizer_settings'));
        
        // Add plugin scripts and styles to theme
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        
        // Add plugin admin bar items
        add_action('admin_bar_menu', array($this, 'add_admin_bar_items'), 100);
        
        // Add plugin widgets to theme
        add_action('widgets_init', array($this, 'register_widgets'));
        
        // Add plugin shortcodes
        $this->register_shortcodes();
    }

    /**
     * Register theme support for plugin features
     */
    public function register_theme_support() {
        // Add theme support for plugin features
        add_theme_support('common-elements-dashboard');
        add_theme_support('common-elements-rfp');
        add_theme_support('common-elements-directory');
        add_theme_support('common-elements-forums');
        add_theme_support('common-elements-learning-hub');
    }

    /**
     * Theme support callback function
     * 
     * This method is called by the theme to check if specific features are supported
     * 
     * @param string $feature The feature to check support for
     * @return bool Whether the feature is supported
     */
    public function theme_support($feature = '') {
        if (empty($feature)) {
            return false;
        }
        
        // List of supported features
        $supported_features = array(
            'dashboard',
            'rfp',
            'directory',
            'forums',
            'learning-hub',
            'membership',
            'classifieds',
            'common-area',
            'office'
        );
        
        // Check if the feature is supported
        return in_array($feature, $supported_features);
    }

    /**
     * Add theme compatibility functions
     */
    public function add_theme_compatibility() {
        // Check if current theme is Common Elements Theme
        if ($this->is_common_elements_theme()) {
            // Add full compatibility
            $this->add_full_compatibility();
        } else {
            // Add basic compatibility for other themes
            $this->add_basic_compatibility();
        }
    }

    /**
     * Check if current theme is Common Elements Theme
     *
     * @return bool Whether the current theme is Common Elements Theme
     */
    private function is_common_elements_theme() {
        $theme = wp_get_theme();
        return ('Common Elements' === $theme->name || 'Common Elements' === $theme->parent_theme);
    }

    /**
     * Add full compatibility for Common Elements Theme
     */
    private function add_full_compatibility() {
        if ( has_action('common_elements_before_header') ) {
            add_action('common_elements_before_header', array($this, 'add_before_header_content'));
        }
        if ( has_action('common_elements_after_header') ) {
            add_action('common_elements_after_header', array($this, 'add_after_header_content'));
        }
        if ( has_action('common_elements_before_footer') ) {
            add_action('common_elements_before_footer', array($this, 'add_before_footer_content'));
        }
        if ( has_action('common_elements_after_footer') ) {
            add_action('common_elements_after_footer', array($this, 'add_after_footer_content'));
        }
        
        if ( has_filter('common_elements_header_menu_items') ) {
            add_filter('common_elements_header_menu_items', array($this, 'modify_header_menu_items'));
        }
        if ( has_filter('common_elements_dashboard_tabs') ) {
            add_filter('common_elements_dashboard_tabs', array($this, 'modify_dashboard_tabs'));
        }
        if ( has_filter('common_elements_user_roles') ) {
            add_filter('common_elements_user_roles', array($this, 'modify_user_roles'));
        }
        
        add_action('widgets_init', array($this, 'register_theme_sidebars'));
        
    }


    /**
     * Placeholder for theme's before header action.
     */
    public function add_before_header_content() {
    }

    /**
     * Placeholder for theme's after header action.
     */
    public function add_after_header_content() {
    }

    /**
     * Placeholder for theme's before footer action.
     */
    public function add_before_footer_content() {
    }

    /**
     * Placeholder for theme's after footer action.
     */
    public function add_after_footer_content() {
    }

    /**
     * Placeholder for theme's header menu items filter.
     * @param array $items Original menu items.
     * @return array Menu items.
     */
    public function modify_header_menu_items( $items ) {
        return $items;
    }

    /**
     * Placeholder for theme's dashboard tabs filter.
     * @param array $tabs Original dashboard tabs.
     * @return array Dashboard tabs.
     */
    public function modify_dashboard_tabs( $tabs ) {
        return $tabs;
    }

    /**
     * Placeholder for theme's user roles filter.
     * @param array $roles Original user roles.
     * @return array User roles.
     */
    public function modify_user_roles( $roles ) {
        return $roles;
    }

    /**
     * Placeholder for theme's sidebar registration action.
     */
    public function register_theme_sidebars() {
    }
    }

    /**
     * Add basic compatibility for other themes
     */
    private function add_basic_compatibility() {
        // Add basic hooks
        add_action('wp_head', array($this, 'add_compatibility_header'));
        add_action('wp_footer', array($this, 'add_compatibility_footer'));
        
        // Add content filters
        add_filter('the_content', array($this, 'filter_content_for_compatibility'));
        
        // Add template redirects
        add_action('template_redirect', array($this, 'template_redirect'));
        
        // Add template filter for plugin templates
    }

    /**
     * Check plugin templates
     * 
     * This method checks if a template exists in the plugin
     * 
     * @param string $template The template path to check
     * @return string|bool The plugin template path or false if not found
     */
    public function check_plugin_templates($template) {
        // If no template, return false
        if (empty($template)) {
            return false;
        }
        
        // Get template name
        $template_name = basename($template);
        
        // Check if we have a matching template in the plugin
        $plugin_template = $this->get_plugin_template($template_name);
        
        if ($plugin_template) {
            return $plugin_template;
        }
        
        return false;
    }

    /**
     * Template redirect method
     * 
     * This method handles template redirects for plugin pages
     */
    public function template_redirect() {
        // Check if we're on a plugin page
        if ($this->is_plugin_page()) {
            // Handle specific plugin page redirects
            $this->handle_template_redirects();
        }
    }

    /**
     * Handle template redirects for plugin pages
     */
    public function handle_template_redirects() {
        global $wp_query;
        
        // Check for plugin endpoints
        if (isset($wp_query->query_vars['rfp'])) {
            // Handle RFP endpoint
            $this->handle_rfp_endpoint();
        } elseif (isset($wp_query->query_vars['directory'])) {
            // Handle directory endpoint
            $this->handle_directory_endpoint();
        } elseif (isset($wp_query->query_vars['forum'])) {
            // Handle forum endpoint
            $this->handle_forum_endpoint();
        } elseif (isset($wp_query->query_vars['learning'])) {
            // Handle learning hub endpoint
            $this->handle_learning_endpoint();
        }
    }

    /**
     * Check if current page is a plugin page
     *
     * @return bool Whether the current page is a plugin page
     */
    private function is_plugin_page() {
        global $wp_query;
        
        // Check for plugin endpoints
        if (isset($wp_query->query_vars['rfp']) || 
            isset($wp_query->query_vars['directory']) || 
            isset($wp_query->query_vars['forum']) || 
            isset($wp_query->query_vars['learning'])) {
            return true;
        }
        
        // Check for plugin page templates
        if (is_page_template(array(
            'templates/dashboard-board.php',
            'templates/dashboard-cam.php',
            'templates/dashboard-vendor.php',
            'templates/rfp-listing.php',
            'templates/directory.php',
            'templates/forums-home.php',
            'templates/learning-hub.php'
        ))) {
            return true;
        }
        
        return false;
    }

    /**
     * Handle RFP endpoint
     */
    private function handle_rfp_endpoint() {
        global $wp_query;
        
        // Get RFP ID
        $rfp_id = get_query_var('rfp');
        
        if (!empty($rfp_id)) {
            // Set up RFP data
            $wp_query->is_single = true;
            $wp_query->is_singular = true;
            $wp_query->is_404 = false;
        }
    }

    /**
     * Handle directory endpoint
     */
    private function handle_directory_endpoint() {
        global $wp_query;
        
        // Get directory ID
        $directory_id = get_query_var('directory');
        
        if (!empty($directory_id)) {
            // Set up directory data
            $wp_query->is_single = true;
            $wp_query->is_singular = true;
            $wp_query->is_404 = false;
        }
    }

    /**
     * Handle forum endpoint
     */
    private function handle_forum_endpoint() {
        global $wp_query;
        
        // Get forum ID
        $forum_id = get_query_var('forum');
        
        if (!empty($forum_id)) {
            // Set up forum data
            $wp_query->is_single = true;
            $wp_query->is_singular = true;
            $wp_query->is_404 = false;
        }
    }

    /**
     * Handle learning hub endpoint
     */
    private function handle_learning_endpoint() {
        global $wp_query;
        
        // Get learning ID
        $learning_id = get_query_var('learning');
        
        if (!empty($learning_id)) {
            // Set up learning data
            $wp_query->is_single = true;
            $wp_query->is_singular = true;
            $wp_query->is_404 = false;
        }
    }

    /**
     * Maybe override template with plugin template
     *
     * @param string $template Current template path
     * @return string Modified template path
     */
    public function maybe_override_template($template) {
        
        
        $template_name = basename($template);
        
        if ( ! class_exists( 'Common_Elements_Platform_Template_Loader' ) ) {
            require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-template-loader.php';
        }
        $loader = Common_Elements_Platform_Template_Loader::get_instance();
        
        $located_template = $loader->locate_template( $template_name );

        if ( ! empty( $located_template ) ) {
             $plugin_template_dir = trailingslashit( COMMON_ELEMENTS_PLATFORM_DIR ) . trailingslashit( $loader->get_plugin_template_directory() );
             if ( $located_template !== $template && strpos( $located_template, $plugin_template_dir ) === 0 ) {
                 return $located_template;
             }
             $theme_template_dir = trailingslashit( get_stylesheet_directory() ) . trailingslashit( $loader->get_theme_template_directory() );
             if ( $located_template !== $template && strpos( $located_template, $theme_template_dir ) === 0 ) {
                 return $located_template;
             }
        }
        
        return $template;
    }

    /**
     * Add body classes for plugin pages
     *
     * @param array $classes Current body classes
     * @return array Modified body classes
     */
    public function add_body_classes($classes) {
        // Add plugin-specific body classes
        if (is_page_template('templates/dashboard-board.php')) {
            $classes[] = 'common-elements-dashboard';
            $classes[] = 'common-elements-board-view';
        } elseif (is_page_template('templates/dashboard-cam.php')) {
            $classes[] = 'common-elements-dashboard';
            $classes[] = 'common-elements-cam-view';
        } elseif (is_page_template('templates/dashboard-vendor.php')) {
            $classes[] = 'common-elements-dashboard';
            $classes[] = 'common-elements-vendor-view';
        } elseif (is_page_template('templates/rfp-listing.php')) {
            $classes[] = 'common-elements-rfp';
            $classes[] = 'common-elements-rfp-listing';
        }
        
        return $classes;
    }

    /**
     * Add plugin templates to theme page templates
     *
     * @param array $templates Current page templates
     * @return array Modified page templates
     */
    public function add_plugin_templates($templates) {
        // Add plugin page templates
        $templates['templates/dashboard-board.php'] = 'Board Member Dashboard';
        $templates['templates/dashboard-cam.php'] = 'CAM Professional Dashboard';
        $templates['templates/dashboard-vendor.php'] = 'Vendor Dashboard';
        $templates['templates/rfp-listing.php'] = 'RFP Listing';
        $templates['templates/directory.php'] = 'Directory';
        $templates['templates/forums-home.php'] = 'Forums';
        $templates['templates/learning-hub.php'] = 'Learning Hub';
        
        return $templates;
    }

    /**
     * Add customizer settings for plugin
     *
     * @param WP_Customize_Manager $wp_customize Customizer object
     */
    public function add_customizer_settings($wp_customize) {
        // Add plugin section
        $wp_customize->add_section('common_elements_plugin', array(
            'title' => __('Common Elements Plugin', 'common-elements-platform'),
            'priority' => 30,
        ));
        
        // Add plugin settings
        $wp_customize->add_setting('common_elements_dashboard_layout', array(
            'default' => 'sidebar-left',
            'sanitize_callback' => 'sanitize_text_field',
        ));
        
        $wp_customize->add_control('common_elements_dashboard_layout', array(
            'label' => __('Dashboard Layout', 'common-elements-platform'),
            'section' => 'common_elements_plugin',
            'type' => 'select',
            'choices' => array(
                'sidebar-left' => __('Sidebar Left', 'common-elements-platform'),
                'sidebar-right' => __('Sidebar Right', 'common-elements-platform'),
                'full-width' => __('Full Width', 'common-elements-platform'),
            ),
        ));
    }

    /**
     * Enqueue plugin assets
     */
    public function enqueue_assets() {
        $suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';
        $css_path = 'assets/css/common-elements-platform-public' . $suffix . '.css';
        $js_path = 'assets/js/common-elements-platform-public' . $suffix . '.js';
        $css_file_path = plugin_dir_path(dirname(__FILE__)) . $css_path;
        $js_file_path = plugin_dir_path(dirname(__FILE__)) . $js_path;

        // Enqueue plugin styles
        if ( file_exists( $css_file_path ) ) {
            wp_enqueue_style(
                'common-elements-platform-public',
                plugin_dir_url(dirname(__FILE__)) . $css_path,
                array(),
                filemtime( $css_file_path ),
                'all'
            );
        }
        
        // Enqueue plugin scripts
        if ( file_exists( $js_file_path ) ) {
            wp_enqueue_script(
                'common-elements-platform-public',
                plugin_dir_url(dirname(__FILE__)) . $js_path,
                array('jquery'),
                filemtime( $js_file_path ),
                true
            );
        }
    }

    /**
     * Add admin bar items
     *
     * @param WP_Admin_Bar $wp_admin_bar Admin bar object
     */
    public function add_admin_bar_items($wp_admin_bar) {
        // Only add items for logged-in users
        if (!is_user_logged_in()) {
            return;
        }
        
        // Add main menu item
        $wp_admin_bar->add_node(array(
            'id' => 'common-elements',
            'title' => __('Common Elements', 'common-elements-platform'),
            'href' => admin_url('admin.php?page=common-elements-platform'),
        ));
        
        // Add submenu items
        $wp_admin_bar->add_node(array(
            'parent' => 'common-elements',
            'id' => 'common-elements-dashboard',
            'title' => __('Dashboard', 'common-elements-platform'),
            'href' => home_url('/dashboard/'),
        ));
        
        $wp_admin_bar->add_node(array(
            'parent' => 'common-elements',
            'id' => 'common-elements-rfp',
            'title' => __('RFP System', 'common-elements-platform'),
            'href' => home_url('/rfp/'),
        ));
        
        $wp_admin_bar->add_node(array(
            'parent' => 'common-elements',
            'id' => 'common-elements-directory',
            'title' => __('Directory', 'common-elements-platform'),
            'href' => home_url('/directory/'),
        ));
    }

    /**
     * Register plugin widgets
     */
    public function register_widgets() {
        // Register plugin widgets
        register_widget('Common_Elements_Dashboard_Widget');
        register_widget('Common_Elements_RFP_Widget');
        register_widget('Common_Elements_Directory_Widget');
    }

    /**
     * Register plugin shortcodes
     */
    private function register_shortcodes() {
        // Register plugin shortcodes
        add_shortcode('ce_dashboard', array($this, 'dashboard_shortcode'));
        add_shortcode('ce_rfp_listing', array($this, 'rfp_listing_shortcode'));
        add_shortcode('ce_directory', array($this, 'directory_shortcode'));
    }

    /**
     * Dashboard shortcode callback
     *
     * @param array $atts Shortcode attributes
     * @return string Shortcode output
     */
    public function dashboard_shortcode($atts) {
        // Parse attributes
        $atts = shortcode_atts(array(
            'type' => 'board',
        ), $atts, 'ce_dashboard');
        
        // Start output buffering
        ob_start();
        
        // Include appropriate template based on type
        switch ($atts['type']) {
            case 'board':
                include plugin_dir_path(dirname(__FILE__)) . 'public/partials/dashboard/dashboard-board.php';
                break;
            case 'cam':
                include plugin_dir_path(dirname(__FILE__)) . 'public/partials/dashboard/dashboard-cam.php';
                break;
            case 'vendor':
                include plugin_dir_path(dirname(__FILE__)) . 'public/partials/dashboard/dashboard-vendor.php';
                break;
            default:
                include plugin_dir_path(dirname(__FILE__)) . 'public/partials/dashboard/dashboard-board.php';
                break;
        }
        
        // Return buffered content
        return ob_get_clean();
    }

    /**
     * RFP listing shortcode callback
     *
     * @param array $atts Shortcode attributes
     * @return string Shortcode output
     */
    public function rfp_listing_shortcode($atts) {
        // Parse attributes
        $atts = shortcode_atts(array(
            'category' => '',
            'status' => 'open',
            'limit' => 10,
        ), $atts, 'ce_rfp_listing');
        
        // Start output buffering
        ob_start();
        
        // Include template
        include plugin_dir_path(dirname(__FILE__)) . 'public/partials/rfp/rfp-list.php';
        
        // Return buffered content
        return ob_get_clean();
    }

    /**
     * Directory shortcode callback
     *
     * @param array $atts Shortcode attributes
     * @return string Shortcode output
     */
    public function directory_shortcode($atts) {
        // Parse attributes
        $atts = shortcode_atts(array(
            'category' => '',
            'limit' => 20,
        ), $atts, 'ce_directory');
        
        // Start output buffering
        ob_start();
        
        // Include template
        include plugin_dir_path(dirname(__FILE__)) . 'public/partials/directory/directory-list.php';
        
        // Return buffered content
        return ob_get_clean();
    }

    /**
     * Register theme sidebars
     */
    public function register_theme_sidebars() {
        // Register dashboard sidebar
        register_sidebar(array(
            'name' => __('Dashboard Sidebar', 'common-elements-platform'),
            'id' => 'dashboard-sidebar',
            'description' => __('Widgets in this area will be shown on dashboard pages.', 'common-elements-platform'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        
        // Register RFP sidebar
        register_sidebar(array(
            'name' => __('RFP Sidebar', 'common-elements-platform'),
            'id' => 'rfp-sidebar',
            'description' => __('Widgets in this area will be shown on RFP pages.', 'common-elements-platform'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
    }

    /**
     * Add content before header
     */
    public function add_before_header_content() {
        // Include before header template
        include plugin_dir_path(dirname(__FILE__)) . 'public/partials/common-elements-platform-before-header.php';
    }

    /**
     * Add content after header
     */
    public function add_after_header_content() {
        // Include after header template
        include plugin_dir_path(dirname(__FILE__)) . 'public/partials/common-elements-platform-after-header.php';
    }

    /**
     * Add content before footer
     */
    public function add_before_footer_content() {
        // Include before footer template
        include plugin_dir_path(dirname(__FILE__)) . 'public/partials/common-elements-platform-before-footer.php';
    }

    /**
     * Add content after footer
     */
    public function add_after_footer_content() {
        // Include after footer template
        include plugin_dir_path(dirname(__FILE__)) . 'public/partials/common-elements-platform-after-footer.php';
    }

    /**
     * Modify header menu items
     *
     * @param array $items Current menu items
     * @return array Modified menu items
     */
    public function modify_header_menu_items($items) {
        // Add plugin menu items
        $items[] = array(
            'title' => __('Dashboard', 'common-elements-platform'),
            'url' => home_url('/dashboard/'),
            'classes' => 'common-elements-dashboard-link',
        );
        
        $items[] = array(
            'title' => __('RFP System', 'common-elements-platform'),
            'url' => home_url('/rfp/'),
            'classes' => 'common-elements-rfp-link',
        );
        
        $items[] = array(
            'title' => __('Directory', 'common-elements-platform'),
            'url' => home_url('/directory/'),
            'classes' => 'common-elements-directory-link',
        );
        
        return $items;
    }

    /**
     * Modify dashboard tabs
     *
     * @param array $tabs Current dashboard tabs
     * @return array Modified dashboard tabs
     */
    public function modify_dashboard_tabs($tabs) {
        // Add plugin dashboard tabs
        $tabs['rfp'] = array(
            'title' => __('RFP System', 'common-elements-platform'),
            'icon' => 'dashicons-media-document',
            'url' => home_url('/dashboard/rfp/'),
        );
        
        $tabs['directory'] = array(
            'title' => __('Directory', 'common-elements-platform'),
            'icon' => 'dashicons-groups',
            'url' => home_url('/dashboard/directory/'),
        );
        
        return $tabs;
    }

    /**
     * Modify user roles
     *
     * @param array $roles Current user roles
     * @return array Modified user roles
     */
    public function modify_user_roles($roles) {
        // Add plugin user roles
        $roles['board_member'] = array(
            'name' => __('Board Member', 'common-elements-platform'),
            'capabilities' => array(
                'read' => true,
                'view_dashboard' => true,
                'view_rfp' => true,
                'create_rfp' => true,
                'view_directory' => true,
            ),
        );
        
        $roles['cam_professional'] = array(
            'name' => __('CAM Professional', 'common-elements-platform'),
            'capabilities' => array(
                'read' => true,
                'view_dashboard' => true,
                'view_rfp' => true,
                'create_rfp' => true,
                'approve_rfp' => true,
                'view_directory' => true,
                'manage_directory' => true,
            ),
        );
        
        $roles['vendor'] = array(
            'name' => __('Vendor', 'common-elements-platform'),
            'capabilities' => array(
                'read' => true,
                'view_dashboard' => true,
                'view_rfp' => true,
                'submit_proposal' => true,
                'view_directory' => true,
            ),
        );
        
        return $roles;
    }

    /**
     * Add compatibility header content
     */
    public function add_compatibility_header() {
        // Add compatibility CSS
        echo '<style type="text/css">
            .common-elements-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }
            .common-elements-dashboard {
                display: flex;
                flex-wrap: wrap;
            }
            .common-elements-dashboard-sidebar {
                width: 25%;
                padding-right: 20px;
            }
            .common-elements-dashboard-content {
                width: 75%;
            }
            @media (max-width: 768px) {
                .common-elements-dashboard-sidebar,
                .common-elements-dashboard-content {
                    width: 100%;
                    padding-right: 0;
                }
            }
        </style>';
    }

    /**
     * Add compatibility footer content
     */
    public function add_compatibility_footer() {
        // Add compatibility JavaScript
        echo '<script type="text/javascript">
            (function($) {
                $(document).ready(function() {
                    // Initialize plugin components
                    if (typeof commonElementsInit === "function") {
                        commonElementsInit();
                    }
                });
            })(jQuery);
        </script>';
    }

    /**
     * Filter content for compatibility
     *
     * @param string $content Current content
     * @return string Modified content
     */
    public function filter_content_for_compatibility($content) {
        global $post;
        
        // Only modify plugin pages
        if (!$post || !is_singular()) {
            return $content;
        }
        
        // Check if this is a plugin page
        if ($this->is_plugin_page()) {
            // Wrap content in plugin container
            $content = '<div class="common-elements-container">' . $content . '</div>';
        }
        
        return $content;
    }
}
