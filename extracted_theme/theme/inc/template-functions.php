<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Common_Elements
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function common_elements_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Add class based on user role for dashboard styling
	if ( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$roles = (array) $user->roles;
		
		if ( in_array( 'administrator', $roles ) || in_array( 'editor', $roles ) ) {
			$classes[] = 'user-board';
		} elseif ( in_array( 'author', $roles ) ) {
			$classes[] = 'user-cam';
		} elseif ( in_array( 'contributor', $roles ) ) {
			$classes[] = 'user-vendor';
		} else {
			$classes[] = 'user-member';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'common_elements_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function common_elements_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'common_elements_pingback_header' );

/**
 * Modify the excerpt length
 */
function common_elements_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'common_elements_excerpt_length' );

/**
 * Modify the excerpt more string
 */
function common_elements_excerpt_more( $more ) {
	return '&hellip; <a class="read-more" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read More', 'common-elements' ) . '</a>';
}
add_filter( 'excerpt_more', 'common_elements_excerpt_more' );

/**
 * Add custom dashboard page templates based on user role
 */
function common_elements_dashboard_template( $template ) {
	if ( is_page( 'dashboard' ) && is_user_logged_in() ) {
		$user = wp_get_current_user();
		$roles = (array) $user->roles;
		
		if ( in_array( 'administrator', $roles ) || in_array( 'editor', $roles ) ) {
			$new_template = locate_template( array( 'templates/dashboard-board.php' ) );
		} elseif ( in_array( 'author', $roles ) ) {
			$new_template = locate_template( array( 'templates/dashboard-cam.php' ) );
		} elseif ( in_array( 'contributor', $roles ) ) {
			$new_template = locate_template( array( 'templates/dashboard-vendor.php' ) );
		} else {
			$new_template = locate_template( array( 'templates/dashboard-member.php' ) );
		}
		
		if ( '' != $new_template ) {
			return $new_template;
		}
	}
	
	return $template;
}
add_filter( 'template_include', 'common_elements_dashboard_template' );

/**
 * Add custom RFP page templates
 */
function common_elements_rfp_template( $template ) {
	if ( is_page( 'rfp' ) ) {
		$new_template = locate_template( array( 'templates/rfp.php' ) );
		if ( '' != $new_template ) {
			return $new_template;
		}
	}
	
	if ( is_page( 'rfp-proposals' ) ) {
		$new_template = locate_template( array( 'templates/rfp-proposal.php' ) );
		if ( '' != $new_template ) {
			return $new_template;
		}
	}
	
	return $template;
}
add_filter( 'template_include', 'common_elements_rfp_template' );

/**
 * Add custom Directory page template
 */
function common_elements_directory_template( $template ) {
	if ( is_page( 'directory' ) ) {
		$new_template = locate_template( array( 'templates/directory.php' ) );
		if ( '' != $new_template ) {
			return $new_template;
		}
	}
	
	return $template;
}
add_filter( 'template_include', 'common_elements_directory_template' );

/**
 * Add custom Learning Hub page template
 */
function common_elements_learning_hub_template( $template ) {
	if ( is_page( 'learning-hub' ) ) {
		$new_template = locate_template( array( 'templates/learning-hub.php' ) );
		if ( '' != $new_template ) {
			return $new_template;
		}
	}
	
	return $template;
}
add_filter( 'template_include', 'common_elements_learning_hub_template' );
