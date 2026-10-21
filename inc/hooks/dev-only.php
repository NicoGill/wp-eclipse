<?php
/**
 * Hooks only for the local environment (WP_ENVIRONMENT_TYPE = local).
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Route mails to Mailpit in local environment.
 *
 * @param \PHPMailer\PHPMailer\PHPMailer $phpmailer The PHPMailer instance.
 *
 * @return void
 */
function phpmailer_init_dev( $phpmailer ) {
	if ( 'local' !== wp_get_environment_type() ) {
		return;
	}

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase -- PHPMailer API.
	$phpmailer->isSMTP();
	$phpmailer->Host = 'mailpit';
	$phpmailer->Port = 1025;
	// phpcs:enable
}
add_action( 'phpmailer_init', __NAMESPACE__ . '\phpmailer_init_dev' );
