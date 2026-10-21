<?php
/**
 * Enqueue scripts and styles.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Enqueue theme stylesheet and deferred script, versioned by the build.
 */
function scripts() {
	$asset_file_path = get_template_directory() . '/build/js/main.asset.php';

	if ( is_readable( $asset_file_path ) ) {
		$asset_file = include $asset_file_path;
	} else {
		$asset_file = array(
			'version'      => wp_get_theme( get_template() )->get( 'Version' ),
			'dependencies' => array(),
		);
	}

	wp_enqueue_style( 'wp-eclipse-styles', get_stylesheet_directory_uri() . '/build/css/main.css', array(), $asset_file['version'] );
	wp_enqueue_script(
		'wp-eclipse-scripts',
		get_stylesheet_directory_uri() . '/build/js/main.js',
		$asset_file['dependencies'],
		$asset_file['version'],
		array( 'strategy' => 'defer' )
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\scripts' );

/**
 * Preload the first font face declared in theme.json (the body text font).
 *
 * @param array $resources Resources to preload.
 *
 * @return array Resources to preload.
 */
function preload_theme_font( $resources ) {
	$families = wp_get_global_settings( array( 'typography', 'fontFamilies' ) );
	$src      = (array) ( $families['theme'][0]['fontFace'][0]['src'] ?? array() );

	if ( $src && str_starts_with( $src[0], 'file:./' ) ) {
		$file        = substr( $src[0], 7 );
		$resources[] = array(
			'href'        => get_theme_file_uri( $file ),
			'as'          => 'font',
			'type'        => 'font/' . pathinfo( $file, PATHINFO_EXTENSION ),
			'crossorigin' => 'anonymous',
		);
	}

	return $resources;
}
add_filter( 'wp_preload_resources', __NAMESPACE__ . '\preload_theme_font' );
