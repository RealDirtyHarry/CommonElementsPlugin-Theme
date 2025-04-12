<?php
/**
 * Template for Forums Home
 *
 * @package Common_Elements_Platform
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<h1><?php _e( 'Forums', 'common-elements-platform' ); ?></h1>
		<p><?php _e( 'Forums content goes here.', 'common-elements-platform' ); ?></p>
		<?php
		?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
