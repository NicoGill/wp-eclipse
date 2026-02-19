<?php
/**
 * Functions to enqueue scripts in the block editor and frontend.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Enqueues the filters.js script in the block editor.
 *
 * @return void
 */
function enqueue_editor_filters_script() {
	wp_enqueue_script(
		'editor_filters_script',
		get_template_directory_uri() . '/build/js/filters.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_editor_filters_script' );

/**
 * Register block variations.
 */
function register_block_variations() {
	wp_enqueue_script(
		'wdsbt-enqueue-block-variations',
		get_template_directory_uri() . '/build/js/variations.js',
		array( 'wp-blocks', 'wp-dom-ready', 'wp-element', 'wp-primitives' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\register_block_variations' );
