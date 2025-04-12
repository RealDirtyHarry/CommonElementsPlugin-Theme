<?php
/**
 * Custom template tags for this theme
 *
 * @package Common_Elements
 */

if ( ! function_exists( 'common_elements_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function common_elements_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'common-elements' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'common_elements_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function common_elements_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'common-elements' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;

if ( ! function_exists( 'common_elements_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function common_elements_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'common-elements' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'common-elements' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'common-elements' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'common-elements' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'common-elements' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'common-elements' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'common_elements_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function common_elements_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'common_elements_dashboard_header' ) ) :
	/**
	 * Displays the dashboard header for logged-in users.
	 */
	function common_elements_dashboard_header() {
		// Get current user
		$current_user = wp_get_current_user();
		
		// Determine user role for dashboard type
		$user_roles = $current_user->roles;
		$dashboard_type = 'member'; // Default
		
		if ( in_array( 'administrator', $user_roles ) || in_array( 'editor', $user_roles ) ) {
			$dashboard_type = 'board';
		} elseif ( in_array( 'author', $user_roles ) ) {
			$dashboard_type = 'cam';
		} elseif ( in_array( 'contributor', $user_roles ) ) {
			$dashboard_type = 'vendor';
		}
		
		// Dashboard header HTML
		?>
		<div class="dashboard-header">
			<div class="container">
				<div class="dashboard-header-inner">
					<div class="dashboard-welcome">
						<h2><?php printf( esc_html__( 'Welcome, %s', 'common-elements' ), esc_html( $current_user->display_name ) ); ?></h2>
						<p class="dashboard-role">
							<?php 
							switch ( $dashboard_type ) {
								case 'board':
									esc_html_e( 'Board Member Dashboard', 'common-elements' );
									break;
								case 'cam':
									esc_html_e( 'CAM Professional Dashboard', 'common-elements' );
									break;
								case 'vendor':
									esc_html_e( 'Vendor Dashboard', 'common-elements' );
									break;
								default:
									esc_html_e( 'Member Dashboard', 'common-elements' );
							}
							?>
						</p>
					</div>
					
					<div class="dashboard-actions">
						<a href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>" class="dashboard-action-button">
							<?php esc_html_e( 'Dashboard Home', 'common-elements' ); ?>
						</a>
						
						<?php if ( $dashboard_type === 'board' || $dashboard_type === 'cam' ) : ?>
							<a href="<?php echo esc_url( home_url( '/rfp/' ) ); ?>" class="dashboard-action-button">
								<?php esc_html_e( 'RFP System', 'common-elements' ); ?>
							</a>
						<?php endif; ?>
						
						<?php if ( $dashboard_type === 'vendor' ) : ?>
							<a href="<?php echo esc_url( home_url( '/rfp-proposals/' ) ); ?>" class="dashboard-action-button">
								<?php esc_html_e( 'My Proposals', 'common-elements' ); ?>
							</a>
						<?php endif; ?>
						
						<a href="<?php echo esc_url( home_url( '/directory/' ) ); ?>" class="dashboard-action-button">
							<?php esc_html_e( 'Directory', 'common-elements' ); ?>
						</a>
						
						<a href="<?php echo esc_url( home_url( '/learning-hub/' ) ); ?>" class="dashboard-action-button">
							<?php esc_html_e( 'Learning Hub', 'common-elements' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
endif;
