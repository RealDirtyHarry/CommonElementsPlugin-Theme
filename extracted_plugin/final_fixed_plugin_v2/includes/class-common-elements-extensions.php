<?php
/**
 * Common Elements Platform - Extensions Framework
 *
 * This file provides the architecture for extending the Common Elements Platform
 * with custom Gutenberg blocks, widgets, and shortcodes.
 *
 * @package CommonElements
 * @subpackage Extensions
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Common_Elements_Extensions' ) ) {

    /**
     * Main class for handling extensions to the Common Elements Platform
     * 
     * This class provides a framework for registering and managing custom
     * Gutenberg blocks, widgets, and shortcodes that can be added to the
     * plugin in future updates.
     * 
     * @since 1.0.0
     */
    class Common_Elements_Extensions {

        /**
         * Instance of this class.
         *
         * @since 1.0.0
         * @var object
         */
        protected static $instance = null;

        /**
         * Registered blocks.
         *
         * @since 1.0.0
         * @var array
         */
        protected $blocks = array();

        /**
         * Registered widgets.
         *
         * @since 1.0.0
         * @var array
         */
        protected $widgets = array();

        /**
         * Registered shortcodes.
         *
         * @since 1.0.0
         * @var array
         */
        protected $shortcodes = array();

        /**
         * Extension version requirements.
         *
         * @since 1.0.0
         * @var array
         */
        protected $version_requirements = array();

        /**
         * Get a single instance of this class.
         *
         * @since 1.0.0
         * @return Common_Elements_Extensions Single instance of this class.
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
            $this->init_hooks();
        }

        /**
         * Initialize hooks.
         *
         * @since 1.0.0
         * @return void
         */
        private function init_hooks() {
            add_action( 'init', array( $this, 'register_blocks' ), 20 );
            add_action( 'widgets_init', array( $this, 'register_widgets' ) );
            add_action( 'init', array( $this, 'register_shortcodes' ) );
            add_action( 'plugins_loaded', array( $this, 'load_extensions' ) );
            
            // Hook for extensions to register themselves
            do_action( 'common_elements_extensions_init', $this );
        }

        /**
         * Register a new block type.
         *
         * @since 1.0.0
         * @param string $name Block name/slug.
         * @param array  $args Block arguments.
         * @return bool True on success, false on failure.
         */
        public function register_block( $name, $args = array() ) {
            if ( empty( $name ) ) {
                return false;
            }

            $defaults = array(
                'title'           => '',
                'description'     => '',
                'category'        => 'common-elements',
                'icon'            => 'admin-generic',
                'keywords'        => array(),
                'render_callback' => null,
                'attributes'      => array(),
                'editor_script'   => '',
                'editor_style'    => '',
                'script'          => '',
                'style'           => '',
                'version'         => '1.0.0',
            );

            $args = wp_parse_args( $args, $defaults );

            // Validate required fields
            if ( empty( $args['title'] ) ) {
                return false;
            }

            $this->blocks[ $name ] = $args;

            return true;
        }

        /**
         * Register a new widget.
         *
         * @since 1.0.0
         * @param string $class_name Widget class name.
         * @param array  $args       Widget arguments.
         * @return bool True on success, false on failure.
         */
        public function register_widget( $class_name, $args = array() ) {
            if ( empty( $class_name ) || ! class_exists( $class_name ) ) {
                return false;
            }

            $defaults = array(
                'version' => '1.0.0',
            );

            $args = wp_parse_args( $args, $defaults );

            $this->widgets[ $class_name ] = $args;

            return true;
        }

        /**
         * Register a new shortcode.
         *
         * @since 1.0.0
         * @param string   $tag      Shortcode tag.
         * @param callable $callback Shortcode callback.
         * @param array    $args     Shortcode arguments.
         * @return bool True on success, false on failure.
         */
        public function register_shortcode( $tag, $callback, $args = array() ) {
            if ( empty( $tag ) || ! is_callable( $callback ) ) {
                return false;
            }

            $defaults = array(
                'description' => '',
                'attributes'  => array(),
                'version'     => '1.0.0',
            );

            $args = wp_parse_args( $args, $defaults );
            $args['callback'] = $callback;

            $this->shortcodes[ $tag ] = $args;

            return true;
        }

        /**
         * Register a version requirement for an extension.
         *
         * @since 1.0.0
         * @param string $extension_id Extension identifier.
         * @param string $min_version  Minimum required version.
         * @return bool True on success, false on failure.
         */
        public function register_version_requirement( $extension_id, $min_version ) {
            if ( empty( $extension_id ) || empty( $min_version ) ) {
                return false;
            }

            $this->version_requirements[ $extension_id ] = $min_version;

            return true;
        }

        /**
         * Check if an extension is compatible with the current version.
         *
         * @since 1.0.0
         * @param string $extension_id Extension identifier.
         * @param string $version      Extension version.
         * @return bool True if compatible, false otherwise.
         */
        public function is_compatible( $extension_id, $version ) {
            if ( ! isset( $this->version_requirements[ $extension_id ] ) ) {
                return true;
            }

            return version_compare( $version, $this->version_requirements[ $extension_id ], '>=' );
        }

        /**
         * Register all blocks with WordPress.
         *
         * @since 1.0.0
         * @return void
         */
        public function register_blocks() {
            if ( ! function_exists( 'register_block_type' ) ) {
                return;
            }

            foreach ( $this->blocks as $name => $args ) {
                $block_args = array(
                    'editor_script' => ! empty( $args['editor_script'] ) ? $args['editor_script'] : '',
                    'editor_style'  => ! empty( $args['editor_style'] ) ? $args['editor_style'] : '',
                    'script'        => ! empty( $args['script'] ) ? $args['script'] : '',
                    'style'         => ! empty( $args['style'] ) ? $args['style'] : '',
                    'attributes'    => ! empty( $args['attributes'] ) ? $args['attributes'] : array(),
                );

                if ( ! empty( $args['render_callback'] ) && is_callable( $args['render_callback'] ) ) {
                    $block_args['render_callback'] = $args['render_callback'];
                }

                register_block_type( 'common-elements/' . $name, $block_args );

                // Register block category if it doesn't exist
                add_filter( 'block_categories', function( $categories ) {
                    $category_slugs = wp_list_pluck( $categories, 'slug' );
                    
                    if ( in_array( 'common-elements', $category_slugs, true ) ) {
                        return $categories;
                    }
                    
                    return array_merge(
                        $categories,
                        array(
                            array(
                                'slug'  => 'common-elements',
                                'title' => __( 'Common Elements', 'common-elements' ),
                                'icon'  => 'admin-generic',
                            ),
                        )
                    );
                } );
            }
        }

        /**
         * Register all widgets with WordPress.
         *
         * @since 1.0.0
         * @return void
         */
        public function register_widgets() {
            foreach ( $this->widgets as $class_name => $args ) {
                if ( class_exists( $class_name ) ) {
                    register_widget( $class_name );
                }
            }
        }

        /**
         * Register all shortcodes with WordPress.
         *
         * @since 1.0.0
         * @return void
         */
        public function register_shortcodes() {
            foreach ( $this->shortcodes as $tag => $args ) {
                if ( ! empty( $args['callback'] ) && is_callable( $args['callback'] ) ) {
                    add_shortcode( $tag, $args['callback'] );
                }
            }
        }

        /**
         * Load all registered extensions.
         *
         * @since 1.0.0
         * @return void
         */
        public function load_extensions() {
            /**
             * Action hook to load extensions.
             *
             * @since 1.0.0
             * @param Common_Elements_Extensions $this Instance of this class.
             */
            do_action( 'common_elements_load_extensions', $this );
        }

        /**
         * Get all registered blocks.
         *
         * @since 1.0.0
         * @return array Registered blocks.
         */
        public function get_blocks() {
            return $this->blocks;
        }

        /**
         * Get all registered widgets.
         *
         * @since 1.0.0
         * @return array Registered widgets.
         */
        public function get_widgets() {
            return $this->widgets;
        }

        /**
         * Get all registered shortcodes.
         *
         * @since 1.0.0
         * @return array Registered shortcodes.
         */
        public function get_shortcodes() {
            return $this->shortcodes;
        }

        /**
         * Get block by name.
         *
         * @since 1.0.0
         * @param string $name Block name.
         * @return array|false Block arguments or false if not found.
         */
        public function get_block( $name ) {
            return isset( $this->blocks[ $name ] ) ? $this->blocks[ $name ] : false;
        }

        /**
         * Get widget by class name.
         *
         * @since 1.0.0
         * @param string $class_name Widget class name.
         * @return array|false Widget arguments or false if not found.
         */
        public function get_widget( $class_name ) {
            return isset( $this->widgets[ $class_name ] ) ? $this->widgets[ $class_name ] : false;
        }

        /**
         * Get shortcode by tag.
         *
         * @since 1.0.0
         * @param string $tag Shortcode tag.
         * @return array|false Shortcode arguments or false if not found.
         */
        public function get_shortcode( $tag ) {
            return isset( $this->shortcodes[ $tag ] ) ? $this->shortcodes[ $tag ] : false;
        }
    }

    // Initialize the extensions framework
    add_action( 'plugins_loaded', array( 'Common_Elements_Extensions', 'get_instance' ), 5 );
}

