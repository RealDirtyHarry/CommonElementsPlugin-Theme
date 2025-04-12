<?php
/**
 * Card Layout Customization Class
 *
 * Provides functionality to customize card layouts throughout the theme
 * including number of cards per row, rows per page, and fields displayed.
 *
 * @package CommonElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Common_Elements_Card_Customizer {

    /**
     * Instance of this class.
     *
     * @since 1.0.0
     * @var object
     */
    protected static $instance = null;

    /**
     * Default settings for card layouts
     *
     * @since 1.0.0
     * @var array
     */
    private $defaults = array(
        'directory' => array(
            'cards_per_row' => 3,
            'rows_per_page' => 3,
            'total_per_page' => 9,
            'fields' => array(
                'image' => true,
                'title' => true,
                'category' => true,
                'description' => true,
                'contact' => true,
                'rating' => true,
                'location' => true,
                'meta' => true,
            ),
        ),
        'classifieds' => array(
            'cards_per_row' => 3,
            'rows_per_page' => 4,
            'total_per_page' => 12,
            'fields' => array(
                'image' => true,
                'title' => true,
                'category' => true,
                'price' => true,
                'description' => true,
                'contact' => true,
                'location' => true,
                'date' => true,
            ),
        ),
        'rfp' => array(
            'cards_per_row' => 2,
            'rows_per_page' => 4,
            'total_per_page' => 8,
            'fields' => array(
                'image' => true,
                'title' => true,
                'category' => true,
                'budget' => true,
                'due_date' => true,
                'description' => true,
                'organization' => true,
                'posted_date' => true,
            ),
        ),
        'jobs' => array(
            'cards_per_row' => 2,
            'rows_per_page' => 4,
            'total_per_page' => 8,
            'fields' => array(
                'image' => true,
                'title' => true,
                'job_type' => true,
                'salary' => true,
                'company' => true,
                'description' => true,
                'requirements' => true,
                'location' => true,
                'posted_date' => true,
            ),
        ),
        'courses' => array(
            'cards_per_row' => 3,
            'rows_per_page' => 3,
            'total_per_page' => 9,
            'fields' => array(
                'image' => true,
                'title' => true,
                'category' => true,
                'instructor' => true,
                'description' => true,
                'duration' => true,
                'lessons' => true,
                'price' => true,
            ),
        ),
    );

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'customize_register', array( $this, 'register_customizer_settings' ) );
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_filter( 'common_elements_card_settings', array( $this, 'get_card_settings' ), 10, 2 );
        add_shortcode( 'common_elements_cards', array( $this, 'cards_shortcode' ) );
    }

    /**
     * Get an instance of this class
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialize
     */
    public function init() {
        // Load saved settings or use defaults
        $this->load_settings();
        
        // Add theme support
        add_theme_support( 'common-elements-cards' );
    }

    /**
     * Load settings from database or use defaults
     */
    private function load_settings() {
        foreach ( $this->defaults as $card_type => $default_settings ) {
            $saved_settings = get_option( 'common_elements_' . $card_type . '_card_settings', array() );
            $this->defaults[$card_type] = wp_parse_args( $saved_settings, $default_settings );
        }
    }

    /**
     * Register Customizer settings
     */
    public function register_customizer_settings( $wp_customize ) {
        // Add section for card layouts
        $wp_customize->add_section( 'common_elements_card_layouts', array(
            'title'    => __( 'Card Layouts', 'common-elements' ),
            'priority' => 30,
        ) );

        // Add settings for each card type
        foreach ( $this->defaults as $card_type => $settings ) {
            $this->add_card_customizer_settings( $wp_customize, $card_type, $settings );
        }
    }

    /**
     * Add customizer settings for a specific card type
     */
    private function add_card_customizer_settings( $wp_customize, $card_type, $settings ) {
        $title = ucfirst( $card_type );
        
        // Cards per row
        $wp_customize->add_setting( 'common_elements_' . $card_type . '_cards_per_row', array(
            'default'           => $settings['cards_per_row'],
            'sanitize_callback' => 'absint',
        ) );
        
        $wp_customize->add_control( 'common_elements_' . $card_type . '_cards_per_row', array(
            'label'       => sprintf( __( '%s Cards Per Row', 'common-elements' ), $title ),
            'description' => __( 'Number of cards to display per row', 'common-elements' ),
            'section'     => 'common_elements_card_layouts',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 1,
                'max'  => 6,
                'step' => 1,
            ),
        ) );
        
        // Total per page
        $wp_customize->add_setting( 'common_elements_' . $card_type . '_total_per_page', array(
            'default'           => $settings['total_per_page'],
            'sanitize_callback' => 'absint',
        ) );
        
        $wp_customize->add_control( 'common_elements_' . $card_type . '_total_per_page', array(
            'label'       => sprintf( __( '%s Cards Per Page', 'common-elements' ), $title ),
            'description' => __( 'Total number of cards to display per page', 'common-elements' ),
            'section'     => 'common_elements_card_layouts',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 1,
                'max'  => 100,
                'step' => 1,
            ),
        ) );
    }

    /**
     * Add admin menu for card customization
     */
    public function add_admin_menu() {
        add_submenu_page(
            'themes.php',
            __( 'Card Layouts', 'common-elements' ),
            __( 'Card Layouts', 'common-elements' ),
            'manage_options',
            'common-elements-cards',
            array( $this, 'admin_page' )
        );
    }

    /**
     * Register settings for admin page
     */
    public function register_settings() {
        foreach ( $this->defaults as $card_type => $settings ) {
            register_setting(
                'common_elements_card_settings',
                'common_elements_' . $card_type . '_card_settings',
                array(
                    'sanitize_callback' => array( $this, 'sanitize_card_settings' ),
                    'default'           => $settings,
                )
            );
        }
    }

    /**
     * Sanitize card settings
     */
    public function sanitize_card_settings( $input ) {
        $sanitized = array();
        
        if ( isset( $input['cards_per_row'] ) ) {
            $sanitized['cards_per_row'] = absint( $input['cards_per_row'] );
        }
        
        if ( isset( $input['rows_per_page'] ) ) {
            $sanitized['rows_per_page'] = absint( $input['rows_per_page'] );
        }
        
        if ( isset( $input['total_per_page'] ) ) {
            $sanitized['total_per_page'] = absint( $input['total_per_page'] );
        }
        
        if ( isset( $input['fields'] ) && is_array( $input['fields'] ) ) {
            $sanitized['fields'] = array();
            foreach ( $input['fields'] as $field => $value ) {
                $sanitized['fields'][$field] = (bool) $value;
            }
        }
        
        return $sanitized;
    }

    /**
     * Admin page for card customization
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__( 'Card Layout Customization', 'common-elements' ); ?></h1>
            
            <form method="post" action="options.php">
                <?php settings_fields( 'common_elements_card_settings' ); ?>
                
                <div class="nav-tab-wrapper">
                    <?php foreach ( $this->defaults as $card_type => $settings ) : ?>
                        <a href="#<?php echo esc_attr( $card_type ); ?>-cards" class="nav-tab"><?php echo esc_html( ucfirst( $card_type ) ); ?></a>
                    <?php endforeach; ?>
                </div>
                
                <?php foreach ( $this->defaults as $card_type => $settings ) : ?>
                    <div id="<?php echo esc_attr( $card_type ); ?>-cards" class="card-settings-tab">
                        <h2><?php echo esc_html( ucfirst( $card_type ) . ' ' . __( 'Card Settings', 'common-elements' ) ); ?></h2>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php echo esc_html__( 'Cards Per Row', 'common-elements' ); ?></th>
                                <td>
                                    <input type="number" name="common_elements_<?php echo esc_attr( $card_type ); ?>_card_settings[cards_per_row]" 
                                           value="<?php echo esc_attr( $settings['cards_per_row'] ); ?>" min="1" max="6" step="1" />
                                    <p class="description"><?php echo esc_html__( 'Number of cards to display in each row', 'common-elements' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo esc_html__( 'Rows Per Page', 'common-elements' ); ?></th>
                                <td>
                                    <input type="number" name="common_elements_<?php echo esc_attr( $card_type ); ?>_card_settings[rows_per_page]" 
                                           value="<?php echo esc_attr( $settings['rows_per_page'] ); ?>" min="1" max="20" step="1" />
                                    <p class="description"><?php echo esc_html__( 'Number of rows to display per page', 'common-elements' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo esc_html__( 'Total Cards Per Page', 'common-elements' ); ?></th>
                                <td>
                                    <input type="number" name="common_elements_<?php echo esc_attr( $card_type ); ?>_card_settings[total_per_page]" 
                                           value="<?php echo esc_attr( $settings['total_per_page'] ); ?>" min="1" max="100" step="1" />
                                    <p class="description"><?php echo esc_html__( 'Total number of cards to display per page', 'common-elements' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo esc_html__( 'Card Fields', 'common-elements' ); ?></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><?php echo esc_html__( 'Card Fields', 'common-elements' ); ?></legend>
                                        <?php foreach ( $settings['fields'] as $field => $enabled ) : ?>
                                            <label>
                                                <input type="checkbox" name="common_elements_<?php echo esc_attr( $card_type ); ?>_card_settings[fields][<?php echo esc_attr( $field ); ?>]" 
                                                       value="1" <?php checked( $enabled ); ?> />
                                                <?php echo esc_html( ucfirst( str_replace( '_', ' ', $field ) ) ); ?>
                                            </label><br>
                                        <?php endforeach; ?>
                                    </fieldset>
                                    <p class="description"><?php echo esc_html__( 'Select which fields to display on each card', 'common-elements' ); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php endforeach; ?>
                
                <?php submit_button(); ?>
            </form>
        </div>
        
        <script>
            jQuery(document).ready(function($) {
                // Tab functionality
                $('.card-settings-tab').hide();
                $('.card-settings-tab:first').show();
                $('.nav-tab:first').addClass('nav-tab-active');
                
                $('.nav-tab').click(function(e) {
                    e.preventDefault();
                    $('.nav-tab').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active');
                    $('.card-settings-tab').hide();
                    $($(this).attr('href')).show();
                });
            });
        </script>
        <?php
    }

    /**
     * Get card settings for a specific card type
     */
    public function get_card_settings( $settings, $card_type ) {
        if ( isset( $this->defaults[$card_type] ) ) {
            return $this->defaults[$card_type];
        }
        return $settings;
    }

    /**
     * Shortcode for displaying cards
     */
    public function cards_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'type'          => 'directory',
            'cards_per_row' => 0,
            'rows_per_page' => 0,
            'total_per_page' => 0,
            'category'      => '',
            'orderby'       => 'date',
            'order'         => 'DESC',
            'fields'        => '',
        ), $atts );
        
        // Get settings for this card type
        $settings = $this->get_card_settings( array(), $atts['type'] );
        
        // Override with shortcode attributes if provided
        if ( $atts['cards_per_row'] > 0 ) {
            $settings['cards_per_row'] = absint( $atts['cards_per_row'] );
        }
        
        if ( $atts['rows_per_page'] > 0 ) {
            $settings['rows_per_page'] = absint( $atts['rows_per_page'] );
        }
        
        if ( $atts['total_per_page'] > 0 ) {
            $settings['total_per_page'] = absint( $atts['total_per_page'] );
        }
        
        if ( ! empty( $atts['fields'] ) ) {
            $custom_fields = explode( ',', $atts['fields'] );
            $fields = array();
            foreach ( $settings['fields'] as $field => $enabled ) {
                $fields[$field] = in_array( $field, $custom_fields );
            }
            $settings['fields'] = $fields;
        }
        
        // Generate the card grid based on settings
        return $this->generate_card_grid( $atts['type'], $settings, $atts );
    }

    /**
     * Generate card grid HTML
     */
    private function generate_card_grid( $card_type, $settings, $query_args = array() ) {
        // This would normally query posts based on card type and generate HTML
        // For now, we'll just return a placeholder
        
        $cards_per_row = $settings['cards_per_row'];
        $total_per_page = $settings['total_per_page'];
        
        $output = '<div class="info-card-grid" data-cards-per-row="' . esc_attr( $cards_per_row ) . '">';
        $output .= '<!-- Card grid for ' . esc_html( $card_type ) . ' with ' . esc_html( $cards_per_row ) . ' cards per row and ' . esc_html( $total_per_page ) . ' total cards -->';
        $output .= '</div>';
        
        return $output;
    }
}

// Initialize the card customizer
Common_Elements_Card_Customizer::get_instance();
