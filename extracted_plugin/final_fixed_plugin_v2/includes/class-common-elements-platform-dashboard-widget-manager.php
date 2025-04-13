<?php
/**
 * Dashboard Widget Manager
 *
 * @package Common_Elements_Platform
 */

/**
 * Dashboard Widget Manager Class
 *
 * Manages dashboard widgets including registration, positioning, and settings.
 */
class Common_Elements_Platform_Dashboard_Widget_Manager {

	/**
	 * @var Common_Elements_Platform_Dashboard_Widget_Manager Singleton instance
	 */
	private static $instance = null;

	/**
	 * @var array Registered widgets
	 */
	private $widgets = array();

	/**
	 * Get singleton instance
	 *
	 * @return Common_Elements_Platform_Dashboard_Widget_Manager
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'register_default_widgets' ) );
		add_action( 'wp_ajax_ce_ajax_save_widget_position', array( $this, 'ajax_save_widget_position' ) );
		add_action( 'wp_ajax_ce_ajax_get_widget_settings', array( $this, 'ajax_get_widget_settings' ) );
		add_action( 'wp_ajax_ce_ajax_save_widget_settings', array( $this, 'ajax_save_widget_settings' ) );
		add_action( 'wp_ajax_ce_ajax_add_widget', array( $this, 'ajax_add_widget' ) );
		add_action( 'wp_ajax_ce_ajax_remove_widget', array( $this, 'ajax_remove_widget' ) );
		add_action( 'wp_ajax_ce_ajax_refresh_widget', array( $this, 'ajax_refresh_widget' ) );
	}

	/**
	 * Register default widgets
	 */
	public function register_default_widgets() {
		$this->register_widget( 'rfp', array(
			'title' => 'RFP Management',
			'description' => 'Manage and view Request for Proposals',
			'icon' => 'fa-file-contract',
			'roles' => array( 'administrator', 'editor', 'author', 'contributor' ),
			'callback' => array( $this, 'render_rfp_widget' ),
			'settings' => array(
				'show_open_rfps' => true,
				'show_closed_rfps' => false,
				'max_items' => 5,
			),
		));

		$this->register_widget( 'directory', array(
			'title' => 'Vendor Directory',
			'description' => 'Browse and search vendor directory',
			'icon' => 'fa-address-book',
			'roles' => array( 'administrator', 'editor', 'author', 'contributor', 'subscriber' ),
			'callback' => array( $this, 'render_directory_widget' ),
			'settings' => array(
				'show_categories' => true,
				'show_locations' => true,
				'max_items' => 5,
			),
		));

		$this->register_widget( 'forum', array(
			'title' => 'Community Forum',
			'description' => 'Recent forum topics and discussions',
			'icon' => 'fa-comments',
			'roles' => array( 'administrator', 'editor', 'author', 'contributor', 'subscriber' ),
			'callback' => array( $this, 'render_forum_widget' ),
			'settings' => array(
				'show_recent_topics' => true,
				'show_popular_topics' => false,
				'max_items' => 5,
			),
		));

		$this->register_widget( 'learning', array(
			'title' => 'Learning Hub',
			'description' => 'Access courses and track learning progress',
			'icon' => 'fa-graduation-cap',
			'roles' => array( 'administrator', 'editor', 'author', 'contributor', 'subscriber' ),
			'callback' => array( $this, 'render_learning_widget' ),
			'settings' => array(
				'show_my_courses' => true,
				'show_recommended_courses' => true,
				'max_items' => 3,
			),
		));

		$this->register_widget( 'calendar', array(
			'title' => 'Calendar',
			'description' => 'View upcoming events and deadlines',
			'icon' => 'fa-calendar-alt',
			'roles' => array( 'administrator', 'editor', 'author', 'contributor', 'subscriber' ),
			'callback' => array( $this, 'render_calendar_widget' ),
			'settings' => array(
				'show_community_events' => true,
				'show_personal_events' => true,
				'days_ahead' => 30,
			),
		));

		$this->register_widget( 'stats', array(
			'title' => 'Statistics',
			'description' => 'View community and platform statistics',
			'icon' => 'fa-chart-bar',
			'roles' => array( 'administrator', 'editor' ),
			'callback' => array( $this, 'render_stats_widget' ),
			'settings' => array(
				'show_member_stats' => true,
				'show_activity_stats' => true,
				'show_learning_stats' => true,
			),
		));
	}

	/**
	 * Register a widget
	 *
	 * @param string $id Widget ID
	 * @param array $args Widget arguments
	 */
	public function register_widget( $id, $args ) {
		$this->widgets[ $id ] = wp_parse_args( $args, array(
			'title' => '',
			'description' => '',
			'icon' => 'fa-cube',
			'roles' => array( 'administrator' ),
			'callback' => null,
			'settings' => array(),
		));
	}

	/**
	 * Get all registered widgets
	 *
	 * @return array Registered widgets
	 */
	public function get_widgets() {
		return $this->widgets;
	}
	
