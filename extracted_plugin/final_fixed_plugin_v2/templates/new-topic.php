<?php
/**
 * Template for Creating a New Forum Topic
 *
 * @package Common_Elements_Platform
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! is_user_logged_in() ) {
	wp_redirect( home_url( '/forums/' ) );
	exit;
}

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="ce-new-topic-container">
			<div class="ce-forum-breadcrumbs">
				<a href="<?php echo esc_url( home_url( '/forums/' ) ); ?>">
					<i class="fas fa-home"></i>
					<?php esc_html_e( 'Forums', 'common-elements-platform' ); ?>
				</a>
				
				<span class="ce-breadcrumb-separator">
					<i class="fas fa-chevron-right"></i>
				</span>
				<span class="ce-breadcrumb-current"><?php esc_html_e( 'Create New Topic', 'common-elements-platform' ); ?></span>
			</div>
			
			<h1 class="ce-new-topic-title"><?php esc_html_e( 'Create New Topic', 'common-elements-platform' ); ?></h1>
			
			<form id="ce-new-topic-form" class="ce-new-topic-form">
				<?php wp_nonce_field( 'common_elements_platform_nonce', 'nonce' ); ?>
				
				<div class="ce-form-row">
					<label for="topic-title"><?php esc_html_e( 'Topic Title', 'common-elements-platform' ); ?> <span class="required">*</span></label>
					<input type="text" id="topic-title" name="title" required>
				</div>
				
				<div class="ce-form-row">
					<label for="topic-board"><?php esc_html_e( 'Board', 'common-elements-platform' ); ?> <span class="required">*</span></label>
					<select id="topic-board" name="board_id" required>
						<option value=""><?php esc_html_e( 'Select Board', 'common-elements-platform' ); ?></option>
						<?php
						$boards = get_terms( array(
							'taxonomy' => 'forum_board',
							'hide_empty' => false,
						) );
						
						if ( ! is_wp_error( $boards ) && ! empty( $boards ) ) {
							foreach ( $boards as $board ) {
								echo '<option value="' . esc_attr( $board->term_id ) . '">' . esc_html( $board->name ) . '</option>';
							}
						}
						?>
					</select>
				</div>
				
				<div class="ce-form-row">
					<label for="topic-content"><?php esc_html_e( 'Content', 'common-elements-platform' ); ?> <span class="required">*</span></label>
					<?php
					wp_editor( '', 'topic-content', array(
						'textarea_name' => 'content',
						'media_buttons' => true,
						'textarea_rows' => 10,
						'teeny' => false,
						'quicktags' => true,
					) );
					?>
				</div>
				
				<div class="ce-form-row">
					<label for="topic-tags"><?php esc_html_e( 'Tags', 'common-elements-platform' ); ?></label>
					<input type="text" id="topic-tags" name="tags" placeholder="<?php esc_attr_e( 'Separate tags with commas', 'common-elements-platform' ); ?>">
				</div>
				
				<div class="ce-form-row">
					<button type="submit" class="ce-button ce-button-primary">
						<i class="fas fa-paper-plane"></i>
						<?php esc_html_e( 'Create Topic', 'common-elements-platform' ); ?>
					</button>
					
					<a href="<?php echo esc_url( home_url( '/forums/' ) ); ?>" class="ce-button ce-button-secondary">
						<i class="fas fa-times"></i>
						<?php esc_html_e( 'Cancel', 'common-elements-platform' ); ?>
					</a>
				</div>
				
				<div class="ce-form-error-message" style="display: none;"></div>
			</form>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<script>
jQuery(document).ready(function($) {
	$('#ce-new-topic-form').on('submit', function(e) {
		e.preventDefault();
		
		const $form = $(this);
		const $submitButton = $form.find('button[type="submit"]');
		const $errorMessage = $form.find('.ce-form-error-message');
		
		const title = $form.find('#topic-title').val();
		const boardId = $form.find('#topic-board').val();
		const content = tinyMCE.activeEditor ? tinyMCE.activeEditor.getContent() : $form.find('#topic-content').val();
		
		if (!title || !boardId || !content) {
			$errorMessage.text('<?php esc_html_e( 'Please fill in all required fields.', 'common-elements-platform' ); ?>').show();
			return;
		}
		
		$submitButton.prop('disabled', true);
		
		$.ajax({
			url: common_elements_platform.ajax_url,
			type: 'POST',
			data: {
				action: 'ce_ajax_create_topic',
				nonce: $form.find('#nonce').val(),
				title: title,
				board_id: boardId,
				content: content,
				tags: $form.find('#topic-tags').val()
			},
			success: function(response) {
				if (response.success) {
					window.location.href = response.data.topic_url;
				} else {
					$errorMessage.text(response.data.message).show();
					$submitButton.prop('disabled', false);
				}
			},
			error: function() {
				$errorMessage.text('<?php esc_html_e( 'An error occurred. Please try again.', 'common-elements-platform' ); ?>').show();
				$submitButton.prop('disabled', false);
			}
		});
	});
});
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
