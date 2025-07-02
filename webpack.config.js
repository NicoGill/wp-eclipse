const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
const fs = require( 'fs' );
const glob = require( 'glob' );
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );
const ImageminPlugin = require( 'imagemin-webpack-plugin' ).default;
const SVGSpritemapPlugin = require( 'svg-spritemap-webpack-plugin' );
const BrowserSyncPlugin = require( 'browser-sync-webpack-plugin' );

/**
 * An object specifying entry points for building the application.
 *
 * @property {string} main       Path to the main JavaScript file for the application.
 * @property {string} gutenberg  Path to the JavaScript file for Gutenberg editor customization.
 * @property {string} style      Path to the main SCSS file containing application styles.
 * @property {string} admin      Path to the SCSS file specifically for admin styles.
 */
const entries = {
	main: path.resolve( __dirname, 'src/js/main.js' ),
	theme: path.resolve( __dirname, 'src/scss/main.scss' ),
	tinymce: path.resolve( __dirname, 'src/scss/editor-classic.scss' ),
};

const fontFiles = glob.sync( './src/fonts/**/*.{woff,woff2,ttf,otf,eot}' );
const imageFiles = glob.sync(
	'./src/images/**/*.{jpg,jpeg,png,gif,svg,webp,avif}'
);
const svgIcons = glob
	.sync( './src/icons/**/*.svg' )
	.map( ( file ) => file.replace( /\\/g, '/' ) );

const plugins = [ ...defaultConfig.plugins ];

// Copie fonts/images si contenus
if ( fontFiles.length || imageFiles.length ) {
	const patterns = [];

	if ( fontFiles.length ) {
		patterns.push( {
			from: path.resolve( __dirname, 'src/fonts' ),
			to: path.resolve( __dirname, 'build/fonts' ),
		} );
	}

	if ( imageFiles.length ) {
		patterns.push( {
			from: path.resolve( __dirname, 'src/images' ),
			to: path.resolve( __dirname, 'build/images' ),
		} );
	}

	plugins.push( new CopyWebpackPlugin( { patterns } ) );
}

// Optimisation images si fichiers présents
if ( imageFiles.length ) {
	plugins.push(
		new ImageminPlugin( {
			test: /\.(jpe?g|png|gif|svg)$/i,
			pngquant: { quality: '65-80' },
			jpegtran: { progressive: true },
		} )
	);
}

// Sprite SVG si icônes détectés
if ( svgIcons.length > 0 ) {
	plugins.push(
		new SVGSpritemapPlugin( svgIcons, {
			output: {
				filename: 'images/sprite.svg',
				svgo: true,
			},
			sprite: {
				prefix: false,
				generate: {
					title: false,
				},
			},
		} )
	);
}

// BrowserSync pour Laragon HTTPS
plugins.push(
	new BrowserSyncPlugin(
		{
			host: 'localhost',
			port: 3000,
			proxy: 'https://eclipse.test',
			https: {
				key: 'C:/laragon/etc/ssl/laragon.key',
				cert: 'C:/laragon/etc/ssl/laragon.crt',
			},
			files: [ 'build/*.css', 'build/*.js', '**/*.php' ],
			open: false,
			notify: false,
		},
		{ reload: true }
	)
);

module.exports = {
	...defaultConfig,
	entry: entries,
	output: {
		path: path.resolve( __dirname, 'build' ),
		filename: '[name].js',
	},
	resolve: {
		alias: {
			'@scss': path.resolve( __dirname, 'src/scss' ),
			'@js': path.resolve( __dirname, 'src/js' ),
		},
	},
	plugins,
};
