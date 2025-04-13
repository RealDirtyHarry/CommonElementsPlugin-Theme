<?php
/**
 * Template for RFP Listing
 *
 * @package Common_Elements_Platform
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="ce-rfp-listing">
			<div class="ce-rfp-header">
				<h1><?php esc_html_e( 'Request for Proposals', 'common-elements-platform' ); ?></h1>
				
				<?php if ( is_user_logged_in() && current_user_can( 'publish_posts' ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/submit-rfp/' ) ); ?>" class="ce-button ce-button-primary">
						<i class="fas fa-plus"></i>
						<?php esc_html_e( 'Submit New RFP', 'common-elements-platform' ); ?>
					</a>
				<?php endif; ?>
			</div>
			
			<div class="ce-rfp-filter">
				<div class="ce-rfp-filter-row">
					<div class="ce-rfp-filter-item">
						<label for="ce-rfp-filter-category"><?php esc_html_e( 'Category', 'common-elements-platform' ); ?></label>
						<select id="ce-rfp-filter-category" class="ce-rfp-filter-category">
							<option value=""><?php esc_html_e( 'All Categories', 'common-elements-platform' ); ?></option>
							<?php
							$categories = get_terms( array(
								'taxonomy' => 'rfp_category',
								'hide_empty' => true,
							) );
							
							if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
								foreach ( $categories as $category ) {
									echo '<option value="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</option>';
								}
							}
							?>
						</select>
					</div>
					
					<div class="ce-rfp-filter-item">
						<label for="ce-rfp-filter-status"><?php esc_html_e( 'Status', 'common-elements-platform' ); ?></label>
						<select id="ce-rfp-filter-status" class="ce-rfp-filter-status">
							<option value=""><?php esc_html_e( 'All Statuses', 'common-elements-platform' ); ?></option>
							<option value="open"><?php esc_html_e( 'Open', 'common-elements-platform' ); ?></option>
							<option value="closed"><?php esc_html_e( 'Closed', 'common-elements-platform' ); ?></option>
							<option value="awarded"><?php esc_html_e( 'Awarded', 'common-elements-platform' ); ?></option>
						</select>
					</div>
					
					<div class="ce-rfp-filter-item">
						<label for="ce-rfp-filter-sort"><?php esc_html_e( 'Sort By', 'common-elements-platform' ); ?></label>
						<select id="ce-rfp-filter-sort" class="ce-rfp-filter-sort">
							<option value="date_desc"><?php esc_html_e( 'Newest First', 'common-elements-platform' ); ?></option>
							<option value="date_asc"><?php esc_html_e( 'Oldest First', 'common-elements-platform' ); ?></option>
							<option value="deadline_asc"><?php esc_html_e( 'Deadline (Soonest)', 'common-elements-platform' ); ?></option>
							<option value="deadline_desc"><?php esc_html_e( 'Deadline (Latest)', 'common-elements-platform' ); ?></option>
						</select>
					</div>
				</div>
			</div>
			
			<div class="ce-rfp-list">
				<?php
				$args = array(
					'post_type' => 'rfp',
					'posts_per_page' => 10,
					'paged' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
				);
				
				$rfp_query = new WP_Query( $args );
				
				if ( $rfp_query->have_posts() ) :
					while ( $rfp_query->have_posts() ) :
						$rfp_query->the_post();
						
						$deadline = get_post_meta( get_the_ID(), 'rfp_deadline', true );
						$community = get_post_meta( get_the_ID(), 'rfp_community', true );
						$status = get_post_meta( get_the_ID(), 'rfp_status', true );
						
						$categories = wp_get_object_terms( get_the_ID(), 'rfp_category' );
						$category_name = ! empty( $categories ) ? $categories[0]->name : __( 'Uncategorized', 'common-elements-platform' );
						
						$deadline_formatted = ! empty( $deadline ) ? date_i18n( get_option( 'date_format' ), strtotime( $deadline ) ) : '';
						
						$status_class = 'ce-rfp-status-' . sanitize_html_class( $status );
						
						$image_url = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
						if ( empty( $image_url ) ) {
							$image_url = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/placeholder.jpg';
						}
						
						$excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 20 );
						?>
						
						<div class="info-card rfp-card">
							<div class="info-card-image">
								<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>">
							</div>
							<div class="info-card-content">
								<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--spacing-sm);">
									<h3 class="info-card-title"><?php the_title(); ?></h3>
									<span class="info-card-badge"><?php echo esc_html( $category_name ); ?></span>
								</div>
								
								<div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
									<div class="info-card-budget">
										<i class="fas fa-dollar-sign" style="margin-right: 4px;"></i> <?php esc_html_e( 'Budget:', 'common-elements-platform' ); ?> <?php esc_html_e( 'Contact for details', 'common-elements-platform' ); ?>
									</div>
									
									<div class="info-card-due-date">
										<i class="fas fa-calendar-alt" style="margin-right: 4px;"></i> <?php esc_html_e( 'Due:', 'common-elements-platform' ); ?> <?php echo esc_html( $deadline_formatted ); ?>
									</div>
								</div>
								
								<p class="info-card-description"><?php echo esc_html( $excerpt ); ?></p>
								
								<div class="info-card-meta">
									<span><i class="fas fa-building" style="color: var(--secondary-color);"></i> <?php echo esc_html( $community ); ?></span>
									<span><i class="fas fa-map-marker-alt" style="color: var(--secondary-color);"></i> <?php esc_html_e( 'Location:', 'common-elements-platform' ); ?> <?php esc_html_e( 'Various', 'common-elements-platform' ); ?></span>
									<span><i class="fas fa-clock" style="color: var(--secondary-color);"></i> <?php esc_html_e( 'Posted:', 'common-elements-platform' ); ?> <?php echo get_the_date(); ?></span>
								</div>
								
								<div class="info-card-footer">
									<a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline"><?php esc_html_e( 'View Details', 'common-elements-platform' ); ?></a>
									<?php if ( 'open' === $status && is_user_logged_in() ) : ?>
										<a href="<?php the_permalink(); ?>#submit-proposal" class="btn btn-sm btn-secondary"><?php esc_html_e( 'Submit Proposal', 'common-elements-platform' ); ?></a>
									<?php endif; ?>
								</div>
							</div>
						</div>
						
					<?php endwhile; ?>
					
					<div class="ce-pagination">
						<?php
						echo paginate_links( array(
							'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var( 'paged' ) ),
							'total' => $rfp_query->max_num_pages,
							'prev_text' => '<i class="fas fa-chevron-left"></i>',
							'next_text' => '<i class="fas fa-chevron-right"></i>',
						) );
						?>
					</div>
					
				<?php else : ?>
					
					<div class="ce-no-results">
						<i class="fas fa-search"></i>
						<h3><?php esc_html_e( 'No RFPs Found', 'common-elements-platform' ); ?></h3>
						<p><?php esc_html_e( 'No RFPs match your criteria. Try adjusting your filters or check back later.', 'common-elements-platform' ); ?></p>
					</div>
					
				<?php endif; ?>
				
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
