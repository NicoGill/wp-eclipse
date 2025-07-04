<?php

/**
 * The template for displaying a static front page.
 *
 * @package NicoGill\wp_eclipse
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#home-page-display
 */

namespace NicoGill\wp_eclipse;

defined('ABSPATH') || exit;

get_header();
?>

    <main id="primary" class="site-main site-main--front" role="main">
		<div class="wrapper">
			<?php
			while (have_posts()) :
				the_post();
				the_content();
			endwhile;
			?>
		</div>
    </main>

<?php get_footer(); ?>
