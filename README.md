# 🌕️ Eclipse, WordPress starter theme

Hybrid WordPress starter theme (PHP templates plus blocks) by [Nicolas Gillium](https://nicolas-gillium.fr), freelance web developer in Nancy since 2014. Built for mockup integration: one source of design tokens, a modern asset pipeline, strict linting and a one-command rename for client projects.

Inspired by [wd_s](https://github.com/WebDevStudios/wd_s), [_s](https://github.com/Automattic/_s) and [air-light](https://github.com/digitoimistodude/air-light). Functions, not classes: every file in `inc/` is a plain namespaced PHP file autoloaded by `functions.php`.

## Requirements

- WordPress 6.4+, PHP 8.0+
- Node.js 22.13+ (see `.nvmrc`), npm 8.19+
- Composer 2.9+
- Optional plugins the theme integrates with: ACF Pro (blocks, options page), Contact Form 7, Yoast SEO, Safe SVG (required for SVG uploads)

## Quick start

```bash
npm install && composer install
```

For a new project, rename every identifier first (see [Rename this theme](#rename-this-theme)):

```bash
npm run rename -- --slug acme-studio --vendor Acme --name "Acme Studio" --domain acme-studio.test
```

Then:

```bash
npm run start
```

`start` builds the assets, watches them and proxies the local site through BrowserSync on `https://localhost:3000` (local domain and Laragon SSL paths live in `webpack.config.js`). `npm run build` produces the production assets.

## Structure

```text
assets/
  fonts/        self-hosted web fonts, declared in theme.json
  images/       static images, copied to build/images (icons/*.svg become one sprite)
  js/           main.js (imports main.scss) and modules/
  scss/         abstracts (mixins, aliases, breakpoints), base, components, theme, pages, vendors
bin/            rename.js, version.js
blocks/         block sources scaffolded by npm run create:block (compiled to build/blocks)
build/          compiled assets, generated, not versioned
inc/            PHP, autoloaded by functions.php (see below)
languages/      wp-eclipse.pot
patterns/       block patterns (subfolders become pattern categories)
template-parts/ reusable template fragments
theme.json      design tokens and base styles
```

| `inc/` folder | Content |
|:-|:-|
| `functions/` | Helpers used by templates and hooks: `get_svg()`, `get_primary_term()`, `is_developer()`, ... |
| `hooks/` | Actions and filters: admin, navigation, security, plugins (ACF, CF7, Yoast), local-only behaviour |
| `setup/` | Theme supports, menus, asset enqueue, ACF options page |
| `gutenberg/` | Block registration from `build/blocks`, block styles, categories, allowed blocks |
| `template-tags/` | Output helpers for templates (`print_post_date()`, pagination, edit link) |
| `post-types/`, `taxonomies/`, `shortcodes/` | Empty scaffold folders, one file per registration |

## Design tokens

`theme.json` is the single source for the palette, fluid font sizes, font family and `@font-face`, block gap, root padding, and the base body, heading and button styles. WordPress outputs them on the front and in the editor as `--wp--preset--*` and `--wp--style--*` custom properties.

SCSS never redeclares a token: `assets/scss/abstracts/_variables.scss` only holds semantic aliases (`--color-primary`, `--font-default`, ...) over those presets, plus values the editor does not need (status colors). Breakpoints live in `_env.scss` as Sass variables. To integrate a mockup, change `theme.json` first, then the SCSS.

## Assets pipeline

- `assets/js/main.js` imports `assets/scss/main.scss`: one entry, one `build/js/main.js` and one `build/css/main.css`, enqueued with their build hash and `defer`.
- `assets/images/icons/*.svg` are merged into `build/images/icons/sprite.svg`. In PHP: `get_svg( [ 'icon' => 'menu' ] )`; in menus, an `icon-{name}` CSS class on a menu item prepends that icon. The socials menu swaps titles for network icons automatically.
- Images in `assets/images` are copied to `build/images` and compressed in production (sharp, svgo).
- Fonts are served straight from `assets/fonts`; the first font face declared in `theme.json` is preloaded.
- Aliases `@scss`, `@js` and `@blocks` resolve to their folders in webpack.

## Blocks

- `npm run create:block` scaffolds a dynamic block (`render.php`), `npm run create:block:acf` an ACF block (`acf.renderTemplate`), both from the templates in `inc/block-template`.
- Blocks are compiled to `build/blocks/<slug>` and registered from their `block.json` on `init`.
- Block patterns go in `patterns/<category>/`; each subfolder is registered as a pattern category. Remote patterns are disabled.
- Core blocks that do not fit a classic theme (query loop, comments, navigation, ...) are removed in `inc/gutenberg/unregister-blocks.php`.

## Commands

| Command | Action |
|:-|:-|
| `npm run start` | Build, watch and BrowserSync |
| `npm run build` | Production build |
| `npm run lint` | Every linter: SCSS, JavaScript and PHP (WordPress Coding Standards) |
| `npm run lint:css` / `lint:css:fix` | stylelint on SCSS (`@wordpress/stylelint-config`, BEM class names) |
| `npm run lint:js` / `lint:js:fix` | ESLint on JavaScript (`@wordpress/eslint-plugin`, flat config) |
| `npm run lint:php` / `lint:php:fix` | PHP_CodeSniffer with WPCS and PHPCompatibilityWP (`phpcs` / `phpcbf`) |
| `npm run format` | Prettier on JavaScript, SCSS and JSON |
| `npm run create:block` / `create:block:acf` | Scaffold a block in `blocks/` |
| `npm run rename` | Rename every theme identifier for a new project |
| `npm version patch`, `minor` or `major` | Release: lint, bump `package.json` and `style.css`, stamp the changelog, commit and tag |
| `npm run package` | Production build and release archive in `dist/` |
| `composer run pot` | Generate `languages/wp-eclipse.pot` |
| `composer run report` | Full PHP_CodeSniffer report with sniff sources |

## Rename this theme

```bash
npm run rename -- --slug acme-studio --vendor Acme --name "Acme Studio" --domain acme-studio.test
```

Only `--slug` is required (kebab-case). Defaults: `--vendor` keeps `NicoGill`, `--name` is the title-cased slug, `--domain` is `<slug>.test`. Add `--dry-run` to list the files without writing. Every identifier derives from those four tokens:

| Token | Drives |
|:-|:-|
| `wp-eclipse` (slug) | theme folder, text domain, style/script handles, npm name, block namespace, block category slug, Composer name |
| `wp_eclipse` (snake_case, derived) | PHP namespace tail, `@package`, hook prefix |
| `NicoGill` (vendor) | PHP namespace root (`NicoGill\wp_eclipse`), lowercase in the Composer name |
| `Eclipse` (name) | `Theme Name` in `style.css`, block category title |
| `eclipse.test` (domain) | BrowserSync proxy in `webpack.config.js` |

The script rewrites its own tokens, so it can run again later. Then rename the theme folder to the new slug, activate it (`wp theme activate <slug>`), and review the `style.css` header, `package.json` / `composer.json` metadata and this README.

## Release and deploy

1. Record the changes under `[Unreleased]` in [CHANGELOG.md](CHANGELOG.md) as you go.
2. On a clean tree, run `npm version patch` (or `minor`, `major`). It lints, bumps `package.json` and `style.css`, turns `[Unreleased]` into the new version with today's date, commits as `release: x.y.z` and tags `x.y.z`.
3. `git push --follow-tags`
4. `npm run package` builds the production assets and writes `dist/wp-eclipse.x.y.z.zip` with only what a site needs (`.distignore` lists what stays out: sources, tooling, `node_modules`, `vendor`). Upload the archive through *Appearance > Themes* or unzip it in `wp-content/themes/`.

Deploying with rsync or a CI job works the same way: `npm ci && npm run build`, then sync the theme folder minus the entries of `.distignore`.

## License

GPL-2.0-or-later. Use it to make something cool, have fun, and share what you've learned with others.
