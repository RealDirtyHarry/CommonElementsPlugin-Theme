<?php
/**
 * Plugin integration with theme for card customization
 * 
 * This file registers the necessary hooks to connect the plugin
 * with the theme for card layout customization.
 *
 * @package CommonElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register theme integration hooks
 */
function common_elements_register_theme_integration() {
    // Add filter to provide card settings to theme
    add_filter( 'common_elements_theme_card_settings', 'common_elements_provide_card_settings', 10, 2 );
    
    // Add action to register card templates
    add_action( 'init', 'common_elements_register_card_templates', 20 );
    
    // Add filter to modify card content
    add_filter( 'common_elements_card_content', 'common_elements_filter_card_content', 10, 3 );
    
    // Add shortcode for displaying cards
    add_shortcode( 'common_elements_cards', 'common_elements_cards_shortcode' );
    
    // Add admin menu for card customization
    add_action( 'admin_menu', 'common_elements_add_card_admin_menu' );
    
    // Register card customization settings
    add_action( 'admin_init', 'common_elements_register_card_settings' );
    
    // Add customizer settings for cards
    add_action( 'customize_register', 'common_elements_card_customizer_settings' );
}
add_action( 'plugins_loaded', 'common_elements_register_theme_integration' );

/**
 * Provide card settings to theme
 */
function common_elements_provide_card_settings( $settings, $card_type ) {
    // Get settings from database
    $saved_settings = get_option( 'common_elements_' . $card_type . '_card_settings', array() );
    
    // Merge with default settings
    if ( ! empty( $saved_settings ) ) {
        $settings = wp_parse_args( $saved_settings, $settings );
    }
    
    return $settings;
}

/**
 * Register card templates
 */
function common_elements_register_card_templates() {
    // Register templates for different card types
    $card_types = array(
        'directory',
        'classifieds',
        'rfp',
        'jobs',
        'courses',
    );
    
    foreach ( $card_types as $card_type ) {
        add_filter( 'common_elements_card_template_' . $card_type, function( $template ) use ( $card_type ) {
            // Get template from plugin
            $template_path = plugin_dir_path( __FILE__ ) . '../templates/cards/' . $card_type . '-card.php';
            
            if ( file_exists( $template_path ) ) {
                ob_start();
                include $template_path;
                return ob_get_clean();
            }
            
            return $template;
        } );
    }
}

/**
 * Filter card content
 */
function common_elements_filter_card_content( $content, $card_type, $post_id ) {
    // Get post data
    $post = get_post( $post_id );
    
    if ( ! $post ) {
        return $content;
    }
    
    // Get card settings
    $settings = apply_filters( 'common_elements_theme_card_settings', array(), $card_type );
    
    // Replace placeholders in content with post data
    $content = str_replace( '{{title}}', get_the_title( $post ), $content );
    $content = str_replace( '{{excerpt}}', get_the_excerpt( $post ), $content );
    $content = str_replace( '{{permalink}}', get_permalink( $post ), $content );
    
    // Replace featured image
    if ( has_post_thumbnail( $post ) ) {
        $image = get_the_post_thumbnail_url( $post, 'medium' );
        $content = str_replace( '{{image}}', $image, $content );
    } else {
        $content = str_replace( '{{image}}', plugin_dir_url( __FILE__ ) . '../assets/images/placeholder.jpg', $content );
    }
    
    // Replace custom fields
    $custom_fields = get_post_custom( $post_id );
    
    foreach ( $custom_fields as $key => $values ) {
        if ( strpos( $key, '_' ) === 0 ) {
            continue; // Skip private fields
        }
        
        $value = $values[0];
        $content = str_replace( '{{' . $key . '}}', $value, $content );
    }
    
    return $content;
}

/**
 * Shortcode for displaying cards
 */
