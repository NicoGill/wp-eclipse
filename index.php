<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

defined('ABSPATH') || exit;

get_header();

?>

<main id="primary" class="site-main" role="main">
	<div class="wrapper">
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php single_post_title(); ?></h1>
			</header>

			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part('template-parts/post/teaser');

			endwhile;

			the_posts_navigation();

		else : ?>

			<p><?php esc_html_e('Il n\'y a pas de contenu à afficher.', 'wp_eclipse'); ?></p>

		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