	/**
	 * Get widget by ID
	 *
	 * @param string $id Widget ID
	 * @return array|null Widget data or null if not found
	 */
	public function get_widget( $id ) {
		return isset( $this->widgets[ $id ] ) ? $this->widgets[ $id ] : null;
	}

	/**
	 * Get widgets for a specific user role
	 *
	 * @param string $role User role
	 * @return array Widgets available for the role
	 */
	public function get_widgets_for_role( $role ) {
		$widgets = array();
		
		foreach ( $this->widgets as $id => $widget ) {
			if ( in_array( $role, $widget['roles'], true ) ) {
				$widgets[ $id ] = $widget;
			}
		}
		
		return $widgets;
	}

	/**
	 * Get user dashboard widgets
	 *
	 * @param int $user_id User ID
	 * @return array User dashboard widgets
	 */
	public function get_user_dashboard_widgets( $user_id ) {
		$user_widgets = get_user_meta( $user_id, 'ce_dashboard_widgets', true );
		
		if ( ! $user_widgets ) {
			$user_widgets = $this->get_default_dashboard_widgets( $user_id );
			update_user_meta( $user_id, 'ce_dashboard_widgets', $user_widgets );
		}
		
		return $user_widgets;
	}

	/**
	 * Get default dashboard widgets for a user
	 *
	 * @param int $user_id User ID
	 * @return array Default dashboard widgets
	 */
	public function get_default_dashboard_widgets( $user_id ) {
		$user = get_userdata( $user_id );
		$role = $user->roles[0];
		
		$default_widgets = array(
			'column_1' => array(),
			'column_2' => array(),
		);
		
		if ( 'administrator' === $role ) {
			$default_widgets['column_1'] = array(
				array( 'id' => 'stats', 'settings' => array() ),
				array( 'id' => 'rfp', 'settings' => array() ),
			);
			$default_widgets['column_2'] = array(
				array( 'id' => 'calendar', 'settings' => array() ),
				array( 'id' => 'forum', 'settings' => array() ),
			);
		}
		elseif ( 'editor' === $role ) {
			$default_widgets['column_1'] = array(
				array( 'id' => 'rfp', 'settings' => array() ),
				array( 'id' => 'directory', 'settings' => array() ),
			);
			$default_widgets['column_2'] = array(
				array( 'id' => 'calendar', 'settings' => array() ),
				array( 'id' => 'learning', 'settings' => array() ),
			);
		}
		elseif ( 'contributor' === $role ) {
			$default_widgets['column_1'] = array(
				array( 'id' => 'rfp', 'settings' => array() ),
				array( 'id' => 'directory', 'settings' => array() ),
			);
			$default_widgets['column_2'] = array(
				array( 'id' => 'calendar', 'settings' => array() ),
				array( 'id' => 'forum', 'settings' => array() ),
			);
		}
		else {
			$default_widgets['column_1'] = array(
				array( 'id' => 'forum', 'settings' => array() ),
				array( 'id' => 'directory', 'settings' => array() ),
			);
			$default_widgets['column_2'] = array(
				array( 'id' => 'calendar', 'settings' => array() ),
				array( 'id' => 'learning', 'settings' => array() ),
			);
		}
		
		return $default_widgets;
	}
	
	/**
	 * Render dashboard widgets
	 *
	 * @param int $user_id User ID
	 */
	public function render_dashboard_widgets( $user_id ) {
		$user_widgets = $this->get_user_dashboard_widgets( $user_id );
		
		echo '<div class="ce-dashboard-widgets">';
		
		foreach ( $user_widgets as $column_id => $widgets ) {
			echo '<div class="ce-dashboard-column" data-column="' . esc_attr( $column_id ) . '">';
			
			foreach ( $widgets as $widget ) {
				$this->render_widget( $widget['id'], $widget['settings'] );
			}
			
			echo '</div>';
		}
		
		echo '</div>';
		
		echo '<div class="ce-dashboard-add-widget-container">';
		echo '<button class="ce-dashboard-add-widget"><i class="fas fa-plus ce-dashboard-add-widget-icon"></i> Add Widget</button>';
		echo '</div>';
		
		$this->render_widget_types_modal( $user_id );
	}

