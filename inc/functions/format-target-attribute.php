<?php
/**
 * Function : format_target_attribute( $target )
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Format target attribute for links.
 *
 * @param string $target Target attribute value.
 * @return string Formatted target attribute.
 */
function format_target_attribute( $target ) {
	$attr  = $target ? 'target="' . esc_attr( $target ) . '"' : 'target="_self"';
	$attr .= ( '_blank' === $target ) ? ' rel="noopener"' : '';

	return $attr;
}
