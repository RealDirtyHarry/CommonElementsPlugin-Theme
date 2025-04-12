<?php
/**
 * Register all custom post types for the plugin
 *
 * @package Common_Elements_Platform
 */

/**
 * Class responsible for registering custom post types and taxonomies.
 */
class Common_Elements_Platform_Post_Types {

	/**
	 * Register custom post types.
	 *
	 * @since    1.0.0
	 */
	public function register_post_types() {
		// Register RFP post type
		register_post_type(
			'rfp',
			array(
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
				'show_in_menu'        => false, // Hide from top-level menu, will be shown as submenu
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'show_in_rest'        => true,
				'menu_icon'           => 'dashicons-media-document',
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'rfps' ),
				'query_var'           => true,
			)
		);

		// Register Proposal post type
		register_post_type(
			'proposal',
			array(
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
				),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => false, // Hide from top-level menu, will be shown as submenu
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'show_in_rest'        => true,
				'menu_icon'           => 'dashicons-media-text',
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'proposals' ),
				'query_var'           => true,
			)
		);

		// Register Directory Listing post type
		register_post_type(
			'directory_listing',
			array(
				'labels'              => array(
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
				),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => false, // Hide from top-level menu, will be shown as submenu
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'show_in_rest'        => true,
				'menu_icon'           => 'dashicons-building',
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'directory' ),
				'query_var'           => true,
			)
		);

		register_post_type(
			'learning',
			array(
				'labels'              => array(
					'name'                  => _x( 'Learning Hub Items', 'Post type general name', 'common-elements-platform' ),
					'singular_name'         => _x( 'Learning Hub Item', 'Post type singular name', 'common-elements-platform' ),
					'menu_name'             => _x( 'Learning Hub', 'Admin Menu text', 'common-elements-platform' ),
					'name_admin_bar'        => _x( 'Learning Item', 'Add New on Toolbar', 'common-elements-platform' ),
					'add_new'               => __( 'Add New', 'common-elements-platform' ),
					'add_new_item'          => __( 'Add New Learning Item', 'common-elements-platform' ),
					'new_item'              => __( 'New Learning Item', 'common-elements-platform' ),
					'edit_item'             => __( 'Edit Learning Item', 'common-elements-platform' ),
					'view_item'             => __( 'View Learning Item', 'common-elements-platform' ),
					'all_items'             => __( 'All Learning Items', 'common-elements-platform' ),
					'search_items'          => __( 'Search Learning Items', 'common-elements-platform' ),
					'not_found'             => __( 'No learning items found.', 'common-elements-platform' ),
					'not_found_in_trash'    => __( 'No learning items found in Trash.', 'common-elements-platform' ),
				),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => false, // Assume submenu for now
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'show_in_rest'        => true,
				'menu_icon'           => 'dashicons-welcome-learn-more',
				'capability_type'     => 'post',
				'hierarchical'        => false, // Assume non-hierarchical for now
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'learning' ),
				'query_var'           => true,
			)
		);

	}

	/**
	 * Register custom taxonomies.
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomies() {
		// Register RFP Category taxonomy
		register_taxonomy(
			'rfp_category',
			'rfp',
			array(
				'labels'            => array(
					'name'              => _x( 'RFP Categories', 'taxonomy general name', 'common-elements-platform' ),
					'singular_name'     => _x( 'RFP Category', 'taxonomy singular name', 'common-elements-platform' ),
					'search_items'      => __( 'Search RFP Categories', 'common-elements-platform' ),
					'all_items'         => __( 'All RFP Categories', 'common-elements-platform' ),
					'parent_item'       => __( 'Parent RFP Category', 'common-elements-platform' ),
					'parent_item_colon' => __( 'Parent RFP Category:', 'common-elements-platform' ),
					'edit_item'         => __( 'Edit RFP Category', 'common-elements-platform' ),
					'update_item'       => __( 'Update RFP Category', 'common-elements-platform' ),
					'add_new_item'      => __( 'Add New RFP Category', 'common-elements-platform' ),
					'new_item_name'     => __( 'New RFP Category Name', 'common-elements-platform' ),
					'menu_name'         => __( 'RFP Categories', 'common-elements-platform' ),
				),
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'rfp-category' ),
				'show_in_rest'      => true,
			)
		);

		// Register Directory Category taxonomy
		register_taxonomy(
			'directory_category',
			'directory_listing',
			array(
				'labels'            => array(
					'name'              => _x( 'Directory Categories', 'taxonomy general name', 'common-elements-platform' ),
					'singular_name'     => _x( 'Directory Category', 'taxonomy singular name', 'common-elements-platform' ),
					'search_items'      => __( 'Search Directory Categories', 'common-elements-platform' ),
					'all_items'         => __( 'All Directory Categories', 'common-elements-platform' ),
					'parent_item'       => __( 'Parent Directory Category', 'common-elements-platform' ),
					'parent_item_colon' => __( 'Parent Directory Category:', 'common-elements-platform' ),
					'edit_item'         => __( 'Edit Directory Category', 'common-elements-platform' ),
					'update_item'       => __( 'Update Directory Category', 'common-elements-platform' ),
					'add_new_item'      => __( 'Add New Directory Category', 'common-elements-platform' ),
					'new_item_name'     => __( 'New Directory Category Name', 'common-elements-platform' ),
					'menu_name'         => __( 'Directory Categories', 'common-elements-platform' ),
				),
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'directory-category' ),
				'show_in_rest'      => true,
			)
		);

		// Register Directory Location taxonomy
		register_taxonomy(
			'directory_location',
			'directory_listing',
			array(
				'labels'            => array(
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
				),
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'directory-location' ),
				'show_in_rest'      => true,
			)
		);
	}
}
