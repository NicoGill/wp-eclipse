<?php
/**
 * Global Filters hooks.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Produces cleaner filenames for uploads
 *
 * @param  string $filename
 * @return string
 */
function sanitize_file_name( $filename ) {
	$sanitized_filename = remove_accents( $filename ); // Convert to ASCII

	// Standard replacements
	$invalid            = array(
		' '   => '-',
		'%20' => '-',
		'_'   => '-',
	);
	$sanitized_filename = str_replace( array_keys( $invalid ), array_values( $invalid ), $sanitized_filename );

	$sanitized_filename = preg_replace( '/[^A-Za-z0-9-\. ]/', '', $sanitized_filename ); // Remove all non-alphanumeric except .
	$sanitized_filename = preg_replace( '/\.(?=.*\.)/', '', $sanitized_filename ); // Remove all but last .
	$sanitized_filename = preg_replace( '/-+/', '-', $sanitized_filename ); // Replace any more than one - in a row
	$sanitized_filename = str_replace( '-.', '.', $sanitized_filename ); // Remove last - if at the end
	$sanitized_filename = strtolower( $sanitized_filename ); // Lowercase

	return $sanitized_filename;
}
add_filter( 'sanitize_file_name', __NAMESPACE__ . '\sanitize_file_name', 10, 1 );

/**
 * Filters WYSIWYG content with the_content filter.
 *
 * @param string $content content dump from WYSIWYG.
 *
 * @return string|bool Content string if content exists, else empty.
 */
function get_post_content( $content ) {
	return ! empty( $content ) ? $content : false;
}
add_filter( 'the_content', __NAMESPACE__ . '\get_post_content', 20 );

/**
 * Add lazy loading to all images
 */
function filter_wp_get_attachment_image_attributes( $attr, $attachment, $size ) {
	if ( is_admin() ) {
		return $attr;
	}

	if ( isset( $attr['loading'] ) && false === $attr['loading'] ) {
		return $attr;
	}

	$attr['loading'] = 'lazy';

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', __NAMESPACE__ . '\filter_wp_get_attachment_image_attributes', 10, 5 );

/**
 * Enable custom mime types.
 *
 * @author WebDevStudios
 *
 * @param array $mimes Current allowed mime types.
 *
 * @return array Mime types.
 */
function custom_mime_types( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['svgz'] = 'image/svg+xml';

	return $mimes;
}
add_filter( 'upload_mimes', __NAMESPACE__ . '\custom_mime_types' );

/**
 * Removes or Adjusts the prefix on category archive page titles.
 *
 * @author Corey Collins
 *
 * @param string $block_title The default $block_title of the page.
 *
 * @return string The updated $block_title.
 */
function remove_archive_title_prefix( $block_title ) {
	// Get the single category title with no prefix.
	$single_cat_title = single_term_title( '', false );

	if ( is_category() || is_tag() || is_tax() ) {
		return esc_html( $single_cat_title );
	}

	return $block_title;
}
add_filter( 'get_the_archive_title', __NAMESPACE__ . '\remove_archive_title_prefix' );

/**
 * Remove WP big image scalling
 */
add_filter( 'big_image_size_threshold', '__return_false' );

/**
 * Disable WordPress search functionality
 */
function remove_s_query( $query, $error = true ) {

	if ( is_search() && ! is_admin() ) {
		$query->is_search       = false;
		$query->query_vars['s'] = false;
		$query->query['s']      = false;

		if ( $error ) {
			$query->is_404 = true;
		}
	}
}

add_action( 'parse_query', __NAMESPACE__ . '\remove_s_query' );

/**
 * Removes the width and height attributes of <img> tags for SVG
 *
 * Without this filter, the width and height are set to "1" since
 * WordPress core can't seem to figure out an SVG file's dimensions.
 *
 * For SVG:s, returns an array with file url, width and height set
 * to null, and false for 'is_intermediate'.
 *
 * @source: https://wordpress.stackexchange.com/questions/240579/issue-with-wp-get-attachment-image-and-svg-file-type
 *
 * @wp-hook image_downsize
 * @param mixed $out Value to be filtered
 * @param int   $id Attachment ID for image.
 * @return bool|array False if not in admin or not SVG. Array otherwise.
 */
function fix_svg_size_attributes( $out, $id ) {
	$image_url = wp_get_attachment_url( $id );
	$file_ext  = pathinfo( $image_url, PATHINFO_EXTENSION );

	if ( is_admin() || 'svg' !== $file_ext ) {
			return false;
	}

	return array( $image_url, null, null, false );
}
add_filter( 'image_downsize', __NAMESPACE__ . '\fix_svg_size_attributes', 10, 2 );

/**
 * Initialize machine featured repeater with values. If no values are set, set default values.
 */
function initialize_machine_features_repeater_field( $field ) {

	if ( empty( $field['value'] ) ) {

		$field['value'] = array(
			array(
				'field_66ffafc7c8908' => 'Modèle',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Tête d\'impression',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Nombre de tête d\'impression',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Taille de gouttes',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Couleurs',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Encres',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Séchage',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Largeur d\'impression',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Épaisseur maximale du support',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Résolution max.',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Vitesse d\'impression maximale',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Logiciel RIP',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Entrainement du chariot',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Dimensions',
				'field_66ffb04dc8909' => '',
			),
			array(
				'field_66ffafc7c8908' => 'Besoin en électricité ',
				'field_66ffb04dc8909' => '',
			),
		);
	}

	return $field;
}
add_filter( 'acf/prepare_field/key=field_66ffafc7c8907', __NAMESPACE__ . '\initialize_machine_features_repeater_field', 10, 1 );

/**
 * Filter machine_categorie and category term link to respectly archive link with get parameter slug cat.
 */
function filter_machine_categorie_term_link( $termlink, $term, $taxonomy ) {
	if ( 'machine_categorie' === $taxonomy ) {
		$termlink = add_query_arg( 'categorie', $term->slug, get_post_type_archive_link( 'machine' ) );
	}

	if ( 'category' === $taxonomy ) {
		$termlink = add_query_arg( 'categorie', $term->slug, get_post_type_archive_link( 'post' ) );
	}

	return $termlink;
}
add_filter( 'term_link', __NAMESPACE__ . '\filter_machine_categorie_term_link', 10, 3 );
