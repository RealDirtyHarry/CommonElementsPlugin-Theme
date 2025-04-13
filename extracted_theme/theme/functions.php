<?php
/**
 * Common Elements Theme functions and definitions
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define theme version
if ( ! defined( 'COMMON_ELEMENTS_THEME_VERSION' ) ) {
	define( 'COMMON_ELEMENTS_THEME_VERSION', '1.0.0' );
}

// Define theme directory path
if ( ! defined( 'COMMON_ELEMENTS_THEME_DIR' ) ) {
	define( 'COMMON_ELEMENTS_THEME_DIR', get_template_directory() );
}

// Define theme directory URI
if ( ! defined( 'COMMON_ELEMENTS_THEME_URI' ) ) {
	define( 'COMMON_ELEMENTS_THEME_URI', get_template_directory_uri() );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function common_elements_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Register navigation menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'common-elements' ),
			'footer'  => esc_html__( 'Footer Menu', 'common-elements' ),
			'mobile'  => esc_html__( 'Mobile Menu', 'common-elements' ),
		)
	);

	// Switch default core markup to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'common_elements_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'common_elements_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function common_elements_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'common_elements_content_width', 1200 );
}
add_action( 'after_setup_theme', 'common_elements_content_width', 0 );

/**
 * Register widget area.
 */
function common_elements_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'common-elements' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'common-elements' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'common-elements' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add footer widgets here.', 'common-elements' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'common-elements' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add footer widgets here.', 'common-elements' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'common-elements' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add footer widgets here.', 'common-elements' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 4', 'common-elements' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Add footer widgets here.', 'common-elements' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'common_elements_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function common_elements_scripts() {
	// Enqueue main stylesheet
	wp_enqueue_style( 'common-elements-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );

	// Enqueue Google Fonts
	wp_enqueue_style( 'common-elements-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap', array(), null );
su
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );

	$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';
	$nav_js_path = '/js/navigation' . $suffix . '.js';
	$main_js_path = '/js/main' . $suffix . '.js';
	$nav_js_file_path = COMMON_ELEMENTS_THEME_DIR . $nav_js_path;
	$main_js_file_path = COMMON_ELEMENTS_THEME_DIR . $main_js_path;

	// Enqueue main JavaScript file
	if ( file_exists( $nav_js_file_path ) ) {
		wp_enqueue_script( 'common-elements-navigation', COMMON_ELEMENTS_THEME_URI . $nav_js_path, array('jquery'), filemtime( $nav_js_file_path ), true );
	}

	// Enqueue custom JavaScript file
	if ( file_exists( $main_js_file_path ) ) {
		wp_enqueue_script( 'common-elements-main', COMMON_ELEMENTS_THEME_URI . $main_js_path, array('jquery'), filemtime( $main_js_file_path ), true );
	}

	wp_localize_script( 'common-elements-main', 'commonElementsTheme', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'siteUrl' => site_url(),
		'nonce'   => wp_create_nonce( 'common-elements-theme-nonce' ),
	));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'common_elements_scripts' );

/**
 * Custom template tags for this theme.
 */
require COMMON_ELEMENTS_THEME_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require COMMON_ELEMENTS_THEME_DIR . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require COMMON_ELEMENTS_THEME_DIR . '/inc/customizer.php';

/**
 * BuddyPress compatibility functions.
 */
if ( class_exists( 'BuddyPress' ) ) {
	require COMMON_ELEMENTS_THEME_DIR . '/inc/buddypress.php';
}

/**
 * bbPress compatibility functions.
 */
if ( class_exists( 'bbPress' ) ) {
	require COMMON_ELEMENTS_THEME_DIR . '/inc/bbpress.php';
}

/**
 * MemberPress compatibility functions.
 */
if ( class_exists( 'MeprUser' ) ) {
	require COMMON_ELEMENTS_THEME_DIR . '/inc/memberpress.php';
}

/**
 * Dashboard functions.
 */
require COMMON_ELEMENTS_THEME_DIR . '/inc/dashboard.php';

/**
 * RFP system functions.
 */
require COMMON_ELEMENTS_THEME_DIR . '/inc/rfp-system.php';

/**
 * Directory functions.
 */
require COMMON_ELEMENTS_THEME_DIR . '/inc/directory.php';
