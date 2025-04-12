<?php
/**
 * Single Topic Template
 *
 * This template displays a single topic with its replies.
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
$forum_id = bbp_get_topic_forum_id( $topic_id );
$forum_title = bbp_get_forum_title( $forum_id );
$is_closed = bbp_is_topic_closed( $topic_id );
$is_sticky = bbp_is_topic_sticky( $topic_id );
$is_super_sticky = bbp_is_topic_super_sticky( $topic_id );
$reply_count = bbp_get_topic_reply_count( $topic_id );
$voice_count = bbp_get_topic_voice_count( $topic_id );
$last_active = bbp_get_topic_last_active_time( $topic_id );
?>

<div class="ce-forums">
    <div class="ce-container">
        <div class="ce-section">
            <div class="ce-topic-breadcrumbs">
                <a href="<?php echo esc_url( home_url( '/forums' ) ); ?>">Forums</a> &raquo; 
                <a href="<?php echo esc_url( bbp_get_forum_permalink( $forum_id ) ); ?>"><?php echo esc_html( $forum_title ); ?></a> &raquo; 
                <?php echo esc_html( $topic_title ); ?>
            </div>
            
            <div class="ce-topic-header">
                <h1 class="ce-topic-title">
                    <?php echo esc_html( $topic_title ); ?>
                    <?php if ( $is_sticky || $is_super_sticky ) : ?>
                        <span class="ce-topic-badge ce-topic-badge-sticky">Sticky</span>
                    <?php endif; ?>
                    <?php if ( $is_closed ) : ?>
                        <span class="ce-topic-badge ce-topic-badge-closed">Closed</span>
                    <?php endif; ?>
                </h1>
                
                <div class="ce-topic-meta-info">
                    <div class="ce-topic-meta-item">
                        <i class="fas fa-reply"></i> <?php echo esc_html( $reply_count ); ?> Replies
                    </div>
                    <div class="ce-topic-meta-item">
                        <i class="fas fa-users"></i> <?php echo esc_html( $voice_count ); ?> Participants
                    </div>
                    <?php if ( ! empty( $last_active ) ) : ?>
                        <div class="ce-topic-meta-item">
                            <i class="fas fa-clock"></i> Last Active: <?php echo esc_html( $last_active ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="ce-topic-actions">
                <div class="ce-topic-buttons">
                    <?php if ( is_user_logged_in() ) : ?>
                        <?php if ( bbp_is_subscriptions_active() ) : ?>
                            <?php if ( bbp_is_user_subscribed_to_topic( get_current_user_id(), $topic_id ) ) : ?>
                                <a href="<?php echo esc_url( bbp_get_topic_unsubscribe_link( $topic_id ) ); ?>" class="ce-btn ce-btn-outline-primary">
                                    <i class="fas fa-bell-slash"></i> Unsubscribe
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url( bbp_get_topic_subscribe_link( $topic_id ) ); ?>" class="ce-btn ce-btn-outline-primary">
                                    <i class="fas fa-bell"></i> Subscribe
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php if ( bbp_current_user_can_access_create_reply_form() && ! $is_closed ) : ?>
                            <a href="#respond" class="ce-btn ce-btn-primary">
                                <i class="fas fa-reply"></i> Reply
                            </a>
                        <?php endif; ?>
                        
                        <?php if ( bbp_current_user_can_edit_topic( $topic_id ) ) : ?>
                            <a href="<?php echo esc_url( bbp_get_topic_edit_url( $topic_id ) ); ?>" class="ce-btn ce-btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        <?php endif; ?>
                        
                        <?php if ( bbp_current_user_can_trash_topic( $topic_id ) ) : ?>
                            <a href="<?php echo esc_url( bbp_get_topic_trash_url( $topic_id ) ); ?>" class="ce-btn ce-btn-outline-danger">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        <?php endif; ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="ce-btn ce-btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login to Reply
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="ce-topic-posts">
                <?php if ( bbp_has_replies() ) : ?>
                    <div class="ce-topic-pagination-top">
                        <?php bbp_topic_pagination(); ?>
                    </div>
                    
                    <?php
                    // Get the original topic post
                    $topic_author_id = bbp_get_topic_author_id( $topic_id );
                    $topic_author_name = bbp_get_topic_author( $topic_id );
                    $topic_author_url = bbp_get_user_profile_url( $topic_author_id );
                    $topic_date = bbp_get_topic_post_date( $topic_id );
                    $topic_content = bbp_get_topic_content( $topic_id );
                    $topic_author_role = bbp_get_user_display_role( $topic_author_id );
                    $topic_author_posts = bbp_get_user_topic_count_raw( $topic_author_id ) + bbp_get_user_reply_count_raw( $topic_author_id );
                    ?>
                    
                    <div class="ce-post-item ce-post-original">
                        <div class="ce-post-author">
                            <div class="ce-post-author-avatar">
                                <?php echo get_avatar( $topic_author_id, 80 ); ?>
                            </div>
                            <div class="ce-post-author-name">
                                <a href="<?php echo esc_url( $topic_author_url ); ?>"><?php echo esc_html( $topic_author_name ); ?></a>
                            </div>
                            <div class="ce-post-author-role">
                                <?php echo esc_html( $topic_author_role ); ?>
                            </div>
                            <div class="ce-post-author-posts">
                                <i class="fas fa-comments"></i> <?php echo esc_html( $topic_author_posts ); ?> posts
                            </div>
                        </div>
                        <div class="ce-post-content">
                            <div class="ce-post-meta">
                                <div class="ce-post-date">
                                    <i class="fas fa-calendar-alt"></i> <?php echo esc_html( $topic_date ); ?>
                                </div>
                                <div class="ce-post-permalink">
                                    <a href="<?php echo esc_url( bbp_get_topic_permalink( $topic_id ) ); ?>" title="Permalink to this post">
                                        <i class="fas fa-link"></i> #1
                                    </a>
                                </div>
                            </div>
                            <div class="ce-post-body">
                                <?php echo wp_kses_post( $topic_content ); ?>
                            </div>
                            <div class="ce-post-actions">
                                <?php if ( bbp_current_user_can_edit_topic( $topic_id ) ) : ?>
                                    <a href="<?php echo esc_url( bbp_get_topic_edit_url( $topic_id ) ); ?>" class="ce-post-action-link">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( bbp_current_user_can_trash_topic( $topic_id ) ) : ?>
                                    <a href="<?php echo esc_url( bbp_get_topic_trash_url( $topic_id ) ); ?>" class="ce-post-action-link">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                <?php endif; ?>
                                
                                <a href="#respond" class="ce-post-action-link">
                                    <i class="fas fa-reply"></i> Reply
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    // Loop through replies
                    $reply_count = 1; // Start at 1 because the original post is #1
                    while ( bbp_replies() ) : bbp_the_reply();
                        $reply_count++;
                        $reply_id = bbp_get_reply_id();
                        $reply_author_id = bbp_get_reply_author_id( $reply_id );
                        $reply_author_name = bbp_get_reply_author( $reply_id );
                        $reply_author_url = bbp_get_user_profile_url( $reply_author_id );
                        $reply_date = bbp_get_reply_post_date( $reply_id );
                        $reply_content = bbp_get_reply_content( $reply_id );
                        $reply_author_role = bbp_get_user_display_role( $reply_author_id );
                        $reply_author_posts = bbp_get_user_topic_count_raw( $reply_author_id ) + bbp_get_user_reply_count_raw( $reply_author_id );
                        $is_topic_author = $reply_author_id === $topic_author_id;
                    ?>
                        <div class="ce-post-item <?php echo $is_topic_author ? 'ce-post-by-topic-author' : ''; ?>">
                            <div class="ce-post-author">
                                <div class="ce-post-author-avatar">
                                    <?php echo get_avatar( $reply_author_id, 80 ); ?>
                                </div>
                                <div class="ce-post-author-name">
                                    <a href="<?php echo esc_url( $reply_author_url ); ?>"><?php echo esc_html( $reply_author_name ); ?></a>
                                </div>
                                <div class="ce-post-author-role">
                                    <?php echo esc_html( $reply_author_role ); ?>
                                </div>
                                <div class="ce-post-author-posts">
                                    <i class="fas fa-comments"></i> <?php echo esc_html( $reply_author_posts ); ?> posts
                                </div>
                                <?php if ( $is_topic_author ) : ?>
                                    <div class="ce-post-author-badge">
                                        <span class="ce-badge ce-badge-primary">Topic Author</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="ce-post-content">
                                <div class="ce-post-meta">
                                    <div class="ce-post-date">
                                        <i class="fas fa-calendar-alt"></i> <?php echo esc_html( $reply_date ); ?>
                                    </div>
                                    <div class="ce-post-permalink">
                                        <a href="<?php echo esc_url( bbp_get_reply_url( $reply_id ) ); ?>" title="Permalink to this post">
                                            <i class="fas fa-link"></i> #<?php echo esc_html( $reply_count ); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="ce-post-body">
                                    <?php echo wp_kses_post( $reply_content ); ?>
                                </div>
                                <div class="ce-post-actions">
                                    <?php if ( bbp_current_user_can_edit_reply( $reply_id ) ) : ?>
                                        <a href="<?php echo esc_url( bbp_get_reply_edit_url( $reply_id ) ); ?>" class="ce-post-action-link">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ( bbp_current_user_can_trash_reply( $reply_id ) ) : ?>
                                        <a href="<?php echo esc_url( bbp_get_reply_trash_url( $reply_id ) ); ?>" class="ce-post-action-link">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="#respond" class="ce-post-action-link ce-post-quote-link" data-reply-id="<?php echo esc_attr( $reply_id ); ?>">
                                        <i class="fas fa-quote-left"></i> Quote
                                    </a>
                                    
                                    <a href="#respond" class="ce-post-action-link">
                                        <i class="fas fa-reply"></i> Reply
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    
                    <div class="ce-topic-pagination-bottom">
                        <?php bbp_topic_pagination(); ?>
                    </div>
                <?php else : ?>
                    <div class="ce-post-item ce-post-original">
                        <div class="ce-post-author">
                            <div class="ce-post-author-avatar">
                                <?php echo get_avatar( $topic_author_id, 80 ); ?>
                            </div>
                            <div class="ce-post-author-name">
                                <a href="<?php echo esc_url( $topic_author_url ); ?>"><?php echo esc_html( $topic_author_name ); ?></a>
                            </div>
                            <div class="ce-post-author-role">
                                <?php echo esc_html( $topic_author_role ); ?>
                            </div>
                            <div class="ce-post-author-posts">
                                <i class="fas fa-comments"></i> <?php echo esc_html( $topic_author_posts ); ?> posts
                            </div>
                        </div>
                        <div class="ce-post-content">
                            <div class="ce-post-meta">
                                <div class="ce-post-date">
                                    <i class="fas fa-calendar-alt"></i> <?php echo esc_html( $topic_date ); ?>
                                </div>
                                <div class="ce-post-permalink">
                                    <a href="<?php echo esc_url( bbp_get_topic_permalink( $topic_id ) ); ?>" title="Permalink to this post">
                                        <i class="fas fa-link"></i> #1
                                    </a>
                                </div>
                            </div>
                            <div class="ce-post-body">
                                <?php echo wp_kses_post( $topic_content ); ?>
                            </div>
                            <div class="ce-post-actions">
                                <?php if ( bbp_current_user_can_edit_topic( $topic_id ) ) : ?>
                                    <a href="<?php echo esc_url( bbp_get_topic_edit_url( $topic_id ) ); ?>" class="ce-post-action-link">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( bbp_current_user_can_trash_topic( $topic_id ) ) : ?>
                                    <a href="<?php echo esc_url( bbp_get_topic_trash_url( $topic_id ) ); ?>" class="ce-post-action-link">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                <?php endif; ?>
                                
                                <a href="#respond" class="ce-post-action-link">
                                    <i class="fas fa-reply"></i> Reply
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ce-alert ce-alert-info">
                        <p>There are no replies to this topic yet.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ( bbp_current_user_can_access_create_reply_form() && ! $is_closed ) : ?>
                <div class="ce-reply-form" id="respond">
                    <div class="ce-card">
                        <div class="ce-card-header">
                            <h3 class="ce-card-title">Reply to: <?php echo esc_html( $topic_title ); ?></h3>
                        </div>
                        <div class="ce-card-body">
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
                        </div>
                    </div>
                </div>
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
        // Quote functionality
        const quoteLinks = document.querySelectorAll('.ce-post-quote-link');
        
        quoteLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const replyId = this.getAttribute('data-reply-id');
                const replyContent = document.querySelector(`[data-reply-id="${replyId}"]`).closest('.ce-post-item').querySelector('.ce-post-body').innerText;
                const replyAuthor = document.querySelector(`[data-reply-id="${replyId}"]`).closest('.ce-post-item').querySelector('.ce-post-author-name a').innerText;
                
                const editor = document.querySelector('#bbp_reply_content');
                const quote = `[quote="${replyAuthor}"]${replyContent}[/quote]\n\n`;
                
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
            });
        });
    });
</script>
