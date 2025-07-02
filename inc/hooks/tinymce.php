<?php
/**
 * TinyMCE (old) editor actions.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 *  Show TinyMCE second editor tools row by default.
 *
 *  @param  array $tinymce tinymce options.
 */
function show_second_editor_row( $tinymce ) {
	$tinymce['wordpress_adv_hidden'] = false;
	return $tinymce;
}
add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\show_second_editor_row' );

/**
 *  Add custom styles to TinyMCE editor.
 *
 * @param  array $buttons TinyMCE init array.
 *
 * @return array $buttons TinyMCE init array.
 */
function tinymce2_custom_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	// add custom HTML elements to the style dropdown
	array_push( $buttons, 'spacer_select', 'button_select' );

	return $buttons;
}
add_filter( 'mce_buttons_2', __NAMESPACE__ . '\tinymce2_custom_buttons' );

/**
 *  Customize Tiny MCE formats from editor.
 */
function tinymce_custom_formats( $init ) {
	$init['block_formats'] = 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3;Heading 4=h4;';

	$style_formats = array(
		array(
			'title'    => 'Titre',
			'selector' => 'p, h1, h2, h3, h4, h5, h6, span, li',
			'classes'  => 'text-title',
			'wrapper'  => false,
		),
		array(
			'title'    => 'Sur-titre',
			'selector' => 'p, h1, h2, h3, h4, h5, h6, span, li',
			'classes'  => 'text-surtitle',
			'wrapper'  => false,
		),
		array(
			'title'    => 'Corps de texte',
			'selector' => 'p, h1, h2, h3, h4, h5, h6, span, li',
			'classes'  => 'text-body',
			'wrapper'  => false,
		),
		array(
			'inline'  => 'span',
			'title'   => 'Noir et souligné',
			'classes' => 'text-underlined-black',
			'wrapper' => true,
		),
		array(
			'title'    => 'Sans marge supérieure',
			'selector' => 'p, h1, h2, h3, h4, h5, h6, span, li',
			'classes'  => 'mt-0',
			'wrapper'  => false,
		),
		array(
			'title'    => 'Sans marge inférieure',
			'selector' => 'p, h1, h2, h3, h4, h5, h6, span, li',
			'classes'  => 'mb-0',
			'wrapper'  => false,
		),
	);

	// Insert the array, JSON ENCODED, into 'style_formats'
	$init['style_formats'] = wp_json_encode( $style_formats );

	return $init;
}
add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\tinymce_custom_formats' );
