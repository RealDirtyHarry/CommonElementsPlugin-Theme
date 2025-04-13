<?php
/**
 * Template for Single Proposal View
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
		<div class="ce-proposal-single">
			<?php
			while ( have_posts() ) :
				the_post();
				
				$rfp_id = get_post_meta( get_the_ID(), 'related_rfp', true );
				$price = get_post_meta( get_the_ID(), 'proposal_price', true );
				$timeline = get_post_meta( get_the_ID(), 'proposal_timeline', true );
				$status = get_post_meta( get_the_ID(), 'proposal_status', true );
				$attachments = get_post_meta( get_the_ID(), 'proposal_attachment', false );
				
				$status_class = 'ce-proposal-status-' . sanitize_html_class( $status );
				
				$rfp_title = '';
				$rfp_link = '';
				if ( ! empty( $rfp_id ) ) {
					$rfp = get_post( $rfp_id );
					if ( $rfp && 'rfp' === $rfp->post_type ) {
						$rfp_title = $rfp->post_title;
						$rfp_link = get_permalink( $rfp_id );
					}
				}
				?>
				
				<div class="ce-proposal-header">
					<div class="ce-proposal-meta">
						<span class="ce-proposal-status <?php echo esc_attr( $status_class ); ?>">
							<?php 
							switch ( $status ) {
								case 'submitted':
									esc_html_e( 'Submitted', 'common-elements-platform' );
									break;
								case 'under_review':
									esc_html_e( 'Under Review', 'common-elements-platform' );
									break;
								case 'accepted':
									esc_html_e( 'Accepted', 'common-elements-platform' );
									break;
								case 'rejected':
									esc_html_e( 'Rejected', 'common-elements-platform' );
									break;
								default:
									echo esc_html( ucfirst( $status ) );
							}
							?>
						</span>
					</div>
					
					<h1 class="ce-proposal-title"><?php the_title(); ?></h1>
					
					<?php if ( ! empty( $rfp_title ) && ! empty( $rfp_link ) ) : ?>
						<div class="ce-proposal-rfp-link">
							<?php esc_html_e( 'In response to RFP:', 'common-elements-platform' ); ?>
							<a href="<?php echo esc_url( $rfp_link ); ?>"><?php echo esc_html( $rfp_title ); ?></a>
						</div>
					<?php endif; ?>
					
					<div class="ce-proposal-details">
						<?php if ( ! empty( $price ) ) : ?>
							<div class="ce-proposal-detail">
								<i class="fas fa-dollar-sign"></i>
								<span><?php echo esc_html( sprintf( __( 'Price: %s', 'common-elements-platform' ), $price ) ); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( ! empty( $timeline ) ) : ?>
							<div class="ce-proposal-detail">
								<i class="fas fa-calendar-alt"></i>
								<span><?php echo esc_html( sprintf( __( 'Timeline: %s', 'common-elements-platform' ), $timeline ) ); ?></span>
							</div>
						<?php endif; ?>
						
						<div class="ce-proposal-detail">
							<i class="fas fa-clock"></i>
							<span><?php echo esc_html( sprintf( __( 'Submitted: %s', 'common-elements-platform' ), get_the_date() ) ); ?></span>
						</div>
					</div>
				</div>
				
				<div class="ce-proposal-content">
					<div class="ce-proposal-description">
						<h2><?php esc_html_e( 'Proposal Details', 'common-elements-platform' ); ?></h2>
						<?php the_content(); ?>
					</div>
					
					<?php if ( ! empty( $attachments ) ) : ?>
						<div class="ce-proposal-attachments">
							<h2><?php esc_html_e( 'Attachments', 'common-elements-platform' ); ?></h2>
							<ul class="ce-proposal-attachment-list">
								<?php foreach ( $attachments as $attachment_id ) : ?>
									<li class="ce-proposal-attachment-item">
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
				
				<?php
				$rfp_author_id = 0;
				if ( ! empty( $rfp_id ) ) {
					$rfp = get_post( $rfp_id );
					if ( $rfp ) {
						$rfp_author_id = $rfp->post_author;
					}
				}
				
				if ( is_user_logged_in() && get_current_user_id() === $rfp_author_id && 'submitted' === $status ) :
				?>
					<div class="ce-proposal-actions">
						<h2><?php esc_html_e( 'Proposal Actions', 'common-elements-platform' ); ?></h2>
						
						<div class="ce-proposal-action-buttons">
							<button class="ce-button ce-button-primary ce-proposal-accept" data-proposal-id="<?php echo get_the_ID(); ?>" data-rfp-id="<?php echo esc_attr( $rfp_id ); ?>">
								<i class="fas fa-check"></i>
								<?php esc_html_e( 'Accept Proposal', 'common-elements-platform' ); ?>
							</button>
							
							<button class="ce-button ce-button-secondary ce-proposal-review" data-proposal-id="<?php echo get_the_ID(); ?>" data-rfp-id="<?php echo esc_attr( $rfp_id ); ?>">
								<i class="fas fa-search"></i>
								<?php esc_html_e( 'Mark Under Review', 'common-elements-platform' ); ?>
							</button>
							
							<button class="ce-button ce-button-danger ce-proposal-reject" data-proposal-id="<?php echo get_the_ID(); ?>" data-rfp-id="<?php echo esc_attr( $rfp_id ); ?>">
								<i class="fas fa-times"></i>
								<?php esc_html_e( 'Reject Proposal', 'common-elements-platform' ); ?>
							</button>
						</div>
					</div>
				<?php endif; ?>
				
			<?php endwhile; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<script>
jQuery(document).ready(function($) {
	$('.ce-proposal-action-buttons button').on('click', function() {
		const $button = $(this);
		const proposalId = $button.data('proposal-id');
		const rfpId = $button.data('rfp-id');
		let action = '';
		
		if ($button.hasClass('ce-proposal-accept')) {
			action = 'accept';
		} else if ($button.hasClass('ce-proposal-review')) {
			action = 'review';
		} else if ($button.hasClass('ce-proposal-reject')) {
			action = 'reject';
		}
		
		if (action) {
			$.ajax({
				url: common_elements_platform.ajax_url,
				type: 'POST',
				data: {
					action: 'ce_ajax_update_proposal_status',
					nonce: common_elements_platform.nonce,
					proposal_id: proposalId,
					rfp_id: rfpId,
					status_action: action
				},
				success: function(response) {
					if (response.success) {
						window.location.reload();
					} else {
						alert(response.data.message);
					}
				},
				error: function() {
					alert('An error occurred. Please try again.');
				}
			});
		}
	});
});
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
