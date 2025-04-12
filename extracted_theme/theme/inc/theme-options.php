<?php
/**
 * Theme options page for Common Elements theme.
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class responsible for theme options.
 */
class Common_Elements_Theme_Options {

    /**
     * The single instance of this class.
     *
     * @var Common_Elements_Theme_Options
     */
    private static $instance = null;

    /**
     * Theme options.
     *
     * @var array
     */
    private $options = array();

    /**
     * Get the single instance of this class.
     *
     * @return Common_Elements_Theme_Options
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
        $this->options = get_option( 'common_elements_theme_options', array() );
        
        add_action( 'admin_menu', array( $this, 'add_theme_options_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ) );
        add_action( 'customize_register', array( $this, 'customize_register' ) );
    }

    /**
     * Add theme options page.
     */
    public function add_theme_options_page() {
        add_theme_page(
            __( 'Theme Options', 'common-elements' ),
            __( 'Theme Options', 'common-elements' ),
            'edit_theme_options',
            'common-elements-theme-options',
            array( $this, 'render_theme_options_page' )
        );
    }

    /**
     * Register settings.
     */
    public function register_settings() {
        register_setting(
            'common_elements_theme_options',
            'common_elements_theme_options',
            array( $this, 'sanitize_options' )
        );

        // General Settings
        add_settings_section(
            'common_elements_general_settings',
            __( 'General Settings', 'common-elements' ),
            array( $this, 'render_general_section' ),
            'common_elements_theme_options'
        );

        add_settings_field(
            'logo',
            __( 'Logo', 'common-elements' ),
            array( $this, 'render_logo_field' ),
            'common_elements_theme_options',
            'common_elements_general_settings'
        );

        add_settings_field(
            'favicon',
            __( 'Favicon', 'common-elements' ),
            array( $this, 'render_favicon_field' ),
            'common_elements_theme_options',
            'common_elements_general_settings'
        );

        // Colors Settings
        add_settings_section(
            'common_elements_colors_settings',
            __( 'Colors', 'common-elements' ),
            array( $this, 'render_colors_section' ),
            'common_elements_theme_options'
        );

        add_settings_field(
            'color_scheme',
            __( 'Color Scheme', 'common-elements' ),
            array( $this, 'render_color_scheme_field' ),
            'common_elements_theme_options',
            'common_elements_colors_settings'
        );

        add_settings_field(
            'custom_colors',
            __( 'Custom Colors', 'common-elements' ),
            array( $this, 'render_custom_colors_field' ),
            'common_elements_theme_options',
            'common_elements_colors_settings'
        );

        // Typography Settings
        add_settings_section(
            'common_elements_typography_settings',
            __( 'Typography', 'common-elements' ),
            array( $this, 'render_typography_section' ),
            'common_elements_theme_options'
        );

        add_settings_field(
            'heading_font',
            __( 'Heading Font', 'common-elements' ),
            array( $this, 'render_heading_font_field' ),
            'common_elements_theme_options',
            'common_elements_typography_settings'
        );

        add_settings_field(
            'body_font',
            __( 'Body Font', 'common-elements' ),
            array( $this, 'render_body_font_field' ),
            'common_elements_theme_options',
            'common_elements_typography_settings'
        );

        // Layout Settings
        add_settings_section(
            'common_elements_layout_settings',
            __( 'Layout', 'common-elements' ),
            array( $this, 'render_layout_section' ),
            'common_elements_theme_options'
        );

        add_settings_field(
            'container_width',
            __( 'Container Width', 'common-elements' ),
            array( $this, 'render_container_width_field' ),
            'common_elements_theme_options',
            'common_elements_layout_settings'
        );

        add_settings_field(
            'sidebar_position',
            __( 'Sidebar Position', 'common-elements' ),
            array( $this, 'render_sidebar_position_field' ),
            'common_elements_theme_options',
            'common_elements_layout_settings'
        );

        // Header Settings
        add_settings_section(
            'common_elements_header_settings',
            __( 'Header', 'common-elements' ),
            array( $this, 'render_header_section' ),
            'common_elements_theme_options'
        );

        add_settings_field(
            'header_layout',
            __( 'Header Layout', 'common-elements' ),
            array( $this, 'render_header_layout_field' ),
            'common_elements_theme_options',
            'common_elements_header_settings'
        );

        add_settings_field(
            'sticky_header',
            __( 'Sticky Header', 'common-elements' ),
            array( $this, 'render_sticky_header_field' ),
            'common_elements_theme_options',
            'common_elements_header_settings'
        );

        // Footer Settings
        add_settings_section(
            'common_elements_footer_settings',
            __( 'Footer', 'common-elements' ),
            array( $this, 'render_footer_section' ),
            'common_elements_theme_options'
        );

        add_settings_field(
            'footer_layout',
            __( 'Footer Layout', 'common-elements' ),
            array( $this, 'render_footer_layout_field' ),
            'common_elements_theme_options',
            'common_elements_footer_settings'
        );

        add_settings_field(
            'footer_copyright',
            __( 'Footer Copyright', 'common-elements' ),
            array( $this, 'render_footer_copyright_field' ),
            'common_elements_theme_options',
            'common_elements_footer_settings'
        );

        // Advanced Settings
        add_settings_section(
            'common_elements_advanced_settings',
            __( 'Advanced', 'common-elements' ),
            array( $this, 'render_advanced_section' ),
            'common_elements_theme_options'
        );

        add_settings_field(
            'custom_css',
            __( 'Custom CSS', 'common-elements' ),
            array( $this, 'render_custom_css_field' ),
            'common_elements_theme_options',
            'common_elements_advanced_settings'
        );

        add_settings_field(
            'custom_js',
            __( 'Custom JavaScript', 'common-elements' ),
            array( $this, 'render_custom_js_field' ),
            'common_elements_theme_options',
            'common_elements_advanced_settings'
        );
    }

