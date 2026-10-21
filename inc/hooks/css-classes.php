<?php
/**
 * Filter CSS classes.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array Body classes.
 */
function body_classes( $classes ) {
	// Give all pages a unique class.
	if ( is_page() ) {
		$classes[] = 'page-' . basename( get_permalink() );
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', __NAMESPACE__ . '\body_classes' );
