const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');
const { globSync } = require('glob');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
const SVGSpritemapPlugin =
	require('svg-spritemap-webpack-plugin').default ||
	require('svg-spritemap-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

const isProduction = process.env.NODE_ENV === 'production';

// main.js imports main.scss: one entry emits js/main.js, css/main.css and js/main.asset.php.
const entries = {
	main: path.resolve(__dirname, 'assets/js/main.js'),
};

globSync('blocks/*/index.js', { cwd: __dirname }).forEach((file) => {
	const blockSlug = file
		.replace(/\\/g, '/')
		.replace(/^blocks\//, '')
		.replace(/\/index\.js$/, '');

	entries[`blocks/${blockSlug}/index`] = path.resolve(__dirname, file);
});

// Sites are LTR only: drop the *-rtl.css twins wp-scripts would emit.
const plugins = defaultConfig.plugins.filter(
	(plugin) => plugin.constructor.name !== 'RtlCssPlugin'
);

// Keep block assets near block.json for WordPress block metadata resolution.
const cssPlugin = plugins.find(
	(plugin) => plugin.constructor.name === 'MiniCssExtractPlugin'
);
cssPlugin.options.filename = (pathData) =>
	pathData.chunk.name.startsWith('blocks/') ? '[name].css' : 'css/[name].css';
cssPlugin.options.chunkFilename = '[id].css';

plugins.push(
	new CopyWebpackPlugin({
		patterns: [
			{
				from: path.resolve(__dirname, 'assets/images'),
				to: path.resolve(__dirname, 'build/images'),
				noErrorOnMissing: true,
				globOptions: {
					// Icon source files are compiled into the sprite, not copied as standalone files.
					ignore: ['**/icons/**/*.svg'],
				},
			},
			{
				from: path.resolve(__dirname, 'blocks'),
				to: path.resolve(__dirname, 'build/blocks'),
				noErrorOnMissing: true,
				globOptions: {
					ignore: ['**/index.js', '**/*.scss'],
				},
			},
		],
	}),
	new SVGSpritemapPlugin('assets/images/icons/*.svg', {
		output: {
			filename: 'images/icons/sprite.svg',
			svgo: true,
		},
		sprite: {
			prefix: false,
		},
	})
);

if (!isProduction) {
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
				files: ['build/**/*.css', 'build/**/*.js', '**/*.php'],
				open: false,
				notify: false,
			},
			{ reload: true }
		)
	);
}

module.exports = {
	...defaultConfig,
	entry: entries,
	output: {
		path: path.resolve(__dirname, 'build'),
		filename: (pathData) =>
			pathData.chunk.name.startsWith('blocks/')
				? '[name].js'
				: 'js/[name].js',
		clean: true,
	},
	optimization: {
		...defaultConfig.optimization,
		minimizer: [
			...(defaultConfig.optimization?.minimizer || []),
			...(isProduction
				? [
						new ImageMinimizerPlugin({
							test: /\.(jpe?g|png|gif|webp|avif)$/i,
							minimizer: {
								implementation:
									ImageMinimizerPlugin.sharpMinify,
								options: {
									encodeOptions: {
										jpeg: { quality: 75 },
										png: { quality: 80 },
										webp: { quality: 75 },
										avif: { quality: 50 },
									},
								},
							},
						}),
						new ImageMinimizerPlugin({
							test: /\.svg$/i,
							exclude: /images[\\/]icons[\\/]sprite\.svg$/i,
							minimizer: {
								implementation: ImageMinimizerPlugin.svgoMinify,
								options: {
									encodeOptions: {
										multipass: true,
										plugins: [{ name: 'preset-default' }],
									},
								},
							},
						}),
					]
				: []),
		],
	},
	resolve: {
		alias: {
			'@blocks': path.resolve(__dirname, 'blocks'),
			'@js': path.resolve(__dirname, 'assets/js'),
			'@scss': path.resolve(__dirname, 'assets/scss'),
		},
	},
	plugins,
};
