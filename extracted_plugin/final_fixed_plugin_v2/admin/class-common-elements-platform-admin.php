<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://commonelements.com
 * @since      1.0.0
 *
 * @package    Common_Elements_Platform
 * @subpackage Common_Elements_Platform/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Common_Elements_Platform
 * @subpackage Common_Elements_Platform/admin
 * @author     Common Elements Team
 */
class Common_Elements_Platform_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Common_Elements_Platform_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Common_Elements_Platform_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/common-elements-platform-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Common_Elements_Platform_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Common_Elements_Platform_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/common-elements-platform-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Register the admin menu items.
	 *
	 * @since    1.0.0
	 */
	public function add_admin_menu() {
		// Add the main menu item
		add_menu_page(
			__( 'Common Elements Platform', 'common-elements-platform' ),
			__( 'Common Elements', 'common-elements-platform' ),
			'manage_options',
			'common-elements-platform',
			array( $this, 'display_admin_dashboard' ),
			'dashicons-networking',
			30
		);
		
		// Add submenu items
		add_submenu_page(
			'common-elements-platform',
			__( 'Dashboard', 'common-elements-platform' ),
			__( 'Dashboard', 'common-elements-platform' ),
			'manage_options',
			'common-elements-platform',
			array( $this, 'display_admin_dashboard' )
		);
		
		// Add RFP submenu
		add_submenu_page(
			'common-elements-platform',
			__( 'RFP System', 'common-elements-platform' ),
			__( 'RFP System', 'common-elements-platform' ),
			'manage_options',
			'edit.php?post_type=rfp',
			null
		);
		
		// Add Proposals submenu
		add_submenu_page(
			'common-elements-platform',
			__( 'Proposals', 'common-elements-platform' ),
			__( 'Proposals', 'common-elements-platform' ),
			'manage_options',
			'edit.php?post_type=proposal',
			null
		);
		
		// Add Directory submenu
		add_submenu_page(
			'common-elements-platform',
			__( 'Directory', 'common-elements-platform' ),
			__( 'Directory', 'common-elements-platform' ),
			'manage_options',
			'edit.php?post_type=directory_listing',
			null
		);
		
		// Add Forums submenu
		add_submenu_page(
			'common-elements-platform',
			__( 'Forums', 'common-elements-platform' ),
			__( 'Forums', 'common-elements-platform' ),
			'manage_options',
			'common-elements-platform-forums',
			array( $this, 'display_admin_forums' )
		);
		
		// Add Learning Hub submenu
		add_submenu_page(
			'common-elements-platform',
			__( 'Learning Hub', 'common-elements-platform' ),
			__( 'Learning Hub', 'common-elements-platform' ),
			'manage_options',
			'common-elements-platform-learning',
			array( $this, 'display_admin_learning' )
		);
		
		// Add Settings submenu
		add_submenu_page(
			'common-elements-platform',
			__( 'Settings', 'common-elements-platform' ),
			__( 'Settings', 'common-elements-platform' ),
			'manage_options',
			'common-elements-platform-settings',
			array( $this, 'display_admin_settings' )
		);
	}
	
	/**
	 * Display the admin dashboard page.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_dashboard() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/common-elements-platform-admin-display.php';
	}
	
	/**
	 * Display the admin RFP page.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_rfp() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/common-elements-platform-admin-rfp.php';
	}
	
	/**
	 * Display the admin directory page.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_directory() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/common-elements-platform-admin-directory.php';
	}
	
	/**
	 * Display the admin forums page.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_forums() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/common-elements-platform-admin-forums.php';
	}
	
	/**
	 * Display the admin learning hub page.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_learning() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/common-elements-platform-admin-learning.php';
	}
	
	/**
	 * Display the admin settings page.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_settings() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/common-elements-platform-admin-settings.php';
	}
	
	/**
	 * Register the settings for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {
		register_setting(
			'common_elements_platform_options',
			'common_elements_platform_options',
			array( $this, 'validate_settings' )
		);
	}
	
	/**
	 * Validate the settings for the plugin.
	 *
	 * @since    1.0.0
	 * @param    array    $input    The input array to validate.
	 * @return   array              The validated input array.
	 */
	public function validate_settings( $input ) {
		// Validate platform name
		if ( isset( $input['platform_name'] ) ) {
			$input['platform_name'] = sanitize_text_field( $input['platform_name'] );
		}
		
		// Validate platform logo
		if ( isset( $input['platform_logo'] ) ) {
			$input['platform_logo'] = esc_url_raw( $input['platform_logo'] );
		}
		
		// Validate admin email
		if ( isset( $input['admin_email'] ) ) {
			$input['admin_email'] = sanitize_email( $input['admin_email'] );
		}
		
		// Validate module checkboxes
		$modules = array( 'enable_dashboard', 'enable_rfp', 'enable_directory', 'enable_forum', 'enable_learning' );
		foreach ( $modules as $module ) {
			$input[$module] = isset( $input[$module] ) ? 'on' : 'off';
		}
		
		// Validate integration settings
		if ( isset( $input['ga_id'] ) ) {
			$input['ga_id'] = sanitize_text_field( $input['ga_id'] );
		}
		
		if ( isset( $input['mailchimp_api'] ) ) {
			$input['mailchimp_api'] = sanitize_text_field( $input['mailchimp_api'] );
		}
		
		if ( isset( $input['recaptcha_site_key'] ) ) {
			$input['recaptcha_site_key'] = sanitize_text_field( $input['recaptcha_site_key'] );
		}
		
		if ( isset( $input['recaptcha_secret_key'] ) ) {
			$input['recaptcha_secret_key'] = sanitize_text_field( $input['recaptcha_secret_key'] );
		}
		
		return $input;
	}
}
