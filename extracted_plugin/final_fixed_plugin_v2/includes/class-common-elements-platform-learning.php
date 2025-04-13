<?php
/**
 * The learning functionality of the plugin.
 *
 * @package Common_Elements_Platform
 */

/**
 * The learning functionality of the plugin.
 *
 * Handles all learning-related functionality including
 * courses, lessons, quizzes, and user progress tracking.
 */
class Common_Elements_Platform_Learning {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_learning_post_types' ) );
		add_action( 'init', array( $this, 'register_learning_taxonomies' ) );
		add_action( 'init', array( $this, 'register_learning_endpoints' ) );
		
		add_action( 'add_meta_boxes', array( $this, 'add_learning_meta_boxes' ) );
		
		add_action( 'save_post_course', array( $this, 'save_course_meta_box_data' ) );
		add_action( 'save_post_lesson', array( $this, 'save_lesson_meta_box_data' ) );
		add_action( 'save_post_quiz', array( $this, 'save_quiz_meta_box_data' ) );
		
		add_filter( 'template_include', array( $this, 'learning_template' ) );
		
		add_action( 'wp_ajax_enroll_course', array( $this, 'enroll_course' ) );
		add_action( 'wp_ajax_complete_lesson', array( $this, 'complete_lesson' ) );
		add_action( 'wp_ajax_submit_quiz', array( $this, 'submit_quiz' ) );
	}

	/**
	 * Register Learning custom post types
	 *
	 * @since    1.0.0
	 */
	public function register_learning_post_types() {
		$course_labels = array(
			'name'                  => _x( 'Courses', 'Post type general name', 'common-elements-platform' ),
			'singular_name'         => _x( 'Course', 'Post type singular name', 'common-elements-platform' ),
			'menu_name'             => _x( 'Learning', 'Admin Menu text', 'common-elements-platform' ),
			'name_admin_bar'        => _x( 'Course', 'Add New on Toolbar', 'common-elements-platform' ),
			'add_new'               => __( 'Add New', 'common-elements-platform' ),
			'add_new_item'          => __( 'Add New Course', 'common-elements-platform' ),
			'new_item'              => __( 'New Course', 'common-elements-platform' ),
			'edit_item'             => __( 'Edit Course', 'common-elements-platform' ),
			'view_item'             => __( 'View Course', 'common-elements-platform' ),
			'all_items'             => __( 'All Courses', 'common-elements-platform' ),
			'search_items'          => __( 'Search Courses', 'common-elements-platform' ),
			'parent_item_colon'     => __( 'Parent Courses:', 'common-elements-platform' ),
			'not_found'             => __( 'No courses found.', 'common-elements-platform' ),
			'not_found_in_trash'    => __( 'No courses found in Trash.', 'common-elements-platform' ),
			'featured_image'        => _x( 'Course Cover Image', 'Overrides the "Featured Image" phrase', 'common-elements-platform' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase', 'common-elements-platform' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase', 'common-elements-platform' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase', 'common-elements-platform' ),
			'archives'              => _x( 'Course archives', 'The post type archive label used in nav menus', 'common-elements-platform' ),
			'insert_into_item'      => _x( 'Insert into course', 'Overrides the "Insert into post" phrase', 'common-elements-platform' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this course', 'Overrides the "Uploaded to this post" phrase', 'common-elements-platform' ),
			'filter_items_list'     => _x( 'Filter courses list', 'Screen reader text for the filter links heading on the post type listing screen', 'common-elements-platform' ),
			'items_list_navigation' => _x( 'Courses list navigation', 'Screen reader text for the pagination heading on the post type listing screen', 'common-elements-platform' ),
			'items_list'            => _x( 'Courses list', 'Screen reader text for the items list heading on the post type listing screen', 'common-elements-platform' ),
		);

		$course_args = array(
			'labels'             => $course_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false, // Will be added as submenu to Common Elements
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'course' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-welcome-learn-more',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'course', $course_args );

		$lesson_labels = array(
			'name'                  => _x( 'Lessons', 'Post type general name', 'common-elements-platform' ),
			'singular_name'         => _x( 'Lesson', 'Post type singular name', 'common-elements-platform' ),
			'menu_name'             => _x( 'Lessons', 'Admin Menu text', 'common-elements-platform' ),
			'name_admin_bar'        => _x( 'Lesson', 'Add New on Toolbar', 'common-elements-platform' ),
			'add_new'               => __( 'Add New', 'common-elements-platform' ),
			'add_new_item'          => __( 'Add New Lesson', 'common-elements-platform' ),
			'new_item'              => __( 'New Lesson', 'common-elements-platform' ),
			'edit_item'             => __( 'Edit Lesson', 'common-elements-platform' ),
			'view_item'             => __( 'View Lesson', 'common-elements-platform' ),
			'all_items'             => __( 'All Lessons', 'common-elements-platform' ),
			'search_items'          => __( 'Search Lessons', 'common-elements-platform' ),
			'parent_item_colon'     => __( 'Parent Lessons:', 'common-elements-platform' ),
			'not_found'             => __( 'No lessons found.', 'common-elements-platform' ),
			'not_found_in_trash'    => __( 'No lessons found in Trash.', 'common-elements-platform' ),
		);

		$lesson_args = array(
			'labels'             => $lesson_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false, // Will be added as submenu to Common Elements
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'lesson' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-media-document',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'lesson', $lesson_args );

		$quiz_labels = array(
			'name'                  => _x( 'Quizzes', 'Post type general name', 'common-elements-platform' ),
			'singular_name'         => _x( 'Quiz', 'Post type singular name', 'common-elements-platform' ),
			'menu_name'             => _x( 'Quizzes', 'Admin Menu text', 'common-elements-platform' ),
			'name_admin_bar'        => _x( 'Quiz', 'Add New on Toolbar', 'common-elements-platform' ),
			'add_new'               => __( 'Add New', 'common-elements-platform' ),
			'add_new_item'          => __( 'Add New Quiz', 'common-elements-platform' ),
			'new_item'              => __( 'New Quiz', 'common-elements-platform' ),
			'edit_item'             => __( 'Edit Quiz', 'common-elements-platform' ),
			'view_item'             => __( 'View Quiz', 'common-elements-platform' ),
			'all_items'             => __( 'All Quizzes', 'common-elements-platform' ),
			'search_items'          => __( 'Search Quizzes', 'common-elements-platform' ),
			'parent_item_colon'     => __( 'Parent Quizzes:', 'common-elements-platform' ),
			'not_found'             => __( 'No quizzes found.', 'common-elements-platform' ),
			'not_found_in_trash'    => __( 'No quizzes found in Trash.', 'common-elements-platform' ),
		);

		$quiz_args = array(
			'labels'             => $quiz_labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => false, // Will be added as submenu to Common Elements
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'quiz' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => 'dashicons-clipboard',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'quiz', $quiz_args );
	}

	/**
	 * Register Learning taxonomies
	 *
	 * @since    1.0.0
	 */
	public function register_learning_taxonomies() {
		$category_labels = array(
			'name'              => _x( 'Course Categories', 'taxonomy general name', 'common-elements-platform' ),
			'singular_name'     => _x( 'Course Category', 'taxonomy singular name', 'common-elements-platform' ),
			'search_items'      => __( 'Search Course Categories', 'common-elements-platform' ),
			'all_items'         => __( 'All Course Categories', 'common-elements-platform' ),
			'parent_item'       => __( 'Parent Course Category', 'common-elements-platform' ),
			'parent_item_colon' => __( 'Parent Course Category:', 'common-elements-platform' ),
			'edit_item'         => __( 'Edit Course Category', 'common-elements-platform' ),
			'update_item'       => __( 'Update Course Category', 'common-elements-platform' ),
			'add_new_item'      => __( 'Add New Course Category', 'common-elements-platform' ),
			'new_item_name'     => __( 'New Course Category Name', 'common-elements-platform' ),
			'menu_name'         => __( 'Categories', 'common-elements-platform' ),
		);

		$category_args = array(
			'hierarchical'      => true,
			'labels'            => $category_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'course-category' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'course_category', array( 'course' ), $category_args );

		$tag_labels = array(
			'name'              => _x( 'Course Tags', 'taxonomy general name', 'common-elements-platform' ),
			'singular_name'     => _x( 'Course Tag', 'taxonomy singular name', 'common-elements-platform' ),
			'search_items'      => __( 'Search Course Tags', 'common-elements-platform' ),
			'all_items'         => __( 'All Course Tags', 'common-elements-platform' ),
			'parent_item'       => __( 'Parent Course Tag', 'common-elements-platform' ),
			'parent_item_colon' => __( 'Parent Course Tag:', 'common-elements-platform' ),
			'edit_item'         => __( 'Edit Course Tag', 'common-elements-platform' ),
			'update_item'       => __( 'Update Course Tag', 'common-elements-platform' ),
			'add_new_item'      => __( 'Add New Course Tag', 'common-elements-platform' ),
			'new_item_name'     => __( 'New Course Tag Name', 'common-elements-platform' ),
			'menu_name'         => __( 'Tags', 'common-elements-platform' ),
		);

		$tag_args = array(
			'hierarchical'      => false,
			'labels'            => $tag_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'course-tag' ),
			'show_in_rest'      => true,
		);

		register_taxonomy( 'course_tag', array( 'course' ), $tag_args );
	}

	/**
	 * Register learning endpoints.
	 *
	 * @since    1.0.0
	 */
	public function register_learning_endpoints() {
		add_rewrite_rule(
			'learning/category/([^/]+)/?$',
			'index.php?course_category=$matches[1]',
			'top'
		);
		
		add_rewrite_rule(
			'learning/tag/([^/]+)/?$',
			'index.php?course_tag=$matches[1]',
			'top'
		);
		
		add_rewrite_tag( '%course_category%', '([^&]+)' );
		add_rewrite_tag( '%course_tag%', '([^&]+)' );
	}

	/**
	 * Add Learning meta boxes
	 *
	 * @since    1.0.0
	 */
	public function add_learning_meta_boxes() {
		add_meta_box(
			'course_details',
			__( 'Course Details', 'common-elements-platform' ),
			array( $this, 'course_details_meta_box_callback' ),
			'course',
			'normal',
			'high'
		);
		
		add_meta_box(
			'course_curriculum',
			__( 'Course Curriculum', 'common-elements-platform' ),
			array( $this, 'course_curriculum_meta_box_callback' ),
			'course',
			'normal',
			'default'
		);
		
		add_meta_box(
			'lesson_details',
			__( 'Lesson Details', 'common-elements-platform' ),
			array( $this, 'lesson_details_meta_box_callback' ),
			'lesson',
			'normal',
			'high'
		);
		
		add_meta_box(
			'quiz_details',
			__( 'Quiz Details', 'common-elements-platform' ),
			array( $this, 'quiz_details_meta_box_callback' ),
			'quiz',
			'normal',
			'high'
		);
		
		add_meta_box(
			'quiz_questions',
			__( 'Quiz Questions', 'common-elements-platform' ),
			array( $this, 'quiz_questions_meta_box_callback' ),
			'quiz',
			'normal',
			'default'
		);
	}
}
