<?php
/**
 * Template loader for the plugin.
 *
 * @package Common_Elements_Platform
 */

/**
 * Class responsible for loading templates.
 *
 * This class provides a comprehensive template system for the plugin,
 * including template hierarchy, overrides, and debugging.
 *
 * @since 1.0.0
 */
class Common_Elements_Platform_Template_Loader {

    /**
     * The single instance of this class.
     *
     * @since 1.0.0
     * @access private
     * @var Common_Elements_Platform_Template_Loader
     */
    private static $instance = null;

    /**
     * Template directory name in theme.
     *
     * @since 1.0.0
     * @access private
     * @var string
     */
    private $theme_template_directory = 'common-elements';

    /**
     * Template directory name in plugin.
     *
     * @since 1.0.0
     * @access private
     * @var string
     */
    private $plugin_template_directory = 'templates';

    /**
     * Debug mode.
     *
     * @since 1.0.0
     * @access private
     * @var bool
     */
    private $debug = false;

    /**
     * Get the single instance of this class.
     *
     * @since 1.0.0
     * @return Common_Elements_Platform_Template_Loader
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
        // Check if debug mode is enabled
        $options = get_option( 'common_elements_platform_options', array() );
        $this->debug = isset( $options['debug_mode'] ) && $options['debug_mode'] === 'on';
    }

    /**
     * Get template part.
     *
     * Looks for the template in the theme first, then falls back to the plugin.
     *
     * @since 1.0.0
     * @param string $slug The template slug.
     * @param string $name The template name (optional).
     * @param array  $args Arguments to pass to the template (optional).
     * @return void
     */
    public function get_template_part( $slug, $name = null, $args = array() ) {
        if ( $args && is_array( $args ) ) {
            extract( $args );
        }

        $template = $this->locate_template( array(
            $this->get_template_filename( $slug, $name ),
            $this->get_template_filename( $slug ),
        ) );

        // Allow 3rd party plugins to filter template file from their plugin.
        $template = apply_filters( 'common_elements_get_template_part', $template, $slug, $name );

        if ( $template ) {
            include( $template );
        }
    }

    /**
     * Get template filename with extension.
     *
     * @since 1.0.0
     * @param string $slug The template slug.
     * @param string $name The template name (optional).
     * @return string
     */
    private function get_template_filename( $slug, $name = null ) {
        if ( $name ) {
            return $slug . '-' . $name . '.php';
        } else {
            return $slug . '.php';
        }
    }

    /**
     * Locate template.
     *
     * Locate the template file, looking first in the theme, then in the plugin.
     *
     * @since 1.0.0
     * @param array|string $template_names Template file(s) to search for.
     * @return string The template filename if found, empty string otherwise.
     */
    public function locate_template( $template_names ) {
        $located = '';

        // Convert to array if string
        if ( ! is_array( $template_names ) ) {
            $template_names = array( $template_names );
        }

        // Look in theme first
        foreach ( $template_names as $template_name ) {
            if ( empty( $template_name ) ) {
                continue;
            }

            // Check theme template directory
            $theme_template = $this->get_theme_template_path( $template_name );
            if ( file_exists( $theme_template ) ) {
                $located = $theme_template;
                break;
            }
        }

        // If not found in theme, look in plugin
        if ( empty( $located ) ) {
            foreach ( $template_names as $template_name ) {
                if ( empty( $template_name ) ) {
                    continue;
                }

                // Check plugin template directory
                $plugin_template = $this->get_plugin_template_path( $template_name );
                if ( file_exists( $plugin_template ) ) {
                    $located = $plugin_template;
                    break;
                }
            }
        }

        // Debug template location
        if ( $this->debug && ! empty( $located ) ) {
            $this->debug_template_location( $located, $template_names );
        }

        return $located;
    }

    /**
     * Get theme template path.
     *
     * @since 1.0.0
     * @param string $template_name Template name.
     * @return string
     */
    private function get_theme_template_path( $template_name ) {
        return trailingslashit( get_stylesheet_directory() ) . trailingslashit( $this->theme_template_directory ) . $template_name;
    }

    /**
     * Get plugin template path.
     *
     * @since 1.0.0
     * @param string $template_name Template name.
     * @return string
     */
    private function get_plugin_template_path( $template_name ) {
        return trailingslashit( COMMON_ELEMENTS_PLATFORM_DIR ) . trailingslashit( $this->plugin_template_directory ) . $template_name;
    }

    /**
     * Debug template location.
     *
     * @since 1.0.0
     * @param string $located       The located template.
     * @param array  $template_names Template names that were searched.
     * @return void
     */
    private function debug_template_location( $located, $template_names ) {
        $debug_message = sprintf(
            '<div class="common-elements-template-debug"><p>Template: %s</p><p>Searched: %s</p></div>',
            esc_html( $located ),
            esc_html( implode( ', ', $template_names ) )
        );

        if ( is_admin() ) {
            echo $debug_message;
        } else {
            add_action( 'wp_footer', function() use ( $debug_message ) {
                echo $debug_message;
            } );
        }
    }

