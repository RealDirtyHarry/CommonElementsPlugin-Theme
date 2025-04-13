<?php
/**
 * Template for Forum Reply Form
 *
 * @package Common_Elements_Platform
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! is_user_logged_in() ) {
	?>
	<div class="ce-forum-login-required">
		<p><?php esc_html_e( 'You must be logged in to reply to topics.', 'common-elements-platform' ); ?></p>
		<a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="ce-button ce-button-primary">
			<i class="fas fa-sign-in-alt"></i>
			<?php esc_html_e( 'Log In', 'common-elements-platform' ); ?>
		</a>
	</div>
	<?php
	return;
}

$topic_id = isset( $args['topic_id'] ) ? $args['topic_id'] : 0;
$parent_id = isset( $args['parent_id'] ) ? $args['parent_id'] : 0;

if ( ! $topic_id ) {
	return;
}
?>

<div id="ce-forum-reply-form-container" class="ce-forum-reply-form-container">
	<h3 class="ce-forum-reply-form-title">
		<?php
		if ( $parent_id ) {
			esc_html_e( 'Reply to Comment', 'common-elements-platform' );
		} else {
			esc_html_e( 'Reply to Topic', 'common-elements-platform' );
		}
		?>
	</h3>
	
	<form id="ce-forum-reply-form" class="ce-forum-reply-form">
		<?php wp_nonce_field( 'common_elements_platform_nonce', 'nonce' ); ?>
		<input type="hidden" name="topic_id" value="<?php echo esc_attr( $topic_id ); ?>">
		<input type="hidden" name="parent_id" value="<?php echo esc_attr( $parent_id ); ?>">
		
		<div class="ce-form-row">
			<?php
			wp_editor( '', 'reply-content', array(
				'textarea_name' => 'content',
				'media_buttons' => true,
				'textarea_rows' => 8,
				'teeny' => true,
				'quicktags' => true,
			) );
			?>
		</div>
		
		<div class="ce-form-row ce-form-actions">
			<button type="submit" class="ce-button ce-button-primary">
				<i class="fas fa-paper-plane"></i>
				<?php esc_html_e( 'Submit Reply', 'common-elements-platform' ); ?>
			</button>
			
			<button type="button" class="ce-button ce-button-secondary ce-forum-reply-cancel">
				<i class="fas fa-times"></i>
				<?php esc_html_e( 'Cancel', 'common-elements-platform' ); ?>
			</button>
		</div>
		
		<div class="ce-form-error-message" style="display: none;">
			<?php esc_html_e( 'Please enter a reply.', 'common-elements-platform' ); ?>
		</div>
	</form>
</div>

<script>
jQuery(document).ready(function($) {
	$(document).on('click', '.ce-forum-reply-cancel', function(e) {
		e.preventDefault();
		$('#ce-forum-reply-form-container').hide();
		$('#ce-forum-reply-form')[0].reset();
	});
});
</script>
