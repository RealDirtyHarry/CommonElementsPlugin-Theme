<?php
/**
 * Template for Single Forum Topic
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
		<div class="ce-forum-single-topic">
			<?php
			while ( have_posts() ) :
				the_post();
				
				$topic_id = get_the_ID();
				$author_id = get_the_author_meta( 'ID' );
				$author_name = get_the_author();
				$author_role = get_the_author_meta( 'role' );
				$author_avatar = get_avatar_url( $author_id, array( 'size' => 96 ) );
				$post_date = get_the_date();
				$post_time = get_the_time();
				$views = get_post_meta( $topic_id, 'topic_views', true ) ? get_post_meta( $topic_id, 'topic_views', true ) : 0;
				$votes = get_post_meta( $topic_id, 'topic_votes', true ) ? get_post_meta( $topic_id, 'topic_votes', true ) : 0;
				$user_vote = 0;
				
				if ( is_user_logged_in() ) {
					$current_user_id = get_current_user_id();
					$user_votes = get_post_meta( $topic_id, 'user_votes', true ) ? get_post_meta( $topic_id, 'user_votes', true ) : array();
					
					if ( isset( $user_votes[ $current_user_id ] ) ) {
						$user_vote = $user_votes[ $current_user_id ];
					}
				}
				
				$boards = wp_get_object_terms( $topic_id, 'forum_board' );
				$board = ! empty( $boards ) && ! is_wp_error( $boards ) ? $boards[0] : null;
				
				$solution_id = get_post_meta( $topic_id, 'topic_solution', true );
				
				$views++;
				update_post_meta( $topic_id, 'topic_views', $views );
			?>
				<div class="ce-forum-breadcrumbs">
					<a href="<?php echo esc_url( home_url( '/forums/' ) ); ?>">
						<i class="fas fa-home"></i>
						<?php esc_html_e( 'Forums', 'common-elements-platform' ); ?>
					</a>
					
					<?php if ( $board ) : ?>
						<span class="ce-breadcrumb-separator">
							<i class="fas fa-chevron-right"></i>
						</span>
						<a href="<?php echo esc_url( get_term_link( $board ) ); ?>">
							<?php echo esc_html( $board->name ); ?>
						</a>
					<?php endif; ?>
					
					<span class="ce-breadcrumb-separator">
						<i class="fas fa-chevron-right"></i>
					</span>
					<span class="ce-breadcrumb-current"><?php the_title(); ?></span>
				</div>
				
				<div class="ce-forum-topic">
					<div class="ce-forum-topic-header">
						<h1 class="ce-forum-topic-title"><?php the_title(); ?></h1>
						
						<div class="ce-forum-topic-meta">
							<?php if ( $board ) : ?>
								<div class="ce-forum-topic-board">
									<i class="fas fa-folder"></i>
									<a href="<?php echo esc_url( get_term_link( $board ) ); ?>"><?php echo esc_html( $board->name ); ?></a>
								</div>
							<?php endif; ?>
							
							<div class="ce-forum-topic-views">
								<i class="fas fa-eye"></i>
								<span><?php echo esc_html( sprintf( _n( '%s view', '%s views', $views, 'common-elements-platform' ), number_format_i18n( $views ) ) ); ?></span>
							</div>
							
							<div class="ce-forum-topic-date">
								<i class="fas fa-calendar-alt"></i>
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( $post_date . ' ' . $post_time ); ?></time>
							</div>
						</div>
					</div>
					
					<div class="ce-forum-topic-content">
						<div class="ce-forum-topic-author">
							<div class="ce-forum-author-avatar">
								<?php echo get_avatar( $author_id, 96 ); ?>
							</div>
							
							<div class="ce-forum-author-info">
								<div class="ce-forum-author-name"><?php echo esc_html( $author_name ); ?></div>
								
								<?php if ( ! empty( $author_role ) ) : ?>
									<div class="ce-forum-author-role"><?php echo esc_html( $author_role ); ?></div>
								<?php endif; ?>
								
								<div class="ce-forum-author-posts">
									<?php
									$author_posts = count_user_posts( $author_id, 'forum_topic' );
									echo esc_html( sprintf( _n( '%s topic', '%s topics', $author_posts, 'common-elements-platform' ), number_format_i18n( $author_posts ) ) );
									?>
								</div>
							</div>
						</div>
						
						<div class="ce-forum-topic-body">
							<div class="ce-forum-topic-text">
								<?php the_content(); ?>
							</div>
							
							<div class="ce-forum-topic-actions">
								<div class="ce-forum-voting">
									<button class="ce-forum-vote-button ce-forum-upvote <?php echo $user_vote > 0 ? 'active' : ''; ?>" data-post-id="<?php echo esc_attr( $topic_id ); ?>">
										<i class="fas fa-chevron-up"></i>
									</button>
									
									<span class="ce-forum-vote-count"><?php echo esc_html( $votes ); ?></span>
									
									<button class="ce-forum-vote-button ce-forum-downvote <?php echo $user_vote < 0 ? 'active' : ''; ?>" data-post-id="<?php echo esc_attr( $topic_id ); ?>">
										<i class="fas fa-chevron-down"></i>
									</button>
								</div>
								
								<?php if ( is_user_logged_in() ) : ?>
									<button class="ce-forum-reply-button ce-forum-reply-to-topic">
										<i class="fas fa-reply"></i>
										<?php esc_html_e( 'Reply', 'common-elements-platform' ); ?>
									</button>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="ce-forum-topic-replies">
					<h2 class="ce-forum-replies-title">
						<?php
						$reply_count = wp_count_comments( $topic_id )->approved;
						echo esc_html( sprintf( _n( '%s Reply', '%s Replies', $reply_count, 'common-elements-platform' ), number_format_i18n( $reply_count ) ) );
						?>
					</h2>
					
					<?php
					$args = array(
						'post_type' => 'forum_reply',
						'posts_per_page' => -1,
						'post_parent' => 0,
						'meta_query' => array(
							array(
								'key' => 'topic_id',
								'value' => $topic_id,
								'compare' => '=',
							),
						),
						'orderby' => 'date',
						'order' => 'ASC',
					);
					
					$replies_query = new WP_Query( $args );
					
					if ( $replies_query->have_posts() ) :
						while ( $replies_query->have_posts() ) :
							$replies_query->the_post();
							
							$reply_id = get_the_ID();
							$reply_author_id = get_the_author_meta( 'ID' );
							$reply_author_name = get_the_author();
							$reply_author_role = get_the_author_meta( 'role' );
							$reply_date = get_the_date();
							$reply_time = get_the_time();
							$reply_votes = get_post_meta( $reply_id, 'reply_votes', true ) ? get_post_meta( $reply_id, 'reply_votes', true ) : 0;
							$reply_user_vote = 0;
							
							if ( is_user_logged_in() ) {
								$current_user_id = get_current_user_id();
								$reply_user_votes = get_post_meta( $reply_id, 'user_votes', true ) ? get_post_meta( $reply_id, 'user_votes', true ) : array();
								
								if ( isset( $reply_user_votes[ $current_user_id ] ) ) {
									$reply_user_vote = $reply_user_votes[ $current_user_id ];
								}
							}
							
							$is_solution = $solution_id && $solution_id == $reply_id;
							$can_mark_solution = is_user_logged_in() && ( get_current_user_id() == $author_id || current_user_can( 'manage_options' ) );
					?>
							<div class="ce-forum-reply <?php echo $is_solution ? 'ce-forum-solution' : ''; ?>" data-reply-id="<?php echo esc_attr( $reply_id ); ?>">
								<?php if ( $is_solution ) : ?>
									<div class="ce-forum-solution-badge">
										<i class="fas fa-check-circle"></i>
										<?php esc_html_e( 'Solution', 'common-elements-platform' ); ?>
									</div>
								<?php endif; ?>
								
								<div class="ce-forum-reply-content">
									<div class="ce-forum-reply-author">
										<div class="ce-forum-author-avatar">
											<?php echo get_avatar( $reply_author_id, 64 ); ?>
										</div>
										
										<div class="ce-forum-author-info">
											<div class="ce-forum-author-name"><?php echo esc_html( $reply_author_name ); ?></div>
											
											<?php if ( ! empty( $reply_author_role ) ) : ?>
												<div class="ce-forum-author-role"><?php echo esc_html( $reply_author_role ); ?></div>
											<?php endif; ?>
										</div>
									</div>
									
									<div class="ce-forum-reply-body">
										<div class="ce-forum-reply-meta">
											<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( $reply_date . ' ' . $reply_time ); ?></time>
										</div>
										
										<div class="ce-forum-reply-text">
											<?php the_content(); ?>
										</div>
										
										<div class="ce-forum-reply-actions">
											<div class="ce-forum-voting">
												<button class="ce-forum-vote-button ce-forum-upvote <?php echo $reply_user_vote > 0 ? 'active' : ''; ?>" data-post-id="<?php echo esc_attr( $reply_id ); ?>">
													<i class="fas fa-chevron-up"></i>
												</button>
												
												<span class="ce-forum-vote-count"><?php echo esc_html( $reply_votes ); ?></span>
												
												<button class="ce-forum-vote-button ce-forum-downvote <?php echo $reply_user_vote < 0 ? 'active' : ''; ?>" data-post-id="<?php echo esc_attr( $reply_id ); ?>">
													<i class="fas fa-chevron-down"></i>
												</button>
											</div>
											
											<?php if ( is_user_logged_in() ) : ?>
												<button class="ce-forum-reply-button" data-parent-id="<?php echo esc_attr( $reply_id ); ?>">
													<i class="fas fa-reply"></i>
													<?php esc_html_e( 'Reply', 'common-elements-platform' ); ?>
												</button>
												
												<?php if ( $can_mark_solution && ! $is_solution ) : ?>
													<button class="ce-forum-mark-solution" data-reply-id="<?php echo esc_attr( $reply_id ); ?>" data-topic-id="<?php echo esc_attr( $topic_id ); ?>">
														<i class="fas fa-check-circle"></i>
														<?php esc_html_e( 'Mark as Solution', 'common-elements-platform' ); ?>
													</button>
												<?php endif; ?>
											<?php endif; ?>
										</div>
									</div>
								</div>
								
								<div class="ce-forum-nested-replies">
									<?php
									$nested_args = array(
										'post_type' => 'forum_reply',
										'posts_per_page' => -1,
										'post_parent' => $reply_id,
										'orderby' => 'date',
										'order' => 'ASC',
									);
									
									$nested_replies_query = new WP_Query( $nested_args );
									
									if ( $nested_replies_query->have_posts() ) :
										while ( $nested_replies_query->have_posts() ) :
											$nested_replies_query->the_post();
											
											$nested_reply_id = get_the_ID();
											$nested_reply_author_id = get_the_author_meta( 'ID' );
											$nested_reply_author_name = get_the_author();
											$nested_reply_author_role = get_the_author_meta( 'role' );
											$nested_reply_date = get_the_date();
											$nested_reply_time = get_the_time();
									?>
											<div class="ce-forum-reply ce-forum-nested-reply" data-reply-id="<?php echo esc_attr( $nested_reply_id ); ?>">
												<div class="ce-forum-reply-content">
													<div class="ce-forum-reply-author">
														<div class="ce-forum-author-avatar">
															<?php echo get_avatar( $nested_reply_author_id, 48 ); ?>
														</div>
														
														<div class="ce-forum-author-info">
															<div class="ce-forum-author-name"><?php echo esc_html( $nested_reply_author_name ); ?></div>
															
															<?php if ( ! empty( $nested_reply_author_role ) ) : ?>
																<div class="ce-forum-author-role"><?php echo esc_html( $nested_reply_author_role ); ?></div>
															<?php endif; ?>
														</div>
													</div>
													
													<div class="ce-forum-reply-body">
														<div class="ce-forum-reply-meta">
															<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( $nested_reply_date . ' ' . $nested_reply_time ); ?></time>
														</div>
														
														<div class="ce-forum-reply-text">
															<?php the_content(); ?>
														</div>
													</div>
												</div>
											</div>
									<?php
										endwhile;
										wp_reset_postdata();
									endif;
									?>
								</div>
							</div>
					<?php
						endwhile;
						wp_reset_postdata();
					else :
					?>
						<div class="ce-forum-no-replies">
							<p><?php esc_html_e( 'No replies yet. Be the first to reply!', 'common-elements-platform' ); ?></p>
						</div>
					<?php endif; ?>
				</div>
				
				<?php if ( is_user_logged_in() ) : ?>
					<div id="ce-forum-reply-form-container" style="display: none;">
						<h3 class="ce-forum-reply-form-title"><?php esc_html_e( 'Post a Reply', 'common-elements-platform' ); ?></h3>
						
						<form id="ce-forum-reply-form" class="ce-forum-reply-form">
							<?php wp_nonce_field( 'common_elements_platform_nonce', 'nonce' ); ?>
							<input type="hidden" name="topic_id" value="<?php echo esc_attr( $topic_id ); ?>">
							<input type="hidden" name="parent_id" value="0">
							
							<div class="ce-form-row">
								<textarea name="content" rows="6" placeholder="<?php esc_attr_e( 'Write your reply here...', 'common-elements-platform' ); ?>" required></textarea>
							</div>
							
							<div class="ce-form-row">
								<button type="submit" class="ce-button ce-button-primary">
									<i class="fas fa-paper-plane"></i>
									<?php esc_html_e( 'Post Reply', 'common-elements-platform' ); ?>
								</button>
								
								<button type="button" class="ce-button ce-button-secondary ce-forum-cancel-reply">
									<i class="fas fa-times"></i>
									<?php esc_html_e( 'Cancel', 'common-elements-platform' ); ?>
								</button>
							</div>
							
							<div class="ce-form-error-message" style="display: none;"></div>
						</form>
					</div>
					
					<script>
					jQuery(document).ready(function($) {
						$(document).on('click', '.ce-forum-cancel-reply', function(e) {
							e.preventDefault();
							$('#ce-forum-reply-form-container').hide();
							$('#ce-forum-reply-form')[0].reset();
							$('#ce-forum-reply-form input[name="parent_id"]').val(0);
						});
					});
					</script>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
