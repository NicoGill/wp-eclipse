<?php
/**
 * Enqueue scripts and styles.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Enqueue scripts and styles.
 *
 * @author WebDevStudios
 */
function scripts() {
	$asset_file_path = get_template_directory() . '/build/js/main.asset.php';

	if ( is_readable( $asset_file_path ) ) {
		$asset_file = include $asset_file_path;
	} else {
		$asset_file = array(
			'version'      => '1.0.0',
			'dependencies' => array( 'wp-polyfill' ),
		);
	}

	// Register styles & scripts.
	wp_enqueue_style( 'wp_eclipse-styles', get_stylesheet_directory_uri() . '/build/css/theme.css', array(), $asset_file['version'] );
	wp_enqueue_script( 'wp_eclipse-scripts', get_stylesheet_directory_uri() . '/build/js/main.js', $asset_file['dependencies'], $asset_file['version'], true );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\scripts' );

/**
 * Remove Contact form 7 styles and scripts
 */
function conditional_load_cf7_assets() {
	if ( ! is_page_template( 'page-templates/contact.php' ) ) {
		return;
	}

	if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
		wpcf7_enqueue_scripts();
	}
	if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
		wpcf7_enqueue_styles();
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\conditional_load_cf7_assets' );

/**
 * Enqueue custom styles for the TinyMCE editor (classic)
 */
function editor_styles() {
	add_editor_style( 'build/css/tinymce.css' );
}
add_action( 'admin_init', __NAMESPACE__ . '\editor_styles' );
