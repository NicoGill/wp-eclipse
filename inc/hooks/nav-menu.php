<?php
/**
 * Nav menus hooks.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Remove IDs from menu items.
 *
 * @param string $id The ID of the menu item.
 * @param object $item The current menu item.
 * @param object $args An object containing wp_nav_menu() arguments.
 *
 * @return string The ID of the menu item.
 */
function clear_nav_menu_item_id( $id, $item, $args ) {
	return '';
}
add_filter( 'nav_menu_item_id', __NAMESPACE__ . '\clear_nav_menu_item_id', 10, 3 );

/**
 * Replace menu title by SVG icon.
 *
 * @param string $title The menu item title.
 * @param array  $item The menu item.
 * @param object $args The menu arguments.
 * @param int    $depth The depth of the menu.
 *
 * @return string The modified menu items.
 */
function socials_nav_menu_item_title( $title, $item, $args, $depth ) {

	if ( $args->theme_location !== 'socials' ) {
		return $title;
	}

	// supported social icons
	$social_icons = array(
		'facebook.com'  => 'facebook',
		'instagram.com' => 'instagram',
		'tiktok.com'    => 'tiktok',
		'linkedin.com'  => 'linkedin',
	);

	// fallback icon
	$svg = 'external';

	// find matching icon
	foreach ( $social_icons as $domain => $value ) {
		if ( strstr( $item->url, $domain ) ) {
			$svg = $value;
		}
	}

	// replace title with svg and <span> wrapped title
	$title = get_svg( array( 'icon' => $svg ) ) . '<span class="screen-reader-text">' . $title . '</span>';

	return $title;
}
add_filter( 'nav_menu_item_title', __NAMESPACE__ . '\socials_nav_menu_item_title', 10, 4 );
