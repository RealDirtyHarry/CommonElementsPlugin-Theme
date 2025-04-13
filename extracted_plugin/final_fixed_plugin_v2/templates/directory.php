<?php
/**
 * Template for Directory
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
		<div class="ce-directory-container">
			<div class="ce-directory-header">
				<h1 class="ce-directory-title"><?php esc_html_e( 'Community Directory', 'common-elements-platform' ); ?></h1>
				
				<div class="ce-directory-search">
					<form id="ce-directory-search-form" class="ce-search-form">
						<div class="ce-search-input-wrapper">
							<input type="text" class="ce-directory-search-input" placeholder="<?php esc_attr_e( 'Search directory...', 'common-elements-platform' ); ?>">
							<button type="submit" class="ce-search-button">
								<i class="fas fa-search"></i>
							</button>
						</div>
					</form>
				</div>
			</div>
			
			<div class="ce-directory-filters">
				<div class="ce-directory-filter">
					<label for="ce-directory-filter-category"><?php esc_html_e( 'Category', 'common-elements-platform' ); ?></label>
					<select id="ce-directory-filter-category" class="ce-directory-filter-category">
						<option value=""><?php esc_html_e( 'All Categories', 'common-elements-platform' ); ?></option>
						<?php
						$categories = get_terms( array(
							'taxonomy' => 'directory_category',
							'hide_empty' => false,
						) );
						
						if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
							foreach ( $categories as $category ) {
								echo '<option value="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="ce-directory-filter">
					<label for="ce-directory-filter-location"><?php esc_html_e( 'Location', 'common-elements-platform' ); ?></label>
					<select id="ce-directory-filter-location" class="ce-directory-filter-location">
						<option value=""><?php esc_html_e( 'All Locations', 'common-elements-platform' ); ?></option>
						<?php
						$locations = get_terms( array(
							'taxonomy' => 'directory_location',
							'hide_empty' => false,
						) );
						
						if ( ! is_wp_error( $locations ) && ! empty( $locations ) ) {
							foreach ( $locations as $location ) {
								echo '<option value="' . esc_attr( $location->slug ) . '">' . esc_html( $location->name ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="ce-directory-filter">
					<label for="ce-directory-filter-sort"><?php esc_html_e( 'Sort By', 'common-elements-platform' ); ?></label>
					<select id="ce-directory-filter-sort" class="ce-directory-filter-sort">
						<option value="title"><?php esc_html_e( 'Name (A-Z)', 'common-elements-platform' ); ?></option>
						<option value="title-desc"><?php esc_html_e( 'Name (Z-A)', 'common-elements-platform' ); ?></option>
						<option value="date"><?php esc_html_e( 'Newest First', 'common-elements-platform' ); ?></option>
						<option value="date-asc"><?php esc_html_e( 'Oldest First', 'common-elements-platform' ); ?></option>
					</select>
				</div>
				
				<div class="ce-directory-view-toggle">
					<button class="ce-view-toggle-button ce-view-list active" data-view="list">
						<i class="fas fa-list"></i>
					</button>
					<button class="ce-view-toggle-button ce-view-grid" data-view="grid">
						<i class="fas fa-th"></i>
					</button>
					<button class="ce-view-toggle-button ce-view-map" data-view="map">
						<i class="fas fa-map-marker-alt"></i>
					</button>
				</div>
			</div>
			
			<div class="ce-directory-content">
				<div class="ce-directory-list-view active">
					<?php
					$args = array(
						'post_type' => 'directory_listing',
						'posts_per_page' => 10,
						'paged' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
					);
					
					$directory_query = new WP_Query( $args );
					
					if ( $directory_query->have_posts() ) :
					?>
						<div class="ce-directory-list">
							<?php
							while ( $directory_query->have_posts() ) :
								$directory_query->the_post();
								
								$address = get_post_meta( get_the_ID(), 'directory_address', true );
								$phone = get_post_meta( get_the_ID(), 'directory_phone', true );
								$email = get_post_meta( get_the_ID(), 'directory_email', true );
								$website = get_post_meta( get_the_ID(), 'directory_website', true );
								$lat = get_post_meta( get_the_ID(), 'directory_lat', true );
								$lng = get_post_meta( get_the_ID(), 'directory_lng', true );
								
								$categories = wp_get_object_terms( get_the_ID(), 'directory_category' );
								$category_names = array();
								if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
									foreach ( $categories as $category ) {
										$category_names[] = $category->name;
									}
								}
							?>
								<div class="ce-directory-item" data-lat="<?php echo esc_attr( $lat ); ?>" data-lng="<?php echo esc_attr( $lng ); ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="ce-directory-item-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'medium' ); ?>
											</a>
										</div>
									<?php endif; ?>
									
									<div class="ce-directory-item-content">
										<h2 class="ce-directory-item-title">
											<a href="<?php the_permalink(); ?>" class="ce-directory-item-link"><?php the_title(); ?></a>
										</h2>
										
										<?php if ( ! empty( $category_names ) ) : ?>
											<div class="ce-directory-item-categories">
												<?php foreach ( $category_names as $category_name ) : ?>
													<span class="ce-directory-item-category"><?php echo esc_html( $category_name ); ?></span>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
										
										<div class="ce-directory-item-description">
											<?php the_excerpt(); ?>
										</div>
										
										<div class="ce-directory-item-details">
											<?php if ( ! empty( $address ) ) : ?>
												<div class="ce-directory-item-detail ce-directory-item-address">
													<i class="fas fa-map-marker-alt"></i>
													<span><?php echo esc_html( $address ); ?></span>
												</div>
											<?php endif; ?>
											
											<?php if ( ! empty( $phone ) ) : ?>
												<div class="ce-directory-item-detail">
													<i class="fas fa-phone"></i>
													<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
												</div>
											<?php endif; ?>
											
											<?php if ( ! empty( $email ) ) : ?>
												<div class="ce-directory-item-detail">
													<i class="fas fa-envelope"></i>
													<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
												</div>
											<?php endif; ?>
											
											<?php if ( ! empty( $website ) ) : ?>
												<div class="ce-directory-item-detail">
													<i class="fas fa-globe"></i>
													<a href="<?php echo esc_url( $website ); ?>" target="_blank"><?php echo esc_html( $website ); ?></a>
												</div>
											<?php endif; ?>
										</div>
									</div>
									
									<div class="ce-directory-item-actions">
										<a href="<?php the_permalink(); ?>" class="ce-button ce-button-primary">
											<i class="fas fa-info-circle"></i>
											<?php esc_html_e( 'View Details', 'common-elements-platform' ); ?>
										</a>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
						
						<div class="ce-directory-pagination">
							<?php
							$big = 999999999;
							echo paginate_links( array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var( 'paged' ) ),
								'total' => $directory_query->max_num_pages,
								'prev_text' => '<i class="fas fa-chevron-left"></i>',
								'next_text' => '<i class="fas fa-chevron-right"></i>',
							) );
							?>
						</div>
						
						<?php wp_reset_postdata(); ?>
					<?php else : ?>
						<div class="ce-directory-no-results">
							<p><?php esc_html_e( 'No directory listings found.', 'common-elements-platform' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
				
				<div class="ce-directory-map-view">
					<div id="ce-directory-map" data-lat="<?php echo esc_attr( get_option( 'ce_directory_default_lat', '37.7749' ) ); ?>" data-lng="<?php echo esc_attr( get_option( 'ce_directory_default_lng', '-122.4194' ) ); ?>" data-zoom="<?php echo esc_attr( get_option( 'ce_directory_default_zoom', '12' ) ); ?>"></div>
				</div>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<script>
jQuery(document).ready(function($) {
	$('.ce-view-toggle-button').on('click', function() {
		const view = $(this).data('view');
		
		$('.ce-view-toggle-button').removeClass('active');
		$(this).addClass('active');
		
		$('.ce-directory-list-view, .ce-directory-map-view').removeClass('active');
		
		if (view === 'map') {
			$('.ce-directory-map-view').addClass('active');
			initMap();
		} else {
			$('.ce-directory-list-view').addClass('active');
			
			if (view === 'grid') {
				$('.ce-directory-list').addClass('ce-directory-grid');
			} else {
				$('.ce-directory-list').removeClass('ce-directory-grid');
			}
		}
	});
	
	function initMap() {
		const $mapContainer = $('#ce-directory-map');
		
		if ($mapContainer.length && typeof google !== 'undefined' && google.maps) {
			const map = new google.maps.Map($mapContainer[0], {
				center: { lat: parseFloat($mapContainer.data('lat')), lng: parseFloat($mapContainer.data('lng')) },
				zoom: parseInt($mapContainer.data('zoom')),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			
			$('.ce-directory-item').each(function() {
				const $item = $(this);
				const lat = parseFloat($item.data('lat'));
				const lng = parseFloat($item.data('lng'));
				
				if (lat && lng) {
					const marker = new google.maps.Marker({
						position: { lat: lat, lng: lng },
						map: map,
						title: $item.find('.ce-directory-item-title').text()
					});
					
					const infoWindow = new google.maps.InfoWindow({
						content: '<div class="ce-map-info-window">' +
								'<h3>' + $item.find('.ce-directory-item-title').text() + '</h3>' +
								'<p>' + $item.find('.ce-directory-item-address').text() + '</p>' +
								'<a href="' + $item.find('.ce-directory-item-link').attr('href') + '">View Details</a>' +
								'</div>'
					});
					
					marker.addListener('click', function() {
						infoWindow.open(map, marker);
					});
				}
			});
		}
	}
	
	if ($('.ce-view-map').length && (typeof google === 'undefined' || typeof google.maps === 'undefined')) {
		$.getScript('https://maps.googleapis.com/maps/api/js?key=' + common_elements_platform.google_maps_api_key, function() {
		});
	}
	
	$('.ce-directory-filter select').on('change', function() {
		const category = $('.ce-directory-filter-category').val();
		const location = $('.ce-directory-filter-location').val();
		const sort = $('.ce-directory-filter-sort').val();
		
		$.ajax({
			url: common_elements_platform.ajax_url,
			type: 'POST',
			data: {
				action: 'ce_ajax_filter_directory',
				nonce: common_elements_platform.nonce,
				category: category,
				location: location,
				sort: sort
			},
			beforeSend: function() {
				$('.ce-directory-list').addClass('ce-loading');
			},
			success: function(response) {
				if (response.success) {
					$('.ce-directory-list').html(response.data.html);
					
					if (response.data.pagination) {
						$('.ce-directory-pagination').html(response.data.pagination);
					}
				} else {
					console.error('Failed to filter directory');
				}
				$('.ce-directory-list').removeClass('ce-loading');
			},
			error: function() {
				console.error('AJAX error');
				$('.ce-directory-list').removeClass('ce-loading');
			}
		});
	});
	
	$('#ce-directory-search-form').on('submit', function(e) {
		e.preventDefault();
		
		const searchTerm = $('.ce-directory-search-input').val();
		
		$.ajax({
			url: common_elements_platform.ajax_url,
			type: 'POST',
			data: {
				action: 'ce_ajax_search_directory',
				nonce: common_elements_platform.nonce,
				search: searchTerm
			},
			beforeSend: function() {
				$('.ce-directory-list').addClass('ce-loading');
			},
			success: function(response) {
				if (response.success) {
					$('.ce-directory-list').html(response.data.html);
					
					if (response.data.pagination) {
						$('.ce-directory-pagination').html(response.data.pagination);
					}
				} else {
					console.error('Failed to search directory');
				}
				$('.ce-directory-list').removeClass('ce-loading');
			},
			error: function() {
				console.error('AJAX error');
				$('.ce-directory-list').removeClass('ce-loading');
			}
		});
	});
});
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
