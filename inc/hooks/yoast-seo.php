<?php
/**
 * Yoast SEO plugin actions.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Set Yoast SEO plugin metabox priority to low.
 *
 * @return string Priority.
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
 * Remove Yoast HTML comments.
 *
 * @source https://gist.github.com/paulcollett/4c81c4f6eb85334ba076
 */
add_filter( 'wpseo_debug_markers', '__return_false' );

/**
 * Remove Yoast dashboard widgets.
 */
function remove_yoast_dashboard_widgets() {
	remove_meta_box( 'wpseo-wincher-dashboard-overview', 'dashboard', 'normal' );
	remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\remove_yoast_dashboard_widgets', 20 );

/**
 * Hide Yoast admin menu from everyone but the developer.
 */
function remove_yoast_admin_menu() {
	if ( ! is_developer() ) {
		remove_menu_page( 'wpseo_dashboard' );
	}
}
add_action( 'admin_menu', __NAMESPACE__ . '\remove_yoast_admin_menu', 100 );

/**
 * Hide Yoast admin bar menu from everyone but the developer.
 *
 * @param \WP_Admin_Bar $wp_admin_bar The admin bar.
 */
function remove_yoast_admin_bar_menu( $wp_admin_bar ) {
	if ( ! is_developer() ) {
		$wp_admin_bar->remove_node( 'wpseo-menu' );
	}
}
add_action( 'admin_bar_menu', __NAMESPACE__ . '\remove_yoast_admin_bar_menu', 999 );
