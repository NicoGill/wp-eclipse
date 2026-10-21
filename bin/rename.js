#!/usr/bin/env node
/**
 * Rename the theme for a new project.
 *
 *   npm run rename -- --slug acme-studio [--vendor Acme] [--name "Acme Studio"] [--domain acme-studio.test] [--dry-run]
 *
 * Every identifier derives from four tokens: slug (kebab-case: folder, text domain,
 * handles, npm and block namespace), vendor (PHP namespace root), name (human title)
 * and the local dev domain. snake_case and lowercase variants are derived.
 *
 * CURRENT is rewritten by the replacement itself, so the script stays correct after a rename.
 */
const fs = require('fs');
const path = require('path');
const { parseArgs } = require('util');

const CURRENT = {
	slug: 'wp-eclipse',
	vendor: 'NicoGill',
	name: 'Eclipse',
	domain: 'eclipse.test',
};

const ROOT = path.resolve(__dirname, '..');
const SKIP_DIRS = new Set([
	'.git',
	'node_modules',
	'vendor',
	'build',
	'.npm-cache',
]);
const TEXT_FILE = /\.(php|js|json|scss|css|md|mustache|dist|txt|pot)$/;

const { values: args } = parseArgs({
	options: {
		slug: { type: 'string' },
		vendor: { type: 'string' },
		name: { type: 'string' },
		domain: { type: 'string' },
		'dry-run': { type: 'boolean', default: false },
	},
});

if (!args.slug || !/^[a-z][a-z0-9-]*$/.test(args.slug)) {
	console.error(
		'Usage: npm run rename -- --slug <kebab-case> [--vendor PascalCase] [--name "Human Name"] [--domain local.test] [--dry-run]'
	);
	process.exit(1);
}
if (args.vendor && !/^[A-Za-z][A-Za-z0-9]*$/.test(args.vendor)) {
	console.error('--vendor must be alphanumeric, e.g. Acme');
	process.exit(1);
}

const titleCase = (slug) =>
	slug
		.split('-')
		.map((w) => w[0].toUpperCase() + w.slice(1))
		.join(' ');
const snake = (slug) => slug.replace(/-/g, '_');

const next = {
	slug: args.slug,
	vendor: args.vendor || CURRENT.vendor,
	name: args.name || titleCase(args.slug),
	domain: args.domain || `${args.slug}.test`,
};

// Most specific tokens first so "eclipse.test" is not eaten by a shorter match.
const replacements = [
	[CURRENT.domain, next.domain],
	[snake(CURRENT.slug), snake(next.slug)],
	[CURRENT.slug, next.slug],
	[CURRENT.vendor, next.vendor],
	[CURRENT.vendor.toLowerCase(), next.vendor.toLowerCase()],
	[CURRENT.name, next.name],
].filter(([from, to]) => from !== to);

function walk(dir, out = []) {
	for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
		const full = path.join(dir, entry.name);
		if (entry.isDirectory()) {
			if (!SKIP_DIRS.has(entry.name)) {
				walk(full, out);
			}
		} else if (TEXT_FILE.test(entry.name)) {
			out.push(full);
		}
	}
	return out;
}

let changed = 0;
for (const file of walk(ROOT)) {
	const src = fs.readFileSync(file, 'utf8');
	const out = replacements.reduce(
		(s, [from, to]) => s.split(from).join(to),
		src
	);
	if (out === src) {
		continue;
	}
	changed++;
	if (!args['dry-run']) {
		fs.writeFileSync(file, out);
	}
	console.log(
		`${args['dry-run'] ? 'would update' : 'updated'}  ${path.relative(ROOT, file)}`
	);
}

console.log(
	`\n${changed} file(s) ${args['dry-run'] ? 'would be ' : ''}updated.`
);
console.log(
	`Now: rename the theme folder to "${next.slug}", run "wp theme activate ${next.slug}", then "npm install && npm run build".`
);