function common_elements_cards_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'type'          => 'directory',
        'cards_per_row' => 0,
        'rows_per_page' => 0,
        'total_per_page' => 0,
        'category'      => '',
        'orderby'       => 'date',
        'order'         => 'DESC',
        'fields'        => '',
        'post_type'     => '',
    ), $atts );
    
    // Get card type
    $card_type = sanitize_text_field( $atts['type'] );
    
    // Get settings for this card type
    $settings = apply_filters( 'common_elements_theme_card_settings', array(), $card_type );
    
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
    
    // Determine post type
    $post_type = ! empty( $atts['post_type'] ) ? $atts['post_type'] : 'post';
    
    // Set up query args
    $query_args = array(
        'post_type'      => $post_type,
        'posts_per_page' => isset( $settings['total_per_page'] ) ? $settings['total_per_page'] : 9,
        'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
    );
    
    // Add category if specified
    if ( ! empty( $atts['category'] ) ) {
        if ( $post_type === 'post' ) {
            $query_args['category_name'] = $atts['category'];
        } else {
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => $post_type . '_category',
                    'field'    => 'slug',
                    'terms'    => explode( ',', $atts['category'] ),
                ),
            );
        }
    }
    
    // Get posts
    $query = new WP_Query( $query_args );
    
    if ( ! $query->have_posts() ) {
        return '<p>' . __( 'No items found', 'common-elements' ) . '</p>';
    }
    
    // Get card template
    $template = apply_filters( 'common_elements_card_template_' . $card_type, '' );
    
    if ( empty( $template ) ) {
        return '<p>' . __( 'Card template not found', 'common-elements' ) . '</p>';
    }
    
    // Build output
    $cards_per_row = isset( $settings['cards_per_row'] ) ? $settings['cards_per_row'] : 3;
    
    $output = '<div class="info-card-grid" style="--cards-per-row: ' . esc_attr( $cards_per_row ) . ';">';
    
    while ( $query->have_posts() ) {
        $query->the_post();
        
        // Filter card content
        $card_content = apply_filters( 'common_elements_card_content', $template, $card_type, get_the_ID() );
        
        $output .= $card_content;
    }
    
    $output .= '</div>';
    
    wp_reset_postdata();
    
    return $output;
}

/**
 * Add admin menu for card customization
 */
function common_elements_add_card_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=page',
        __( 'Card Layouts', 'common-elements' ),
        __( 'Card Layouts', 'common-elements' ),
        'manage_options',
        'common-elements-cards',
        'common_elements_card_admin_page'
    );
}

/**
 * Admin page for card customization
 */
