<?php

/**
 * Setup Advanced Custom Fields Pro.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Hide the ACF admin menu item in production.
 */
if ( wp_get_environment_type() === 'production' ) {
	add_filter( 'acf/settings/show_admin', '__return_false' );
}

// When including the PRO plugin, hide the ACF Updates menu
add_filter( 'acf/settings/show_updates', '__return_false', 100 );

/**
 * Add a custom path for saving ACF JSON files.
 */
function acf_json_save_point( $path ) {
	return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', __NAMESPACE__ . '\acf_json_save_point' );

/**
 * Add a custom path to look for JSON files.
 */
function acf_json_load_point( $paths ) {
	// Remove the original path (optional).
	unset( $paths[0] );

	// Append the new path and return it.
	$paths[] = get_stylesheet_directory() . '/acf-json';

	return $paths;
}
add_filter( 'acf/settings/load_json', __NAMESPACE__ . '\acf_json_load_point' );

/**
 * Disable the custom post type and taxonomies feature.
 */
add_filter( 'acf/settings/enable_post_types', '__return_false' );

/**
 * Disable the UI for registering options pages.
 */
add_filter( 'acf/settings/enable_options_pages_ui', '__return_false' );

/**
 * Add options pages.
 */
if ( function_exists( 'acf_add_options_page' ) ) {

	function add_options_pages() {
		// Add parent.
		acf_add_options_page(
			array(
				'page_title' => __( 'Paramètres du thème', 'wp_eclipse' ),
				'menu_title' => __( 'Paramètres', 'wp_eclipse' ),
				'menu_slug'  => 'theme-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
			)
		);

		// acf_add_options_sub_page(
		// array(
		// 'page_title'  => __( 'Contenu de la page FAQ', 'wp_eclipse' ),
		// 'menu_title'  => __( 'Page FAQ', 'wp_eclipse' ),
		// 'parent_slug' => 'edit.php?post_type=faq',
		// )
		// );
	}

	add_action( 'acf/init', __NAMESPACE__ . '\add_options_pages' );
}
