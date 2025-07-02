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
	main: path.resolve( __dirname, 'assets/js/main.js' ),
	theme: path.resolve( __dirname, 'assets/scss/main.scss' ),
	tinymce: path.resolve( __dirname, 'assets/scss/editor-classic.scss' ),
};

const fontFiles = glob.sync( './assets/fonts/**/*.{woff,woff2,ttf,otf,eot}' );
const imageFiles = glob.sync(
	'./assets/images/**/*.{jpg,jpeg,png,gif,svg,webp,avif}'
);
const plugins = [ ...defaultConfig.plugins ];

// Copie fonts/images si contenus
if ( fontFiles.length || imageFiles.length ) {
	const patterns = [];

	if ( fontFiles.length ) {
		patterns.push( {
			from: path.resolve( __dirname, 'assets/fonts' ),
			to: path.resolve( __dirname, 'build/fonts' ),
		} );
	}

	if ( imageFiles.length ) {
		patterns.push( {
			from: path.resolve( __dirname, 'assets/images' ),
			to: path.resolve( __dirname, 'build/images' ),
		} );
	}

	patterns.push( {
		from: '*.svg',
		to: 'images/icons/[name][ext]',
		context: path.resolve(
			process.cwd(),
			'assets/icons'
		),
		noErrorOnMissing: true,
	} );

	plugins.push( new CopyWebpackPlugin( { patterns } ) );
}

// Sprite SVG si icônes détectés
/**
 *
 */
plugins.push(
	new SVGSpritemapPlugin( 'assets/images/icons/*.svg', {
		output: {
			filename: 'images/icons/sprite.svg',
			svgo: true
		},
		sprite: {
			prefix: false,
		},
	} )
);

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


// Optimisation images si fichiers présents
if ( imageFiles.length ) {
	plugins.push(
		new ImageminPlugin({
			test: /\.(jpe?g|png|gif)$/i,
			pngquant: {quality: '65-80'},
			jpegtran: {progressive: true},
		})
	);
}

module.exports = {
	...defaultConfig,
	entry: entries,
	output: {
		path: path.resolve( __dirname, 'build' ),
		filename: '[name].js',
	},
	resolve: {
		alias: {
			'@scss': path.resolve( __dirname, 'assets/scss' ),
			'@js': path.resolve( __dirname, 'assets/js' ),
		},
	},
	plugins,
};
