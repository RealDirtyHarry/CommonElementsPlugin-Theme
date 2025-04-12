<?php
/**
 * The RFP system functionality of the plugin.
 *
 * @package Common_Elements_Platform
 */

/**
 * The RFP system functionality of the plugin.
 *
 * Handles all RFP-related functionality including
 * RFP submission, proposal management, and notifications.
 */
class Common_Elements_Platform_RFP {

	/**
	 * Register RFP endpoints.
	 *
	 * @since    1.0.0
	 */
	public function register_rfp_endpoints() {
		add_rewrite_rule(
			'rfp/([^/]+)/?$',
			'index.php?rfp=$matches[1]',
			'top'
		);
		
		add_rewrite_rule(
			'rfp-proposals/([^/]+)/?$',
			'index.php?rfp_proposal=$matches[1]',
			'top'
		);
		
		add_rewrite_tag( '%rfp%', '([^&]+)' );
		add_rewrite_tag( '%rfp_proposal%', '([^&]+)' );
	}

	/**
	 * Handle RFP submission via AJAX.
	 *
	 * @since    1.0.0
	 */
	public function submit_rfp() {
		// Check nonce for security
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		// Check if user is logged in
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		if ( ! current_user_can( 'publish_posts' ) ) {
			wp_send_json_error( array( 'message' => 'Insufficient permissions to submit RFPs.' ) );
			return;
		}
		$user = wp_get_current_user(); // Still need user object for author ID
		
		// Validate required fields
		$required_fields = array( 'title', 'description', 'deadline', 'community' );
		foreach ( $required_fields as $field ) {
			if ( empty( $_POST[$field] ) ) {
				wp_send_json_error( array( 'message' => 'Missing required field: ' . $field ) );
				return;
			}
		}
		
		// Sanitize input
		$title = sanitize_text_field( $_POST['title'] );
		$description = wp_kses_post( $_POST['description'] );
		$deadline = sanitize_text_field( $_POST['deadline'] );
		$community = sanitize_text_field( $_POST['community'] );
		$category = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';
		
		// Create RFP post
		$rfp_data = array(
			'post_title'    => $title,
			'post_content'  => $description,
			'post_status'   => 'publish',
			'post_type'     => 'rfp',
			'post_author'   => $user->ID,
		);
		
		$rfp_id = wp_insert_post( $rfp_data );
		
		if ( is_wp_error( $rfp_id ) ) {
			wp_send_json_error( array( 'message' => $rfp_id->get_error_message() ) );
			return;
		}
		
		// Add RFP metadata
		update_post_meta( $rfp_id, 'rfp_deadline', $deadline );
		update_post_meta( $rfp_id, 'rfp_community', $community );
		update_post_meta( $rfp_id, 'rfp_status', 'open' );
		
		// Set RFP category if provided
		if ( ! empty( $category ) ) {
			wp_set_object_terms( $rfp_id, $category, 'rfp_category' );
		}
		
		// Handle file uploads if any
		if ( ! empty( $_FILES ) ) {
			foreach ( $_FILES as $file_key => $file_array ) {
				if ( ! empty( $file_array['name'] ) ) {
					$attachment_id = media_handle_upload( $file_key, $rfp_id );
					if ( ! is_wp_error( $attachment_id ) ) {
						add_post_meta( $rfp_id, 'rfp_attachment', $attachment_id );
					}
				}
			}
		}
		
		// Send notification to vendors
		$this->notify_vendors_of_new_rfp( $rfp_id );
		
		wp_send_json_success( array(
			'message' => 'RFP created successfully',
			'rfp_id' => $rfp_id,
			'rfp_url' => get_permalink( $rfp_id ),
		) );
	}

	/**
	 * Handle proposal submission via AJAX.
	 *
	 * @since    1.0.0
	 */
	public function submit_proposal() {
		// Check nonce for security
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		// Check if user is logged in
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( array( 'message' => 'Insufficient permissions to submit proposals.' ) );
			return;
		}
		$user = wp_get_current_user(); // Still need user object for author ID
		
