<?php
/**
 * Global Filters hooks.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Produces cleaner filenames for uploads.
 *
 * @param string $filename The filename.
 *
 * @return string Sanitized filename.
 */
function sanitize_file_name( $filename ) {
	$sanitized_filename = remove_accents( $filename ); // Convert to ASCII.

	// Standard replacements.
	$invalid            = array(
		' '   => '-',
		'%20' => '-',
		'_'   => '-',
	);
	$sanitized_filename = str_replace( array_keys( $invalid ), array_values( $invalid ), $sanitized_filename );

	$sanitized_filename = preg_replace( '/[^A-Za-z0-9-\. ]/', '', $sanitized_filename ); // Remove all non-alphanumeric except dot.
	$sanitized_filename = preg_replace( '/\.(?=.*\.)/', '', $sanitized_filename ); // Remove all but last dot.
	$sanitized_filename = preg_replace( '/-+/', '-', $sanitized_filename ); // Collapse dashes.
	$sanitized_filename = str_replace( '-.', '.', $sanitized_filename ); // Remove dash before extension.
	$sanitized_filename = strtolower( $sanitized_filename ); // Lowercase.

	return $sanitized_filename;
}
add_filter( 'sanitize_file_name', __NAMESPACE__ . '\sanitize_file_name', 10, 1 );

/**
 * Removes the prefix on term archive page titles.
 *
 * @param string $block_title The default $block_title of the page.
 *
 * @return string The updated $block_title.
 */
function remove_archive_title_prefix( $block_title ): string {
	if ( is_category() || is_tag() || is_tax() ) {
		return esc_html( single_term_title( '', false ) );
	}

	return $block_title;
}
add_filter( 'get_the_archive_title', __NAMESPACE__ . '\remove_archive_title_prefix' );

/**
 * Remove WP big image scaling.
 */
add_filter( 'big_image_size_threshold', '__return_false' );
