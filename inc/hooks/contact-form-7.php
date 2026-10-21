<?php
/**
 * Contact Form 7 plugin actions.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Disable wpautop in Contact Form 7.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Do not load Contact Form 7 assets everywhere.
 */
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

/**
 * Load Contact Form 7 assets only where a form is in the content.
 * Use the `wp_eclipse_load_cf7_assets` filter for forms placed elsewhere (ACF fields, templates).
 */
function conditional_load_cf7_assets() {
	$post     = get_post();
	$has_form = is_singular() && $post && (
		has_shortcode( $post->post_content, 'contact-form-7' )
		|| has_block( 'contact-form-7/contact-form-selector', $post )
	);

	if ( ! apply_filters( 'wp_eclipse_load_cf7_assets', $has_form ) ) {
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
