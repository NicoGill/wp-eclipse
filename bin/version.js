#!/usr/bin/env node
/**
 * Runs on `npm version` (package.json is already bumped): sync the style.css
 * header and turn the CHANGELOG "[Unreleased]" section into the new release.
 */
const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const { version, repository } = require(path.join(root, 'package.json'));
const today = new Date().toISOString().slice(0, 10);

const styleFile = path.join(root, 'style.css');
fs.writeFileSync(
	styleFile,
	fs
		.readFileSync(styleFile, 'utf8')
		.replace(/^Version: .*$/m, `Version: ${version}`)
);

const logFile = path.join(root, 'CHANGELOG.md');
const repo = repository.url.replace(/\.git$/, '');
const log = fs
	.readFileSync(logFile, 'utf8')
	.replace('## [Unreleased]', `## [Unreleased]\n\n## [${version}] - ${today}`)
	.replace(
		/^\[Unreleased\]: .*\/compare\/(.+)\.\.\.HEAD$/m,
		`[Unreleased]: ${repo}/compare/${version}...HEAD\n[${version}]: ${repo}/compare/$1...${version}`
	);
fs.writeFileSync(logFile, log);

console.log(`style.css and CHANGELOG.md stamped with ${version}.`);
