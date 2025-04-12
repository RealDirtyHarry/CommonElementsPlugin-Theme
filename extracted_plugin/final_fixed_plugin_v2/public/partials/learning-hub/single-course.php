<?php
/**
 * Single Course Template
 *
 * This template displays the details of a single course in the Learning Hub.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Get the current course
global $post;

// Get course meta data
$instructor = get_post_meta( get_the_ID(), 'course_instructor', true );
$instructor_bio = get_post_meta( get_the_ID(), 'course_instructor_bio', true );
$instructor_image = get_post_meta( get_the_ID(), 'course_instructor_image', true );
$duration = get_post_meta( get_the_ID(), 'course_duration', true );
$enrolled = get_post_meta( get_the_ID(), 'course_enrolled', true );
$level = get_post_meta( get_the_ID(), 'course_level', true );
$requirements = get_post_meta( get_the_ID(), 'course_requirements', true );
$objectives = get_post_meta( get_the_ID(), 'course_objectives', true );
$certificate = get_post_meta( get_the_ID(), 'course_certificate', true );

// Get course progress if user is enrolled
$user_progress = 0;
$is_enrolled = false;
$completed_lessons = array();

if ( is_user_logged_in() ) {
    $current_user_id = get_current_user_id();
    $is_enrolled = mpcs_user_is_enrolled_in_course( $current_user_id, get_the_ID() );
    
    if ( $is_enrolled ) {
        $user_progress = mpcs_get_user_course_progress( $current_user_id, get_the_ID() );
        $completed_lessons = mpcs_get_user_completed_lessons( $current_user_id, get_the_ID() );
    }
}

// Get course lessons
$lessons = mpcs_get_course_lessons( get_the_ID() );

// Get course categories
$course_categories = get_the_terms( get_the_ID(), 'course_category' );
$category_names = array();
if ( ! empty( $course_categories ) && ! is_wp_error( $course_categories ) ) {
    foreach ( $course_categories as $category ) {
        $category_names[] = $category->name;
    }
}
?>

<div class="ce-learning-hub">
    <div class="ce-container">
        <div class="ce-section">
            <div class="ce-section-header">
                <div class="ce-breadcrumbs">
                    <a href="<?php echo esc_url( home_url( '/learning-hub' ) ); ?>">Learning Hub</a> &raquo; <?php the_title(); ?>
                </div>
                <h1 class="ce-section-title"><?php the_title(); ?></h1>
                <?php if ( ! empty( $category_names ) ) : ?>
                    <div class="ce-course-categories">
                        <?php echo esc_html( implode( ' / ', $category_names ) ); ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="ce-course-header">
                <div class="row">
                    <div class="col-md-8">
                        <div class="ce-course-image">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) );
                            } else {
                                echo '<img src="https://via.placeholder.com/800x450" alt="' . esc_attr( get_the_title() ) . '" class="img-fluid">';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ce-course-sidebar">
                            <div class="ce-course-meta-card">
                                <div class="ce-course-meta-item">
                                    <div class="ce-course-meta-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="ce-course-meta-content">
                                        <div class="ce-course-meta-label">Duration</div>
                                        <div class="ce-course-meta-value"><?php echo esc_html( $duration ?: 'Self-paced' ); ?></div>
                                    </div>
                                </div>
                                <div class="ce-course-meta-item">
                                    <div class="ce-course-meta-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="ce-course-meta-content">
                                        <div class="ce-course-meta-label">Enrolled</div>
                                        <div class="ce-course-meta-value"><?php echo esc_html( $enrolled ?: '0' ); ?> students</div>
                                    </div>
                                </div>
                                <div class="ce-course-meta-item">
                                    <div class="ce-course-meta-icon">
                                        <i class="fas fa-signal"></i>
                                    </div>
                                    <div class="ce-course-meta-content">
                                        <div class="ce-course-meta-label">Level</div>
                                        <div class="ce-course-meta-value"><?php echo esc_html( $level ?: 'All Levels' ); ?></div>
                                    </div>
                                </div>
                                <div class="ce-course-meta-item">
                                    <div class="ce-course-meta-icon">
                                        <i class="fas fa-certificate"></i>
                                    </div>
                                    <div class="ce-course-meta-content">
                                        <div class="ce-course-meta-label">Certificate</div>
                                        <div class="ce-course-meta-value"><?php echo ! empty( $certificate ) ? 'Yes' : 'No'; ?></div>
                                    </div>
                                </div>
                                
                                <?php if ( $is_enrolled ) : ?>
                                    <div class="ce-course-progress">
                                        <div class="ce-course-progress-label">Your Progress</div>
                                        <div class="ce-course-progress-bar">
                                            <div class="ce-course-progress-value" style="width: <?php echo esc_attr( $user_progress ); ?>%"></div>
                                        </div>
                                        <div class="ce-course-progress-text"><?php echo esc_html( $user_progress ); ?>% Complete</div>
                                    </div>
                                    
                                    <div class="ce-course-actions">
                                        <?php if ( $user_progress > 0 ) : ?>
                                            <a href="<?php echo esc_url( mpcs_get_user_course_continue_url( get_current_user_id(), get_the_ID() ) ); ?>" class="ce-btn ce-btn-primary ce-btn-block">Continue Course</a>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( mpcs_get_course_first_lesson_url( get_the_ID() ) ); ?>" class="ce-btn ce-btn-primary ce-btn-block">Start Course</a>
                                        <?php endif; ?>
                                    </div>
                                <?php else : ?>
                                    <div class="ce-course-actions">
                                        <?php if ( is_user_logged_in() ) : ?>
                                            <a href="<?php echo esc_url( mpcs_get_course_enrollment_url( get_the_ID() ) ); ?>" class="ce-btn ce-btn-primary ce-btn-block">Enroll Now</a>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="ce-btn ce-btn-primary ce-btn-block">Login to Enroll</a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ce-course-tabs">
                <ul class="ce-tabs-nav">
                    <li class="ce-tab-item">
                        <a href="#overview" class="ce-tab-link active" data-toggle="tab">Overview</a>
                    </li>
                    <li class="ce-tab-item">
                        <a href="#curriculum" class="ce-tab-link" data-toggle="tab">Curriculum</a>
                    </li>
                    <li class="ce-tab-item">
                        <a href="#instructor" class="ce-tab-link" data-toggle="tab">Instructor</a>
                    </li>
                    <?php if ( ! empty( $requirements ) ) : ?>
                        <li class="ce-tab-item">
                            <a href="#requirements" class="ce-tab-link" data-toggle="tab">Requirements</a>
                        </li>
                    <?php endif; ?>
                </ul>
                
                <div class="ce-tabs-content">
                    <div class="ce-tab-pane active" id="overview">
                        <div class="ce-course-overview">
                            <h2 class="ce-course-section-title">Course Description</h2>
                            <div class="ce-course-description">
                                <?php the_content(); ?>
                            </div>
                            
                            <?php if ( ! empty( $objectives ) ) : ?>
                                <h2 class="ce-course-section-title">What You'll Learn</h2>
                                <div class="ce-course-objectives">
                                    <?php echo wp_kses_post( $objectives ); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( ! empty( $certificate ) ) : ?>
                                <h2 class="ce-course-section-title">Certificate</h2>
                                <div class="ce-course-certificate">
                                    <div class="ce-certificate-preview">
                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/certificate-preview.jpg' ); ?>" alt="Certificate Preview">
                                    </div>
                                    <div class="ce-certificate-info">
                                        <p>Upon successful completion of this course, you will receive a certificate of achievement. This certificate can be used for professional development and continuing education credits.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="ce-tab-pane" id="curriculum">
                        <div class="ce-course-curriculum">
                            <h2 class="ce-course-section-title">Course Curriculum</h2>
                            
                            <?php if ( ! empty( $lessons ) ) : ?>
                                <div class="ce-curriculum-list">
                                    <?php
                                    $current_section = '';
                                    $section_count = 0;
                                    
                                    foreach ( $lessons as $lesson ) :
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
                                        <div class="ce-curriculum-section">
                                            <div class="ce-curriculum-section-header" data-toggle="collapse" data-target="#section-<?php echo esc_attr( $section_count ); ?>">
                                                <h3 class="ce-curriculum-section-title"><?php echo esc_html( $section ?: 'Section ' . $section_count ); ?></h3>
                                                <div class="ce-curriculum-section-toggle">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                            </div>
                                            <div class="ce-curriculum-section-content collapse show" id="section-<?php echo esc_attr( $section_count ); ?>">
                                    <?php endif; ?>
                                    
                                    <?php
                                        $lesson_type = get_post_meta( $lesson_id, 'lesson_type', true );
                                        $lesson_duration = get_post_meta( $lesson_id, 'lesson_duration', true );
                                        $is_completed = in_array( $lesson_id, $completed_lessons );
                                        $lesson_icon = 'fa-file-alt';
                                        $lesson_type_label = 'Lesson';
                                        
                                        if ( $lesson_type === 'video' ) {
                                            $lesson_icon = 'fa-play-circle';
                                            $lesson_type_label = 'Video';
                                        } elseif ( $lesson_type === 'quiz' ) {
                                            $lesson_icon = 'fa-question-circle';
                                            $lesson_type_label = 'Quiz';
                                        } elseif ( $lesson_type === 'assignment' ) {
                                            $lesson_icon = 'fa-clipboard';
                                            $lesson_type_label = 'Assignment';
                                        }
                                    ?>
                                    
                                    <div class="ce-curriculum-item <?php echo $is_completed ? 'ce-curriculum-item-completed' : ''; ?>">
                                        <div class="ce-curriculum-item-icon">
                                            <i class="fas <?php echo esc_attr( $lesson_icon ); ?>"></i>
                                        </div>
                                        <div class="ce-curriculum-item-content">
                                            <div class="ce-curriculum-item-title"><?php echo esc_html( $lesson->post_title ); ?></div>
                                            <div class="ce-curriculum-item-meta">
                                                <span class="ce-curriculum-item-type"><?php echo esc_html( $lesson_type_label ); ?></span>
                                                <?php if ( ! empty( $lesson_duration ) ) : ?>
                                                    <span class="ce-curriculum-item-duration"><?php echo esc_html( $lesson_duration ); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="ce-curriculum-item-status">
                                            <?php if ( $is_enrolled ) : ?>
                                                <?php if ( $is_completed ) : ?>
                                                    <span class="ce-curriculum-item-completed-badge">
                                                        <i class="fas fa-check-circle"></i> Completed
                                                    </span>
                                                <?php else : ?>
                                                    <a href="<?php echo esc_url( get_permalink( $lesson_id ) ); ?>" class="ce-btn ce-btn-sm ce-btn-outline-primary">Start</a>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <span class="ce-curriculum-item-locked">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <?php endforeach; ?>
                                    
                                    <?php if ( $current_section !== '' ) : ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else : ?>
                                <div class="ce-alert ce-alert-info">
                                    <p>No curriculum content has been added to this course yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="ce-tab-pane" id="instructor">
                        <div class="ce-course-instructor">
                            <h2 class="ce-course-section-title">About the Instructor</h2>
                            
                            <div class="ce-instructor-profile">
                                <div class="ce-instructor-avatar">
                                    <?php if ( ! empty( $instructor_image ) ) : ?>
                                        <img src="<?php echo esc_url( $instructor_image ); ?>" alt="<?php echo esc_attr( $instructor ); ?>">
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/default-avatar.jpg' ); ?>" alt="Instructor">
                                    <?php endif; ?>
                                </div>
                                <div class="ce-instructor-info">
                                    <h3 class="ce-instructor-name"><?php echo esc_html( $instructor ?: 'Course Instructor' ); ?></h3>
                                    <div class="ce-instructor-bio">
                                        <?php echo wp_kses_post( $instructor_bio ?: 'No instructor biography available.' ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if ( ! empty( $requirements ) ) : ?>
                        <div class="ce-tab-pane" id="requirements">
                            <div class="ce-course-requirements">
                                <h2 class="ce-course-section-title">Course Requirements</h2>
                                <div class="ce-requirements-content">
                                    <?php echo wp_kses_post( $requirements ); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="ce-section">
                <h2 class="ce-section-title">Related Courses</h2>
                
                <div class="ce-courses-grid">
                    <?php
                    $related_args = array(
                        'post_type' => 'mpcs-course',
                        'posts_per_page' => 3,
                        'post__not_in' => array( get_the_ID() ),
                        'orderby' => 'rand',
                    );
                    
                    // Add category filter if this course has categories
                    if ( ! empty( $course_categories ) && ! is_wp_error( $course_categories ) ) {
                        $category_ids = array();
                        foreach ( $course_categories as $category ) {
                            $category_ids[] = $category->term_id;
                        }
                        
                        $related_args['tax_query'] = array(
                            array(
                                'taxonomy' => 'course_category',
                                'field' => 'term_id',
                                'terms' => $category_ids,
                            ),
                        );
                    }
                    
                    $related_courses = new WP_Query( $related_args );
                    
                    if ( $related_courses->have_posts() ) :
                        while ( $related_courses->have_posts() ) : $related_courses->the_post();
                            $related_course_id = get_the_ID();
                            $related_instructor = get_post_meta( $related_course_id, 'course_instructor', true );
                            $related_duration = get_post_meta( $related_course_id, 'course_duration', true );
                            $related_enrolled = get_post_meta( $related_course_id, 'course_enrolled', true );
                            $related_thumbnail = get_the_post_thumbnail_url( $related_course_id, 'medium' );
                            if ( empty( $related_thumbnail ) ) {
                                $related_thumbnail = 'https://via.placeholder.com/300x200';
                            }
                    ?>
                        <div class="ce-course-card">
                            <div class="ce-course-image">
                                <img src="<?php echo esc_url( $related_thumbnail ); ?>" alt="<?php the_title_attribute(); ?>">
                            </div>
                            <div class="ce-course-body">
                                <h3 class="ce-course-title"><?php the_title(); ?></h3>
                                <?php if ( ! empty( $related_instructor ) ) : ?>
                                    <div class="ce-course-instructor">By <?php echo esc_html( $related_instructor ); ?></div>
                                <?php endif; ?>
                                <div class="ce-course-description"><?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?></div>
                                <div class="ce-course-meta">
                                    <?php if ( ! empty( $related_enrolled ) ) : ?>
                                        <span><i class="fas fa-users"></i> <?php echo esc_html( $related_enrolled ); ?> Enrolled</span>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $related_duration ) ) : ?>
                                        <span><i class="fas fa-clock"></i> <?php echo esc_html( $related_duration ); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="ce-course-footer">
                                <a href="<?php the_permalink(); ?>" class="ce-btn ce-btn-primary">View Course</a>
                            </div>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <div class="ce-alert ce-alert-info">
                            <p>No related courses found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabLinks = document.querySelectorAll('.ce-tab-link');
        
        tabLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                tabLinks.forEach(function(tab) {
                    tab.classList.remove('active');
                });
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Show corresponding tab content
                const tabId = this.getAttribute('href').substring(1);
                document.querySelectorAll('.ce-tab-pane').forEach(function(pane) {
                    pane.classList.remove('active');
                });
                document.getElementById(tabId).classList.add('active');
            });
        });
        
        // Section toggle functionality
        const sectionHeaders = document.querySelectorAll('.ce-curriculum-section-header');
        
        sectionHeaders.forEach(function(header) {
            header.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetContent = document.querySelector(targetId);
                
                if (targetContent.classList.contains('show')) {
                    targetContent.classList.remove('show');
                    this.querySelector('.ce-curriculum-section-toggle i').classList.remove('fa-chevron-up');
                    this.querySelector('.ce-curriculum-section-toggle i').classList.add('fa-chevron-down');
                } else {
                    targetContent.classList.add('show');
                    this.querySelector('.ce-curriculum-section-toggle i').classList.remove('fa-chevron-down');
                    this.querySelector('.ce-curriculum-section-toggle i').classList.add('fa-chevron-up');
                }
            });
        });
    });
</script>
