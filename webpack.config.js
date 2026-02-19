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

const moveRtlCssAssetsPlugin = {
	apply(compiler) {
		compiler.hooks.thisCompilation.tap(
			'MoveRtlCssAssetsPlugin',
			(compilation) => {
				const { Compilation } = compiler.webpack;

				compilation.hooks.processAssets.tap(
					{
						name: 'MoveRtlCssAssetsPlugin',
						stage: Compilation.PROCESS_ASSETS_STAGE_REPORT,
					},
					() => {
						Object.keys(compilation.assets).forEach((assetName) => {
							if (
								!assetName.endsWith('-rtl.css') ||
								assetName.startsWith('css/') ||
								assetName.startsWith('blocks/')
							) {
								return;
							}

							const targetName = `css/${assetName}`;
							const asset = compilation.getAsset(assetName);
							compilation.emitAsset(targetName, asset.source);
							compilation.deleteAsset(assetName);
						});
					}
				);
			}
		);
	},
};

const entries = {
	main: path.resolve(__dirname, 'assets/js/main.js'),
	theme: path.resolve(__dirname, 'assets/scss/main.scss'),
	tinymce: path.resolve(__dirname, 'assets/scss/editor-classic.scss'),
};

globSync('blocks/*/index.js', { cwd: __dirname }).forEach((file) => {
	const normalized = file.replace(/\\/g, '/');
	const blockSlug = normalized
		.replace(/^blocks\//, '')
		.replace(/\/index\.js$/, '');

	entries[`blocks/${blockSlug}/index`] = path.resolve(__dirname, file);
});

const fontFiles = globSync('assets/fonts/**/*.{woff,woff2,ttf,otf,eot}', {
	cwd: __dirname,
});
const imageFiles = globSync(
	'assets/images/**/*.{jpg,jpeg,png,gif,svg,webp,avif}',
	{
		cwd: __dirname,
	}
);

const plugins = [...defaultConfig.plugins];
const copyPatterns = [];

if (fontFiles.length) {
	copyPatterns.push({
		from: path.resolve(__dirname, 'assets/fonts'),
		to: path.resolve(__dirname, 'build/fonts'),
	});
}

if (imageFiles.length) {
	copyPatterns.push({
		from: path.resolve(__dirname, 'assets/images'),
		to: path.resolve(__dirname, 'build/images'),
	});
}

copyPatterns.push({
	from: path.resolve(__dirname, 'blocks'),
	to: path.resolve(__dirname, 'build/blocks'),
	noErrorOnMissing: true,
	globOptions: {
		ignore: ['**/index.js', '**/*.scss'],
	},
});

if (copyPatterns.length) {
	plugins.push(new CopyWebpackPlugin({ patterns: copyPatterns }));
}

plugins.push(
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
plugins.push(moveRtlCssAssetsPlugin);

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

// Keep block assets near block.json for WordPress block metadata resolution.
const jsOutputFilename = (pathData) => {
	const name = pathData.chunk?.name || '';
	return name.startsWith('blocks/') ? '[name].js' : 'js/[name].js';
};

plugins.forEach((plugin) => {
	if (plugin?.constructor?.name === 'MiniCssExtractPlugin') {
		plugin.options.filename = (pathData) => {
			const name = pathData.chunk?.name || '';
			return name.startsWith('blocks/') ? '[name].css' : 'css/[name].css';
		};
		plugin.options.chunkFilename = '[id].css';
	}

	if (plugin?.constructor?.name === 'RtlCssPlugin') {
		return;
	}
});

module.exports = {
	...defaultConfig,
	entry: entries,
	output: {
		path: path.resolve(__dirname, 'build'),
		filename: jsOutputFilename,
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
										jpeg: {
											quality: 75,
										},
										png: {
											quality: 80,
										},
										webp: {
											quality: 75,
										},
										avif: {
											quality: 50,
										},
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
