<?php
/**
 * Template for Single Directory Listing
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
		<div class="ce-directory-single">
			<?php
			while ( have_posts() ) :
				the_post();
				
				$address = get_post_meta( get_the_ID(), 'directory_address', true );
				$phone = get_post_meta( get_the_ID(), 'directory_phone', true );
				$email = get_post_meta( get_the_ID(), 'directory_email', true );
				$website = get_post_meta( get_the_ID(), 'directory_website', true );
				$hours = get_post_meta( get_the_ID(), 'directory_hours', true );
				$social = get_post_meta( get_the_ID(), 'directory_social', true );
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
				
				<div class="ce-directory-header">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="ce-directory-featured-image">
							<?php the_post_thumbnail( 'large' ); ?>
						</div>
					<?php endif; ?>
					
					<div class="ce-directory-meta">
						<?php if ( ! empty( $category_names ) ) : ?>
							<div class="ce-directory-categories">
								<?php foreach ( $category_names as $category_name ) : ?>
									<span class="ce-directory-category"><?php echo esc_html( $category_name ); ?></span>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
					
					<h1 class="ce-directory-title"><?php the_title(); ?></h1>
					
					<div class="ce-directory-contact-info">
						<?php if ( ! empty( $address ) ) : ?>
							<div class="ce-directory-info-item">
								<i class="fas fa-map-marker-alt"></i>
								<span><?php echo esc_html( $address ); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( ! empty( $phone ) ) : ?>
							<div class="ce-directory-info-item">
								<i class="fas fa-phone"></i>
								<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
							</div>
						<?php endif; ?>
						
						<?php if ( ! empty( $email ) ) : ?>
							<div class="ce-directory-info-item">
								<i class="fas fa-envelope"></i>
								<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
							</div>
						<?php endif; ?>
						
						<?php if ( ! empty( $website ) ) : ?>
							<div class="ce-directory-info-item">
								<i class="fas fa-globe"></i>
								<a href="<?php echo esc_url( $website ); ?>" target="_blank"><?php echo esc_html( $website ); ?></a>
							</div>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="ce-directory-content">
					<div class="ce-directory-main">
						<div class="ce-directory-description">
							<h2><?php esc_html_e( 'About', 'common-elements-platform' ); ?></h2>
							<?php the_content(); ?>
						</div>
						
						<?php if ( ! empty( $hours ) && is_array( $hours ) ) : ?>
							<div class="ce-directory-hours">
								<h2><?php esc_html_e( 'Business Hours', 'common-elements-platform' ); ?></h2>
								<table class="ce-hours-table">
									<?php
									$days = array(
										'monday'    => __( 'Monday', 'common-elements-platform' ),
										'tuesday'   => __( 'Tuesday', 'common-elements-platform' ),
										'wednesday' => __( 'Wednesday', 'common-elements-platform' ),
										'thursday'  => __( 'Thursday', 'common-elements-platform' ),
										'friday'    => __( 'Friday', 'common-elements-platform' ),
										'saturday'  => __( 'Saturday', 'common-elements-platform' ),
										'sunday'    => __( 'Sunday', 'common-elements-platform' ),
									);
									
									foreach ( $days as $day_key => $day_name ) :
										$day_hours = isset( $hours[$day_key] ) ? $hours[$day_key] : '';
										$is_closed = empty( $day_hours ) || $day_hours === 'closed';
									?>
										<tr>
											<td class="ce-hours-day"><?php echo esc_html( $day_name ); ?></td>
											<td class="ce-hours-time <?php echo $is_closed ? 'ce-hours-closed' : ''; ?>">
												<?php
												if ( $is_closed ) {
													esc_html_e( 'Closed', 'common-elements-platform' );
												} else {
													echo esc_html( $day_hours );
												}
												?>
											</td>
										</tr>
									<?php endforeach; ?>
								</table>
							</div>
						<?php endif; ?>
					</div>
					
					<div class="ce-directory-sidebar">
						<?php if ( ! empty( $lat ) && ! empty( $lng ) ) : ?>
							<div class="ce-directory-map">
								<h3><?php esc_html_e( 'Location', 'common-elements-platform' ); ?></h3>
								<div id="ce-directory-map-canvas" data-lat="<?php echo esc_attr( $lat ); ?>" data-lng="<?php echo esc_attr( $lng ); ?>" data-title="<?php echo esc_attr( get_the_title() ); ?>"></div>
							</div>
						<?php endif; ?>
						
						<?php if ( ! empty( $social ) && is_array( $social ) ) : ?>
							<div class="ce-directory-social">
								<h3><?php esc_html_e( 'Connect', 'common-elements-platform' ); ?></h3>
								<div class="ce-social-links">
									<?php foreach ( $social as $platform => $url ) : 
										if ( empty( $url ) ) {
											continue;
										}
										
										$icon_class = 'fa-link';
										switch ( $platform ) {
											case 'facebook':
												$icon_class = 'fa-facebook-f';
												break;
											case 'twitter':
												$icon_class = 'fa-twitter';
												break;
											case 'instagram':
												$icon_class = 'fa-instagram';
												break;
											case 'linkedin':
												$icon_class = 'fa-linkedin-in';
												break;
											case 'youtube':
												$icon_class = 'fa-youtube';
												break;
										}
									?>
										<a href="<?php echo esc_url( $url ); ?>" class="ce-social-link ce-social-<?php echo esc_attr( $platform ); ?>" target="_blank">
											<i class="fab <?php echo esc_attr( $icon_class ); ?>"></i>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
						
						<div class="ce-directory-actions">
							<a href="#" class="ce-button ce-button-secondary ce-directory-share-btn">
								<i class="fas fa-share-alt"></i>
								<?php esc_html_e( 'Share', 'common-elements-platform' ); ?>
							</a>
							
							<a href="#" class="ce-button ce-button-primary ce-directory-contact-btn">
								<i class="fas fa-envelope"></i>
								<?php esc_html_e( 'Contact', 'common-elements-platform' ); ?>
							</a>
						</div>
					</div>
				</div>
				
				<div class="ce-directory-contact-form" style="display: none;">
					<h2><?php esc_html_e( 'Contact', 'common-elements-platform' ); ?> <?php the_title(); ?></h2>
					
					<form id="ce-directory-contact-form">
						<?php wp_nonce_field( 'common_elements_platform_nonce', 'nonce' ); ?>
						<input type="hidden" name="listing_id" value="<?php echo get_the_ID(); ?>">
						
						<div class="ce-form-row">
							<label for="contact-name"><?php esc_html_e( 'Your Name', 'common-elements-platform' ); ?> <span class="required">*</span></label>
							<input type="text" id="contact-name" name="name" required>
						</div>
						
						<div class="ce-form-row">
							<label for="contact-email"><?php esc_html_e( 'Your Email', 'common-elements-platform' ); ?> <span class="required">*</span></label>
							<input type="email" id="contact-email" name="email" required>
						</div>
						
						<div class="ce-form-row">
							<label for="contact-phone"><?php esc_html_e( 'Your Phone', 'common-elements-platform' ); ?></label>
							<input type="text" id="contact-phone" name="phone">
						</div>
						
						<div class="ce-form-row">
							<label for="contact-message"><?php esc_html_e( 'Message', 'common-elements-platform' ); ?> <span class="required">*</span></label>
							<textarea id="contact-message" name="message" rows="5" required></textarea>
						</div>
						
						<div class="ce-form-row">
							<button type="submit" class="ce-button ce-button-primary">
								<i class="fas fa-paper-plane"></i>
								<?php esc_html_e( 'Send Message', 'common-elements-platform' ); ?>
							</button>
							
							<button type="button" class="ce-button ce-button-secondary ce-directory-contact-cancel">
								<i class="fas fa-times"></i>
								<?php esc_html_e( 'Cancel', 'common-elements-platform' ); ?>
							</button>
						</div>
						
						<div class="ce-form-error-message" style="display: none;"></div>
					</form>
				</div>
				
			<?php endwhile; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<script>
jQuery(document).ready(function($) {
	function initMap() {
		const $mapCanvas = $('#ce-directory-map-canvas');
		
		if ($mapCanvas.length && typeof google !== 'undefined' && google.maps) {
			const lat = parseFloat($mapCanvas.data('lat'));
			const lng = parseFloat($mapCanvas.data('lng'));
			const title = $mapCanvas.data('title');
			
			const mapOptions = {
				center: { lat: lat, lng: lng },
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				scrollwheel: false
			};
			
			const map = new google.maps.Map($mapCanvas[0], mapOptions);
			
			const marker = new google.maps.Marker({
				position: { lat: lat, lng: lng },
				map: map,
				title: title
			});
		}
	}
	
	if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
		$.getScript('https://maps.googleapis.com/maps/api/js?key=' + common_elements_platform.google_maps_api_key, function() {
			initMap();
		});
	} else {
		initMap();
	}
	
	$('.ce-directory-contact-btn').on('click', function(e) {
		e.preventDefault();
		$('.ce-directory-contact-form').slideDown(300);
	});
	
	$('.ce-directory-contact-cancel').on('click', function() {
		$('.ce-directory-contact-form').slideUp(300);
	});
	
	$('#ce-directory-contact-form').on('submit', function(e) {
		e.preventDefault();
		
		const $form = $(this);
		const $submitButton = $form.find('button[type="submit"]');
		
		$submitButton.prop('disabled', true);
		
		$.ajax({
			url: common_elements_platform.ajax_url,
			type: 'POST',
			data: $form.serialize() + '&action=ce_ajax_directory_contact',
			success: function(response) {
				if (response.success) {
					$form[0].reset();
					$form.html('<div class="ce-form-success-message"><i class="fas fa-check-circle"></i> ' + response.data.message + '</div>');
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
	
	$('.ce-directory-share-btn').on('click', function(e) {
		e.preventDefault();
		
		if (navigator.share) {
			navigator.share({
				title: '<?php echo esc_js( get_the_title() ); ?>',
				url: '<?php echo esc_js( get_permalink() ); ?>'
			});
		} else {
			const $shareBtn = $(this);
			const shareUrl = '<?php echo esc_js( get_permalink() ); ?>';
			const shareTitle = '<?php echo esc_js( get_the_title() ); ?>';
			
			const shareLinks = `
				<div class="ce-share-dropdown">
					<a href="https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}" target="_blank" class="ce-share-link ce-share-facebook">
						<i class="fab fa-facebook-f"></i> Facebook
					</a>
					<a href="https://twitter.com/intent/tweet?url=${encodeURIComponent(shareUrl)}&text=${encodeURIComponent(shareTitle)}" target="_blank" class="ce-share-link ce-share-twitter">
						<i class="fab fa-twitter"></i> Twitter
					</a>
					<a href="https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(shareUrl)}&title=${encodeURIComponent(shareTitle)}" target="_blank" class="ce-share-link ce-share-linkedin">
						<i class="fab fa-linkedin-in"></i> LinkedIn
					</a>
					<a href="mailto:?subject=${encodeURIComponent(shareTitle)}&body=${encodeURIComponent(shareUrl)}" class="ce-share-link ce-share-email">
						<i class="fas fa-envelope"></i> Email
					</a>
				</div>
			`;
			
			if ($shareBtn.next('.ce-share-dropdown').length) {
				$shareBtn.next('.ce-share-dropdown').remove();
			} else {
				$shareBtn.after(shareLinks);
			}
		}
	});
});
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
