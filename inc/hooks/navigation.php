<?php
/**
 * Navigations filters.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

use WP_Post;

/**
 * Dropdown caret for primary menu
 *
 * @param string $item_output the menu item output
 * @param WP_Post $item menu item object
 * @param int $depth depth of the menu
 * @param stdObject $args wp_nav_menu() arguments
 *
 * @return string menu item with possible description
 */
add_filter('walker_nav_menu_start_el', function ($item_output, $item, $depth, $args) {

	if ($args->theme_location == 'primary') {
		foreach ($item->classes as $value) {
			if ($value == 'menu-item-has-children') {
				// add caret button. not focusable as tab navigation is handeled without this button
				$item_output .= '<button class="menu-item__caret js-menu-caret">' .
					get_svg(['icon' => 'chevron-down', 'class' => ['menu-item__caret__icon', 'menu-item__caret__icon--desktop', 'menu-item__caret__icon--arrow']]) .
					get_svg(['icon' => 'plus', 'class' => ['menu-item__caret__icon', 'menu-item__caret__icon--mobile', 'menu-item__caret__icon--open']]) .
					get_svg(['icon' => 'minus', 'class' => ['menu-item__caret__icon', 'menu-item__caret__icon--mobile', 'menu-item__caret__icon--close']]) .
					'<span class="menu-item__caret__text-open">' . esc_html__('Ouvrir le sous-menu', 'wp_eclipe') . '</span>' .
					'<span class="menu-item__caret__text-close">' . esc_html__('Fermer le sous-menu', 'wp_eclipe') . '</span>' .
					'</button>';
			}
		}
	}
	return '<span class="menu-item__link">' . $item_output . '</span>';

}, 10, 4);

/**
 * Include icon by class name
 *
 * Example: `icon-arrow` includes svg `arrow` from SVG sprite.
 *
 * @param string $title the title of menu item
 * @param WP_Post $item menu item object
 * @param stdObject $args wp_nav_menu() arguments
 * @param int $depth depth of the menu
 *
 * @return string menu item with possible description
 */
add_filter('nav_menu_item_title', function ($title, $item, $args, $depth) {

	foreach ($item->classes as $value) {
		if (str_starts_with($value, 'icon-')) {
			$svg = get_svg(['icon' => str_replace('icon-', '', $value), 'class' => ['icon-from-class']]);
			if (in_array('after-icon', $item->classes)) {
				$title = trim($title) . $svg;
			} else {
				$title = $svg . trim($title);
			}
		}
	}
	return $title;

}, 10, 4);
