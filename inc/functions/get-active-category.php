<?php
/**
 * Retrieve the active categorie GET parameter if exist.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Retrieve the active categorie GET parameter if exist.
 *
 * @author Nicolas Gillium
 */
function get_active_category() {

	return isset( $_GET['categorie'] ) ? sanitize_text_field( wp_unslash( $_GET['categorie'] ) ) : 'all';
}
