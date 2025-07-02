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
