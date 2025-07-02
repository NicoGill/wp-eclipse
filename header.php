<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

defined('ABSPATH') || exit;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<div id="page" class="site js-page">

		<header id="masthead" class="site-header">
			<div class="site-header__inner">

				<?php
				$custom_logo_id = get_theme_mod( 'custom_logo' );

				if ( $custom_logo_id ) : ?>
					<div class="site-header__branding">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
							<?php echo wp_get_attachment_image( $custom_logo_id, 'full' ); ?>
						</a>
					</div>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'primary' ) ) : ?>
					<nav class="js-navigation primary-navigation site-header__main desktop-menu" data-navigation-type="desktop" aria-label="Menu principal">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => '',
								'menu_class'     => 'header-navigation primary-navigation__items',
								'link_before'    => '',
								'link_after'     => '',
								'fallback_cb'    => '',
								'depth'          => 2,
							)
						);
						?>
					</nav>
				<?php endif; ?>

				<?php get_template_part('template-parts/global/menu-toggle'); ?>
			</div>
		</header>

		<?php print_edit_link(); ?>
