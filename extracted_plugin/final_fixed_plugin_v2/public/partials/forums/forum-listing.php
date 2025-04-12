<?php
/**
 * Forum Listing Template
 *
 * This template displays a list of forums in the community section.
 *
 * @package Common_Elements_Platform
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
?>

<div class="ce-forums">
    <div class="ce-container">
        <div class="ce-section">
            <div class="ce-section-header">
                <h1 class="ce-section-title">Community Forums</h1>
                <p class="ce-section-description">Connect with other community association professionals, board members, and vendors to share knowledge and best practices.</p>
            </div>
            
            <div class="ce-forums-actions">
                <div class="ce-forums-search">
                    <form role="search" method="get" class="ce-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="ce-form-group">
                            <div class="ce-input-group">
                                <input type="search" class="ce-form-control" placeholder="Search forums..." value="<?php echo get_search_query(); ?>" name="s" />
                                <input type="hidden" name="post_type" value="forum" />
                                <div class="ce-input-group-append">
                                    <button type="submit" class="ce-btn ce-btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="ce-forums-buttons">
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( bbp_get_user_profile_url( get_current_user_id() ) ); ?>" class="ce-btn ce-btn-outline-primary">
                            <i class="fas fa-user"></i> My Profile
                        </a>
                        <a href="<?php echo esc_url( bbp_get_subscriptions_permalink( get_current_user_id() ) ); ?>" class="ce-btn ce-btn-outline-primary">
                            <i class="fas fa-bell"></i> Subscriptions
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>" class="ce-btn ce-btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login to Participate
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="ce-forums-statistics">
                <div class="ce-card">
                    <div class="ce-card-body">
                        <div class="ce-forums-stats-grid">
                            <div class="ce-forums-stat">
                                <div class="ce-forums-stat-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="ce-forums-stat-content">
                                    <div class="ce-forums-stat-value"><?php echo esc_html( bbp_get_forum_count() ); ?></div>
                                    <div class="ce-forums-stat-label">Forums</div>
                                </div>
                            </div>
                            
                            <div class="ce-forums-stat">
                                <div class="ce-forums-stat-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="ce-forums-stat-content">
                                    <div class="ce-forums-stat-value"><?php echo esc_html( bbp_get_topic_count() ); ?></div>
                                    <div class="ce-forums-stat-label">Topics</div>
                                </div>
                            </div>
                            
                            <div class="ce-forums-stat">
                                <div class="ce-forums-stat-icon">
                                    <i class="fas fa-reply"></i>
                                </div>
                                <div class="ce-forums-stat-content">
                                    <div class="ce-forums-stat-value"><?php echo esc_html( bbp_get_reply_count() ); ?></div>
                                    <div class="ce-forums-stat-label">Replies</div>
                                </div>
                            </div>
                            
                            <div class="ce-forums-stat">
                                <div class="ce-forums-stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="ce-forums-stat-content">
                                    <div class="ce-forums-stat-value"><?php echo esc_html( bbp_get_user_count() ); ?></div>
                                    <div class="ce-forums-stat-label">Members</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ce-forums-categories">
                <?php
                // Get all forum categories
                $forum_categories = bbp_get_forum_types();
                
                if ( ! empty( $forum_categories ) ) :
                    foreach ( $forum_categories as $category_id => $category_name ) :
                        // Get forums in this category
                        $forums = bbp_get_forums( array(
                            'post_parent' => $category_id,
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                        ) );
                ?>
                    <div class="ce-forum-category">
                        <div class="ce-card">
                            <div class="ce-card-header">
                                <h2 class="ce-card-title"><?php echo esc_html( $category_name ); ?></h2>
                            </div>
                            <div class="ce-card-body">
                                <div class="ce-forums-list">
                                    <?php if ( ! empty( $forums ) ) : ?>
                                        <?php foreach ( $forums as $forum ) : ?>
                                            <div class="ce-forum-item">
                                                <div class="ce-forum-icon">
                                                    <?php if ( bbp_is_forum_category( $forum->ID ) ) : ?>
                                                        <i class="fas fa-folder"></i>
                                                    <?php else : ?>
                                                        <i class="fas fa-comments"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="ce-forum-content">
                                                    <h3 class="ce-forum-title">
                                                        <a href="<?php echo esc_url( bbp_get_forum_permalink( $forum->ID ) ); ?>">
                                                            <?php echo esc_html( $forum->post_title ); ?>
                                                        </a>
                                                    </h3>
                                                    <div class="ce-forum-description">
                                                        <?php echo wp_kses_post( $forum->post_content ); ?>
                                                    </div>
                                                    <?php if ( bbp_get_forum_subforum_count( $forum->ID ) > 0 ) : ?>
                                                        <div class="ce-forum-subforums">
                                                            <span class="ce-forum-subforums-label">Subforums:</span>
                                                            <?php bbp_list_forums( array(
                                                                'before' => '',
                                                                'after' => '',
                                                                'link_before' => '',
                                                                'link_after' => '',
                                                                'separator' => ', ',
                                                                'show_topic_count' => false,
                                                                'show_reply_count' => false,
                                                                'parent_id' => $forum->ID,
                                                            ) ); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="ce-forum-meta">
                                                    <div class="ce-forum-topics">
                                                        <div class="ce-forum-meta-value"><?php echo esc_html( bbp_get_forum_topic_count( $forum->ID ) ); ?></div>
                                                        <div class="ce-forum-meta-label">Topics</div>
                                                    </div>
                                                    <div class="ce-forum-posts">
                                                        <div class="ce-forum-meta-value"><?php echo esc_html( bbp_get_forum_reply_count( $forum->ID ) ); ?></div>
                                                        <div class="ce-forum-meta-label">Posts</div>
                                                    </div>
                                                </div>
                                                <div class="ce-forum-activity">
                                                    <?php $last_active_id = bbp_get_forum_last_active_id( $forum->ID ); ?>
                                                    <?php if ( ! empty( $last_active_id ) ) : ?>
                                                        <div class="ce-forum-last-post">
                                                            <div class="ce-forum-last-post-title">
                                                                <a href="<?php echo esc_url( bbp_get_topic_permalink( $last_active_id ) ); ?>">
                                                                    <?php echo esc_html( bbp_get_topic_title( $last_active_id ) ); ?>
                                                                </a>
                                                            </div>
                                                            <div class="ce-forum-last-post-meta">
                                                                <?php
                                                                $last_active_time = bbp_get_forum_last_active_time( $forum->ID );
                                                                $last_poster_id = bbp_get_forum_last_reply_author_id( $forum->ID );
                                                                $last_poster_name = bbp_get_forum_last_reply_author( $forum->ID );
                                                                ?>
                                                                <span class="ce-forum-last-post-time"><?php echo esc_html( $last_active_time ); ?></span>
                                                                <span class="ce-forum-last-post-author">
                                                                    by <a href="<?php echo esc_url( bbp_get_user_profile_url( $last_poster_id ) ); ?>"><?php echo esc_html( $last_poster_name ); ?></a>
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
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <div class="ce-forum-no-forums">
                                            <p>No forums found in this category.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    endforeach;
                else :
                ?>
                    <div class="ce-alert ce-alert-info">
                        <p>No forum categories found.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="ce-forums-online">
                <div class="ce-card">
                    <div class="ce-card-header">
                        <h3 class="ce-card-title">Who's Online</h3>
                    </div>
                    <div class="ce-card-body">
                        <div class="ce-online-users">
                            <?php
                            $online_users = bbp_get_online_users();
                            
                            if ( ! empty( $online_users ) ) :
                                foreach ( $online_users as $user_id ) :
                                    $user = get_userdata( $user_id );
                            ?>
                                <div class="ce-online-user">
                                    <div class="ce-online-user-avatar">
                                        <?php echo get_avatar( $user_id, 40 ); ?>
                                        <span class="ce-online-indicator"></span>
                                    </div>
                                    <div class="ce-online-user-name">
                                        <a href="<?php echo esc_url( bbp_get_user_profile_url( $user_id ) ); ?>">
                                            <?php echo esc_html( $user->display_name ); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php
                                endforeach;
                            else :
                            ?>
                                <div class="ce-no-online-users">
                                    <p>No users currently online.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
