<?php
/**
 * Plugin support for Common Elements theme.
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class responsible for plugin support.
 */
class Common_Elements_Plugin_Support {

    /**
     * The single instance of this class.
     *
     * @var Common_Elements_Plugin_Support
     */
    private static $instance = null;

    /**
     * Get the single instance of this class.
     *
     * @return Common_Elements_Plugin_Support
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        // Common Elements Platform integration
        add_action( 'after_setup_theme', array( $this, 'common_elements_platform_support' ) );
        add_filter( 'common_elements_platform_template_paths', array( $this, 'add_theme_template_path' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'common_elements_platform_styles' ) );
        
        // MemberPress integration
        add_action( 'after_setup_theme', array( $this, 'memberpress_support' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'memberpress_styles' ) );
        
        // Gravity Forms integration
        add_action( 'after_setup_theme', array( $this, 'gravity_forms_support' ) );
        add_filter( 'gform_field_container', array( $this, 'gravity_forms_field_container' ), 10, 6 );
        add_filter( 'gform_submit_button', array( $this, 'gravity_forms_submit_button' ), 10, 2 );
        
        // GravityView integration
        add_action( 'after_setup_theme', array( $this, 'gravityview_support' ) );
        add_filter( 'gravityview/template/view/class', array( $this, 'gravityview_template_class' ) );
        
        // GravityCharts integration
        add_action( 'after_setup_theme', array( $this, 'gravitycharts_support' ) );
        
        // GeoDirectory integration
        add_action( 'after_setup_theme', array( $this, 'geodirectory_support' ) );
        add_filter( 'geodir_design_settings', array( $this, 'geodirectory_design_settings' ) );
    }

    /**
     * Add Common Elements Platform support.
     */
    public function common_elements_platform_support() {
        // Add theme support for Common Elements Platform
        add_theme_support( 'common-elements-platform', array(
            'directory'    => true,
            'rfp'          => true,
            'proposals'    => true,
            'forums'       => true,
            'learning-hub' => true,
        ) );
        
        // Create template directories if they don't exist
        $template_dirs = array(
            'common-elements',
            'common-elements/directory',
            'common-elements/rfp',
            'common-elements/forum',
            'common-elements/learning',
        );
        
        foreach ( $template_dirs as $dir ) {
            $dir_path = get_template_directory() . '/' . $dir;
            if ( ! file_exists( $dir_path ) ) {
                wp_mkdir_p( $dir_path );
            }
        }
    }

    /**
     * Add theme template path to Common Elements Platform.
     *
     * @param array $paths Template paths.
     * @return array
     */
    public function add_theme_template_path( $paths ) {
        $paths[] = get_template_directory() . '/common-elements/';
        return $paths;
    }

    /**
     * Enqueue Common Elements Platform styles.
     */
    public function common_elements_platform_styles() {
        if ( ! class_exists( 'Common_Elements_Platform' ) ) {
            return;
        }
        
    }

    /**
     * Add MemberPress support.
     */
    public function memberpress_support() {
        if ( ! class_exists( 'MeprUser' ) ) {
            return;
        }
        
        // Add MemberPress template overrides directory
        if ( ! file_exists( get_template_directory() . '/memberpress' ) ) {
            wp_mkdir_p( get_template_directory() . '/memberpress' );
        }
        
        // Add MemberPress account integration with Common Elements Platform
        add_filter( 'mepr-account-nav-items', array( $this, 'memberpress_account_nav_items' ) );
    }

