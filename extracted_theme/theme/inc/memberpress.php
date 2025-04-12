<?php
/**
 * MemberPress compatibility functions for Common Elements theme
 *
 * @package Common_Elements
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Add theme support for MemberPress
 */
function common_elements_add_memberpress_support() {
    add_theme_support( 'memberpress' );
}
add_action( 'after_setup_theme', 'common_elements_add_memberpress_support' );

/**
 * Enqueue MemberPress specific styles
 */
function common_elements_enqueue_memberpress_styles() {
    if ( ! class_exists( 'MeprUser' ) ) {
        return;
    }
    
    wp_enqueue_style(
        'common-elements-memberpress',
        get_template_directory_uri() . '/css/memberpress.css',
        array(),
        COMMON_ELEMENTS_THEME_VERSION
    );
}
add_action( 'wp_enqueue_scripts', 'common_elements_enqueue_memberpress_styles' );

/**
 * Add custom classes to MemberPress elements
 */
function common_elements_add_memberpress_classes( $classes ) {
    if ( ! class_exists( 'MeprUser' ) ) {
        return $classes;
    }
    
    if ( function_exists( 'is_account_page' ) && is_account_page() ) {
        $classes[] = 'memberpress-account';
    }
    
    if ( function_exists( 'is_login_page' ) && is_login_page() ) {
        $classes[] = 'memberpress-login';
    }
    
    if ( function_exists( 'is_register_page' ) && is_register_page() ) {
        $classes[] = 'memberpress-register';
    }
    
    if ( function_exists( 'is_checkout_page' ) && is_checkout_page() ) {
        $classes[] = 'memberpress-checkout';
    }
    
    if ( function_exists( 'is_thank_you_page' ) && is_thank_you_page() ) {
        $classes[] = 'memberpress-thank-you';
    }
    
    return $classes;
}
add_filter( 'body_class', 'common_elements_add_memberpress_classes' );

/**
 * Customize MemberPress form elements
 */
function common_elements_memberpress_form_elements() {
    // Add our custom form element classes
    add_filter( 'mepr-login-form', 'common_elements_memberpress_form_classes' );
    add_filter( 'mepr-signup-form', 'common_elements_memberpress_form_classes' );
    add_filter( 'mepr-forgot-password-form', 'common_elements_memberpress_form_classes' );
}
add_action( 'after_setup_theme', 'common_elements_memberpress_form_elements' );

/**
 * Add custom classes to MemberPress forms
 */
function common_elements_memberpress_form_classes( $form ) {
    // Add form-control class to text inputs and textareas
    $form = str_replace( '<input type="text"', '<input type="text" class="form-control"', $form );
    $form = str_replace( '<input type="email"', '<input type="email" class="form-control"', $form );
    $form = str_replace( '<input type="password"', '<input type="password" class="form-control"', $form );
    $form = str_replace( '<textarea', '<textarea class="form-control"', $form );
    
    // Add form-select class to select elements
    $form = str_replace( '<select', '<select class="form-select"', $form );
    
    // Add btn and btn-primary classes to submit buttons
    $form = str_replace( '<input type="submit"', '<input type="submit" class="btn btn-primary"', $form );
    
    return $form;
}

/**
 * Customize MemberPress buttons
 */
function common_elements_memberpress_buttons( $button ) {
    // Add our custom button classes
    $button = str_replace( 'class="mepr-submit"', 'class="mepr-submit btn btn-primary"', $button );
    $button = str_replace( 'class="mepr-cancel"', 'class="mepr-cancel btn btn-outline"', $button );
    
    return $button;
}
add_filter( 'mepr-submit-button', 'common_elements_memberpress_buttons' );
add_filter( 'mepr-cancel-button', 'common_elements_memberpress_buttons' );

/**
 * Customize MemberPress account page
 */
