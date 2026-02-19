<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @author WebDevStudios
 */
function setup() {
	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on wd_s, refer to the
	 * README.md file in this theme to find and replace all
	 * references of wd_s
	 */
	load_theme_textdomain( 'wp_eclipse', get_template_directory() . '/build/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 250,
			'flex-height' => true,
		)
	);

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// TODO:
	// add_image_size( 'hero', 1920, 1080, false );

	// Register navigation menus.
	register_nav_menus(
		array(
			'primary'  => esc_html__( 'Menu principal', 'wp_eclipse' ),
			'socials'  => esc_html__( 'Menu des réseaux sociaux', 'wp_eclipse' ),
			'footer-1' => esc_html__( 'Menu du pied de page colonne 1', 'wp_eclipse' ),
			// etc.
		)
	);

	/**
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'gallery',
			'caption',
		)
	);

	// Add theme support for selective refresh for widgets.
	remove_theme_support( 'customize-selective-refresh-widgets' );

	// Block editor support in a classic theme.
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_editor_style( 'build/css/theme.css' );

	// Keep templates managed by PHP in this classic theme.
	remove_theme_support( 'block-templates' );
	remove_theme_support( 'block-template-parts' );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\setup' );
