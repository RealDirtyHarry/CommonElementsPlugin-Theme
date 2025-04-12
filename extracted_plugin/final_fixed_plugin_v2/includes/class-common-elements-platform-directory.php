<?php
/**
 * The directory functionality of the plugin.
 *
 * @package Common_Elements_Platform
 */

/**
 * The directory functionality of the plugin.
 *
 * Handles all directory-related functionality including
 * post type registration, taxonomies, meta boxes, and search.
 */
class Common_Elements_Platform_Directory {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		// Register post types and taxonomies
		add_action( 'init', array( $this, 'register_directory_post_types' ) );
		add_action( 'init', array( $this, 'register_directory_taxonomies' ) );
		add_action( 'init', array( $this, 'register_directory_endpoints' ) );
		
		// Register meta boxes
		add_action( 'add_meta_boxes', array( $this, 'add_directory_meta_boxes' ) );
		
		// Save meta box data
		add_action( 'save_post_directory_listing', array( $this, 'save_directory_meta_box_data' ) );
		
		// Handle templates
		add_filter( 'template_include', array( $this, 'directory_template' ) );
		
		// AJAX handlers
		add_action( 'wp_ajax_search_directory', array( $this, 'search_directory' ) );
		add_action( 'wp_ajax_nopriv_search_directory', array( $this, 'search_directory' ) );
		
		// Register cache groups
		add_action( 'init', array( $this, 'register_cache_groups' ) );
		
