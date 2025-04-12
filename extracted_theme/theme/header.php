<?php
/**
 * The header for our theme
 *
 * @package Common_Elements
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'common-elements' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container">
			<div class="site-header-inner">
				<div class="site-branding">
					<?php
					the_custom_logo();
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					else :
						?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;
					$common_elements_description = get_bloginfo( 'description', 'display' );
					if ( $common_elements_description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $common_elements_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<?php endif; ?>
				</div><!-- .site-branding -->

				<nav id="site-navigation" class="main-navigation">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="menu-toggle-icon"></span>
						<?php esc_html_e( 'Menu', 'common-elements' ); ?>
					</button>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'menu_class'     => 'primary-menu',
						)
					);
					?>
				</nav><!-- #site-navigation -->

				<div class="header-actions">
					<?php if ( class_exists( 'BuddyPress' ) && is_user_logged_in() ) : ?>
						<div class="user-account-menu">
							<a href="<?php echo esc_url( bp_loggedin_user_domain() ); ?>" class="user-account-link">
								<?php echo get_avatar( get_current_user_id(), 40 ); ?>
								<span class="user-name"><?php echo esc_html( bp_core_get_user_displayname( get_current_user_id() ) ); ?></span>
							</a>
							<div class="user-account-dropdown">
								<ul>
									<li><a href="<?php echo esc_url( bp_loggedin_user_domain() ); ?>"><?php esc_html_e( 'Profile', 'common-elements' ); ?></a></li>
									<li><a href="<?php echo esc_url( bp_loggedin_user_domain() . 'settings/' ); ?>"><?php esc_html_e( 'Settings', 'common-elements' ); ?></a></li>
									<?php if ( current_user_can( 'manage_options' ) ) : ?>
										<li><a href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Admin', 'common-elements' ); ?></a></li>
									<?php endif; ?>
									<li><a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php esc_html_e( 'Log Out', 'common-elements' ); ?></a></li>
								</ul>
							</div>
						</div>
					<?php else : ?>
						<div class="login-buttons">
							<a href="<?php echo esc_url( wp_login_url() ); ?>" class="login-button"><?php esc_html_e( 'Log In', 'common-elements' ); ?></a>
							<a href="<?php echo esc_url( wp_registration_url() ); ?>" class="register-button"><?php esc_html_e( 'Register', 'common-elements' ); ?></a>
						</div>
					<?php endif; ?>
				</div><!-- .header-actions -->
			</div><!-- .site-header-inner -->
		</div><!-- .container -->
	</header><!-- #masthead -->

	<?php if ( function_exists( 'common_elements_dashboard_header' ) && is_user_logged_in() ) : ?>
		<?php common_elements_dashboard_header(); ?>
	<?php endif; ?>

	<div id="content" class="site-content">
