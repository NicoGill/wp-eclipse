<?php
/**
 * Yoast SEO plugin actions.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 *  Set Yoast SEO plugin metabox priority to low.
 *
 *  Turn off by using `remove_filter( 'wpseo_metabox_prio', 'air_helper_lowpriority_yoastseo' )`
 */
function lowpriority_yoastseo() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', __NAMESPACE__ . '\lowpriority_yoastseo' );

/**
 * Include empty terms in sitemap.
 */
add_filter( 'wpseo_sitemap_exclude_empty_terms', '__return_false' );

/**
 * Remove Yoast HTML Comments
 *
 * @source : https://gist.github.com/paulcollett/4c81c4f6eb85334ba076
 */
add_filter( 'wpseo_debug_markers', '__return_false' );

/**
 * Remove widget in dashboard
 */
add_action(
	'wp_dashboard_setup',
	function () {
		remove_meta_box( 'wpseo-wincher-dashboard-overview', 'dashboard', 'normal' );
		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );
	},
	20
);