/**
 * Helper function to get the extensions instance.
 *
 * @since 1.0.0
 * @return Common_Elements_Extensions Instance of the extensions class.
 */
function common_elements_extensions() {
    return Common_Elements_Extensions::get_instance();
}

/**
 * Register a block with Common Elements.
 *
 * @since 1.0.0
 * @param string $name Block name/slug.
 * @param array  $args Block arguments.
 * @return bool True on success, false on failure.
 */
function ce_register_block( $name, $args = array() ) {
    return common_elements_extensions()->register_block( $name, $args );
}

/**
 * Register a widget with Common Elements.
 *
 * @since 1.0.0
 * @param string $class_name Widget class name.
 * @param array  $args       Widget arguments.
 * @return bool True on success, false on failure.
 */
function ce_register_widget( $class_name, $args = array() ) {
    return common_elements_extensions()->register_widget( $class_name, $args );
}

/**
 * Register a shortcode with Common Elements.
 *
 * @since 1.0.0
 * @param string   $tag      Shortcode tag.
 * @param callable $callback Shortcode callback.
 * @param array    $args     Shortcode arguments.
 * @return bool True on success, false on failure.
 */
function ce_register_shortcode( $tag, $callback, $args = array() ) {
    return common_elements_extensions()->register_shortcode( $tag, $callback, $args );
}

