<?php
/**
 * Actions for customize WordPress administration.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Hide dashboard widgets
 */
function hide_duplicator_dashboard_widgets() {
	global $wp_meta_boxes;

	$screen = get_current_screen();

	if ( ! $screen ) {
		return;
	}

	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	remove_meta_box( 'duplicator_dashboard_widget', 'dashboard', 'normal' );
	// Site Health Status widget
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health'] );
	// WordPress Events and News widget
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
}
add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\hide_duplicator_dashboard_widgets', 20 );

/**
 * Giving credits
 */
function sign_footer_admin() {
	echo 'Thème WordPress crée par <a href="https://nicolas-gillium.fr" target="_blank">Nicolas Gillium</a>.';
}
add_filter( 'admin_footer_text', __NAMESPACE__ . '\sign_footer_admin' );

/**
 * Remove login language switcher introduced in WP 5.9.
 */
add_filter( 'login_display_language_dropdown', '__return_false' );

/**
 * Step 1: Add a new column for the post ID
 */
add_filter(
	'manage_recipe_posts_columns',
	function ( $columns ) {
		$columns['post_id'] = 'ID'; // 'ID' is the column title
		return $columns;
	}
);

/**
 * Step 2: Populate the new column with the post ID
 */
add_action(
	'manage_recipe_posts_custom_column',
	function ( $column, $post_id ) {
		if ( 'post_id' === $column ) {
			echo esc_html( $post_id );
		}
	},
	10,
	2
);

/**
 * Remove menu entry for user except dev.
 */
add_action(
	'admin_menu',
	function () {
		if ( get_current_user_id() !== 1 ) {
			remove_menu_page( 'plugins.php' );
			remove_menu_page( 'tools.php' );
			remove_menu_page( 'options-general.php' );
			remove_menu_page( 'wpseo_dashboard' );
			remove_menu_page( 'duplicator-pro' );

			remove_submenu_page( 'themes.php', 'themes.php' );
			remove_submenu_page( 'themes.php', 'customize.php' );
			remove_submenu_page( 'themes.php', 'widgets.php' );
			remove_submenu_page( 'themes.php', 'edit.php?post_type=wp_block' );
			remove_submenu_page( 'themes.php', 'site-editor.php?path=/patterns' );

			$customize_url = add_query_arg( 'return', urlencode( remove_query_arg( wp_removable_query_args(), wp_unslash( $_SERVER['REQUEST_URI'] ) ) ), 'customize.php' );
			remove_submenu_page( 'themes.php', $customize_url );
		}
	},
	100
);

/**
 * Disable the remote patterns coming from the Dotorg pattern directory.
 */
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Remove top bar menus
 */
add_action(
	'admin_bar_menu',
	function ( $wp_admin_bar ) {
		if ( get_current_user_id() !== 1 ) {
			// Supprime le menu "Yoast SEO" de la barre d'administration
			$wp_admin_bar->remove_node( 'wpseo-menu' );
		}
	},
	999
);
