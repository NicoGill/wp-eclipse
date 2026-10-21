<?php
/**
 * Return SVG markup from the icon sprite.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Return SVG markup for an icon of build/images/icons/sprite.svg.
 *
 * Output is fully escaped here: callers may echo the result.
 *
 * @param array $args Icon arguments, keys below.
 *     @type string       $icon         Icon filename without extension (required).
 *     @type string       $title        Accessible title. Without it the icon is decorative (aria-hidden).
 *     @type string       $desc         Accessible description.
 *     @type string       $color        SVG color attribute.
 *     @type string       $stroke-width SVG stroke-width attribute.
 *     @type string       $height       SVG height attribute.
 *     @type string       $width        SVG width attribute.
 *     @type string|array $class        Extra classes.
 *
 * @return string SVG markup, empty string without icon.
 */
function get_svg( $args = [] ) {
	if ( empty( $args['icon'] ) ) {
		return '';
	}

	$args = wp_parse_args(
		$args,
		[
			'title'        => '',
			'desc'         => '',
			'color'        => '',
			'stroke-width' => '',
			'height'       => '',
			'width'        => '',
			'class'        => [],
		]
	);

	$title = $args['title'] ? $args['title'] : $args['icon'];
	$uid   = wp_unique_id( sanitize_title( $title ) . '-' );

	$attrs = array_filter(
		[
			'class'        => implode( ' ', array_map( 'sanitize_html_class', array_merge( [ 'icon', $args['icon'] ], (array) $args['class'] ) ) ),
			'role'         => 'img',
			'height'       => $args['height'],
			'width'        => $args['width'],
			'color'        => $args['color'],
			'stroke-width' => $args['stroke-width'],
		]
	);

	if ( $args['title'] ) {
		$attrs['aria-labelledby'] = 'title-' . $uid . ( $args['desc'] ? ' desc-' . $uid : '' );
	} else {
		$attrs['aria-hidden'] = 'true';
	}

	$html = '<svg';
	foreach ( $attrs as $name => $value ) {
		$html .= ' ' . $name . '="' . esc_attr( $value ) . '"';
	}
	$html .= '><title id="title-' . esc_attr( $uid ) . '">' . esc_html( $title ) . '</title>';

	if ( $args['desc'] ) {
		$html .= '<desc id="desc-' . esc_attr( $uid ) . '">' . esc_html( $args['desc'] ) . '</desc>';
	}

	$html .= '<use href="' . esc_url( get_parent_theme_file_uri( 'build/images/icons/sprite.svg' ) ) . '#' . esc_attr( $args['icon'] ) . '"></use></svg>';

	return $html;
}
