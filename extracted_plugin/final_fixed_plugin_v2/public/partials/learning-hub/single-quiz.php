<?php
/**
 * Quiz Assessment Template
 *
 * This template displays a quiz assessment in the Learning Hub.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Get the current quiz
global $post;

// Get quiz meta data
$quiz_duration = get_post_meta( get_the_ID(), 'quiz_duration', true );
$quiz_passing_score = get_post_meta( get_the_ID(), 'quiz_passing_score', true );
$quiz_attempts_allowed = get_post_meta( get_the_ID(), 'quiz_attempts_allowed', true );
$quiz_questions = get_post_meta( get_the_ID(), 'quiz_questions', true );

// Get course ID
$course_id = mpcs_get_lesson_course_id( get_the_ID() );

// Get next and previous lessons
$next_lesson_id = mpcs_get_next_lesson_id( get_the_ID() );
$prev_lesson_id = mpcs_get_previous_lesson_id( get_the_ID() );

// Check if user is enrolled
$is_enrolled = false;
$user_progress = 0;
$is_completed = false;
$quiz_attempts = 0;
$last_score = 0;
$has_passed = false;

if ( is_user_logged_in() ) {
    $current_user_id = get_current_user_id();
    $is_enrolled = mpcs_user_is_enrolled_in_course( $current_user_id, $course_id );
    
    if ( $is_enrolled ) {
        $user_progress = mpcs_get_user_course_progress( $current_user_id, $course_id );
        $is_completed = mpcs_is_lesson_completed( $current_user_id, get_the_ID() );
        $quiz_attempts = mpcs_get_quiz_attempts( $current_user_id, get_the_ID() );
        $last_score = mpcs_get_last_quiz_score( $current_user_id, get_the_ID() );
        $has_passed = $last_score >= $quiz_passing_score;
    }
}

// Get course lessons for navigation
$course_lessons = mpcs_get_course_lessons( $course_id );

// Check if form is submitted
$form_submitted = false;
$form_errors = array();
$quiz_results = array();
$quiz_score = 0;

if ( isset( $_POST['submit_quiz'] ) && isset( $_POST['quiz_nonce'] ) && wp_verify_nonce( $_POST['quiz_nonce'], 'submit_quiz_nonce' ) ) {
    $form_submitted = true;
    
    // Process quiz submission
    if ( $is_enrolled && ( empty( $quiz_attempts_allowed ) || $quiz_attempts < $quiz_attempts_allowed ) ) {
        $quiz_questions_data = json_decode( $quiz_questions, true );
        $total_questions = count( $quiz_questions_data );
        $correct_answers = 0;
        
        foreach ( $quiz_questions_data as $question_index => $question ) {
            $question_id = 'question_' . $question_index;
            $user_answer = isset( $_POST[$question_id] ) ? sanitize_text_field( $_POST[$question_id] ) : '';
            $correct_answer = $question['correct_answer'];
            $is_correct = $user_answer === $correct_answer;
            
            if ( $is_correct ) {
                $correct_answers++;
            }
            
            $quiz_results[] = array(
                'question' => $question['question'],
                'user_answer' => $user_answer,
                'correct_answer' => $correct_answer,
                'is_correct' => $is_correct,
            );
        }
        
        $quiz_score = ( $correct_answers / $total_questions ) * 100;
        $has_passed = $quiz_score >= $quiz_passing_score;
        
        // Save quiz attempt
        mpcs_save_quiz_attempt( $current_user_id, get_the_ID(), $quiz_score, $quiz_results );
        
        // Mark lesson as completed if passed
        if ( $has_passed ) {
            mpcs_mark_lesson_complete( $current_user_id, get_the_ID() );
            $is_completed = true;
        }
    } else {
        $form_errors[] = 'You have reached the maximum number of attempts for this quiz.';
    }
}
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
                    <span class="ce-lesson-type">
                        <i class="fas fa-question-circle"></i> Quiz
                    </span>
                    <?php if ( ! empty( $quiz_duration ) ) : ?>
                        <span class="ce-lesson-duration">
                            <i class="fas fa-clock"></i> <?php echo esc_html( $quiz_duration ); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ( ! empty( $quiz_passing_score ) ) : ?>
                        <span class="ce-lesson-passing-score">
                            <i class="fas fa-check"></i> Passing Score: <?php echo esc_html( $quiz_passing_score ); ?>%
                        </span>
                    <?php endif; ?>
                    <?php if ( ! empty( $quiz_attempts_allowed ) ) : ?>
                        <span class="ce-lesson-attempts">
                            <i class="fas fa-redo"></i> Attempts Allowed: <?php echo esc_html( $quiz_attempts_allowed ); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="ce-lesson-content">
                <div class="ce-quiz-introduction">
                    <?php the_content(); ?>
                </div>
                
                <?php if ( $form_submitted && ! empty( $quiz_results ) ) : ?>
                    <div class="ce-quiz-results">
                        <h2 class="ce-quiz-results-title">Quiz Results</h2>
                        
                        <div class="ce-quiz-score <?php echo $has_passed ? 'ce-quiz-score-passed' : 'ce-quiz-score-failed'; ?>">
                            <div class="ce-quiz-score-circle">
                                <div class="ce-quiz-score-number"><?php echo round( $quiz_score ); ?>%</div>
                            </div>
                            <div class="ce-quiz-score-text">
                                <?php if ( $has_passed ) : ?>
                                    <div class="ce-quiz-score-status">Passed</div>
                                    <div class="ce-quiz-score-message">Congratulations! You have passed the quiz.</div>
                                <?php else : ?>
                                    <div class="ce-quiz-score-status">Failed</div>
                                    <div class="ce-quiz-score-message">You did not reach the passing score. Please try again.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="ce-quiz-answers">
                            <h3 class="ce-quiz-answers-title">Your Answers</h3>
                            
                            <?php foreach ( $quiz_results as $index => $result ) : ?>
                                <div class="ce-quiz-answer <?php echo $result['is_correct'] ? 'ce-quiz-answer-correct' : 'ce-quiz-answer-incorrect'; ?>">
                                    <div class="ce-quiz-answer-question">
                                        <span class="ce-quiz-answer-number"><?php echo $index + 1; ?>.</span>
                                        <?php echo esc_html( $result['question'] ); ?>
                                    </div>
                                    <div class="ce-quiz-answer-details">
                                        <div class="ce-quiz-answer-user">
                                            <span class="ce-quiz-answer-label">Your Answer:</span>
                                            <span class="ce-quiz-answer-value"><?php echo esc_html( $result['user_answer'] ); ?></span>
                                        </div>
                                        <?php if ( ! $result['is_correct'] ) : ?>
                                            <div class="ce-quiz-answer-correct-answer">
                                                <span class="ce-quiz-answer-label">Correct Answer:</span>
                                                <span class="ce-quiz-answer-value"><?php echo esc_html( $result['correct_answer'] ); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if ( ! $has_passed && ( empty( $quiz_attempts_allowed ) || $quiz_attempts < $quiz_attempts_allowed ) ) : ?>
                            <div class="ce-quiz-retry">
                                <a href="<?php echo esc_url( add_query_arg( 'retry', '1', get_permalink() ) ); ?>" class="ce-btn ce-btn-primary">Try Again</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php elseif ( $is_enrolled && ! $is_completed && ( empty( $quiz_attempts_allowed ) || $quiz_attempts < $quiz_attempts_allowed ) && ! isset( $_GET['retry'] ) && $quiz_attempts > 0 ) : ?>
                    <div class="ce-quiz-previous-attempts">
                        <h2 class="ce-quiz-attempts-title">Previous Attempts</h2>
                        
                        <div class="ce-quiz-score <?php echo $has_passed ? 'ce-quiz-score-passed' : 'ce-quiz-score-failed'; ?>">
                            <div class="ce-quiz-score-circle">
                                <div class="ce-quiz-score-number"><?php echo round( $last_score ); ?>%</div>
                            </div>
                            <div class="ce-quiz-score-text">
                                <?php if ( $has_passed ) : ?>
                                    <div class="ce-quiz-score-status">Passed</div>
                                    <div class="ce-quiz-score-message">Congratulations! You have passed the quiz.</div>
                                <?php else : ?>
                                    <div class="ce-quiz-score-status">Failed</div>
                                    <div class="ce-quiz-score-message">You did not reach the passing score.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="ce-quiz-attempts-info">
                            <div class="ce-quiz-attempts-count">
                                <span class="ce-quiz-attempts-label">Attempts:</span>
                                <span class="ce-quiz-attempts-value"><?php echo esc_html( $quiz_attempts ); ?><?php echo ! empty( $quiz_attempts_allowed ) ? ' of ' . esc_html( $quiz_attempts_allowed ) : ''; ?></span>
                            </div>
                        </div>
                        
                        <div class="ce-quiz-retry">
                            <a href="<?php echo esc_url( add_query_arg( 'retry', '1', get_permalink() ) ); ?>" class="ce-btn ce-btn-primary">Try Again</a>
                        </div>
                    </div>
                <?php elseif ( $is_enrolled && ( $is_completed || isset( $_GET['retry'] ) || $quiz_attempts === 0 ) && ( empty( $quiz_attempts_allowed ) || $quiz_attempts < $quiz_attempts_allowed ) ) : ?>
                    <?php if ( ! empty( $form_errors ) ) : ?>
                        <div class="ce-alert ce-alert-danger">
                            <ul>
                                <?php foreach ( $form_errors as $error ) : ?>
                                    <li><?php echo esc_html( $error ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <div class="ce-quiz-form">
                        <form method="post" class="ce-form">
                            <?php wp_nonce_field( 'submit_quiz_nonce', 'quiz_nonce' ); ?>
                            
                            <?php
                            $quiz_questions_data = json_decode( $quiz_questions, true );
                            if ( ! empty( $quiz_questions_data ) ) :
                                foreach ( $quiz_questions_data as $question_index => $question ) :
                                    $question_id = 'question_' . $question_index;
                            ?>
                                <div class="ce-quiz-question">
                                    <h3 class="ce-quiz-question-text">
                                        <span class="ce-quiz-question-number"><?php echo $question_index + 1; ?>.</span>
                                        <?php echo esc_html( $question['question'] ); ?>
                                    </h3>
                                    
                                    <div class="ce-quiz-options">
                                        <?php foreach ( $question['options'] as $option_index => $option ) : ?>
                                            <div class="ce-quiz-option">
                                                <label class="ce-quiz-option-label">
                                                    <input type="radio" name="<?php echo esc_attr( $question_id ); ?>" value="<?php echo esc_attr( $option ); ?>" required>
                                                    <span class="ce-quiz-option-text"><?php echo esc_html( $option ); ?></span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                            
                            <div class="ce-form-actions">
                                <button type="submit" name="submit_quiz" class="ce-btn ce-btn-primary">Submit Quiz</button>
                            </div>
                        </form>
                    </div>
                <?php elseif ( $is_enrolled && $is_completed && ! isset( $_GET['retry'] ) ) : ?>
                    <div class="ce-quiz-completed">
                        <div class="ce-quiz-completed-message">
                            <i class="fas fa-check-circle"></i>
                            <h2>Quiz Completed</h2>
                            <p>You have successfully completed this quiz with a score of <?php echo round( $last_score ); ?>%.</p>
                        </div>
                        
                        <div class="ce-quiz-navigation">
                            <?php if ( $next_lesson_id ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $next_lesson_id ) ); ?>" class="ce-btn ce-btn-primary">
                                    Continue to Next Lesson <i class="fas fa-arrow-right"></i>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="ce-btn ce-btn-primary">
                                    Back to Course <i class="fas fa-arrow-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php elseif ( $is_enrolled && ! empty( $quiz_attempts_allowed ) && $quiz_attempts >= $quiz_attempts_allowed ) : ?>
                    <div class="ce-quiz-max-attempts">
                        <div class="ce-alert ce-alert-warning">
                            <h3>Maximum Attempts Reached</h3>
                            <p>You have reached the maximum number of attempts allowed for this quiz.</p>
                            <p>Your best score: <?php echo round( $last_score ); ?>%</p>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="ce-quiz-not-enrolled">
                        <div class="ce-alert ce-alert-info">
                            <h3>Enrollment Required</h3>
                            <p>You need to be enrolled in this course to take the quiz.</p>
                        </div>
                        
                        <div class="ce-quiz-enroll">
                            <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="ce-btn ce-btn-primary">
                                View Course Details
                            </a>
                        </div>
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
                    
                    <?php if ( $next_lesson_id && $is_completed ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $next_lesson_id ) ); ?>" class="ce-btn ce-btn-primary ce-btn-next">
                            Next Lesson <i class="fas fa-arrow-right"></i>
                        </a>
                    <?php elseif ( ! $next_lesson_id && $is_completed ) : ?>
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
