<?php
/**
 * Template structure for Common Elements theme.
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class responsible for template structure.
 */
class Common_Elements_Template_Structure {

    /**
     * The single instance of this class.
     *
     * @var Common_Elements_Template_Structure
     */
    private static $instance = null;

    /**
     * Get the single instance of this class.
     *
     * @return Common_Elements_Template_Structure
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
        add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_filter( 'body_class', array( $this, 'body_classes' ) );
        add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
        add_filter( 'template_include', array( $this, 'template_loader' ) );
    }

    /**
     * Setup theme.
     */
    public function setup_theme() {
        // Add theme support
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ) );
        add_theme_support( 'customize-selective-refresh-widgets' );
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ) );
        add_theme_support( 'editor-styles' );
        add_theme_support( 'responsive-embeds' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'wp-block-styles' );

        // Register nav menus
        register_nav_menus( array(
            'primary'   => esc_html__( 'Primary Menu', 'common-elements' ),
            'secondary' => esc_html__( 'Secondary Menu', 'common-elements' ),
            'footer'    => esc_html__( 'Footer Menu', 'common-elements' ),
            'mobile'    => esc_html__( 'Mobile Menu', 'common-elements' ),
        ) );

        // Set content width
        if ( ! isset( $content_width ) ) {
            $content_width = 1200;
        }
    }

    /**
     * Enqueue scripts and styles.
     */
    public function enqueue_scripts() {
        // Enqueue styles
        wp_enqueue_style(
            'common-elements-style',
            get_stylesheet_uri(),
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );

        wp_enqueue_style(
            'common-elements-main',
            get_template_directory_uri() . '/assets/css/main.css',
            array(),
            COMMON_ELEMENTS_THEME_VERSION
        );

        // Enqueue scripts
        wp_enqueue_script(
            'common-elements-navigation',
            get_template_directory_uri() . '/assets/js/navigation.js',
            array( 'jquery' ),
            COMMON_ELEMENTS_THEME_VERSION,
            true
        );

        wp_enqueue_script(
            'common-elements-main',
            get_template_directory_uri() . '/assets/js/main.js',
            array( 'jquery' ),
            COMMON_ELEMENTS_THEME_VERSION,
            true
        );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

    /**
     * Add custom body classes.
     *
     * @param array $classes Body classes.
     * @return array
     */
    public function body_classes( $classes ) {
        // Add a class if there is a custom header
        if ( has_header_image() ) {
            $classes[] = 'has-header-image';
        }

        // Add a class for the sidebar position
        $options = get_option( 'common_elements_theme_options', array() );
        $sidebar_position = isset( $options['sidebar_position'] ) ? $options['sidebar_position'] : 'right';
        $classes[] = 'sidebar-' . $sidebar_position;

        // Add a class for the header layout
        $header_layout = isset( $options['header_layout'] ) ? $options['header_layout'] : 'default';
        $classes[] = 'header-' . $header_layout;

        // Add a class for the footer layout
        $footer_layout = isset( $options['footer_layout'] ) ? $options['footer_layout'] : 'default';
        $classes[] = 'footer-' . $footer_layout;

        // Add a class if sticky header is enabled
        if ( isset( $options['sticky_header'] ) && 'on' === $options['sticky_header'] ) {
            $classes[] = 'has-sticky-header';
        }

        return $classes;
    }

    /**
     * Register widget areas.
     */
    public function register_sidebars() {
        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar', 'common-elements' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'Footer 1', 'common-elements' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'Add widgets here to appear in footer column 1.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'Footer 2', 'common-elements' ),
            'id'            => 'footer-2',
            'description'   => esc_html__( 'Add widgets here to appear in footer column 2.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'Footer 3', 'common-elements' ),
            'id'            => 'footer-3',
            'description'   => esc_html__( 'Add widgets here to appear in footer column 3.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'Footer 4', 'common-elements' ),
            'id'            => 'footer-4',
            'description'   => esc_html__( 'Add widgets here to appear in footer column 4.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        // Register plugin-specific widget areas
        register_sidebar( array(
            'name'          => esc_html__( 'Directory Sidebar', 'common-elements' ),
            'id'            => 'directory-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in the directory sidebar.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'RFP Sidebar', 'common-elements' ),
            'id'            => 'rfp-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in the RFP sidebar.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'Forums Sidebar', 'common-elements' ),
            'id'            => 'forums-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in the forums sidebar.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => esc_html__( 'Learning Hub Sidebar', 'common-elements' ),
            'id'            => 'learning-hub-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in the learning hub sidebar.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    }

    /**
     * Template loader.
     *
     * @param string $template The template to load.
     * @return string
     */
    public function template_loader( $template ) {
        // Check if this is a plugin template
        if ( $this->is_plugin_template() ) {
            return $this->get_plugin_template();
        }

        return $template;
    }

    /**
     * Check if current page is a plugin template.
     *
     * @return bool
     */
    private function is_plugin_template() {
        global $wp_query;

        // Check for plugin-specific query vars
        if ( isset( $wp_query->query_vars['directory'] ) ) {
            return true;
        }

        if ( isset( $wp_query->query_vars['rfp'] ) ) {
            return true;
        }

        if ( isset( $wp_query->query_vars['forum'] ) ) {
            return true;
        }

        if ( isset( $wp_query->query_vars['learning'] ) ) {
            return true;
        }

        // Check for plugin post types
        if ( is_singular( 'directory' ) || is_post_type_archive( 'directory' ) || is_tax( 'directory_category' ) ) {
            return true;
        }

        if ( is_singular( 'rfp' ) || is_post_type_archive( 'rfp' ) || is_tax( 'rfp_category' ) ) {
            return true;
        }

        if ( is_singular( 'forum' ) || is_post_type_archive( 'forum' ) || is_tax( 'forum_category' ) ) {
            return true;
        }

        if ( is_singular( 'learning' ) || is_post_type_archive( 'learning' ) || is_tax( 'learning_category' ) ) {
            return true;
        }

        return false;
    }

    /**
     * Get plugin template.
     *
     * @return string
     */
    private function get_plugin_template() {
        global $wp_query;

        // Directory templates
        if ( isset( $wp_query->query_vars['directory'] ) || is_singular( 'directory' ) || is_post_type_archive( 'directory' ) || is_tax( 'directory_category' ) ) {
            if ( is_singular( 'directory' ) ) {
                $template = locate_template( array( 'common-elements/directory/single-directory.php' ) );
                if ( ! $template ) {
                    $template = get_template_directory() . '/templates/directory/single-directory.php';
                }
            } else {
                $template = locate_template( array( 'common-elements/directory/archive-directory.php' ) );
                if ( ! $template ) {
                    $template = get_template_directory() . '/templates/directory/archive-directory.php';
                }
            }
            return $template;
        }

        // RFP templates
        if ( isset( $wp_query->query_vars['rfp'] ) || is_singular( 'rfp' ) || is_post_type_archive( 'rfp' ) || is_tax( 'rfp_category' ) ) {
            if ( is_singular( 'rfp' ) ) {
                $template = locate_template( array( 'common-elements/rfp/single-rfp.php' ) );
                if ( ! $template ) {
                    $template = get_template_directory() . '/templates/rfp/single-rfp.php';
                }
            } else {
                $template = locate_template( array( 'common-elements/rfp/archive-rfp.php' ) );
                if ( ! $template ) {
                    $template = get_template_directory() . '/templates/rfp/archive-rfp.php';
                }
            }
            return $template;
        }

        // Forum templates
        if ( isset( $wp_query->query_vars['forum'] ) || is_singular( 'forum' ) || is_post_type_archive( 'forum' ) || is_tax( 'forum_category' ) ) {
            if ( is_singular( 'forum' ) ) {
                $template = locate_template( array( 'common-elements/forum/single-forum.php' ) );
                if ( ! $template ) {
                    $template = get_template_directory() . '/templates/forum/single-forum.php';
                }
            } else {
                $template = locate_template( array( 'common-elements/forum/archive-forum.php' ) );
                if ( ! $template ) {
                    $template = get_template_directory() . '/templates/forum/archive-forum.php';
                }
            }
            return $template;
        }

        // Learning templates
        if ( isset( $wp_query->query_vars['learning'] ) || is_singular( 'learning' ) || is_post_type_archive( 'learning' ) || is_tax( 'learning_category' ) ) {
            if ( is_singular( 'learning' ) ) {
                $template = locate_template( array( 'common-elements/learning/single-learning.php' ) );
                if ( ! $template ) {
                    $template = get_template_directory() . '/templates/learning/single-learning.php';
                }
            } else {
                $template = locate_template( array( 'common-elements/learning/archive-learning.php' ) );
                if ( ! $template ) {
                    $template = get_template_directory() . '/templates/learning/archive-learning.php';
                }
            }
            return $template;
        }

        return get_template_directory() . '/index.php';
    }

    /**
     * Get template part.
     *
     * @param string $slug The template slug.
     * @param string $name The template name (optional).
     * @param array  $args Arguments to pass to the template (optional).
     */
    public static function get_template_part( $slug, $name = null, $args = array() ) {
        if ( $args && is_array( $args ) ) {
            extract( $args );
        }

        $templates = array();
        if ( $name ) {
            $templates[] = "{$slug}-{$name}.php";
        }
        $templates[] = "{$slug}.php";

        $template = locate_template( $templates );
        if ( ! $template ) {
            $template = get_template_directory() . "/templates/{$slug}" . ( $name ? "-{$name}" : '' ) . ".php";
            if ( ! file_exists( $template ) ) {
                return;
            }
        }

        include( $template );
    }

    /**
     * Get sidebar.
     *
     * @param string $name The sidebar name (optional).
     */
    public static function get_sidebar( $name = null ) {
        if ( $name ) {
            get_sidebar( $name );
        } else {
            get_sidebar();
        }
    }

    /**
     * Get header.
     *
     * @param string $name The header name (optional).
     */
    public static function get_header( $name = null ) {
        if ( $name ) {
            get_header( $name );
        } else {
            get_header();
        }
    }

    /**
     * Get footer.
     *
     * @param string $name The footer name (optional).
     */
    public static function get_footer( $name = null ) {
        if ( $name ) {
            get_footer( $name );
        } else {
            get_footer();
        }
    }
}

// Initialize the template structure
Common_Elements_Template_Structure::get_instance();

/**
 * Helper function to get template part.
 *
 * @param string $slug The template slug.
 * @param string $name The template name (optional).
 * @param array  $args Arguments to pass to the template (optional).
 */
function common_elements_get_template_part( $slug, $name = null, $args = array() ) {
    Common_Elements_Template_Structure::get_template_part( $slug, $name, $args );
}

/**
 * Helper function to get sidebar.
 *
 * @param string $name The sidebar name (optional).
 */
function common_elements_get_sidebar( $name = null ) {
    Common_Elements_Template_Structure::get_sidebar( $name );
}

/**
 * Helper function to get header.
 *
 * @param string $name The header name (optional).
 */
function common_elements_get_header( $name = null ) {
    Common_Elements_Template_Structure::get_header( $name );
}

/**
 * Helper function to get footer.
 *
 * @param string $name The footer name (optional).
 */
function common_elements_get_footer( $name = null ) {
    Common_Elements_Template_Structure::get_footer( $name );
}
