<?php
/**
 * Template part for displaying post preview
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

?>

<article>
	<header>
		<?php print_post_primary_term_link(); ?>

		<?php the_post_thumbnail( 'medium' ); ?>

		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

		<?php print_post_date(); ?>
	</header>
	<div>
		<?php the_excerpt(); ?>
	</div>
	<footer>
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<?php esc_html_e( 'En savoir plus', 'wp_eclipse' ); ?>
		</a>
	</footer>
</article>
