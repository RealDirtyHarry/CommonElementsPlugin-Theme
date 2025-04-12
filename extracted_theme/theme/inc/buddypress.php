<?php
/**
 * BuddyPress compatibility functions for Common Elements theme
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Add theme support for BuddyPress
 */
function common_elements_add_buddypress_support() {
    add_theme_support( 'buddypress-use-legacy' );
}
add_action( 'after_setup_theme', 'common_elements_add_buddypress_support' );

/**
 * Enqueue BuddyPress specific styles
 */
function common_elements_enqueue_buddypress_styles() {
    if ( ! class_exists( 'BuddyPress' ) ) {
        return;
    }
    
    wp_enqueue_style(
        'common-elements-buddypress',
        get_template_directory_uri() . '/css/buddypress.css',
        array(),
        COMMON_ELEMENTS_THEME_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'common_elements_enqueue_buddypress_styles' );

/**
 * Add custom classes to BuddyPress elements
 */
function common_elements_add_buddypress_classes( $classes ) {
    if ( ! class_exists( 'BuddyPress' ) ) {
        return $classes;
    }
    
    if ( bp_is_user() ) {
        $classes[] = 'buddypress-user';
    }
    
    if ( bp_is_group() ) {
        $classes[] = 'buddypress-group';
    }
    
    if ( bp_is_directory() ) {
        $classes[] = 'buddypress-directory';
    }
    
    return $classes;
}
add_filter( 'body_class', 'common_elements_add_buddypress_classes' );

/**
 * Customize BuddyPress templates
 */
function common_elements_buddypress_template_hierarchy( $templates, $slug, $name ) {
    // Check if we're using a BuddyPress template
    if ( ! bp_is_active() ) {
        return $templates;
    }
    
    // Add our custom template path
    $custom_templates = array();
    
    // If we have a name, we're looking for slug-name.php
    if ( $name ) {
        $custom_templates[] = "templates/buddypress/{$slug}-{$name}.php";
    }
    
    // We're always going to look for slug.php
    $custom_templates[] = "templates/buddypress/{$slug}.php";
    
    // Add our custom templates to the top of the stack
    $templates = array_merge( $custom_templates, $templates );
    
    return $templates;
}
add_filter( 'bp_get_template_part', 'common_elements_buddypress_template_hierarchy', 10, 3 );

/**
 * Customize BuddyPress buttons
 */
function common_elements_buddypress_buttons() {
    // Add our custom button classes
    add_filter( 'bp_get_add_friend_button', 'common_elements_buddypress_button_classes' );
    add_filter( 'bp_get_send_message_button_args', 'common_elements_buddypress_button_classes' );
    add_filter( 'bp_get_send_public_message_button', 'common_elements_buddypress_button_classes' );
    add_filter( 'bp_get_follow_button', 'common_elements_buddypress_button_classes' );
    add_filter( 'bp_get_group_join_button', 'common_elements_buddypress_button_classes' );
    add_filter( 'bp_get_group_create_button', 'common_elements_buddypress_button_classes' );
}
add_action( 'after_setup_theme', 'common_elements_buddypress_buttons' );

/**
 * Add custom classes to BuddyPress buttons
 */
function common_elements_buddypress_button_classes( $button ) {
    if ( is_array( $button ) ) {
        if ( isset( $button['link_class'] ) ) {
            // Add our custom button classes
            $button['link_class'] .= ' btn';
            
            // Add primary class for action buttons
            if ( strpos( $button['id'], 'accept' ) !== false || 
                 strpos( $button['id'], 'join' ) !== false || 
                 strpos( $button['id'], 'add' ) !== false ) {
                $button['link_class'] .= ' btn-primary';
            } 
            // Add secondary class for non-action buttons
            else {
                $button['link_class'] .= ' btn-secondary';
            }
            
            // Add small class for compact buttons
            if ( isset( $button['wrapper_class'] ) && strpos( $button['wrapper_class'], 'compact' ) !== false ) {
                $button['link_class'] .= ' btn-sm';
            }
        }
    } else {
        // For string-based buttons, add our classes
        $button = str_replace( 'class="', 'class="btn btn-primary ', $button );
    }
    
    return $button;
}

/**
 * Customize BuddyPress navigation
 */
function common_elements_buddypress_navigation() {
    // Add our custom navigation classes
    add_filter( 'bp_get_options_nav', 'common_elements_buddypress_nav_classes' );
    add_filter( 'bp_get_nav_menu', 'common_elements_buddypress_nav_classes' );
}
add_action( 'after_setup_theme', 'common_elements_buddypress_navigation' );

/**
 * Add custom classes to BuddyPress navigation
 */
function common_elements_buddypress_nav_classes( $nav ) {
    // Add our custom navigation classes
    $nav = str_replace( '<ul class="', '<ul class="nav nav-tabs ', $nav );
    $nav = str_replace( 'class="current selected"', 'class="current selected active"', $nav );
    
    return $nav;
}

/**
 * Customize BuddyPress form elements
 */
function common_elements_buddypress_form_elements() {
    // Add our custom form element classes
    add_filter( 'bp_get_the_profile_field_input_name', 'common_elements_buddypress_form_element_classes' );
    add_filter( 'bp_get_the_profile_field_textarea', 'common_elements_buddypress_form_element_classes' );
    add_filter( 'bp_get_the_profile_field_selectbox', 'common_elements_buddypress_form_element_classes' );
    add_filter( 'bp_get_the_profile_field_multiselectbox', 'common_elements_buddypress_form_element_classes' );
    add_filter( 'bp_get_the_profile_field_checkbox', 'common_elements_buddypress_form_element_classes' );
    add_filter( 'bp_get_the_profile_field_radio', 'common_elements_buddypress_form_element_classes' );
    add_filter( 'bp_get_the_profile_field_datebox', 'common_elements_buddypress_form_element_classes' );
}
add_action( 'after_setup_theme', 'common_elements_buddypress_form_elements' );

/**
 * Add custom classes to BuddyPress form elements
 */
function common_elements_buddypress_form_element_classes( $field ) {
    // Add form-control class to text inputs and textareas
    if ( strpos( $field, '<input' ) !== false || strpos( $field, '<textarea' ) !== false ) {
        $field = str_replace( 'class="', 'class="form-control ', $field );
    }
    
    // Add form-select class to select elements
    if ( strpos( $field, '<select' ) !== false ) {
        $field = str_replace( 'class="', 'class="form-select ', $field );
    }
    
    // Add form-check-input class to checkboxes and radio buttons
    if ( strpos( $field, 'type="checkbox"' ) !== false || strpos( $field, 'type="radio"' ) !== false ) {
        $field = str_replace( 'class="', 'class="form-check-input ', $field );
    }
    
    return $field;
}

/**
 * Customize BuddyPress pagination
 */
function common_elements_buddypress_pagination( $pagination ) {
    // Add our custom pagination classes
    $pagination = str_replace( 'class="pagination"', 'class="pagination justify-content-center"', $pagination );
    $pagination = str_replace( '<li', '<li class="page-item"', $pagination );
    $pagination = str_replace( 'class="current"', 'class="current page-link active"', $pagination );
    $pagination = str_replace( '<a', '<a class="page-link"', $pagination );
    
    return $pagination;
}
add_filter( 'bp_get_pagination_links', 'common_elements_buddypress_pagination' );

/**
 * Customize BuddyPress notifications
 */
function common_elements_buddypress_notifications() {
    // Add our custom notification classes
    add_filter( 'bp_get_the_notification_description', 'common_elements_buddypress_notification_classes' );
}
add_action( 'after_setup_theme', 'common_elements_buddypress_notifications' );

/**
 * Add custom classes to BuddyPress notifications
 */
function common_elements_buddypress_notification_classes( $notification ) {
    // Add our custom notification classes
    $notification = '<div class="notification-item">' . $notification . '</div>';
    
    return $notification;
}

/**
 * Add custom widgets for BuddyPress
 */
function common_elements_register_buddypress_widgets() {
    // Only register if BuddyPress is active
    if ( ! class_exists( 'BuddyPress' ) ) {
        return;
    }
    
    // Register sidebar for BuddyPress pages
    register_sidebar(
        array(
            'name'          => esc_html__( 'BuddyPress Sidebar', 'common-elements' ),
            'id'            => 'buddypress-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in BuddyPress pages.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'common_elements_register_buddypress_widgets' );

/**
 * Customize BuddyPress avatar
 */
function common_elements_buddypress_avatar( $avatar ) {
    // Add our custom avatar classes
    $avatar = str_replace( 'class="avatar', 'class="avatar rounded-circle', $avatar );
    
    return $avatar;
}
add_filter( 'bp_get_activity_avatar', 'common_elements_buddypress_avatar' );
add_filter( 'bp_get_member_avatar', 'common_elements_buddypress_avatar' );
add_filter( 'bp_get_group_avatar', 'common_elements_buddypress_avatar' );

/**
 * Customize BuddyPress activity stream
 */
function common_elements_buddypress_activity() {
    // Add our custom activity classes
    add_filter( 'bp_get_activity_action', 'common_elements_buddypress_activity_classes' );
    add_filter( 'bp_get_activity_content', 'common_elements_buddypress_activity_classes' );
}
add_action( 'after_setup_theme', 'common_elements_buddypress_activity' );

/**
 * Add custom classes to BuddyPress activity
 */
function common_elements_buddypress_activity_classes( $activity ) {
    // Add our custom activity classes
    if ( strpos( $activity, 'activity-action' ) !== false ) {
        $activity = str_replace( 'class="activity-action"', 'class="activity-action card-title"', $activity );
    }
    
    if ( strpos( $activity, 'activity-inner' ) !== false ) {
        $activity = str_replace( 'class="activity-inner"', 'class="activity-inner card-text"', $activity );
    }
    
    return $activity;
}

/**
 * Add custom shortcodes for BuddyPress
 */
function common_elements_register_buddypress_shortcodes() {
    // Only register if BuddyPress is active
    if ( ! class_exists( 'BuddyPress' ) ) {
        return;
    }
    
    // Register shortcodes
    add_shortcode( 'ce_members', 'common_elements_members_shortcode' );
    add_shortcode( 'ce_groups', 'common_elements_groups_shortcode' );
    add_shortcode( 'ce_activity', 'common_elements_activity_shortcode' );
}
add_action( 'init', 'common_elements_register_buddypress_shortcodes' );

/**
 * Members shortcode callback
 */
function common_elements_members_shortcode( $atts ) {
    // Only process if BuddyPress is active
    if ( ! class_exists( 'BuddyPress' ) ) {
        return '';
    }
    
    $atts = shortcode_atts( array(
        'type'    => 'active',
        'number'  => 12,
        'columns' => 3,
    ), $atts, 'ce_members' );
    
    // Determine column class based on columns attribute
    $column_class = 'col-md-4'; // Default for 3 columns
    
    switch ( intval( $atts['columns'] ) ) {
        case 1:
            $column_class = 'col-md-12';
            break;
        case 2:
            $column_class = 'col-md-6';
            break;
        case 3:
            $column_class = 'col-md-4';
            break;
        case 4:
            $column_class = 'col-md-3';
            break;
        case 6:
            $column_class = 'col-md-2';
            break;
    }
    
    // Get members based on type
    $args = array(
        'type'    => $atts['type'],
        'per_page' => intval( $atts['number'] ),
    );
    
    if ( bp_has_members( $args ) ) {
        ob_start();
        ?>
        <div class="ce-members">
            <div class="row">
                <?php while ( bp_members() ) : bp_the_member(); ?>
                    <div class="<?php echo esc_attr( $column_class ); ?> mb-4">
                        <div class="member-card">
                            <div class="member-card-header">
                                <a href="<?php bp_member_permalink(); ?>">
                                    <?php bp_member_avatar( 'type=full&width=100&height=100' ); ?>
                                </a>
                            </div>
                            <div class="member-card-body">
                                <h3 class="member-name">
                                    <a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
                                </h3>
                                <div class="member-last-active">
                                    <?php bp_member_last_active(); ?>
                                </div>
                                <?php if ( bp_get_member_latest_update() ) : ?>
                                    <div class="member-update">
                                        <?php bp_member_latest_update(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="member-card-footer">
                                <?php if ( bp_is_active( 'friends' ) ) : ?>
                                    <div class="member-friend-count">
                                        <i class="fas fa-user-friends"></i> <?php bp_member_total_friend_count(); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php bp_member_permalink(); ?>" class="btn btn-primary btn-sm">
                                    <?php esc_html_e( 'View Profile', 'common-elements' ); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    return '';
}

/**
 * Groups shortcode callback
 */
function common_elements_groups_shortcode( $atts ) {
    // Only process if BuddyPress is active
    if ( ! class_exists( 'BuddyPress' ) || ! bp_is_active( 'groups' ) ) {
        return '';
    }
    
    $atts = shortcode_atts( array(
        'type'    => 'active',
        'number'  => 12,
        'columns' => 3,
    ), $atts, 'ce_groups' );
    
    // Determine column class based on columns attribute
    $column_class = 'col-md-4'; // Default for 3 columns
    
    switch ( intval( $atts['columns'] ) ) {
        case 1:
            $column_class = 'col-md-12';
            break;
        case 2:
            $column_class = 'col-md-6';
            break;
        case 3:
            $column_class = 'col-md-4';
            break;
        case 4:
            $column_class = 'col-md-3';
            break;
        case 6:
            $column_class = 'col-md-2';
            break;
    }
    
    // Get groups based on type
    $args = array(
        'type'     => $atts['type'],
        'per_page' => intval( $atts['number'] ),
    );
    
    if ( bp_has_groups( $args ) ) {
        ob_start();
        ?>
        <div class="ce-groups">
            <div class="row">
                <?php while ( bp_groups() ) : bp_the_group(); ?>
                    <div class="<?php echo esc_attr( $column_class ); ?> mb-4">
                        <div class="group-card">
                            <div class="group-card-header">
                                <a href="<?php bp_group_permalink(); ?>">
                                    <?php bp_group_avatar( 'type=full&width=100&height=100' ); ?>
                                </a>
                            </div>
                            <div class="group-card-body">
                                <h3 class="group-name">
                                    <a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a>
                                </h3>
                                <div class="group-type">
                                    <?php bp_group_type(); ?>
                                </div>
                                <div class="group-description">
                                    <?php bp_group_description_excerpt(); ?>
                                </div>
                            </div>
                            <div class="group-card-footer">
                                <div class="group-member-count">
                                    <i class="fas fa-users"></i> <?php bp_group_member_count(); ?>
                                </div>
                                
                                <a href="<?php bp_group_permalink(); ?>" class="btn btn-primary btn-sm">
                                    <?php esc_html_e( 'View Group', 'common-elements' ); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    return '';
}

/**
 * Activity shortcode callback
 */
function common_elements_activity_shortcode( $atts ) {
    // Only process if BuddyPress is active
    if ( ! class_exists( 'BuddyPress' ) || ! bp_is_active( 'activity' ) ) {
        return '';
    }
    
    $atts = shortcode_atts( array(
        'type'   => 'activity_update',
        'number' => 10,
    ), $atts, 'ce_activity' );
    
    // Get activity based on type
    $args = array(
        'action'   => $atts['type'],
        'per_page' => intval( $atts['number'] ),
    );
    
    if ( bp_has_activities( $args ) ) {
        ob_start();
        ?>
        <div class="ce-activity">
            <ul class="activity-list">
                <?php while ( bp_activities() ) : bp_the_activity(); ?>
                    <li class="activity-item">
                        <div class="activity-avatar">
                            <a href="<?php bp_activity_user_link(); ?>">
                                <?php bp_activity_avatar( 'type=thumb&width=50&height=50' ); ?>
                            </a>
                        </div>
                        <div class="activity-content">
                            <div class="activity-header">
                                <?php bp_activity_action(); ?>
                            </div>
                            <div class="activity-inner">
                                <?php bp_activity_content_body(); ?>
                            </div>
                            <div class="activity-meta">
                                <?php if ( bp_activity_can_comment() ) : ?>
                                    <a href="<?php bp_activity_comment_link(); ?>" class="button acomment-reply bp-primary-action">
                                        <?php
                                        /* translators: %s: comment count */
                                        printf( esc_html__( 'Comment %s', 'common-elements' ), '<span>' . esc_html( bp_activity_get_comment_count() ) . '</span>' );
                                        ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( bp_activity_can_favorite() ) : ?>
                                    <?php if ( ! bp_get_activity_is_favorite() ) : ?>
                                        <a href="<?php bp_activity_favorite_link(); ?>" class="button fav bp-secondary-action">
                                            <?php esc_html_e( 'Favorite', 'common-elements' ); ?>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php bp_activity_unfavorite_link(); ?>" class="button unfav bp-secondary-action">
                                            <?php esc_html_e( 'Remove Favorite', 'common-elements' ); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php if ( bp_activity_user_can_delete() ) : ?>
                                    <a href="<?php bp_activity_delete_link(); ?>" class="button delete-activity confirm bp-secondary-action">
                                        <?php esc_html_e( 'Delete', 'common-elements' ); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php do_action( 'bp_activity_entry_meta' ); ?>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }
    
    return '';
}
