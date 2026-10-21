<?php
/**
 * Enqueue scripts and styles.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Enqueue theme styles and deferred script, versioned by the build.
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

	wp_enqueue_style( 'wp-eclipse-styles', get_stylesheet_directory_uri() . '/build/css/theme.css', array(), $asset_file['version'] );
	wp_enqueue_script(
		'wp-eclipse-scripts',
		get_stylesheet_directory_uri() . '/build/js/main.js',
		$asset_file['dependencies'],
		$asset_file['version'],
		array( 'strategy' => 'defer' )
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\scripts' );
