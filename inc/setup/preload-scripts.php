<?php
/**
 * Preload styles and scripts.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Preload styles and scripts.
 *
 * @author WebDevStudios
 */
function preload_scripts() {
	$asset_file_path = get_template_directory() . '/build/js/main.asset.php';

	if ( is_readable( $asset_file_path ) ) {
		$asset_file = include $asset_file_path;
	} else {
		$theme           = wp_get_theme( get_template() );
		$theme_version   = $theme->get( 'Version' );

		$asset_file = array(
			'version'     	=> $theme_version,
		);
	}

	$style_url   	= get_stylesheet_directory_uri() . '/build/css/theme.css';
	$script_url 	= get_stylesheet_directory_uri() . '/build/js/main.js';

	?>
	<link rel="preload" href="<?php echo esc_url( $style_url ); ?>?ver=<?php echo esc_html( $asset_file['version'] ); ?>" as="style">
	<link rel="preload" href="<?php echo esc_url( $script_url ); ?>?ver=<?php echo esc_html( $asset_file['version'] ); ?>" as="script">
	<?php
}
add_action( 'wp_head', __NAMESPACE__ . '\preload_scripts', 1 );


