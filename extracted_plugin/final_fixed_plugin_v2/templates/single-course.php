<?php
/**
 * Template for Single Course View
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
		<div class="ce-course-single">
			<?php
			while ( have_posts() ) :
				the_post();
				
				$duration = get_post_meta( get_the_ID(), 'course_duration', true );
				$level = get_post_meta( get_the_ID(), 'course_level', true );
				$instructor = get_post_meta( get_the_ID(), 'course_instructor', true );
				$curriculum = get_post_meta( get_the_ID(), 'course_curriculum', true );
				
				$categories = wp_get_object_terms( get_the_ID(), 'course_category' );
				$category_name = ! empty( $categories ) ? $categories[0]->name : __( 'Uncategorized', 'common-elements-platform' );
				
				$enrolled = false;
				if ( is_user_logged_in() ) {
					$user_id = get_current_user_id();
					$enrolled_users = get_post_meta( get_the_ID(), 'enrolled_users', true );
					if ( ! empty( $enrolled_users ) && is_array( $enrolled_users ) ) {
						$enrolled = in_array( $user_id, $enrolled_users );
					}
				}
				?>
				
				<div class="ce-course-header">
					<div class="ce-course-meta">
						<span class="ce-course-category"><?php echo esc_html( $category_name ); ?></span>
						<span class="ce-course-level">
							<?php 
							switch ( $level ) {
								case 'beginner':
									echo '<i class="fas fa-signal-1"></i> ';
									esc_html_e( 'Beginner', 'common-elements-platform' );
									break;
								case 'intermediate':
									echo '<i class="fas fa-signal-2"></i> ';
									esc_html_e( 'Intermediate', 'common-elements-platform' );
									break;
								case 'advanced':
									echo '<i class="fas fa-signal-3"></i> ';
									esc_html_e( 'Advanced', 'common-elements-platform' );
									break;
								default:
									echo '<i class="fas fa-signal"></i> ';
									echo esc_html( ucfirst( $level ) );
							}
							?>
						</span>
					</div>
					
					<h1 class="ce-course-title"><?php the_title(); ?></h1>
					
					<div class="ce-course-details">
						<?php if ( ! empty( $duration ) ) : ?>
							<div class="ce-course-detail">
								<i class="fas fa-clock"></i>
								<span><?php echo esc_html( sprintf( __( 'Duration: %s', 'common-elements-platform' ), $duration ) ); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( ! empty( $instructor ) ) : ?>
							<div class="ce-course-detail">
								<i class="fas fa-user"></i>
								<span><?php echo esc_html( sprintf( __( 'Instructor: %s', 'common-elements-platform' ), $instructor ) ); ?></span>
							</div>
						<?php endif; ?>
						
						<div class="ce-course-detail">
							<i class="fas fa-calendar-alt"></i>
							<span><?php echo esc_html( sprintf( __( 'Published: %s', 'common-elements-platform' ), get_the_date() ) ); ?></span>
						</div>
					</div>
				</div>
				
				<div class="ce-course-content">
					<div class="ce-course-description">
						<h2><?php esc_html_e( 'Course Description', 'common-elements-platform' ); ?></h2>
						<?php the_content(); ?>
					</div>
					
					<?php if ( ! empty( $curriculum ) && is_array( $curriculum ) ) : ?>
						<div class="ce-course-curriculum">
							<h2><?php esc_html_e( 'Course Curriculum', 'common-elements-platform' ); ?></h2>
							
							<div class="ce-curriculum-sections">
								<?php foreach ( $curriculum as $section_index => $section ) : ?>
									<div class="ce-curriculum-section">
										<div class="ce-section-header">
											<h3 class="ce-section-title"><?php echo esc_html( $section['title'] ); ?></h3>
											<?php if ( ! empty( $section['description'] ) ) : ?>
												<div class="ce-section-description"><?php echo wp_kses_post( $section['description'] ); ?></div>
											<?php endif; ?>
										</div>
										
										<?php if ( ! empty( $section['items'] ) && is_array( $section['items'] ) ) : ?>
											<div class="ce-section-items">
												<?php foreach ( $section['items'] as $item_index => $item ) : 
													$item_type = isset( $item['type'] ) ? $item['type'] : 'lesson';
													$item_id = isset( $item['id'] ) ? $item['id'] : 0;
													$item_title = isset( $item['title'] ) ? $item['title'] : '';
													$item_duration = isset( $item['duration'] ) ? $item['duration'] : '';
													
													$accessible = $enrolled;
													if ( $section_index === 0 && $item_index === 0 ) {
														$accessible = true;
													}
													
													$item_permalink = '#';
													if ( $item_id > 0 ) {
														$item_permalink = get_permalink( $item_id );
													}
													
													$item_icon = 'fa-file-alt';
													if ( $item_type === 'lesson' ) {
														$item_icon = 'fa-book';
													} elseif ( $item_type === 'quiz' ) {
														$item_icon = 'fa-question-circle';
													}
												?>
													<div class="ce-section-item ce-item-<?php echo esc_attr( $item_type ); ?> <?php echo $accessible ? 'ce-item-accessible' : 'ce-item-locked'; ?>">
														<div class="ce-item-icon">
															<i class="fas <?php echo esc_attr( $item_icon ); ?>"></i>
														</div>
														
														<div class="ce-item-content">
															<h4 class="ce-item-title">
																<?php if ( $accessible ) : ?>
																	<a href="<?php echo esc_url( $item_permalink ); ?>"><?php echo esc_html( $item_title ); ?></a>
																<?php else : ?>
																	<?php echo esc_html( $item_title ); ?>
																<?php endif; ?>
															</h4>
															
															<?php if ( ! empty( $item_duration ) ) : ?>
																<div class="ce-item-duration">
																	<i class="fas fa-clock"></i>
																	<span><?php echo esc_html( $item_duration ); ?></span>
																</div>
															<?php endif; ?>
														</div>
														
														<div class="ce-item-status">
															<?php if ( $accessible ) : ?>
																<span class="ce-item-status-accessible">
																	<i class="fas fa-unlock"></i>
																	<?php esc_html_e( 'Accessible', 'common-elements-platform' ); ?>
																</span>
															<?php else : ?>
																<span class="ce-item-status-locked">
																	<i class="fas fa-lock"></i>
																	<?php esc_html_e( 'Locked', 'common-elements-platform' ); ?>
																</span>
															<?php endif; ?>
														</div>
													</div>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="ce-course-actions">
					<?php if ( ! $enrolled && is_user_logged_in() ) : ?>
						<div id="enroll-section" class="ce-course-enroll">
							<h2><?php esc_html_e( 'Enroll in this Course', 'common-elements-platform' ); ?></h2>
							
							<form id="ce-course-enroll-form">
								<?php wp_nonce_field( 'common_elements_platform_nonce', 'nonce' ); ?>
								<input type="hidden" name="course_id" value="<?php echo get_the_ID(); ?>">
								
								<div class="ce-form-row">
									<button type="submit" class="ce-button ce-button-primary">
										<i class="fas fa-user-plus"></i>
										<?php esc_html_e( 'Enroll Now', 'common-elements-platform' ); ?>
									</button>
								</div>
								
								<div class="ce-form-error-message" style="display: none;"></div>
							</form>
						</div>
					<?php elseif ( $enrolled ) : ?>
						<div class="ce-course-enrolled">
							<div class="ce-enrolled-message">
								<i class="fas fa-check-circle"></i>
								<?php esc_html_e( 'You are enrolled in this course', 'common-elements-platform' ); ?>
							</div>
							
							<?php
							$first_lesson_link = '#';
							if ( ! empty( $curriculum ) && is_array( $curriculum ) ) {
								foreach ( $curriculum as $section ) {
									if ( ! empty( $section['items'] ) && is_array( $section['items'] ) ) {
										foreach ( $section['items'] as $item ) {
											if ( isset( $item['type'] ) && $item['type'] === 'lesson' && isset( $item['id'] ) && $item['id'] > 0 ) {
												$first_lesson_link = get_permalink( $item['id'] );
												break 2;
											}
										}
									}
								}
							}
							?>
							
							<a href="<?php echo esc_url( $first_lesson_link ); ?>" class="ce-button ce-button-primary">
								<i class="fas fa-play-circle"></i>
								<?php esc_html_e( 'Start Learning', 'common-elements-platform' ); ?>
							</a>
						</div>
					<?php else : ?>
						<div class="ce-course-login-required">
							<p><?php esc_html_e( 'Please log in to enroll in this course.', 'common-elements-platform' ); ?></p>
							<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="ce-button ce-button-secondary">
								<i class="fas fa-sign-in-alt"></i>
								<?php esc_html_e( 'Log In', 'common-elements-platform' ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
				
			<?php endwhile; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<script>
jQuery(document).ready(function($) {
	$('#ce-course-enroll-form').on('submit', function(e) {
		e.preventDefault();
		
		const $form = $(this);
		const $submitButton = $form.find('button[type="submit"]');
		
		$submitButton.prop('disabled', true);
		
		$.ajax({
			url: common_elements_platform.ajax_url,
			type: 'POST',
			data: $form.serialize() + '&action=enroll_course',
			success: function(response) {
				if (response.success) {
					window.location.reload();
				} else {
					$form.find('.ce-form-error-message').text(response.data.message).show();
					$submitButton.prop('disabled', false);
				}
			},
			error: function() {
				$form.find('.ce-form-error-message').text('An error occurred. Please try again.').show();
				$submitButton.prop('disabled', false);
			}
		});
	});
});
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
