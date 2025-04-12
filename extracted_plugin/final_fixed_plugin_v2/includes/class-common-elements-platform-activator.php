<?php
/**
 * Fired during plugin activation
 *
 * @link       https://commonelements.com
 * @since      1.0.0
 *
 * @package    Common_Elements_Platform
 * @subpackage Common_Elements_Platform/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Common_Elements_Platform
 * @subpackage Common_Elements_Platform/includes
 * @author     Common Elements Team
 */
class Common_Elements_Platform_Activator {

	/**
	 * Activate the plugin.
	 *
	 * Initialize any plugin settings, create necessary database tables,
	 * and set up any required data structures during plugin activation.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Create custom post types
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-common-elements-platform-post-types.php';
		$post_types = new Common_Elements_Platform_Post_Types();
		$post_types->register_post_types();
		
		// Flush rewrite rules to ensure our custom post types work
		flush_rewrite_rules();
		
		// Set default options if needed
		if ( ! get_option( 'common_elements_platform_options' ) ) {
			$default_options = array(
				'enable_directory' => 'on',
				'enable_rfp' => 'on',
				'enable_forum' => 'on',
				'enable_dashboard' => 'on',
			);
			update_option( 'common_elements_platform_options', $default_options );
		}
	}
}
