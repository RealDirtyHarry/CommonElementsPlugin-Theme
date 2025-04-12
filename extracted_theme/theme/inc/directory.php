<?php
/**
 * Directory functions for Common Elements theme
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * This file previously contained directory post type and taxonomy registration.
 * That functionality has been moved to the Common Elements Platform plugin
 * for better separation of concerns and to avoid duplication.
 * 
 * The theme now only handles the display and styling of directory elements.
 */

/**
 * Add theme support for directory features
 */
function common_elements_theme_directory_support() {
    // Add theme support for directory features
    add_theme_support( 'common-elements-directory' );
    
    // Add image sizes for directory listings
    add_image_size( 'directory-thumbnail', 300, 300, true );
    add_image_size( 'directory-featured', 600, 400, true );
}
add_action( 'after_setup_theme', 'common_elements_theme_directory_support' );

/**
 * Add directory-specific body classes
 *
 * @param array $classes Array of body classes.
 * @return array Modified array of body classes.
 */
function common_elements_directory_body_classes( $classes ) {
    if ( is_post_type_archive( 'directory_listing' ) ) {
        $classes[] = 'directory-archive';
    }
    
    if ( is_tax( 'directory_category' ) || is_tax( 'directory_location' ) || is_tax( 'directory_feature' ) ) {
        $classes[] = 'directory-taxonomy';
    }
    
    if ( is_singular( 'directory_listing' ) ) {
        $classes[] = 'directory-single';
        
        // Add featured class if listing is featured
        if ( get_post_meta( get_the_ID(), '_directory_featured', true ) ) {
            $classes[] = 'directory-featured';
        }
    }
    
    return $classes;
}
add_filter( 'body_class', 'common_elements_directory_body_classes' );

/**
 * Add directory-specific CSS
 */
function common_elements_directory_styles() {
    if ( is_post_type_archive( 'directory_listing' ) || 
         is_tax( 'directory_category' ) || 
         is_tax( 'directory_location' ) || 
         is_tax( 'directory_feature' ) || 
         is_singular( 'directory_listing' ) ) {
        
        wp_enqueue_style( 
            'common-elements-directory', 
            get_template_directory_uri() . '/assets/css/directory.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'common_elements_directory_styles' );

/**
 * Add directory-specific scripts
 */
function common_elements_directory_scripts() {
    if ( is_post_type_archive( 'directory_listing' ) || 
         is_tax( 'directory_category' ) || 
         is_tax( 'directory_location' ) || 
         is_tax( 'directory_feature' ) || 
         is_singular( 'directory_listing' ) ) {
        
        wp_enqueue_script( 
            'common-elements-directory', 
            get_template_directory_uri() . '/assets/js/directory.js',
            array( 'jquery' ),
            COMMON_ELEMENTS_THEME_VERSION,
            true
        );
        
        // Localize script with directory data
        wp_localize_script( 
            'common-elements-directory', 
            'commonElementsDirectory', 
            array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'common_elements_platform_nonce' ),
            )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'common_elements_directory_scripts' );

/**
 * Add directory-specific widgets
 */
function common_elements_register_directory_widgets() {
    register_sidebar( array(
        'name'          => __( 'Directory Sidebar', 'common-elements' ),
        'id'            => 'directory-sidebar',
        'description'   => __( 'Widgets in this area will be shown on directory pages.', 'common-elements' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'common_elements_register_directory_widgets' );

/**
 * Modify directory archive title
 *
 * @param string $title The archive title.
 * @return string Modified archive title.
 */
function common_elements_directory_archive_title( $title ) {
    if ( is_post_type_archive( 'directory_listing' ) ) {
        return __( 'Directory', 'common-elements' );
    }
    
    if ( is_tax( 'directory_category' ) ) {
        $term = get_queried_object();
        return sprintf( __( 'Directory: %s', 'common-elements' ), $term->name );
    }
    
    if ( is_tax( 'directory_location' ) ) {
        $term = get_queried_object();
        return sprintf( __( 'Directory in %s', 'common-elements' ), $term->name );
    }
    
    return $title;
}
add_filter( 'get_the_archive_title', 'common_elements_directory_archive_title' );

/**
 * Add directory template parts
 */
function common_elements_get_directory_template_part( $slug, $name = null ) {
    $templates = array();
    $name = (string) $name;
    
    if ( '' !== $name ) {
        $templates[] = "template-parts/directory/{$slug}-{$name}.php";
    }
    
    $templates[] = "template-parts/directory/{$slug}.php";
    
    // Allow plugins to modify the template hierarchy
    $templates = apply_filters( 'common_elements_directory_template_hierarchy', $templates, $slug, $name );
    
    locate_template( $templates, true, false );
}
