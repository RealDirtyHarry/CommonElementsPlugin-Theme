<?php
/**
 * The RFP post types registration functionality.
 *
 * @package Common_Elements_Platform
 */

/**
 * The RFP post types registration functionality.
 *
 * Registers custom post types and taxonomies for the RFP system.
 */
class Common_Elements_Platform_RFP_Post_Types {

	/**
	 * Register RFP post types and taxonomies.
	 *
	 * @since    1.0.0
	 */
	public function register_post_types() {
		register_post_type( 'rfp', array(
			'labels'              => array(
				'name'                  => _x( 'RFPs', 'Post type general name', 'common-elements-platform' ),
				'singular_name'         => _x( 'RFP', 'Post type singular name', 'common-elements-platform' ),
				'menu_name'             => _x( 'RFPs', 'Admin Menu text', 'common-elements-platform' ),
				'name_admin_bar'        => _x( 'RFP', 'Add New on Toolbar', 'common-elements-platform' ),
				'add_new'               => __( 'Add New', 'common-elements-platform' ),
				'add_new_item'          => __( 'Add New RFP', 'common-elements-platform' ),
				'new_item'              => __( 'New RFP', 'common-elements-platform' ),
				'edit_item'             => __( 'Edit RFP', 'common-elements-platform' ),
				'view_item'             => __( 'View RFP', 'common-elements-platform' ),
				'all_items'             => __( 'All RFPs', 'common-elements-platform' ),
				'search_items'          => __( 'Search RFPs', 'common-elements-platform' ),
				'parent_item_colon'     => __( 'Parent RFPs:', 'common-elements-platform' ),
				'not_found'             => __( 'No RFPs found.', 'common-elements-platform' ),
				'not_found_in_trash'    => __( 'No RFPs found in Trash.', 'common-elements-platform' ),
				'featured_image'        => _x( 'RFP Cover Image', 'Overrides the "Featured Image" phrase', 'common-elements-platform' ),
				'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase', 'common-elements-platform' ),
				'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase', 'common-elements-platform' ),
				'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase', 'common-elements-platform' ),
				'archives'              => _x( 'RFP archives', 'The post type archive label used in nav menus', 'common-elements-platform' ),
				'insert_into_item'      => _x( 'Insert into RFP', 'Overrides the "Insert into post" phrase', 'common-elements-platform' ),
				'uploaded_to_this_item' => _x( 'Uploaded to this RFP', 'Overrides the "Uploaded to this post" phrase', 'common-elements-platform' ),
				'filter_items_list'     => _x( 'Filter RFPs list', 'Screen reader text for the filter links heading on the post type listing screen', 'common-elements-platform' ),
				'items_list_navigation' => _x( 'RFPs list navigation', 'Screen reader text for the pagination heading on the post type listing screen', 'common-elements-platform' ),
				'items_list'            => _x( 'RFPs list', 'Screen reader text for the items list heading on the post type listing screen', 'common-elements-platform' ),
			),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-clipboard',
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'         => true,
			'rewrite'             => array( 'slug' => 'rfp' ),
			'query_var'           => true,
		) );

		register_post_type( 'proposal', array(
			'labels'              => array(
				'name'                  => _x( 'Proposals', 'Post type general name', 'common-elements-platform' ),
				'singular_name'         => _x( 'Proposal', 'Post type singular name', 'common-elements-platform' ),
				'menu_name'             => _x( 'Proposals', 'Admin Menu text', 'common-elements-platform' ),
				'name_admin_bar'        => _x( 'Proposal', 'Add New on Toolbar', 'common-elements-platform' ),
				'add_new'               => __( 'Add New', 'common-elements-platform' ),
				'add_new_item'          => __( 'Add New Proposal', 'common-elements-platform' ),
				'new_item'              => __( 'New Proposal', 'common-elements-platform' ),
				'edit_item'             => __( 'Edit Proposal', 'common-elements-platform' ),
				'view_item'             => __( 'View Proposal', 'common-elements-platform' ),
				'all_items'             => __( 'All Proposals', 'common-elements-platform' ),
				'search_items'          => __( 'Search Proposals', 'common-elements-platform' ),
				'parent_item_colon'     => __( 'Parent Proposals:', 'common-elements-platform' ),
				'not_found'             => __( 'No Proposals found.', 'common-elements-platform' ),
				'not_found_in_trash'    => __( 'No Proposals found in Trash.', 'common-elements-platform' ),
				'featured_image'        => _x( 'Proposal Cover Image', 'Overrides the "Featured Image" phrase', 'common-elements-platform' ),
				'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase', 'common-elements-platform' ),
				'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase', 'common-elements-platform' ),
				'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase', 'common-elements-platform' ),
				'archives'              => _x( 'Proposal archives', 'The post type archive label used in nav menus', 'common-elements-platform' ),
				'insert_into_item'      => _x( 'Insert into Proposal', 'Overrides the "Insert into post" phrase', 'common-elements-platform' ),
				'uploaded_to_this_item' => _x( 'Uploaded to this Proposal', 'Overrides the "Uploaded to this post" phrase', 'common-elements-platform' ),
				'filter_items_list'     => _x( 'Filter Proposals list', 'Screen reader text for the filter links heading on the post type listing screen', 'common-elements-platform' ),
				'items_list_navigation' => _x( 'Proposals list navigation', 'Screen reader text for the pagination heading on the post type listing screen', 'common-elements-platform' ),
				'items_list'            => _x( 'Proposals list', 'Screen reader text for the items list heading on the post type listing screen', 'common-elements-platform' ),
			),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-media-document',
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'         => true,
			'rewrite'             => array( 'slug' => 'proposal' ),
			'query_var'           => true,
		) );

		register_taxonomy( 'rfp_category', 'rfp', array(
			'labels'            => array(
				'name'                       => _x( 'RFP Categories', 'taxonomy general name', 'common-elements-platform' ),
				'singular_name'              => _x( 'RFP Category', 'taxonomy singular name', 'common-elements-platform' ),
				'search_items'               => __( 'Search RFP Categories', 'common-elements-platform' ),
				'popular_items'              => __( 'Popular RFP Categories', 'common-elements-platform' ),
				'all_items'                  => __( 'All RFP Categories', 'common-elements-platform' ),
				'parent_item'                => __( 'Parent RFP Category', 'common-elements-platform' ),
				'parent_item_colon'          => __( 'Parent RFP Category:', 'common-elements-platform' ),
				'edit_item'                  => __( 'Edit RFP Category', 'common-elements-platform' ),
				'view_item'                  => __( 'View RFP Category', 'common-elements-platform' ),
				'update_item'                => __( 'Update RFP Category', 'common-elements-platform' ),
				'add_new_item'               => __( 'Add New RFP Category', 'common-elements-platform' ),
				'new_item_name'              => __( 'New RFP Category Name', 'common-elements-platform' ),
				'separate_items_with_commas' => __( 'Separate RFP Categories with commas', 'common-elements-platform' ),
				'add_or_remove_items'        => __( 'Add or remove RFP Categories', 'common-elements-platform' ),
				'choose_from_most_used'      => __( 'Choose from the most used RFP Categories', 'common-elements-platform' ),
				'not_found'                  => __( 'No RFP Categories found.', 'common-elements-platform' ),
				'no_terms'                   => __( 'No RFP Categories', 'common-elements-platform' ),
				'items_list_navigation'      => __( 'RFP Categories list navigation', 'common-elements-platform' ),
				'items_list'                 => __( 'RFP Categories list', 'common-elements-platform' ),
				'back_to_items'              => __( '&larr; Back to RFP Categories', 'common-elements-platform' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'rfp-category' ),
		) );
	}

	/**
	 * Add RFP metaboxes.
	 *
	 * @since    1.0.0
	 */
	public function add_rfp_metaboxes() {
		add_meta_box(
			'rfp_details',
			__( 'RFP Details', 'common-elements-platform' ),
			array( $this, 'render_rfp_metabox' ),
			'rfp',
			'normal',
			'high'
		);

		add_meta_box(
			'proposal_details',
			__( 'Proposal Details', 'common-elements-platform' ),
			array( $this, 'render_proposal_metabox' ),
			'proposal',
			'normal',
			'high'
		);
	}

	/**
	 * Render RFP metabox.
	 *
	 * @since    1.0.0
	 * @param    WP_Post    $post    The post object.
	 */
	public function render_rfp_metabox( $post ) {
		wp_nonce_field( 'rfp_details_nonce', 'rfp_details_nonce' );

		$deadline = get_post_meta( $post->ID, 'rfp_deadline', true );
		$community = get_post_meta( $post->ID, 'rfp_community', true );
		$status = get_post_meta( $post->ID, 'rfp_status', true );
		$status = ! empty( $status ) ? $status : 'open';
		?>
		<div class="rfp-metabox">
			<div class="rfp-metabox-field">
				<label for="rfp_deadline"><?php esc_html_e( 'Deadline', 'common-elements-platform' ); ?></label>
				<input type="date" id="rfp_deadline" name="rfp_deadline" value="<?php echo esc_attr( $deadline ); ?>">
			</div>

			<div class="rfp-metabox-field">
				<label for="rfp_community"><?php esc_html_e( 'Community', 'common-elements-platform' ); ?></label>
				<input type="text" id="rfp_community" name="rfp_community" value="<?php echo esc_attr( $community ); ?>">
			</div>

			<div class="rfp-metabox-field">
				<label for="rfp_status"><?php esc_html_e( 'Status', 'common-elements-platform' ); ?></label>
				<select id="rfp_status" name="rfp_status">
					<option value="open" <?php selected( $status, 'open' ); ?>><?php esc_html_e( 'Open', 'common-elements-platform' ); ?></option>
					<option value="closed" <?php selected( $status, 'closed' ); ?>><?php esc_html_e( 'Closed', 'common-elements-platform' ); ?></option>
					<option value="awarded" <?php selected( $status, 'awarded' ); ?>><?php esc_html_e( 'Awarded', 'common-elements-platform' ); ?></option>
				</select>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Proposal metabox.
	 *
	 * @since    1.0.0
	 * @param    WP_Post    $post    The post object.
	 */
	public function render_proposal_metabox( $post ) {
		wp_nonce_field( 'proposal_details_nonce', 'proposal_details_nonce' );

		$rfp_id = get_post_meta( $post->ID, 'related_rfp', true );
		$price = get_post_meta( $post->ID, 'proposal_price', true );
		$timeline = get_post_meta( $post->ID, 'proposal_timeline', true );
		$status = get_post_meta( $post->ID, 'proposal_status', true );
		$status = ! empty( $status ) ? $status : 'submitted';

		$rfps = get_posts( array(
			'post_type' => 'rfp',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
		) );
		?>
		<div class="proposal-metabox">
			<div class="proposal-metabox-field">
				<label for="related_rfp"><?php esc_html_e( 'Related RFP', 'common-elements-platform' ); ?></label>
				<select id="related_rfp" name="related_rfp">
					<option value=""><?php esc_html_e( 'Select RFP', 'common-elements-platform' ); ?></option>
					<?php foreach ( $rfps as $rfp ) : ?>
						<option value="<?php echo esc_attr( $rfp->ID ); ?>" <?php selected( $rfp_id, $rfp->ID ); ?>><?php echo esc_html( $rfp->post_title ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="proposal-metabox-field">
				<label for="proposal_price"><?php esc_html_e( 'Price', 'common-elements-platform' ); ?></label>
				<input type="text" id="proposal_price" name="proposal_price" value="<?php echo esc_attr( $price ); ?>">
			</div>

			<div class="proposal-metabox-field">
				<label for="proposal_timeline"><?php esc_html_e( 'Timeline', 'common-elements-platform' ); ?></label>
				<input type="text" id="proposal_timeline" name="proposal_timeline" value="<?php echo esc_attr( $timeline ); ?>">
			</div>

			<div class="proposal-metabox-field">
				<label for="proposal_status"><?php esc_html_e( 'Status', 'common-elements-platform' ); ?></label>
				<select id="proposal_status" name="proposal_status">
					<option value="submitted" <?php selected( $status, 'submitted' ); ?>><?php esc_html_e( 'Submitted', 'common-elements-platform' ); ?></option>
					<option value="under_review" <?php selected( $status, 'under_review' ); ?>><?php esc_html_e( 'Under Review', 'common-elements-platform' ); ?></option>
					<option value="accepted" <?php selected( $status, 'accepted' ); ?>><?php esc_html_e( 'Accepted', 'common-elements-platform' ); ?></option>
					<option value="rejected" <?php selected( $status, 'rejected' ); ?>><?php esc_html_e( 'Rejected', 'common-elements-platform' ); ?></option>
				</select>
			</div>
		</div>
		<?php
	}

	/**
	 * Save RFP metabox data.
	 *
	 * @since    1.0.0
	 * @param    int       $post_id    The post ID.
	 * @param    WP_Post   $post       The post object.
	 */
	public function save_rfp_metabox( $post_id, $post ) {
		if ( ! isset( $_POST['rfp_details_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['rfp_details_nonce'], 'rfp_details_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( 'rfp' !== $post->post_type || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['rfp_deadline'] ) ) {
			update_post_meta( $post_id, 'rfp_deadline', sanitize_text_field( $_POST['rfp_deadline'] ) );
		}

		if ( isset( $_POST['rfp_community'] ) ) {
			update_post_meta( $post_id, 'rfp_community', sanitize_text_field( $_POST['rfp_community'] ) );
		}

		if ( isset( $_POST['rfp_status'] ) ) {
			update_post_meta( $post_id, 'rfp_status', sanitize_text_field( $_POST['rfp_status'] ) );
		}
	}

	/**
	 * Save Proposal metabox data.
	 *
	 * @since    1.0.0
	 * @param    int       $post_id    The post ID.
	 * @param    WP_Post   $post       The post object.
	 */
	public function save_proposal_metabox( $post_id, $post ) {
		if ( ! isset( $_POST['proposal_details_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['proposal_details_nonce'], 'proposal_details_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( 'proposal' !== $post->post_type || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['related_rfp'] ) ) {
			update_post_meta( $post_id, 'related_rfp', intval( $_POST['related_rfp'] ) );
		}

		if ( isset( $_POST['proposal_price'] ) ) {
			update_post_meta( $post_id, 'proposal_price', sanitize_text_field( $_POST['proposal_price'] ) );
		}

		if ( isset( $_POST['proposal_timeline'] ) ) {
			update_post_meta( $post_id, 'proposal_timeline', sanitize_text_field( $_POST['proposal_timeline'] ) );
		}

		if ( isset( $_POST['proposal_status'] ) ) {
			update_post_meta( $post_id, 'proposal_status', sanitize_text_field( $_POST['proposal_status'] ) );
		}
	}

	/**
	 * Handle proposal status update via AJAX.
	 *
	 * @since    1.0.0
	 */
	public function update_proposal_status() {
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		$required_fields = array( 'proposal_id', 'rfp_id', 'status_action' );
		foreach ( $required_fields as $field ) {
			if ( empty( $_POST[$field] ) ) {
				wp_send_json_error( array( 'message' => 'Missing required field: ' . $field ) );
				return;
			}
		}
		
		$proposal_id = intval( $_POST['proposal_id'] );
		$rfp_id = intval( $_POST['rfp_id'] );
		$status_action = sanitize_text_field( $_POST['status_action'] );
		
		$proposal = get_post( $proposal_id );
		$rfp = get_post( $rfp_id );
		
		if ( ! $proposal || 'proposal' !== $proposal->post_type || ! $rfp || 'rfp' !== $rfp->post_type ) {
			wp_send_json_error( array( 'message' => 'Invalid proposal or RFP' ) );
			return;
		}
		
		if ( get_current_user_id() !== $rfp->post_author && ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'You do not have permission to update this proposal' ) );
			return;
		}
		
		$new_status = '';
		switch ( $status_action ) {
			case 'accept':
				$new_status = 'accepted';
				update_post_meta( $rfp_id, 'rfp_status', 'awarded' );
				break;
			case 'review':
				$new_status = 'under_review';
				break;
			case 'reject':
				$new_status = 'rejected';
				break;
			default:
				wp_send_json_error( array( 'message' => 'Invalid status action' ) );
				return;
		}
		
		update_post_meta( $proposal_id, 'proposal_status', $new_status );
		
		$this->notify_proposal_author_of_status_change( $proposal_id, $new_status );
		
		wp_send_json_success( array(
			'message' => 'Proposal status updated successfully',
			'proposal_id' => $proposal_id,
			'new_status' => $new_status,
		) );
	}

	/**
	 * Notify proposal author of status change.
	 *
	 * @since    1.0.0
	 * @param    int       $proposal_id    The proposal ID.
	 * @param    string    $new_status     The new status.
	 */
	private function notify_proposal_author_of_status_change( $proposal_id, $new_status ) {
		error_log( 'Notifying proposal author of status change: ' . $proposal_id . ' to ' . $new_status );
	}
}
