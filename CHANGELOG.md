# Changelog

All notable changes to this theme are documented here. The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the project adheres to [Semantic Versioning](https://semver.org/). `npm version` moves the `[Unreleased]` section into a new release.

## [Unreleased]

### Added

- `npm run rename` (`bin/rename.js`): renames every theme identifier from four tokens (slug, vendor, name, local domain) and rewrites its own tokens so it can run again.
- `theme.json` as the single source of design tokens: palette, fluid font sizes, Space Mono family with its four `@font-face`, block gap, root padding, base body, heading and button styles.
- `npm run lint` running stylelint, ESLint and PHP_CodeSniffer (WordPress Coding Standards) in one go; `lint:php` and `lint:php:fix` scripts.
- Preload of the first font face declared in `theme.json` through `wp_preload_resources`.
- `is_developer()` helper and `wp_eclipse_is_developer` filter gating technical admin menus.
- `wp_eclipse_load_cf7_assets` filter to load Contact Form 7 assets for forms outside the post content.
- `CHANGELOG.md`, release flow (`npm version` syncs `style.css` and stamps the changelog) and `npm run package` producing a release archive from `.distignore`.

### Changed

- Text domain is `wp-eclipse` (theme slug), style and script handles are `wp-eclipse-*`, block namespace is `wp-eclipse`, Composer package is `nicogill/wp-eclipse`.
- Theme script is deferred through the `strategy` argument of `wp_enqueue_script`; `Requires at least` is 6.4.
- SCSS consumes `theme.json` presets through aliases in `_variables.scss`; the `wrap` mixin uses the root padding variables; unused mixins and Sass width variables removed.
- Single webpack entry (`main.js` imports `main.scss`), no RTL output, fonts served from `assets/fonts` instead of being copied and hashed by webpack.
- Toolchain: `@wordpress/scripts` 35 (ESLint 10 flat config in `eslint.config.js`, stylelint 17), `@wordpress/stylelint-config` 27, PHP_CodeSniffer 3.13.6, WPCS 3.4.1; stylelint config rebuilt on the WordPress preset with a BEM class pattern.
- `wp-cli/wp-cli-bundle` replaced by `wp-cli/i18n-command`; the POT file lives in `languages/` instead of `build/languages`.
- Local-only hooks rely on `WP_ENVIRONMENT_TYPE` instead of a hardcoded host.
- `.nvmrc` on Node 25, `engines` declared in `package.json`.

### Removed

- Editor asset enqueues pointing to missing `filters.js` and `variations.js`.
- `Access-Control-Allow-Origin: *` on the REST API, unsanitized SVG upload MIME type, global search kill, forced lazy loading on every image, `the_content` filter returning `false`.
- Dead hooks, unused constants and `main_classes()`, client leftovers (recipe column, Duplicator), browser-sniffing body classes, nonexistent TinyMCE buttons and the empty TinyMCE stylesheet, preload of CSS and JS already in the head.
- `eslint-plugin-eslint-comments`, legacy `.eslintrc.js` and `.eslintignore`.

### Fixed

- Socials menu: YouTube mapped, unknown networks keep their text label instead of calling a missing icon.
- `get_svg()` escapes every attribute, uses `href` and `wp_unique_id()`, and exposes a provided title to assistive technologies.
- Contact Form 7 assets load when a form is in the content instead of on a page template that did not exist.
- `rel="noopener"` on `_blank` links (no `nofollow`), translated navigation `aria-label`, `wp_date()` in the footer, `Author URI` typo in `style.css`.
- PHP_CodeSniffer: 38 errors and 11 warnings down to zero.

## [1.2.2] - 2026-02-19

- Fix the SVG sprite pipeline and align theme asset loading.
- PHPCS-driven cleanup across theme files, text domain defaults and PHPCS scope aligned.

## [1.2.1] - 2026-02-19

- Improve block scaffolding (`create-block` templates for dynamic and ACF blocks) and refresh the tooling.

## [1.2.0] - 2026-02-19

- Document the README and the Gutenberg/theme setup.
- Modernize the asset build (`@wordpress/scripts`), the blocks workflow and linting; build output reorganized into `js/` and `css/`.
- Social icons as SVG.

## [1.1.0] - 2025-07-03

- Responsive navigation starter and accessible mobile menu dialog.
- Theme cleaning, initial improvements.

## [1.0.0] - 2025-07-02

- First version.

[Unreleased]: https://github.com/NicoGill/wp-eclipse/compare/1.2.2...HEAD
[1.2.2]: https://github.com/NicoGill/wp-eclipse/compare/1.2.1...1.2.2
[1.2.1]: https://github.com/NicoGill/wp-eclipse/compare/1.2...1.2.1
[1.2.0]: https://github.com/NicoGill/wp-eclipse/compare/1.1...1.2
[1.1.0]: https://github.com/NicoGill/wp-eclipse/compare/Version-1...1.1
[1.0.0]: https://github.com/NicoGill/wp-eclipse/releases/tag/Version-1
