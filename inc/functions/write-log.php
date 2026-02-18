<?php
/**
 * Print array in debug log file.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Logs the provided data to the error log.
 *
 * @param mixed $log The data to be logged. Can be a string, array, object, or null.
 *
 * @return void
 */
function write_log( $log ) {
	if ( is_array( $log ) || is_object( $log ) ) {
		error_log( print_r( $log, true ) );
	} elseif ( is_null( $log ) ) {
		error_log( 'NULL' );
	} else {
		error_log( $log );
	}
}
