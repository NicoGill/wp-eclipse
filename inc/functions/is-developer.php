<?php
/**
 * Function : is_developer()
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Whether the current user is the developer (sees technical admin menus).
 *
 * @return bool
 */
function is_developer(): bool {
	return apply_filters( 'wp_eclipse_is_developer', 1 === get_current_user_id() );
}
