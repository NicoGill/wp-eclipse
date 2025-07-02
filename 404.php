<?php
/**
 *
 * The template file used to render the 404 page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

defined('ABSPATH') || exit;

get_header();

?>

<main id="main" class="site-main site-main--404" role="main">
	<section class="container-404">
		<div class="container-404__inner">
			<header class="header-404">
				<h1 class="header-404__title"><?php esc_html_e('404', 'wp_eclipse'); ?></h1>
				<p class="header-404__text"><?php esc_html_e('Oups, cette page n\'existe pas', 'wp_eclipse'); ?></p>
			</header>
			<footer class="footer-404">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button">
					<?php esc_html_e('Retour à l\'accueil', 'wp_eclipse'); ?>
				</a>
			</footer>
		</div>
	</section>
</main>

<?php
get_footer();
