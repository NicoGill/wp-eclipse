<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

defined('ABSPATH') || exit;

?>
		<footer id="colophon" class="site-footer">
			<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
		</footer>

		<?php wp_footer(); ?>

	</body>

</html>