function common_elements_memberpress_account_page( $output ) {
    // Add our custom account page classes
    $output = str_replace( 'class="mp_wrapper', 'class="mp_wrapper mepr-account-wrapper', $output );
    $output = str_replace( '<div class="mepr-account-row"', '<div class="mepr-account-row row"', $output );
    $output = str_replace( '<div class="mepr-account-label"', '<div class="mepr-account-label col-md-4"', $output );
    $output = str_replace( '<div class="mepr-account-value"', '<div class="mepr-account-value col-md-8"', $output );
    
    return $output;
}
add_filter( 'mepr_account_page', 'common_elements_memberpress_account_page' );

/**
 * Customize MemberPress checkout page
 */
function common_elements_memberpress_checkout_page( $output ) {
    // Add our custom checkout page classes
    $output = str_replace( 'class="mp_wrapper', 'class="mp_wrapper mepr-checkout-wrapper', $output );
    $output = str_replace( '<div class="mp_price_str"', '<div class="mp_price_str alert alert-info"', $output );
    
    return $output;
}
add_filter( 'mepr_checkout_page', 'common_elements_memberpress_checkout_page' );

/**
 * Customize MemberPress thank you page
 */
function common_elements_memberpress_thank_you_page( $output ) {
    // Add our custom thank you page classes
    $output = str_replace( 'class="mp_wrapper', 'class="mp_wrapper mepr-thank-you-wrapper', $output );
    $output = str_replace( '<div class="mepr-thank-you-message"', '<div class="mepr-thank-you-message alert alert-success"', $output );
    
    return $output;
}
add_filter( 'mepr_thank_you_page', 'common_elements_memberpress_thank_you_page' );

/**
 * Customize MemberPress login page
 */
function common_elements_memberpress_login_page( $output ) {
    // Add our custom login page classes
    $output = str_replace( 'class="mp_wrapper', 'class="mp_wrapper mepr-login-wrapper', $output );
    
    return $output;
}
add_filter( 'mepr_login_page', 'common_elements_memberpress_login_page' );

/**
 * Add custom widgets for MemberPress
 */
