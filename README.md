
# WordPress Eclipse theme

WordPress development starter theme by (and mostly for) Nicolas Gillium, freelance web developer based in Nancy since 2014.

Largely inspired by themes such as [wd_s](https://github.com/WebDevStudios/wd_s), [_s](https://github.com/Automattic/_s) 
and [air-light](https://github.com/digitoimistodude/air-light).

🎯 The aim is to provide a simple but effective development base for managing frontend dependencies.

⚠️ **Under development and improvement.** ⚠️

## Author

- [Nicolas Gillium](https://www.github.com/nicogill)

## Stack

@wordpress/scripts

## Setup

```bash
npm install
```

```bash
composer install
```

## Development

Command | Action
:- | :-
`npm run start` | Builds assets and starts Live Reload and Browsersync servers
`npm run build` | Builds production-ready assets for a deployment
`npm run create:block -- my-block` | Creates a Gutenberg block scaffold in `/blocks/my-block`
`npm run create:block:acf -- my-acf-block` | Creates an ACF-compatible block scaffold in `/blocks/my-acf-block`
`npm run lint:js` | Runs JavaScript linting
`npm run lint:js:fix` | Runs JavaScript linting with auto-fix
`npm run lint:css` | Runs SCSS linting
`npm run lint:css:fix` | Runs SCSS linting with auto-fix
`npm run lint:style` | Runs stylelint on `/assets` and `/blocks`
`npm run lint:style:fix` | Runs stylelint with auto-fix on `/assets` and `/blocks`

## Blocks

- Source of truth is `/blocks/*` and `/assets/*`.
- Compiled files are written to `/build` via `@wordpress/scripts`.
- Blocks are auto-registered from `/build/blocks` on WordPress `init`.
- ACF Pro blocks are supported via `block.json` (`acf.renderTemplate`).
