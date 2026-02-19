<?php
/**
 *
 * The template for displaying archive pages
 * *
 * * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

defined( 'ABSPATH' ) || exit;

get_header();

?>

<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/post/teaser' );
		endwhile;

		the_posts_navigation();

	else :
		?>

		<p><?php esc_html_e( 'Il n\'y a pas de contenu à afficher.', 'wp_eclipse' ); ?></p>

	<?php endif; ?>
</main>

<?php
get_footer();