function common_elements_register_memberpress_widgets() {
    // Only register if MemberPress is active
    if ( ! class_exists( 'MeprUser' ) ) {
        return;
    }
    
    // Register sidebar for MemberPress pages
    register_sidebar(
        array(
            'name'          => esc_html__( 'MemberPress Sidebar', 'common-elements' ),
            'id'            => 'memberpress-sidebar',
            'description'   => esc_html__( 'Add widgets here to appear in MemberPress pages.', 'common-elements' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'common_elements_register_memberpress_widgets' );

/**
 * Add custom shortcodes for MemberPress
 */
function common_elements_register_memberpress_shortcodes() {
    // Only register if MemberPress is active
    if ( ! class_exists( 'MeprUser' ) ) {
        return;
    }
    
    // Register shortcodes
    add_shortcode( 'ce_membership_plans', 'common_elements_membership_plans_shortcode' );
    add_shortcode( 'ce_user_courses', 'common_elements_user_courses_shortcode' );
    add_shortcode( 'ce_course_progress', 'common_elements_course_progress_shortcode' );
}
add_action( 'init', 'common_elements_register_memberpress_shortcodes' );

/**
 * Membership plans shortcode callback
 */
function common_elements_membership_plans_shortcode( $atts ) {
    // Only process if MemberPress is active
    if ( ! class_exists( 'MeprProduct' ) ) {
        return '';
    }
    
    $atts = shortcode_atts( array(
        'ids'     => '',
        'columns' => 3,
        'style'   => 'card', // card or table
    ), $atts, 'ce_membership_plans' );
    
    // Get membership plans
    $args = array(
        'post_type'      => 'memberpressproduct',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    );
    
    // If specific IDs are provided
    if ( ! empty( $atts['ids'] ) ) {
        $ids = explode( ',', $atts['ids'] );
        $args['post__in'] = array_map( 'intval', $ids );
    }
    
    $plans = get_posts( $args );
    
    if ( empty( $plans ) ) {
        return '';
    }
    
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
    }
    
    ob_start();
    
    // Card style display
    if ( 'card' === $atts['style'] ) {
        ?>
        <div class="ce-membership-plans">
            <div class="row">
                <?php foreach ( $plans as $plan ) : ?>
                    <?php
                    $product = new MeprProduct( $plan->ID );
                    $price = $product->price();
                    $period = $product->period_type_name();
                    $trial = $product->trial();
                    $features = get_post_meta( $plan->ID, '_mepr_product_features', true );
                    ?>
                    <div class="<?php echo esc_attr( $column_class ); ?> mb-4">
                        <div class="membership-card">
                            <div class="membership-card-header">
                                <h3 class="membership-title"><?php echo esc_html( $plan->post_title ); ?></h3>
                                <div class="membership-price">
                                    <span class="price-amount"><?php echo esc_html( $price ); ?></span>
                                    <?php if ( ! empty( $period ) ) : ?>
                                        <span class="price-period"><?php echo esc_html( $period ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="membership-card-body">
                                <div class="membership-description">
                                    <?php echo wp_kses_post( $plan->post_excerpt ); ?>
                                </div>
                                <?php if ( ! empty( $features ) ) : ?>
                                    <ul class="membership-features">
                                        <?php foreach ( explode( "\n", $features ) as $feature ) : ?>
                                            <li class="feature-item">
                                                <i class="fas fa-check"></i> <?php echo esc_html( trim( $feature ) ); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <?php if ( $trial ) : ?>
                                    <div class="membership-trial">
                                        <i class="fas fa-gift"></i> <?php esc_html_e( 'Free Trial Available', 'common-elements' ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="membership-card-footer">
                                <a href="<?php echo esc_url( $product->url() ); ?>" class="btn btn-primary">
                                    <?php esc_html_e( 'Sign Up Now', 'common-elements' ); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    } 
    // Table style display
    else {
        ?>
        <div class="ce-membership-plans-table">
            <table class="membership-table">
                <thead>
                    <tr>
                        <th class="plan-name"><?php esc_html_e( 'Membership Plan', 'common-elements' ); ?></th>
                        <th class="plan-price"><?php esc_html_e( 'Price', 'common-elements' ); ?></th>
                        <th class="plan-features"><?php esc_html_e( 'Features', 'common-elements' ); ?></th>
                        <th class="plan-action"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $plans as $plan ) : ?>
                        <?php
                        $product = new MeprProduct( $plan->ID );
                        $price = $product->price();
                        $period = $product->period_type_name();
                        $features = get_post_meta( $plan->ID, '_mepr_product_features', true );
                        ?>
                        <tr>
                            <td class="plan-name">
                                <h3><?php echo esc_html( $plan->post_title ); ?></h3>
                                <div class="plan-description">
                                    <?php echo wp_kses_post( $plan->post_excerpt ); ?>
                                </div>
                            </td>
                            <td class="plan-price">
                                <div class="price-amount"><?php echo esc_html( $price ); ?></div>
                                <?php if ( ! empty( $period ) ) : ?>
                                    <div class="price-period"><?php echo esc_html( $period ); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="plan-features">
                                <?php if ( ! empty( $features ) ) : ?>
                                    <ul class="features-list">
                                        <?php foreach ( explode( "\n", $features ) as $feature ) : ?>
                                            <li><?php echo esc_html( trim( $feature ) ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </td>
                            <td class="plan-action">
                                <a href="<?php echo esc_url( $product->url() ); ?>" class="btn btn-primary">
                                    <?php esc_html_e( 'Sign Up', 'common-elements' ); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    return ob_get_clean();
}

/**
 * User courses shortcode callback
 */
function common_elements_user_courses_shortcode( $atts ) {
    // Only process if MemberPress Courses is active
    if ( ! class_exists( 'MeprUser' ) || ! class_exists( 'MeprCourse' ) ) {
        return '';
    }
    
    $atts = shortcode_atts( array(
        'number'  => 10,
        'status'  => 'all', // all, in-progress, completed
        'columns' => 3,
    ), $atts, 'ce_user_courses' );
    
    // Get current user
    $current_user = MeprUtils::get_currentuserinfo();
    
    if ( empty( $current_user ) ) {
        return '<p>' . esc_html__( 'Please log in to view your courses.', 'common-elements' ) . '</p>';
    }
    
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
    }
    
    // Get user's courses
    $args = array(
        'post_type'      => 'mpcs-course',
        'posts_per_page' => intval( $atts['number'] ),
        'post_status'    => 'publish',
    );
    
    // Filter by user access
    $mepr_user = new MeprUser( $current_user->ID );
    $accessible_courses = array();
    
    $all_courses = get_posts( array(
        'post_type'      => 'mpcs-course',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ) );
    
    foreach ( $all_courses as $course ) {
        if ( $mepr_user->can_access( $course->ID ) ) {
            $accessible_courses[] = $course->ID;
        }
    }
    
    if ( empty( $accessible_courses ) ) {
        return '<p>' . esc_html__( 'You do not have access to any courses.', 'common-elements' ) . '</p>';
    }
    
    $args['post__in'] = $accessible_courses;
    
    // Filter by course status if specified
    if ( 'in-progress' === $atts['status'] ) {
        $in_progress_courses = array();
        foreach ( $accessible_courses as $course_id ) {
            $course = new MeprCourse( $course_id );
            $progress = $course->get_user_progress( $current_user->ID );
            if ( $progress > 0 && $progress < 100 ) {
                $in_progress_courses[] = $course_id;
            }
        }
        
        if ( empty( $in_progress_courses ) ) {
            return '<p>' . esc_html__( 'You do not have any courses in progress.', 'common-elements' ) . '</p>';
        }
        
        $args['post__in'] = $in_progress_courses;
    } elseif ( 'completed' === $atts['status'] ) {
        $completed_courses = array();
        foreach ( $accessible_courses as $course_id ) {
            $course = new MeprCourse( $course_id );
            $progress = $course->get_user_progress( $current_user->ID );
            if ( $progress >= 100 ) {
                $completed_courses[] = $course_id;
            }
        }
        
        if ( empty( $completed_courses ) ) {
            return '<p>' . esc_html__( 'You have not completed any courses yet.', 'common-elements' ) . '</p>';
        }
        
        $args['post__in'] = $completed_courses;
    }
    
    $courses = get_posts( $args );
    
    if ( empty( $courses ) ) {
        return '';
    }
    
    ob_start();
    ?>
    <div class="ce-user-courses">
        <div class="row">
            <?php foreach ( $courses as $course_post ) : ?>
                <?php
                $course = new MeprCourse( $course_post->ID );
                $progress = $course->get_user_progress( $current_user->ID );
                $lessons = $course->get_lessons();
                $lesson_count = count( $lessons );
                $completed_lessons = $course->get_user_completed_lessons_count( $current_user->ID );
                ?>
                <div class="<?php echo esc_attr( $column_class ); ?> mb-4">
                    <div class="course-card">
                        <?php if ( has_post_thumbnail( $course_post->ID ) ) : ?>
                            <div class="course-card-image">
                                <a href="<?php echo esc_url( get_permalink( $course_post->ID ) ); ?>">
                                    <?php echo get_the_post_thumbnail( $course_post->ID, 'medium', array( 'class' => 'img-fluid' ) ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="course-card-body">
                            <h3 class="course-title">
                                <a href="<?php echo esc_url( get_permalink( $course_post->ID ) ); ?>">
                                    <?php echo esc_html( $course_post->post_title ); ?>
                                </a>
                            </h3>
                            <div class="course-progress">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo esc_attr( $progress ); ?>%;" aria-valuenow="<?php echo esc_attr( $progress ); ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo esc_html( $progress ); ?>%
                                    </div>
                                </div>
                                <div class="progress-text">
                                    <?php
                                    /* translators: %1$d: completed lessons, %2$d: total lessons */
                                    printf( esc_html__( '%1$d of %2$d lessons completed', 'common-elements' ), $completed_lessons, $lesson_count );
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="course-card-footer">
                            <a href="<?php echo esc_url( get_permalink( $course_post->ID ) ); ?>" class="btn btn-primary">
                                <?php
                                if ( $progress >= 100 ) {
                                    esc_html_e( 'Review Course', 'common-elements' );
                                } elseif ( $progress > 0 ) {
                                    esc_html_e( 'Continue Learning', 'common-elements' );
                                } else {
                                    esc_html_e( 'Start Course', 'common-elements' );
                                }
                                ?>
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

/**
 * Course progress shortcode callback
 */
function common_elements_course_progress_shortcode( $atts ) {
    // Only process if MemberPress Courses is active
    if ( ! class_exists( 'MeprUser' ) || ! class_exists( 'MeprCourse' ) ) {
        return '';
    }
    
    $atts = shortcode_atts( array(
        'course_id' => 0,
    ), $atts, 'ce_course_progress' );
    
    // Get current user
    $current_user = MeprUtils::get_currentuserinfo();
    
    if ( empty( $current_user ) ) {
        return '';
    }
    
    // Get course ID
    $course_id = intval( $atts['course_id'] );
    
    // If no course ID is specified, try to get it from the current post
    if ( $course_id === 0 && is_singular( 'mpcs-course' ) ) {
        $course_id = get_the_ID();
    }
    
    if ( $course_id === 0 ) {
        return '';
    }
    
    // Check if user has access to the course
    $mepr_user = new MeprUser( $current_user->ID );
    if ( ! $mepr_user->can_access( $course_id ) ) {
        return '';
    }
    
    // Get course progress
    $course = new MeprCourse( $course_id );
    $progress = $course->get_user_progress( $current_user->ID );
    $lessons = $course->get_lessons();
    $lesson_count = count( $lessons );
    $completed_lessons = $course->get_user_completed_lessons_count( $current_user->ID );
    
    ob_start();
    ?>
    <div class="ce-course-progress">
        <div class="progress-header">
            <h3 class="progress-title"><?php esc_html_e( 'Your Progress', 'common-elements' ); ?></h3>
            <div class="progress-percentage"><?php echo esc_html( $progress ); ?>%</div>
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: <?php echo esc_attr( $progress ); ?>%;" aria-valuenow="<?php echo esc_attr( $progress ); ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="progress-details">
            <?php
            /* translators: %1$d: completed lessons, %2$d: total lessons */
            printf( esc_html__( '%1$d of %2$d lessons completed', 'common-elements' ), $completed_lessons, $lesson_count );
            ?>
        </div>
        <?php if ( $progress >= 100 ) : ?>
            <div class="progress-complete">
                <i class="fas fa-trophy"></i> <?php esc_html_e( 'Course Completed!', 'common-elements' ); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * MemberPress Courses integration
 */
function common_elements_memberpress_courses_integration() {
    // Only process if MemberPress Courses is active
    if ( ! class_exists( 'MeprCourse' ) ) {
        return;
    }
    
    // Add custom course template
    add_filter( 'mpcs_course_template', 'common_elements_custom_course_template' );
    
    // Add custom lesson template
    add_filter( 'mpcs_lesson_template', 'common_elements_custom_lesson_template' );
    
    // Add custom quiz template
    add_filter( 'mpcs_quiz_template', 'common_elements_custom_quiz_template' );
}
add_action( 'after_setup_theme', 'common_elements_memberpress_courses_integration' );

/**
 * Custom course template
 */
function common_elements_custom_course_template( $template ) {
    $custom_template = get_template_directory() . '/templates/memberpress/courses/single-course.php';
    
    if ( file_exists( $custom_template ) ) {
        return $custom_template;
    }
    
    return $template;
}

/**
 * Custom lesson template
 */
function common_elements_custom_lesson_template( $template ) {
    $custom_template = get_template_directory() . '/templates/memberpress/courses/single-lesson.php';
    
    if ( file_exists( $custom_template ) ) {
        return $custom_template;
    }
    
    return $template;
}

/**
 * Custom quiz template
 */
function common_elements_custom_quiz_template( $template ) {
    $custom_template = get_template_directory() . '/templates/memberpress/courses/single-quiz.php';
    
    if ( file_exists( $custom_template ) ) {
        return $custom_template;
    }
    
    return $template;
}

/**
 * Add custom CSS for MemberPress Courses
 */
function common_elements_memberpress_courses_css() {
    // Only process if MemberPress Courses is active
    if ( ! class_exists( 'MeprCourse' ) ) {
        return;
    }
    
    // Add custom CSS for course pages
    if ( is_singular( 'mpcs-course' ) || is_singular( 'mpcs-lesson' ) || is_singular( 'mpcs-quiz' ) ) {
        ?>
        <style type="text/css">
            /* Course navigation */
            .mpcs-course-navigation {
                background-color: var(--background-light);
                border-radius: var(--border-radius-md);
                padding: var(--spacing-md);
                margin-bottom: var(--spacing-lg);
            }
            
            .mpcs-course-navigation .mpcs-breadcrumbs {
                margin-bottom: var(--spacing-md);
            }
            
            .mpcs-course-navigation .mpcs-breadcrumbs a {
                color: var(--primary-color);
                text-decoration: none;
            }
            
            .mpcs-course-navigation .mpcs-breadcrumbs a:hover {
                text-decoration: underline;
            }
            
            /* Course progress */
            .mpcs-progress {
                margin-bottom: var(--spacing-lg);
            }
            
            .mpcs-progress .mpcs-progress-bar {
                height: 10px;
                background-color: var(--background-dark);
                border-radius: var(--border-radius-sm);
                overflow: hidden;
            }
            
            .mpcs-progress .mpcs-progress-bar-fill {
                height: 100%;
                background-color: var(--primary-color);
            }
            
            .mpcs-progress .mpcs-progress-text {
                margin-top: var(--spacing-xs);
                font-size: var(--font-size-sm);
                color: var(--medium-text);
            }
            
            /* Course curriculum */
            .mpcs-curriculum {
                margin-bottom: var(--spacing-lg);
            }
            
            .mpcs-curriculum .mpcs-section {
                margin-bottom: var(--spacing-md);
            }
            
            .mpcs-curriculum .mpcs-section-title {
                background-color: var(--background-light);
                padding: var(--spacing-sm) var(--spacing-md);
                border-radius: var(--border-radius-sm);
                margin-bottom: var(--spacing-sm);
                font-weight: var(--font-weight-semibold);
            }
            
            .mpcs-curriculum .mpcs-lesson {
                padding: var(--spacing-sm) var(--spacing-md);
                border-bottom: 1px solid var(--border-color);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            
            .mpcs-curriculum .mpcs-lesson:last-child {
                border-bottom: none;
            }
            
            .mpcs-curriculum .mpcs-lesson-title {
                flex: 1;
            }
            
            .mpcs-curriculum .mpcs-lesson-title a {
                color: var(--dark-text);
                text-decoration: none;
            }
            
            .mpcs-curriculum .mpcs-lesson-title a:hover {
                color: var(--primary-color);
            }
            
            .mpcs-curriculum .mpcs-lesson-status {
                margin-left: var(--spacing-sm);
            }
            
            .mpcs-curriculum .mpcs-lesson-status.complete {
                color: var(--success-color);
            }
            
            /* Lesson content */
            .mpcs-lesson-content {
                margin-bottom: var(--spacing-lg);
            }
            
            /* Quiz */
            .mpcs-quiz {
                background-color: var(--background-light);
                border-radius: var(--border-radius-md);
                padding: var(--spacing-lg);
                margin-bottom: var(--spacing-lg);
            }
            
            .mpcs-quiz .mpcs-question {
                margin-bottom: var(--spacing-md);
            }
            
            .mpcs-quiz .mpcs-question-prompt {
                font-weight: var(--font-weight-semibold);
                margin-bottom: var(--spacing-sm);
            }
            
            .mpcs-quiz .mpcs-answers {
                margin-left: var(--spacing-md);
            }
            
            .mpcs-quiz .mpcs-answer {
                margin-bottom: var(--spacing-xs);
            }
            
            /* Navigation buttons */
            .mpcs-navigation {
                display: flex;
                justify-content: space-between;
                margin-top: var(--spacing-lg);
            }
            
            .mpcs-navigation .mpcs-prev,
            .mpcs-navigation .mpcs-next {
                padding: var(--spacing-sm) var(--spacing-md);
                background-color: var(--primary-color);
                color: white;
                border-radius: var(--border-radius-sm);
                text-decoration: none;
                transition: background-color var(--transition-fast);
            }
            
            .mpcs-navigation .mpcs-prev:hover,
            .mpcs-navigation .mpcs-next:hover {
                background-color: var(--primary-dark);
            }
            
            .mpcs-navigation .mpcs-prev {
                margin-right: auto;
            }
            
            .mpcs-navigation .mpcs-next {
                margin-left: auto;
            }
        </style>
        <?php
    }
}
add_action( 'wp_head', 'common_elements_memberpress_courses_css' );

/**
 * Customize MemberPress Courses lesson list
 */
function common_elements_memberpress_courses_lesson_list( $html, $course_id ) {
    // Only process if MemberPress Courses is active
    if ( ! class_exists( 'MeprCourse' ) ) {
        return $html;
    }
    
    // Get course
    $course = new MeprCourse( $course_id );
    $sections = $course->sections();
    
    // Get current user
    $current_user = MeprUtils::get_currentuserinfo();
    $user_id = $current_user ? $current_user->ID : 0;
    
    ob_start();
    ?>
    <div class="ce-course-curriculum">
        <?php foreach ( $sections as $section ) : ?>
            <div class="curriculum-section">
                <h3 class="section-title"><?php echo esc_html( $section->title ); ?></h3>
                <div class="section-lessons">
                    <?php foreach ( $section->lessons as $lesson ) : ?>
                        <?php
                        $lesson_id = $lesson->ID;
                        $lesson_type = get_post_meta( $lesson_id, '_mpcs_lesson_type', true );
                        $completed = $course->is_lesson_completed( $lesson_id, $user_id );
                        $accessible = $course->is_lesson_accessible( $lesson_id, $user_id );
                        ?>
                        <div class="lesson-item <?php echo $completed ? 'completed' : ''; ?> <?php echo ! $accessible ? 'locked' : ''; ?>">
                            <div class="lesson-icon">
                                <?php if ( $completed ) : ?>
                                    <i class="fas fa-check-circle"></i>
                                <?php elseif ( ! $accessible ) : ?>
                                    <i class="fas fa-lock"></i>
                                <?php else : ?>
                                    <?php if ( 'video' === $lesson_type ) : ?>
                                        <i class="fas fa-video"></i>
                                    <?php elseif ( 'quiz' === $lesson_type ) : ?>
                                        <i class="fas fa-question-circle"></i>
                                    <?php else : ?>
                                        <i class="fas fa-book"></i>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="lesson-content">
                                <h4 class="lesson-title">
                                    <?php if ( $accessible ) : ?>
                                        <a href="<?php echo esc_url( get_permalink( $lesson_id ) ); ?>">
                                            <?php echo esc_html( get_the_title( $lesson_id ) ); ?>
                                        </a>
                                    <?php else : ?>
                                        <?php echo esc_html( get_the_title( $lesson_id ) ); ?>
                                    <?php endif; ?>
                                </h4>
                                <?php
                                $lesson_excerpt = get_post_meta( $lesson_id, '_mpcs_lesson_excerpt', true );
                                if ( ! empty( $lesson_excerpt ) ) :
                                ?>
                                    <div class="lesson-excerpt">
                                        <?php echo wp_kses_post( $lesson_excerpt ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="lesson-meta">
                                <?php
                                $lesson_length = get_post_meta( $lesson_id, '_mpcs_lesson_length', true );
                                if ( ! empty( $lesson_length ) ) :
                                ?>
                                    <div class="lesson-length">
                                        <i class="fas fa-clock"></i> <?php echo esc_html( $lesson_length ); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ( $completed ) : ?>
                                    <div class="lesson-status completed">
                                        <?php esc_html_e( 'Completed', 'common-elements' ); ?>
                                    </div>
                                <?php elseif ( ! $accessible ) : ?>
                                    <div class="lesson-status locked">
                                        <?php esc_html_e( 'Locked', 'common-elements' ); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_filter( 'mpcs_course_curriculum', 'common_elements_memberpress_courses_lesson_list', 10, 2 );

/**
 * Customize MemberPress Courses navigation
 */
function common_elements_memberpress_courses_navigation( $html, $course_id, $lesson_id ) {
    // Only process if MemberPress Courses is active
    if ( ! class_exists( 'MeprCourse' ) ) {
        return $html;
    }
    
    // Get course
    $course = new MeprCourse( $course_id );
    
    // Get current user
    $current_user = MeprUtils::get_currentuserinfo();
    $user_id = $current_user ? $current_user->ID : 0;
    
    // Get previous and next lessons
    $prev_lesson_id = $course->get_adjacent_lesson_id( $lesson_id, 'previous' );
    $next_lesson_id = $course->get_adjacent_lesson_id( $lesson_id, 'next' );
    
    ob_start();
    ?>
    <div class="ce-lesson-navigation">
        <div class="navigation-buttons">
            <?php if ( $prev_lesson_id && $course->is_lesson_accessible( $prev_lesson_id, $user_id ) ) : ?>
                <a href="<?php echo esc_url( get_permalink( $prev_lesson_id ) ); ?>" class="btn btn-outline prev-lesson">
                    <i class="fas fa-arrow-left"></i> <?php esc_html_e( 'Previous Lesson', 'common-elements' ); ?>
                </a>
            <?php endif; ?>
            
            <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="btn btn-outline course-link">
                <i class="fas fa-th-list"></i> <?php esc_html_e( 'Course Overview', 'common-elements' ); ?>
            </a>
            
            <?php if ( $next_lesson_id && $course->is_lesson_accessible( $next_lesson_id, $user_id ) ) : ?>
                <a href="<?php echo esc_url( get_permalink( $next_lesson_id ) ); ?>" class="btn btn-primary next-lesson">
                    <?php esc_html_e( 'Next Lesson', 'common-elements' ); ?> <i class="fas fa-arrow-right"></i>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="btn btn-primary complete-course">
                    <?php esc_html_e( 'Complete Course', 'common-elements' ); ?> <i class="fas fa-check"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_filter( 'mpcs_lesson_navigation', 'common_elements_memberpress_courses_navigation', 10, 3 );

/**
 * Customize MemberPress Courses certificate
 */
function common_elements_memberpress_courses_certificate( $html, $course_id, $user_id ) {
    // Only process if MemberPress Courses is active
    if ( ! class_exists( 'MeprCourse' ) ) {
        return $html;
    }
    
    // Get course
    $course = new MeprCourse( $course_id );
    $course_title = get_the_title( $course_id );
    
    // Get user
    $user = get_userdata( $user_id );
    $user_name = $user ? $user->display_name : '';
    
    // Get certificate date
    $completion_date = $course->get_user_completion_date( $user_id );
    $formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $completion_date ) );
    
    ob_start();
    ?>
    <div class="ce-course-certificate">
        <div class="certificate-inner">
            <div class="certificate-header">
                <div class="certificate-logo">
                    <?php
                    $logo_id = get_theme_mod( 'custom_logo' );
                    if ( $logo_id ) {
                        echo wp_get_attachment_image( $logo_id, 'medium' );
                    } else {
                        echo esc_html( get_bloginfo( 'name' ) );
                    }
                    ?>
                </div>
                <h1 class="certificate-title"><?php esc_html_e( 'Certificate of Completion', 'common-elements' ); ?></h1>
            </div>
            <div class="certificate-body">
                <p class="certificate-text">
                    <?php esc_html_e( 'This certifies that', 'common-elements' ); ?>
                </p>
                <p class="certificate-name">
                    <?php echo esc_html( $user_name ); ?>
                </p>
                <p class="certificate-text">
                    <?php esc_html_e( 'has successfully completed the course', 'common-elements' ); ?>
                </p>
                <p class="certificate-course">
                    <?php echo esc_html( $course_title ); ?>
                </p>
                <p class="certificate-date">
                    <?php echo esc_html( $formatted_date ); ?>
                </p>
            </div>
            <div class="certificate-footer">
                <div class="certificate-signature">
                    <div class="signature-line"></div>
                    <p class="signature-name"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_filter( 'mpcs_course_certificate', 'common_elements_memberpress_courses_certificate', 10, 3 );
