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
	<?php	wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php wp_body_open(); ?>

	<header id="masthead" class="site-header">
		<div class="container">
			<div class="header-inner">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
					<?php if (has_custom_logo()) {
						the_custom_logo();
					} else {
						bloginfo('name');
					} ?>
				</a>
				<button class="menu-toggle" aria-expanded="false" aria-controls="primary-menu">
					☰
				</button>
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => 'nav',
					'container_class'=> 'primary-nav',
				]);
				?>
			</div>
		</div>
	</header>

	<?php print_edit_link(); ?>
