const { join } = require('path');

module.exports = {
	blockTemplatesPath: join(__dirname, 'dynamic'),
	defaultValues: {
		transformer: (view) => {
			const {
				variantVars: { isInteractiveVariant },
			} = view;
			return {
				...view,
				requiresAtLeast: isInteractiveVariant ? '6.5' : '6.1',
			};
		},
		author: 'NicoGill',
		category: 'wp_eclipse-blocks',
		dashicon: 'pets',
		description: 'A custom block created by the create-block for the theme',
		namespace: 'wpeclipse',
		textdomain: 'wp_eclipse',
		editorScript: 'file:./index.js',
		editorStyle: 'file:./index.css',
		style: 'file:./style.css',
		render: 'file:./render.php',
		viewScriptModule: 'file:./view.js',
		version: '1.0.0',
		customPackageJSON: {
			prettier: '@wordpress/prettier-config',
		},
	},
	variants: {
		dynamic: {
			title: 'Dynamic Block',
			description: 'Create a dynamic server-rendered block',
			blockTemplatesPath: join(__dirname, 'dynamic'),
		},
		acf: {
			title: 'ACF Block',
			description: 'Create an ACF-powered block scaffold',
			blockTemplatesPath: join(__dirname, 'acf'),
		},
	},
};
