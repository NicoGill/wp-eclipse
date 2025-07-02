<?php
/**
 * Function : format_target_attribute( $target )
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

if ( ! function_exists( 'format_target_attribute' ) ) {
	/**
	 * Format target attribute for links
	 *
	 * @since  1.0.0
	 * @param  string $target  Target attribute value.
	 * @return string          Formatted target attribute.
	 */
	function format_target_attribute( $target ) {
		$attr  = $target ? 'target="' . esc_attr( $target ) . '"' : 'target="_self"';
		$attr .= ( '_blank' === $target ) ? ' rel="nofollow noopener"' : '';

		return $attr;
	}
} // end if
