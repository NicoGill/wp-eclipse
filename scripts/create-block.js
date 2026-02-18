#!/usr/bin/env node

const fs = require( 'fs' );
const path = require( 'path' );

const args = process.argv.slice( 2 );

if ( args.length === 0 ) {
	process.stderr.write(
		'Usage: npm run create:block -- <slug> [--acf] [--namespace=wp-eclipse]\n'
	);
	process.exit( 1 );
}

const acfEnabled = args.includes( '--acf' );
const slugArg = args.find( ( arg ) => ! arg.startsWith( '--' ) );
const namespaceArg = args.find( ( arg ) => arg.startsWith( '--namespace=' ) );
const namespace = namespaceArg
	? namespaceArg.replace( '--namespace=', '' )
	: 'wp-eclipse';

if ( ! slugArg ) {
	process.stderr.write( 'A block slug is required.\n' );
	process.exit( 1 );
}

const slug = slugArg
	.toLowerCase()
	.trim()
	.replace( /[^a-z0-9-]/g, '-' )
	.replace( /-{2,}/g, '-' )
	.replace( /^-|-$/g, '' );

if ( ! slug ) {
	process.stderr.write( 'The block slug is invalid.\n' );
	process.exit( 1 );
}

const blockName = `${ namespace }/${ slug }`;
const blockDir = path.resolve( process.cwd(), 'blocks', slug );

if ( fs.existsSync( blockDir ) ) {
	process.stderr.write( `Block "${ slug }" already exists in /blocks.\n` );
	process.exit( 1 );
}

const title = slug
	.split( '-' )
	.map( ( part ) => part.charAt( 0 ).toUpperCase() + part.slice( 1 ) )
	.join( ' ' );

const blockJson = {
	$schema: 'https://schemas.wp.org/trunk/block.json',
	apiVersion: 3,
	name: blockName,
	version: '0.1.0',
	title,
	category: 'design',
	icon: 'layout',
	description: '',
	keywords: [],
	supports: {
		html: false,
	},
	textdomain: 'wp_eclipse',
	editorScript: 'file:./index.js',
	style: 'file:./index.css',
	editorStyle: 'file:./index.css',
};

if ( acfEnabled ) {
	blockJson.acf = {
		mode: 'preview',
		renderTemplate: 'render.php',
		blockVersion: 2,
	};
}

const acfRenderTemplate = `<?php
/**
 * ACF block template for ${ blockName }.
 *
 * @package wp_eclipse
 */

namespace NicoGill\\wp_eclipse;

$title = get_field( 'title' );
?>
<section <?php echo get_block_wrapper_attributes(); ?>>
\t<?php if ( ! empty( $title ) ) : ?>
\t\t<h2><?php echo esc_html( $title ); ?></h2>
\t<?php endif; ?>
</section>
`;

const standardIndexJs = `import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import metadata from './block.json';
import './style.scss';
import './editor.scss';

registerBlockType( metadata.name, {
\tedit() {
\t\treturn <div { ...useBlockProps() }>${ title }</div>;
\t},
\tsave() {
\t\treturn <div { ...useBlockProps.save() }>${ title }</div>;
\t},
} );
`;

const acfIndexJs = `import './style.scss';
import './editor.scss';
`;

const styleScss = `.wp-block-${ namespace.replace(
	/[^a-z0-9-]/gi,
	'-'
) }-${ slug } {
\tpadding: 1.5rem;
\tborder: 1px dashed currentColor;
}
`;

const editorScss = `.wp-block-${ namespace.replace(
	/[^a-z0-9-]/gi,
	'-'
) }-${ slug } {
\topacity: 0.95;
}
`;

fs.mkdirSync( blockDir, { recursive: true } );
fs.writeFileSync(
	path.join( blockDir, 'block.json' ),
	`${ JSON.stringify( blockJson, null, '\t' ) }\n`
);
fs.writeFileSync(
	path.join( blockDir, 'index.js' ),
	acfEnabled ? acfIndexJs : standardIndexJs
);
fs.writeFileSync( path.join( blockDir, 'style.scss' ), styleScss );
fs.writeFileSync( path.join( blockDir, 'editor.scss' ), editorScss );

if ( acfEnabled ) {
	fs.writeFileSync( path.join( blockDir, 'render.php' ), acfRenderTemplate );
}

process.stdout.write( `Block "${ blockName }" created in blocks/${ slug }.\n` );
