<?php
/**
 * Customize WordPress administration.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Remove noisy dashboard widgets.
 */
function hide_dashboard_widgets() {
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\hide_dashboard_widgets', 20 );

/**
 * Giving credits.
 *
 * @return string Admin footer text.
 */
function sign_footer_admin() {
	return 'Thème WordPress créé par <a href="https://nicolas-gillium.fr" target="_blank" rel="noopener">Nicolas Gillium</a>.';
}
add_filter( 'admin_footer_text', __NAMESPACE__ . '\sign_footer_admin' );

/**
 * Remove login language switcher introduced in WP 5.9.
 */
add_filter( 'login_display_language_dropdown', '__return_false' );

/**
 * Disable the remote patterns coming from the Dotorg pattern directory.
 */
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Hide technical menus from everyone but the developer.
 */
function remove_admin_menus() {
	if ( is_developer() ) {
		return;
	}

	remove_menu_page( 'plugins.php' );
	remove_menu_page( 'tools.php' );
	remove_menu_page( 'options-general.php' );

	remove_submenu_page( 'themes.php', 'themes.php' );
	remove_submenu_page( 'themes.php', 'widgets.php' );
	remove_submenu_page( 'themes.php', 'edit.php?post_type=wp_block' );
	remove_submenu_page( 'themes.php', 'site-editor.php?path=/patterns' );

	// Core registers the Customizer entry with a "return" query arg: the exact URL is needed to remove it.
	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput, WordPress.PHP.DiscouragedPHPFunctions.urlencode_urlencode -- Mirrors wp-admin/menu.php.
	$customize_url = add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ) ), 'customize.php' );
	remove_submenu_page( 'themes.php', $customize_url );
}
add_action( 'admin_menu', __NAMESPACE__ . '\remove_admin_menus', 100 );
