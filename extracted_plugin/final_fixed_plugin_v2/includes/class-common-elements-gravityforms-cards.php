<?php
/**
 * GravityForms Card Integration Class
 *
 * Provides integration between GravityForms and card layouts
 * allowing form entries to be displayed as customizable cards.
 *
 * @package CommonElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Common_Elements_GravityForms_Cards {

    /**
     * Instance of this class.
     *
     * @since 1.0.0
     * @var object
     */
    protected static $instance = null;

    /**
     * Field mappings for different card types
     *
     * @since 1.0.0
     * @var array
     */
    private $field_mappings = array();

    /**
     * Constructor
     */
    public function __construct() {
        // Only initialize if GravityForms is active
        if ( class_exists( 'GFForms' ) ) {
            add_action( 'init', array( $this, 'init' ) );
            add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 20 );
            add_action( 'admin_init', array( $this, 'register_settings' ) );
            add_shortcode( 'gform_cards', array( $this, 'gform_cards_shortcode' ) );
            add_filter( 'gform_entry_list_columns', array( $this, 'add_card_view_column' ), 10, 2 );
            add_action( 'gform_entry_list_column_card_view', array( $this, 'card_view_column' ), 10, 3 );
            add_action( 'wp_ajax_common_elements_preview_gform_card', array( $this, 'ajax_preview_card' ) );
        }
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
        // Load saved field mappings
        $this->load_field_mappings();
    }

    /**
     * Load field mappings from database
     */
    private function load_field_mappings() {
        $this->field_mappings = get_option( 'common_elements_gform_card_mappings', array() );
    }

    /**
     * Add admin menu for GravityForms card integration
     */
    public function add_admin_menu() {
        add_submenu_page(
            'gf_edit_forms',
            __( 'Card Layouts', 'common-elements' ),
            __( 'Card Layouts', 'common-elements' ),
            'manage_options',
            'common-elements-gform-cards',
            array( $this, 'admin_page' )
        );
    }

    /**
     * Register settings for admin page
     */
    public function register_settings() {
        register_setting(
            'common_elements_gform_card_settings',
            'common_elements_gform_card_mappings',
            array(
                'sanitize_callback' => array( $this, 'sanitize_field_mappings' ),
                'default'           => array(),
            )
        );
    }

    /**
     * Sanitize field mappings
     */
    public function sanitize_field_mappings( $input ) {
        $sanitized = array();
        
        if ( ! is_array( $input ) ) {
            return $sanitized;
        }
        
        foreach ( $input as $form_id => $mapping ) {
            $form_id = absint( $form_id );
            
            if ( ! $form_id ) {
                continue;
            }
            
            $sanitized[$form_id] = array();
            
            if ( isset( $mapping['card_type'] ) ) {
                $sanitized[$form_id]['card_type'] = sanitize_text_field( $mapping['card_type'] );
            }
            
            if ( isset( $mapping['fields'] ) && is_array( $mapping['fields'] ) ) {
                $sanitized[$form_id]['fields'] = array();
                
                foreach ( $mapping['fields'] as $card_field => $form_field ) {
                    $sanitized[$form_id]['fields'][sanitize_text_field( $card_field )] = sanitize_text_field( $form_field );
                }
            }
            
            if ( isset( $mapping['display'] ) && is_array( $mapping['display'] ) ) {
                $sanitized[$form_id]['display'] = array();
                
                foreach ( $mapping['display'] as $display_option => $value ) {
                    $sanitized[$form_id]['display'][sanitize_text_field( $display_option )] = (bool) $value;
                }
            }
        }
        
        return $sanitized;
    }

    /**
     * Admin page for GravityForms card integration
     */
    public function admin_page() {
        // Get all GravityForms forms
        $forms = GFAPI::get_forms();
        
        // Get card types from card customizer
        $card_types = array(
            'directory'   => __( 'Directory Listing', 'common-elements' ),
            'classifieds' => __( 'Classified Ad', 'common-elements' ),
            'rfp'         => __( 'RFP', 'common-elements' ),
            'jobs'        => __( 'Job Posting', 'common-elements' ),
            'custom'      => __( 'Custom', 'common-elements' ),
        );
        
        // Card field options
        $card_fields = array(
            'image'       => __( 'Image', 'common-elements' ),
            'title'       => __( 'Title', 'common-elements' ),
            'category'    => __( 'Category', 'common-elements' ),
            'description' => __( 'Description', 'common-elements' ),
            'price'       => __( 'Price', 'common-elements' ),
            'contact'     => __( 'Contact', 'common-elements' ),
            'location'    => __( 'Location', 'common-elements' ),
            'date'        => __( 'Date', 'common-elements' ),
            'meta1'       => __( 'Meta Field 1', 'common-elements' ),
            'meta2'       => __( 'Meta Field 2', 'common-elements' ),
            'meta3'       => __( 'Meta Field 3', 'common-elements' ),
        );
        
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__( 'GravityForms Card Integration', 'common-elements' ); ?></h1>
            
            <p><?php echo esc_html__( 'Map GravityForms fields to card layout fields to display form entries as cards.', 'common-elements' ); ?></p>
            
            <form method="post" action="options.php">
                <?php settings_fields( 'common_elements_gform_card_settings' ); ?>
                
                <div class="nav-tab-wrapper">
                    <?php foreach ( $forms as $form ) : ?>
                        <a href="#form-<?php echo esc_attr( $form['id'] ); ?>" class="nav-tab"><?php echo esc_html( $form['title'] ); ?></a>
                    <?php endforeach; ?>
                </div>
                
                <?php foreach ( $forms as $form ) : 
                    $form_id = $form['id'];
                    $form_fields = GFAPI::get_form_meta( $form_id );
                    $mapping = isset( $this->field_mappings[$form_id] ) ? $this->field_mappings[$form_id] : array();
                    $selected_card_type = isset( $mapping['card_type'] ) ? $mapping['card_type'] : 'directory';
                    $field_mapping = isset( $mapping['fields'] ) ? $mapping['fields'] : array();
                    $display_options = isset( $mapping['display'] ) ? $mapping['display'] : array();
                ?>
                    <div id="form-<?php echo esc_attr( $form_id ); ?>" class="gform-card-settings-tab">
                        <h2><?php echo esc_html( sprintf( __( 'Card Settings for "%s"', 'common-elements' ), $form['title'] ) ); ?></h2>
                        
                        <table class="form-table">
                            <tr>
                                <th scope="row"><?php echo esc_html__( 'Card Type', 'common-elements' ); ?></th>
                                <td>
                                    <select name="common_elements_gform_card_mappings[<?php echo esc_attr( $form_id ); ?>][card_type]">
                                        <?php foreach ( $card_types as $type => $label ) : ?>
                                            <option value="<?php echo esc_attr( $type ); ?>" <?php selected( $selected_card_type, $type ); ?>><?php echo esc_html( $label ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description"><?php echo esc_html__( 'Select which card layout to use for this form', 'common-elements' ); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo esc_html__( 'Field Mapping', 'common-elements' ); ?></th>
                                <td>
                                    <table class="widefat striped">
                                        <thead>
                                            <tr>
                                                <th><?php echo esc_html__( 'Card Field', 'common-elements' ); ?></th>
                                                <th><?php echo esc_html__( 'Form Field', 'common-elements' ); ?></th>
                                                <th><?php echo esc_html__( 'Display', 'common-elements' ); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ( $card_fields as $card_field => $card_field_label ) : 
                                                $selected_form_field = isset( $field_mapping[$card_field] ) ? $field_mapping[$card_field] : '';
                                                $display_field = isset( $display_options[$card_field] ) ? $display_options[$card_field] : true;
                                            ?>
                                                <tr>
                                                    <td><?php echo esc_html( $card_field_label ); ?></td>
                                                    <td>
                                                        <select name="common_elements_gform_card_mappings[<?php echo esc_attr( $form_id ); ?>][fields][<?php echo esc_attr( $card_field ); ?>]">
                                                            <option value=""><?php echo esc_html__( '— Select Field —', 'common-elements' ); ?></option>
                                                            <?php foreach ( $form_fields['fields'] as $field ) : ?>
                                                                <option value="<?php echo esc_attr( $field->id ); ?>" <?php selected( $selected_form_field, $field->id ); ?>>
                                                                    <?php echo esc_html( $field->label ); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="common_elements_gform_card_mappings[<?php echo esc_attr( $form_id ); ?>][display][<?php echo esc_attr( $card_field ); ?>]" value="1" <?php checked( $display_field ); ?> />
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><?php echo esc_html__( 'Preview', 'common-elements' ); ?></th>
                                <td>
                                    <button type="button" class="button preview-card-button" data-form-id="<?php echo esc_attr( $form_id ); ?>">
                                        <?php echo esc_html__( 'Preview Card Layout', 'common-elements' ); ?>
                                    </button>
                                    <div class="card-preview-container" id="preview-<?php echo esc_attr( $form_id ); ?>"></div>
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
                $('.gform-card-settings-tab').hide();
                $('.gform-card-settings-tab:first').show();
                $('.nav-tab:first').addClass('nav-tab-active');
                
                $('.nav-tab').click(function(e) {
                    e.preventDefault();
                    $('.nav-tab').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active');
                    $('.gform-card-settings-tab').hide();
                    $($(this).attr('href')).show();
                });
                
                // Preview functionality
                $('.preview-card-button').click(function() {
                    var formId = $(this).data('form-id');
                    var previewContainer = $('#preview-' + formId);
                    
                    previewContainer.html('<p><?php echo esc_js( __( 'Loading preview...', 'common-elements' ) ); ?></p>');
                    
                    // Collect current form data
                    var formData = {
                        form_id: formId,
                        card_type: $('select[name="common_elements_gform_card_mappings[' + formId + '][card_type]"]').val(),
                        fields: {},
                        display: {}
                    };
                    
                    // Get field mappings
                    $('select[name^="common_elements_gform_card_mappings[' + formId + '][fields]"]').each(function() {
                        var fieldName = $(this).attr('name').match(/\[fields\]\[(.*?)\]/)[1];
                        formData.fields[fieldName] = $(this).val();
                    });
                    
                    // Get display options
                    $('input[name^="common_elements_gform_card_mappings[' + formId + '][display]"]').each(function() {
                        var fieldName = $(this).attr('name').match(/\[display\]\[(.*?)\]/)[1];
                        formData.display[fieldName] = $(this).is(':checked');
                    });
                    
                    // Send AJAX request
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'common_elements_preview_gform_card',
                            nonce: '<?php echo wp_create_nonce( 'common_elements_preview_card' ); ?>',
                            form_data: formData
                        },
                        success: function(response) {
                            if (response.success) {
                                previewContainer.html(response.data.html);
                            } else {
                                previewContainer.html('<p class="error">' + response.data.message + '</p>');
                            }
                        },
                        error: function() {
                            previewContainer.html('<p class="error"><?php echo esc_js( __( 'Error loading preview', 'common-elements' ) ); ?></p>');
                        }
                    });
                });
            });
        </script>
        <style>
            .card-preview-container {
                margin-top: 15px;
                padding: 15px;
                background: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 3px;
            }
        </style>
        <?php
    }

    /**
     * AJAX handler for card preview
     */
    public function ajax_preview_card() {
        // Check nonce
        if ( ! check_ajax_referer( 'common_elements_preview_card', 'nonce', false ) ) {
            wp_send_json_error( array( 'message' => __( 'Security check failed', 'common-elements' ) ) );
        }
        
        // Get form data
        $form_data = isset( $_POST['form_data'] ) ? $_POST['form_data'] : array();
        
        if ( empty( $form_data['form_id'] ) ) {
            wp_send_json_error( array( 'message' => __( 'Invalid form ID', 'common-elements' ) ) );
        }
        
        // Get a sample entry
        $entries = GFAPI::get_entries( $form_data['form_id'], array(), array(), array( 'offset' => 0, 'page_size' => 1 ) );
        
        if ( empty( $entries ) ) {
            wp_send_json_error( array( 'message' => __( 'No entries found for this form. Create at least one entry to preview the card layout.', 'common-elements' ) ) );
        }
        
        // Generate preview HTML
        $html = $this->generate_card_preview( $entries[0], $form_data );
        
        wp_send_json_success( array( 'html' => $html ) );
    }

    /**
     * Generate card preview HTML
     */
    private function generate_card_preview( $entry, $form_data ) {
        $form = GFAPI::get_form( $entry['form_id'] );
        $card_type = $form_data['card_type'];
        $fields = $form_data['fields'];
        $display = $form_data['display'];
        
        // Get field values
        $card_values = array();
        foreach ( $fields as $card_field => $form_field ) {
            if ( ! empty( $form_field ) && isset( $entry[$form_field] ) ) {
                $card_values[$card_field] = $entry[$form_field];
            } else {
                $card_values[$card_field] = '';
            }
        }
        
        // Generate card HTML
        $html = '<div class="info-card">';
        
        // Image
        if ( ! empty( $card_values['image'] ) && ! empty( $display['image'] ) ) {
            $html .= '<div class="info-card-image">';
            $html .= '<img src="' . esc_url( $card_values['image'] ) . '" alt="' . esc_attr( $card_values['title'] ) . '">';
            $html .= '</div>';
        }
        
        $html .= '<div class="info-card-content">';
        
        // Title and category
        $html .= '<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-sm);">';
        if ( ! empty( $card_values['title'] ) && ! empty( $display['title'] ) ) {
            $html .= '<h3 class="info-card-title">' . esc_html( $card_values['title'] ) . '</h3>';
        } else {
            $html .= '<h3 class="info-card-title">' . esc_html__( 'Sample Title', 'common-elements' ) . '</h3>';
        }
        
        if ( ! empty( $card_values['category'] ) && ! empty( $display['category'] ) ) {
            $html .= '<span class="info-card-badge" style="background-color: var(--secondary-color);">' . esc_html( $card_values['category'] ) . '</span>';
        }
        $html .= '</div>';
        
        // Price/meta info
        if ( ( ! empty( $card_values['price'] ) && ! empty( $display['price'] ) ) || 
             ( ! empty( $card_values['location'] ) && ! empty( $display['location'] ) ) ) {
            $html .= '<div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">';
            
            if ( ! empty( $card_values['price'] ) && ! empty( $display['price'] ) ) {
                $html .= '<div style="font-weight: 600; color: var(--secondary-color);">';
                $html .= '<i class="fas fa-dollar-sign" style="margin-right: 4px;"></i> ' . esc_html( $card_values['price'] );
                $html .= '</div>';
            }
            
            if ( ! empty( $card_values['location'] ) && ! empty( $display['location'] ) ) {
                $html .= '<div style="font-weight: 600;">';
                $html .= '<i class="fas fa-map-marker-alt" style="margin-right: 4px; color: var(--secondary-color);"></i> ' . esc_html( $card_values['location'] );
                $html .= '</div>';
            }
            
            $html .= '</div>';
        }
        
        // Description
        if ( ! empty( $card_values['description'] ) && ! empty( $display['description'] ) ) {
            $html .= '<p class="info-card-description">' . esc_html( $card_values['description'] ) . '</p>';
        } else {
            $html .= '<p class="info-card-description">' . esc_html__( 'This is a sample description for the card preview. The actual content will be populated from the form entry.', 'common-elements' ) . '</p>';
        }
        
        // Meta fields
        $html .= '<div class="info-card-meta">';
        
        if ( ! empty( $card_values['meta1'] ) && ! empty( $display['meta1'] ) ) {
            $html .= '<span><i class="fas fa-info-circle" style="color: var(--secondary-color);"></i> ' . esc_html( $card_values['meta1'] ) . '</span>';
        }
        
        if ( ! empty( $card_values['meta2'] ) && ! empty( $display['meta2'] ) ) {
            $html .= '<span><i class="fas fa-tag" style="color: var(--secondary-color);"></i> ' . esc_html( $card_values['meta2'] ) . '</span>';
        }
        
        if ( ! empty( $card_values['date'] ) && ! empty( $display['date'] ) ) {
            $html .= '<span><i class="fas fa-calendar-alt" style="color: var(--secondary-color);"></i> ' . esc_html( $card_values['date'] ) . '</span>';
        }
        
        $html .= '</div>';
        
        // Footer
        $html .= '<div class="info-card-footer">';
        $html .= '<a href="#" class="btn btn-sm btn-outline">View Details</a>';
        $html .= '<a href="#" class="btn btn-sm btn-secondary">Contact</a>';
        $html .= '</div>';
        
        $html .= '</div>'; // End info-card-content
        $html .= '</div>'; // End info-card
        
        return $html;
    }

    /**
     * Add card view column to GravityForms entry list
     */
    public function add_card_view_column( $columns, $form_id ) {
        $columns['card_view'] = __( 'Card View', 'common-elements' );
        return $columns;
    }

    /**
     * Display card view column content
     */
    public function card_view_column( $value, $entry, $field_id ) {
        $form_id = $entry['form_id'];
        
        // Check if we have a mapping for this form
        if ( ! isset( $this->field_mappings[$form_id] ) ) {
            return __( 'No card mapping', 'common-elements' );
        }
        
        return '<a href="#" class="button view-card-preview" data-entry-id="' . esc_attr( $entry['id'] ) . '" data-form-id="' . esc_attr( $form_id ) . '">' . __( 'Preview Card', 'common-elements' ) . '</a>';
    }

    /**
     * Shortcode for displaying GravityForms entries as cards
     */
    public function gform_cards_shortcode( $atts ) {
        $atts = shortcode_atts( array(
            'form_id'       => 0,
            'limit'         => 10,
            'offset'        => 0,
            'orderby'       => 'date_created',
            'order'         => 'DESC',
            'cards_per_row' => 3,
            'search'        => '',
            'filter_field'  => '',
            'filter_value'  => '',
        ), $atts );
        
        $form_id = absint( $atts['form_id'] );
        
        if ( ! $form_id ) {
            return '<p>' . __( 'Error: Form ID is required', 'common-elements' ) . '</p>';
        }
        
        // Check if we have a mapping for this form
        if ( ! isset( $this->field_mappings[$form_id] ) ) {
            return '<p>' . __( 'Error: No card mapping found for this form', 'common-elements' ) . '</p>';
        }
        
        // Get entries
        $search_criteria = array();
        
        if ( ! empty( $atts['search'] ) ) {
            $search_criteria['field_filters'][] = array(
                'mode' => 'any',
                'value' => $atts['search'],
            );
        }
        
        if ( ! empty( $atts['filter_field'] ) && ! empty( $atts['filter_value'] ) ) {
            $search_criteria['field_filters'][] = array(
                'key' => $atts['filter_field'],
                'value' => $atts['filter_value'],
            );
        }
        
        $sorting = array(
            'key' => $atts['orderby'],
            'direction' => $atts['order'],
        );
        
        $paging = array(
            'offset' => absint( $atts['offset'] ),
            'page_size' => absint( $atts['limit'] ),
        );
        
        $entries = GFAPI::get_entries( $form_id, $search_criteria, $sorting, $paging );
        
        if ( empty( $entries ) ) {
            return '<p>' . __( 'No entries found', 'common-elements' ) . '</p>';
        }
        
        // Generate cards
        $mapping = $this->field_mappings[$form_id];
        $card_type = $mapping['card_type'];
        $fields = $mapping['fields'];
        $display = $mapping['display'];
        
        $cards_per_row = absint( $atts['cards_per_row'] );
        if ( $cards_per_row < 1 ) {
            $cards_per_row = 3;
        }
        
        $output = '<div class="info-card-grid" style="grid-template-columns: repeat(' . esc_attr( $cards_per_row ) . ', 1fr);">';
        
        foreach ( $entries as $entry ) {
            $output .= $this->generate_entry_card( $entry, $fields, $display, $card_type );
        }
        
        $output .= '</div>';
        
        return $output;
    }

    /**
     * Generate card HTML for a form entry
     */
    private function generate_entry_card( $entry, $fields, $display, $card_type ) {
        // Get field values
        $card_values = array();
        foreach ( $fields as $card_field => $form_field ) {
            if ( ! empty( $form_field ) && isset( $entry[$form_field] ) ) {
                $card_values[$card_field] = $entry[$form_field];
            } else {
                $card_values[$card_field] = '';
            }
        }
        
        // Generate card HTML based on card type
        $html = '<div class="info-card">';
        
        // Image
        if ( ! empty( $card_values['image'] ) && ! empty( $display['image'] ) ) {
            $html .= '<div class="info-card-image">';
            $html .= '<img src="' . esc_url( $card_values['image'] ) . '" alt="' . esc_attr( $card_values['title'] ) . '">';
            $html .= '</div>';
        }
        
        $html .= '<div class="info-card-content">';
        
        // Title and category
        $html .= '<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-sm);">';
        if ( ! empty( $card_values['title'] ) && ! empty( $display['title'] ) ) {
            $html .= '<h3 class="info-card-title">' . esc_html( $card_values['title'] ) . '</h3>';
        }
        
        if ( ! empty( $card_values['category'] ) && ! empty( $display['category'] ) ) {
            $html .= '<span class="info-card-badge" style="background-color: var(--secondary-color);">' . esc_html( $card_values['category'] ) . '</span>';
        }
        $html .= '</div>';
        
        // Price/meta info
        if ( ( ! empty( $card_values['price'] ) && ! empty( $display['price'] ) ) || 
             ( ! empty( $card_values['location'] ) && ! empty( $display['location'] ) ) ) {
            $html .= '<div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">';
            
            if ( ! empty( $card_values['price'] ) && ! empty( $display['price'] ) ) {
                $html .= '<div style="font-weight: 600; color: var(--secondary-color);">';
                $html .= '<i class="fas fa-dollar-sign" style="margin-right: 4px;"></i> ' . esc_html( $card_values['price'] );
                $html .= '</div>';
            }
            
            if ( ! empty( $card_values['location'] ) && ! empty( $display['location'] ) ) {
                $html .= '<div style="font-weight: 600;">';
                $html .= '<i class="fas fa-map-marker-alt" style="margin-right: 4px; color: var(--secondary-color);"></i> ' . esc_html( $card_values['location'] );
                $html .= '</div>';
            }
            
            $html .= '</div>';
        }
        
        // Description
        if ( ! empty( $card_values['description'] ) && ! empty( $display['description'] ) ) {
            $html .= '<p class="info-card-description">' . esc_html( $card_values['description'] ) . '</p>';
        }
        
        // Meta fields
        $html .= '<div class="info-card-meta">';
        
        if ( ! empty( $card_values['meta1'] ) && ! empty( $display['meta1'] ) ) {
            $html .= '<span><i class="fas fa-info-circle" style="color: var(--secondary-color);"></i> ' . esc_html( $card_values['meta1'] ) . '</span>';
        }
        
        if ( ! empty( $card_values['meta2'] ) && ! empty( $display['meta2'] ) ) {
            $html .= '<span><i class="fas fa-tag" style="color: var(--secondary-color);"></i> ' . esc_html( $card_values['meta2'] ) . '</span>';
        }
        
        if ( ! empty( $card_values['date'] ) && ! empty( $display['date'] ) ) {
            $html .= '<span><i class="fas fa-calendar-alt" style="color: var(--secondary-color);"></i> ' . esc_html( $card_values['date'] ) . '</span>';
        }
        
        $html .= '</div>';
        
        // Footer with entry link
        $html .= '<div class="info-card-footer">';
        $html .= '<a href="' . esc_url( add_query_arg( array( 'entry_id' => $entry['id'] ), get_permalink() ) ) . '" class="btn btn-sm btn-outline">View Details</a>';
        
        if ( ! empty( $card_values['contact'] ) && ! empty( $display['contact'] ) ) {
            $html .= '<a href="mailto:' . esc_attr( $card_values['contact'] ) . '" class="btn btn-sm btn-secondary">Contact</a>';
        } else {
            $html .= '<a href="#" class="btn btn-sm btn-secondary">Contact</a>';
        }
        
        $html .= '</div>';
        
        $html .= '</div>'; // End info-card-content
        $html .= '</div>'; // End info-card
        
        return $html;
    }
}

// Initialize the GravityForms card integration
Common_Elements_GravityForms_Cards::get_instance();
