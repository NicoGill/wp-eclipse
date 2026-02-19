<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

defined( 'ABSPATH' ) || exit;

?>
			<footer id="colophon" class="site-footer">
				<div class="site-footer__inner">
					<p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?></p>
				</div>
			</footer>

			<div class="mobile-menu js-mobile-menu">
				<div class="mobile-menu__nav" role="dialog">

					<?php get_template_part( 'template-parts/global/menu-toggle' ); ?>

					<div class="mobile-menu__nav__inner">
						<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<nav class="js-navigation primary-navigation" data-navigation-type="mobile" aria-label="Menu principal">
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
					</div>
				</div>
				<div class="mobile-menu__overlay" data-a11y-dialog-hide tabindex="-1"></div>
			</div>

		</div><!-- #page -->

		<?php wp_footer(); ?>

	</body>

</html>
