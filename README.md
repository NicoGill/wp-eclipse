
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
- Design tokens: `theme.json` is the single source (palette, fluid font sizes, font family and `@font-face`, block gap, root padding); SCSS consumes them through `--wp--preset--*` / `--wp--style--*` custom properties and the aliases in `assets/scss/abstracts/_variables.scss`
- Frontend assets: `Sass` + `stylelint` (`@wordpress/stylelint-config`), SVG spritemap generation (`svg-spritemap-webpack-plugin`), image optimization (`image-minimizer-webpack-plugin` + `sharp`)
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

Clone this repository, then run:

```bash
npm run rename -- --slug acme-studio --vendor Acme --name "Acme Studio" --domain acme-studio.test
```

Only `--slug` is required (kebab-case). Defaults: `--vendor` keeps `NicoGill`, `--name` is the title-cased slug, `--domain` is `<slug>.test`. Add `--dry-run` to list the files without writing.

Every identifier derives from those four tokens:

| Token | Drives |
|:-|:-|
| `wp-eclipse` (slug) | theme folder, text domain, style/script handles, npm name, block namespace, block category slug, Composer name |
| `wp_eclipse` (slug in snake_case, derived) | PHP namespace tail, `@package`, hook prefix |
| `NicoGill` (vendor) | PHP namespace root (`NicoGill\wp_eclipse`), lowercase in Composer name |
| `Eclipse` (name) | `Theme Name` in `style.css`, block category title |
| `eclipse.test` (domain) | BrowserSync proxy in `webpack.config.js` |

Then rename the theme folder to the new slug, activate it (`wp theme activate <slug>`), and review `style.css` header fields, `package.json` / `composer.json` metadata and this README.

## Development

Command | Action
:- | :-
`npm run start` | Builds assets and starts Live Reload and Browsersync servers
`npm run build` | Builds production-ready assets for a deployment
`npm run rename` | Renames every theme identifier for a new project (see above)
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

- Source of truth is `/blocks/*`, `/assets/*` and `theme.json`.
- `assets/js/main.js` imports `assets/scss/main.scss`: the build emits `build/js/main.js`, `build/css/main.css` and the icon sprite. Fonts stay in `assets/fonts` and are declared in `theme.json`.
- Compiled files are written to `/build` via `@wordpress/scripts`.
- Blocks are auto-registered from `/build/blocks` on WordPress `init`.
- ACF Pro blocks are supported via `block.json` (`acf.renderTemplate`).
- Block scaffolding template is stored in `/inc/block-template`.
