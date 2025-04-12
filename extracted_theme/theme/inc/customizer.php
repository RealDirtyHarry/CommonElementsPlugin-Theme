<?php
/**
 * Common Elements Theme Customizer
 *
 * @package Common_Elements
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function common_elements_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'common_elements_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'common_elements_customize_partial_blogdescription',
			)
		);
	}

	// Add Theme Colors Section
	$wp_customize->add_section(
		'common_elements_colors',
		array(
			'title'    => __( 'Theme Colors', 'common-elements' ),
			'priority' => 30,
		)
	);

	// Primary Color
	$wp_customize->add_setting(
		'primary_color',
		array(
			'default'           => '#0063CE',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_color',
			array(
				'label'    => __( 'Primary Color', 'common-elements' ),
				'section'  => 'common_elements_colors',
				'settings' => 'primary_color',
			)
		)
	);

	// Secondary Color
	$wp_customize->add_setting(
		'secondary_color',
		array(
			'default'           => '#FF8A00',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'secondary_color',
			array(
				'label'    => __( 'Secondary Color', 'common-elements' ),
				'section'  => 'common_elements_colors',
				'settings' => 'secondary_color',
			)
		)
	);

	// Dashboard Options Section
	$wp_customize->add_section(
		'common_elements_dashboard',
		array(
			'title'    => __( 'Dashboard Options', 'common-elements' ),
			'priority' => 35,
		)
	);

	// Dashboard Welcome Message
	$wp_customize->add_setting(
		'dashboard_welcome_message',
		array(
			'default'           => __( 'Welcome to your dashboard', 'common-elements' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'dashboard_welcome_message',
		array(
			'label'    => __( 'Dashboard Welcome Message', 'common-elements' ),
			'section'  => 'common_elements_dashboard',
			'type'     => 'text',
		)
	);

	// Footer Options Section
	$wp_customize->add_section(
		'common_elements_footer',
		array(
			'title'    => __( 'Footer Options', 'common-elements' ),
			'priority' => 40,
		)
	);

	// Footer Copyright Text
	$wp_customize->add_setting(
		'footer_copyright_text',
		array(
			'default'           => __( 'All Rights Reserved.', 'common-elements' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'footer_copyright_text',
		array(
			'label'    => __( 'Copyright Text', 'common-elements' ),
			'section'  => 'common_elements_footer',
			'type'     => 'text',
		)
	);
}
add_action( 'customize_register', 'common_elements_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function common_elements_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function common_elements_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function common_elements_customize_preview_js() {
	wp_enqueue_script( 'common-elements-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), COMMON_ELEMENTS_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'common_elements_customize_preview_js' );

/**
 * Generate CSS for the color customizer options
 */
function common_elements_customizer_css() {
	$primary_color = get_theme_mod( 'primary_color', '#0063CE' );
	$secondary_color = get_theme_mod( 'secondary_color', '#FF8A00' );
	
	$css = '
		:root {
			--color-primary: ' . $primary_color . ';
			--color-primary-light: ' . common_elements_adjust_brightness( $primary_color, 20 ) . ';
			--color-primary-dark: ' . common_elements_adjust_brightness( $primary_color, -20 ) . ';
			
			--color-secondary: ' . $secondary_color . ';
			--color-secondary-light: ' . common_elements_adjust_brightness( $secondary_color, 20 ) . ';
			--color-secondary-dark: ' . common_elements_adjust_brightness( $secondary_color, -20 ) . ';
		}
	';
	
	wp_add_inline_style( 'common-elements-style', $css );
}
add_action( 'wp_enqueue_scripts', 'common_elements_customizer_css' );

/**
 * Helper function to adjust color brightness
 */
function common_elements_adjust_brightness( $hex, $steps ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max( -255, min( 255, $steps ) );

	// Format the hex color string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Get decimal values
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	// Adjust
	$r = max( 0, min( 255, $r + $steps ) );
	$g = max( 0, min( 255, $g + $steps ) );
	$b = max( 0, min( 255, $b + $steps ) );

	// Convert to hex
	$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
	$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
	$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

	return '#' . $r_hex . $g_hex . $b_hex;
}