		// Clear cache when directory listing is updated
		add_action( 'save_post_directory_listing', array( $this, 'clear_directory_cache' ), 10, 3 );
		add_action( 'edited_directory_category', array( $this, 'clear_directory_cache' ) );
		add_action( 'edited_directory_location', array( $this, 'clear_directory_cache' ) );
	}

	/**
	 * Register Directory custom post type
	 *
	 * @since    1.0.0
	 */
	public function register_directory_post_types() {
		$labels = array(
			'name'                  => _x( 'Directory Listings', 'Post type general name', 'common-elements-platform' ),
			'singular_name'         => _x( 'Directory Listing', 'Post type singular name', 'common-elements-platform' ),
			'menu_name'             => _x( 'Directory', 'Admin Menu text', 'common-elements-platform' ),
			'name_admin_bar'        => _x( 'Directory Listing', 'Add New on Toolbar', 'common-elements-platform' ),
			'add_new'               => __( 'Add New', 'common-elements-platform' ),
			'add_new_item'          => __( 'Add New Listing', 'common-elements-platform' ),
			'new_item'              => __( 'New Listing', 'common-elements-platform' ),
			'edit_item'             => __( 'Edit Listing', 'common-elements-platform' ),
			'view_item'             => __( 'View Listing', 'common-elements-platform' ),
			'all_items'             => __( 'All Listings', 'common-elements-platform' ),
			'search_items'          => __( 'Search Listings', 'common-elements-platform' ),
			'parent_item_colon'     => __( 'Parent Listings:', 'common-elements-platform' ),
			'not_found'             => __( 'No listings found.', 'common-elements-platform' ),
			'not_found_in_trash'    => __( 'No listings found in Trash.', 'common-elements-platform' ),
			'featured_image'        => _x( 'Listing Logo', 'Overrides the "Featured Image" phrase', 'common-elements-platform' ),
			'set_featured_image'    => _x( 'Set listing logo', 'Overrides the "Set featured image" phrase', 'common-elements-platform' ),
			'remove_featured_image' => _x( 'Remove listing logo', 'Overrides the "Remove featured image" phrase', 'common-elements-platform' ),
			'use_featured_image'    => _x( 'Use as listing logo', 'Overrides the "Use as featured image" phrase', 'common-elements-platform' ),
			'archives'              => _x( 'Directory archives', 'The post type archive label used in nav menus', 'common-elements-platform' ),
			'insert_into_item'      => _x( 'Insert into listing', 'Overrides the "Insert into post" phrase', 'common-elements-platform' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this listing', 'Overrides the "Uploaded to this post" phrase', 'common-elements-platform' ),
			'filter_items_list'     => _x( 'Filter listings list', 'Screen reader text for the filter links heading on the post type listing screen', 'common-elements-platform' ),
			'items_list_navigation' => _x( 'Listings list navigation', 'Screen reader text for the pagination heading on the post type listing screen', 'common-elements-platform' ),
			'items_list'            => _x( 'Listings list', 'Screen reader text for the items list heading on the post type listing screen', 'common-elements-platform' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false, // Will be added as submenu to Common Elements
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'directory' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-businessperson',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'directory_listing', $args );
	}

	/**
	 * Register Directory taxonomies
	 *
	 * @since    1.0.0
	 */
	public function register_directory_taxonomies() {
		// Register Directory Category taxonomy
		$category_labels = array(
			'name'              => _x( 'Categories', 'taxonomy general name', 'common-elements-platform' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'common-elements-platform' ),
			'search_items'      => __( 'Search Categories', 'common-elements-platform' ),
			'all_items'         => __( 'All Categories', 'common-elements-platform' ),
			'parent_item'       => __( 'Parent Category', 'common-elements-platform' ),
			'parent_item_colon' => __( 'Parent Category:', 'common-elements-platform' ),
			'edit_item'         => __( 'Edit Category', 'common-elements-platform' ),
			'update_item'       => __( 'Update Category', 'common-elements-platform' ),
			'add_new_item'      => __( 'Add New Category', 'common-elements-platform' ),
			'new_item_name'     => __( 'New Category Name', 'common-elements-platform' ),
			'menu_name'         => __( 'Categories', 'common-elements-platform' ),
		);

		$category_args = array(
			'hierarchical'      => true,
			'labels'            => $category_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'directory-category' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'directory_category', array( 'directory_listing' ), $category_args );

		// Register Directory Location taxonomy
		$location_labels = array(
			'name'              => _x( 'Locations', 'taxonomy general name', 'common-elements-platform' ),
			'singular_name'     => _x( 'Location', 'taxonomy singular name', 'common-elements-platform' ),
			'search_items'      => __( 'Search Locations', 'common-elements-platform' ),
			'all_items'         => __( 'All Locations', 'common-elements-platform' ),
			'parent_item'       => __( 'Parent Location', 'common-elements-platform' ),
			'parent_item_colon' => __( 'Parent Location:', 'common-elements-platform' ),
			'edit_item'         => __( 'Edit Location', 'common-elements-platform' ),
			'update_item'       => __( 'Update Location', 'common-elements-platform' ),
			'add_new_item'      => __( 'Add New Location', 'common-elements-platform' ),
			'new_item_name'     => __( 'New Location Name', 'common-elements-platform' ),
			'menu_name'         => __( 'Locations', 'common-elements-platform' ),
		);

		$location_args = array(
			'hierarchical'      => true,
			'labels'            => $location_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'directory-location' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'directory_location', array( 'directory_listing' ), $location_args );
		
		// Register Directory Features taxonomy
		$feature_labels = array(
			'name'              => _x( 'Features', 'taxonomy general name', 'common-elements-platform' ),
			'singular_name'     => _x( 'Feature', 'taxonomy singular name', 'common-elements-platform' ),
			'search_items'      => __( 'Search Features', 'common-elements-platform' ),
			'all_items'         => __( 'All Features', 'common-elements-platform' ),
			'parent_item'       => __( 'Parent Feature', 'common-elements-platform' ),
			'parent_item_colon' => __( 'Parent Feature:', 'common-elements-platform' ),
			'edit_item'         => __( 'Edit Feature', 'common-elements-platform' ),
			'update_item'       => __( 'Update Feature', 'common-elements-platform' ),
			'add_new_item'      => __( 'Add New Feature', 'common-elements-platform' ),
			'new_item_name'     => __( 'New Feature Name', 'common-elements-platform' ),
			'menu_name'         => __( 'Features', 'common-elements-platform' ),
		);

		$feature_args = array(
			'hierarchical'      => false,
			'labels'            => $feature_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'directory-feature' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'directory_feature', array( 'directory_listing' ), $feature_args );
	}

	/**
	 * Register directory endpoints.
	 *
	 * @since    1.0.0
	 */
	public function register_directory_endpoints() {
		add_rewrite_rule(
			'directory/category/([^/]+)/?$',
			'index.php?directory_category=$matches[1]',
			'top'
		);
		
		add_rewrite_rule(
			'directory/location/([^/]+)/?$',
			'index.php?directory_location=$matches[1]',
			'top'
		);
		
		add_rewrite_tag( '%directory_category%', '([^&]+)' );
		add_rewrite_tag( '%directory_location%', '([^&]+)' );
	}

	/**
	 * Add Directory meta boxes
	 *
	 * @since    1.0.0
	 */
	public function add_directory_meta_boxes() {
		add_meta_box(
			'directory_details',
			__( 'Listing Details', 'common-elements-platform' ),
			array( $this, 'directory_details_meta_box_callback' ),
			'directory_listing',
			'normal',
			'high'
		);
		
		add_meta_box(
			'directory_contact',
			__( 'Contact Information', 'common-elements-platform' ),
			array( $this, 'directory_contact_meta_box_callback' ),
			'directory_listing',
			'normal',
			'default'
		);
		
		add_meta_box(
			'directory_social',
			__( 'Social Media', 'common-elements-platform' ),
			array( $this, 'directory_social_meta_box_callback' ),
			'directory_listing',
			'normal',
			'default'
		);
	}

	/**
	 * Directory Details meta box callback
	 *
	 * @since    1.0.0
	 * @param    WP_Post    $post    The post object.
	 */
	public function directory_details_meta_box_callback( $post ) {
		// Add nonce for security
		wp_nonce_field( 'common_elements_directory_details_meta_box', 'common_elements_directory_details_meta_box_nonce' );
		
		// Get existing values
		$featured = get_post_meta( $post->ID, '_directory_featured', true );
		$rating = get_post_meta( $post->ID, '_directory_rating', true );
		$website = get_post_meta( $post->ID, '_directory_website', true );
		
		?>
		<div class="directory-details-meta-box">
			<p>
				<label for="directory_featured">
					<input type="checkbox" id="directory_featured" name="directory_featured" value="1" <?php checked( $featured, '1' ); ?>>
					<?php esc_html_e( 'Featured Listing', 'common-elements-platform' ); ?>
				</label>
			</p>
			<p>
				<label for="directory_rating"><?php esc_html_e( 'Rating (1-5)', 'common-elements-platform' ); ?></label>
				<input type="number" id="directory_rating" name="directory_rating" value="<?php echo esc_attr( $rating ); ?>" class="widefat" min="1" max="5" step="0.1">
			</p>
			<p>
				<label for="directory_website"><?php esc_html_e( 'Website URL', 'common-elements-platform' ); ?></label>
				<input type="url" id="directory_website" name="directory_website" value="<?php echo esc_url( $website ); ?>" class="widefat">
			</p>
		</div>
		<?php
	}

	/**
	 * Directory Contact meta box callback
	 *
	 * @since    1.0.0
	 * @param    WP_Post    $post    The post object.
	 */
	public function directory_contact_meta_box_callback( $post ) {
		// Add nonce for security
		wp_nonce_field( 'common_elements_directory_contact_meta_box', 'common_elements_directory_contact_meta_box_nonce' );
		
		// Get existing values
		$phone = get_post_meta( $post->ID, '_directory_phone', true );
		$email = get_post_meta( $post->ID, '_directory_email', true );
		$address = get_post_meta( $post->ID, '_directory_address', true );
		$city = get_post_meta( $post->ID, '_directory_city', true );
		$state = get_post_meta( $post->ID, '_directory_state', true );
		$zip = get_post_meta( $post->ID, '_directory_zip', true );
		
		?>
		<div class="directory-contact-meta-box">
			<p>
				<label for="directory_phone"><?php esc_html_e( 'Phone Number', 'common-elements-platform' ); ?></label>
				<input type="tel" id="directory_phone" name="directory_phone" value="<?php echo esc_attr( $phone ); ?>" class="widefat">
			</p>
			<p>
				<label for="directory_email"><?php esc_html_e( 'Email Address', 'common-elements-platform' ); ?></label>
				<input type="email" id="directory_email" name="directory_email" value="<?php echo esc_attr( $email ); ?>" class="widefat">
			</p>
			<p>
				<label for="directory_address"><?php esc_html_e( 'Street Address', 'common-elements-platform' ); ?></label>
				<input type="text" id="directory_address" name="directory_address" value="<?php echo esc_attr( $address ); ?>" class="widefat">
			</p>
			<div class="directory-location-fields">
				<p>
					<label for="directory_city"><?php esc_html_e( 'City', 'common-elements-platform' ); ?></label>
					<input type="text" id="directory_city" name="directory_city" value="<?php echo esc_attr( $city ); ?>" class="widefat">
				</p>
				<p>
					<label for="directory_state"><?php esc_html_e( 'State', 'common-elements-platform' ); ?></label>
					<input type="text" id="directory_state" name="directory_state" value="<?php echo esc_attr( $state ); ?>" class="widefat">
				</p>
				<p>
					<label for="directory_zip"><?php esc_html_e( 'ZIP Code', 'common-elements-platform' ); ?></label>
					<input type="text" id="directory_zip" name="directory_zip" value="<?php echo esc_attr( $zip ); ?>" class="widefat">
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Directory Social meta box callback
	 *
	 * @since    1.0.0
	 * @param    WP_Post    $post    The post object.
	 */
	public function directory_social_meta_box_callback( $post ) {
		// Add nonce for security
		wp_nonce_field( 'common_elements_directory_social_meta_box', 'common_elements_directory_social_meta_box_nonce' );
		
		// Get existing values
		$facebook = get_post_meta( $post->ID, '_directory_facebook', true );
		$twitter = get_post_meta( $post->ID, '_directory_twitter', true );
		$linkedin = get_post_meta( $post->ID, '_directory_linkedin', true );
		$instagram = get_post_meta( $post->ID, '_directory_instagram', true );
		
		?>
		<div class="directory-social-meta-box">
			<p>
				<label for="directory_facebook"><?php esc_html_e( 'Facebook URL', 'common-elements-platform' ); ?></label>
				<input type="url" id="directory_facebook" name="directory_facebook" value="<?php echo esc_url( $facebook ); ?>" class="widefat">
			</p>
			<p>
				<label for="directory_twitter"><?php esc_html_e( 'Twitter URL', 'common-elements-platform' ); ?></label>
				<input type="url" id="directory_twitter" name="directory_twitter" value="<?php echo esc_url( $twitter ); ?>" class="widefat">
			</p>
			<p>
				<label for="directory_linkedin"><?php esc_html_e( 'LinkedIn URL', 'common-elements-platform' ); ?></label>
				<input type="url" id="directory_linkedin" name="directory_linkedin" value="<?php echo esc_url( $linkedin ); ?>" class="widefat">
			</p>
			<p>
				<label for="directory_instagram"><?php esc_html_e( 'Instagram URL', 'common-elements-platform' ); ?></label>
				<input type="url" id="directory_instagram" name="directory_instagram" value="<?php echo esc_url( $instagram ); ?>" class="widefat">
			</p>
		</div>
		<?php
	}

	/**
	 * Save Directory meta box data
	 *
	 * @since    1.0.0
	 * @param    int    $post_id    The post ID.
	 */
	public function save_directory_meta_box_data( $post_id ) {
		// Check if we're saving directory details
		if ( isset( $_POST['common_elements_directory_details_meta_box_nonce'] ) ) {
			// Verify nonce
			if ( ! wp_verify_nonce( $_POST['common_elements_directory_details_meta_box_nonce'], 'common_elements_directory_details_meta_box' ) ) {
				return;
			}
			
			// If this is an autosave, don't do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			// Check user permissions
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			
			// Save featured status
			$featured = isset( $_POST['directory_featured'] ) ? '1' : '0';
			update_post_meta( $post_id, '_directory_featured', $featured );
			
			// Save rating
			if ( isset( $_POST['directory_rating'] ) ) {
				$rating = floatval( $_POST['directory_rating'] );
				if ( $rating < 1 ) {
					$rating = 1;
				} elseif ( $rating > 5 ) {
					$rating = 5;
				}
				update_post_meta( $post_id, '_directory_rating', $rating );
			}
			
			// Save website
			if ( isset( $_POST['directory_website'] ) ) {
				update_post_meta( $post_id, '_directory_website', esc_url_raw( $_POST['directory_website'] ) );
			}
		}
		
		// Check if we're saving contact information
		if ( isset( $_POST['common_elements_directory_contact_meta_box_nonce'] ) ) {
			// Verify nonce
			if ( ! wp_verify_nonce( $_POST['common_elements_directory_contact_meta_box_nonce'], 'common_elements_directory_contact_meta_box' ) ) {
				return;
			}
			
			// If this is an autosave, don't do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			// Check user permissions
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			
			// Save phone
			if ( isset( $_POST['directory_phone'] ) ) {
				update_post_meta( $post_id, '_directory_phone', sanitize_text_field( $_POST['directory_phone'] ) );
			}
			
			// Save email
			if ( isset( $_POST['directory_email'] ) ) {
				update_post_meta( $post_id, '_directory_email', sanitize_email( $_POST['directory_email'] ) );
			}
			
			// Save address
			if ( isset( $_POST['directory_address'] ) ) {
				update_post_meta( $post_id, '_directory_address', sanitize_text_field( $_POST['directory_address'] ) );
			}
			
			// Save city
			if ( isset( $_POST['directory_city'] ) ) {
				update_post_meta( $post_id, '_directory_city', sanitize_text_field( $_POST['directory_city'] ) );
			}
			
			// Save state
			if ( isset( $_POST['directory_state'] ) ) {
				update_post_meta( $post_id, '_directory_state', sanitize_text_field( $_POST['directory_state'] ) );
			}
			
			// Save zip
			if ( isset( $_POST['directory_zip'] ) ) {
				update_post_meta( $post_id, '_directory_zip', sanitize_text_field( $_POST['directory_zip'] ) );
			}
		}
		
		// Check if we're saving social media information
		if ( isset( $_POST['common_elements_directory_social_meta_box_nonce'] ) ) {
			// Verify nonce
			if ( ! wp_verify_nonce( $_POST['common_elements_directory_social_meta_box_nonce'], 'common_elements_directory_social_meta_box' ) ) {
				return;
			}
			
			// If this is an autosave, don't do anything
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			// Check user permissions
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			
			// Save Facebook
			if ( isset( $_POST['directory_facebook'] ) ) {
				update_post_meta( $post_id, '_directory_facebook', esc_url_raw( $_POST['directory_facebook'] ) );
			}
			
			// Save Twitter
			if ( isset( $_POST['directory_twitter'] ) ) {
				update_post_meta( $post_id, '_directory_twitter', esc_url_raw( $_POST['directory_twitter'] ) );
			}
			
			// Save LinkedIn
			if ( isset( $_POST['directory_linkedin'] ) ) {
				update_post_meta( $post_id, '_directory_linkedin', esc_url_raw( $_POST['directory_linkedin'] ) );
			}
			
			// Save Instagram
			if ( isset( $_POST['directory_instagram'] ) ) {
				update_post_meta( $post_id, '_directory_instagram', esc_url_raw( $_POST['directory_instagram'] ) );
			}
		}
	}

	/**
	 * Handle directory template selection.
	 *
	 * @since    1.0.0
	 * @param    string    $template    The template to include.
	 * @return   string                 The modified template path.
	 */
	public function directory_template( $template ) {
		if ( is_page( 'directory' ) ) {
			return COMMON_ELEMENTS_PLATFORM_DIR . 'public/partials/directory/directory-listing.php';
		}
		
		if ( is_tax( 'directory_category' ) ) {
			return COMMON_ELEMENTS_PLATFORM_DIR . 'public/partials/directory/directory-category.php';
		}
		
		if ( is_tax( 'directory_location' ) ) {
			return COMMON_ELEMENTS_PLATFORM_DIR . 'public/partials/directory/directory-location.php';
		}
		
		if ( is_singular( 'directory_listing' ) ) {
			return COMMON_ELEMENTS_PLATFORM_DIR . 'public/partials/directory/single-listing.php';
		}
		
		return $template;
	}

	/**
	 * Handle directory search via AJAX.
	 *
	 * @since    1.0.0
	 */
	public function search_directory() {
		// Check nonce for security
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		// Sanitize input
		$search_term = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';
		$category = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';
		$location = isset( $_POST['location'] ) ? sanitize_text_field( $_POST['location'] ) : '';
		$featured = isset( $_POST['featured'] ) ? (bool) $_POST['featured'] : false;
		$page = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
		$per_page = isset( $_POST['per_page'] ) ? absint( $_POST['per_page'] ) : 20;
		$orderby = isset( $_POST['orderby'] ) ? sanitize_text_field( $_POST['orderby'] ) : 'title';
		$order = isset( $_POST['order'] ) ? sanitize_text_field( $_POST['order'] ) : 'ASC';
		
		// Validate orderby parameter
		$valid_orderby = array('title', 'date', 'rating', 'featured');
		if (!in_array($orderby, $valid_orderby)) {
			$orderby = 'title';
		}
		
		// Validate order parameter
		$valid_order = array('ASC', 'DESC');
		if (!in_array($order, $valid_order)) {
			$order = 'ASC';
		}
		
		// Build query args
		$args = array(
			'post_type' => 'directory_listing',
			'posts_per_page' => $per_page,
			'paged' => $page,
		);
		
		// Handle ordering
		if ($orderby === 'rating' || $orderby === 'featured') {
			$args['meta_key'] = ($orderby === 'rating') ? '_directory_rating' : '_directory_featured';
			$args['orderby'] = 'meta_value_num';
			$args['order'] = $order;
		} else {
			$args['orderby'] = $orderby;
			$args['order'] = $order;
		}
		
		// Add search term if provided
		if ( ! empty( $search_term ) ) {
			$args['s'] = $search_term;
		}
		
		// Add tax query for category and location if provided
		$tax_query = array();
		
		if ( ! empty( $category ) ) {
			$tax_query[] = array(
				'taxonomy' => 'directory_category',
				'field'    => 'slug',
				'terms'    => $category,
			);
		}
		
		if ( ! empty( $location ) ) {
			$tax_query[] = array(
				'taxonomy' => 'directory_location',
				'field'    => 'slug',
				'terms'    => $location,
			);
		}
		
		if ( ! empty( $tax_query ) ) {
			$args['tax_query'] = $tax_query;
		}
		
		// Add meta query for featured listings if requested
		if ( $featured ) {
			$args['meta_query'] = array(
				array(
					'key'     => '_directory_featured',
					'value'   => '1',
					'compare' => '=',
				),
			);
		}
		
		// Check for cached results
		$cache_key = 'directory_search_' . md5(serialize($args));
		$cached_results = wp_cache_get($cache_key, 'common_elements_directory');
		
		if (false === $cached_results) {
			// Run the query
			$query = new WP_Query( $args );
			$listings = array();
			
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$listings[] = $this->format_listing_data( get_the_ID() );
				}
				wp_reset_postdata();
			}
			
			// Get category and location filters for the search form
			$categories = get_terms( array(
				'taxonomy' => 'directory_category',
				'hide_empty' => true,
			) );
			
			$locations = get_terms( array(
				'taxonomy' => 'directory_location',
				'hide_empty' => true,
			) );
			
			$filters = array(
				'categories' => array(),
				'locations' => array(),
			);
			
			foreach ( $categories as $cat ) {
				$filters['categories'][] = array(
					'id' => $cat->term_id,
					'name' => $cat->name,
					'slug' => $cat->slug,
					'count' => $cat->count,
				);
			}
			
			foreach ( $locations as $loc ) {
				$filters['locations'][] = array(
					'id' => $loc->term_id,
					'name' => $loc->name,
					'slug' => $loc->slug,
					'count' => $loc->count,
				);
			}
			
			$results = array(
				'listings' => $listings,
				'filters' => $filters,
				'total' => $query->found_posts,
				'max_pages' => $query->max_num_pages,
				'current_page' => $page,
			);
			
			// Cache the results for 1 hour
			wp_cache_set($cache_key, $results, 'common_elements_directory', 3600);
			
			wp_send_json_success($results);
		} else {
			// Return cached results
			wp_send_json_success($cached_results);
		}
	}

	/**
	 * Format listing data for API response.
	 *
	 * @since    1.0.0
	 * @param    int       $listing_id    The listing ID.
	 * @return   array                    Formatted listing data.
	 */
	private function format_listing_data( $listing_id ) {
		// Check for cached listing data
		$cache_key = 'directory_listing_' . $listing_id;
		$cached_listing = wp_cache_get($cache_key, 'common_elements_directory');
		
		if (false !== $cached_listing) {
			return $cached_listing;
		}
		
		$listing = array(
			'id' => $listing_id,
			'title' => get_the_title( $listing_id ),
			'excerpt' => get_the_excerpt( $listing_id ),
			'content' => get_the_content( null, false, $listing_id ),
			'permalink' => get_permalink( $listing_id ),
			'thumbnail' => get_the_post_thumbnail_url( $listing_id, 'medium' ),
			'author' => get_the_author_meta( 'display_name', get_post_field( 'post_author', $listing_id ) ),
			'date' => get_the_date( 'Y-m-d', $listing_id ),
			'categories' => array(),
			'locations' => array(),
			'featured' => (bool) get_post_meta( $listing_id, '_directory_featured', true ),
			'rating' => (float) get_post_meta( $listing_id, '_directory_rating', true ),
			'contact' => array(
				'phone' => get_post_meta( $listing_id, '_directory_phone', true ),
				'email' => get_post_meta( $listing_id, '_directory_email', true ),
				'website' => get_post_meta( $listing_id, '_directory_website', true ),
				'address' => get_post_meta( $listing_id, '_directory_address', true ),
				'city' => get_post_meta( $listing_id, '_directory_city', true ),
				'state' => get_post_meta( $listing_id, '_directory_state', true ),
				'zip' => get_post_meta( $listing_id, '_directory_zip', true ),
			),
			'social' => array(
				'facebook' => get_post_meta( $listing_id, '_directory_facebook', true ),
				'twitter' => get_post_meta( $listing_id, '_directory_twitter', true ),
				'linkedin' => get_post_meta( $listing_id, '_directory_linkedin', true ),
				'instagram' => get_post_meta( $listing_id, '_directory_instagram', true ),
			),
			'coordinates' => $this->get_listing_coordinates($listing_id),
		);
		
		// Get categories
		$categories = wp_get_post_terms( $listing_id, 'directory_category' );
		foreach ( $categories as $category ) {
			$listing['categories'][] = array(
				'id' => $category->term_id,
				'name' => $category->name,
				'slug' => $category->slug,
				'permalink' => get_term_link( $category ),
			);
		}
		
		// Get locations
		$locations = wp_get_post_terms( $listing_id, 'directory_location' );
		foreach ( $locations as $location ) {
			$listing['locations'][] = array(
				'id' => $location->term_id,
				'name' => $location->name,
				'slug' => $location->slug,
				'permalink' => get_term_link( $location ),
			);
		}
		
		// Apply filters to allow extensions
		$listing = apply_filters( 'common_elements_directory_listing_data', $listing, $listing_id );
		
		// Cache the listing data for 1 hour
		wp_cache_set($cache_key, $listing, 'common_elements_directory', 3600);
		
		return $listing;
	}
	
	/**
	 * Get listing coordinates from address or stored values.
	 *
	 * @since    1.0.0
	 * @param    int       $listing_id    The listing ID.
	 * @return   array                    Coordinates array with lat and lng.
	 */
	private function get_listing_coordinates($listing_id) {
		// Check if we already have coordinates stored
		$lat = get_post_meta($listing_id, '_directory_lat', true);
		$lng = get_post_meta($listing_id, '_directory_lng', true);
		
		// If we have valid coordinates, return them
		if (!empty($lat) && !empty($lng) && is_numeric($lat) && is_numeric($lng)) {
			return array(
				'lat' => (float) $lat,
				'lng' => (float) $lng
			);
		}
		
		// Otherwise, try to geocode the address
		$address = array(
			get_post_meta($listing_id, '_directory_address', true),
			get_post_meta($listing_id, '_directory_city', true),
			get_post_meta($listing_id, '_directory_state', true),
			get_post_meta($listing_id, '_directory_zip', true)
		);
		
		// Filter out empty values and join with commas
		$address = array_filter($address);
		$full_address = implode(', ', $address);
		
		// If we don't have an address, return empty coordinates
		if (empty($full_address)) {
			return array(
				'lat' => 0,
				'lng' => 0
			);
		}
		
		// Try to geocode the address
		$coordinates = $this->geocode_address($full_address);
		
		// If geocoding was successful, store the coordinates
		if ($coordinates && isset($coordinates['lat']) && isset($coordinates['lng'])) {
			update_post_meta($listing_id, '_directory_lat', $coordinates['lat']);
			update_post_meta($listing_id, '_directory_lng', $coordinates['lng']);
			return $coordinates;
		}
		
		// Return empty coordinates if geocoding failed
		return array(
			'lat' => 0,
			'lng' => 0
		);
	}
	
	/**
	 * Geocode an address to get coordinates.
	 *
	 * @since    1.0.0
	 * @param    string    $address    The address to geocode.
	 * @return   array|false           Coordinates array or false on failure.
	 */
	private function geocode_address($address) {
		// Check for cached geocoding results
		$cache_key = 'geocode_' . md5($address);
		$cached_coordinates = wp_cache_get($cache_key, 'common_elements_directory');
		
		if (false !== $cached_coordinates) {
			return $cached_coordinates;
		}
		
		// For now, we'll return placeholder coordinates
		// In a production environment, you would integrate with a geocoding service like Google Maps API
		// This is a placeholder implementation
		$coordinates = array(
			'lat' => 0,
			'lng' => 0
		);
		
		// Cache the coordinates for 1 week (addresses don't change often)
		wp_cache_set($cache_key, $coordinates, 'common_elements_directory', 604800); // 7 days
		
		return $coordinates;
	}
	
	/**
	 * Register cache groups for directory data.
	 *
	 * @since    1.0.0
	 */
	public function register_cache_groups() {
		wp_cache_add_non_persistent_groups('common_elements_directory');
	}
	
	/**
	 * Clear directory cache when content is updated.
	 *
	 * @since    1.0.0
	 * @param    int       $post_id    The post ID.
	 * @param    WP_Post   $post       The post object.
	 * @param    bool      $update     Whether this is an existing post being updated.
	 */
	public function clear_directory_cache($post_id = 0, $post = null, $update = false) {
		// Delete all directory search caches
		$this->delete_directory_search_cache();
		
		// If we have a specific post ID, delete its individual cache
		if ($post_id > 0) {
			$cache_key = 'directory_listing_' . $post_id;
			wp_cache_delete($cache_key, 'common_elements_directory');
		}
	}
	
	/**
	 * Delete all directory search cache entries.
	 *
	 * @since    1.0.0
	 */
	private function delete_directory_search_cache() {
		// In a production environment, you would use a more sophisticated approach
		// to selectively delete cache entries. For simplicity, we're using a workaround
		// since WordPress doesn't provide a way to delete cache entries by prefix.
		
		// This is a placeholder implementation that would be replaced with a proper
		// cache management solution in production.
		
		// For now, we'll rely on the cache expiration we set (1 hour)
	}
}
