<?php
/**
 * Toggle menu button
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

?>

<button class="menu-toggle js-menu-toggle">
	<span class="menu-toggle__icon">
		<?php echo get_svg( [ 'icon' => 'menu' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in get_svg(). ?>
		<?php echo get_svg( [ 'icon' => 'close' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in get_svg(). ?>
	</span>

	<span class="menu-toggle__label-open">
		<?php esc_html_e( 'Ouvrir le menu', 'wp-eclipse' ); ?>
	</span>

	<span class="menu-toggle__label-close">
		<?php esc_html_e( 'Fermer le menu', 'wp-eclipse' ); ?>
	</span>
</button>
