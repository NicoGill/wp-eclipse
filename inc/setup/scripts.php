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
	$asset_file_path = get_template_directory() . '/build/index.asset.php';

	if ( is_readable( $asset_file_path ) ) {
		$asset_file = include $asset_file_path;
	} else {
		$asset_file = array(
			'version'      => '1.0.0',
			'dependencies' => array( 'wp-polyfill' ),
		);
	}

	// Register styles & scripts.
	wp_enqueue_style( 'wp_liyu-styles', get_stylesheet_directory_uri() . '/build/theme.css', array(), $asset_file['version'] );
	wp_enqueue_script( 'wp_liyu-scripts', get_stylesheet_directory_uri() . '/build/main.js', $asset_file['dependencies'], $asset_file['version'], true );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\scripts' );

/**
 * Disable Gutenberg assets everywhere.
 */
function remove_gutenberg_styles() {
	wp_dequeue_style( 'wp-block-library' ); // WordPress core
	wp_dequeue_style( 'wp-block-library-theme' ); // WordPress core
	wp_dequeue_style( 'global-styles' ); // div id="global-styles-css"
	wp_dequeue_style( 'classic-theme-styles' ); // div id="classic-theme-styles-css"
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\remove_gutenberg_styles' );

/**
 * Remove inline styles from classic theme styles.
 */
function print_styles() {
	wp_deregister_style( 'classic-theme-styles-inline-css' );
	wp_dequeue_style( 'classic-theme-styles-inline-css' );
}
add_action( 'wp_print_styles', __NAMESPACE__ . '\print_styles' );

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
	add_editor_style( 'build/tinymce.css' );
}
add_action( 'admin_init', __NAMESPACE__ . '\editor_styles' );
