<?php
/**
 * The settings API for the plugin.
 *
 * @package Common_Elements_Platform
 */

/**
 * Class responsible for managing plugin settings.
 *
 * This class provides a comprehensive settings framework for the plugin,
 * including settings registration, validation, and retrieval.
 *
 * @since 1.0.0
 */
class Common_Elements_Platform_Settings {

    /**
     * The single instance of this class.
     *
     * @since 1.0.0
     * @access private
     * @var Common_Elements_Platform_Settings
     */
    private static $instance = null;

    /**
     * The plugin options.
     *
     * @since 1.0.0
     * @access private
     * @var array
     */
    private $options = array();

    /**
     * The settings sections.
     *
     * @since 1.0.0
     * @access private
     * @var array
     */
    private $sections = array();

    /**
     * The settings fields.
     *
     * @since 1.0.0
     * @access private
     * @var array
     */
    private $fields = array();

    /**
     * Get the single instance of this class.
     *
     * @since 1.0.0
     * @return Common_Elements_Platform_Settings
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    private function __construct() {
        $this->options = get_option( 'common_elements_platform_options', array() );
        $this->define_sections();
        $this->define_fields();
    }

    /**
     * Define settings sections.
     *
     * @since 1.0.0
     */
    private function define_sections() {
        $this->sections = array(
            'general' => array(
                'id'    => 'common_elements_general_settings',
                'title' => __( 'General Settings', 'common-elements-platform' ),
                'desc'  => __( 'Configure general settings for the Common Elements Platform.', 'common-elements-platform' ),
                'icon'  => 'dashicons-admin-generic',
            ),
            'modules' => array(
                'id'    => 'common_elements_module_settings',
                'title' => __( 'Module Settings', 'common-elements-platform' ),
                'desc'  => __( 'Enable or disable specific modules of the Common Elements Platform.', 'common-elements-platform' ),
                'icon'  => 'dashicons-admin-plugins',
            ),
            'appearance' => array(
                'id'    => 'common_elements_appearance_settings',
                'title' => __( 'Appearance Settings', 'common-elements-platform' ),
                'desc'  => __( 'Configure appearance settings for the Common Elements Platform.', 'common-elements-platform' ),
                'icon'  => 'dashicons-admin-appearance',
            ),
            'pages' => array(
                'id'    => 'common_elements_pages_settings',
                'title' => __( 'Pages Settings', 'common-elements-platform' ),
                'desc'  => __( 'Configure page assignments for the Common Elements Platform.', 'common-elements-platform' ),
                'icon'  => 'dashicons-admin-page',
            ),
            'integrations' => array(
                'id'    => 'common_elements_integration_settings',
                'title' => __( 'Integration Settings', 'common-elements-platform' ),
                'desc'  => __( 'Configure integration settings for third-party services.', 'common-elements-platform' ),
                'icon'  => 'dashicons-admin-links',
            ),
            'plugins' => array(
                'id'    => 'common_elements_plugins_integration',
                'title' => __( 'Plugin Integrations', 'common-elements-platform' ),
                'desc'  => __( 'Configure integration settings for third-party WordPress plugins.', 'common-elements-platform' ),
                'icon'  => 'dashicons-admin-plugins',
            ),
            'advanced' => array(
                'id'    => 'common_elements_advanced_settings',
                'title' => __( 'Advanced Settings', 'common-elements-platform' ),
                'desc'  => __( 'Configure advanced settings for the Common Elements Platform.', 'common-elements-platform' ),
                'icon'  => 'dashicons-admin-tools',
            ),
        );
    }

