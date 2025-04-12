<?php
/**
 * Course Catalog Template
 *
 * This template displays a list of available courses in the Learning Hub.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Get courses from the query
global $query;
if ( ! isset( $query ) ) {
    $query = $GLOBALS['wp_query'];
}
?>

<div class="ce-learning-hub">
    <div class="ce-container">
        <div class="ce-section">
            <div class="ce-section-header">
                <h1 class="ce-section-title">Learning Hub</h1>
                <p class="ce-section-description">Explore our comprehensive courses designed for community association professionals, board members, and vendors.</p>
            </div>
            
            <div class="ce-card">
                <div class="ce-card-header">
                    <div class="ce-card-title">Course Categories</div>
                </div>
                <div class="ce-card-body">
                    <div class="ce-category-filters">
                        <div class="row">
                            <?php
                            $categories = get_terms( array(
                                'taxonomy' => 'course_category',
                                'hide_empty' => false,
                            ) );
                            
                            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                                foreach ( $categories as $category ) :
                                    $category_icon = get_term_meta( $category->term_id, 'category_icon', true );
                                    $icon_class = ! empty( $category_icon ) ? $category_icon : 'fa-book';
                            ?>
                                <div class="col-md-4 col-sm-6">
                                    <a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="ce-category-card">
                                        <div class="ce-category-icon">
                                            <i class="fas <?php echo esc_attr( $icon_class ); ?>"></i>
                                        </div>
                                        <div class="ce-category-content">
                                            <h3 class="ce-category-title"><?php echo esc_html( $category->name ); ?></h3>
                                            <div class="ce-category-description"><?php echo wp_kses_post( $category->description ); ?></div>
                                            <div class="ce-category-count"><?php echo esc_html( $category->count ); ?> Courses</div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ce-section">
                <h2 class="ce-section-title">Featured Courses</h2>
                
                <div class="ce-courses-grid">
                    <?php
                    $featured_args = array(
                        'post_type' => 'mpcs-course',
                        'posts_per_page' => 3,
                        'meta_query' => array(
                            array(
                                'key' => 'featured_course',
                                'value' => '1',
                                'compare' => '=',
                            ),
                        ),
                    );
                    
                    $featured_courses = new WP_Query( $featured_args );
                    
                    if ( $featured_courses->have_posts() ) :
                        while ( $featured_courses->have_posts() ) : $featured_courses->the_post();
                            $course_id = get_the_ID();
                            $instructor = get_post_meta( $course_id, 'course_instructor', true );
                            $duration = get_post_meta( $course_id, 'course_duration', true );
                            $enrolled = get_post_meta( $course_id, 'course_enrolled', true );
                            $thumbnail = get_the_post_thumbnail_url( $course_id, 'large' );
                            if ( empty( $thumbnail ) ) {
                                $thumbnail = 'https://via.placeholder.com/600x400';
                            }
                    ?>
                        <div class="ce-course-card">
                            <div class="ce-course-image">
                                <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title_attribute(); ?>">
                                <div class="ce-course-badge">Featured</div>
                            </div>
                            <div class="ce-course-body">
                                <h3 class="ce-course-title"><?php the_title(); ?></h3>
                                <?php if ( ! empty( $instructor ) ) : ?>
                                    <div class="ce-course-instructor">By <?php echo esc_html( $instructor ); ?></div>
                                <?php endif; ?>
                                <div class="ce-course-description"><?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?></div>
                                <div class="ce-course-meta">
                                    <?php if ( ! empty( $enrolled ) ) : ?>
                                        <span><i class="fas fa-users"></i> <?php echo esc_html( $enrolled ); ?> Enrolled</span>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $duration ) ) : ?>
                                        <span><i class="fas fa-clock"></i> <?php echo esc_html( $duration ); ?></span>
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
                    endif;
                    ?>
                </div>
            </div>
            
            <div class="ce-section">
                <h2 class="ce-section-title">All Courses</h2>
                
                <div class="ce-card">
                    <div class="ce-card-header">
                        <div class="ce-card-title">Browse Courses</div>
                    </div>
                    <div class="ce-card-body">
                        <div class="ce-course-filters">
                            <form action="<?php echo esc_url( home_url( '/learning-hub' ) ); ?>" method="get" class="ce-filter-form">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="ce-form-group">
                                            <label class="ce-form-label">Category</label>
                                            <select name="category" class="ce-form-select">
                                                <option value="">All Categories</option>
                                                <?php
                                                if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                                                    foreach ( $categories as $category ) {
                                                        $selected = isset( $_GET['category'] ) && $_GET['category'] === $category->slug ? 'selected' : '';
                                                        echo '<option value="' . esc_attr( $category->slug ) . '" ' . $selected . '>' . esc_html( $category->name ) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="ce-form-group">
                                            <label class="ce-form-label">Sort By</label>
                                            <select name="orderby" class="ce-form-select">
                                                <option value="date" <?php selected( ! isset( $_GET['orderby'] ) || $_GET['orderby'] === 'date' ); ?>>Newest First</option>
                                                <option value="title" <?php selected( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'title' ); ?>>Title</option>
                                                <option value="popularity" <?php selected( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'popularity' ); ?>>Popularity</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="ce-form-group">
                                            <label class="ce-form-label">&nbsp;</label>
                                            <button type="submit" class="ce-btn ce-btn-primary ce-btn-block">Apply Filters</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <?php if ( $query->have_posts() ) : ?>
                            <div class="ce-courses-list">
                                <?php while ( $query->have_posts() ) : $query->the_post(); 
                                    $course_id = get_the_ID();
                                    $instructor = get_post_meta( $course_id, 'course_instructor', true );
                                    $duration = get_post_meta( $course_id, 'course_duration', true );
                                    $enrolled = get_post_meta( $course_id, 'course_enrolled', true );
                                    $thumbnail = get_the_post_thumbnail_url( $course_id, 'medium' );
                                    if ( empty( $thumbnail ) ) {
                                        $thumbnail = 'https://via.placeholder.com/300x200';
                                    }
                                    
                                    // Get course categories
                                    $course_categories = get_the_terms( $course_id, 'course_category' );
                                    $category_names = array();
                                    if ( ! empty( $course_categories ) && ! is_wp_error( $course_categories ) ) {
                                        foreach ( $course_categories as $category ) {
                                            $category_names[] = $category->name;
                                        }
                                    }
                                ?>
                                    <div class="ce-course-item">
                                        <div class="ce-course-item-image">
                                            <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title_attribute(); ?>">
                                        </div>
                                        <div class="ce-course-item-content">
                                            <h3 class="ce-course-item-title"><?php the_title(); ?></h3>
                                            <?php if ( ! empty( $instructor ) ) : ?>
                                                <div class="ce-course-item-instructor">By <?php echo esc_html( $instructor ); ?></div>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $category_names ) ) : ?>
                                                <div class="ce-course-item-categories">
                                                    <?php echo esc_html( implode( ', ', $category_names ) ); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="ce-course-item-description"><?php echo wp_trim_words( get_the_excerpt(), 30, '...' ); ?></div>
                                            <div class="ce-course-item-meta">
                                                <?php if ( ! empty( $enrolled ) ) : ?>
                                                    <span><i class="fas fa-users"></i> <?php echo esc_html( $enrolled ); ?> Enrolled</span>
                                                <?php endif; ?>
                                                <?php if ( ! empty( $duration ) ) : ?>
                                                    <span><i class="fas fa-clock"></i> <?php echo esc_html( $duration ); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="ce-course-item-actions">
                                            <a href="<?php the_permalink(); ?>" class="ce-btn ce-btn-primary">View Course</a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                            
                            <?php
                            // Pagination
                            $big = 999999999;
                            echo '<div class="ce-pagination">';
                            echo paginate_links( array(
                                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'format' => '?paged=%#%',
                                'current' => max( 1, get_query_var( 'paged' ) ),
                                'total' => $query->max_num_pages,
                                'prev_text' => '&laquo; Previous',
                                'next_text' => 'Next &raquo;',
                            ) );
                            echo '</div>';
                            ?>
                            
                        <?php else : ?>
                            <div class="ce-alert ce-alert-info">
                                <p>No courses found matching your criteria. Please try different filters or check back later.</p>
                            </div>
                        <?php endif; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
            
            <div class="ce-section">
                <h2 class="ce-section-title">Learning Paths</h2>
                
                <div class="ce-learning-paths-grid">
                    <div class="ce-learning-path-card">
                        <div class="ce-learning-path-header">
                            <div class="ce-learning-path-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h3 class="ce-learning-path-title">Board Member Certification</h3>
                        </div>
                        <div class="ce-learning-path-body">
                            <p class="ce-learning-path-description">Complete this learning path to become a certified board member. Learn about governance, financial management, and legal responsibilities.</p>
                            <div class="ce-learning-path-stats">
                                <div class="ce-learning-path-stat">
                                    <div class="ce-learning-path-stat-value">5</div>
                                    <div class="ce-learning-path-stat-label">Courses</div>
                                </div>
                                <div class="ce-learning-path-stat">
                                    <div class="ce-learning-path-stat-value">15</div>
                                    <div class="ce-learning-path-stat-label">Hours</div>
                                </div>
                                <div class="ce-learning-path-stat">
                                    <div class="ce-learning-path-stat-value">1</div>
                                    <div class="ce-learning-path-stat-label">Certificate</div>
                                </div>
                            </div>
                        </div>
                        <div class="ce-learning-path-footer">
                            <a href="#" class="ce-btn ce-btn-primary">View Path</a>
                        </div>
                    </div>
                    
                    <div class="ce-learning-path-card">
                        <div class="ce-learning-path-header">
                            <div class="ce-learning-path-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h3 class="ce-learning-path-title">CAM Professional Development</h3>
                        </div>
                        <div class="ce-learning-path-body">
                            <p class="ce-learning-path-description">Enhance your skills as a Community Association Manager with courses on conflict resolution, project management, and resident relations.</p>
                            <div class="ce-learning-path-stats">
                                <div class="ce-learning-path-stat">
                                    <div class="ce-learning-path-stat-value">7</div>
                                    <div class="ce-learning-path-stat-label">Courses</div>
                                </div>
                                <div class="ce-learning-path-stat">
                                    <div class="ce-learning-path-stat-value">20</div>
                                    <div class="ce-learning-path-stat-label">Hours</div>
                                </div>
                                <div class="ce-learning-path-stat">
                                    <div class="ce-learning-path-stat-value">2</div>
                                    <div class="ce-learning-path-stat-label">Certificates</div>
                                </div>
                            </div>
                        </div>
                        <div class="ce-learning-path-footer">
                            <a href="#" class="ce-btn ce-btn-primary">View Path</a>
                        </div>
                    </div>
                    
                    <div class="ce-learning-path-card">
                        <div class="ce-learning-path-header">
                            <div class="ce-learning-path-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h3 class="ce-learning-path-title">Vendor Excellence Program</h3>
                        </div>
                        <div class="ce-learning-path-body">
                            <p class="ce-learning-path-description">Learn how to effectively work with HOAs and community associations to build long-term relationships and grow your business.</p>
                            <div class="ce-learning-path-stats">
                                <div class="ce-learning-path-stat">
                                    <div class="ce-learning-path-stat-value">4</div>
                                    <div class="ce-learning-path-stat-label">Courses</div>
                                </div>
                                <div class="ce-learning-path-stat">
                                    <div class="ce-learning-path-stat-value">12</div>
                                    <div class="ce-learning-path-stat-label">Hours</div>
                                </div>
                                <div class="ce-learning-path-stat">
                                    <div class="ce-learning-path-stat-value">1</div>
                                    <div class="ce-learning-path-stat-label">Certificate</div>
                                </div>
                            </div>
                        </div>
                        <div class="ce-learning-path-footer">
                            <a href="#" class="ce-btn ce-btn-primary">View Path</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