    /**
     * Add Common Elements Platform items to MemberPress account navigation.
     *
     * @param array $items Navigation items.
     * @return array
     */
    public function memberpress_account_nav_items( $items ) {
        if ( ! class_exists( 'Common_Elements_Platform' ) ) {
            return $items;
        }
        
        // Get Common Elements Platform settings
        $options = get_option( 'common_elements_platform_options', array() );
        
        // Add Directory link if enabled
        if ( isset( $options['modules']['directory'] ) && $options['modules']['directory'] === 'on' ) {
            $items['directory'] = array(
                'url'    => home_url( '/directory/' ),
                'label'  => __( 'Directory', 'common-elements' ),
                'icon'   => 'address-book',
                'active' => false,
            );
        }
        
        // Add RFP link if enabled
        if ( isset( $options['modules']['rfp'] ) && $options['modules']['rfp'] === 'on' ) {
            $items['rfp'] = array(
                'url'    => home_url( '/rfp/' ),
                'label'  => __( 'RFPs', 'common-elements' ),
                'icon'   => 'file-contract',
                'active' => false,
            );
        }
        
        // Add Forums link if enabled
        if ( isset( $options['modules']['forums'] ) && $options['modules']['forums'] === 'on' ) {
            $items['forums'] = array(
                'url'    => home_url( '/forums/' ),
                'label'  => __( 'Forums', 'common-elements' ),
                'icon'   => 'comments',
                'active' => false,
            );
        }
        
        // Add Learning Hub link if enabled
        if ( isset( $options['modules']['learning-hub'] ) && $options['modules']['learning-hub'] === 'on' ) {
            $items['learning'] = array(
                'url'    => home_url( '/learning-hub/' ),
                'label'  => __( 'Learning Hub', 'common-elements' ),
                'icon'   => 'graduation-cap',
                'active' => false,
            );
        }
        
        return $items;
    }

