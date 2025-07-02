<?php
/**
 * Scripts, hooks and filters only for development environment.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Custom PHP mailer on .test domain
 */
function phpmailer_init_dev( $phpmailer ) {

	if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
		return;
	}

	if ( 'eclipse.test' !== $_SERVER['HTTP_HOST'] ) {
		return;
	}

	$phpmailer->isSMTP();
	$phpmailer->Host = 'mailpit'; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	$phpmailer->Port = 1025; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
}
add_action( 'phpmailer_init', __NAMESPACE__ . '\phpmailer_init_dev' );

/**
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 *
 * @source : https://www.kevinleary.net/blog/wordpress-ob_end_flush-error-fix/
 */
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_action(
	'shutdown',
	function () {
		while ( @ob_end_flush() ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	}
);