	/**
	 * Render a single widget
	 *
	 * @param string $widget_id Widget ID
	 * @param array $settings Widget settings
	 */
	public function render_widget( $widget_id, $settings = array() ) {
		$widget = $this->get_widget( $widget_id );
		
		if ( ! $widget ) {
			return;
		}
		
		$settings = wp_parse_args( $settings, $widget['settings'] );
		
		$instance_id = 'ce-widget-' . $widget_id . '-' . uniqid();
		
		echo '<div class="ce-dashboard-widget" id="' . esc_attr( $instance_id ) . '" data-widget-id="' . esc_attr( $widget_id ) . '">';
		echo '<div class="ce-dashboard-widget-header">';
		echo '<h3 class="ce-dashboard-widget-title"><i class="fas ' . esc_attr( $widget['icon'] ) . '"></i> ' . esc_html( $widget['title'] ) . '</h3>';
		echo '<div class="ce-dashboard-widget-actions">';
		echo '<button class="ce-dashboard-widget-toggle" title="Toggle widget"><i class="fas fa-chevron-up"></i></button>';
		echo '<button class="ce-dashboard-widget-settings" title="Widget settings"><i class="fas fa-cog"></i></button>';
		echo '<button class="ce-dashboard-widget-remove" title="Remove widget"><i class="fas fa-times"></i></button>';
		echo '</div>';
		echo '</div>';
		echo '<div class="ce-dashboard-widget-content">';
		
		if ( is_callable( $widget['callback'] ) ) {
			call_user_func( $widget['callback'], $settings );
		}
		
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Render widget types modal
	 *
	 * @param int $user_id User ID
	 */
	public function render_widget_types_modal( $user_id ) {
		$user = get_userdata( $user_id );
		$role = $user->roles[0];
		$available_widgets = $this->get_widgets_for_role( $role );
		
		echo '<div class="ce-dashboard-widget-types-modal" style="display: none;">';
		echo '<div class="ce-dashboard-widget-types-content">';
		echo '<div class="ce-dashboard-widget-types-header">';
		echo '<h3 class="ce-dashboard-widget-types-title">Add Widget</h3>';
		echo '<button class="ce-dashboard-widget-types-close"><i class="fas fa-times"></i></button>';
		echo '</div>';
		echo '<div class="ce-dashboard-widget-types-body">';
		echo '<div class="ce-dashboard-widget-types">';
		
		foreach ( $available_widgets as $id => $widget ) {
			echo '<div class="ce-dashboard-widget-type">';
			echo '<button class="ce-dashboard-widget-type-button" data-widget-id="' . esc_attr( $id ) . '">';
			echo '<div class="ce-dashboard-widget-type-icon"><i class="fas ' . esc_attr( $widget['icon'] ) . '"></i></div>';
			echo '<h4 class="ce-dashboard-widget-type-title">' . esc_html( $widget['title'] ) . '</h4>';
			echo '<p class="ce-dashboard-widget-type-description">' . esc_html( $widget['description'] ) . '</p>';
			echo '</button>';
			echo '</div>';
		}
		
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
	
	/**
	 * AJAX: Save widget position
	 */
	public function ajax_save_widget_position() {
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		$widget_id = isset( $_POST['widget_id'] ) ? sanitize_text_field( $_POST['widget_id'] ) : '';
		$column = isset( $_POST['column'] ) ? sanitize_text_field( $_POST['column'] ) : '';
		$position = isset( $_POST['position'] ) ? intval( $_POST['position'] ) : 0;
		
		if ( ! $widget_id || ! $column ) {
			wp_send_json_error( array( 'message' => 'Invalid widget data' ) );
			return;
		}
		
		$user_id = get_current_user_id();
		$user_widgets = $this->get_user_dashboard_widgets( $user_id );
		
		$found = false;
		$widget_data = null;
		
		foreach ( $user_widgets as $col_id => $widgets ) {
			foreach ( $widgets as $key => $widget ) {
				if ( $widget['id'] === $widget_id ) {
					$widget_data = $widget;
					unset( $user_widgets[ $col_id ][ $key ] );
					$user_widgets[ $col_id ] = array_values( $user_widgets[ $col_id ] );
					$found = true;
					break;
				}
			}
			
			if ( $found ) {
				break;
			}
		}
		
		if ( ! $found || ! $widget_data ) {
			wp_send_json_error( array( 'message' => 'Widget not found' ) );
			return;
		}
		
		if ( ! isset( $user_widgets[ $column ] ) ) {
			$user_widgets[ $column ] = array();
		}
		
		array_splice( $user_widgets[ $column ], $position, 0, array( $widget_data ) );
		
		update_user_meta( $user_id, 'ce_dashboard_widgets', $user_widgets );
		
		wp_send_json_success();
	}

	/**
	 * AJAX: Get widget settings
	 */
	public function ajax_get_widget_settings() {
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		$widget_id = isset( $_POST['widget_id'] ) ? sanitize_text_field( $_POST['widget_id'] ) : '';
		
		if ( ! $widget_id ) {
			wp_send_json_error( array( 'message' => 'Invalid widget ID' ) );
			return;
		}
		
		$widget = $this->get_widget( $widget_id );
		
		if ( ! $widget ) {
			wp_send_json_error( array( 'message' => 'Widget not found' ) );
			return;
		}
		
		$user_id = get_current_user_id();
		$user_widgets = $this->get_user_dashboard_widgets( $user_id );
		
		$found = false;
		$widget_settings = array();
		
		foreach ( $user_widgets as $col_id => $widgets ) {
			foreach ( $widgets as $key => $widget_data ) {
				if ( $widget_data['id'] === $widget_id ) {
					$widget_settings = $widget_data['settings'];
					$found = true;
					break;
				}
			}
			
			if ( $found ) {
				break;
			}
		}
		
		if ( ! $found ) {
			$widget_settings = $widget['settings'];
		}
		
		ob_start();
		
		echo '<div class="ce-dashboard-widget-settings-form">';
		echo '<form id="ce-widget-settings-form-' . esc_attr( $widget_id ) . '">';
		
		foreach ( $widget['settings'] as $key => $default_value ) {
			$value = isset( $widget_settings[ $key ] ) ? $widget_settings[ $key ] : $default_value;
			$label = ucwords( str_replace( '_', ' ', $key ) );
			
			echo '<div class="ce-form-group">';
			
			if ( is_bool( $default_value ) ) {
				echo '<div class="ce-checkbox">';
				echo '<input type="checkbox" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="1" ' . checked( $value, true, false ) . '>';
				echo '<label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label>';
				echo '</div>';
			} elseif ( is_int( $default_value ) ) {
				echo '<label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label>';
				echo '<input type="number" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
			} else {
				echo '<label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label>';
				echo '<input type="text" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
			}
			
			echo '</div>';
		}
		
		echo '</form>';
		echo '</div>';
		
		$settings_html = ob_get_clean();
		
		ob_start();
		
		echo '<div class="ce-dashboard-widget-settings-content">';
		echo '<div class="ce-dashboard-widget-settings-header">';
		echo '<h3 class="ce-dashboard-widget-settings-title">' . esc_html( $widget['title'] ) . ' Settings</h3>';
		echo '<button class="ce-dashboard-widget-settings-close"><i class="fas fa-times"></i></button>';
		echo '</div>';
		echo '<div class="ce-dashboard-widget-settings-body">';
		echo $settings_html;
		echo '</div>';
		echo '<div class="ce-dashboard-widget-settings-footer">';
		echo '<button class="ce-dashboard-widget-settings-cancel">Cancel</button>';
		echo '<button class="ce-dashboard-widget-settings-save">Save Settings</button>';
		echo '</div>';
		echo '</div>';
		
		$html = ob_get_clean();
		
		wp_send_json_success( array( 'html' => $html ) );
	}
	
	/**
	 * AJAX: Save widget settings
	 */
	public function ajax_save_widget_settings() {
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		$widget_id = isset( $_POST['widget_id'] ) ? sanitize_text_field( $_POST['widget_id'] ) : '';
		$form_data = isset( $_POST['form_data'] ) ? $_POST['form_data'] : '';
		
		if ( ! $widget_id || ! $form_data ) {
			wp_send_json_error( array( 'message' => 'Invalid widget data' ) );
			return;
		}
		
		$widget = $this->get_widget( $widget_id );
		
		if ( ! $widget ) {
			wp_send_json_error( array( 'message' => 'Widget not found' ) );
			return;
		}
		
		parse_str( $form_data, $settings );
		
		$sanitized_settings = array();
		
		foreach ( $widget['settings'] as $key => $default_value ) {
			if ( is_bool( $default_value ) ) {
				$sanitized_settings[ $key ] = isset( $settings[ $key ] ) ? true : false;
			} elseif ( is_int( $default_value ) ) {
				$sanitized_settings[ $key ] = isset( $settings[ $key ] ) ? intval( $settings[ $key ] ) : $default_value;
			} else {
				$sanitized_settings[ $key ] = isset( $settings[ $key ] ) ? sanitize_text_field( $settings[ $key ] ) : $default_value;
			}
		}
		
		$user_id = get_current_user_id();
		$user_widgets = $this->get_user_dashboard_widgets( $user_id );
		
		foreach ( $user_widgets as $col_id => $widgets ) {
			foreach ( $widgets as $key => $widget_data ) {
				if ( $widget_data['id'] === $widget_id ) {
					$user_widgets[ $col_id ][ $key ]['settings'] = $sanitized_settings;
					break;
				}
			}
		}
		
		update_user_meta( $user_id, 'ce_dashboard_widgets', $user_widgets );
		
		wp_send_json_success();
	}
	
	/**
	 * AJAX: Add widget
	 */
	public function ajax_add_widget() {
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		$widget_type = isset( $_POST['widget_type'] ) ? sanitize_text_field( $_POST['widget_type'] ) : '';
		
		if ( ! $widget_type ) {
			wp_send_json_error( array( 'message' => 'Invalid widget type' ) );
			return;
		}
		
		$widget = $this->get_widget( $widget_type );
		
		if ( ! $widget ) {
			wp_send_json_error( array( 'message' => 'Widget type not found' ) );
			return;
		}
		
		$user_id = get_current_user_id();
		$user = get_userdata( $user_id );
		$role = $user->roles[0];
		
		if ( ! in_array( $role, $widget['roles'], true ) ) {
			wp_send_json_error( array( 'message' => 'Widget not available for your role' ) );
			return;
		}
		
		$user_widgets = $this->get_user_dashboard_widgets( $user_id );
		
		$new_widget = array(
			'id' => $widget_type,
			'settings' => $widget['settings'],
		);
		
		$user_widgets['column_1'][] = $new_widget;
		
		update_user_meta( $user_id, 'ce_dashboard_widgets', $user_widgets );
		
		ob_start();
		$this->render_widget( $widget_type, $widget['settings'] );
		$html = ob_get_clean();
		
		wp_send_json_success( array( 'html' => $html ) );
	}
	
	/**
	 * AJAX: Remove widget
	 */
	public function ajax_remove_widget() {
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		$widget_id = isset( $_POST['widget_id'] ) ? sanitize_text_field( $_POST['widget_id'] ) : '';
		
		if ( ! $widget_id ) {
			wp_send_json_error( array( 'message' => 'Invalid widget ID' ) );
			return;
		}
		
		$user_id = get_current_user_id();
		$user_widgets = $this->get_user_dashboard_widgets( $user_id );
		
		$found = false;
		
		foreach ( $user_widgets as $col_id => $widgets ) {
			foreach ( $widgets as $key => $widget ) {
				if ( $widget['id'] === $widget_id ) {
					unset( $user_widgets[ $col_id ][ $key ] );
					$user_widgets[ $col_id ] = array_values( $user_widgets[ $col_id ] );
					$found = true;
					break;
				}
			}
			
			if ( $found ) {
				break;
			}
		}
		
		if ( ! $found ) {
			wp_send_json_error( array( 'message' => 'Widget not found' ) );
			return;
		}
		
		update_user_meta( $user_id, 'ce_dashboard_widgets', $user_widgets );
		
		wp_send_json_success();
	}

	/**
	 * AJAX: Refresh widget
	 */
	public function ajax_refresh_widget() {
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		$widget_id = isset( $_POST['widget_id'] ) ? sanitize_text_field( $_POST['widget_id'] ) : '';
		
		if ( ! $widget_id ) {
			wp_send_json_error( array( 'message' => 'Invalid widget ID' ) );
			return;
		}
		
		$widget = $this->get_widget( $widget_id );
		
		if ( ! $widget ) {
			wp_send_json_error( array( 'message' => 'Widget not found' ) );
			return;
		}
		
		$user_id = get_current_user_id();
		$user_widgets = $this->get_user_dashboard_widgets( $user_id );
		
		$found = false;
		$widget_settings = array();
		
		foreach ( $user_widgets as $col_id => $widgets ) {
			foreach ( $widgets as $widget_data ) {
				if ( $widget_data['id'] === $widget_id ) {
					$widget_settings = $widget_data['settings'];
					$found = true;
					break;
				}
			}
			
			if ( $found ) {
				break;
			}
		}
		
		if ( ! $found ) {
			$widget_settings = $widget['settings'];
		}
		
		ob_start();
		$this->render_widget( $widget_id, $widget_settings );
		$html = ob_get_clean();
		
		wp_send_json_success( array( 'html' => $html ) );
	}
	
	/**
	 * Render RFP widget
	 *
	 * @param array $settings Widget settings
	 */
	public function render_rfp_widget( $settings ) {
		$args = array(
			'post_type' => 'rfp',
			'posts_per_page' => $settings['max_items'],
			'meta_query' => array(),
		);
		
		if ( $settings['show_open_rfps'] && ! $settings['show_closed_rfps'] ) {
			$args['meta_query'][] = array(
				'key' => '_rfp_status',
				'value' => 'open',
				'compare' => '=',
			);
		} elseif ( ! $settings['show_open_rfps'] && $settings['show_closed_rfps'] ) {
			$args['meta_query'][] = array(
				'key' => '_rfp_status',
				'value' => 'closed',
				'compare' => '=',
			);
		}
		
		$rfps = get_posts( $args );
		
		if ( empty( $rfps ) ) {
			echo '<p class="ce-widget-empty-message">No RFPs found.</p>';
			return;
		}
		
		echo '<ul class="ce-rfp-list">';
		
		foreach ( $rfps as $rfp ) {
			$status = get_post_meta( $rfp->ID, '_rfp_status', true );
			$deadline = get_post_meta( $rfp->ID, '_rfp_deadline', true );
			
			echo '<li class="ce-rfp-item ce-rfp-status-' . esc_attr( $status ) . '">';
			echo '<h4 class="ce-rfp-title"><a href="' . esc_url( get_permalink( $rfp->ID ) ) . '">' . esc_html( $rfp->post_title ) . '</a></h4>';
			
			if ( $deadline ) {
				echo '<div class="ce-rfp-deadline">Deadline: ' . esc_html( date( 'F j, Y', strtotime( $deadline ) ) ) . '</div>';
			}
			
			echo '<div class="ce-rfp-status">Status: <span class="ce-rfp-status-badge ce-rfp-status-' . esc_attr( $status ) . '">' . esc_html( ucfirst( $status ) ) . '</span></div>';
			echo '</li>';
		}
		
		echo '</ul>';
		
		echo '<div class="ce-widget-footer">';
		echo '<a href="' . esc_url( home_url( '/rfps/' ) ) . '" class="ce-button ce-button-small">View All RFPs</a>';
		echo '</div>';
	}
	
	/**
	 * Render Directory widget
	 *
	 * @param array $settings Widget settings
	 */
	public function render_directory_widget( $settings ) {
		$args = array(
			'post_type' => 'vendor',
			'posts_per_page' => $settings['max_items'],
		);
		
		$vendors = get_posts( $args );
		
		if ( empty( $vendors ) ) {
			echo '<p class="ce-widget-empty-message">No vendors found.</p>';
			return;
		}
		
		echo '<ul class="ce-directory-list">';
		
		foreach ( $vendors as $vendor ) {
			$categories = get_the_terms( $vendor->ID, 'vendor_category' );
			$location = get_post_meta( $vendor->ID, '_vendor_location', true );
			
			echo '<li class="ce-directory-item">';
			echo '<h4 class="ce-directory-title"><a href="' . esc_url( get_permalink( $vendor->ID ) ) . '">' . esc_html( $vendor->post_title ) . '</a></h4>';
			
			if ( $settings['show_categories'] && ! empty( $categories ) && ! is_wp_error( $categories ) ) {
				echo '<div class="ce-directory-categories">';
				$category_names = array();
				
				foreach ( $categories as $category ) {
					$category_names[] = $category->name;
				}
				
				echo 'Categories: ' . esc_html( implode( ', ', $category_names ) );
				echo '</div>';
			}
			
			if ( $settings['show_locations'] && $location ) {
				echo '<div class="ce-directory-location">Location: ' . esc_html( $location ) . '</div>';
			}
			
			echo '</li>';
		}
		
		echo '</ul>';
		
		echo '<div class="ce-widget-footer">';
		echo '<a href="' . esc_url( home_url( '/directory/' ) ) . '" class="ce-button ce-button-small">View Full Directory</a>';
		echo '</div>';
	}
	
	/**
	 * Render Forum widget
	 *
	 * @param array $settings Widget settings
	 */
	public function render_forum_widget( $settings ) {
		$args = array(
			'post_type' => 'forum_topic',
			'posts_per_page' => $settings['max_items'],
		);
		
		if ( $settings['show_popular_topics'] && ! $settings['show_recent_topics'] ) {
			$args['meta_key'] = '_topic_votes';
			$args['orderby'] = 'meta_value_num';
			$args['order'] = 'DESC';
		}
		
		$topics = get_posts( $args );
		
		if ( empty( $topics ) ) {
			echo '<p class="ce-widget-empty-message">No forum topics found.</p>';
			return;
		}
		
		echo '<ul class="ce-forum-list">';
		
		foreach ( $topics as $topic ) {
			$votes = get_post_meta( $topic->ID, '_topic_votes', true ) ? get_post_meta( $topic->ID, '_topic_votes', true ) : 0;
			$replies = get_post_meta( $topic->ID, '_topic_replies', true ) ? get_post_meta( $topic->ID, '_topic_replies', true ) : 0;
			$board = get_the_terms( $topic->ID, 'forum_board' );
			$board_name = ! empty( $board ) && ! is_wp_error( $board ) ? $board[0]->name : '';
			
			echo '<li class="ce-forum-item">';
			echo '<h4 class="ce-forum-title"><a href="' . esc_url( get_permalink( $topic->ID ) ) . '">' . esc_html( $topic->post_title ) . '</a></h4>';
			echo '<div class="ce-forum-meta">';
			
			if ( $board_name ) {
				echo '<span class="ce-forum-board">' . esc_html( $board_name ) . '</span>';
			}
			
			echo '<span class="ce-forum-votes"><i class="fas fa-thumbs-up"></i> ' . esc_html( $votes ) . '</span>';
			echo '<span class="ce-forum-replies"><i class="fas fa-comment"></i> ' . esc_html( $replies ) . '</span>';
			echo '</div>';
			echo '</li>';
		}
		
		echo '</ul>';
		
		echo '<div class="ce-widget-footer">';
		echo '<a href="' . esc_url( home_url( '/forums/' ) ) . '" class="ce-button ce-button-small">View All Topics</a>';
		echo '</div>';
	}
	
	/**
	 * Render Learning widget
	 *
	 * @param array $settings Widget settings
	 */
	public function render_learning_widget( $settings ) {
		$user_id = get_current_user_id();
		$enrolled_courses = get_user_meta( $user_id, 'ce_enrolled_courses', true );
		
		if ( empty( $enrolled_courses ) ) {
			$enrolled_courses = array();
		}
		
		echo '<div class="ce-learning-widget-content">';
		
		if ( $settings['show_my_courses'] && ! empty( $enrolled_courses ) ) {
			echo '<div class="ce-learning-section">';
			echo '<h4 class="ce-learning-section-title">My Courses</h4>';
			echo '<ul class="ce-learning-list">';
			
			$enrolled_args = array(
				'post_type' => 'course',
				'posts_per_page' => $settings['max_items'],
				'post__in' => $enrolled_courses,
			);
			
			$enrolled_courses_query = get_posts( $enrolled_args );
			
			foreach ( $enrolled_courses_query as $course ) {
				$progress = get_user_meta( $user_id, 'ce_course_progress_' . $course->ID, true );
				$progress = $progress ? $progress : 0;
				
				echo '<li class="ce-learning-item">';
				echo '<h5 class="ce-learning-title"><a href="' . esc_url( get_permalink( $course->ID ) ) . '">' . esc_html( $course->post_title ) . '</a></h5>';
				echo '<div class="ce-learning-progress-bar"><div class="ce-learning-progress" style="width: ' . esc_attr( $progress ) . '%;"></div></div>';
				echo '<div class="ce-learning-progress-text">' . esc_html( $progress ) . '% Complete</div>';
				echo '</li>';
			}
			
			echo '</ul>';
			echo '</div>';
		}
		
		if ( $settings['show_recommended_courses'] ) {
			echo '<div class="ce-learning-section">';
			echo '<h4 class="ce-learning-section-title">Recommended Courses</h4>';
			echo '<ul class="ce-learning-list">';
			
			$recommended_args = array(
				'post_type' => 'course',
				'posts_per_page' => $settings['max_items'],
				'meta_key' => '_course_featured',
				'meta_value' => '1',
			);
			
			if ( ! empty( $enrolled_courses ) ) {
				$recommended_args['post__not_in'] = $enrolled_courses;
			}
			
			$recommended_courses = get_posts( $recommended_args );
			
			if ( empty( $recommended_courses ) ) {
				echo '<li class="ce-learning-item ce-learning-empty">No recommended courses available.</li>';
			} else {
				foreach ( $recommended_courses as $course ) {
					$difficulty = get_post_meta( $course->ID, '_course_difficulty', true );
					$duration = get_post_meta( $course->ID, '_course_duration', true );
					
					echo '<li class="ce-learning-item">';
					echo '<h5 class="ce-learning-title"><a href="' . esc_url( get_permalink( $course->ID ) ) . '">' . esc_html( $course->post_title ) . '</a></h5>';
					echo '<div class="ce-learning-meta">';
					
					if ( $difficulty ) {
						echo '<span class="ce-learning-difficulty">Difficulty: ' . esc_html( ucfirst( $difficulty ) ) . '</span>';
					}
					
					if ( $duration ) {
						echo '<span class="ce-learning-duration">Duration: ' . esc_html( $duration ) . '</span>';
					}
					
					echo '</div>';
					echo '</li>';
				}
			}
			
			echo '</ul>';
			echo '</div>';
		}
		
		echo '</div>';
		
		echo '<div class="ce-widget-footer">';
		echo '<a href="' . esc_url( home_url( '/learning/' ) ) . '" class="ce-button ce-button-small">View Learning Hub</a>';
		echo '</div>';
	}
	
	/**
	 * Render Calendar widget
	 *
	 * @param array $settings Widget settings
	 */
	public function render_calendar_widget( $settings ) {
		$user_id = get_current_user_id();
		$today = current_time( 'Y-m-d' );
		$end_date = date( 'Y-m-d', strtotime( $today . ' + ' . $settings['days_ahead'] . ' days' ) );
		
		$args = array(
			'post_type' => 'event',
			'posts_per_page' => -1,
			'meta_key' => '_event_date',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => '_event_date',
					'value' => array( $today, $end_date ),
					'compare' => 'BETWEEN',
					'type' => 'DATE',
				),
			),
		);
		
		if ( ! $settings['show_community_events'] && $settings['show_personal_events'] ) {
			$args['meta_query'][] = array(
				'key' => '_event_type',
				'value' => 'personal',
				'compare' => '=',
			);
		} elseif ( $settings['show_community_events'] && ! $settings['show_personal_events'] ) {
			$args['meta_query'][] = array(
				'key' => '_event_type',
				'value' => 'community',
				'compare' => '=',
			);
		}
		
		$events = get_posts( $args );
		
		if ( empty( $events ) ) {
			echo '<p class="ce-widget-empty-message">No upcoming events found.</p>';
			return;
		}
		
		echo '<div class="ce-calendar-widget-content">';
		
		$current_date = '';
		
		foreach ( $events as $event ) {
			$event_date = get_post_meta( $event->ID, '_event_date', true );
			$event_time = get_post_meta( $event->ID, '_event_time', true );
			$event_type = get_post_meta( $event->ID, '_event_type', true );
			$formatted_date = date( 'F j, Y', strtotime( $event_date ) );
			
			if ( $current_date !== $formatted_date ) {
				if ( $current_date !== '' ) {
					echo '</ul>';
				}
				
				$current_date = $formatted_date;
				echo '<h4 class="ce-calendar-date">' . esc_html( $formatted_date ) . '</h4>';
				echo '<ul class="ce-calendar-events">';
			}
			
			echo '<li class="ce-calendar-event ce-event-type-' . esc_attr( $event_type ) . '">';
			echo '<div class="ce-calendar-event-time">' . esc_html( $event_time ) . '</div>';
			echo '<div class="ce-calendar-event-details">';
			echo '<h5 class="ce-calendar-event-title"><a href="' . esc_url( get_permalink( $event->ID ) ) . '">' . esc_html( $event->post_title ) . '</a></h5>';
			echo '<div class="ce-calendar-event-excerpt">' . wp_trim_words( $event->post_content, 10 ) . '</div>';
			echo '</div>';
			echo '</li>';
		}
		
		echo '</ul>';
		echo '</div>';
		
		echo '<div class="ce-widget-footer">';
		echo '<a href="' . esc_url( home_url( '/calendar/' ) ) . '" class="ce-button ce-button-small">View Full Calendar</a>';
		echo '</div>';
	}
	
