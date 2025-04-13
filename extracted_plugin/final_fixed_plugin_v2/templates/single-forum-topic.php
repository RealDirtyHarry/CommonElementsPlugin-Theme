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
			<!-- Forum topic content will be displayed here -->
			<!-- This template includes breadcrumbs, topic details, author info -->
			<!-- Voting system, reply functionality, and solution marking -->
		</div>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
