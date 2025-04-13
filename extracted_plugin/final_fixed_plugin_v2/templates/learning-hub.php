<?php
/**
 * Template for Learning Hub
 *
 * @package Common_Elements_Platform
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$categories = get_terms( array(
	'taxonomy' => 'course_category',
	'hide_empty' => false,
) );

$featured_courses = new WP_Query( array(
	'post_type' => 'course',
	'posts_per_page' => 3,
	'meta_query' => array(
		array(
			'key' => 'course_featured',
			'value' => '1',
			'compare' => '=',
		),
	),
) );

$recent_courses = new WP_Query( array(
	'post_type' => 'course',
	'posts_per_page' => 6,
	'orderby' => 'date',
	'order' => 'DESC',
) );

$enrolled_courses = array();
if ( is_user_logged_in() ) {
	$user_id = get_current_user_id();
	$enrolled_course_ids = get_user_meta( $user_id, 'enrolled_courses', true );
	
	if ( ! empty( $enrolled_course_ids ) && is_array( $enrolled_course_ids ) ) {
		$enrolled_courses = new WP_Query( array(
			'post_type' => 'course',
			'posts_per_page' => -1,
			'post__in' => $enrolled_course_ids,
		) );
	}
}
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="ce-learning-hub-container">
			<div class="ce-learning-hub-header">
				<h1 class="ce-learning-hub-title"><?php esc_html_e( 'Learning Hub', 'common-elements-platform' ); ?></h1>
				
				<div class="ce-learning-hub-search">
					<form id="ce-learning-search-form" class="ce-search-form">
						<div class="ce-search-input-wrapper">
							<input type="text" name="search" class="ce-learning-search-input" placeholder="<?php esc_attr_e( 'Search courses...', 'common-elements-platform' ); ?>">
							<button type="submit" class="ce-search-button">
								<i class="fas fa-search"></i>
							</button>
						</div>
						
						<div class="ce-learning-search-filter">
							<select name="category" class="ce-learning-category-filter">
								<option value=""><?php esc_html_e( 'All Categories', 'common-elements-platform' ); ?></option>
								<?php
								if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
									foreach ( $categories as $category ) {
										echo '<option value="' . esc_attr( $category->term_id ) . '">' . esc_html( $category->name ) . '</option>';
									}
								}
								?>
							</select>
						</div>
					</form>
				</div>
			</div>
			
			<?php if ( is_user_logged_in() && ! empty( $enrolled_courses ) && $enrolled_courses->have_posts() ) : ?>
				<div class="ce-learning-section ce-learning-enrolled-courses">
					<h2 class="ce-learning-section-title"><?php esc_html_e( 'My Courses', 'common-elements-platform' ); ?></h2>
					
					<div class="ce-learning-courses-grid">
						<?php while ( $enrolled_courses->have_posts() ) : $enrolled_courses->the_post();
							$course_id = get_the_ID();
							$course_progress = get_user_meta( $user_id, 'course_' . $course_id . '_progress', true );
							$course_progress = ! empty( $course_progress ) ? $course_progress : 0;
							
							$course_image = get_the_post_thumbnail_url( $course_id, 'medium' );
							$course_image = $course_image ? $course_image : COMMON_ELEMENTS_PLATFORM_URL . 'assets/images/course-placeholder.jpg';
							
							$lesson_count = get_post_meta( $course_id, 'course_lesson_count', true );
							$lesson_count = ! empty( $lesson_count ) ? $lesson_count : 0;
							
							$course_duration = get_post_meta( $course_id, 'course_duration', true );
							$course_duration = ! empty( $course_duration ) ? $course_duration : '';
						?>
							<div class="ce-learning-course-card">
								<div class="ce-learning-course-image">
									<img src="<?php echo esc_url( $course_image ); ?>" alt="<?php the_title_attribute(); ?>">
									
									<div class="ce-learning-course-progress">
										<div class="ce-learning-progress-bar">
											<div class="ce-learning-progress-fill" style="width: <?php echo esc_attr( $course_progress ); ?>%;"></div>
										</div>
										<span class="ce-learning-progress-text"><?php echo esc_html( $course_progress ); ?>% <?php esc_html_e( 'Complete', 'common-elements-platform' ); ?></span>
									</div>
								</div>
								
								<div class="ce-learning-course-content">
									<h3 class="ce-learning-course-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									
									<div class="ce-learning-course-meta">
										<?php if ( ! empty( $lesson_count ) ) : ?>
											<span class="ce-learning-course-lessons">
												<i class="fas fa-book"></i>
												<?php echo esc_html( sprintf( _n( '%d Lesson', '%d Lessons', $lesson_count, 'common-elements-platform' ), $lesson_count ) ); ?>
											</span>
										<?php endif; ?>
										
										<?php if ( ! empty( $course_duration ) ) : ?>
											<span class="ce-learning-course-duration">
												<i class="fas fa-clock"></i>
												<?php echo esc_html( $course_duration ); ?>
											</span>
										<?php endif; ?>
									</div>
									
									<div class="ce-learning-course-actions">
										<a href="<?php the_permalink(); ?>" class="ce-button ce-button-primary">
											<?php
											if ( $course_progress > 0 && $course_progress < 100 ) {
												esc_html_e( 'Continue Learning', 'common-elements-platform' );
											} elseif ( $course_progress == 100 ) {
												esc_html_e( 'Review Course', 'common-elements-platform' );
											} else {
												esc_html_e( 'Start Course', 'common-elements-platform' );
											}
											?>
										</a>
									</div>
								</div>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			<?php endif; ?>
			
			<?php if ( $featured_courses->have_posts() ) : ?>
				<div class="ce-learning-section ce-learning-featured-courses">
					<h2 class="ce-learning-section-title"><?php esc_html_e( 'Featured Courses', 'common-elements-platform' ); ?></h2>
					
					<div class="ce-learning-featured-slider">
						<?php while ( $featured_courses->have_posts() ) : $featured_courses->the_post();
							$course_id = get_the_ID();
							$course_image = get_the_post_thumbnail_url( $course_id, 'large' );
							$course_image = $course_image ? $course_image : COMMON_ELEMENTS_PLATFORM_URL . 'assets/images/course-placeholder.jpg';
							
							$lesson_count = get_post_meta( $course_id, 'course_lesson_count', true );
							$lesson_count = ! empty( $lesson_count ) ? $lesson_count : 0;
							
							$course_duration = get_post_meta( $course_id, 'course_duration', true );
							$course_duration = ! empty( $course_duration ) ? $course_duration : '';
							
							$instructor_id = get_post_meta( $course_id, 'course_instructor', true );
							$instructor_name = $instructor_id ? get_the_author_meta( 'display_name', $instructor_id ) : '';
						?>
							<div class="ce-learning-featured-course">
								<div class="ce-learning-featured-image">
									<img src="<?php echo esc_url( $course_image ); ?>" alt="<?php the_title_attribute(); ?>">
								</div>
								
								<div class="ce-learning-featured-content">
									<h3 class="ce-learning-featured-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									
									<div class="ce-learning-featured-excerpt">
										<?php the_excerpt(); ?>
									</div>
									
									<div class="ce-learning-featured-meta">
										<?php if ( ! empty( $instructor_name ) ) : ?>
											<span class="ce-learning-featured-instructor">
												<i class="fas fa-user"></i>
												<?php echo esc_html( $instructor_name ); ?>
											</span>
										<?php endif; ?>
										
										<?php if ( ! empty( $lesson_count ) ) : ?>
											<span class="ce-learning-featured-lessons">
												<i class="fas fa-book"></i>
												<?php echo esc_html( sprintf( _n( '%d Lesson', '%d Lessons', $lesson_count, 'common-elements-platform' ), $lesson_count ) ); ?>
											</span>
										<?php endif; ?>
										
										<?php if ( ! empty( $course_duration ) ) : ?>
											<span class="ce-learning-featured-duration">
												<i class="fas fa-clock"></i>
												<?php echo esc_html( $course_duration ); ?>
											</span>
										<?php endif; ?>
									</div>
									
									<div class="ce-learning-featured-actions">
										<a href="<?php the_permalink(); ?>" class="ce-button ce-button-primary">
											<?php esc_html_e( 'View Course', 'common-elements-platform' ); ?>
										</a>
									</div>
								</div>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			<?php endif; ?>
			
			<div class="ce-learning-section ce-learning-categories">
				<h2 class="ce-learning-section-title"><?php esc_html_e( 'Course Categories', 'common-elements-platform' ); ?></h2>
				
				<div class="ce-learning-categories-grid">
					<?php
					if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
						foreach ( $categories as $category ) {
							$category_icon = get_term_meta( $category->term_id, 'category_icon', true );
							$category_icon = ! empty( $category_icon ) ? $category_icon : 'fas fa-folder';
							
							$category_color = get_term_meta( $category->term_id, 'category_color', true );
							$category_color = ! empty( $category_color ) ? $category_color : '#0073aa';
							
							$course_count = new WP_Query( array(
								'post_type' => 'course',
								'posts_per_page' => -1,
								'tax_query' => array(
									array(
										'taxonomy' => 'course_category',
										'field' => 'term_id',
										'terms' => $category->term_id,
									),
								),
							) );
							
							$course_count = $course_count->found_posts;
							?>
							<div class="ce-learning-category-card">
								<div class="ce-learning-category-icon" style="background-color: <?php echo esc_attr( $category_color ); ?>;">
									<i class="<?php echo esc_attr( $category_icon ); ?>"></i>
								</div>
								
								<div class="ce-learning-category-content">
									<h3 class="ce-learning-category-title">
										<a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
									</h3>
									
									<div class="ce-learning-category-count">
										<?php echo esc_html( sprintf( _n( '%d Course', '%d Courses', $course_count, 'common-elements-platform' ), $course_count ) ); ?>
									</div>
									
									<?php if ( ! empty( $category->description ) ) : ?>
										<div class="ce-learning-category-description">
											<?php echo wp_kses_post( $category->description ); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<?php
						}
					} else {
						?>
						<div class="ce-learning-no-categories">
							<p><?php esc_html_e( 'No course categories found.', 'common-elements-platform' ); ?></p>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			
			<?php if ( $recent_courses->have_posts() ) : ?>
				<div class="ce-learning-section ce-learning-recent-courses">
					<h2 class="ce-learning-section-title"><?php esc_html_e( 'Recent Courses', 'common-elements-platform' ); ?></h2>
					
					<div class="ce-learning-courses-grid">
						<?php while ( $recent_courses->have_posts() ) : $recent_courses->the_post();
							$course_id = get_the_ID();
							$course_image = get_the_post_thumbnail_url( $course_id, 'medium' );
							$course_image = $course_image ? $course_image : COMMON_ELEMENTS_PLATFORM_URL . 'assets/images/course-placeholder.jpg';
							
							$lesson_count = get_post_meta( $course_id, 'course_lesson_count', true );
							$lesson_count = ! empty( $lesson_count ) ? $lesson_count : 0;
							
							$course_duration = get_post_meta( $course_id, 'course_duration', true );
							$course_duration = ! empty( $course_duration ) ? $course_duration : '';
							
							$course_categories = get_the_terms( $course_id, 'course_category' );
						?>
							<div class="ce-learning-course-card">
								<div class="ce-learning-course-image">
									<img src="<?php echo esc_url( $course_image ); ?>" alt="<?php the_title_attribute(); ?>">
									
									<?php if ( ! is_wp_error( $course_categories ) && ! empty( $course_categories ) ) : ?>
										<div class="ce-learning-course-categories">
											<?php foreach ( $course_categories as $course_category ) : ?>
												<a href="<?php echo esc_url( get_term_link( $course_category ) ); ?>" class="ce-learning-course-category">
													<?php echo esc_html( $course_category->name ); ?>
												</a>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</div>
								
								<div class="ce-learning-course-content">
									<h3 class="ce-learning-course-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									
									<div class="ce-learning-course-meta">
										<?php if ( ! empty( $lesson_count ) ) : ?>
											<span class="ce-learning-course-lessons">
												<i class="fas fa-book"></i>
												<?php echo esc_html( sprintf( _n( '%d Lesson', '%d Lessons', $lesson_count, 'common-elements-platform' ), $lesson_count ) ); ?>
											</span>
										<?php endif; ?>
										
										<?php if ( ! empty( $course_duration ) ) : ?>
											<span class="ce-learning-course-duration">
												<i class="fas fa-clock"></i>
												<?php echo esc_html( $course_duration ); ?>
											</span>
										<?php endif; ?>
									</div>
									
									<div class="ce-learning-course-excerpt">
										<?php the_excerpt(); ?>
									</div>
									
									<div class="ce-learning-course-actions">
										<a href="<?php the_permalink(); ?>" class="ce-button ce-button-primary">
											<?php esc_html_e( 'View Course', 'common-elements-platform' ); ?>
										</a>
									</div>
								</div>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
