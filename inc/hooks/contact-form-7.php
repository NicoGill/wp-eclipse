<?php
/**
 * Contact Form 7 plugin actions.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Disable wpautop in Contact Form 7
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Remove loading of contact form 7 scripts and styles.
 */
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

/**
 * Remove Contact form 7 styles and scripts
 */
function conditional_load_cf7_assets() {
	if ( ! is_page_template( 'page-templates/contact.php' ) ) {
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
