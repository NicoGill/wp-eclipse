
# 🌕️ WordPress Eclipse theme

WordPress development starter hybrid theme by (and mostly for) Nicolas Gillium, freelance web developer based in Nancy since 2014.

Largely inspired by themes such as [wd_s](https://github.com/WebDevStudios/wd_s), [_s](https://github.com/Automattic/_s) 
and [air-light](https://github.com/digitoimistodude/air-light).

🎯 The aim is to provide a simple but effective development base for managing frontend dependencies.

⚠️ **Under development and improvement.** ⚠️

## Author

- [Nicolas Gillium](https://www.github.com/nicogill)

## Stack

- JavaScript/Build: `@wordpress/scripts` (Webpack-based build pipeline for WordPress themes/blocks)
- Dev server: `BrowserSync` via `browser-sync-webpack-plugin` (live reload/proxy workflow)
- Frontend assets: `Sass` + `stylelint` (`stylelint-config-standard-scss`), SVG spritemap generation (`svg-spritemap-webpack-plugin`), image optimization (`image-minimizer-webpack-plugin` + `sharp`)
- JavaScript linting/formatting: tooling provided by `@wordpress/scripts` (ESLint + formatting commands)
- WordPress/PHP quality: `PHP_CodeSniffer` with `WordPress Coding Standards (WPCS)` and `PHPCompatibilityWP`
- WordPress CLI: `wp-cli/wp-cli-bundle` (including POT generation via `wp i18n make-pot`)
- ACF development support: `php-stubs/acf-pro-stubs` for static analysis/autocomplete

## `inc/` Directory Structure

All `*.php` files inside these directories are auto-loaded by `functions.php`.

- `inc/functions/`: Reusable helper functions used across templates and hooks.
- `inc/hooks/`: WordPress actions/filters integrations (core, admin, navigation, plugins, dev-only behavior).
- `inc/setup/`: Theme bootstrap (theme supports, menus, assets enqueue, preload, ACF options pages).
- `inc/gutenberg/`: Block editor integration (registering block assets, styles, patterns, and restrictions).
- `inc/template-tags/`: Presentation-oriented template helpers for front-end rendering.
- `inc/post-types/`: Place custom post type registrations here.
- `inc/taxonomies/`: Place custom taxonomy registrations here.
- `inc/shortcodes/`: Place shortcode definitions here.

Note: `inc/post-types/`, `inc/taxonomies/`, and `inc/shortcodes/` are scaffold directories and may be empty in a fresh install.

## Requirements

- Node.js `>= 18.12.0`
- npm `>= 8.19.2`
- Composer `>= 2.9`

## Setup

```bash
npm install
```

```bash
composer install
```

### Rename This Theme

Clone this repository, rename the theme folder, then run a case-sensitive find/replace across the codebase (same approach as `_s`).

Use these placeholders:

- `your-theme-slug` (kebab-case, example: `acme-studio`)
- `your_theme_slug` (snake_case, example: `acme_studio`)
- `YourVendor` (PHP vendor/namespace root, example: `Acme`)

Recommended replacement steps:

1. Search for `'wp_eclipse'` and replace with `'your_theme_slug'` (text domain in PHP strings).
2. Search for `wp_eclipse_` and replace with `your_theme_slug_` (prefixed PHP functions, if any).
3. Search for `wp_eclipse-` and replace with `your_theme_slug-` (script/style handles, if any).
4. Search for `NicoGill\\wp_eclipse` and replace with `YourVendor\\your_theme_slug` (PHP namespace).
5. Search for `NicoGill\\eclipse\\` and replace with `YourVendor\\your_theme_slug\\` (constant namespace in `functions.php`).
6. Search for `wp-eclipse` and replace with `your-theme-slug` (npm package name, block namespace default, repository URL).
7. Search for `nicogill/eclipse` and replace with `yourvendor/your-theme-slug` (Composer package name).
8. Search for `eclipse.test` and replace with your local domain (example: `acme-studio.test`) in development-only files (`webpack.config.js`, `inc/hooks/dev-only.php`).
9. Search for `Text Domain: wp_eclipse` in `style.css` and replace with `Text Domain: your_theme_slug` (or your final text domain convention).

Then update:

- `style.css` theme header fields (Theme Name, URI, Author, Text Domain, Tags).
- Translation filename (for example `build/languages/wp_eclipse.pot` to your own slug).
- Project metadata in `package.json` and `composer.json`.
- This README.

## Development

Command | Action
:- | :-
`npm run start` | Builds assets and starts Live Reload and Browsersync servers
`npm run build` | Builds production-ready assets for a deployment
`npm run create:block` | Runs an interactive prompt to scaffold a dynamic Gutenberg block (with `render.php`) in `/blocks`
`npm run create:block:acf` | Runs an interactive prompt to scaffold an ACF-compatible block in `/blocks`
`npm run lint:js` | Runs JavaScript linting
`npm run lint:js:fix` | Runs JavaScript linting with auto-fix
`npm run lint:css` | Runs SCSS linting
`npm run lint:css:fix` | Runs SCSS linting with auto-fix
`npm run lint:style` | Runs stylelint on `/assets` and `/blocks`
`npm run lint:style:fix` | Runs stylelint with auto-fix on `/assets` and `/blocks`
`composer run format` | Runs PHP Code Beautifier and Fixer (`phpcbf`)
`composer run lint` | Runs PHP_CodeSniffer checks (`phpcs`)
`composer run report` | Runs a full PHP_CodeSniffer report
`composer run pot` | Generates/updates the POT file for translations

## Blocks

- Source of truth is `/blocks/*` and `/assets/*`.
- Compiled files are written to `/build` via `@wordpress/scripts`.
- Blocks are auto-registered from `/build/blocks` on WordPress `init`.
- ACF Pro blocks are supported via `block.json` (`acf.renderTemplate`).
- Block scaffolding template is stored in `/inc/block-template`.
