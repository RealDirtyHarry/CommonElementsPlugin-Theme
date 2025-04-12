<?php
/**
 * RFP System functions for Common Elements theme
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register RFP custom post type
 */
function common_elements_register_rfp_post_type() {
    $labels = array(
        'name'                  => _x( 'RFPs', 'Post type general name', 'common-elements' ),
        'singular_name'         => _x( 'RFP', 'Post type singular name', 'common-elements' ),
        'menu_name'             => _x( 'RFPs', 'Admin Menu text', 'common-elements' ),
        'name_admin_bar'        => _x( 'RFP', 'Add New on Toolbar', 'common-elements' ),
        'add_new'               => __( 'Add New', 'common-elements' ),
        'add_new_item'          => __( 'Add New RFP', 'common-elements' ),
        'new_item'              => __( 'New RFP', 'common-elements' ),
        'edit_item'             => __( 'Edit RFP', 'common-elements' ),
        'view_item'             => __( 'View RFP', 'common-elements' ),
        'all_items'             => __( 'All RFPs', 'common-elements' ),
        'search_items'          => __( 'Search RFPs', 'common-elements' ),
        'parent_item_colon'     => __( 'Parent RFPs:', 'common-elements' ),
        'not_found'             => __( 'No RFPs found.', 'common-elements' ),
        'not_found_in_trash'    => __( 'No RFPs found in Trash.', 'common-elements' ),
        'featured_image'        => _x( 'RFP Cover Image', 'Overrides the "Featured Image" phrase', 'common-elements' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase', 'common-elements' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase', 'common-elements' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase', 'common-elements' ),
        'archives'              => _x( 'RFP archives', 'The post type archive label used in nav menus', 'common-elements' ),
        'insert_into_item'      => _x( 'Insert into RFP', 'Overrides the "Insert into post" phrase', 'common-elements' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this RFP', 'Overrides the "Uploaded to this post" phrase', 'common-elements' ),
        'filter_items_list'     => _x( 'Filter RFPs list', 'Screen reader text for the filter links heading on the post type listing screen', 'common-elements' ),
        'items_list_navigation' => _x( 'RFPs list navigation', 'Screen reader text for the pagination heading on the post type listing screen', 'common-elements' ),
        'items_list'            => _x( 'RFPs list', 'Screen reader text for the items list heading on the post type listing screen', 'common-elements' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'rfp' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-media-document',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'rfp', $args );
    
    // Register RFP Proposal custom post type
    $proposal_labels = array(
        'name'                  => _x( 'Proposals', 'Post type general name', 'common-elements' ),
        'singular_name'         => _x( 'Proposal', 'Post type singular name', 'common-elements' ),
        'menu_name'             => _x( 'Proposals', 'Admin Menu text', 'common-elements' ),
        'name_admin_bar'        => _x( 'Proposal', 'Add New on Toolbar', 'common-elements' ),
        'add_new'               => __( 'Add New', 'common-elements' ),
        'add_new_item'          => __( 'Add New Proposal', 'common-elements' ),
        'new_item'              => __( 'New Proposal', 'common-elements' ),
        'edit_item'             => __( 'Edit Proposal', 'common-elements' ),
        'view_item'             => __( 'View Proposal', 'common-elements' ),
        'all_items'             => __( 'All Proposals', 'common-elements' ),
        'search_items'          => __( 'Search Proposals', 'common-elements' ),
        'parent_item_colon'     => __( 'Parent Proposals:', 'common-elements' ),
        'not_found'             => __( 'No Proposals found.', 'common-elements' ),
        'not_found_in_trash'    => __( 'No Proposals found in Trash.', 'common-elements' ),
    );

    $proposal_args = array(
        'labels'             => $proposal_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=rfp',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'proposal' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'rfp_proposal', $proposal_args );
}
add_action( 'init', 'common_elements_register_rfp_post_type' );

/**
 * Register RFP taxonomies
 */
function common_elements_register_rfp_taxonomies() {
    // Register RFP Category taxonomy
    $category_labels = array(
        'name'              => _x( 'RFP Categories', 'taxonomy general name', 'common-elements' ),
        'singular_name'     => _x( 'RFP Category', 'taxonomy singular name', 'common-elements' ),
        'search_items'      => __( 'Search RFP Categories', 'common-elements' ),
        'all_items'         => __( 'All RFP Categories', 'common-elements' ),
        'parent_item'       => __( 'Parent RFP Category', 'common-elements' ),
        'parent_item_colon' => __( 'Parent RFP Category:', 'common-elements' ),
        'edit_item'         => __( 'Edit RFP Category', 'common-elements' ),
        'update_item'       => __( 'Update RFP Category', 'common-elements' ),
        'add_new_item'      => __( 'Add New RFP Category', 'common-elements' ),
        'new_item_name'     => __( 'New RFP Category Name', 'common-elements' ),
        'menu_name'         => __( 'Categories', 'common-elements' ),
    );

    $category_args = array(
        'hierarchical'      => true,
        'labels'            => $category_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'rfp-category' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'rfp_category', array( 'rfp' ), $category_args );

    // Register RFP Status taxonomy
    $status_labels = array(
        'name'              => _x( 'RFP Statuses', 'taxonomy general name', 'common-elements' ),
        'singular_name'     => _x( 'RFP Status', 'taxonomy singular name', 'common-elements' ),
        'search_items'      => __( 'Search RFP Statuses', 'common-elements' ),
        'all_items'         => __( 'All RFP Statuses', 'common-elements' ),
        'parent_item'       => __( 'Parent RFP Status', 'common-elements' ),
        'parent_item_colon' => __( 'Parent RFP Status:', 'common-elements' ),
        'edit_item'         => __( 'Edit RFP Status', 'common-elements' ),
        'update_item'       => __( 'Update RFP Status', 'common-elements' ),
        'add_new_item'      => __( 'Add New RFP Status', 'common-elements' ),
        'new_item_name'     => __( 'New RFP Status Name', 'common-elements' ),
        'menu_name'         => __( 'Statuses', 'common-elements' ),
    );

    $status_args = array(
        'hierarchical'      => false,
        'labels'            => $status_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'rfp-status' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'rfp_status', array( 'rfp' ), $status_args );
}
add_action( 'init', 'common_elements_register_rfp_taxonomies' );

/**
 * Add RFP meta boxes
 */
function common_elements_add_rfp_meta_boxes() {
    add_meta_box(
        'rfp_details',
        __( 'RFP Details', 'common-elements' ),
        'common_elements_rfp_details_meta_box_callback',
        'rfp',
        'normal',
        'high'
    );
    
    add_meta_box(
        'rfp_proposals',
        __( 'Submitted Proposals', 'common-elements' ),
        'common_elements_rfp_proposals_meta_box_callback',
        'rfp',
        'normal',
        'default'
    );
    
    add_meta_box(
        'proposal_details',
        __( 'Proposal Details', 'common-elements' ),
        'common_elements_proposal_details_meta_box_callback',
        'rfp_proposal',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'common_elements_add_rfp_meta_boxes' );

/**
 * RFP Details meta box callback
 */
function common_elements_rfp_details_meta_box_callback( $post ) {
    // Add nonce for security
    wp_nonce_field( 'common_elements_rfp_details_meta_box', 'common_elements_rfp_details_meta_box_nonce' );
    
    // Get existing values
    $deadline = get_post_meta( $post->ID, '_rfp_deadline', true );
    $budget = get_post_meta( $post->ID, '_rfp_budget', true );
    $location = get_post_meta( $post->ID, '_rfp_location', true );
    
    ?>
    <div class="rfp-details-meta-box">
        <p>
            <label for="rfp_deadline"><?php esc_html_e( 'Submission Deadline', 'common-elements' ); ?></label>
            <input type="date" id="rfp_deadline" name="rfp_deadline" value="<?php echo esc_attr( $deadline ); ?>" class="widefat">
        </p>
        <p>
            <label for="rfp_budget"><?php esc_html_e( 'Budget Range', 'common-elements' ); ?></label>
            <input type="text" id="rfp_budget" name="rfp_budget" value="<?php echo esc_attr( $budget ); ?>" class="widefat">
        </p>
        <p>
            <label for="rfp_location"><?php esc_html_e( 'Location', 'common-elements' ); ?></label>
            <input type="text" id="rfp_location" name="rfp_location" value="<?php echo esc_attr( $location ); ?>" class="widefat">
        </p>
    </div>
    <?php
}

/**
 * RFP Proposals meta box callback
 */
function common_elements_rfp_proposals_meta_box_callback( $post ) {
    // Query proposals for this RFP
    $proposals = get_posts( array(
        'post_type'      => 'rfp_proposal',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'   => '_proposal_rfp_id',
                'value' => $post->ID,
            ),
        ),
    ) );
    
    if ( empty( $proposals ) ) {
        echo '<p>' . esc_html__( 'No proposals have been submitted yet.', 'common-elements' ) . '</p>';
        return;
    }
    
    ?>
    <table class="widefat fixed striped">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Proposal', 'common-elements' ); ?></th>
                <th><?php esc_html_e( 'Vendor', 'common-elements' ); ?></th>
                <th><?php esc_html_e( 'Date Submitted', 'common-elements' ); ?></th>
                <th><?php esc_html_e( 'Actions', 'common-elements' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $proposals as $proposal ) : ?>
                <tr>
                    <td>
                        <a href="<?php echo esc_url( get_edit_post_link( $proposal->ID ) ); ?>">
                            <?php echo esc_html( get_the_title( $proposal->ID ) ); ?>
                        </a>
                    </td>
                    <td><?php echo esc_html( get_the_author_meta( 'display_name', $proposal->post_author ) ); ?></td>
                    <td><?php echo esc_html( get_the_date( '', $proposal->ID ) ); ?></td>
                    <td>
                        <a href="<?php echo esc_url( get_permalink( $proposal->ID ) ); ?>" class="button button-small">
                            <?php esc_html_e( 'View', 'common-elements' ); ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}

/**
 * Proposal Details meta box callback
 */
function common_elements_proposal_details_meta_box_callback( $post ) {
    // Add nonce for security
    wp_nonce_field( 'common_elements_proposal_details_meta_box', 'common_elements_proposal_details_meta_box_nonce' );
    
    // Get existing values
    $rfp_id = get_post_meta( $post->ID, '_proposal_rfp_id', true );
    $price = get_post_meta( $post->ID, '_proposal_price', true );
    $timeline = get_post_meta( $post->ID, '_proposal_timeline', true );
    
    // Get RFPs for dropdown
    $rfps = get_posts( array(
        'post_type'      => 'rfp',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ) );
    
    ?>
    <div class="proposal-details-meta-box">
        <p>
            <label for="proposal_rfp_id"><?php esc_html_e( 'Related RFP', 'common-elements' ); ?></label>
            <select id="proposal_rfp_id" name="proposal_rfp_id" class="widefat">
                <option value=""><?php esc_html_e( 'Select an RFP', 'common-elements' ); ?></option>
                <?php foreach ( $rfps as $rfp ) : ?>
                    <option value="<?php echo esc_attr( $rfp->ID ); ?>" <?php selected( $rfp_id, $rfp->ID ); ?>>
                        <?php echo esc_html( get_the_title( $rfp->ID ) ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="proposal_price"><?php esc_html_e( 'Proposed Price', 'common-elements' ); ?></label>
            <input type="text" id="proposal_price" name="proposal_price" value="<?php echo esc_attr( $price ); ?>" class="widefat">
        </p>
        <p>
            <label for="proposal_timeline"><?php esc_html_e( 'Proposed Timeline', 'common-elements' ); ?></label>
            <input type="text" id="proposal_timeline" name="proposal_timeline" value="<?php echo esc_attr( $timeline ); ?>" class="widefat">
        </p>
    </div>
    <?php
}

/**
 * Save RFP meta box data
 */
function common_elements_save_rfp_meta_box_data( $post_id ) {
    // Check if nonce is set
    if ( ! isset( $_POST['common_elements_rfp_details_meta_box_nonce'] ) ) {
        return;
    }
    
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['common_elements_rfp_details_meta_box_nonce'], 'common_elements_rfp_details_meta_box' ) ) {
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
    
    // Save RFP details
    if ( isset( $_POST['rfp_deadline'] ) ) {
        update_post_meta( $post_id, '_rfp_deadline', sanitize_text_field( $_POST['rfp_deadline'] ) );
    }
    
    if ( isset( $_POST['rfp_budget'] ) ) {
        update_post_meta( $post_id, '_rfp_budget', sanitize_text_field( $_POST['rfp_budget'] ) );
    }
    
    if ( isset( $_POST['rfp_location'] ) ) {
        update_post_meta( $post_id, '_rfp_location', sanitize_text_field( $_POST['rfp_location'] ) );
    }
}
add_action( 'save_post_rfp', 'common_elements_save_rfp_meta_box_data' );

/**
 * Save Proposal meta box data
 */
function common_elements_save_proposal_meta_box_data( $post_id ) {
    // Check if nonce is set
    if ( ! isset( $_POST['common_elements_proposal_details_meta_box_nonce'] ) ) {
        return;
    }
    
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['common_elements_proposal_details_meta_box_nonce'], 'common_elements_proposal_details_meta_box' ) ) {
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
    
    // Save Proposal details
    if ( isset( $_POST['proposal_rfp_id'] ) ) {
        update_post_meta( $post_id, '_proposal_rfp_id', sanitize_text_field( $_POST['proposal_rfp_id'] ) );
    }
    
    if ( isset( $_POST['proposal_price'] ) ) {
        update_post_meta( $post_id, '_proposal_price', sanitize_text_field( $_POST['proposal_price'] ) );
    }
    
    if ( isset( $_POST['proposal_timeline'] ) ) {
        update_post_meta( $post_id, '_proposal_timeline', sanitize_text_field( $_POST['proposal_timeline'] ) );
    }
}
add_action( 'save_post_rfp_proposal', 'common_elements_save_proposal_meta_box_data' );

/**
 * Register RFP shortcodes
 */
function common_elements_register_rfp_shortcodes() {
    // RFP listing shortcode
    add_shortcode( 'ce_rfp_listing', 'common_elements_rfp_listing_shortcode' );
    
    // RFP submission form shortcode
    add_shortcode( 'ce_rfp_submission_form', 'common_elements_rfp_submission_form_shortcode' );
    
    // Proposal submission form shortcode
    add_shortcode( 'ce_proposal_submission_form', 'common_elements_proposal_submission_form_shortcode' );
}
add_action( 'init', 'common_elements_register_rfp_shortcodes' );

/**
 * RFP listing shortcode callback
 */
function common_elements_rfp_listing_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'limit'    => 10,
        'category' => '',
        'status'   => '',
    ), $atts, 'ce_rfp_listing' );
    
    $args = array(
        'post_type'      => 'rfp',
        'posts_per_page' => $atts['limit'],
    );
    
    // Add category filter if specified
    if ( ! empty( $atts['category'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'rfp_category',
            'field'    => 'slug',
            'terms'    => explode( ',', $atts['category'] ),
        );
    }
    
    // Add status filter if specified
    if ( ! empty( $atts['status'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'rfp_status',
            'field'    => 'slug',
            'terms'    => explode( ',', $atts['status'] ),
        );
    }
    
    $rfps = get_posts( $args );
    
    ob_start();
    
    if ( empty( $rfps ) ) {
        echo '<p>' . esc_html__( 'No RFPs found.', 'common-elements' ) . '</p>';
        return ob_get_clean();
    }
    
    ?>
    <div class="ce-rfp-listing">
        <div class="rfp-grid">
            <?php foreach ( $rfps as $rfp ) : ?>
                <?php
                $deadline = get_post_meta( $rfp->ID, '_rfp_deadline', true );
                $budget = get_post_meta( $rfp->ID, '_rfp_budget', true );
                $location = get_post_meta( $rfp->ID, '_rfp_location', true );
                
                // Get categories
                $categories = get_the_terms( $rfp->ID, 'rfp_category' );
                $category_names = array();
                
                if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                    foreach ( $categories as $category ) {
                        $category_names[] = $category->name;
                    }
                }
                
                // Get status
                $statuses = get_the_terms( $rfp->ID, 'rfp_status' );
                $status_name = '';
                
                if ( ! empty( $statuses ) && ! is_wp_error( $statuses ) ) {
                    $status_name = $statuses[0]->name;
                }
                ?>
                <div class="rfp-card">
                    <div class="rfp-card-header">
                        <h3 class="rfp-title">
                            <a href="<?php echo esc_url( get_permalink( $rfp->ID ) ); ?>">
                                <?php echo esc_html( get_the_title( $rfp->ID ) ); ?>
                            </a>
                        </h3>
                        <?php if ( ! empty( $status_name ) ) : ?>
                            <span class="rfp-status"><?php echo esc_html( $status_name ); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="rfp-card-body">
                        <div class="rfp-excerpt">
                            <?php echo wp_kses_post( get_the_excerpt( $rfp->ID ) ); ?>
                        </div>
                        <div class="rfp-meta">
                            <?php if ( ! empty( $deadline ) ) : ?>
                                <div class="rfp-meta-item">
                                    <span class="meta-label"><?php esc_html_e( 'Deadline:', 'common-elements' ); ?></span>
                                    <span class="meta-value"><?php echo esc_html( $deadline ); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( ! empty( $budget ) ) : ?>
                                <div class="rfp-meta-item">
                                    <span class="meta-label"><?php esc_html_e( 'Budget:', 'common-elements' ); ?></span>
                                    <span class="meta-value"><?php echo esc_html( $budget ); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( ! empty( $location ) ) : ?>
                                <div class="rfp-meta-item">
                                    <span class="meta-label"><?php esc_html_e( 'Location:', 'common-elements' ); ?></span>
                                    <span class="meta-value"><?php echo esc_html( $location ); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( ! empty( $category_names ) ) : ?>
                                <div class="rfp-meta-item">
                                    <span class="meta-label"><?php esc_html_e( 'Categories:', 'common-elements' ); ?></span>
                                    <span class="meta-value"><?php echo esc_html( implode( ', ', $category_names ) ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="rfp-card-footer">
                        <a href="<?php echo esc_url( get_permalink( $rfp->ID ) ); ?>" class="btn btn-primary">
                            <?php esc_html_e( 'View Details', 'common-elements' ); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    
    return ob_get_clean();
}

/**
 * RFP submission form shortcode callback
 */
function common_elements_rfp_submission_form_shortcode( $atts ) {
    // Only show form to logged-in users
    if ( ! is_user_logged_in() ) {
        return '<p>' . esc_html__( 'You must be logged in to submit an RFP.', 'common-elements' ) . '</p>';
    }
    
    // Check if user has permission to submit RFPs
    $user = wp_get_current_user();
    $allowed_roles = array( 'administrator', 'board_member', 'cam_professional' );
    $has_permission = false;
    
    foreach ( $allowed_roles as $role ) {
        if ( in_array( $role, (array) $user->roles, true ) ) {
            $has_permission = true;
            break;
        }
    }
    
    if ( ! $has_permission ) {
        return '<p>' . esc_html__( 'You do not have permission to submit RFPs.', 'common-elements' ) . '</p>';
    }
    
    // Process form submission
    $form_submitted = false;
    $form_errors = array();
    
    if ( isset( $_POST['submit_rfp'] ) && isset( $_POST['rfp_nonce'] ) && wp_verify_nonce( $_POST['rfp_nonce'], 'submit_rfp' ) ) {
        // Validate required fields
        if ( empty( $_POST['rfp_title'] ) ) {
            $form_errors[] = __( 'Please enter a title for your RFP.', 'common-elements' );
        }
        
        if ( empty( $_POST['rfp_description'] ) ) {
            $form_errors[] = __( 'Please enter a description for your RFP.', 'common-elements' );
        }
        
        if ( empty( $_POST['rfp_deadline'] ) ) {
            $form_errors[] = __( 'Please enter a submission deadline.', 'common-elements' );
        }
        
        // If no errors, create the RFP
        if ( empty( $form_errors ) ) {
            $rfp_data = array(
                'post_title'   => sanitize_text_field( $_POST['rfp_title'] ),
                'post_content' => wp_kses_post( $_POST['rfp_description'] ),
                'post_status'  => 'publish',
                'post_type'    => 'rfp',
                'post_author'  => get_current_user_id(),
            );
            
            $rfp_id = wp_insert_post( $rfp_data );
            
            if ( ! is_wp_error( $rfp_id ) ) {
                // Save RFP meta data
                update_post_meta( $rfp_id, '_rfp_deadline', sanitize_text_field( $_POST['rfp_deadline'] ) );
                update_post_meta( $rfp_id, '_rfp_budget', sanitize_text_field( $_POST['rfp_budget'] ) );
                update_post_meta( $rfp_id, '_rfp_location', sanitize_text_field( $_POST['rfp_location'] ) );
                
                // Set RFP category if provided
                if ( ! empty( $_POST['rfp_category'] ) ) {
                    wp_set_object_terms( $rfp_id, intval( $_POST['rfp_category'] ), 'rfp_category' );
                }
                
                // Set initial status to "Open"
                wp_set_object_terms( $rfp_id, 'open', 'rfp_status' );
                
                $form_submitted = true;
                $rfp_url = get_permalink( $rfp_id );
            } else {
                $form_errors[] = __( 'Error creating RFP. Please try again.', 'common-elements' );
            }
        }
    }
    
    // Get RFP categories for dropdown
    $categories = get_terms( array(
        'taxonomy'   => 'rfp_category',
        'hide_empty' => false,
    ) );
    
    ob_start();
    
    // Show success message if form was submitted successfully
    if ( $form_submitted ) {
        ?>
        <div class="ce-form-success">
            <p><?php esc_html_e( 'Your RFP has been submitted successfully!', 'common-elements' ); ?></p>
            <p><a href="<?php echo esc_url( $rfp_url ); ?>" class="btn btn-primary"><?php esc_html_e( 'View Your RFP', 'common-elements' ); ?></a></p>
        </div>
        <?php
        return ob_get_clean();
    }
    
    // Show error messages if any
    if ( ! empty( $form_errors ) ) {
        ?>
        <div class="ce-form-errors">
            <ul>
                <?php foreach ( $form_errors as $error ) : ?>
                    <li><?php echo esc_html( $error ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
    
    ?>
    <div class="ce-rfp-submission-form">
        <form method="post" action="">
            <?php wp_nonce_field( 'submit_rfp', 'rfp_nonce' ); ?>
            
            <div class="form-group">
                <label for="rfp_title" class="form-label"><?php esc_html_e( 'RFP Title', 'common-elements' ); ?> <span class="required">*</span></label>
                <input type="text" id="rfp_title" name="rfp_title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="rfp_description" class="form-label"><?php esc_html_e( 'RFP Description', 'common-elements' ); ?> <span class="required">*</span></label>
                <textarea id="rfp_description" name="rfp_description" class="form-control" rows="6" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="rfp_deadline" class="form-label"><?php esc_html_e( 'Submission Deadline', 'common-elements' ); ?> <span class="required">*</span></label>
                <input type="date" id="rfp_deadline" name="rfp_deadline" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="rfp_budget" class="form-label"><?php esc_html_e( 'Budget Range', 'common-elements' ); ?></label>
                <input type="text" id="rfp_budget" name="rfp_budget" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="rfp_location" class="form-label"><?php esc_html_e( 'Location', 'common-elements' ); ?></label>
                <input type="text" id="rfp_location" name="rfp_location" class="form-control">
            </div>
            
            <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                <div class="form-group">
                    <label for="rfp_category" class="form-label"><?php esc_html_e( 'Category', 'common-elements' ); ?></label>
                    <select id="rfp_category" name="rfp_category" class="form-select">
                        <option value=""><?php esc_html_e( 'Select a category', 'common-elements' ); ?></option>
                        <?php foreach ( $categories as $category ) : ?>
                            <option value="<?php echo esc_attr( $category->term_id ); ?>">
                                <?php echo esc_html( $category->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <button type="submit" name="submit_rfp" class="btn btn-primary"><?php esc_html_e( 'Submit RFP', 'common-elements' ); ?></button>
            </div>
        </form>
    </div>
    <?php
    
    return ob_get_clean();
}

/**
 * Proposal submission form shortcode callback
 */
function common_elements_proposal_submission_form_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'rfp_id' => 0,
    ), $atts, 'ce_proposal_submission_form' );
    
    // Only show form to logged-in users
    if ( ! is_user_logged_in() ) {
        return '<p>' . esc_html__( 'You must be logged in to submit a proposal.', 'common-elements' ) . '</p>';
    }
    
    // Check if user has permission to submit proposals
    $user = wp_get_current_user();
    $allowed_roles = array( 'administrator', 'vendor' );
    $has_permission = false;
    
    foreach ( $allowed_roles as $role ) {
        if ( in_array( $role, (array) $user->roles, true ) ) {
            $has_permission = true;
            break;
        }
    }
    
    if ( ! $has_permission ) {
        return '<p>' . esc_html__( 'You do not have permission to submit proposals.', 'common-elements' ) . '</p>';
    }
    
    // Get RFP ID from attribute or current post
    $rfp_id = intval( $atts['rfp_id'] );
    
    if ( $rfp_id === 0 && is_singular( 'rfp' ) ) {
        $rfp_id = get_the_ID();
    }
    
    if ( $rfp_id === 0 ) {
        return '<p>' . esc_html__( 'No RFP specified for proposal submission.', 'common-elements' ) . '</p>';
    }
    
    // Check if RFP exists and is published
    $rfp = get_post( $rfp_id );
    
    if ( ! $rfp || $rfp->post_type !== 'rfp' || $rfp->post_status !== 'publish' ) {
        return '<p>' . esc_html__( 'The specified RFP does not exist or is not available.', 'common-elements' ) . '</p>';
    }
    
    // Check if user has already submitted a proposal for this RFP
    $existing_proposal = get_posts( array(
        'post_type'      => 'rfp_proposal',
        'author'         => get_current_user_id(),
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'   => '_proposal_rfp_id',
                'value' => $rfp_id,
            ),
        ),
    ) );
    
    if ( ! empty( $existing_proposal ) ) {
        $proposal_url = get_permalink( $existing_proposal[0]->ID );
        return '<p>' . sprintf(
            esc_html__( 'You have already submitted a proposal for this RFP. %sView your proposal%s.', 'common-elements' ),
            '<a href="' . esc_url( $proposal_url ) . '">',
            '</a>'
        ) . '</p>';
    }
    
    // Process form submission
    $form_submitted = false;
    $form_errors = array();
    
    if ( isset( $_POST['submit_proposal'] ) && isset( $_POST['proposal_nonce'] ) && wp_verify_nonce( $_POST['proposal_nonce'], 'submit_proposal' ) ) {
        // Validate required fields
        if ( empty( $_POST['proposal_title'] ) ) {
            $form_errors[] = __( 'Please enter a title for your proposal.', 'common-elements' );
        }
        
        if ( empty( $_POST['proposal_content'] ) ) {
            $form_errors[] = __( 'Please enter content for your proposal.', 'common-elements' );
        }
        
        // If no errors, create the proposal
        if ( empty( $form_errors ) ) {
            $proposal_data = array(
                'post_title'   => sanitize_text_field( $_POST['proposal_title'] ),
                'post_content' => wp_kses_post( $_POST['proposal_content'] ),
                'post_status'  => 'publish',
                'post_type'    => 'rfp_proposal',
                'post_author'  => get_current_user_id(),
            );
            
            $proposal_id = wp_insert_post( $proposal_data );
            
            if ( ! is_wp_error( $proposal_id ) ) {
                // Save proposal meta data
                update_post_meta( $proposal_id, '_proposal_rfp_id', $rfp_id );
                update_post_meta( $proposal_id, '_proposal_price', sanitize_text_field( $_POST['proposal_price'] ) );
                update_post_meta( $proposal_id, '_proposal_timeline', sanitize_text_field( $_POST['proposal_timeline'] ) );
                
                $form_submitted = true;
                $proposal_url = get_permalink( $proposal_id );
            } else {
                $form_errors[] = __( 'Error creating proposal. Please try again.', 'common-elements' );
            }
        }
    }
    
    ob_start();
    
    // Show success message if form was submitted successfully
    if ( $form_submitted ) {
        ?>
        <div class="ce-form-success">
            <p><?php esc_html_e( 'Your proposal has been submitted successfully!', 'common-elements' ); ?></p>
            <p><a href="<?php echo esc_url( $proposal_url ); ?>" class="btn btn-primary"><?php esc_html_e( 'View Your Proposal', 'common-elements' ); ?></a></p>
        </div>
        <?php
        return ob_get_clean();
    }
    
    // Show error messages if any
    if ( ! empty( $form_errors ) ) {
        ?>
        <div class="ce-form-errors">
            <ul>
                <?php foreach ( $form_errors as $error ) : ?>
                    <li><?php echo esc_html( $error ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
    
    ?>
    <div class="ce-proposal-submission-form">
        <h3><?php printf( esc_html__( 'Submit Proposal for: %s', 'common-elements' ), esc_html( get_the_title( $rfp_id ) ) ); ?></h3>
        
        <form method="post" action="">
            <?php wp_nonce_field( 'submit_proposal', 'proposal_nonce' ); ?>
            
            <div class="form-group">
                <label for="proposal_title" class="form-label"><?php esc_html_e( 'Proposal Title', 'common-elements' ); ?> <span class="required">*</span></label>
                <input type="text" id="proposal_title" name="proposal_title" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="proposal_content" class="form-label"><?php esc_html_e( 'Proposal Content', 'common-elements' ); ?> <span class="required">*</span></label>
                <textarea id="proposal_content" name="proposal_content" class="form-control" rows="8" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="proposal_price" class="form-label"><?php esc_html_e( 'Proposed Price', 'common-elements' ); ?></label>
                <input type="text" id="proposal_price" name="proposal_price" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="proposal_timeline" class="form-label"><?php esc_html_e( 'Proposed Timeline', 'common-elements' ); ?></label>
                <input type="text" id="proposal_timeline" name="proposal_timeline" class="form-control">
            </div>
            
            <div class="form-group">
                <button type="submit" name="submit_proposal" class="btn btn-primary"><?php esc_html_e( 'Submit Proposal', 'common-elements' ); ?></button>
            </div>
        </form>
    </div>
    <?php
    
    return ob_get_clean();
}
