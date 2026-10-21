const globals = require('globals');
const wpPlugin = require('@wordpress/eslint-plugin');

module.exports = [
	{ ignores: ['**/build/**', '**/node_modules/**', '**/vendor/**', 'eslint.config.js'] },
	...wpPlugin.configs.recommended,
	{
		languageOptions: {
			globals: globals.browser,
			parserOptions: {
				requireConfigFile: false,
				babelOptions: {
					presets: [require.resolve('@wordpress/babel-preset-default')],
				},
			},
		},
		rules: {
			'@wordpress/no-global-event-listener': 'off', // no React components here
			'jsdoc/require-param': 'off',
			'jsdoc/require-returns-type': 'off',
			camelcase: 'off',
			'no-console': 'off',
		},
	},
];
