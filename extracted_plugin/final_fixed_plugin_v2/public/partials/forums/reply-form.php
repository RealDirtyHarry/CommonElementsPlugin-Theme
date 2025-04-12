<?php
/**
 * Reply Form Template
 *
 * This template displays the form for replying to a topic.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Get current topic
$topic_id = bbp_get_topic_id();
$topic_title = bbp_get_topic_title( $topic_id );
$is_closed = bbp_is_topic_closed( $topic_id );
?>

<div class="ce-reply-form" id="respond">
    <div class="ce-card">
        <div class="ce-card-header">
            <h3 class="ce-card-title">Reply to: <?php echo esc_html( $topic_title ); ?></h3>
        </div>
        <div class="ce-card-body">
            <?php if ( bbp_current_user_can_access_create_reply_form() && ! $is_closed ) : ?>
                <form id="new-post" method="post" action="<?php echo esc_url( bbp_get_reply_url( $topic_id ) ); ?>">
                    <?php do_action( 'bbp_theme_before_reply_form' ); ?>
                    
                    <fieldset class="bbp-form">
                        <legend><?php printf( esc_html__( 'Reply To: %s', 'bbpress' ), bbp_get_topic_title() ); ?></legend>
                        
                        <?php do_action( 'bbp_theme_before_reply_form_notices' ); ?>
                        
                        <?php if ( ! bbp_is_topic_open() && ! bbp_is_reply_edit() ) : ?>
                            <div class="ce-alert ce-alert-warning">
                                <p><?php esc_html_e( 'This topic is marked as closed to new replies, however your posting capabilities still allow you to do so.', 'bbpress' ); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php do_action( 'bbp_template_notices' ); ?>
                        
                        <div>
                            <?php bbp_get_template_part( 'form', 'anonymous' ); ?>
                            
                            <?php do_action( 'bbp_theme_before_reply_form_content' ); ?>
                            
                            <div class="ce-form-group">
                                <label for="bbp_reply_content" class="ce-form-label"><?php esc_html_e( 'Reply', 'bbpress' ); ?></label>
                                <div class="ce-bbp-editor-wrapper">
                                    <?php bbp_the_content( array( 'context' => 'reply' ) ); ?>
                                </div>
                            </div>
                            
                            <?php do_action( 'bbp_theme_after_reply_form_content' ); ?>
                            
                            <?php if ( bbp_is_subscriptions_active() && ! bbp_is_anonymous() && ( ! bbp_is_reply_edit() || ( bbp_is_reply_edit() && ! bbp_is_reply_anonymous() ) ) ) : ?>
                                <div class="ce-form-group">
                                    <div class="ce-form-check">
                                        <input class="ce-form-check-input" name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox" value="bbp_subscribe" <?php bbp_form_topic_subscribed(); ?> />
                                        <label class="ce-form-check-label" for="bbp_topic_subscription">
                                            <?php esc_html_e( 'Notify me of follow-up replies via email', 'bbpress' ); ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php do_action( 'bbp_theme_before_reply_form_tags' ); ?>
                            
                            <div class="ce-form-group">
                                <label for="bbp_topic_tags" class="ce-form-label"><?php esc_html_e( 'Tags', 'bbpress' ); ?></label>
                                <input type="text" value="<?php bbp_form_topic_tags(); ?>" class="ce-form-control" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_tags" id="bbp_topic_tags" <?php disabled( bbp_is_topic_spam() ); ?> />
                                <small class="ce-form-text"><?php esc_html_e( 'Separate tags with commas', 'bbpress' ); ?></small>
                            </div>
                            
                            <?php do_action( 'bbp_theme_after_reply_form_tags' ); ?>
                            
                            <?php do_action( 'bbp_theme_before_reply_form_submit_wrapper' ); ?>
                            
                            <div class="ce-form-group">
                                <?php do_action( 'bbp_theme_before_reply_form_submit_button' ); ?>
                                
                                <button type="submit" id="bbp_reply_submit" name="bbp_reply_submit" class="ce-btn ce-btn-primary">
                                    <?php esc_html_e( 'Submit Reply', 'bbpress' ); ?>
                                </button>
                                
                                <?php do_action( 'bbp_theme_after_reply_form_submit_button' ); ?>
                            </div>
                            
                            <?php do_action( 'bbp_theme_after_reply_form_submit_wrapper' ); ?>
                        </div>
                        
                        <?php bbp_reply_form_fields(); ?>
                    </fieldset>
                    
                    <?php do_action( 'bbp_theme_after_reply_form' ); ?>
                </form>
            <?php elseif ( $is_closed ) : ?>
                <div class="ce-alert ce-alert-warning">
                    <p>This topic is closed to new replies.</p>
                </div>
            <?php elseif ( ! is_user_logged_in() ) : ?>
                <div class="ce-alert ce-alert-info">
                    <p>You must be logged in to reply to this topic.</p>
                    <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="ce-btn ce-btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add quote functionality
        window.addQuote = function(authorName, content) {
            const editor = document.querySelector('#bbp_reply_content');
            const quote = `[quote="${authorName}"]${content}[/quote]\n\n`;
            
            if (editor) {
                if (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden()) {
                    tinyMCE.activeEditor.execCommand('mceInsertContent', false, quote);
                } else {
                    const startPos = editor.selectionStart;
                    const endPos = editor.selectionEnd;
                    editor.value = editor.value.substring(0, startPos) + quote + editor.value.substring(endPos, editor.value.length);
                    editor.focus();
                    editor.selectionStart = startPos + quote.length;
                    editor.selectionEnd = startPos + quote.length;
                }
            }
            
            // Scroll to the reply form
            document.querySelector('#respond').scrollIntoView({ behavior: 'smooth' });
        };
    });
</script>
