<?php
/**
 * Template for RFP Submission Form
 *
 * @package Common_Elements_Platform
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! is_user_logged_in() || ! current_user_can( 'publish_posts' ) ) {
	wp_redirect( home_url() );
	exit;
}

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="ce-rfp-form-container">
			<h1><?php esc_html_e( 'Submit Request for Proposal', 'common-elements-platform' ); ?></h1>
			
			<form id="ce-rfp-form" class="ce-rfp-form" enctype="multipart/form-data">
				<?php wp_nonce_field( 'common_elements_platform_nonce', 'nonce' ); ?>
				
				<div class="ce-form-row">
					<label for="rfp-title"><?php esc_html_e( 'RFP Title', 'common-elements-platform' ); ?> <span class="required">*</span></label>
					<input type="text" id="rfp-title" name="title" required>
				</div>
				
				<div class="ce-form-row">
					<label for="rfp-description"><?php esc_html_e( 'RFP Description', 'common-elements-platform' ); ?> <span class="required">*</span></label>
					<textarea id="rfp-description" name="description" rows="8" required></textarea>
				</div>
				
				<div class="ce-form-row">
					<label for="rfp-deadline"><?php esc_html_e( 'Deadline', 'common-elements-platform' ); ?> <span class="required">*</span></label>
					<input type="date" id="rfp-deadline" name="deadline" required>
				</div>
				
				<div class="ce-form-row">
					<label for="rfp-community"><?php esc_html_e( 'Community', 'common-elements-platform' ); ?> <span class="required">*</span></label>
					<input type="text" id="rfp-community" name="community" required>
				</div>
				
				<div class="ce-form-row">
					<label for="rfp-category"><?php esc_html_e( 'Category', 'common-elements-platform' ); ?></label>
					<select id="rfp-category" name="category">
						<option value=""><?php esc_html_e( 'Select Category', 'common-elements-platform' ); ?></option>
						<?php
						$categories = get_terms( array(
							'taxonomy' => 'rfp_category',
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
				
				<div class="ce-form-row">
					<label for="rfp-attachment"><?php esc_html_e( 'Attachment', 'common-elements-platform' ); ?></label>
					<div class="ce-file-upload">
						<input type="file" id="rfp-attachment" name="rfp_attachment" class="ce-file-upload-input" data-allowed-types="pdf,doc,docx,xls,xlsx,ppt,pptx,zip" data-max-size="10">
						<div class="ce-file-preview"></div>
					</div>
				</div>
				
				<div class="ce-form-row">
					<button type="submit" class="ce-button ce-button-primary">
						<i class="fas fa-paper-plane"></i>
						<?php esc_html_e( 'Submit RFP', 'common-elements-platform' ); ?>
					</button>
				</div>
				
				<div class="ce-form-error-message" style="display: none;"></div>
			</form>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<script>
jQuery(document).ready(function($) {
	$('#ce-rfp-form').on('submit', function(e) {
		e.preventDefault();
		
		const $form = $(this);
		const $submitButton = $form.find('button[type="submit"]');
		const $errorMessage = $form.find('.ce-form-error-message');
		
		$submitButton.prop('disabled', true);
		
		const formData = new FormData(this);
		formData.append('action', 'submit_rfp');
		
		$.ajax({
			url: common_elements_platform.ajax_url,
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {
				if (response.success) {
					window.location.href = response.data.rfp_url;
				} else {
					$errorMessage.text(response.data.message).show();
					$submitButton.prop('disabled', false);
				}
			},
			error: function() {
				$errorMessage.text('An error occurred. Please try again.').show();
				$submitButton.prop('disabled', false);
			}
		});
	});
});
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
