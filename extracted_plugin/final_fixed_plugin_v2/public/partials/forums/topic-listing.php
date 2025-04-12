<?php
/**
 * Topic Listing Template
 *
 * This template displays a list of topics in a forum.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Get current forum
$forum_id = bbp_get_forum_id();
$forum_title = bbp_get_forum_title( $forum_id );
$forum_description = bbp_get_forum_content( $forum_id );
$topic_count = bbp_get_forum_topic_count( $forum_id );
$reply_count = bbp_get_forum_reply_count( $forum_id );
$last_active = bbp_get_forum_last_active_time( $forum_id );
?>

<div class="ce-forums">
    <div class="ce-container">
        <div class="ce-section">
            <div class="ce-forum-breadcrumbs">
                <a href="<?php echo esc_url( home_url( '/forums' ) ); ?>">Forums</a> &raquo; <?php echo esc_html( $forum_title ); ?>
            </div>
            
            <div class="ce-forum-header">
                <h1 class="ce-forum-title"><?php echo esc_html( $forum_title ); ?></h1>
                <?php if ( ! empty( $forum_description ) ) : ?>
                    <div class="ce-forum-description"><?php echo wp_kses_post( $forum_description ); ?></div>
                <?php endif; ?>
                
                <div class="ce-forum-meta-info">
                    <div class="ce-forum-meta-item">
                        <i class="fas fa-file-alt"></i> <?php echo esc_html( $topic_count ); ?> Topics
                    </div>
                    <div class="ce-forum-meta-item">
                        <i class="fas fa-reply"></i> <?php echo esc_html( $reply_count ); ?> Replies
                    </div>
                    <?php if ( ! empty( $last_active ) ) : ?>
                        <div class="ce-forum-meta-item">
                            <i class="fas fa-clock"></i> Last Active: <?php echo esc_html( $last_active ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="ce-forum-actions">
                <div class="ce-forum-search">
                    <form role="search" method="get" class="ce-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="ce-form-group">
                            <div class="ce-input-group">
                                <input type="search" class="ce-form-control" placeholder="Search this forum..." value="<?php echo get_search_query(); ?>" name="s" />
                                <input type="hidden" name="post_type" value="topic" />
                                <input type="hidden" name="bbp_forum_id" value="<?php echo esc_attr( $forum_id ); ?>" />
                                <div class="ce-input-group-append">
                                    <button type="submit" class="ce-btn ce-btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="ce-forum-buttons">
                    <?php if ( bbp_current_user_can_access_create_topic_form() ) : ?>
                        <a href="<?php echo esc_url( bbp_get_forum_permalink( $forum_id ) . 'create-topic/' ); ?>" class="ce-btn ce-btn-primary">
                            <i class="fas fa-plus"></i> New Topic
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( is_user_logged_in() ) : ?>
                        <?php if ( bbp_is_subscriptions_active() ) : ?>
                            <?php if ( bbp_is_user_subscribed_to_forum( get_current_user_id(), $forum_id ) ) : ?>
                                <a href="<?php echo esc_url( bbp_get_forum_unsubscribe_link( $forum_id ) ); ?>" class="ce-btn ce-btn-outline-primary">
                                    <i class="fas fa-bell-slash"></i> Unsubscribe
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url( bbp_get_forum_subscribe_link( $forum_id ) ); ?>" class="ce-btn ce-btn-outline-primary">
                                    <i class="fas fa-bell"></i> Subscribe
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="ce-btn ce-btn-outline-primary">
                            <i class="fas fa-sign-in-alt"></i> Login to Participate
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ( bbp_has_topics( array( 'forum_id' => $forum_id ) ) ) : ?>
                <div class="ce-topics-filter">
                    <div class="ce-card">
                        <div class="ce-card-body">
                            <div class="ce-topics-filter-row">
                                <div class="ce-topics-filter-item">
                                    <label for="ce-topics-orderby" class="ce-topics-filter-label">Order By:</label>
                                    <select id="ce-topics-orderby" class="ce-form-select ce-topics-filter-select" onchange="window.location.href=this.value">
                                        <option value="<?php echo esc_url( add_query_arg( 'orderby', 'date', get_permalink() ) ); ?>" <?php selected( ! isset( $_GET['orderby'] ) || $_GET['orderby'] === 'date' ); ?>>
                                            Newest First
                                        </option>
                                        <option value="<?php echo esc_url( add_query_arg( 'orderby', 'activity', get_permalink() ) ); ?>" <?php selected( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'activity' ); ?>>
                                            Last Activity
                                        </option>
                                        <option value="<?php echo esc_url( add_query_arg( 'orderby', 'popularity', get_permalink() ) ); ?>" <?php selected( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'popularity' ); ?>>
                                            Most Popular
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="ce-topics-filter-item">
                                    <label for="ce-topics-status" class="ce-topics-filter-label">Status:</label>
                                    <select id="ce-topics-status" class="ce-form-select ce-topics-filter-select" onchange="window.location.href=this.value">
                                        <option value="<?php echo esc_url( remove_query_arg( 'status', get_permalink() ) ); ?>" <?php selected( ! isset( $_GET['status'] ) ); ?>>
                                            All Topics
                                        </option>
                                        <option value="<?php echo esc_url( add_query_arg( 'status', 'open', get_permalink() ) ); ?>" <?php selected( isset( $_GET['status'] ) && $_GET['status'] === 'open' ); ?>>
                                            Open Topics
                                        </option>
                                        <option value="<?php echo esc_url( add_query_arg( 'status', 'closed', get_permalink() ) ); ?>" <?php selected( isset( $_GET['status'] ) && $_GET['status'] === 'closed' ); ?>>
                                            Closed Topics
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="ce-topics-list">
                    <div class="ce-card">
                        <div class="ce-card-header">
                            <div class="ce-topics-header-row">
                                <div class="ce-topics-header-topic">Topic</div>
                                <div class="ce-topics-header-voices">Voices</div>
                                <div class="ce-topics-header-replies">Replies</div>
                                <div class="ce-topics-header-activity">Last Activity</div>
                            </div>
                        </div>
                        <div class="ce-card-body">
                            <?php while ( bbp_topics() ) : bbp_the_topic(); ?>
                                <?php
                                $topic_id = bbp_get_topic_id();
                                $is_sticky = bbp_is_topic_sticky( $topic_id );
                                $is_super_sticky = bbp_is_topic_super_sticky( $topic_id );
                                $is_closed = bbp_is_topic_closed( $topic_id );
                                $voices = bbp_get_topic_voice_count( $topic_id );
                                $replies = bbp_get_topic_replies_link( $topic_id );
                                $last_active = bbp_get_topic_last_active_time( $topic_id );
                                $last_poster_id = bbp_get_topic_last_reply_author_id( $topic_id );
                                $last_poster_name = bbp_get_topic_last_reply_author( $topic_id );
                                ?>
                                <div class="ce-topic-item <?php echo $is_sticky || $is_super_sticky ? 'ce-topic-sticky' : ''; ?> <?php echo $is_closed ? 'ce-topic-closed' : ''; ?>">
                                    <div class="ce-topic-content">
                                        <div class="ce-topic-icon">
                                            <?php if ( $is_sticky || $is_super_sticky ) : ?>
                                                <i class="fas fa-thumbtack"></i>
                                            <?php elseif ( $is_closed ) : ?>
                                                <i class="fas fa-lock"></i>
                                            <?php else : ?>
                                                <i class="fas fa-file-alt"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ce-topic-details">
                                            <h3 class="ce-topic-title">
                                                <a href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
                                                <?php if ( $is_sticky || $is_super_sticky ) : ?>
                                                    <span class="ce-topic-badge ce-topic-badge-sticky">Sticky</span>
                                                <?php endif; ?>
                                                <?php if ( $is_closed ) : ?>
                                                    <span class="ce-topic-badge ce-topic-badge-closed">Closed</span>
                                                <?php endif; ?>
                                            </h3>
                                            <div class="ce-topic-meta">
                                                <span class="ce-topic-author">
                                                    Started by <a href="<?php echo esc_url( bbp_get_user_profile_url( bbp_get_topic_author_id() ) ); ?>"><?php bbp_topic_author(); ?></a>
                                                </span>
                                                <span class="ce-topic-date">
                                                    <?php bbp_topic_post_date(); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ce-topic-voices">
                                        <?php echo esc_html( $voices ); ?>
                                    </div>
                                    <div class="ce-topic-replies">
                                        <?php echo wp_kses_post( $replies ); ?>
                                    </div>
                                    <div class="ce-topic-activity">
                                        <div class="ce-topic-last-poster">
                                            <?php echo get_avatar( $last_poster_id, 30 ); ?>
                                            <a href="<?php echo esc_url( bbp_get_user_profile_url( $last_poster_id ) ); ?>"><?php echo esc_html( $last_poster_name ); ?></a>
                                        </div>
                                        <div class="ce-topic-last-date">
                                            <?php echo esc_html( $last_active ); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                
                <div class="ce-topics-pagination">
                    <?php bbp_topic_pagination(); ?>
                </div>
            <?php else : ?>
                <div class="ce-alert ce-alert-info">
                    <p>There are no topics in this forum yet.</p>
                    <?php if ( bbp_current_user_can_access_create_topic_form() ) : ?>
                        <p>Be the first to create a topic!</p>
                        <a href="<?php echo esc_url( bbp_get_forum_permalink( $forum_id ) . 'create-topic/' ); ?>" class="ce-btn ce-btn-primary">
                            <i class="fas fa-plus"></i> New Topic
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if ( bbp_has_subforums() ) : ?>
                <div class="ce-subforums">
                    <div class="ce-card">
                        <div class="ce-card-header">
                            <h3 class="ce-card-title">Subforums</h3>
                        </div>
                        <div class="ce-card-body">
                            <div class="ce-forums-list">
                                <?php while ( bbp_forums() ) : bbp_the_forum(); ?>
                                    <?php
                                    $subforum_id = bbp_get_forum_id();
                                    $subforum_title = bbp_get_forum_title( $subforum_id );
                                    $subforum_description = bbp_get_forum_content( $subforum_id );
                                    $subforum_topic_count = bbp_get_forum_topic_count( $subforum_id );
                                    $subforum_reply_count = bbp_get_forum_reply_count( $subforum_id );
                                    $subforum_last_active_id = bbp_get_forum_last_active_id( $subforum_id );
                                    $subforum_last_active_time = bbp_get_forum_last_active_time( $subforum_id );
                                    $subforum_last_poster_id = bbp_get_forum_last_reply_author_id( $subforum_id );
                                    $subforum_last_poster_name = bbp_get_forum_last_reply_author( $subforum_id );
                                    ?>
                                    <div class="ce-forum-item">
                                        <div class="ce-forum-icon">
                                            <?php if ( bbp_is_forum_category( $subforum_id ) ) : ?>
                                                <i class="fas fa-folder"></i>
                                            <?php else : ?>
                                                <i class="fas fa-comments"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ce-forum-content">
                                            <h3 class="ce-forum-title">
                                                <a href="<?php echo esc_url( bbp_get_forum_permalink( $subforum_id ) ); ?>">
                                                    <?php echo esc_html( $subforum_title ); ?>
                                                </a>
                                            </h3>
                                            <div class="ce-forum-description">
                                                <?php echo wp_kses_post( $subforum_description ); ?>
                                            </div>
                                        </div>
                                        <div class="ce-forum-meta">
                                            <div class="ce-forum-topics">
                                                <div class="ce-forum-meta-value"><?php echo esc_html( $subforum_topic_count ); ?></div>
                                                <div class="ce-forum-meta-label">Topics</div>
                                            </div>
                                            <div class="ce-forum-posts">
                                                <div class="ce-forum-meta-value"><?php echo esc_html( $subforum_reply_count ); ?></div>
                                                <div class="ce-forum-meta-label">Posts</div>
                                            </div>
                                        </div>
                                        <div class="ce-forum-activity">
                                            <?php if ( ! empty( $subforum_last_active_id ) ) : ?>
                                                <div class="ce-forum-last-post">
                                                    <div class="ce-forum-last-post-title">
                                                        <a href="<?php echo esc_url( bbp_get_topic_permalink( $subforum_last_active_id ) ); ?>">
                                                            <?php echo esc_html( bbp_get_topic_title( $subforum_last_active_id ) ); ?>
                                                        </a>
                                                    </div>
                                                    <div class="ce-forum-last-post-meta">
                                                        <span class="ce-forum-last-post-time"><?php echo esc_html( $subforum_last_active_time ); ?></span>
                                                        <span class="ce-forum-last-post-author">
                                                            by <a href="<?php echo esc_url( bbp_get_user_profile_url( $subforum_last_poster_id ) ); ?>"><?php echo esc_html( $subforum_last_poster_name ); ?></a>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="ce-forum-no-activity">
                                                    No activity yet
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
