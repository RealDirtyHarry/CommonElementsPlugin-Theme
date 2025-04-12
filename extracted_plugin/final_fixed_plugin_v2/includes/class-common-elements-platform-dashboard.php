<?php
/**
 * The dashboard functionality of the plugin.
 *
 * @package Common_Elements_Platform
 */

/**
 * The dashboard functionality of the plugin.
 *
 * Handles all dashboard-related functionality including
 * board member, CAM professional, and vendor dashboards.
 */
class Common_Elements_Platform_Dashboard {

	/**
	 * Register dashboard endpoints.
	 *
	 * @since    1.0.0
	 */
	public function register_dashboard_endpoints() {
		add_rewrite_rule(
			'dashboard/([^/]+)/?$',
			'index.php?dashboard_type=$matches[1]',
			'top'
		);
		
		add_rewrite_tag( '%dashboard_type%', '([^&]+)' );
	}

	/**
	 * Get dashboard data via AJAX.
	 *
	 * @since    1.0.0
	 */
	public function get_dashboard_data() {
		// Check nonce for security
		check_ajax_referer( 'common_elements_platform_nonce', 'nonce' );
		
		// Check if user is logged in
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( array( 'message' => 'User not logged in' ) );
			return;
		}
		
		$user = wp_get_current_user();
		$roles = (array) $user->roles;
		$dashboard_type = isset( $_POST['dashboard_type'] ) ? sanitize_text_field( $_POST['dashboard_type'] ) : 'member';
		
		// Prepare dashboard data based on user role
		$data = array(
			'user_id' => $user->ID,
			'user_name' => $user->display_name,
			'dashboard_type' => $dashboard_type,
		);
		
		// Add role-specific data
		if ( in_array( 'administrator', $roles ) || in_array( 'editor', $roles ) ) {
			// Board member dashboard data
			$data['recent_rfps'] = $this->get_recent_rfps();
			$data['recent_proposals'] = $this->get_recent_proposals();
			$data['community_stats'] = $this->get_community_stats();
			$data['learning_stats'] = $this->get_learning_stats();
		} elseif ( in_array( 'author', $roles ) ) {
			// CAM professional dashboard data
			$data['assigned_communities'] = $this->get_assigned_communities( $user->ID );
			$data['recent_rfps'] = $this->get_recent_rfps();
			$data['learning_progress'] = $this->get_learning_progress( $user->ID );
		} elseif ( in_array( 'contributor', $roles ) ) {
			// Vendor dashboard data
			$data['open_rfps'] = $this->get_open_rfps();
			$data['my_proposals'] = $this->get_user_proposals( $user->ID );
			$data['directory_listing'] = $this->get_vendor_listing( $user->ID );
		} else {
			// Regular member dashboard data
			$data['recent_forum_topics'] = $this->get_recent_forum_topics();
			$data['recent_classifieds'] = $this->get_recent_classifieds();
		}
		
