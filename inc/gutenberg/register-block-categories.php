<?php
/**
 * Register custom block category(ies).
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Register_wp_eclipse_category
 *
 * @param array $categories block categories.
 * @return array $categories block categories.
 * @author WebDevStudios
 */
function register_wp_eclipse_category( $categories ) {
	$custom_block_category = array(
		'slug'  => __( 'wp_eclipse-blocks', 'wp_eclipse' ),
		'title' => __( 'WP Eclipse Blocks', 'wp_eclipse' ),
	);

	$categories_sorted    = array();
	$categories_sorted[0] = $custom_block_category;

	foreach ( $categories as $category ) {
		$categories_sorted[] = $category;
	}

	return $categories_sorted;
}

add_filter( 'block_categories_all', __NAMESPACE__ . '\register_wp_eclipse_category', 10, 1 );
