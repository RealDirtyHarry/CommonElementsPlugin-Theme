<?php
/**
 * Template for Single Quiz View
 *
 * @package Common_Elements_Platform
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="ce-quiz-single">
			<?php
			while ( have_posts() ) :
				the_post();
				
				$course_id = get_post_meta( get_the_ID(), 'course_id', true );
				$lesson_id = get_post_meta( get_the_ID(), 'lesson_id', true );
				$time_limit = get_post_meta( get_the_ID(), 'quiz_time_limit', true );
				$passing_score = get_post_meta( get_the_ID(), 'quiz_passing_score', true );
				$questions = get_post_meta( get_the_ID(), 'quiz_questions', true );
				
				$course_title = '';
				$course_link = '';
				$lesson_title = '';
				$lesson_link = '';
				
				if ( ! empty( $course_id ) ) {
					$course = get_post( $course_id );
					if ( $course && 'course' === $course->post_type ) {
						$course_title = $course->post_title;
						$course_link = get_permalink( $course_id );
					}
				}
				
				if ( ! empty( $lesson_id ) ) {
					$lesson = get_post( $lesson_id );
					if ( $lesson && 'lesson' === $lesson->post_type ) {
						$lesson_title = $lesson->post_title;
						$lesson_link = get_permalink( $lesson_id );
					}
				}
				
				$has_access = false;
				if ( is_user_logged_in() ) {
					$user_id = get_current_user_id();
					$enrolled_users = get_post_meta( $course_id, 'enrolled_users', true );
					
					if ( ! empty( $enrolled_users ) && is_array( $enrolled_users ) && in_array( $user_id, $enrolled_users ) ) {
						$has_access = true;
					}
				}
				
				$completed = false;
				$user_score = 0;
				if ( is_user_logged_in() ) {
					$user_id = get_current_user_id();
					$quiz_results = get_post_meta( get_the_ID(), 'quiz_results', true );
					
					if ( ! empty( $quiz_results ) && is_array( $quiz_results ) && isset( $quiz_results[$user_id] ) ) {
						$completed = true;
						$user_score = $quiz_results[$user_id]['score'];
					}
				}
				
				if ( ! $has_access ) {
					?>
					<div class="ce-quiz-access-denied">
						<div class="ce-access-denied-message">
							<i class="fas fa-lock"></i>
							<h2><?php esc_html_e( 'Access Denied', 'common-elements-platform' ); ?></h2>
							<p><?php esc_html_e( 'You need to be enrolled in this course to access this quiz.', 'common-elements-platform' ); ?></p>
							
							<?php if ( ! empty( $course_link ) ) : ?>
								<a href="<?php echo esc_url( $course_link ); ?>" class="ce-button ce-button-primary">
									<i class="fas fa-arrow-left"></i>
									<?php esc_html_e( 'Go to Course', 'common-elements-platform' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
					<?php
				} else {
					?>
					<div class="ce-quiz-header">
						<div class="ce-quiz-navigation">
							<?php if ( ! empty( $course_title ) && ! empty( $course_link ) ) : ?>
								<div class="ce-quiz-course-link">
									<a href="<?php echo esc_url( $course_link ); ?>">
										<i class="fas fa-arrow-left"></i>
										<?php echo esc_html( $course_title ); ?>
									</a>
								</div>
							<?php endif; ?>
							
							<?php if ( ! empty( $lesson_title ) && ! empty( $lesson_link ) ) : ?>
								<div class="ce-quiz-lesson-link">
									<a href="<?php echo esc_url( $lesson_link ); ?>">
										<i class="fas fa-book"></i>
										<?php echo esc_html( $lesson_title ); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
						
						<h1 class="ce-quiz-title"><?php the_title(); ?></h1>
						
						<div class="ce-quiz-details">
							<?php if ( ! empty( $time_limit ) ) : ?>
								<div class="ce-quiz-detail">
									<i class="fas fa-clock"></i>
									<span><?php echo esc_html( sprintf( __( 'Time Limit: %s minutes', 'common-elements-platform' ), $time_limit ) ); ?></span>
								</div>
							<?php endif; ?>
							
							<?php if ( ! empty( $passing_score ) ) : ?>
								<div class="ce-quiz-detail">
									<i class="fas fa-check-circle"></i>
									<span><?php echo esc_html( sprintf( __( 'Passing Score: %s%%', 'common-elements-platform' ), $passing_score ) ); ?></span>
								</div>
							<?php endif; ?>
							
							<?php if ( ! empty( $questions ) && is_array( $questions ) ) : ?>
								<div class="ce-quiz-detail">
									<i class="fas fa-question-circle"></i>
									<span><?php echo esc_html( sprintf( _n( '%s Question', '%s Questions', count( $questions ), 'common-elements-platform' ), count( $questions ) ) ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					</div>
					
					<div class="ce-quiz-content">
						<div class="ce-quiz-description">
							<?php the_content(); ?>
						</div>
						
						<?php if ( $completed ) : ?>
							<div class="ce-quiz-results">
								<h2><?php esc_html_e( 'Quiz Results', 'common-elements-platform' ); ?></h2>
								
								<div class="ce-quiz-score">
									<div class="ce-quiz-score-circle <?php echo $user_score >= $passing_score ? 'ce-quiz-passed' : 'ce-quiz-failed'; ?>">
										<span class="ce-quiz-score-value"><?php echo esc_html( $user_score ); ?>%</span>
									</div>
									
									<div class="ce-quiz-score-message">
										<?php if ( $user_score >= $passing_score ) : ?>
											<h3><?php esc_html_e( 'Congratulations!', 'common-elements-platform' ); ?></h3>
											<p><?php esc_html_e( 'You have passed this quiz.', 'common-elements-platform' ); ?></p>
										<?php else : ?>
											<h3><?php esc_html_e( 'Not Passed', 'common-elements-platform' ); ?></h3>
											<p><?php esc_html_e( 'You did not reach the passing score for this quiz.', 'common-elements-platform' ); ?></p>
										<?php endif; ?>
									</div>
								</div>
								
								<div class="ce-quiz-actions">
									<a href="<?php echo esc_url( add_query_arg( 'retake', '1', get_permalink() ) ); ?>" class="ce-button ce-button-secondary">
										<i class="fas fa-redo"></i>
										<?php esc_html_e( 'Retake Quiz', 'common-elements-platform' ); ?>
									</a>
									
									<?php if ( ! empty( $course_link ) ) : ?>
										<a href="<?php echo esc_url( $course_link ); ?>" class="ce-button ce-button-primary">
											<i class="fas fa-arrow-right"></i>
											<?php esc_html_e( 'Continue Course', 'common-elements-platform' ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						<?php elseif ( ! empty( $questions ) && is_array( $questions ) ) : ?>
							<form id="ce-quiz-form" class="ce-quiz-questions">
								<?php wp_nonce_field( 'common_elements_platform_nonce', 'nonce' ); ?>
								<input type="hidden" name="quiz_id" value="<?php echo get_the_ID(); ?>">
								<input type="hidden" name="course_id" value="<?php echo esc_attr( $course_id ); ?>">
								
								<?php if ( ! empty( $time_limit ) ) : ?>
									<div class="ce-quiz-timer">
										<i class="fas fa-clock"></i>
										<span id="ce-quiz-timer-display"><?php echo esc_html( $time_limit ); ?>:00</span>
									</div>
								<?php endif; ?>
								
								<?php foreach ( $questions as $question_index => $question ) : 
									$question_type = isset( $question['type'] ) ? $question['type'] : 'multiple_choice';
									$question_text = isset( $question['text'] ) ? $question['text'] : '';
									$question_options = isset( $question['options'] ) ? $question['options'] : array();
									$question_id = 'question_' . $question_index;
								?>
									<div class="ce-quiz-question" data-question-index="<?php echo esc_attr( $question_index ); ?>">
										<h3 class="ce-question-text">
											<span class="ce-question-number"><?php echo esc_html( $question_index + 1 ); ?>.</span>
											<?php echo esc_html( $question_text ); ?>
										</h3>
										
										<?php if ( $question_type === 'multiple_choice' ) : ?>
											<div class="ce-question-options">
												<?php foreach ( $question_options as $option_index => $option ) : 
													$option_id = $question_id . '_option_' . $option_index;
												?>
													<div class="ce-question-option">
														<input type="radio" id="<?php echo esc_attr( $option_id ); ?>" name="<?php echo esc_attr( $question_id ); ?>" value="<?php echo esc_attr( $option_index ); ?>">
														<label for="<?php echo esc_attr( $option_id ); ?>"><?php echo esc_html( $option ); ?></label>
													</div>
												<?php endforeach; ?>
											</div>
										<?php elseif ( $question_type === 'true_false' ) : ?>
											<div class="ce-question-options">
												<div class="ce-question-option">
													<input type="radio" id="<?php echo esc_attr( $question_id ); ?>_true" name="<?php echo esc_attr( $question_id ); ?>" value="true">
													<label for="<?php echo esc_attr( $question_id ); ?>_true"><?php esc_html_e( 'True', 'common-elements-platform' ); ?></label>
												</div>
												<div class="ce-question-option">
													<input type="radio" id="<?php echo esc_attr( $question_id ); ?>_false" name="<?php echo esc_attr( $question_id ); ?>" value="false">
													<label for="<?php echo esc_attr( $question_id ); ?>_false"><?php esc_html_e( 'False', 'common-elements-platform' ); ?></label>
												</div>
											</div>
										<?php elseif ( $question_type === 'text' ) : ?>
											<div class="ce-question-text-answer">
												<textarea name="<?php echo esc_attr( $question_id ); ?>" rows="4" placeholder="<?php esc_attr_e( 'Enter your answer here...', 'common-elements-platform' ); ?>"></textarea>
											</div>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
								
								<div class="ce-quiz-submit">
									<button type="submit" class="ce-button ce-button-primary">
										<i class="fas fa-check"></i>
										<?php esc_html_e( 'Submit Quiz', 'common-elements-platform' ); ?>
									</button>
								</div>
							</form>
							
							<script>
							jQuery(document).ready(function($) {
								<?php if ( ! empty( $time_limit ) ) : ?>
									let timeLeft = <?php echo esc_js( $time_limit * 60 ); ?>;
									const timerDisplay = $('#ce-quiz-timer-display');
									
									const quizTimer = setInterval(function() {
										timeLeft--;
										
										const minutes = Math.floor(timeLeft / 60);
										const seconds = timeLeft % 60;
										
										timerDisplay.text(minutes + ':' + (seconds < 10 ? '0' : '') + seconds);
										
										if (timeLeft <= 0) {
											clearInterval(quizTimer);
											$('#ce-quiz-form').submit();
										}
									}, 1000);
								<?php endif; ?>
								
								$('#ce-quiz-form').on('submit', function(e) {
									e.preventDefault();
									
									const $form = $(this);
									const $submitButton = $form.find('button[type="submit"]');
									
									$submitButton.prop('disabled', true);
									
									$.ajax({
										url: common_elements_platform.ajax_url,
										type: 'POST',
										data: $form.serialize() + '&action=submit_quiz',
										success: function(response) {
											if (response.success) {
												window.location.reload();
											} else {
												alert(response.data.message);
												$submitButton.prop('disabled', false);
											}
										},
										error: function() {
											alert('An error occurred. Please try again.');
											$submitButton.prop('disabled', false);
										}
									});
								});
							});
							</script>
						<?php endif; ?>
					</div>
				<?php } ?>
			<?php endwhile; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
