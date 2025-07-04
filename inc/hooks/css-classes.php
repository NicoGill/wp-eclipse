<?php
/**
 * Filter CSS classes.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Adds custom classes to apply to <main>
 *
 * @author WebDevStudios
 *
 * @param array $new_classes Classes for the <main> element.
 *
 * @return string main classes.
 */
function main_classes( $new_classes ) {

	$classes = [ 'site-main' ];

	if ( ! empty( $new_classes ) ) {
		$classes = array_merge( $classes, $new_classes );
	}

	$classes = apply_filters( 'wp_eclipse_main_classes', $classes );

	return implode( ' ', $classes );
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @author WebDevStudios
 *
 * @param array $classes Classes for the body element.
 *
 * @return array Body classes.
 */
function body_classes( $classes ) {
	// Allows for incorrect snake case like is_IE to be used without throwing errors.
	global $is_IE, $is_edge, $is_safari;

	// If it's IE, add a class.
	if ( $is_IE ) {
		$classes[] = 'ie';
	}

	// If it's Edge, add a class.
	if ( $is_edge ) {
		$classes[] = 'edge';
	}

	// If it's Safari, add a class.
	if ( $is_safari ) {
		$classes[] = 'safari';
	}

	// Are we on mobile?
	if ( wp_is_mobile() ) {
		$classes[] = 'mobile';
	}

	// Give all pages a unique class.
	if ( is_page() ) {
		$classes[] = 'page-' . basename( get_permalink() );
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds "no-js" class. If JS is enabled, this will be replaced (by javascript) to "js".
	$classes[] = 'no-js';

	// Add a `has-sidebar` class if we're using the sidebar template.
	if ( is_page_template( 'templates/sidebar-right.php' ) ) {
		$classes[] = 'has-sidebar';
	}

	return $classes;
}

add_filter( 'body_class', __NAMESPACE__ . '\body_classes' );
