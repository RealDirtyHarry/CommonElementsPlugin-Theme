<?php
/**
 * The footer for our theme
 *
 * @package Common_Elements
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="footer-widgets">
				<div class="footer-widget-area">
					<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="footer-widget footer-1">
							<?php dynamic_sidebar( 'footer-1' ); ?>
						</div>
					<?php endif; ?>
					
					<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="footer-widget footer-2">
							<?php dynamic_sidebar( 'footer-2' ); ?>
						</div>
					<?php endif; ?>
					
					<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="footer-widget footer-3">
							<?php dynamic_sidebar( 'footer-3' ); ?>
						</div>
					<?php endif; ?>
					
					<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<div class="footer-widget footer-4">
							<?php dynamic_sidebar( 'footer-4' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div><!-- .footer-widgets -->

			<div class="site-info">
				<div class="footer-menu-container">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_id'        => 'footer-menu',
							'container'      => false,
							'menu_class'     => 'footer-menu',
							'depth'          => 1,
						)
					);
					?>
				</div>
				
				<div class="copyright">
					<p>
						&copy; <?php echo date_i18n( 'Y' ); ?> 
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php bloginfo( 'name' ); ?>
						</a>
						<?php esc_html_e( 'All Rights Reserved.', 'common-elements' ); ?>
					</p>
				</div>
			</div><!-- .site-info -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
