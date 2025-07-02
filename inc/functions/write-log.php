<?php
/**
 * Print array in debug log file.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * @param mixed $log
 *
 * @return [type]
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
