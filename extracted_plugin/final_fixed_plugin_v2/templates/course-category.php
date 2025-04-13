<?php
/**
 * Template for Course Category
 *
 * @package Common_Elements_Platform
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$category_id = get_queried_object_id();
$category = get_term( $category_id, 'course_category' );

if ( ! $category || is_wp_error( $category ) ) {
	wp_redirect( home_url( '/learning-hub/' ) );
	exit;
}

$category_description = term_description( $category_id, 'course_category' );
$category_icon = get_term_meta( $category_id, 'category_icon', true );
$category_icon = ! empty( $category_icon ) ? $category_icon : 'fas fa-folder';
$category_color = get_term_meta( $category_id, 'category_color', true );
$category_color = ! empty( $category_color ) ? $category_color : '#0073aa';

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$courses_per_page = 12;

$courses_query = new WP_Query( array(
	'post_type' => 'course',
	'posts_per_page' => $courses_per_page,
	'paged' => $paged,
	'tax_query' => array(
		array(
			'taxonomy' => 'course_category',
			'field' => 'term_id',
			'terms' => $category_id,
		),
	),
) );

$total_courses = $courses_query->found_posts;
$total_pages = ceil( $total_courses / $courses_per_page );

$subcategories = get_terms( array(
	'taxonomy' => 'course_category',
	'hide_empty' => false,
	'parent' => $category_id,
) );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="ce-learning-category-container">
			<div class="ce-learning-breadcrumbs">
				<a href="<?php echo esc_url( home_url( '/learning-hub/' ) ); ?>">
					<i class="fas fa-home"></i>
					<?php esc_html_e( 'Learning Hub', 'common-elements-platform' ); ?>
				</a>
				
				<?php
				$parent_category = null;
				if ( $category->parent ) {
					$parent_category = get_term( $category->parent, 'course_category' );
					
					if ( $parent_category && ! is_wp_error( $parent_category ) ) :
					?>
						<span class="ce-breadcrumb-separator">
							<i class="fas fa-chevron-right"></i>
						</span>
						<a href="<?php echo esc_url( get_term_link( $parent_category ) ); ?>">
							<?php echo esc_html( $parent_category->name ); ?>
						</a>
					<?php
					endif;
				}
				?>
				
				<span class="ce-breadcrumb-separator">
					<i class="fas fa-chevron-right"></i>
				</span>
				<span class="ce-breadcrumb-current"><?php echo esc_html( $category->name ); ?></span>
			</div>
			
			<div class="ce-learning-category-header">
				<div class="ce-learning-category-icon" style="background-color: <?php echo esc_attr( $category_color ); ?>;">
					<i class="<?php echo esc_attr( $category_icon ); ?>"></i>
				</div>
				
				<div class="ce-learning-category-info">
					<h1 class="ce-learning-category-title"><?php echo esc_html( $category->name ); ?></h1>
					
					<?php if ( ! empty( $category_description ) ) : ?>
						<div class="ce-learning-category-description">
							<?php echo wp_kses_post( $category_description ); ?>
						</div>
					<?php endif; ?>
					
					<div class="ce-learning-category-meta">
						<span class="ce-learning-category-count">
							<i class="fas fa-book"></i>
							<?php echo esc_html( sprintf( _n( '%d Course', '%d Courses', $total_courses, 'common-elements-platform' ), $total_courses ) ); ?>
						</span>
					</div>
				</div>
			</div>
			
			<?php if ( ! empty( $subcategories ) && ! is_wp_error( $subcategories ) ) : ?>
				<div class="ce-learning-subcategories">
					<h2 class="ce-learning-section-title"><?php esc_html_e( 'Subcategories', 'common-elements-platform' ); ?></h2>
					
					<div class="ce-learning-categories-grid">
						<?php foreach ( $subcategories as $subcategory ) :
							$subcategory_icon = get_term_meta( $subcategory->term_id, 'category_icon', true );
							$subcategory_icon = ! empty( $subcategory_icon ) ? $subcategory_icon : 'fas fa-folder';
							
							$subcategory_color = get_term_meta( $subcategory->term_id, 'category_color', true );
							$subcategory_color = ! empty( $subcategory_color ) ? $subcategory_color : '#0073aa';
							
							$subcategory_course_count = new WP_Query( array(
								'post_type' => 'course',
								'posts_per_page' => -1,
								'tax_query' => array(
									array(
										'taxonomy' => 'course_category',
										'field' => 'term_id',
										'terms' => $subcategory->term_id,
									),
								),
							) );
							
							$subcategory_course_count = $subcategory_course_count->found_posts;
						?>
							<div class="ce-learning-category-card">
								<div class="ce-learning-category-icon" style="background-color: <?php echo esc_attr( $subcategory_color ); ?>;">
									<i class="<?php echo esc_attr( $subcategory_icon ); ?>"></i>
								</div>
								
								<div class="ce-learning-category-content">
									<h3 class="ce-learning-category-title">
										<a href="<?php echo esc_url( get_term_link( $subcategory ) ); ?>"><?php echo esc_html( $subcategory->name ); ?></a>
									</h3>
									
									<div class="ce-learning-category-count">
										<?php echo esc_html( sprintf( _n( '%d Course', '%d Courses', $subcategory_course_count, 'common-elements-platform' ), $subcategory_course_count ) ); ?>
									</div>
									
									<?php if ( ! empty( $subcategory->description ) ) : ?>
										<div class="ce-learning-category-description">
											<?php echo wp_kses_post( $subcategory->description ); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<div class="ce-learning-category-courses">
				<h2 class="ce-learning-section-title"><?php esc_html_e( 'Courses', 'common-elements-platform' ); ?></h2>
				
				<?php if ( $courses_query->have_posts() ) : ?>
					<div class="ce-learning-courses-grid">
						<?php while ( $courses_query->have_posts() ) : $courses_query->the_post();
							$course_id = get_the_ID();
							$course_image = get_the_post_thumbnail_url( $course_id, 'medium' );
							$course_image = $course_image ? $course_image : COMMON_ELEMENTS_PLATFORM_URL . 'assets/images/course-placeholder.jpg';
							
							$lesson_count = get_post_meta( $course_id, 'course_lesson_count', true );
							$lesson_count = ! empty( $lesson_count ) ? $lesson_count : 0;
							
							$course_duration = get_post_meta( $course_id, 'course_duration', true );
							$course_duration = ! empty( $course_duration ) ? $course_duration : '';
							
							$instructor_id = get_post_meta( $course_id, 'course_instructor', true );
							$instructor_name = $instructor_id ? get_the_author_meta( 'display_name', $instructor_id ) : '';
						?>
							<div class="ce-learning-course-card">
								<div class="ce-learning-course-image">
									<img src="<?php echo esc_url( $course_image ); ?>" alt="<?php the_title_attribute(); ?>">
								</div>
								
								<div class="ce-learning-course-content">
									<h3 class="ce-learning-course-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									
									<div class="ce-learning-course-meta">
										<?php if ( ! empty( $instructor_name ) ) : ?>
											<span class="ce-learning-course-instructor">
												<i class="fas fa-user"></i>
												<?php echo esc_html( $instructor_name ); ?>
											</span>
										<?php endif; ?>
										
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
					
					<?php if ( $total_pages > 1 ) : ?>
						<div class="ce-learning-pagination">
							<?php
							echo paginate_links( array(
								'base' => get_pagenum_link(1) . '%_%',
								'format' => 'page/%#%',
								'current' => $paged,
								'total' => $total_pages,
								'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __( 'Previous', 'common-elements-platform' ),
								'next_text' => __( 'Next', 'common-elements-platform' ) . ' <i class="fas fa-chevron-right"></i>',
							) );
							?>
						</div>
					<?php endif; ?>
				<?php else : ?>
					<div class="ce-learning-no-courses">
						<p><?php esc_html_e( 'No courses found in this category.', 'common-elements-platform' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