		// Validate required fields
		$required_fields = array( 'rfp_id', 'title', 'description', 'price' );
		foreach ( $required_fields as $field ) {
			if ( empty( $_POST[$field] ) ) {
				wp_send_json_error( array( 'message' => 'Missing required field: ' . $field ) );
				return;
			}
		}
		
		// Sanitize input
		$rfp_id = intval( $_POST['rfp_id'] );
		$title = sanitize_text_field( $_POST['title'] );
		$description = wp_kses_post( $_POST['description'] );
		$price = sanitize_text_field( $_POST['price'] );
		$timeline = isset( $_POST['timeline'] ) ? sanitize_text_field( $_POST['timeline'] ) : '';
		
		// Verify RFP exists and is open
		$rfp = get_post( $rfp_id );
		if ( ! $rfp || $rfp->post_type !== 'rfp' ) {
			wp_send_json_error( array( 'message' => 'Invalid RFP' ) );
			return;
		}
		
		$rfp_status = get_post_meta( $rfp_id, 'rfp_status', true );
		if ( $rfp_status !== 'open' ) {
			wp_send_json_error( array( 'message' => 'This RFP is no longer accepting proposals' ) );
			return;
		}
		
		// Create proposal post
		$proposal_data = array(
			'post_title'    => $title,
			'post_content'  => $description,
			'post_status'   => 'publish',
			'post_type'     => 'proposal',
			'post_author'   => $user->ID,
		);
		
		$proposal_id = wp_insert_post( $proposal_data );
		
		if ( is_wp_error( $proposal_id ) ) {
			wp_send_json_error( array( 'message' => $proposal_id->get_error_message() ) );
			return;
		}
		
		// Add proposal metadata
		update_post_meta( $proposal_id, 'related_rfp', $rfp_id );
		update_post_meta( $proposal_id, 'proposal_price', $price );
		update_post_meta( $proposal_id, 'proposal_timeline', $timeline );
		update_post_meta( $proposal_id, 'proposal_status', 'submitted' );
		
		// Handle file uploads if any
		if ( ! empty( $_FILES ) ) {
			foreach ( $_FILES as $file_key => $file_array ) {
				if ( ! empty( $file_array['name'] ) ) {
					$attachment_id = media_handle_upload( $file_key, $proposal_id );
					if ( ! is_wp_error( $attachment_id ) ) {
						add_post_meta( $proposal_id, 'proposal_attachment', $attachment_id );
					}
				}
			}
		}
		
		// Notify RFP author of new proposal
		$this->notify_rfp_author_of_new_proposal( $rfp_id, $proposal_id );
		
		wp_send_json_success( array(
			'message' => 'Proposal submitted successfully',
			'proposal_id' => $proposal_id,
			'proposal_url' => get_permalink( $proposal_id ),
		) );
	}

	/**
	 * Notify vendors of a new RFP.
	 *
	 * @since    1.0.0
	 * @param    int    $rfp_id    The RFP ID.
	 */
	private function notify_vendors_of_new_rfp( $rfp_id ) {
		// In a real implementation, this would send emails or notifications to vendors
		// For now, we'll just log the action
		error_log( 'Notifying vendors of new RFP: ' . $rfp_id );
	}

	/**
	 * Notify RFP author of a new proposal.
	 *
	 * @since    1.0.0
	 * @param    int    $rfp_id        The RFP ID.
	 * @param    int    $proposal_id   The proposal ID.
	 */
	private function notify_rfp_author_of_new_proposal( $rfp_id, $proposal_id ) {
		// In a real implementation, this would send an email or notification to the RFP author
		// For now, we'll just log the action
		error_log( 'Notifying RFP author of new proposal: ' . $proposal_id . ' for RFP: ' . $rfp_id );
	}
}