    /**
     * Sanitize options.
     *
     * @param array $input The input options.
     * @return array The sanitized options.
     */
    public function sanitize_options( $input ) {
        $sanitized = array();

        // General Settings
        if ( isset( $input['logo'] ) ) {
            $sanitized['logo'] = esc_url_raw( $input['logo'] );
        }

        if ( isset( $input['favicon'] ) ) {
            $sanitized['favicon'] = esc_url_raw( $input['favicon'] );
        }

        // Colors Settings
        if ( isset( $input['color_scheme'] ) ) {
            $sanitized['color_scheme'] = sanitize_text_field( $input['color_scheme'] );
        }

        if ( isset( $input['primary_color'] ) ) {
            $sanitized['primary_color'] = sanitize_hex_color( $input['primary_color'] );
        }

        if ( isset( $input['secondary_color'] ) ) {
            $sanitized['secondary_color'] = sanitize_hex_color( $input['secondary_color'] );
        }

        // Typography Settings
        if ( isset( $input['heading_font'] ) ) {
            $sanitized['heading_font'] = sanitize_text_field( $input['heading_font'] );
        }

        if ( isset( $input['body_font'] ) ) {
            $sanitized['body_font'] = sanitize_text_field( $input['body_font'] );
        }

        // Layout Settings
        if ( isset( $input['container_width'] ) ) {
            $sanitized['container_width'] = absint( $input['container_width'] );
        }

        if ( isset( $input['sidebar_position'] ) ) {
            $sanitized['sidebar_position'] = sanitize_text_field( $input['sidebar_position'] );
        }

        // Header Settings
        if ( isset( $input['header_layout'] ) ) {
            $sanitized['header_layout'] = sanitize_text_field( $input['header_layout'] );
        }

        if ( isset( $input['sticky_header'] ) ) {
            $sanitized['sticky_header'] = ( $input['sticky_header'] === 'on' ) ? 'on' : 'off';
        }

        // Footer Settings
        if ( isset( $input['footer_layout'] ) ) {
            $sanitized['footer_layout'] = sanitize_text_field( $input['footer_layout'] );
        }

        if ( isset( $input['footer_copyright'] ) ) {
            $sanitized['footer_copyright'] = wp_kses_post( $input['footer_copyright'] );
        }

        // Advanced Settings
        if ( isset( $input['custom_css'] ) ) {
            $sanitized['custom_css'] = wp_strip_all_tags( $input['custom_css'] );
        }

        if ( isset( $input['custom_js'] ) ) {
            $sanitized['custom_js'] = wp_strip_all_tags( $input['custom_js'] );
        }

        return $sanitized;
    }

