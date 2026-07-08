# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

A Laravel 8 (PHP) + Vue 3 monolith for a shoe/footwear manufacturer's site ("TYT/Balkun"). It serves two very different things from one codebase:

- A **public marketing/e-commerce site** rendered with Blade templates (`resources/views`), covering catalog browsing, product detail, client registration/login, a private "zona privada" order/cart area, contact forms, job applications, etc.
- An **admin back-office SPA** mounted at `/adm`, built with Vue 3 + vue-router (`resources/js`), driven entirely by a JSON API under `routes/api.php`.

## Commands

Frontend (Node/npm):
- `npm run dev` / `npm run development` — Laravel Mix dev build (compiles `resources/js/app.js`, `resources/js/page.js`, `resources/scss/app.scss`)
- `npm run watch` — Mix watch mode
- `npm run hot` — Mix watch with HMR
- `npm run prod` / `npm run production` — Mix production build
- `npm run build` — separate `vue-cli-service build` (uses `vue.config.js`, entry `resources/js/app.js`) — a second, parallel build pipeline for the Vue admin app, distinct from Mix

Backend (PHP/Composer, via `artisan`):
- `php artisan serve` — run the app locally
- `php artisan migrate` — run DB migrations
- `php artisan test` or `vendor/bin/phpunit` — run the test suite (only default Laravel example tests exist under `tests/Unit` and `tests/Feature`; no project-specific tests currently)
- `vendor/bin/phpunit --filter TestName` — run a single test
- `php artisan route:clear`, `config:clear`, `cache:clear`, `view:clear` — there are also `/clear-cache` and `/install-storage` web routes in `routes/web.php` that do this remotely (legacy ops helpers)

There is no linter/formatter configured for PHP or JS in this repo (no ESLint/Pint config present).

## Architecture

### Admin SPA (`resources/js`)

Every admin entity (Familia, Articulo, Cliente, Empresa, Calidad, Pedidos, Vendedores, etc.) lives under `resources/js/views/data/<entity>/` and follows the **same five-file convention**:
- `Layout.vue` — wraps the entity's routes (breadcrumbs/section chrome)
- `Home.vue` — listing/table view, backed by `window.dataPaginator(...)` (defined in `app.js`) for filtering/pagination against a POST endpoint
- `Add.vue` / `Edit.vue` — thin wrappers around `Form.vue` for create/update
- `Form.vue` — the actual form fields
- `config.js` — defines that entity's `routes` object (path `/adm/<entity>`, child routes for list/add/edit/copy) and imports the four components above

All per-entity `config.js` route objects are aggregated in `resources/js/views/data/main/config.js`, which is imported into `resources/js/router/index.js` alongside `configurations/config` and `stock/config`. **When adding a new admin entity, follow this exact Layout/Home/Add/Edit/Form/config.js pattern and register it in `views/data/main/config.js`.**

Global app wiring lives in `resources/js/app.js`:
- `window.httpRequest({url, method, data, errors})` — the app's fetch wrapper; centrally handles 401 (redirect to `/adm/login`), 405, 422 (validation errors, auto-populated into an `errors` reactive object or shown via `awesomeModal`), and 500 responses. Use this (not raw `fetch`/axios) for admin API calls.
- `window.$globalState` — reactive global state for auth user/status and sidebar UI prefs (persisted to `localStorage`)
- `window.verifyAuth()` — called on load to check the `/adm/check-auth` session and populate `$globalState.auth`
- `window.dataPaginator({urlBase, filtersKeys})` — shared composable used by every entity's `Home.vue` for server-side filtered/paginated listing (POSTs filters as `FormData` to `urlBase`)
- `window.pathAsset(path)` / `window.public_path` — asset URL helper, driven by a `<meta name="public-path">` tag
- `window.toCurrency(numero, decimales)` — locale-aware currency formatting (reads `<meta name="decimal-separator">` / `thousands-separator`)

A second, separate Vue root (`resources/js/page.js`, mounted at `#page`) powers a small piece of the public-facing Blade pages (currently just `navBar`) — it is not part of the admin SPA.

### Backend (`app/`)

- `app/Http/Controllers/Admin/*Controller.php` — one controller per admin entity, exposing `all` (paginated list POST), `find`, `store`, `delete` actions consumed by the matching Vue entity folder. This mirrors the frontend's per-entity convention 1:1 — a new admin entity typically needs a new Model, a new `Admin/<Entity>Controller`, an API route group, and the five-file Vue folder above.
- `app/Http/Controllers/PageController.php`, `LoginClienteController.php`, `ZonaPrivadaController.php`, `SitemapController.php` — the public-site controllers (catalog, product detail, client auth, private cart/order area, sitemap).
- `app/Http/Controllers/Soap/*` — SOAP client controllers integrating with an external ERP/product system (`SoapConexion.php` sets up the client; `Products.php`/`Login.php` consume it — see also `Articulo::updateApi()` / `Cliente::updateApi()` sync entry points referenced from `routes/web.php`).
- `app/Libs/Watchdog*.php` — a logging/monitoring facade+trait used across the app.
- Admin auth/permissions use the `mateusjunges/laravel-acl` package (`Junges\ACL\Models\Permission`, `Group`) — see `PermissionController` / `GroupController`.
- Client-facing (non-admin) auth uses a custom `auth.cliente` middleware (`app/Http/Middleware/middelewarecliente.php`), separate from the admin `auth` middleware guarding `/adm` API routes.

### Routing

- `routes/web.php` — public Blade routes, plus a catch-all `adm/{any}` that returns `welcome.blade.php` (the admin SPA shell) so vue-router can take over client-side.
- `routes/api.php` (~1000 lines) — almost entirely admin CRUD endpoints, wrapped in one outer `Route::group(['middleware' => ['auth']])` and then per-entity `Route::group(['prefix' => '<entity>', 'as' => '<entity>.'])` blocks with `store/{id?}`, `delete/{id}`, `/` (list, POST), `/{id}` (find) actions — matching the `httpRequest`/`dataPaginator` calls made from each entity's Vue files.

### Views (`resources/views`)

Blade views are split into `page/` (public marketing/catalog pages), `ZonaPrivada/` (authenticated client cart/order area), `emails/` (transactional email templates), and `layouts/` (shared page chrome — note both an older `plantilla.blade.php` and newer `newplantilla.blade.php` exist, so check which layout a view actually extends before assuming).

## Notes

- Local dev URL is `http://balkun.test/` (see `mix.browserSync` in `webpack.mix.js`) — a local Valet/Homestead-style domain, not `localhost`.
- Some Vue files are stale duplicates left in place (e.g. `views/data/articulos/Home copy.vue`, `Home copy 2.vue`, `views/data/cliente/HomeBkp.vue`) — don't assume every file in a folder is live; check `config.js` to see which components are actually routed.
