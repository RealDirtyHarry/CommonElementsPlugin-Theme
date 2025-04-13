<?php
/**
 * Template for Single RFP View
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
		<div class="ce-rfp-single">
			<?php
			while ( have_posts() ) :
				the_post();
				
				$deadline = get_post_meta( get_the_ID(), 'rfp_deadline', true );
				$community = get_post_meta( get_the_ID(), 'rfp_community', true );
				$status = get_post_meta( get_the_ID(), 'rfp_status', true );
				$attachments = get_post_meta( get_the_ID(), 'rfp_attachment', false );
				
				$categories = wp_get_object_terms( get_the_ID(), 'rfp_category' );
				$category_name = ! empty( $categories ) ? $categories[0]->name : __( 'Uncategorized', 'common-elements-platform' );
				
				$deadline_formatted = ! empty( $deadline ) ? date_i18n( get_option( 'date_format' ), strtotime( $deadline ) ) : '';
				
				$status_class = 'ce-rfp-status-' . sanitize_html_class( $status );
				?>
				
				<div class="ce-rfp-header">
					<div class="ce-rfp-meta">
						<span class="ce-rfp-category"><?php echo esc_html( $category_name ); ?></span>
						<span class="ce-rfp-status <?php echo esc_attr( $status_class ); ?>">
							<?php 
							switch ( $status ) {
								case 'open':
									esc_html_e( 'Open', 'common-elements-platform' );
									break;
								case 'closed':
									esc_html_e( 'Closed', 'common-elements-platform' );
									break;
								case 'awarded':
									esc_html_e( 'Awarded', 'common-elements-platform' );
									break;
								default:
									echo esc_html( ucfirst( $status ) );
							}
							?>
						</span>
					</div>
					
					<h1 class="ce-rfp-title"><?php the_title(); ?></h1>
					
					<div class="ce-rfp-details">
						<?php if ( ! empty( $community ) ) : ?>
							<div class="ce-rfp-detail">
								<i class="fas fa-building"></i>
								<span><?php echo esc_html( $community ); ?></span>
							</div>
						<?php endif; ?>
						
						<?php if ( ! empty( $deadline_formatted ) ) : ?>
							<div class="ce-rfp-detail">
								<i class="fas fa-calendar-alt"></i>
								<span><?php echo esc_html( sprintf( __( 'Deadline: %s', 'common-elements-platform' ), $deadline_formatted ) ); ?></span>
							</div>
						<?php endif; ?>
						
						<div class="ce-rfp-detail">
							<i class="fas fa-clock"></i>
							<span><?php echo esc_html( sprintf( __( 'Posted: %s', 'common-elements-platform' ), get_the_date() ) ); ?></span>
						</div>
					</div>
				</div>
				
				<div class="ce-rfp-content">
					<div class="ce-rfp-description">
						<h2><?php esc_html_e( 'Description', 'common-elements-platform' ); ?></h2>
						<?php the_content(); ?>
					</div>
					
					<?php if ( ! empty( $attachments ) ) : ?>
						<div class="ce-rfp-attachments">
							<h2><?php esc_html_e( 'Attachments', 'common-elements-platform' ); ?></h2>
							<ul class="ce-rfp-attachment-list">
								<?php foreach ( $attachments as $attachment_id ) : ?>
									<li class="ce-rfp-attachment-item">
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
				
				<?php if ( 'open' === $status && is_user_logged_in() ) : ?>
					<div class="ce-rfp-actions">
						<a href="#submit-proposal" class="ce-button ce-button-primary">
							<i class="fas fa-paper-plane"></i>
							<?php esc_html_e( 'Submit Proposal', 'common-elements-platform' ); ?>
						</a>
					</div>
					
					<div id="submit-proposal" class="ce-rfp-proposal-form">
						<h2><?php esc_html_e( 'Submit Your Proposal', 'common-elements-platform' ); ?></h2>
						
						<form id="ce-proposal-form" enctype="multipart/form-data">
							<?php wp_nonce_field( 'common_elements_platform_nonce', 'nonce' ); ?>
							<input type="hidden" name="rfp_id" value="<?php echo get_the_ID(); ?>">
							
							<div class="ce-form-row">
								<label for="proposal-title"><?php esc_html_e( 'Proposal Title', 'common-elements-platform' ); ?> <span class="required">*</span></label>
								<input type="text" id="proposal-title" name="title" required>
							</div>
							
							<div class="ce-form-row">
								<label for="proposal-description"><?php esc_html_e( 'Proposal Description', 'common-elements-platform' ); ?> <span class="required">*</span></label>
								<textarea id="proposal-description" name="description" rows="6" required></textarea>
							</div>
							
							<div class="ce-form-row">
								<label for="proposal-price"><?php esc_html_e( 'Price', 'common-elements-platform' ); ?> <span class="required">*</span></label>
								<input type="text" id="proposal-price" name="price" required>
							</div>
							
							<div class="ce-form-row">
								<label for="proposal-timeline"><?php esc_html_e( 'Timeline', 'common-elements-platform' ); ?></label>
								<input type="text" id="proposal-timeline" name="timeline">
							</div>
							
							<div class="ce-form-row">
								<label for="proposal-attachment"><?php esc_html_e( 'Attachment', 'common-elements-platform' ); ?></label>
								<div class="ce-file-upload">
									<input type="file" id="proposal-attachment" name="proposal_attachment" class="ce-file-upload-input" data-allowed-types="pdf,doc,docx,xls,xlsx,ppt,pptx,zip" data-max-size="10">
									<div class="ce-file-preview"></div>
								</div>
							</div>
							
							<div class="ce-form-row">
								<button type="submit" class="ce-button ce-button-primary">
									<i class="fas fa-paper-plane"></i>
									<?php esc_html_e( 'Submit Proposal', 'common-elements-platform' ); ?>
								</button>
							</div>
							
							<div class="ce-form-error-message" style="display: none;"></div>
						</form>
					</div>
				<?php endif; ?>
				
			<?php endwhile; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
