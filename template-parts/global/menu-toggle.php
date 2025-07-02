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
		<?php echo get_svg(['icon' => 'menu']); ?>
		<?php echo get_svg(['icon' => 'close']); ?>
	</span>

	<span class="menu-toggle__label-open">
		<?php esc_html_e('Ouvrir le menu', 'wp_eclipse'); ?>
	</span>

	<span class="menu-toggle__label-close">
		<?php esc_html_e('Fermer le menu', 'wp_eclipse'); ?>
	</span>
</button>
