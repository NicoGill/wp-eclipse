<?php
/**
 * WPE eclipse functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

// Define a global path and url.
define('NicoGill\eclipse\ROOT_PATH', trailingslashit(get_template_directory()));
define('NicoGill\eclipse\ROOT_URL', trailingslashit(get_template_directory_uri()));

/**
 * Get all the include files for the theme.
 *
 * @author WebDevStudios
 */
function include_inc_files()
{
	$files = array(
		'inc/functions/', // Custom functions that act independently of the theme templates.
		'inc/hooks/', // Load custom filters and hooks.
		'inc/taxonomies/', // Load custom taxonomies.
		'inc/post-types/', // Load custom post types.
		'inc/setup/', // Theme setup.
		'inc/gutenberg/', // Blocks configurations, filters and hooks.
		'inc/shortcodes/', // Load shortcodes.
		'inc/template-tags/', // Custom template tags for this theme.
	);

	foreach ($files as $include) {
		$include = trailingslashit(get_template_directory()) . $include;

		// Allows inclusion of individual files or all .php files in a directory.
		if (is_dir($include)) {
			foreach (glob($include . '*.php') as $file) {
				require $file;
			}
		} else {
			require $include;
		}
	}
}

include_inc_files();
