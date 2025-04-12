<?php
/**
 * Integration between Common Elements Card Customizer and GravityForms
 * 
 * This file registers the necessary hooks to connect the card customizer
 * with GravityForms for dynamic card content.
 *
 * @package CommonElements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register GravityForms integration hooks
 */
function common_elements_register_gravityforms_integration() {
    // Only proceed if GravityForms is active
    if ( ! class_exists( 'GFForms' ) ) {
        return;
    }
    
    // Include the GravityForms cards class
    require_once plugin_dir_path( __FILE__ ) . 'class-common-elements-gravityforms-cards.php';
    
    // Add filter to extend card types with GravityForms forms
    add_filter( 'common_elements_card_types', 'common_elements_add_gform_card_types' );
    
    // Add action to register GravityForms card templates
    add_action( 'init', 'common_elements_register_gform_card_templates', 20 );
    
    // Add filter to modify card content with GravityForms data
    add_filter( 'common_elements_card_content', 'common_elements_filter_gform_card_content', 10, 3 );
}
add_action( 'plugins_loaded', 'common_elements_register_gravityforms_integration' );

/**
 * Add GravityForms forms as card types
 */
function common_elements_add_gform_card_types( $card_types ) {
    // Get all GravityForms forms
    $forms = GFAPI::get_forms();
    
    if ( empty( $forms ) ) {
        return $card_types;
    }
    
    foreach ( $forms as $form ) {
        $card_types['gform_' . $form['id']] = sprintf( __( 'GravityForm: %s', 'common-elements' ), $form['title'] );
    }
    
    return $card_types;
}

/**
 * Register GravityForms card templates
 */
function common_elements_register_gform_card_templates() {
    // Get all GravityForms forms
    $forms = GFAPI::get_forms();
    
    if ( empty( $forms ) ) {
        return;
    }
    
    // Get card mappings
    $mappings = get_option( 'common_elements_gform_card_mappings', array() );
    
    foreach ( $forms as $form ) {
        $form_id = $form['id'];
        
        // Skip if no mapping exists
        if ( ! isset( $mappings[$form_id] ) ) {
            continue;
        }
        
        // Register template for this form
        add_filter( 'common_elements_card_template_gform_' . $form_id, function( $template ) use ( $form_id, $mappings ) {
            // Get the mapped card type
            $card_type = isset( $mappings[$form_id]['card_type'] ) ? $mappings[$form_id]['card_type'] : 'directory';
            
            // Use the template for that card type
            return apply_filters( 'common_elements_card_template_' . $card_type, '' );
        } );
    }
}

/**
 * Filter card content with GravityForms data
 */
function common_elements_filter_gform_card_content( $content, $card_type, $post_id ) {
    // Check if this is a GravityForms card type
    if ( strpos( $card_type, 'gform_' ) !== 0 ) {
        return $content;
    }
    
    // Extract form ID from card type
    $form_id = str_replace( 'gform_', '', $card_type );
    
    // Get entry ID from post ID or query var
    $entry_id = get_query_var( 'entry_id', $post_id );
    
    if ( ! $entry_id ) {
        return $content;
    }
    
    // Get the entry
    $entry = GFAPI::get_entry( $entry_id );
    
    if ( is_wp_error( $entry ) ) {
        return $content;
    }
    
    // Get field mappings
    $mappings = get_option( 'common_elements_gform_card_mappings', array() );
    
    if ( ! isset( $mappings[$form_id] ) ) {
        return $content;
    }
    
    $mapping = $mappings[$form_id];
    $fields = isset( $mapping['fields'] ) ? $mapping['fields'] : array();
    $display = isset( $mapping['display'] ) ? $mapping['display'] : array();
    
    // Replace placeholders in content with entry data
    foreach ( $fields as $card_field => $form_field ) {
        if ( empty( $form_field ) || empty( $display[$card_field] ) ) {
            continue;
        }
        
        $value = isset( $entry[$form_field] ) ? $entry[$form_field] : '';
        $placeholder = '{{' . $card_field . '}}';
        
        $content = str_replace( $placeholder, $value, $content );
    }
    
    return $content;
}