/**
 * Register a block category for Common Elements blocks.
 */
function ce_register_block_category( $categories ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'common-elements',
                'title' => __( 'Common Elements', 'common-elements' ),
                'icon'  => 'admin-generic',
            ),
        )
    );
}
add_filter( 'block_categories', 'ce_register_block_category', 10, 1 );

/**
 * Register Common Elements block category for Gutenberg.
 */
function ce_register_block_category_gutenberg( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'common-elements',
                'title' => __( 'Common Elements', 'common-elements' ),
            ),
        )
    );
}
add_filter( 'block_categories_all', 'ce_register_block_category_gutenberg', 10, 2 );

/**
 * Register block assets for Common Elements blocks.
 */
function ce_register_block_assets() {
    // Register block editor script
    wp_register_script(
        'common-elements-block-editor',
        plugins_url( 'assets/js/blocks.editor.js', dirname( __FILE__ ) ),
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-components' ),
        filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/js/blocks.editor.js' ),
        true
    );

    // Register block editor styles
    wp_register_style(
        'common-elements-block-editor',
        plugins_url( 'assets/css/blocks.editor.css', dirname( __FILE__ ) ),
        array( 'wp-edit-blocks' ),
        filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/css/blocks.editor.css' )
    );

    // Register block frontend styles
    wp_register_style(
        'common-elements-block-style',
        plugins_url( 'assets/css/blocks.style.css', dirname( __FILE__ ) ),
        array(),
        filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/css/blocks.style.css' )
    );

    // Register block localization
    if ( function_exists( 'wp_set_script_translations' ) ) {
        wp_set_script_translations( 'common-elements-block-editor', 'common-elements' );
    }
}
add_action( 'init', 'ce_register_block_assets' );

/**
 * Create necessary directories for block assets.
 */
function ce_create_block_asset_directories() {
    $plugin_dir = plugin_dir_path( dirname( __FILE__ ) );
    
    // Create directories if they don't exist
    $directories = array(
        'assets/js',
        'assets/css',
        'blocks',
        'widgets',
        'shortcodes',
    );
    
    foreach ( $directories as $directory ) {
        $dir_path = $plugin_dir . $directory;
        if ( ! file_exists( $dir_path ) ) {
            wp_mkdir_p( $dir_path );
        }
    }
    
    // Create placeholder files
    $placeholder_files = array(
        'assets/js/blocks.editor.js' => '// Common Elements Block Editor Scripts',
        'assets/css/blocks.editor.css' => '/* Common Elements Block Editor Styles */',
        'assets/css/blocks.style.css' => '/* Common Elements Block Frontend Styles */',
    );
    
    foreach ( $placeholder_files as $file => $content ) {
        $file_path = $plugin_dir . $file;
        if ( ! file_exists( $file_path ) ) {
            file_put_contents( $file_path, $content );
        }
    }
}
register_activation_hook( dirname( dirname( __FILE__ ) ) . '/common-elements-platform.php', 'ce_create_block_asset_directories' );