    /**
     * Get template.
     *
     * Load a template file.
     *
     * @since 1.0.0
     * @param string $template_name Template name.
     * @param array  $args          Arguments to pass to the template (optional).
     * @param bool   $load          Whether to load the template (default: true).
     * @return string
     */
    public function get_template( $template_name, $args = array(), $load = true ) {
        $located = $this->locate_template( $template_name );

        if ( ! $located ) {
            return '';
        }

        // Allow 3rd party plugins to filter template file from their plugin.
        $located = apply_filters( 'common_elements_get_template', $located, $template_name, $args );

        do_action( 'common_elements_before_template', $template_name, $located, $args );

        if ( $args && is_array( $args ) ) {
            extract( $args );
        }

        if ( $load ) {
            include( $located );
        }

        do_action( 'common_elements_after_template', $template_name, $located, $args );

        return $located;
    }

    /**
     * Get template content.
     *
     * Load a template file and return its content.
     *
     * @since 1.0.0
     * @param string $template_name Template name.
     * @param array  $args          Arguments to pass to the template (optional).
     * @return string
     */
    public function get_template_content( $template_name, $args = array() ) {
        ob_start();
        $this->get_template( $template_name, $args );
        return ob_get_clean();
    }

    /**
     * Set template data.
     *
     * Make data available to a template.
     *
     * @since 1.0.0
     * @param array  $data          Data to set.
     * @param string $template_name Template name.
     * @return void
     */
    public function set_template_data( $data, $template_name ) {
        // Store data in a global variable
        global $common_elements_template_data;
        
        if ( ! isset( $common_elements_template_data ) ) {
            $common_elements_template_data = array();
        }
        
        $common_elements_template_data[ $template_name ] = $data;
    }

    /**
     * Get template data.
     *
     * Get data that was previously set for a template.
     *
     * @since 1.0.0
     * @param string $template_name Template name.
     * @return array|null
     */
    public function get_template_data( $template_name ) {
        global $common_elements_template_data;
        
        if ( isset( $common_elements_template_data[ $template_name ] ) ) {
            return $common_elements_template_data[ $template_name ];
        }
        
        return null;
    }

    /**
     * Include template.
     *
     * Include a template file, looking first in the theme, then in the plugin.
     *
     * @since 1.0.0
     * @param string $template_name Template name.
     * @param array  $args          Arguments to pass to the template (optional).
     * @return bool
     */
    public function include_template( $template_name, $args = array() ) {
        $located = $this->locate_template( $template_name );
        
        if ( ! $located ) {
            return false;
        }
        
        if ( $args && is_array( $args ) ) {
            extract( $args );
        }
        
        include( $located );
        
        return true;
    }

    /**
     * Get template path.
     *
     * Get the path to a template file.
     *
     * @since 1.0.0
     * @param string $template_name Template name.
     * @return string|bool
     */
    public function get_template_path( $template_name ) {
        $located = $this->locate_template( $template_name );
        
        if ( ! $located ) {
            return false;
        }
        
        return $located;
    }

    /**
     * Check if template exists.
     *
     * @since 1.0.0
     * @param string $template_name Template name.
     * @return bool
     */
    public function template_exists( $template_name ) {
        $located = $this->locate_template( $template_name );
        
        return ! empty( $located );
    }

    /**
     * Set theme template directory.
     *
     * @since 1.0.0
     * @param string $directory Directory name.
     * @return void
     */
    public function set_theme_template_directory( $directory ) {
        $this->theme_template_directory = sanitize_file_name( $directory );
    }

    /**
     * Get theme template directory.
     *
     * @since 1.0.0
     * @return string
     */
    public function get_theme_template_directory() {
        return $this->theme_template_directory;
    }

    /**
     * Set plugin template directory.
     *
     * @since 1.0.0
     * @param string $directory Directory name.
     * @return void
     */
    public function set_plugin_template_directory( $directory ) {
        $this->plugin_template_directory = sanitize_file_name( $directory );
    }

    /**
     * Get plugin template directory.
     *
     * @since 1.0.0
     * @return string
     */
    public function get_plugin_template_directory() {
        return $this->plugin_template_directory;
    }

    /**
     * Set debug mode.
     *
     * @since 1.0.0
     * @param bool $debug Debug mode.
     * @return void
     */
    public function set_debug( $debug ) {
        $this->debug = (bool) $debug;
    }

    /**
     * Get debug mode.
     *
     * @since 1.0.0
     * @return bool
     */
    public function get_debug() {
        return $this->debug;
    }
}