    /**
     * Enqueue MemberPress styles.
     */
    public function memberpress_styles() {
        if ( ! class_exists( 'MeprUser' ) ) {
            return;
        }
        
        wp_enqueue_style(
            'common-elements-memberpress',
            get_template_directory_uri() . '/assets/css/memberpress.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );
    }

    /**
     * Add Gravity Forms support.
     */
    public function gravity_forms_support() {
        if ( ! class_exists( 'GFForms' ) ) {
            return;
        }
        
        // Add Gravity Forms styles
        add_filter( 'gform_pre_enqueue_styles', array( $this, 'gravity_forms_styles' ) );
        
        // Add Gravity Forms AJAX spinner
        add_filter( 'gform_ajax_spinner_url', array( $this, 'gravity_forms_spinner_url' ), 10, 2 );
    }

    /**
     * Modify Gravity Forms styles.
     *
     * @param array $styles Styles.
     * @return array
     */
    public function gravity_forms_styles( $styles ) {
        // Disable default Gravity Forms CSS
        unset( $styles['gforms_reset_css'] );
        unset( $styles['gforms_formsmain_css'] );
        unset( $styles['gforms_ready_class_css'] );
        unset( $styles['gforms_browsers_css'] );
        
        return $styles;
    }

    /**
     * Modify Gravity Forms field container.
     *
     * @param string $field_container Field container HTML.
     * @param object $field           Field object.
     * @param string $form            Form string.
     * @param string $css_class       CSS class.
     * @param string $style           Style attribute.
     * @param string $field_content   Field content.
     * @return string
     */
    public function gravity_forms_field_container( $field_container, $field, $form, $css_class, $style, $field_content ) {
        return '<div class="form-field gfield ' . $css_class . '">' . $field_content . '</div>';
    }

    /**
     * Modify Gravity Forms submit button.
     *
     * @param string $button Button HTML.
     * @param array  $form   Form array.
     * @return string
     */
    public function gravity_forms_submit_button( $button, $form ) {
        return '<button type="submit" class="button gform_button" id="gform_submit_button_' . $form['id'] . '">' . $form['button']['text'] . '</button>';
    }

    /**
     * Modify Gravity Forms spinner URL.
     *
     * @param string $spinner_url Spinner URL.
     * @param array  $form        Form array.
     * @return string
     */
    public function gravity_forms_spinner_url( $spinner_url, $form ) {
        return get_template_directory_uri() . '/assets/images/spinner.gif';
    }

    /**
     * Enqueue Gravity Forms styles.
     */
    public function gravity_forms_styles() {
        if ( ! class_exists( 'GFForms' ) ) {
            return;
        }
        
        wp_enqueue_style(
            'common-elements-gravity-forms',
            get_template_directory_uri() . '/assets/css/gravity-forms.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );
    }

    /**
     * Add GravityView support.
     */
    public function gravityview_support() {
        if ( ! class_exists( 'GravityView_Plugin' ) ) {
            return;
        }
        
        // Add GravityView template overrides directory
        if ( ! file_exists( get_template_directory() . '/gravityview' ) ) {
            wp_mkdir_p( get_template_directory() . '/gravityview' );
        }
        
        // Enqueue GravityView styles
        add_action( 'wp_enqueue_scripts', array( $this, 'gravityview_styles' ) );
    }

    /**
     * Modify GravityView template class.
     *
     * @param string $class Template class.
     * @return string
     */
    public function gravityview_template_class( $class ) {
        return 'common-elements-gravityview ' . $class;
    }

    /**
     * Enqueue GravityView styles.
     */
    public function gravityview_styles() {
        if ( ! class_exists( 'GravityView_Plugin' ) ) {
            return;
        }
        
        wp_enqueue_style(
            'common-elements-gravityview',
            get_template_directory_uri() . '/assets/css/gravityview.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );
    }

    /**
     * Add GravityCharts support.
     */
    public function gravitycharts_support() {
        if ( ! class_exists( 'GFChart' ) ) {
            return;
        }
        
        // Enqueue GravityCharts styles
        add_action( 'wp_enqueue_scripts', array( $this, 'gravitycharts_styles' ) );
    }

    /**
     * Enqueue GravityCharts styles.
     */
    public function gravitycharts_styles() {
        if ( ! class_exists( 'GFChart' ) ) {
            return;
        }
        
        wp_enqueue_style(
            'common-elements-gravitycharts',
            get_template_directory_uri() . '/assets/css/gravitycharts.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );
    }

    /**
     * Add GeoDirectory support.
     */
    public function geodirectory_support() {
        if ( ! class_exists( 'GeoDirectory' ) ) {
            return;
        }
        
        // Add GeoDirectory template overrides directory
        if ( ! file_exists( get_template_directory() . '/geodirectory' ) ) {
            wp_mkdir_p( get_template_directory() . '/geodirectory' );
        }
        
        // Enqueue GeoDirectory styles
        add_action( 'wp_enqueue_scripts', array( $this, 'geodirectory_styles' ) );
        
        // Add GeoDirectory integration with Common Elements Platform Directory
        if ( class_exists( 'Common_Elements_Platform' ) ) {
            add_filter( 'geodir_get_template', array( $this, 'geodirectory_template' ), 10, 5 );
        }
    }

    /**
     * Modify GeoDirectory design settings.
     *
     * @param array $settings Design settings.
     * @return array
     */
    public function geodirectory_design_settings( $settings ) {
        // Get theme options
        $options = get_option( 'common_elements_theme_options', array() );
        
        // Set primary color
        if ( isset( $options['primary_color'] ) ) {
            $settings['design_primary_color'] = $options['primary_color'];
        }
        
        // Set secondary color
        if ( isset( $options['secondary_color'] ) ) {
            $settings['design_secondary_color'] = $options['secondary_color'];
        }
        
        return $settings;
    }

    /**
     * Modify GeoDirectory template.
     *
     * @param string $template      Template path.
     * @param string $template_name Template name.
     * @param array  $args          Template arguments.
     * @param string $template_path Template path.
     * @param string $default_path  Default path.
     * @return string
     */
    public function geodirectory_template( $template, $template_name, $args, $template_path, $default_path ) {
        // Check if this is a directory template
        if ( strpos( $template_name, 'content-listing' ) !== false ) {
            // Check if Common Elements Platform directory template exists
            $ce_template = get_template_directory() . '/common-elements/directory/geodirectory-' . $template_name;
            if ( file_exists( $ce_template ) ) {
                return $ce_template;
            }
        }
        
        return $template;
    }

    /**
     * Enqueue GeoDirectory styles.
     */
    public function geodirectory_styles() {
        if ( ! class_exists( 'GeoDirectory' ) ) {
            return;
        }
        
        wp_enqueue_style(
            'common-elements-geodirectory',
            get_template_directory_uri() . '/assets/css/geodirectory.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );
    }
}

// Initialize the plugin support
Common_Elements_Plugin_Support::get_instance();
