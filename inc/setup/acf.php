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
if ( 'production' === wp_get_environment_type() ) {
	add_filter( 'acf/settings/show_admin', '__return_false' );
}

/**
 * Hide the ACF Updates menu.
 */
add_filter( 'acf/settings/show_updates', '__return_false', 100 );

/**
 * Disable the custom post type and taxonomies UI.
 */
add_filter( 'acf/settings/enable_post_types', '__return_false' );

/**
 * Disable the UI for registering options pages.
 */
add_filter( 'acf/settings/enable_options_pages_ui', '__return_false' );

/**
 * Save ACF JSON files in the theme.
 *
 * @return string Path.
 */
function acf_json_save_point() {
	return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', __NAMESPACE__ . '\acf_json_save_point' );

/**
 * Load ACF JSON files from the theme only.
 *
 * @param array $paths Load paths.
 *
 * @return array Load paths.
 */
function acf_json_load_point( $paths ) {
	unset( $paths[0] );
	$paths[] = get_stylesheet_directory() . '/acf-json';

	return $paths;
}
add_filter( 'acf/settings/load_json', __NAMESPACE__ . '\acf_json_load_point' );

/**
 * Add the theme settings options page.
 */
function add_options_pages() {
	acf_add_options_page(
		array(
			'page_title' => __( 'Paramètres du thème', 'wp-eclipse' ),
			'menu_title' => __( 'Paramètres', 'wp-eclipse' ),
			'menu_slug'  => 'theme-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
}
add_action( 'acf/init', __NAMESPACE__ . '\add_options_pages' );
