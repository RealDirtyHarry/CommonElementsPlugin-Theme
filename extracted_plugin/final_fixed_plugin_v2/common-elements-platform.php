<?php
/**
 * Plugin Name: Common Elements Platform
 * Plugin URI: https://commonelements.com
 * Description: A custom plugin that extends WordPress functionality for the Common Elements website, providing dashboards, RFP system, directory, and more.
 * Version: 1.0.0
 * Author: Common Elements Team
 * Author URI: https://commonelements.com
 * Text Domain: common-elements-platform
 * Domain Path: /languages
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'COMMON_ELEMENTS_PLATFORM_VERSION', '1.0.0' );

/**
 * Plugin base file.
 */
define( 'COMMON_ELEMENTS_PLATFORM_FILE', __FILE__ );

/**
 * Plugin base directory.
 */
define( 'COMMON_ELEMENTS_PLATFORM_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Plugin URL.
 */
define( 'COMMON_ELEMENTS_PLATFORM_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 */
function activate_common_elements_platform() {
	require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-activator.php';
	Common_Elements_Platform_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_common_elements_platform() {
	require_once COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform-deactivator.php';
	Common_Elements_Platform_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_common_elements_platform' );
register_deactivation_hook( __FILE__, 'deactivate_common_elements_platform' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require COMMON_ELEMENTS_PLATFORM_DIR . 'includes/class-common-elements-platform.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_common_elements_platform() {
	$plugin = new Common_Elements_Platform();
	$plugin->run();
}
run_common_elements_platform();
