<?php
/**
 * Limit the excerpt length.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Limit the excerpt length.
 *
 * @author WebDevStudios
 *
 * @param array $args Parameters include length and more.
 *
 * @return string The excerpt.
 */
function get_trimmed_excerpt( $args = [] ) {

	// Set defaults.
	$defaults = [
		'length' => 30,
		'more'   => '...',
		'post'   => '',
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Trim the excerpt.
	return wp_trim_words( get_the_excerpt( $args['post'] ), absint( $args['length'] ), esc_html( $args['more'] ) );
}