    /**
     * Enqueue admin scripts.
     *
     * @param string $hook The current admin page.
     */
    public function enqueue_admin_scripts( $hook ) {
        if ( 'appearance_page_common-elements-theme-options' !== $hook ) {
            return;
        }

        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );

        wp_enqueue_script(
            'common-elements-theme-options',
            get_template_directory_uri() . '/assets/js/theme-options.js',
            array( 'jquery', 'wp-color-picker' ),
            COMMON_ELEMENTS_THEME_VERSION,
            true
        );

        wp_enqueue_style(
            'common-elements-theme-options',
            get_template_directory_uri() . '/assets/css/theme-options.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );
    }

    /**
     * Enqueue frontend scripts.
     */
    public function enqueue_frontend_scripts() {
        // Enqueue Google Fonts
        $heading_font = $this->get_option( 'heading_font', 'Inter' );
        $body_font = $this->get_option( 'body_font', 'Open Sans' );
        
        $google_fonts_url = $this->get_google_fonts_url( $heading_font, $body_font );
        
        if ( $google_fonts_url ) {
            wp_enqueue_style(
                'common-elements-google-fonts',
                $google_fonts_url,
                array(),
                COMMON_ELEMENTS_THEME_VERSION
            );
        }

        // Enqueue color scheme CSS
        $color_scheme = $this->get_option( 'color_scheme', 'blue' );
        
        wp_enqueue_style(
            'common-elements-variables',
            get_template_directory_uri() . '/assets/css/variables.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );

        // Add inline CSS for custom colors if using custom color scheme
        if ( 'custom' === $color_scheme ) {
            $primary_color = $this->get_option( 'primary_color', '#0063CE' );
            $secondary_color = $this->get_option( 'secondary_color', '#FF8A00' );
            
            $custom_css = "
                :root {
                    --primary-color: {$primary_color};
                    --primary-dark: " . $this->adjust_brightness( $primary_color, -20 ) . ";
                    --primary-light: " . $this->adjust_brightness( $primary_color, 20 ) . ";
                    
                    --secondary-color: {$secondary_color};
                    --secondary-dark: " . $this->adjust_brightness( $secondary_color, -20 ) . ";
                    --secondary-light: " . $this->adjust_brightness( $secondary_color, 20 ) . ";
                }
            ";
            
            wp_add_inline_style( 'common-elements-variables', $custom_css );
        } else {
            // Add color scheme class to body
            add_filter( 'body_class', function( $classes ) use ( $color_scheme ) {
                $classes[] = 'color-scheme-' . $color_scheme;
                return $classes;
            } );
        }

        // Add custom CSS
        $custom_css = $this->get_option( 'custom_css', '' );
        
        if ( ! empty( $custom_css ) ) {
            wp_add_inline_style( 'common-elements-variables', $custom_css );
        }

        // Add custom JavaScript
        $custom_js = $this->get_option( 'custom_js', '' );
        
        if ( ! empty( $custom_js ) ) {
            wp_add_inline_script( 'jquery', $custom_js );
        }
    }

    /**
     * Register customizer settings.
     *
     * @param WP_Customize_Manager $wp_customize The customizer object.
     */
    public function customize_register( $wp_customize ) {
        // Add Theme Options section
        $wp_customize->add_section( 'common_elements_theme_options', array(
            'title'    => __( 'Theme Options', 'common-elements' ),
            'priority' => 30,
        ) );

        // Add Color Scheme setting
        $wp_customize->add_setting( 'common_elements_theme_options[color_scheme]', array(
            'default'           => 'blue',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'common_elements_color_scheme', array(
            'label'    => __( 'Color Scheme', 'common-elements' ),
            'section'  => 'common_elements_theme_options',
            'settings' => 'common_elements_theme_options[color_scheme]',
            'type'     => 'select',
            'choices'  => array(
                'blue'   => __( 'Blue', 'common-elements' ),
                'green'  => __( 'Green', 'common-elements' ),
                'purple' => __( 'Purple', 'common-elements' ),
                'red'    => __( 'Red', 'common-elements' ),
                'teal'   => __( 'Teal', 'common-elements' ),
                'custom' => __( 'Custom', 'common-elements' ),
            ),
        ) );

        // Add Primary Color setting
        $wp_customize->add_setting( 'common_elements_theme_options[primary_color]', array(
            'default'           => '#0063CE',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'common_elements_primary_color', array(
            'label'    => __( 'Primary Color', 'common-elements' ),
            'section'  => 'common_elements_theme_options',
            'settings' => 'common_elements_theme_options[primary_color]',
        ) ) );

        // Add Secondary Color setting
        $wp_customize->add_setting( 'common_elements_theme_options[secondary_color]', array(
            'default'           => '#FF8A00',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'common_elements_secondary_color', array(
            'label'    => __( 'Secondary Color', 'common-elements' ),
            'section'  => 'common_elements_theme_options',
            'settings' => 'common_elements_theme_options[secondary_color]',
        ) ) );

        // Add Container Width setting
        $wp_customize->add_setting( 'common_elements_theme_options[container_width]', array(
            'default'           => 1280,
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'absint',
        ) );

        $wp_customize->add_control( 'common_elements_container_width', array(
            'label'    => __( 'Container Width (px)', 'common-elements' ),
            'section'  => 'common_elements_theme_options',
            'settings' => 'common_elements_theme_options[container_width]',
            'type'     => 'number',
            'input_attrs' => array(
                'min'  => 960,
                'max'  => 1920,
                'step' => 10,
            ),
        ) );

        // Add Sidebar Position setting
        $wp_customize->add_setting( 'common_elements_theme_options[sidebar_position]', array(
            'default'           => 'right',
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'common_elements_sidebar_position', array(
            'label'    => __( 'Sidebar Position', 'common-elements' ),
            'section'  => 'common_elements_theme_options',
            'settings' => 'common_elements_theme_options[sidebar_position]',
            'type'     => 'select',
            'choices'  => array(
                'left'  => __( 'Left', 'common-elements' ),
                'right' => __( 'Right', 'common-elements' ),
                'none'  => __( 'None', 'common-elements' ),
            ),
        ) );
    }

    /**
     * Render theme options page.
     */
    public function render_theme_options_page() {
        if ( ! current_user_can( 'edit_theme_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'common-elements' ) );
        }

        // Get current tab
        $current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'general';

        // Define tabs
        $tabs = array(
            'general'    => __( 'General', 'common-elements' ),
            'colors'     => __( 'Colors', 'common-elements' ),
            'typography' => __( 'Typography', 'common-elements' ),
            'layout'     => __( 'Layout', 'common-elements' ),
            'header'     => __( 'Header', 'common-elements' ),
            'footer'     => __( 'Footer', 'common-elements' ),
            'advanced'   => __( 'Advanced', 'common-elements' ),
        );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

            <h2 class="nav-tab-wrapper">
                <?php foreach ( $tabs as $tab_id => $tab_name ) : ?>
                    <a href="?page=common-elements-theme-options&tab=<?php echo esc_attr( $tab_id ); ?>" class="nav-tab <?php echo $current_tab === $tab_id ? 'nav-tab-active' : ''; ?>">
                        <?php echo esc_html( $tab_name ); ?>
                    </a>
                <?php endforeach; ?>
            </h2>

            <form method="post" action="options.php">
                <?php
                settings_fields( 'common_elements_theme_options' );
                
                // Only show sections for current tab
                switch ( $current_tab ) {
                    case 'general':
                        do_settings_sections( 'common_elements_theme_options' );
                        break;
                    case 'colors':
                        $this->render_colors_tab();
                        break;
                    case 'typography':
                        $this->render_typography_tab();
                        break;
                    case 'layout':
                        $this->render_layout_tab();
                        break;
                    case 'header':
                        $this->render_header_tab();
                        break;
                    case 'footer':
                        $this->render_footer_tab();
                        break;
                    case 'advanced':
                        $this->render_advanced_tab();
                        break;
                }
                
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Render general section.
     */
    public function render_general_section() {
        echo '<p>' . esc_html__( 'Configure general theme settings.', 'common-elements' ) . '</p>';
    }

    /**
     * Render logo field.
     */
    public function render_logo_field() {
        $logo = $this->get_option( 'logo', '' );
        ?>
        <div class="image-upload-field">
            <input type="text" id="common_elements_logo" name="common_elements_theme_options[logo]" value="<?php echo esc_attr( $logo ); ?>" class="regular-text">
            <button type="button" class="button image-upload-button" data-target="common_elements_logo"><?php esc_html_e( 'Select Image', 'common-elements' ); ?></button>
            <?php if ( ! empty( $logo ) ) : ?>
                <div class="image-preview">
                    <img src="<?php echo esc_url( $logo ); ?>" alt="">
                </div>
            <?php endif; ?>
        </div>
        <p class="description"><?php esc_html_e( 'Upload or select your site logo.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render favicon field.
     */
    public function render_favicon_field() {
        $favicon = $this->get_option( 'favicon', '' );
        ?>
        <div class="image-upload-field">
            <input type="text" id="common_elements_favicon" name="common_elements_theme_options[favicon]" value="<?php echo esc_attr( $favicon ); ?>" class="regular-text">
            <button type="button" class="button image-upload-button" data-target="common_elements_favicon"><?php esc_html_e( 'Select Image', 'common-elements' ); ?></button>
            <?php if ( ! empty( $favicon ) ) : ?>
                <div class="image-preview">
                    <img src="<?php echo esc_url( $favicon ); ?>" alt="">
                </div>
            <?php endif; ?>
        </div>
        <p class="description"><?php esc_html_e( 'Upload or select your site favicon (recommended size: 32x32px).', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render colors section.
     */
    public function render_colors_section() {
        echo '<p>' . esc_html__( 'Customize the color scheme of your site.', 'common-elements' ) . '</p>';
    }

    /**
     * Render color scheme field.
     */
    public function render_color_scheme_field() {
        $color_scheme = $this->get_option( 'color_scheme', 'blue' );
        ?>
        <select id="common_elements_color_scheme" name="common_elements_theme_options[color_scheme]">
            <option value="blue" <?php selected( $color_scheme, 'blue' ); ?>><?php esc_html_e( 'Blue', 'common-elements' ); ?></option>
            <option value="green" <?php selected( $color_scheme, 'green' ); ?>><?php esc_html_e( 'Green', 'common-elements' ); ?></option>
            <option value="purple" <?php selected( $color_scheme, 'purple' ); ?>><?php esc_html_e( 'Purple', 'common-elements' ); ?></option>
            <option value="red" <?php selected( $color_scheme, 'red' ); ?>><?php esc_html_e( 'Red', 'common-elements' ); ?></option>
            <option value="teal" <?php selected( $color_scheme, 'teal' ); ?>><?php esc_html_e( 'Teal', 'common-elements' ); ?></option>
            <option value="custom" <?php selected( $color_scheme, 'custom' ); ?>><?php esc_html_e( 'Custom', 'common-elements' ); ?></option>
        </select>
        <p class="description"><?php esc_html_e( 'Select a predefined color scheme or choose "Custom" to define your own colors.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render custom colors field.
     */
    public function render_custom_colors_field() {
        $primary_color = $this->get_option( 'primary_color', '#0063CE' );
        $secondary_color = $this->get_option( 'secondary_color', '#FF8A00' );
        ?>
        <div class="custom-colors-field" data-depends-on="common_elements_color_scheme" data-depends-value="custom">
            <p>
                <label for="common_elements_primary_color"><?php esc_html_e( 'Primary Color', 'common-elements' ); ?></label><br>
                <input type="text" id="common_elements_primary_color" name="common_elements_theme_options[primary_color]" value="<?php echo esc_attr( $primary_color ); ?>" class="color-picker">
            </p>
            <p>
                <label for="common_elements_secondary_color"><?php esc_html_e( 'Secondary Color', 'common-elements' ); ?></label><br>
                <input type="text" id="common_elements_secondary_color" name="common_elements_theme_options[secondary_color]" value="<?php echo esc_attr( $secondary_color ); ?>" class="color-picker">
            </p>
        </div>
        <?php
    }

    /**
     * Render typography section.
     */
    public function render_typography_section() {
        echo '<p>' . esc_html__( 'Customize the typography of your site.', 'common-elements' ) . '</p>';
    }

    /**
     * Render heading font field.
     */
    public function render_heading_font_field() {
        $heading_font = $this->get_option( 'heading_font', 'Inter' );
        $google_fonts = $this->get_google_fonts();
        ?>
        <select id="common_elements_heading_font" name="common_elements_theme_options[heading_font]">
            <?php foreach ( $google_fonts as $font_name ) : ?>
                <option value="<?php echo esc_attr( $font_name ); ?>" <?php selected( $heading_font, $font_name ); ?>><?php echo esc_html( $font_name ); ?></option>
            <?php endforeach; ?>
        </select>
        <p class="description"><?php esc_html_e( 'Select the font for headings.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render body font field.
     */
    public function render_body_font_field() {
        $body_font = $this->get_option( 'body_font', 'Open Sans' );
        $google_fonts = $this->get_google_fonts();
        ?>
        <select id="common_elements_body_font" name="common_elements_theme_options[body_font]">
            <?php foreach ( $google_fonts as $font_name ) : ?>
                <option value="<?php echo esc_attr( $font_name ); ?>" <?php selected( $body_font, $font_name ); ?>><?php echo esc_html( $font_name ); ?></option>
            <?php endforeach; ?>
        </select>
        <p class="description"><?php esc_html_e( 'Select the font for body text.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render layout section.
     */
    public function render_layout_section() {
        echo '<p>' . esc_html__( 'Customize the layout of your site.', 'common-elements' ) . '</p>';
    }

    /**
     * Render container width field.
     */
    public function render_container_width_field() {
        $container_width = $this->get_option( 'container_width', 1280 );
        ?>
        <input type="number" id="common_elements_container_width" name="common_elements_theme_options[container_width]" value="<?php echo esc_attr( $container_width ); ?>" min="960" max="1920" step="10">
        <p class="description"><?php esc_html_e( 'Set the maximum width of the content container in pixels.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render sidebar position field.
     */
    public function render_sidebar_position_field() {
        $sidebar_position = $this->get_option( 'sidebar_position', 'right' );
        ?>
        <select id="common_elements_sidebar_position" name="common_elements_theme_options[sidebar_position]">
            <option value="left" <?php selected( $sidebar_position, 'left' ); ?>><?php esc_html_e( 'Left', 'common-elements' ); ?></option>
            <option value="right" <?php selected( $sidebar_position, 'right' ); ?>><?php esc_html_e( 'Right', 'common-elements' ); ?></option>
            <option value="none" <?php selected( $sidebar_position, 'none' ); ?>><?php esc_html_e( 'None', 'common-elements' ); ?></option>
        </select>
        <p class="description"><?php esc_html_e( 'Select the position of the sidebar.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render header section.
     */
    public function render_header_section() {
        echo '<p>' . esc_html__( 'Customize the header of your site.', 'common-elements' ) . '</p>';
    }

    /**
     * Render header layout field.
     */
    public function render_header_layout_field() {
        $header_layout = $this->get_option( 'header_layout', 'default' );
        ?>
        <select id="common_elements_header_layout" name="common_elements_theme_options[header_layout]">
            <option value="default" <?php selected( $header_layout, 'default' ); ?>><?php esc_html_e( 'Default', 'common-elements' ); ?></option>
            <option value="centered" <?php selected( $header_layout, 'centered' ); ?>><?php esc_html_e( 'Centered', 'common-elements' ); ?></option>
            <option value="split" <?php selected( $header_layout, 'split' ); ?>><?php esc_html_e( 'Split', 'common-elements' ); ?></option>
            <option value="minimal" <?php selected( $header_layout, 'minimal' ); ?>><?php esc_html_e( 'Minimal', 'common-elements' ); ?></option>
        </select>
        <p class="description"><?php esc_html_e( 'Select the layout of the header.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render sticky header field.
     */
    public function render_sticky_header_field() {
        $sticky_header = $this->get_option( 'sticky_header', 'off' );
        ?>
        <label for="common_elements_sticky_header">
            <input type="checkbox" id="common_elements_sticky_header" name="common_elements_theme_options[sticky_header]" <?php checked( $sticky_header, 'on' ); ?>>
            <?php esc_html_e( 'Enable sticky header', 'common-elements' ); ?>
        </label>
        <p class="description"><?php esc_html_e( 'Keep the header visible when scrolling down.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render footer section.
     */
    public function render_footer_section() {
        echo '<p>' . esc_html__( 'Customize the footer of your site.', 'common-elements' ) . '</p>';
    }

    /**
     * Render footer layout field.
     */
    public function render_footer_layout_field() {
        $footer_layout = $this->get_option( 'footer_layout', 'default' );
        ?>
        <select id="common_elements_footer_layout" name="common_elements_theme_options[footer_layout]">
            <option value="default" <?php selected( $footer_layout, 'default' ); ?>><?php esc_html_e( 'Default', 'common-elements' ); ?></option>
            <option value="centered" <?php selected( $footer_layout, 'centered' ); ?>><?php esc_html_e( 'Centered', 'common-elements' ); ?></option>
            <option value="minimal" <?php selected( $footer_layout, 'minimal' ); ?>><?php esc_html_e( 'Minimal', 'common-elements' ); ?></option>
            <option value="columns" <?php selected( $footer_layout, 'columns' ); ?>><?php esc_html_e( 'Columns', 'common-elements' ); ?></option>
        </select>
        <p class="description"><?php esc_html_e( 'Select the layout of the footer.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render footer copyright field.
     */
    public function render_footer_copyright_field() {
        $footer_copyright = $this->get_option( 'footer_copyright', '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ) . '. All rights reserved.' );
        ?>
        <textarea id="common_elements_footer_copyright" name="common_elements_theme_options[footer_copyright]" rows="3" cols="50"><?php echo esc_textarea( $footer_copyright ); ?></textarea>
        <p class="description"><?php esc_html_e( 'Enter the copyright text for the footer. You can use HTML.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render advanced section.
     */
    public function render_advanced_section() {
        echo '<p>' . esc_html__( 'Advanced settings for the theme.', 'common-elements' ) . '</p>';
    }

    /**
     * Render custom CSS field.
     */
    public function render_custom_css_field() {
        $custom_css = $this->get_option( 'custom_css', '' );
        ?>
        <textarea id="common_elements_custom_css" name="common_elements_theme_options[custom_css]" rows="10" cols="50" class="large-text code"><?php echo esc_textarea( $custom_css ); ?></textarea>
        <p class="description"><?php esc_html_e( 'Add custom CSS to customize the appearance of your site.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render custom JS field.
     */
    public function render_custom_js_field() {
        $custom_js = $this->get_option( 'custom_js', '' );
        ?>
        <textarea id="common_elements_custom_js" name="common_elements_theme_options[custom_js]" rows="10" cols="50" class="large-text code"><?php echo esc_textarea( $custom_js ); ?></textarea>
        <p class="description"><?php esc_html_e( 'Add custom JavaScript to enhance the functionality of your site.', 'common-elements' ); ?></p>
        <?php
    }

    /**
     * Render colors tab.
     */
    public function render_colors_tab() {
        do_settings_sections( 'common_elements_theme_options' );
    }

    /**
     * Render typography tab.
     */
    public function render_typography_tab() {
        do_settings_sections( 'common_elements_theme_options' );
    }

    /**
     * Render layout tab.
     */
    public function render_layout_tab() {
        do_settings_sections( 'common_elements_theme_options' );
    }

    /**
     * Render header tab.
     */
    public function render_header_tab() {
        do_settings_sections( 'common_elements_theme_options' );
    }

    /**
     * Render footer tab.
     */
    public function render_footer_tab() {
        do_settings_sections( 'common_elements_theme_options' );
    }

    /**
     * Render advanced tab.
     */
    public function render_advanced_tab() {
        do_settings_sections( 'common_elements_theme_options' );
    }

    /**
     * Get option value.
     *
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
     * Get Google Fonts URL.
     *
     * @param string $heading_font The heading font.
     * @param string $body_font    The body font.
     * @return string The Google Fonts URL.
     */
    private function get_google_fonts_url( $heading_font, $body_font ) {
        $fonts = array();
        
        if ( 'off' !== $heading_font ) {
            $fonts[] = $heading_font . ':300,400,500,600,700';
        }
        
        if ( 'off' !== $body_font && $body_font !== $heading_font ) {
            $fonts[] = $body_font . ':300,400,500,600,700';
        }
        
        if ( empty( $fonts ) ) {
            return false;
        }
        
        $fonts_url = add_query_arg( array(
            'family' => urlencode( implode( '|', $fonts ) ),
            'display' => 'swap',
        ), 'https://fonts.googleapis.com/css2' );
        
        return $fonts_url;
    }

    /**
     * Get Google Fonts list.
     *
     * @return array The Google Fonts list.
     */
    private function get_google_fonts() {
        return array(
            'Open Sans',
            'Roboto',
            'Lato',
            'Montserrat',
            'Raleway',
            'PT Sans',
            'Source Sans Pro',
            'Oswald',
            'Merriweather',
            'Playfair Display',
            'Ubuntu',
            'Poppins',
            'Nunito',
            'Rubik',
            'Work Sans',
            'Inter',
            'Noto Sans',
            'Quicksand',
            'Fira Sans',
            'Mulish',
        );
    }

    /**
     * Adjust color brightness.
     *
     * @param string $hex   The hex color.
     * @param int    $steps The steps to adjust brightness.
     * @return string The adjusted hex color.
     */
    private function adjust_brightness( $hex, $steps ) {
        // Remove # if present
        $hex = ltrim( $hex, '#' );
        
        // Convert to RGB
        $r = hexdec( substr( $hex, 0, 2 ) );
        $g = hexdec( substr( $hex, 2, 2 ) );
        $b = hexdec( substr( $hex, 4, 2 ) );
        
        // Adjust brightness
        $r = max( 0, min( 255, $r + $steps ) );
        $g = max( 0, min( 255, $g + $steps ) );
        $b = max( 0, min( 255, $b + $steps ) );
        
        // Convert back to hex
        return '#' . sprintf( '%02x%02x%02x', $r, $g, $b );
    }
}

// Initialize the theme options
Common_Elements_Theme_Options::get_instance();