	/**
	 * Render Stats widget
	 *
	 * @param array $settings Widget settings
	 */
	public function render_stats_widget( $settings ) {
		echo '<div class="ce-stats-widget-content">';
		
		if ( $settings['show_member_stats'] ) {
			echo '<div class="ce-stats-section">';
			echo '<h4 class="ce-stats-section-title">Member Statistics</h4>';
			echo '<div class="ce-stats-grid">';
			
			$total_members = count_users();
			echo '<div class="ce-stats-item">';
			echo '<div class="ce-stats-value">' . esc_html( $total_members['total_users'] ) . '</div>';
			echo '<div class="ce-stats-label">Total Members</div>';
			echo '</div>';
			
			$args = array(
				'date_query' => array(
					array(
						'after' => '1 month ago',
					),
				),
				'count_total' => true,
				'fields' => 'ID',
			);
			$new_members_query = new WP_User_Query( $args );
			$new_members = $new_members_query->get_total();
			
			echo '<div class="ce-stats-item">';
			echo '<div class="ce-stats-value">' . esc_html( $new_members ) . '</div>';
			echo '<div class="ce-stats-label">New Members This Month</div>';
			echo '</div>';
			
			$active_members = count_users()['avail_roles']['subscriber'] ?? 0;
			echo '<div class="ce-stats-item">';
			echo '<div class="ce-stats-value">' . esc_html( $active_members ) . '</div>';
			echo '<div class="ce-stats-label">Active Members</div>';
			echo '</div>';
			
			echo '</div>';
			echo '</div>';
		}
		
		if ( $settings['show_activity_stats'] ) {
			echo '<div class="ce-stats-section">';
			echo '<h4 class="ce-stats-section-title">Activity Statistics</h4>';
			echo '<div class="ce-stats-grid">';
			
			$total_rfps = wp_count_posts( 'rfp' )->publish;
			echo '<div class="ce-stats-item">';
			echo '<div class="ce-stats-value">' . esc_html( $total_rfps ) . '</div>';
			echo '<div class="ce-stats-label">Total RFPs</div>';
			echo '</div>';
			
			$total_topics = wp_count_posts( 'forum_topic' )->publish;
			echo '<div class="ce-stats-item">';
			echo '<div class="ce-stats-value">' . esc_html( $total_topics ) . '</div>';
			echo '<div class="ce-stats-label">Forum Topics</div>';
			echo '</div>';
			
			$total_vendors = wp_count_posts( 'vendor' )->publish;
			echo '<div class="ce-stats-item">';
			echo '<div class="ce-stats-value">' . esc_html( $total_vendors ) . '</div>';
			echo '<div class="ce-stats-label">Vendors</div>';
			echo '</div>';
			
			echo '</div>';
			echo '</div>';
		}
		
		if ( $settings['show_learning_stats'] ) {
			echo '<div class="ce-stats-section">';
			echo '<h4 class="ce-stats-section-title">Learning Statistics</h4>';
			echo '<div class="ce-stats-grid">';
			
			$total_courses = wp_count_posts( 'course' )->publish;
			echo '<div class="ce-stats-item">';
			echo '<div class="ce-stats-value">' . esc_html( $total_courses ) . '</div>';
			echo '<div class="ce-stats-label">Total Courses</div>';
			echo '</div>';
			
			$course_completions = get_option( 'ce_course_completions', 0 );
			echo '<div class="ce-stats-item">';
			echo '<div class="ce-stats-value">' . esc_html( $course_completions ) . '</div>';
			echo '<div class="ce-stats-label">Course Completions</div>';
			echo '</div>';
			
			$completion_rate = get_option( 'ce_average_completion_rate', 0 );
			echo '<div class="ce-stats-item">';
			echo '<div class="ce-stats-value">' . esc_html( $completion_rate ) . '%</div>';
			echo '<div class="ce-stats-label">Avg. Completion Rate</div>';
			echo '</div>';
			
			echo '</div>';
			echo '</div>';
		}
		
		echo '</div>';
	}
}
}
