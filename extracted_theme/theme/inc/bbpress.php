<?php
/**
 * bbPress compatibility functions for Common Elements theme
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Add theme support for bbPress
 */
function common_elements_add_bbpress_support() {
    add_theme_support( 'bbpress' );
}
add_action( 'after_setup_theme', 'common_elements_add_bbpress_support' );

/**
 * Enqueue bbPress specific styles
 */
function common_elements_enqueue_bbpress_styles() {
    if ( ! class_exists( 'bbPress' ) ) {
        return;
    }
    
    wp_enqueue_style(
        'common-elements-bbpress',
        get_template_directory_uri() . '/css/bbpress.css',
        array(),
        COMMON_ELEMENTS_THEME_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'common_elements_enqueue_bbpress_styles' );

/**
 * Add custom classes to bbPress elements
 */
function common_elements_add_bbpress_classes( $classes ) {
    if ( ! class_exists( 'bbPress' ) ) {
        return $classes;
    }
    
    if ( bbp_is_forum() ) {
        $classes[] = 'bbpress-forum';
    }
    
    if ( bbp_is_topic() ) {
        $classes[] = 'bbpress-topic';
    }
    
    if ( bbp_is_reply() ) {
        $classes[] = 'bbpress-reply';
    }
    
    if ( bbp_is_single_user() ) {
        $classes[] = 'bbpress-user';
    }
    
    return $classes;
}
add_filter( 'body_class', 'common_elements_add_bbpress_classes' );

/**
 * Customize bbPress templates
 */
function common_elements_bbpress_template_hierarchy( $templates, $slug, $name ) {
    // Check if we're using a bbPress template
    if ( ! function_exists( 'is_bbpress' ) || ! is_bbpress() ) {
        return $templates;
    }
    
    // Add our custom template path
    $custom_templates = array();
    
    // If we have a name, we're looking for slug-name.php
    if ( $name ) {
        $custom_templates[] = "templates/bbpress/{$slug}-{$name}.php";
    }
    
    // We're always going to look for slug.php
    $custom_templates[] = "templates/bbpress/{$slug}.php";
    
    // Add our custom templates to the top of the stack
    $templates = array_merge( $custom_templates, $templates );
    
    return $templates;
}
add_filter( 'bbp_get_template_part', 'common_elements_bbpress_template_hierarchy', 10, 3 );

/**
 * Customize bbPress buttons
 */
function common_elements_bbpress_buttons() {
    // Add our custom button classes
    add_filter( 'bbp_get_topic_subscribe_link', 'common_elements_bbpress_button_classes' );
    add_filter( 'bbp_get_topic_favorite_link', 'common_elements_bbpress_button_classes' );
    add_filter( 'bbp_get_user_subscribe_link', 'common_elements_bbpress_button_classes' );
    add_filter( 'bbp_get_user_favorites_link', 'common_elements_bbpress_button_classes' );
}
add_action( 'after_setup_theme', 'common_elements_bbpress_buttons' );

/**
 * Add custom classes to bbPress buttons
 */
function common_elements_bbpress_button_classes( $button ) {
    // Add our custom button classes
    $button = str_replace( 'class="button ', 'class="button btn btn-primary ', $button );
    $button = str_replace( 'class="subscription-toggle', 'class="subscription-toggle btn btn-outline-primary', $button );
    $button = str_replace( 'class="favorite-toggle', 'class="favorite-toggle btn btn-outline-primary', $button );
    
    return $button;
}

/**
 * Customize bbPress form elements
 */
function common_elements_bbpress_form_elements() {
    // Add our custom form element classes
    add_filter( 'bbp_get_form_forum_type_dropdown', 'common_elements_bbpress_form_element_classes' );
    add_filter( 'bbp_get_form_forum_status_dropdown', 'common_elements_bbpress_form_element_classes' );
    add_filter( 'bbp_get_form_forum_visibility_dropdown', 'common_elements_bbpress_form_element_classes' );
}
add_action( 'after_setup_theme', 'common_elements_bbpress_form_elements' );

/**
 * Add custom classes to bbPress form elements
 */
function common_elements_bbpress_form_element_classes( $element ) {
    // Add form-control class to text inputs and textareas
    $element = str_replace( '<input type="text"', '<input type="text" class="form-control"', $element );
    $element = str_replace( '<textarea', '<textarea class="form-control"', $element );
    
    // Add form-select class to select elements
    $element = str_replace( '<select', '<select class="form-select"', $element );
    
    return $element;
}

/**
 * Customize bbPress pagination
 */
function common_elements_bbpress_pagination( $html ) {
    // Add our custom pagination classes
    $html = str_replace( 'class="bbp-pagination-links', 'class="bbp-pagination-links pagination justify-content-center', $html );
    $html = str_replace( '<a class="page-numbers', '<a class="page-numbers page-link', $html );
    $html = str_replace( '<span class="page-numbers current', '<span class="page-numbers current page-link active', $html );
    
    return $html;
}
add_filter( 'bbp_get_forum_pagination_links', 'common_elements_bbpress_pagination' );
add_filter( 'bbp_get_topic_pagination_links', 'common_elements_bbpress_pagination' );
add_filter( 'bbp_get_search_pagination_links', 'common_elements_bbpress_pagination' );

/**
 * Add custom widgets for bbPress
 */
function common_elements_register_bbpress_widgets() {
    // Only register if bbPress is active
    if ( ! class_exists( 'bbPress' ) ) {
        return;
    }
    
    // Register sidebar for bbPress pages
    register_sidebar(
        array(
            'name'          => esc_html__( 'bbPress Sidebar', 'common-elements' ),
            'id'            => 'bbpress-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in bbPress pages.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'common_elements_register_bbpress_widgets' );

/**
 * Customize bbPress breadcrumbs
 */
function common_elements_bbpress_breadcrumbs( $crumbs ) {
    // Add our custom breadcrumb classes
    $crumbs = str_replace( '<span class="bbp-breadcrumb', '<span class="bbp-breadcrumb breadcrumbs', $crumbs );
    
    return $crumbs;
}
add_filter( 'bbp_get_breadcrumb', 'common_elements_bbpress_breadcrumbs' );

/**
 * Customize bbPress search form
 */
function common_elements_bbpress_search_form( $form ) {
    // Add our custom search form classes
    $form = str_replace( '<input type="text" value="', '<input type="text" class="form-control" value="', $form );
    $form = str_replace( '<input type="submit" class="button"', '<input type="submit" class="button btn btn-primary"', $form );
    
    return $form;
}
add_filter( 'bbp_get_search_form', 'common_elements_bbpress_search_form' );

/**
 * Customize bbPress notices
 */
function common_elements_bbpress_notices( $notice ) {
    // Add our custom notice classes
    $notice = str_replace( 'class="bbp-template-notice info"', 'class="bbp-template-notice info alert alert-info"', $notice );
    $notice = str_replace( 'class="bbp-template-notice error"', 'class="bbp-template-notice error alert alert-danger"', $notice );
    $notice = str_replace( 'class="bbp-template-notice warning"', 'class="bbp-template-notice warning alert alert-warning"', $notice );
    $notice = str_replace( 'class="bbp-template-notice success"', 'class="bbp-template-notice success alert alert-success"', $notice );
    
    return $notice;
}
add_filter( 'bbp_get_template_part_notice', 'common_elements_bbpress_notices' );

/**
 * Add custom shortcodes for bbPress
 */
function common_elements_register_bbpress_shortcodes() {
    // Only register if bbPress is active
    if ( ! class_exists( 'bbPress' ) ) {
        return;
    }
    
    // Register shortcodes
    add_shortcode( 'ce_forums', 'common_elements_forums_shortcode' );
    add_shortcode( 'ce_topics', 'common_elements_topics_shortcode' );
    add_shortcode( 'ce_recent_replies', 'common_elements_recent_replies_shortcode' );
}
add_action( 'init', 'common_elements_register_bbpress_shortcodes' );

/**
 * Forums shortcode callback
 */
function common_elements_forums_shortcode( $atts ) {
    // Only process if bbPress is active
    if ( ! class_exists( 'bbPress' ) ) {
        return '';
    }
    
    $atts = shortcode_atts( array(
        'parent'  => 0,
        'number'  => 10,
        'columns' => 1,
    ), $atts, 'ce_forums' );
    
    // Determine column class based on columns attribute
    $column_class = 'col-md-12'; // Default for 1 column
    
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
    }
    
    // Get forums
    $args = array(
        'post_type'      => bbp_get_forum_post_type(),
        'posts_per_page' => intval( $atts['number'] ),
        'post_parent'    => intval( $atts['parent'] ),
        'post_status'    => 'publish',
    );
    
    $forums = get_posts( $args );
    
    if ( ! empty( $forums ) ) {
        ob_start();
        ?>
        <div class="ce-forums">
            <div class="row">
                <?php foreach ( $forums as $forum ) : ?>
                    <?php
                    $forum_id = $forum->ID;
                    $topic_count = bbp_get_forum_topic_count( $forum_id );
                    $reply_count = bbp_get_forum_reply_count( $forum_id );
                    $last_active = bbp_get_forum_last_active_time( $forum_id );
                    ?>
                    <div class="<?php echo esc_attr( $column_class ); ?> mb-4">
                        <div class="forum-card">
                            <div class="forum-card-body">
                                <h3 class="forum-title">
                                    <a href="<?php echo esc_url( bbp_get_forum_permalink( $forum_id ) ); ?>">
                                        <?php echo esc_html( bbp_get_forum_title( $forum_id ) ); ?>
                                    </a>
                                </h3>
                                <div class="forum-description">
                                    <?php echo wp_kses_post( bbp_get_forum_content( $forum_id ) ); ?>
                                </div>
                                <div class="forum-meta">
                                    <div class="forum-topic-count">
                                        <i class="fas fa-comments"></i> <?php echo esc_html( $topic_count ); ?> <?php echo esc_html( _n( 'Topic', 'Topics', $topic_count, 'common-elements' ) ); ?>
                                    </div>
                                    <div class="forum-reply-count">
                                        <i class="fas fa-reply"></i> <?php echo esc_html( $reply_count ); ?> <?php echo esc_html( _n( 'Reply', 'Replies', $reply_count, 'common-elements' ) ); ?>
                                    </div>
                                    <?php if ( ! empty( $last_active ) ) : ?>
                                        <div class="forum-last-active">
                                            <i class="fas fa-clock"></i> <?php echo esc_html( $last_active ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="forum-card-footer">
                                <a href="<?php echo esc_url( bbp_get_forum_permalink( $forum_id ) ); ?>" class="btn btn-primary btn-sm">
                                    <?php esc_html_e( 'View Forum', 'common-elements' ); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    return '';
}

/**
 * Topics shortcode callback
 */
function common_elements_topics_shortcode( $atts ) {
    // Only process if bbPress is active
    if ( ! class_exists( 'bbPress' ) ) {
        return '';
    }
    
    $atts = shortcode_atts( array(
        'forum'   => 0,
        'number'  => 10,
        'orderby' => 'date',
        'order'   => 'DESC',
    ), $atts, 'ce_topics' );
    
    // Get topics
    $args = array(
        'post_type'      => bbp_get_topic_post_type(),
        'posts_per_page' => intval( $atts['number'] ),
        'orderby'        => $atts['orderby'],
        'order'          => $atts['order'],
        'post_status'    => 'publish',
    );
    
    // If forum is specified, get topics from that forum
    if ( intval( $atts['forum'] ) > 0 ) {
        $args['meta_query'] = array(
            array(
                'key'   => '_bbp_forum_id',
                'value' => intval( $atts['forum'] ),
            ),
        );
    }
    
    $topics = get_posts( $args );
    
    if ( ! empty( $topics ) ) {
        ob_start();
        ?>
        <div class="ce-topics">
            <ul class="topic-list">
                <?php foreach ( $topics as $topic ) : ?>
                    <?php
                    $topic_id = $topic->ID;
                    $reply_count = bbp_get_topic_reply_count( $topic_id );
                    $last_active = bbp_get_topic_last_active_time( $topic_id );
                    $author_id = bbp_get_topic_author_id( $topic_id );
                    $author_name = bbp_get_topic_author_display_name( $topic_id );
                    ?>
                    <li class="topic-item">
                        <div class="topic-title">
                            <a href="<?php echo esc_url( bbp_get_topic_permalink( $topic_id ) ); ?>">
                                <?php echo esc_html( bbp_get_topic_title( $topic_id ) ); ?>
                            </a>
                        </div>
                        <div class="topic-meta">
                            <div class="topic-author">
                                <?php
                                /* translators: %s: author name */
                                printf( esc_html__( 'Started by %s', 'common-elements' ), '<a href="' . esc_url( bbp_get_user_profile_url( $author_id ) ) . '">' . esc_html( $author_name ) . '</a>' );
                                ?>
                            </div>
                            <div class="topic-reply-count">
                                <i class="fas fa-reply"></i> <?php echo esc_html( $reply_count ); ?> <?php echo esc_html( _n( 'Reply', 'Replies', $reply_count, 'common-elements' ) ); ?>
                            </div>
                            <?php if ( ! empty( $last_active ) ) : ?>
                                <div class="topic-last-active">
                                    <i class="fas fa-clock"></i> <?php echo esc_html( $last_active ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }
    
    return '';
}

/**
 * Recent replies shortcode callback
 */
function common_elements_recent_replies_shortcode( $atts ) {
    // Only process if bbPress is active
    if ( ! class_exists( 'bbPress' ) ) {
        return '';
    }
    
    $atts = shortcode_atts( array(
        'number' => 5,
    ), $atts, 'ce_recent_replies' );
    
    // Get recent replies
    $args = array(
        'post_type'      => bbp_get_reply_post_type(),
        'posts_per_page' => intval( $atts['number'] ),
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    );
    
    $replies = get_posts( $args );
    
    if ( ! empty( $replies ) ) {
        ob_start();
        ?>
        <div class="ce-recent-replies">
            <ul class="reply-list">
                <?php foreach ( $replies as $reply ) : ?>
                    <?php
                    $reply_id = $reply->ID;
                    $topic_id = bbp_get_reply_topic_id( $reply_id );
                    $author_id = bbp_get_reply_author_id( $reply_id );
                    $author_name = bbp_get_reply_author_display_name( $reply_id );
                    $reply_date = bbp_get_reply_post_date( $reply_id );
                    ?>
                    <li class="reply-item">
                        <div class="reply-author-avatar">
                            <?php echo get_avatar( $author_id, 40 ); ?>
                        </div>
                        <div class="reply-content">
                            <div class="reply-topic">
                                <a href="<?php echo esc_url( bbp_get_topic_permalink( $topic_id ) ); ?>">
                                    <?php echo esc_html( bbp_get_topic_title( $topic_id ) ); ?>
                                </a>
                            </div>
                            <div class="reply-excerpt">
                                <?php echo wp_kses_post( wp_trim_words( bbp_get_reply_content( $reply_id ), 20 ) ); ?>
                            </div>
                            <div class="reply-meta">
                                <div class="reply-author">
                                    <?php
                                    /* translators: %s: author name */
                                    printf( esc_html__( 'By %s', 'common-elements' ), '<a href="' . esc_url( bbp_get_user_profile_url( $author_id ) ) . '">' . esc_html( $author_name ) . '</a>' );
                                    ?>
                                </div>
                                <div class="reply-date">
                                    <i class="fas fa-clock"></i> <?php echo esc_html( $reply_date ); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }
    
    return '';
}
