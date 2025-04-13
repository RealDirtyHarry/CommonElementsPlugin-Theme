<?php
/**
 * Template for Forum
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
		<div class="ce-forum-container">
			<div class="ce-forum-header">
				<h1 class="ce-forum-title"><?php esc_html_e( 'Community Forums', 'common-elements-platform' ); ?></h1>
				
				<div class="ce-forum-search">
					<form id="ce-forum-search-form" class="ce-search-form">
						<div class="ce-search-input-wrapper">
							<input type="text" name="search" class="ce-forum-search-input" placeholder="<?php esc_attr_e( 'Search forums...', 'common-elements-platform' ); ?>">
							<button type="submit" class="ce-search-button">
								<i class="fas fa-search"></i>
							</button>
						</div>
						
						<div class="ce-forum-search-filter">
							<select name="board_id" class="ce-forum-board-filter">
								<option value=""><?php esc_html_e( 'All Boards', 'common-elements-platform' ); ?></option>
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
					</form>
				</div>
			</div>
			
			<div class="ce-forum-boards">
				<?php
				$boards = get_terms( array(
					'taxonomy' => 'forum_board',
					'hide_empty' => false,
					'parent' => 0,
				) );
				
				if ( ! is_wp_error( $boards ) && ! empty( $boards ) ) :
					foreach ( $boards as $board ) :
						$board_description = term_description( $board->term_id, 'forum_board' );
						$board_icon = get_term_meta( $board->term_id, 'board_icon', true );
						$board_color = get_term_meta( $board->term_id, 'board_color', true );
						
						$topics_query = new WP_Query( array(
							'post_type' => 'forum_topic',
							'posts_per_page' => -1,
							'tax_query' => array(
								array(
									'taxonomy' => 'forum_board',
									'field' => 'term_id',
									'terms' => $board->term_id,
								),
							),
						) );
						
						$topic_count = $topics_query->found_posts;
						wp_reset_postdata();
						
						$latest_topic_query = new WP_Query( array(
							'post_type' => 'forum_topic',
							'posts_per_page' => 1,
							'orderby' => 'date',
							'order' => 'DESC',
							'tax_query' => array(
								array(
									'taxonomy' => 'forum_board',
									'field' => 'term_id',
									'terms' => $board->term_id,
								),
							),
						) );
						
						$latest_topic = $latest_topic_query->have_posts() ? $latest_topic_query->posts[0] : null;
						wp_reset_postdata();
						
						$sub_boards = get_terms( array(
							'taxonomy' => 'forum_board',
							'hide_empty' => false,
							'parent' => $board->term_id,
						) );
				?>
					<div class="ce-forum-board">
						<div class="ce-forum-board-header">
							<div class="ce-forum-board-icon" <?php echo ! empty( $board_color ) ? 'style="background-color: ' . esc_attr( $board_color ) . ';"' : ''; ?>>
								<i class="<?php echo ! empty( $board_icon ) ? esc_attr( $board_icon ) : 'fas fa-comments'; ?>"></i>
							</div>
							
							<div class="ce-forum-board-info">
								<h2 class="ce-forum-board-title">
									<a href="<?php echo esc_url( get_term_link( $board ) ); ?>"><?php echo esc_html( $board->name ); ?></a>
								</h2>
								
								<?php if ( ! empty( $board_description ) ) : ?>
									<div class="ce-forum-board-description">
										<?php echo wp_kses_post( $board_description ); ?>
									</div>
								<?php endif; ?>
								
								<?php if ( ! empty( $sub_boards ) && ! is_wp_error( $sub_boards ) ) : ?>
									<div class="ce-forum-sub-boards">
										<span class="ce-forum-sub-boards-label"><?php esc_html_e( 'Sub-boards:', 'common-elements-platform' ); ?></span>
										<ul class="ce-forum-sub-board-list">
											<?php foreach ( $sub_boards as $sub_board ) : ?>
												<li class="ce-forum-sub-board-item">
													<a href="<?php echo esc_url( get_term_link( $sub_board ) ); ?>"><?php echo esc_html( $sub_board->name ); ?></a>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
							</div>
							
							<div class="ce-forum-board-stats">
								<div class="ce-forum-board-stat">
									<span class="ce-forum-stat-value"><?php echo esc_html( $topic_count ); ?></span>
									<span class="ce-forum-stat-label"><?php echo esc_html( _n( 'Topic', 'Topics', $topic_count, 'common-elements-platform' ) ); ?></span>
								</div>
							</div>
							
							<div class="ce-forum-board-latest">
								<?php if ( $latest_topic ) : ?>
									<div class="ce-forum-latest-topic">
										<div class="ce-forum-latest-topic-title">
											<a href="<?php echo esc_url( get_permalink( $latest_topic->ID ) ); ?>"><?php echo esc_html( $latest_topic->post_title ); ?></a>
										</div>
										
										<div class="ce-forum-latest-topic-meta">
											<?php
											$author_id = $latest_topic->post_author;
											$author_name = get_the_author_meta( 'display_name', $author_id );
											$date = get_the_date( get_option( 'date_format' ), $latest_topic->ID );
											$time = get_the_time( get_option( 'time_format' ), $latest_topic->ID );
											?>
											
											<span class="ce-forum-latest-topic-author">
												<?php echo get_avatar( $author_id, 24 ); ?>
												<?php echo esc_html( $author_name ); ?>
											</span>
											
											<span class="ce-forum-latest-topic-date">
												<i class="fas fa-clock"></i>
												<time datetime="<?php echo esc_attr( get_the_date( 'c', $latest_topic->ID ) ); ?>"><?php echo esc_html( $date . ' ' . $time ); ?></time>
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
				<?php
					endforeach;
				else :
				?>
					<div class="ce-forum-no-boards">
						<p><?php esc_html_e( 'No forum boards found.', 'common-elements-platform' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
			
			<?php if ( is_user_logged_in() ) : ?>
				<div class="ce-forum-actions">
					<a href="<?php echo esc_url( home_url( '/new-topic/' ) ); ?>" class="ce-button ce-button-primary">
						<i class="fas fa-plus"></i>
						<?php esc_html_e( 'Create New Topic', 'common-elements-platform' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
