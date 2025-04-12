<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://commonelements.com
 * @since      1.0.0
 *
 * @package    Common_Elements_Platform
 * @subpackage Common_Elements_Platform/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Common_Elements_Platform
 * @subpackage Common_Elements_Platform/includes
 * @author     Common Elements Team
 */
class Common_Elements_Platform_Deactivator {

	/**
	 * Deactivate the plugin.
	 *
	 * Clean up any plugin data, remove temporary files,
	 * and perform any necessary cleanup operations during plugin deactivation.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Flush rewrite rules to remove our custom post types
		flush_rewrite_rules();
		
		// Any additional cleanup can be added here
		// Note: We're not removing options or custom post type data to preserve user data
	}
}