    /**
     * Define settings fields.
     *
     * @since 1.0.0
     */
    private function define_fields() {
        $this->fields = array(
            // General Settings
            array(
                'id'       => 'platform_name',
                'title'    => __( 'Platform Name', 'common-elements-platform' ),
                'desc'     => __( 'The name of your platform as displayed to users.', 'common-elements-platform' ),
                'type'     => 'text',
                'default'  => 'Common Elements',
                'section'  => 'general',
            ),
            array(
                'id'       => 'platform_logo',
                'title'    => __( 'Platform Logo', 'common-elements-platform' ),
                'desc'     => __( 'URL to your platform logo image.', 'common-elements-platform' ),
                'type'     => 'image',
                'default'  => '',
                'section'  => 'general',
            ),
            array(
                'id'       => 'admin_email',
                'title'    => __( 'Admin Email', 'common-elements-platform' ),
                'desc'     => __( 'Email address for platform notifications and alerts.', 'common-elements-platform' ),
                'type'     => 'email',
                'default'  => get_option( 'admin_email' ),
                'section'  => 'general',
            ),
            array(
                'id'       => 'date_format',
                'title'    => __( 'Date Format', 'common-elements-platform' ),
                'desc'     => __( 'Format for displaying dates throughout the platform.', 'common-elements-platform' ),
                'type'     => 'select',
                'options'  => array(
                    'F j, Y' => date_i18n( 'F j, Y' ),
                    'Y-m-d'  => date_i18n( 'Y-m-d' ),
                    'm/d/Y'  => date_i18n( 'm/d/Y' ),
                    'd/m/Y'  => date_i18n( 'd/m/Y' ),
                ),
                'default'  => 'F j, Y',
                'section'  => 'general',
            ),
            array(
                'id'       => 'time_format',
                'title'    => __( 'Time Format', 'common-elements-platform' ),
                'desc'     => __( 'Format for displaying times throughout the platform.', 'common-elements-platform' ),
                'type'     => 'select',
                'options'  => array(
                    'g:i a' => date_i18n( 'g:i a' ),
                    'g:i A' => date_i18n( 'g:i A' ),
                    'H:i'   => date_i18n( 'H:i' ),
                ),
                'default'  => 'g:i a',
                'section'  => 'general',
            ),

            // Module Settings
            array(
                'id'       => 'enable_dashboard',
                'title'    => __( 'Dashboard', 'common-elements-platform' ),
                'desc'     => __( 'Enable dashboard module.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'on',
                'section'  => 'modules',
            ),
            array(
                'id'       => 'enable_rfp',
                'title'    => __( 'RFP System', 'common-elements-platform' ),
                'desc'     => __( 'Enable RFP system module.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'on',
                'section'  => 'modules',
            ),
            array(
                'id'       => 'enable_directory',
                'title'    => __( 'Directory', 'common-elements-platform' ),
                'desc'     => __( 'Enable directory module.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'on',
                'section'  => 'modules',
            ),
            array(
                'id'       => 'enable_forum',
                'title'    => __( 'Forums', 'common-elements-platform' ),
                'desc'     => __( 'Enable forums module.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'on',
                'section'  => 'modules',
            ),
            array(
                'id'       => 'enable_learning',
                'title'    => __( 'Learning Hub', 'common-elements-platform' ),
                'desc'     => __( 'Enable learning hub module.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'on',
                'section'  => 'modules',
            ),

            // Appearance Settings
            array(
                'id'       => 'color_scheme',
                'title'    => __( 'Color Scheme', 'common-elements-platform' ),
                'desc'     => __( 'Select a color scheme for the platform.', 'common-elements-platform' ),
                'type'     => 'select',
                'options'  => array(
                    'blue'   => __( 'Blue', 'common-elements-platform' ),
                    'green'  => __( 'Green', 'common-elements-platform' ),
                    'purple' => __( 'Purple', 'common-elements-platform' ),
                    'custom' => __( 'Custom', 'common-elements-platform' ),
                ),
                'default'  => 'blue',
                'section'  => 'appearance',
            ),
            array(
                'id'       => 'primary_color',
                'title'    => __( 'Primary Color', 'common-elements-platform' ),
                'desc'     => __( 'Primary color for buttons and accents.', 'common-elements-platform' ),
                'type'     => 'color',
                'default'  => '#0063CE',
                'section'  => 'appearance',
                'condition' => array(
                    'color_scheme' => 'custom',
                ),
            ),
            array(
                'id'       => 'secondary_color',
                'title'    => __( 'Secondary Color', 'common-elements-platform' ),
                'desc'     => __( 'Secondary color for highlights and accents.', 'common-elements-platform' ),
                'type'     => 'color',
                'default'  => '#FF8A00',
                'section'  => 'appearance',
                'condition' => array(
                    'color_scheme' => 'custom',
                ),
            ),
            array(
                'id'       => 'button_style',
                'title'    => __( 'Button Style', 'common-elements-platform' ),
                'desc'     => __( 'Style for buttons throughout the platform.', 'common-elements-platform' ),
                'type'     => 'select',
                'options'  => array(
                    'rounded'    => __( 'Rounded', 'common-elements-platform' ),
                    'pill'       => __( 'Pill', 'common-elements-platform' ),
                    'square'     => __( 'Square', 'common-elements-platform' ),
                ),
                'default'  => 'rounded',
                'section'  => 'appearance',
            ),
            array(
                'id'       => 'custom_css',
                'title'    => __( 'Custom CSS', 'common-elements-platform' ),
                'desc'     => __( 'Add custom CSS to customize the appearance.', 'common-elements-platform' ),
                'type'     => 'textarea',
                'default'  => '',
                'section'  => 'appearance',
            ),

            // Pages Settings
            array(
                'id'       => 'dashboard_page',
                'title'    => __( 'Dashboard Page', 'common-elements-platform' ),
                'desc'     => __( 'Select the page to use for the dashboard.', 'common-elements-platform' ),
                'type'     => 'page',
                'default'  => '',
                'section'  => 'pages',
            ),
            array(
                'id'       => 'rfp_page',
                'title'    => __( 'RFP System Page', 'common-elements-platform' ),
                'desc'     => __( 'Select the page to use for the RFP system.', 'common-elements-platform' ),
                'type'     => 'page',
                'default'  => '',
                'section'  => 'pages',
            ),
            array(
                'id'       => 'directory_page',
                'title'    => __( 'Directory Page', 'common-elements-platform' ),
                'desc'     => __( 'Select the page to use for the directory.', 'common-elements-platform' ),
                'type'     => 'page',
                'default'  => '',
                'section'  => 'pages',
            ),
            array(
                'id'       => 'forum_page',
                'title'    => __( 'Forums Page', 'common-elements-platform' ),
                'desc'     => __( 'Select the page to use for the forums.', 'common-elements-platform' ),
                'type'     => 'page',
                'default'  => '',
                'section'  => 'pages',
            ),
            array(
                'id'       => 'learning_page',
                'title'    => __( 'Learning Hub Page', 'common-elements-platform' ),
                'desc'     => __( 'Select the page to use for the learning hub.', 'common-elements-platform' ),
                'type'     => 'page',
                'default'  => '',
                'section'  => 'pages',
            ),

            // Integration Settings
            array(
                'id'       => 'ga_id',
                'title'    => __( 'Google Analytics ID', 'common-elements-platform' ),
                'desc'     => __( 'Your Google Analytics tracking ID (e.g., UA-XXXXX-Y).', 'common-elements-platform' ),
                'type'     => 'text',
                'default'  => '',
                'section'  => 'integrations',
            ),
            array(
                'id'       => 'mailchimp_api',
                'title'    => __( 'Mailchimp API Key', 'common-elements-platform' ),
                'desc'     => __( 'Your Mailchimp API key for newsletter integration.', 'common-elements-platform' ),
                'type'     => 'text',
                'default'  => '',
                'section'  => 'integrations',
            ),
            array(
                'id'       => 'recaptcha_site_key',
                'title'    => __( 'reCAPTCHA Site Key', 'common-elements-platform' ),
                'desc'     => __( 'Google reCAPTCHA site key for form protection.', 'common-elements-platform' ),
                'type'     => 'text',
                'default'  => '',
                'section'  => 'integrations',
            ),
            array(
                'id'       => 'recaptcha_secret_key',
                'title'    => __( 'reCAPTCHA Secret Key', 'common-elements-platform' ),
                'desc'     => __( 'Google reCAPTCHA secret key for form protection.', 'common-elements-platform' ),
                'type'     => 'text',
                'default'  => '',
                'section'  => 'integrations',
            ),

            // Plugin Integrations
            array(
                'id'       => 'enable_memberpress',
                'title'    => __( 'MemberPress Integration', 'common-elements-platform' ),
                'desc'     => __( 'Enable integration with MemberPress for membership functionality.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'off',
                'section'  => 'plugins',
                'condition' => array(
                    'function' => 'class_exists',
                    'args'     => 'MeprOptions',
                ),
            ),
            array(
                'id'       => 'enable_gravityforms',
                'title'    => __( 'Gravity Forms Integration', 'common-elements-platform' ),
                'desc'     => __( 'Enable integration with Gravity Forms for advanced form functionality.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'off',
                'section'  => 'plugins',
                'condition' => array(
                    'function' => 'class_exists',
                    'args'     => 'GFForms',
                ),
            ),
            array(
                'id'       => 'enable_gravityview',
                'title'    => __( 'GravityView Integration', 'common-elements-platform' ),
                'desc'     => __( 'Enable integration with GravityView for displaying form submissions.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'off',
                'section'  => 'plugins',
                'condition' => array(
                    'function' => 'class_exists',
                    'args'     => 'GravityView_Plugin',
                ),
            ),
            array(
                'id'       => 'enable_gravitycharts',
                'title'    => __( 'GravityCharts Integration', 'common-elements-platform' ),
                'desc'     => __( 'Enable integration with GravityCharts for data visualization.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'off',
                'section'  => 'plugins',
                'condition' => array(
                    'function' => 'class_exists',
                    'args'     => 'GFChart',
                ),
            ),
            array(
                'id'       => 'enable_geodirectory',
                'title'    => __( 'GeoDirectory Integration', 'common-elements-platform' ),
                'desc'     => __( 'Enable integration with GeoDirectory for location-based directory features.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'off',
                'section'  => 'plugins',
                'condition' => array(
                    'function' => 'class_exists',
                    'args'     => 'GeoDirectory',
                ),
            ),

            // Advanced Settings
            array(
                'id'       => 'cache_expiration',
                'title'    => __( 'Cache Expiration', 'common-elements-platform' ),
                'desc'     => __( 'Time in seconds before cached data expires.', 'common-elements-platform' ),
                'type'     => 'number',
                'default'  => 3600,
                'section'  => 'advanced',
            ),
            array(
                'id'       => 'debug_mode',
                'title'    => __( 'Debug Mode', 'common-elements-platform' ),
                'desc'     => __( 'Enable debug mode for troubleshooting.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'off',
                'section'  => 'advanced',
            ),
            array(
                'id'       => 'disable_emoji',
                'title'    => __( 'Disable Emoji', 'common-elements-platform' ),
                'desc'     => __( 'Disable WordPress emoji for better performance.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'off',
                'section'  => 'advanced',
            ),
            array(
                'id'       => 'disable_embeds',
                'title'    => __( 'Disable Embeds', 'common-elements-platform' ),
                'desc'     => __( 'Disable WordPress embeds for better performance.', 'common-elements-platform' ),
                'type'     => 'checkbox',
                'default'  => 'off',
                'section'  => 'advanced',
            ),
        );
    }

    /**
     * Register settings.
     *
     * @since 1.0.0
     */
    public function register_settings() {
        register_setting(
            'common_elements_platform_options',
            'common_elements_platform_options',
            array( $this, 'sanitize_settings' )
        );

        // Register sections
        foreach ( $this->sections as $section ) {
            add_settings_section(
                $section['id'],
                $section['title'],
                array( $this, 'section_callback' ),
                'common_elements_platform_settings'
            );
        }

        // Register fields
        foreach ( $this->fields as $field ) {
            // Skip fields with conditions that aren't met
            if ( isset( $field['condition'] ) ) {
                if ( isset( $field['condition']['function'] ) && isset( $field['condition']['args'] ) ) {
                    $function = $field['condition']['function'];
                    $args = $field['condition']['args'];
                    if ( ! call_user_func( $function, $args ) ) {
                        continue;
                    }
                } elseif ( isset( $field['condition']['key'] ) && isset( $field['condition']['value'] ) ) {
                    $key = $field['condition']['key'];
                    $value = $field['condition']['value'];
                    if ( $this->get_option( $key ) !== $value ) {
                        continue;
                    }
                }
            }

            add_settings_field(
                $field['id'],
                $field['title'],
                array( $this, 'field_callback' ),
                'common_elements_platform_settings',
                $this->sections[$field['section']]['id'],
                $field
            );
        }
    }

    /**
     * Section callback.
     *
     * @since 1.0.0
     * @param array $args The section arguments.
     */
    public function section_callback( $args ) {
        $section_id = $args['id'];
        foreach ( $this->sections as $section ) {
            if ( $section['id'] === $section_id ) {
                echo '<p>' . esc_html( $section['desc'] ) . '</p>';
                break;
            }
        }
    }

    /**
     * Field callback.
     *
     * @since 1.0.0
     * @param array $args The field arguments.
     */
    public function field_callback( $args ) {
        $id = $args['id'];
        $type = $args['type'];
        $desc = isset( $args['desc'] ) ? $args['desc'] : '';
        $default = isset( $args['default'] ) ? $args['default'] : '';
        $value = $this->get_option( $id, $default );

        switch ( $type ) {
            case 'text':
            case 'email':
            case 'url':
            case 'number':
                echo '<input type="' . esc_attr( $type ) . '" id="' . esc_attr( $id ) . '" name="common_elements_platform_options[' . esc_attr( $id ) . ']" value="' . esc_attr( $value ) . '" class="regular-text">';
                break;

            case 'textarea':
                echo '<textarea id="' . esc_attr( $id ) . '" name="common_elements_platform_options[' . esc_attr( $id ) . ']" rows="5" cols="50" class="large-text">' . esc_textarea( $value ) . '</textarea>';
                break;

            case 'checkbox':
                $checked = checked( $value, 'on', false );
                echo '<label for="' . esc_attr( $id ) . '">';
                echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="common_elements_platform_options[' . esc_attr( $id ) . ']" value="on" ' . $checked . '>';
                echo '</label>';
                break;

            case 'select':
                echo '<select id="' . esc_attr( $id ) . '" name="common_elements_platform_options[' . esc_attr( $id ) . ']" class="regular-text">';
                foreach ( $args['options'] as $option_value => $option_label ) {
                    $selected = selected( $value, $option_value, false );
                    echo '<option value="' . esc_attr( $option_value ) . '" ' . $selected . '>' . esc_html( $option_label ) . '</option>';
                }
                echo '</select>';
                break;

            case 'color':
                echo '<input type="text" id="' . esc_attr( $id ) . '" name="common_elements_platform_options[' . esc_attr( $id ) . ']" value="' . esc_attr( $value ) . '" class="color-picker">';
                break;

            case 'image':
                echo '<div class="image-upload-field">';
                echo '<input type="text" id="' . esc_attr( $id ) . '" name="common_elements_platform_options[' . esc_attr( $id ) . ']" value="' . esc_attr( $value ) . '" class="regular-text">';
                echo '<button class="button image-upload-button" data-target="' . esc_attr( $id ) . '">' . __( 'Select Image', 'common-elements-platform' ) . '</button>';
                if ( ! empty( $value ) ) {
                    echo '<div class="image-preview"><img src="' . esc_url( $value ) . '" alt=""></div>';
                }
                echo '</div>';
                break;

            case 'page':
                $pages = get_pages();
                echo '<select id="' . esc_attr( $id ) . '" name="common_elements_platform_options[' . esc_attr( $id ) . ']" class="regular-text">';
                echo '<option value="">' . __( '-- Select Page --', 'common-elements-platform' ) . '</option>';
                foreach ( $pages as $page ) {
                    $selected = selected( $value, $page->ID, false );
                    echo '<option value="' . esc_attr( $page->ID ) . '" ' . $selected . '>' . esc_html( $page->post_title ) . '</option>';
                }
                echo '</select>';
                break;
        }

        if ( ! empty( $desc ) ) {
            echo '<p class="description">' . esc_html( $desc ) . '</p>';
        }
    }

    /**
     * Sanitize settings.
     *
     * @since 1.0.0
     * @param array $input The input to sanitize.
     * @return array The sanitized input.
     */
    public function sanitize_settings( $input ) {
        $new_input = array();

        foreach ( $this->fields as $field ) {
            $id = $field['id'];
            $type = $field['type'];

            if ( ! isset( $input[$id] ) ) {
                if ( $type === 'checkbox' ) {
                    $new_input[$id] = 'off';
                }
                continue;
            }

            switch ( $type ) {
                case 'text':
                    $new_input[$id] = sanitize_text_field( $input[$id] );
                    break;

                case 'email':
                    $new_input[$id] = sanitize_email( $input[$id] );
                    break;

                case 'url':
                case 'image':
                    $new_input[$id] = esc_url_raw( $input[$id] );
                    break;

                case 'number':
                    $new_input[$id] = intval( $input[$id] );
                    break;

                case 'textarea':
                    $new_input[$id] = sanitize_textarea_field( $input[$id] );
                    break;

                case 'checkbox':
                    $new_input[$id] = ( $input[$id] === 'on' ) ? 'on' : 'off';
                    break;

                case 'select':
                case 'page':
                    $new_input[$id] = sanitize_text_field( $input[$id] );
                    break;

                case 'color':
                    $new_input[$id] = sanitize_hex_color( $input[$id] );
                    break;

                default:
                    $new_input[$id] = sanitize_text_field( $input[$id] );
                    break;
            }
        }

        return $new_input;
    }

    /**
     * Get option value.
     *
     * @since 1.0.0
     * @param string $key     The option key.
     * @param mixed  $default The default value.
     * @return mixed The option value.
     */
    public function get_option( $key, $default = false ) {
        if ( isset( $this->options[$key] ) ) {
            return $this->options[$key];
        }
        return $default;
    }

    /**
     * Get all options.
     *
     * @since 1.0.0
     * @return array The options.
     */
    public function get_options() {
        return $this->options;
    }

    /**
     * Get settings sections.
     *
     * @since 1.0.0
     * @return array The settings sections.
     */
    public function get_sections() {
        return $this->sections;
    }

    /**
     * Get settings fields.
     *
     * @since 1.0.0
     * @return array The settings fields.
     */
    public function get_fields() {
        return $this->fields;
    }

    /**
     * Enqueue scripts and styles.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );

        wp_enqueue_script(
            'common-elements-platform-settings',
            plugin_dir_url( __FILE__ ) . '../admin/js/common-elements-platform-settings.js',
            array( 'jquery', 'wp-color-picker' ),
            COMMON_ELEMENTS_PLATFORM_VERSION,
            true
        );
    }

    /**
     * Render settings page.
     *
     * @since 1.0.0
     */
    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Get current tab
        $current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general';

        // Get sections for tabs
        $tabs = array();
        foreach ( $this->sections as $section_id => $section ) {
            $tabs[$section_id] = $section;
        }

        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

            <h2 class="nav-tab-wrapper">
                <?php foreach ( $tabs as $tab_id => $tab ) : ?>
                    <a href="?page=common-elements-platform-settings&tab=<?php echo esc_attr( $tab_id ); ?>" class="nav-tab <?php echo $current_tab === $tab_id ? 'nav-tab-active' : ''; ?>">
                        <span class="dashicons <?php echo esc_attr( $tab['icon'] ); ?>"></span>
                        <?php echo esc_html( $tab['title'] ); ?>
                    </a>
                <?php endforeach; ?>
            </h2>

            <form action="options.php" method="post">
                <?php
                settings_fields( 'common_elements_platform_options' );
                
                // Only show sections for current tab
                foreach ( $this->sections as $section_id => $section ) {
                    if ( $section_id === $current_tab ) {
                        do_settings_sections( 'common_elements_platform_settings' );
                        break;
                    }
                }
                
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