function common_elements_card_admin_page() {
    // Get card types
    $card_types = array(
        'directory'   => __( 'Directory Listings', 'common-elements' ),
        'classifieds' => __( 'Classified Ads', 'common-elements' ),
        'rfp'         => __( 'RFP Board', 'common-elements' ),
        'jobs'        => __( 'Job Postings', 'common-elements' ),
        'courses'     => __( 'Courses', 'common-elements' ),
    );
    
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__( 'Card Layout Customization', 'common-elements' ); ?></h1>
        
        <p><?php echo esc_html__( 'Customize the layout and appearance of card-based content throughout your site.', 'common-elements' ); ?></p>
        
        <div class="nav-tab-wrapper">
            <?php foreach ( $card_types as $type => $label ) : ?>
                <a href="#<?php echo esc_attr( $type ); ?>-cards" class="nav-tab"><?php echo esc_html( $label ); ?></a>
            <?php endforeach; ?>
        </div>
        
        <form method="post" action="options.php">
            <?php settings_fields( 'common_elements_card_settings' ); ?>
            
            <?php foreach ( $card_types as $type => $label ) : 
                $settings = get_option( 'common_elements_' . $type . '_card_settings', array() );
                $cards_per_row = isset( $settings['cards_per_row'] ) ? $settings['cards_per_row'] : 3;
                $rows_per_page = isset( $settings['rows_per_page'] ) ? $settings['rows_per_page'] : 3;
                $total_per_page = isset( $settings['total_per_page'] ) ? $settings['total_per_page'] : 9;
                $fields = isset( $settings['fields'] ) ? $settings['fields'] : array();
            ?>
                <div id="<?php echo esc_attr( $type ); ?>-cards" class="card-settings-tab">
                    <h2><?php echo esc_html( $label . ' ' . __( 'Card Settings', 'common-elements' ) ); ?></h2>
                    
                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php echo esc_html__( 'Cards Per Row', 'common-elements' ); ?></th>
                            <td>
                                <input type="number" name="common_elements_<?php echo esc_attr( $type ); ?>_card_settings[cards_per_row]" 
                                       value="<?php echo esc_attr( $cards_per_row ); ?>" min="1" max="6" step="1" />
                                <p class="description"><?php echo esc_html__( 'Number of cards to display in each row', 'common-elements' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo esc_html__( 'Rows Per Page', 'common-elements' ); ?></th>
                            <td>
                                <input type="number" name="common_elements_<?php echo esc_attr( $type ); ?>_card_settings[rows_per_page]" 
                                       value="<?php echo esc_attr( $rows_per_page ); ?>" min="1" max="20" step="1" />
                                <p class="description"><?php echo esc_html__( 'Number of rows to display per page', 'common-elements' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo esc_html__( 'Total Cards Per Page', 'common-elements' ); ?></th>
                            <td>
                                <input type="number" name="common_elements_<?php echo esc_attr( $type ); ?>_card_settings[total_per_page]" 
                                       value="<?php echo esc_attr( $total_per_page ); ?>" min="1" max="100" step="1" />
                                <p class="description"><?php echo esc_html__( 'Total number of cards to display per page', 'common-elements' ); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo esc_html__( 'Card Fields', 'common-elements' ); ?></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><?php echo esc_html__( 'Card Fields', 'common-elements' ); ?></legend>
                                    <?php 
                                    $available_fields = common_elements_get_available_fields( $type );
                                    foreach ( $available_fields as $field => $label ) : 
                                        $checked = isset( $fields[$field] ) ? $fields[$field] : true;
                                    ?>
                                        <label>
                                            <input type="checkbox" name="common_elements_<?php echo esc_attr( $type ); ?>_card_settings[fields][<?php echo esc_attr( $field ); ?>]" 
                                                   value="1" <?php checked( $checked ); ?> />
                                            <?php echo esc_html( $label ); ?>
                                        </label><br>
                                    <?php endforeach; ?>
                                </fieldset>
                                <p class="description"><?php echo esc_html__( 'Select which fields to display on each card', 'common-elements' ); ?></p>
                            </td>
                        </tr>
                    </table>
                    
                    <div class="card-preview-container">
                        <h3><?php echo esc_html__( 'Preview', 'common-elements' ); ?></h3>
                        <div class="card-preview" data-type="<?php echo esc_attr( $type ); ?>">
                            <!-- Preview will be loaded via JavaScript -->
                            <p><?php echo esc_html__( 'Save settings to update preview', 'common-elements' ); ?></p>
                        </div>
                    </div>
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
 * Get available fields for a card type
 */
function common_elements_get_available_fields( $card_type ) {
    $common_fields = array(
        'image'       => __( 'Image', 'common-elements' ),
        'title'       => __( 'Title', 'common-elements' ),
        'category'    => __( 'Category', 'common-elements' ),
        'description' => __( 'Description', 'common-elements' ),
    );
    
    $type_specific_fields = array();
    
    switch ( $card_type ) {
        case 'directory':
            $type_specific_fields = array(
                'contact'     => __( 'Contact Information', 'common-elements' ),
                'rating'      => __( 'Rating', 'common-elements' ),
                'location'    => __( 'Location', 'common-elements' ),
                'website'     => __( 'Website', 'common-elements' ),
                'phone'       => __( 'Phone', 'common-elements' ),
                'email'       => __( 'Email', 'common-elements' ),
                'social'      => __( 'Social Media', 'common-elements' ),
                'hours'       => __( 'Business Hours', 'common-elements' ),
            );
            break;
            
        case 'classifieds':
            $type_specific_fields = array(
                'price'       => __( 'Price', 'common-elements' ),
                'condition'   => __( 'Condition', 'common-elements' ),
                'location'    => __( 'Location', 'common-elements' ),
                'contact'     => __( 'Contact Information', 'common-elements' ),
                'date'        => __( 'Date Posted', 'common-elements' ),
                'expiry'      => __( 'Expiry Date', 'common-elements' ),
            );
            break;
            
        case 'rfp':
            $type_specific_fields = array(
                'budget'      => __( 'Budget', 'common-elements' ),
                'due_date'    => __( 'Due Date', 'common-elements' ),
                'organization' => __( 'Organization', 'common-elements' ),
                'contact'     => __( 'Contact Information', 'common-elements' ),
                'location'    => __( 'Location', 'common-elements' ),
                'status'      => __( 'Status', 'common-elements' ),
                'posted_date' => __( 'Posted Date', 'common-elements' ),
            );
            break;
            
        case 'jobs':
            $type_specific_fields = array(
                'job_type'    => __( 'Job Type', 'common-elements' ),
                'salary'      => __( 'Salary', 'common-elements' ),
                'company'     => __( 'Company', 'common-elements' ),
                'location'    => __( 'Location', 'common-elements' ),
                'requirements' => __( 'Requirements', 'common-elements' ),
                'posted_date' => __( 'Posted Date', 'common-elements' ),
                'closing_date' => __( 'Closing Date', 'common-elements' ),
            );
            break;
            
        case 'courses':
            $type_specific_fields = array(
                'instructor'  => __( 'Instructor', 'common-elements' ),
                'duration'    => __( 'Duration', 'common-elements' ),
                'lessons'     => __( 'Number of Lessons', 'common-elements' ),
                'level'       => __( 'Difficulty Level', 'common-elements' ),
                'price'       => __( 'Price', 'common-elements' ),
                'start_date'  => __( 'Start Date', 'common-elements' ),
                'enrollment'  => __( 'Enrollment Status', 'common-elements' ),
            );
            break;
    }
    
    return array_merge( $common_fields, $type_specific_fields );
}

/**
 * Register card customization settings
 */
function common_elements_register_card_settings() {
    $card_types = array(
        'directory',
        'classifieds',
        'rfp',
        'jobs',
        'courses',
    );
    
    foreach ( $card_types as $type ) {
        register_setting(
            'common_elements_card_settings',
            'common_elements_' . $type . '_card_settings',
            array(
                'sanitize_callback' => 'common_elements_sanitize_card_settings',
                'default'           => array(),
            )
        );
    }
}

/**
 * Sanitize card settings
 */
function common_elements_sanitize_card_settings( $input ) {
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
 * Add customizer settings for cards
 */
function common_elements_card_customizer_settings( $wp_customize ) {
    // Add section for card layouts
    $wp_customize->add_section( 'common_elements_card_layouts', array(
        'title'    => __( 'Card Layouts', 'common-elements' ),
        'priority' => 30,
    ) );
    
    // Add settings for each card type
    $card_types = array(
        'directory'   => __( 'Directory Listings', 'common-elements' ),
        'classifieds' => __( 'Classified Ads', 'common-elements' ),
        'rfp'         => __( 'RFP Board', 'common-elements' ),
        'jobs'        => __( 'Job Postings', 'common-elements' ),
        'courses'     => __( 'Courses', 'common-elements' ),
    );
    
    foreach ( $card_types as $type => $label ) {
        // Get current settings
        $settings = get_option( 'common_elements_' . $type . '_card_settings', array() );
        $cards_per_row = isset( $settings['cards_per_row'] ) ? $settings['cards_per_row'] : 3;
        $total_per_page = isset( $settings['total_per_page'] ) ? $settings['total_per_page'] : 9;
        
        // Cards per row
        $wp_customize->add_setting( 'common_elements_' . $type . '_cards_per_row', array(
            'default'           => $cards_per_row,
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        ) );
        
        $wp_customize->add_control( 'common_elements_' . $type . '_cards_per_row', array(
            'label'       => sprintf( __( '%s Cards Per Row', 'common-elements' ), $label ),
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
        $wp_customize->add_setting( 'common_elements_' . $type . '_total_per_page', array(
            'default'           => $total_per_page,
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        ) );
        
        $wp_customize->add_control( 'common_elements_' . $type . '_total_per_page', array(
            'label'       => sprintf( __( '%s Cards Per Page', 'common-elements' ), $label ),
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
    
    // Add hook to save customizer settings to options
    add_action( 'customize_save_after', 'common_elements_save_card_customizer_settings' );
}

/**
 * Save customizer settings to options
 */
function common_elements_save_card_customizer_settings() {
    $card_types = array(
        'directory',
        'classifieds',
        'rfp',
        'jobs',
        'courses',
    );
    
    foreach ( $card_types as $type ) {
        $settings = get_option( 'common_elements_' . $type . '_card_settings', array() );
        
        $cards_per_row = get_theme_mod( 'common_elements_' . $type . '_cards_per_row' );
        if ( $cards_per_row ) {
            $settings['cards_per_row'] = absint( $cards_per_row );
        }
        
        $total_per_page = get_theme_mod( 'common_elements_' . $type . '_total_per_page' );
        if ( $total_per_page ) {
            $settings['total_per_page'] = absint( $total_per_page );
            
            // Calculate rows per page
            if ( isset( $settings['cards_per_row'] ) && $settings['cards_per_row'] > 0 ) {
                $settings['rows_per_page'] = ceil( $settings['total_per_page'] / $settings['cards_per_row'] );
            }
        }
        
        update_option( 'common_elements_' . $type . '_card_settings', $settings );
    }
}
