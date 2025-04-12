<?php
/**
 * Certificate Template
 *
 * This template displays a certificate of completion for a course in the Learning Hub.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Get the current certificate
global $post;

// Get course ID from URL parameter
$course_id = isset( $_GET['course_id'] ) ? intval( $_GET['course_id'] ) : 0;

// Check if user is logged in and has completed the course
$is_completed = false;
$completion_date = '';
$user_name = '';
$course_title = '';

if ( is_user_logged_in() && $course_id > 0 ) {
    $current_user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $user_name = $current_user->display_name;
    $course_title = get_the_title( $course_id );
    $is_completed = mpcs_user_has_completed_course( $current_user_id, $course_id );
    $completion_date = mpcs_get_course_completion_date( $current_user_id, $course_id );
}

// Get certificate meta data
$certificate_background = get_post_meta( $course_id, 'certificate_background', true );
$certificate_logo = get_post_meta( $course_id, 'certificate_logo', true );
$certificate_signature = get_post_meta( $course_id, 'certificate_signature', true );
$certificate_instructor = get_post_meta( $course_id, 'course_instructor', true );
$certificate_title = get_post_meta( $course_id, 'certificate_title', true );
$certificate_text = get_post_meta( $course_id, 'certificate_text', true );

// Set default values if empty
if ( empty( $certificate_background ) ) {
    $certificate_background = get_template_directory_uri() . '/assets/images/certificate-background.jpg';
}
if ( empty( $certificate_logo ) ) {
    $certificate_logo = get_template_directory_uri() . '/assets/images/logo.png';
}
if ( empty( $certificate_signature ) ) {
    $certificate_signature = get_template_directory_uri() . '/assets/images/signature.png';
}
if ( empty( $certificate_title ) ) {
    $certificate_title = 'Certificate of Completion';
}
if ( empty( $certificate_text ) ) {
    $certificate_text = 'This is to certify that {name} has successfully completed the course {course} on {date}.';
}

// Replace placeholders in certificate text
$certificate_text = str_replace( '{name}', $user_name, $certificate_text );
$certificate_text = str_replace( '{course}', $course_title, $certificate_text );
$certificate_text = str_replace( '{date}', $completion_date, $certificate_text );

// Generate certificate ID
$certificate_id = 'CE-' . $course_id . '-' . $current_user_id . '-' . date( 'Ymd', strtotime( $completion_date ) );
?>

<?php if ( $is_completed ) : ?>
    <div class="ce-certificate-container">
        <div class="ce-certificate-actions">
            <button onclick="window.print();" class="ce-btn ce-btn-primary">
                <i class="fas fa-print"></i> Print Certificate
            </button>
            <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="ce-btn ce-btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to Course
            </a>
        </div>
        
        <div class="ce-certificate" style="background-image: url('<?php echo esc_url( $certificate_background ); ?>');">
            <div class="ce-certificate-header">
                <div class="ce-certificate-logo">
                    <img src="<?php echo esc_url( $certificate_logo ); ?>" alt="Common Elements Logo">
                </div>
                <div class="ce-certificate-title">
                    <h1><?php echo esc_html( $certificate_title ); ?></h1>
                </div>
            </div>
            
            <div class="ce-certificate-body">
                <div class="ce-certificate-text">
                    <p><?php echo wp_kses_post( $certificate_text ); ?></p>
                </div>
            </div>
            
            <div class="ce-certificate-footer">
                <div class="ce-certificate-signature">
                    <img src="<?php echo esc_url( $certificate_signature ); ?>" alt="Signature">
                    <div class="ce-certificate-signature-name">
                        <?php echo esc_html( $certificate_instructor ?: 'Course Instructor' ); ?>
                    </div>
                    <div class="ce-certificate-signature-title">
                        Instructor
                    </div>
                </div>
                
                <div class="ce-certificate-id">
                    <div class="ce-certificate-id-label">Certificate ID:</div>
                    <div class="ce-certificate-id-value"><?php echo esc_html( $certificate_id ); ?></div>
                </div>
                
                <div class="ce-certificate-verification">
                    <div class="ce-certificate-verification-text">
                        Verify this certificate at:
                    </div>
                    <div class="ce-certificate-verification-url">
                        <?php echo esc_url( home_url( '/verify-certificate/?id=' . $certificate_id ) ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .ce-certificate-container, .ce-certificate-container * {
                visibility: visible;
            }
            .ce-certificate-actions {
                display: none;
            }
            .ce-certificate {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                border: none;
            }
        }
    </style>
<?php else : ?>
    <div class="ce-certificate-error">
        <div class="ce-alert ce-alert-warning">
            <h2>Certificate Not Available</h2>
            <p>You have not completed this course yet or the course ID is invalid.</p>
            <p>Please complete all lessons and quizzes to receive your certificate.</p>
        </div>
        
        <div class="ce-certificate-actions">
            <?php if ( $course_id > 0 ) : ?>
                <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="ce-btn ce-btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Course
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/learning-hub' ) ); ?>" class="ce-btn ce-btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Learning Hub
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
