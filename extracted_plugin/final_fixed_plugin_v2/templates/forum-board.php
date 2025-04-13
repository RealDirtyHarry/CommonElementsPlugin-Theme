<?php
/**
 * Template for Forum Board
 *
 * @package Common_Elements_Platform
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$board_id = get_queried_object_id();
$board = get_term( $board_id, 'forum_board' );

if ( ! $board || is_wp_error( $board ) ) {
	wp_redirect( home_url( '/forums/' ) );
	exit;
}

$board_description = term_description( $board_id, 'forum_board' );
$board_icon = get_term_meta( $board_id, 'board_icon', true );
$board_color = get_term_meta( $board_id, 'board_color', true );

$sub_boards = get_terms( array(
	'taxonomy' => 'forum_board',
	'hide_empty' => false,
	'parent' => $board_id,
) );

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$topics_per_page = 20;

$topics_query = new WP_Query( array(
	'post_type' => 'forum_topic',
	'posts_per_page' => $topics_per_page,
	'paged' => $paged,
	'tax_query' => array(
		array(
			'taxonomy' => 'forum_board',
			'field' => 'term_id',
			'terms' => $board_id,
		),
	),
) );

$total_topics = $topics_query->found_posts;
$total_pages = ceil( $total_topics / $topics_per_page );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="ce-forum-board-container">
			<div class="ce-forum-breadcrumbs">
				<a href="<?php echo esc_url( home_url( '/forums/' ) ); ?>">
					<i class="fas fa-home"></i>
					<?php esc_html_e( 'Forums', 'common-elements-platform' ); ?>
				</a>
				
				<?php
				$parent_board = null;
				if ( $board->parent ) {
					$parent_board = get_term( $board->parent, 'forum_board' );
					
					if ( $parent_board && ! is_wp_error( $parent_board ) ) :
					?>
						<span class="ce-breadcrumb-separator">
							<i class="fas fa-chevron-right"></i>
						</span>
						<a href="<?php echo esc_url( get_term_link( $parent_board ) ); ?>">
							<?php echo esc_html( $parent_board->name ); ?>
						</a>
					<?php
					endif;
				}
				?>
				
				<span class="ce-breadcrumb-separator">
					<i class="fas fa-chevron-right"></i>
				</span>
				<span class="ce-breadcrumb-current"><?php echo esc_html( $board->name ); ?></span>
			</div>
			
			<div class="ce-forum-board-header">
				<div class="ce-forum-board-icon" <?php echo ! empty( $board_color ) ? 'style="background-color: ' . esc_attr( $board_color ) . ';"' : ''; ?>>
					<i class="<?php echo ! empty( $board_icon ) ? esc_attr( $board_icon ) : 'fas fa-comments'; ?>"></i>
				</div>
				
				<div class="ce-forum-board-info">
					<h1 class="ce-forum-board-title"><?php echo esc_html( $board->name ); ?></h1>
					
					<?php if ( ! empty( $board_description ) ) : ?>
						<div class="ce-forum-board-description">
							<?php echo wp_kses_post( $board_description ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			
			<?php if ( ! empty( $sub_boards ) && ! is_wp_error( $sub_boards ) ) : ?>
				<div class="ce-forum-sub-boards-container">
					<h2 class="ce-forum-sub-boards-title"><?php esc_html_e( 'Sub-boards', 'common-elements-platform' ); ?></h2>
					
					<div class="ce-forum-boards">
						<?php foreach ( $sub_boards as $sub_board ) :
							$sub_board_description = term_description( $sub_board->term_id, 'forum_board' );
							$sub_board_icon = get_term_meta( $sub_board->term_id, 'board_icon', true );
							$sub_board_color = get_term_meta( $sub_board->term_id, 'board_color', true );
							
							$sub_topics_query = new WP_Query( array(
								'post_type' => 'forum_topic',
								'posts_per_page' => -1,
								'tax_query' => array(
									array(
										'taxonomy' => 'forum_board',
										'field' => 'term_id',
										'terms' => $sub_board->term_id,
									),
								),
							) );
							
							$sub_topic_count = $sub_topics_query->found_posts;
							wp_reset_postdata();
							
							$sub_latest_topic_query = new WP_Query( array(
								'post_type' => 'forum_topic',
								'posts_per_page' => 1,
								'orderby' => 'date',
								'order' => 'DESC',
								'tax_query' => array(
									array(
										'taxonomy' => 'forum_board',
										'field' => 'term_id',
										'terms' => $sub_board->term_id,
									),
								),
							) );
							
							$sub_latest_topic = $sub_latest_topic_query->have_posts() ? $sub_latest_topic_query->posts[0] : null;
							wp_reset_postdata();
						?>
							<div class="ce-forum-board">
								<div class="ce-forum-board-header">
									<div class="ce-forum-board-icon" <?php echo ! empty( $sub_board_color ) ? 'style="background-color: ' . esc_attr( $sub_board_color ) . ';"' : ''; ?>>
										<i class="<?php echo ! empty( $sub_board_icon ) ? esc_attr( $sub_board_icon ) : 'fas fa-comments'; ?>"></i>
									</div>
									
									<div class="ce-forum-board-info">
										<h3 class="ce-forum-board-title">
											<a href="<?php echo esc_url( get_term_link( $sub_board ) ); ?>"><?php echo esc_html( $sub_board->name ); ?></a>
										</h3>
										
										<?php if ( ! empty( $sub_board_description ) ) : ?>
											<div class="ce-forum-board-description">
												<?php echo wp_kses_post( $sub_board_description ); ?>
											</div>
										<?php endif; ?>
									</div>
									
									<div class="ce-forum-board-stats">
										<div class="ce-forum-board-stat">
											<span class="ce-forum-stat-value"><?php echo esc_html( $sub_topic_count ); ?></span>
											<span class="ce-forum-stat-label"><?php echo esc_html( _n( 'Topic', 'Topics', $sub_topic_count, 'common-elements-platform' ) ); ?></span>
										</div>
									</div>
									
									<div class="ce-forum-board-latest">
										<?php if ( $sub_latest_topic ) : ?>
											<div class="ce-forum-latest-topic">
												<div class="ce-forum-latest-topic-title">
													<a href="<?php echo esc_url( get_permalink( $sub_latest_topic->ID ) ); ?>"><?php echo esc_html( $sub_latest_topic->post_title ); ?></a>
												</div>
												
												<div class="ce-forum-latest-topic-meta">
													<?php
													$author_id = $sub_latest_topic->post_author;
													$author_name = get_the_author_meta( 'display_name', $author_id );
													$date = get_the_date( get_option( 'date_format' ), $sub_latest_topic->ID );
													$time = get_the_time( get_option( 'time_format' ), $sub_latest_topic->ID );
													?>
													
													<span class="ce-forum-latest-topic-author">
														<?php echo get_avatar( $author_id, 24 ); ?>
														<?php echo esc_html( $author_name ); ?>
													</span>
													
													<span class="ce-forum-latest-topic-date">
														<i class="fas fa-clock"></i>
														<time datetime="<?php echo esc_attr( get_the_date( 'c', $sub_latest_topic->ID ) ); ?>"><?php echo esc_html( $date . ' ' . $time ); ?></time>
													</span>
												</div>
											</div>
										<?php else : ?>
											<div class="ce-forum-no-topics">
												<?php esc_html_e( 'No topics yet', 'common-elements-platform' ); ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
			
			<div class="ce-forum-topics-container">
				<div class="ce-forum-topics-header">
					<h2 class="ce-forum-topics-title"><?php esc_html_e( 'Topics', 'common-elements-platform' ); ?></h2>
					
					<?php if ( is_user_logged_in() ) : ?>
						<div class="ce-forum-actions">
							<a href="<?php echo esc_url( home_url( '/new-topic/' ) ); ?>" class="ce-button ce-button-primary">
								<i class="fas fa-plus"></i>
								<?php esc_html_e( 'Create New Topic', 'common-elements-platform' ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
				
				<?php if ( $topics_query->have_posts() ) : ?>
					<div class="ce-forum-topics">
						<div class="ce-forum-topics-list">
							<?php while ( $topics_query->have_posts() ) : $topics_query->the_post();
								$topic_id = get_the_ID();
								$author_id = get_the_author_meta( 'ID' );
								$author_name = get_the_author();
								$post_date = get_the_date();
								$post_time = get_the_time();
								$views = get_post_meta( $topic_id, 'topic_views', true ) ? get_post_meta( $topic_id, 'topic_views', true ) : 0;
								$votes = get_post_meta( $topic_id, 'topic_votes', true ) ? get_post_meta( $topic_id, 'topic_votes', true ) : 0;
								$reply_count = wp_count_comments( $topic_id )->approved;
								$has_solution = get_post_meta( $topic_id, 'topic_solution', true ) ? true : false;
							?>
								<div class="ce-forum-topic-item">
									<div class="ce-forum-topic-status">
										<?php if ( $has_solution ) : ?>
											<div class="ce-forum-topic-solved">
												<i class="fas fa-check-circle" title="<?php esc_attr_e( 'Solved', 'common-elements-platform' ); ?>"></i>
											</div>
										<?php else : ?>
											<div class="ce-forum-topic-unsolved">
												<i class="fas fa-question-circle" title="<?php esc_attr_e( 'Unsolved', 'common-elements-platform' ); ?>"></i>
											</div>
										<?php endif; ?>
									</div>
									
									<div class="ce-forum-topic-content">
										<h3 class="ce-forum-topic-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										
										<div class="ce-forum-topic-meta">
											<span class="ce-forum-topic-author">
												<?php echo get_avatar( $author_id, 24 ); ?>
												<?php echo esc_html( $author_name ); ?>
											</span>
											
											<span class="ce-forum-topic-date">
												<i class="fas fa-clock"></i>
												<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( $post_date . ' ' . $post_time ); ?></time>
											</span>
										</div>
									</div>
									
									<div class="ce-forum-topic-stats">
										<div class="ce-forum-topic-stat">
											<span class="ce-forum-stat-value"><?php echo esc_html( $views ); ?></span>
											<span class="ce-forum-stat-label"><?php echo esc_html( _n( 'View', 'Views', $views, 'common-elements-platform' ) ); ?></span>
										</div>
										
										<div class="ce-forum-topic-stat">
											<span class="ce-forum-stat-value"><?php echo esc_html( $reply_count ); ?></span>
											<span class="ce-forum-stat-label"><?php echo esc_html( _n( 'Reply', 'Replies', $reply_count, 'common-elements-platform' ) ); ?></span>
										</div>
										
										<div class="ce-forum-topic-stat">
											<span class="ce-forum-stat-value"><?php echo esc_html( $votes ); ?></span>
											<span class="ce-forum-stat-label"><?php echo esc_html( _n( 'Vote', 'Votes', $votes, 'common-elements-platform' ) ); ?></span>
										</div>
									</div>
									
									<div class="ce-forum-topic-latest">
										<?php
										$latest_reply_query = new WP_Query( array(
											'post_type' => 'forum_reply',
											'posts_per_page' => 1,
											'orderby' => 'date',
											'order' => 'DESC',
											'meta_query' => array(
												array(
													'key' => 'topic_id',
													'value' => $topic_id,
													'compare' => '=',
												),
											),
										) );
										
										if ( $latest_reply_query->have_posts() ) :
											$latest_reply = $latest_reply_query->posts[0];
											$reply_author_id = $latest_reply->post_author;
											$reply_author_name = get_the_author_meta( 'display_name', $reply_author_id );
											$reply_date = get_the_date( get_option( 'date_format' ), $latest_reply->ID );
											$reply_time = get_the_time( get_option( 'time_format' ), $latest_reply->ID );
										?>
											<div class="ce-forum-latest-reply">
												<span class="ce-forum-latest-reply-author">
													<?php echo get_avatar( $reply_author_id, 24 ); ?>
													<?php echo esc_html( $reply_author_name ); ?>
												</span>
												
												<span class="ce-forum-latest-reply-date">
													<i class="fas fa-clock"></i>
													<time datetime="<?php echo esc_attr( get_the_date( 'c', $latest_reply->ID ) ); ?>"><?php echo esc_html( $reply_date . ' ' . $reply_time ); ?></time>
												</span>
											</div>
										<?php
											wp_reset_postdata();
										else :
										?>
											<div class="ce-forum-no-replies">
												<?php esc_html_e( 'No replies yet', 'common-elements-platform' ); ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
						
						<?php if ( $total_pages > 1 ) : ?>
							<div class="ce-forum-pagination">
								<?php
								echo paginate_links( array(
									'base' => get_pagenum_link(1) . '%_%',
									'format' => 'page/%#%',
									'current' => $paged,
									'total' => $total_pages,
									'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __( 'Previous', 'common-elements-platform' ),
									'next_text' => __( 'Next', 'common-elements-platform' ) . ' <i class="fas fa-chevron-right"></i>',
								) );
								?>
							</div>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="ce-forum-no-topics">
						<p><?php esc_html_e( 'No topics found in this board.', 'common-elements-platform' ); ?></p>
						
						<?php if ( is_user_logged_in() ) : ?>
							<p><?php esc_html_e( 'Be the first to create a topic!', 'common-elements-platform' ); ?></p>
							
							<a href="<?php echo esc_url( home_url( '/new-topic/' ) ); ?>" class="ce-button ce-button-primary">
								<i class="fas fa-plus"></i>
								<?php esc_html_e( 'Create New Topic', 'common-elements-platform' ); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
