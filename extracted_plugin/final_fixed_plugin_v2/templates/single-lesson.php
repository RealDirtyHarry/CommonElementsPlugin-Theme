<?php
/**
 * Template for Single Lesson View
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
		<div class="ce-lesson-single">
			<?php
			while ( have_posts() ) :
				the_post();
				
				$course_id = get_post_meta( get_the_ID(), 'course_id', true );
				$duration = get_post_meta( get_the_ID(), 'lesson_duration', true );
				$attachments = get_post_meta( get_the_ID(), 'lesson_attachments', false );
				
				$course_title = '';
				$course_link = '';
				if ( ! empty( $course_id ) ) {
					$course = get_post( $course_id );
					if ( $course && 'course' === $course->post_type ) {
						$course_title = $course->post_title;
						$course_link = get_permalink( $course_id );
					}
				}
				
				$next_lesson_id = 0;
				$prev_lesson_id = 0;
				$current_lesson_id = get_the_ID();
				
				if ( ! empty( $course_id ) ) {
					$curriculum = get_post_meta( $course_id, 'course_curriculum', true );
					
					if ( ! empty( $curriculum ) && is_array( $curriculum ) ) {
						$found_current = false;
						$prev_item_id = 0;
						
						foreach ( $curriculum as $section ) {
							if ( ! empty( $section['items'] ) && is_array( $section['items'] ) ) {
								foreach ( $section['items'] as $item ) {
									if ( isset( $item['id'] ) && $item['id'] > 0 ) {
										if ( $found_current && isset( $item['type'] ) && $item['type'] === 'lesson' && empty( $next_lesson_id ) ) {
											$next_lesson_id = $item['id'];
											break 2;
										}
										
										if ( $item['id'] == $current_lesson_id ) {
											$found_current = true;
											$prev_lesson_id = $prev_item_id;
										}
										
										if ( isset( $item['type'] ) && $item['type'] === 'lesson' ) {
											$prev_item_id = $item['id'];
										}
									}
								}
							}
						}
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
				
				$is_first_lesson = false;
				if ( ! empty( $curriculum ) && is_array( $curriculum ) ) {
					if ( ! empty( $curriculum[0]['items'] ) && is_array( $curriculum[0]['items'] ) ) {
						if ( isset( $curriculum[0]['items'][0]['id'] ) && $curriculum[0]['items'][0]['id'] == $current_lesson_id ) {
							$is_first_lesson = true;
							$has_access = true;
						}
					}
				}
				
				if ( ! $has_access && ! $is_first_lesson ) {
					?>
					<div class="ce-lesson-access-denied">
						<div class="ce-access-denied-message">
							<i class="fas fa-lock"></i>
							<h2><?php esc_html_e( 'Access Denied', 'common-elements-platform' ); ?></h2>
							<p><?php esc_html_e( 'You need to be enrolled in this course to access this lesson.', 'common-elements-platform' ); ?></p>
							
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
					<div class="ce-lesson-header">
						<?php if ( ! empty( $course_title ) && ! empty( $course_link ) ) : ?>
							<div class="ce-lesson-course-link">
								<a href="<?php echo esc_url( $course_link ); ?>">
									<i class="fas fa-arrow-left"></i>
									<?php echo esc_html( $course_title ); ?>
								</a>
							</div>
						<?php endif; ?>
						
						<h1 class="ce-lesson-title"><?php the_title(); ?></h1>
						
						<div class="ce-lesson-details">
							<?php if ( ! empty( $duration ) ) : ?>
								<div class="ce-lesson-detail">
									<i class="fas fa-clock"></i>
									<span><?php echo esc_html( sprintf( __( 'Duration: %s', 'common-elements-platform' ), $duration ) ); ?></span>
								</div>
							<?php endif; ?>
							
							<div class="ce-lesson-detail">
								<i class="fas fa-calendar-alt"></i>
								<span><?php echo esc_html( sprintf( __( 'Published: %s', 'common-elements-platform' ), get_the_date() ) ); ?></span>
							</div>
						</div>
					</div>
					
					<div class="ce-lesson-content">
						<div class="ce-lesson-description">
							<?php the_content(); ?>
						</div>
						
						<?php if ( ! empty( $attachments ) ) : ?>
							<div class="ce-lesson-attachments">
								<h2><?php esc_html_e( 'Lesson Resources', 'common-elements-platform' ); ?></h2>
								<ul class="ce-lesson-attachment-list">
									<?php foreach ( $attachments as $attachment_id ) : ?>
										<li class="ce-lesson-attachment-item">
											<a href="<?php echo esc_url( wp_get_attachment_url( $attachment_id ) ); ?>" target="_blank">
												<i class="fas fa-file"></i>
												<?php echo esc_html( get_the_title( $attachment_id ) ); ?>
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
					
					<div class="ce-lesson-navigation">
						<?php if ( ! empty( $prev_lesson_id ) ) : ?>
							<a href="<?php echo esc_url( get_permalink( $prev_lesson_id ) ); ?>" class="ce-lesson-nav-prev">
								<i class="fas fa-arrow-left"></i>
								<?php esc_html_e( 'Previous Lesson', 'common-elements-platform' ); ?>
							</a>
						<?php endif; ?>
						
						<?php if ( ! empty( $course_link ) ) : ?>
							<a href="<?php echo esc_url( $course_link ); ?>" class="ce-lesson-nav-course">
								<i class="fas fa-th-list"></i>
								<?php esc_html_e( 'Course Content', 'common-elements-platform' ); ?>
							</a>
						<?php endif; ?>
						
						<?php if ( ! empty( $next_lesson_id ) ) : ?>
							<a href="<?php echo esc_url( get_permalink( $next_lesson_id ) ); ?>" class="ce-lesson-nav-next">
								<?php esc_html_e( 'Next Lesson', 'common-elements-platform' ); ?>
								<i class="fas fa-arrow-right"></i>
							</a>
						<?php else : ?>
							<a href="<?php echo esc_url( $course_link ); ?>" class="ce-lesson-nav-complete">
								<?php esc_html_e( 'Complete Course', 'common-elements-platform' ); ?>
								<i class="fas fa-check-circle"></i>
							</a>
						<?php endif; ?>
					</div>
					
					<?php if ( is_user_logged_in() ) : ?>
						<div class="ce-lesson-completion">
							<form id="ce-lesson-complete-form">
								<?php wp_nonce_field( 'common_elements_platform_nonce', 'nonce' ); ?>
								<input type="hidden" name="lesson_id" value="<?php echo get_the_ID(); ?>">
								<input type="hidden" name="course_id" value="<?php echo esc_attr( $course_id ); ?>">
								
								<button type="submit" class="ce-button ce-button-primary ce-complete-lesson-btn">
									<i class="fas fa-check"></i>
									<?php esc_html_e( 'Mark as Complete', 'common-elements-platform' ); ?>
								</button>
							</form>
						</div>
						
						<script>
						jQuery(document).ready(function($) {
							$('#ce-lesson-complete-form').on('submit', function(e) {
								e.preventDefault();
								
								const $form = $(this);
								const $button = $form.find('button[type="submit"]');
								
								$button.prop('disabled', true);
								
								$.ajax({
									url: common_elements_platform.ajax_url,
									type: 'POST',
									data: $form.serialize() + '&action=complete_lesson',
									success: function(response) {
										if (response.success) {
											$button.html('<i class="fas fa-check-circle"></i> ' + '<?php esc_html_e( 'Completed', 'common-elements-platform' ); ?>');
											
											<?php if ( ! empty( $next_lesson_id ) ) : ?>
												setTimeout(function() {
													window.location.href = '<?php echo esc_url( get_permalink( $next_lesson_id ) ); ?>';
												}, 1000);
											<?php else : ?>
												setTimeout(function() {
													window.location.href = '<?php echo esc_url( $course_link ); ?>';
												}, 1000);
											<?php endif; ?>
										} else {
											$button.prop('disabled', false);
											alert(response.data.message);
										}
									},
									error: function() {
										$button.prop('disabled', false);
										alert('An error occurred. Please try again.');
									}
								});
							});
						});
						</script>
					<?php endif; ?>
				<?php } ?>
			<?php endwhile; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