		wp_send_json_success( $data );
	}

	/**
	 * Get recent RFPs.
	 *
	 * @since    1.0.0
	 * @return   array    Array of recent RFPs.
	 */
	private function get_recent_rfps() {
		$args = array(
			'post_type' => 'rfp',
			'posts_per_page' => 5,
			'orderby' => 'date',
			'order' => 'DESC',
		);
		
		$query = new WP_Query( $args );
		$rfps = array();
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$rfps[] = array(
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'date' => get_the_date(),
					'status' => get_post_meta( get_the_ID(), 'rfp_status', true ),
					'url' => get_permalink(),
				);
			}
			wp_reset_postdata();
		}
		
		return $rfps;
	}

	/**
	 * Get recent proposals.
	 *
	 * @since    1.0.0
	 * @return   array    Array of recent proposals.
	 */
	private function get_recent_proposals() {
		$args = array(
			'post_type' => 'proposal',
			'posts_per_page' => 5,
			'orderby' => 'date',
			'order' => 'DESC',
		);
		
		$query = new WP_Query( $args );
		$proposals = array();
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$proposals[] = array(
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'date' => get_the_date(),
					'vendor' => get_the_author(),
					'rfp_id' => get_post_meta( get_the_ID(), 'related_rfp', true ),
					'url' => get_permalink(),
				);
			}
			wp_reset_postdata();
		}
		
		return $proposals;
	}

	/**
	 * Get community statistics.
	 *
	 * @since    1.0.0
	 * @return   array    Array of community statistics.
	 */
	private function get_community_stats() {
		// This would be populated with actual data in a real implementation
		return array(
			'total_members' => 1250,
			'active_members' => 875,
			'total_posts' => 3240,
			'total_topics' => 645,
		);
	}

	/**
	 * Get learning statistics.
	 *
	 * @since    1.0.0
	 * @return   array    Array of learning statistics.
	 */
	private function get_learning_stats() {
		// This would be populated with actual data in a real implementation
		return array(
			'total_courses' => 24,
			'active_learners' => 430,
			'completed_courses' => 1875,
			'certificates_issued' => 1245,
		);
	}

	/**
	 * Get assigned communities for a CAM professional.
	 *
	 * @since    1.0.0
	 * @param    int       $user_id    The user ID.
	 * @return   array                 Array of assigned communities.
	 */
	private function get_assigned_communities( $user_id ) {
		// This would be populated with actual data in a real implementation
		return array(
			array(
				'id' => 1,
				'name' => 'Oakwood Heights',
				'units' => 124,
				'status' => 'active',
				'url' => '#',
			),
			array(
				'id' => 2,
				'name' => 'Riverside Gardens',
				'units' => 86,
				'status' => 'active',
				'url' => '#',
			),
			array(
				'id' => 3,
				'name' => 'Maple Ridge Estates',
				'units' => 210,
				'status' => 'active',
				'url' => '#',
			),
		);
	}

	/**
	 * Get learning progress for a user.
	 *
	 * @since    1.0.0
	 * @param    int       $user_id    The user ID.
	 * @return   array                 Array of learning progress data.
	 */
	private function get_learning_progress( $user_id ) {
		// This would be populated with actual data in a real implementation
		return array(
			'enrolled_courses' => 5,
			'completed_courses' => 3,
			'in_progress_courses' => 2,
			'certificates' => 3,
			'ce_credits' => 24,
		);
	}

	/**
	 * Get open RFPs.
	 *
	 * @since    1.0.0
	 * @return   array    Array of open RFPs.
	 */
	private function get_open_rfps() {
		$args = array(
			'post_type' => 'rfp',
			'posts_per_page' => 10,
			'orderby' => 'date',
			'order' => 'DESC',
			'meta_query' => array(
				array(
					'key' => 'rfp_status',
					'value' => 'open',
					'compare' => '=',
				),
			),
		);
		
		$query = new WP_Query( $args );
		$rfps = array();
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$rfps[] = array(
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'date' => get_the_date(),
					'deadline' => get_post_meta( get_the_ID(), 'rfp_deadline', true ),
					'community' => get_post_meta( get_the_ID(), 'rfp_community', true ),
					'url' => get_permalink(),
				);
			}
			wp_reset_postdata();
		}
		
		return $rfps;
	}

	/**
	 * Get proposals submitted by a user.
	 *
	 * @since    1.0.0
	 * @param    int       $user_id    The user ID.
	 * @return   array                 Array of user proposals.
	 */
	private function get_user_proposals( $user_id ) {
		$args = array(
			'post_type' => 'proposal',
			'posts_per_page' => 10,
			'orderby' => 'date',
			'order' => 'DESC',
			'author' => $user_id,
		);
		
		$query = new WP_Query( $args );
		$proposals = array();
		
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$proposals[] = array(
					'id' => get_the_ID(),
					'title' => get_the_title(),
					'date' => get_the_date(),
					'status' => get_post_meta( get_the_ID(), 'proposal_status', true ),
					'rfp_id' => get_post_meta( get_the_ID(), 'related_rfp', true ),
					'url' => get_permalink(),
				);
			}
			wp_reset_postdata();
		}
		
		return $proposals;
	}

	/**
	 * Get vendor directory listing.
	 *
	 * @since    1.0.0
	 * @param    int       $user_id    The user ID.
	 * @return   array                 Vendor listing data.
	 */
	private function get_vendor_listing( $user_id ) {
		$args = array(
			'post_type' => 'directory_listing',
			'posts_per_page' => 1,
			'author' => $user_id,
		);
		
		$query = new WP_Query( $args );
		$listing = array();
		
		if ( $query->have_posts() ) {
			$query->the_post();
			$listing = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'description' => get_the_excerpt(),
				'logo' => get_the_post_thumbnail_url(),
				'categories' => wp_get_post_terms( get_the_ID(), 'directory_category', array( 'fields' => 'names' ) ),
				'locations' => wp_get_post_terms( get_the_ID(), 'directory_location', array( 'fields' => 'names' ) ),
				'url' => get_permalink(),
			);
			wp_reset_postdata();
		}
		
		return $listing;
	}

	/**
	 * Get recent forum topics.
	 *
	 * @since    1.0.0
	 * @return   array    Array of recent forum topics.
	 */
	private function get_recent_forum_topics() {
		// This would be populated with actual data in a real implementation
		// For now, we'll return dummy data
		return array(
			array(
				'id' => 1,
				'title' => 'Best practices for community pool maintenance',
				'author' => 'John Smith',
				'date' => '2025-04-01',
				'replies' => 12,
				'url' => '#',
			),
			array(
				'id' => 2,
				'title' => 'Recommended vendors for landscaping services',
				'author' => 'Sarah Johnson',
				'date' => '2025-03-28',
				'replies' => 8,
				'url' => '#',
			),
			array(
				'id' => 3,
				'title' => 'New regulations affecting HOA governance',
				'author' => 'Michael Brown',
				'date' => '2025-03-25',
				'replies' => 15,
				'url' => '#',
			),
		);
	}

	/**
	 * Get recent classifieds.
	 *
	 * @since    1.0.0
	 * @return   array    Array of recent classifieds.
	 */
	private function get_recent_classifieds() {
		// This would be populated with actual data in a real implementation
		// For now, we'll return dummy data
		return array(
			array(
				'id' => 1,
				'title' => 'Professional landscaping services',
				'author' => 'Green Thumb Landscaping',
				'date' => '2025-04-02',
				'category' => 'Services',
				'url' => '#',
			),
			array(
				'id' => 2,
				'title' => 'Certified pool maintenance',
				'author' => 'Crystal Clear Pools',
				'date' => '2025-03-30',
				'category' => 'Services',
				'url' => '#',
			),
			array(
				'id' => 3,
				'title' => 'Security system installation',
				'author' => 'Secure Home Systems',
				'date' => '2025-03-27',
				'category' => 'Services',
				'url' => '#',
			),
		);
	}
}
