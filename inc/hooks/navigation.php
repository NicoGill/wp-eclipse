<?php
/**
 * Nav menus filters: item markup, carets and icons.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Remove IDs from menu items.
 *
 * @return string Empty ID.
 */
function clear_nav_menu_item_id() {
	return '';
}
add_filter( 'nav_menu_item_id', __NAMESPACE__ . '\clear_nav_menu_item_id' );

/**
 * Wrap item output and add a caret button to parent items of the primary menu.
 *
 * @param string    $item_output The menu item's starting HTML output.
 * @param \WP_Post  $item        Menu item data object.
 * @param int       $depth       Depth of menu item.
 * @param \stdClass $args        An object of wp_nav_menu() arguments.
 *
 * @return string Menu item output.
 */
function nav_menu_caret( $item_output, $item, $depth, $args ) {
	if ( 'primary' === $args->theme_location && in_array( 'menu-item-has-children', $item->classes, true ) ) {
		// Not focusable: keyboard navigation is handled without this button.
		$item_output .= '<button class="menu-item__caret js-menu-caret">'
			. get_svg(
				[
					'icon'  => 'chevron-down',
					'class' => [ 'menu-item__caret__icon', 'menu-item__caret__icon--desktop', 'menu-item__caret__icon--arrow' ],
				]
			)
			. get_svg(
				[
					'icon'  => 'plus',
					'class' => [ 'menu-item__caret__icon', 'menu-item__caret__icon--mobile', 'menu-item__caret__icon--open' ],
				]
			)
			. get_svg(
				[
					'icon'  => 'minus',
					'class' => [ 'menu-item__caret__icon', 'menu-item__caret__icon--mobile', 'menu-item__caret__icon--close' ],
				]
			)
			. '<span class="menu-item__caret__text-open">' . esc_html__( 'Ouvrir le sous-menu', 'wp-eclipse' ) . '</span>'
			. '<span class="menu-item__caret__text-close">' . esc_html__( 'Fermer le sous-menu', 'wp-eclipse' ) . '</span>'
			. '</button>';
	}

	return '<span class="menu-item__link">' . $item_output . '</span>';
}
add_filter( 'walker_nav_menu_start_el', __NAMESPACE__ . '\nav_menu_caret', 10, 4 );

/**
 * Replace titles with sprite icons.
 *
 * Socials menu: icon picked from the link domain, title kept for screen readers.
 * Any menu: an `icon-{name}` CSS class on the item prepends that icon (`after-icon` appends it).
 *
 * @param string    $title The menu item's title.
 * @param \WP_Post  $item  The current menu item object.
 * @param \stdClass $args  An object of wp_nav_menu() arguments.
 *
 * @return string Menu item title.
 */
function nav_menu_item_icon( $title, $item, $args ) {
	if ( 'socials' === $args->theme_location ) {
		$social_icons = [
			'facebook.com'  => 'facebook',
			'instagram.com' => 'instagram',
			'tiktok.com'    => 'tiktok',
			'linkedin.com'  => 'linkedin',
			'youtube.com'   => 'youtube',
		];

		foreach ( $social_icons as $domain => $icon ) {
			if ( str_contains( $item->url, $domain ) ) {
				return get_svg( [ 'icon' => $icon ] ) . '<span class="screen-reader-text">' . $title . '</span>';
			}
		}

		return $title; // Unknown network: keep the text label.
	}

	foreach ( $item->classes as $class ) {
		if ( str_starts_with( $class, 'icon-' ) ) {
			$svg   = get_svg(
				[
					'icon'  => substr( $class, 5 ),
					'class' => [ 'icon-from-class' ],
				]
			);
			$title = in_array( 'after-icon', $item->classes, true ) ? trim( $title ) . $svg : $svg . trim( $title );
		}
	}

	return $title;
}
add_filter( 'nav_menu_item_title', __NAMESPACE__ . '\nav_menu_item_icon', 10, 3 );
