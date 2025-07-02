<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

defined('ABSPATH') || exit;

get_header();

?>

<main id="primary" class="site-main site-main--search">
	<header class="page-header">
		<h1 class="page-title">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Résultats de recherche pour: %s', 'wp_eclipse' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h1>
	</header>
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post(); ?>

			<article>
				<header>
					<?php the_title(); ?>
				</header>
				<div>
					<?php the_excerpt(); ?>
				</div>
				<footer>
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php esc_html_e('En savoir plus', 'wp_eclipse'); ?>
					</a>
				</footer>
			</article>
		<?php
		endwhile;

		the_posts_navigation();

	else : ?>

		<p><?php esc_html_e('Rien ne correspond à votre recherche.', 'wp_eclipse'); ?></p>

	<?php endif; ?>
</main>

<?php get_footer(); ?>
