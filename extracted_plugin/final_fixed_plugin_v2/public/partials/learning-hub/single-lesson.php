<?php
/**
 * Lesson Content Template
 *
 * This template displays the content of a single lesson in the Learning Hub.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Get the current lesson
global $post;

// Get lesson meta data
$lesson_type = get_post_meta( get_the_ID(), 'lesson_type', true );
$lesson_duration = get_post_meta( get_the_ID(), 'lesson_duration', true );
$lesson_section = get_post_meta( get_the_ID(), 'lesson_section', true );
$lesson_video = get_post_meta( get_the_ID(), 'lesson_video', true );
$lesson_attachments = get_post_meta( get_the_ID(), 'lesson_attachments', true );

// Get course ID
$course_id = mpcs_get_lesson_course_id( get_the_ID() );

// Get next and previous lessons
$next_lesson_id = mpcs_get_next_lesson_id( get_the_ID() );
$prev_lesson_id = mpcs_get_previous_lesson_id( get_the_ID() );

// Check if user is enrolled
$is_enrolled = false;
$user_progress = 0;
$is_completed = false;

if ( is_user_logged_in() ) {
    $current_user_id = get_current_user_id();
    $is_enrolled = mpcs_user_is_enrolled_in_course( $current_user_id, $course_id );
    
    if ( $is_enrolled ) {
        $user_progress = mpcs_get_user_course_progress( $current_user_id, $course_id );
        $is_completed = mpcs_is_lesson_completed( $current_user_id, get_the_ID() );
    }
}

// Get course lessons for navigation
$course_lessons = mpcs_get_course_lessons( $course_id );
?>

<div class="ce-learning-hub">
    <div class="ce-lesson-container">
        <div class="ce-lesson-sidebar">
            <div class="ce-lesson-sidebar-header">
                <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="ce-lesson-course-link">
                    <i class="fas fa-arrow-left"></i> Back to Course
                </a>
                <h3 class="ce-lesson-course-title"><?php echo esc_html( get_the_title( $course_id ) ); ?></h3>
            </div>
            
            <div class="ce-lesson-progress">
                <div class="ce-lesson-progress-bar">
                    <div class="ce-lesson-progress-value" style="width: <?php echo esc_attr( $user_progress ); ?>%"></div>
                </div>
                <div class="ce-lesson-progress-text"><?php echo esc_html( $user_progress ); ?>% Complete</div>
            </div>
            
            <div class="ce-lesson-navigation">
                <?php
                $current_section = '';
                $section_count = 0;
                
                foreach ( $course_lessons as $lesson ) :
                    $lesson_id = $lesson->ID;
                    $section = get_post_meta( $lesson_id, 'lesson_section', true );
                    
                    // If this is a new section, output section header
                    if ( $section !== $current_section ) :
                        $section_count++;
                        if ( $current_section !== '' ) {
                            echo '</div>'; // Close previous section
                        }
                        $current_section = $section;
                ?>
                    <div class="ce-lesson-section">
                        <div class="ce-lesson-section-header" data-toggle="collapse" data-target="#section-<?php echo esc_attr( $section_count ); ?>">
                            <h4 class="ce-lesson-section-title"><?php echo esc_html( $section ?: 'Section ' . $section_count ); ?></h4>
                            <div class="ce-lesson-section-toggle">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div class="ce-lesson-section-content collapse show" id="section-<?php echo esc_attr( $section_count ); ?>">
                <?php endif; ?>
                
                <?php
                    $lesson_type_meta = get_post_meta( $lesson_id, 'lesson_type', true );
                    $is_lesson_completed = mpcs_is_lesson_completed( get_current_user_id(), $lesson_id );
                    $lesson_icon = 'fa-file-alt';
                    $lesson_type_label = 'Lesson';
                    
                    if ( $lesson_type_meta === 'video' ) {
                        $lesson_icon = 'fa-play-circle';
                        $lesson_type_label = 'Video';
                    } elseif ( $lesson_type_meta === 'quiz' ) {
                        $lesson_icon = 'fa-question-circle';
                        $lesson_type_label = 'Quiz';
                    } elseif ( $lesson_type_meta === 'assignment' ) {
                        $lesson_icon = 'fa-clipboard';
                        $lesson_type_label = 'Assignment';
                    }
                    
                    $is_current = $lesson_id == get_the_ID();
                ?>
                
                <div class="ce-lesson-nav-item <?php echo $is_current ? 'ce-lesson-nav-item-current' : ''; ?> <?php echo $is_lesson_completed ? 'ce-lesson-nav-item-completed' : ''; ?>">
                    <a href="<?php echo esc_url( get_permalink( $lesson_id ) ); ?>" class="ce-lesson-nav-link">
                        <div class="ce-lesson-nav-icon">
                            <i class="fas <?php echo esc_attr( $lesson_icon ); ?>"></i>
                        </div>
                        <div class="ce-lesson-nav-content">
                            <div class="ce-lesson-nav-title"><?php echo esc_html( $lesson->post_title ); ?></div>
                            <div class="ce-lesson-nav-meta">
                                <span class="ce-lesson-nav-type"><?php echo esc_html( $lesson_type_label ); ?></span>
                            </div>
                        </div>
                        <div class="ce-lesson-nav-status">
                            <?php if ( $is_lesson_completed ) : ?>
                                <i class="fas fa-check-circle"></i>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
                
                <?php endforeach; ?>
                
                <?php if ( $current_section !== '' ) : ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="ce-lesson-main">
            <div class="ce-lesson-header">
                <div class="ce-lesson-breadcrumbs">
                    <a href="<?php echo esc_url( home_url( '/learning-hub' ) ); ?>">Learning Hub</a> &raquo; 
                    <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>"><?php echo esc_html( get_the_title( $course_id ) ); ?></a> &raquo; 
                    <?php the_title(); ?>
                </div>
                <h1 class="ce-lesson-title"><?php the_title(); ?></h1>
                <div class="ce-lesson-meta">
                    <?php if ( ! empty( $lesson_type ) ) : ?>
                        <span class="ce-lesson-type">
                            <i class="fas <?php echo esc_attr( $lesson_icon ); ?>"></i> <?php echo esc_html( ucfirst( $lesson_type ) ); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ( ! empty( $lesson_duration ) ) : ?>
                        <span class="ce-lesson-duration">
                            <i class="fas fa-clock"></i> <?php echo esc_html( $lesson_duration ); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="ce-lesson-content">
                <?php if ( $lesson_type === 'video' && ! empty( $lesson_video ) ) : ?>
                    <div class="ce-lesson-video">
                        <div class="ce-video-container">
                            <?php echo wp_oembed_get( $lesson_video ); ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="ce-lesson-text">
                    <?php the_content(); ?>
                </div>
                
                <?php if ( ! empty( $lesson_attachments ) ) : ?>
                    <div class="ce-lesson-attachments">
                        <h3 class="ce-lesson-attachments-title">Attachments</h3>
                        <div class="ce-attachments-list">
                            <?php
                            $attachment_ids = explode( ',', $lesson_attachments );
                            foreach ( $attachment_ids as $attachment_id ) {
                                $attachment_url = wp_get_attachment_url( $attachment_id );
                                $attachment_title = get_the_title( $attachment_id );
                                $attachment_type = get_post_mime_type( $attachment_id );
                                $attachment_icon = 'fa-file';
                                
                                if ( strpos( $attachment_type, 'pdf' ) !== false ) {
                                    $attachment_icon = 'fa-file-pdf';
                                } elseif ( strpos( $attachment_type, 'word' ) !== false ) {
                                    $attachment_icon = 'fa-file-word';
                                } elseif ( strpos( $attachment_type, 'excel' ) !== false || strpos( $attachment_type, 'spreadsheet' ) !== false ) {
                                    $attachment_icon = 'fa-file-excel';
                                } elseif ( strpos( $attachment_type, 'image' ) !== false ) {
                                    $attachment_icon = 'fa-file-image';
                                }
                                
                                if ( ! empty( $attachment_url ) ) {
                                    echo '<div class="ce-attachment-item">';
                                    echo '<i class="fas ' . esc_attr( $attachment_icon ) . '"></i>';
                                    echo '<a href="' . esc_url( $attachment_url ) . '" target="_blank">' . esc_html( $attachment_title ) . '</a>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ( $is_enrolled ) : ?>
                    <div class="ce-lesson-completion">
                        <?php if ( $is_completed ) : ?>
                            <div class="ce-lesson-completed-message">
                                <i class="fas fa-check-circle"></i> You have completed this lesson
                            </div>
                        <?php else : ?>
                            <form method="post" class="ce-lesson-complete-form">
                                <?php wp_nonce_field( 'mpcs_complete_lesson', 'mpcs_complete_lesson_nonce' ); ?>
                                <input type="hidden" name="lesson_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
                                <input type="hidden" name="course_id" value="<?php echo esc_attr( $course_id ); ?>">
                                <button type="submit" name="mpcs_complete_lesson" class="ce-btn ce-btn-primary">Mark as Complete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="ce-lesson-footer">
                <div class="ce-lesson-navigation-buttons">
                    <?php if ( $prev_lesson_id ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $prev_lesson_id ) ); ?>" class="ce-btn ce-btn-outline-primary ce-btn-prev">
                            <i class="fas fa-arrow-left"></i> Previous Lesson
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( $next_lesson_id ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $next_lesson_id ) ); ?>" class="ce-btn ce-btn-primary ce-btn-next">
                            Next Lesson <i class="fas fa-arrow-right"></i>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="ce-btn ce-btn-primary ce-btn-next">
                            Back to Course <i class="fas fa-arrow-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Section toggle functionality
        const sectionHeaders = document.querySelectorAll('.ce-lesson-section-header');
        
        sectionHeaders.forEach(function(header) {
            header.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetContent = document.querySelector(targetId);
                
                if (targetContent.classList.contains('show')) {
                    targetContent.classList.remove('show');
                    this.querySelector('.ce-lesson-section-toggle i').classList.remove('fa-chevron-up');
                    this.querySelector('.ce-lesson-section-toggle i').classList.add('fa-chevron-down');
                } else {
                    targetContent.classList.add('show');
                    this.querySelector('.ce-lesson-section-toggle i').classList.remove('fa-chevron-down');
                    this.querySelector('.ce-lesson-section-toggle i').classList.add('fa-chevron-up');
                }
            });
        });
    });
</script>
