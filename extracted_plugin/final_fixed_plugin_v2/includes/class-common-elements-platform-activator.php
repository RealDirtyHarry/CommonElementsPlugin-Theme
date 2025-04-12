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
