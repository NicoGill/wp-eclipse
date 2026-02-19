<?php
/**
 * Auto-register theme blocks from /build/blocks directory.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Register all blocks compiled in build/blocks using block.json metadata.
 */
function register_theme_blocks() {
	$blocks_path = get_template_directory() . '/build/blocks';

	if ( ! is_dir( $blocks_path ) ) {
		return;
	}

	$block_directories = glob( $blocks_path . '/*', GLOB_ONLYDIR );

	if ( false === $block_directories ) {
		return;
	}

	foreach ( $block_directories as $block_directory ) {
		$block_json = $block_directory . '/block.json';

		if ( ! is_readable( $block_json ) ) {
			continue;
		}

		register_block_type( $block_directory );
	}
}
add_action( 'init', __NAMESPACE__ . '\register_theme_blocks' );
