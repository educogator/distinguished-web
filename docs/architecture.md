# Architecture

The custom classic template hierarchy works without Twenty Twenty. `theme.json` v3
provides block/editor tokens and layout settings; PHP supplies site chrome. Production
serves ordinary PHP, CSS and deferred vanilla JavaScript. There is no frontend framework,
remote content fetch, external font, custom write endpoint or required plugin.

## Responsibilities

| Area | Files | Behavior |
| --- | --- | --- |
| Bootstrap | functions.php, inc/theme-setup.php | Feature supports, translations, native menus |
| Assets | inc/assets.php | Versioned local CSS/JS, localized interface strings, conditional comment-reply |
| Read-only content | inc/template-functions.php | Published pages, curated ID mapping, authored excerpts, cards |
| Navigation | inc/navigation.php, template-parts/site-header.php | Assigned menus, previous Twenty Twenty mapping, actual-page fallback |
| Administration | inc/customizer.php | Native sanitized theme mods only, no content writes |
| Homepage | front-page.php, template-parts/hero.php | Static page content once, or native posts query; existing-content discovery |
| Singular | page.php, single.php | Loop, content filters, captions, password form, page links, comments |
| Discovery | home.php, archive.php, search.php, index.php | Native queries and pagination; empty states |
| Missing content | 404.php | Retain native 404 status and search |
| Shared content | template-parts/ | Cards, context navigation, breadcrumbs, footer |
| Styling | theme.json, assets/css/ | Frontend/editor parity, core and classic media support |
| Enhancements | assets/js/main.js | Disclosures, drawer, optional native-dialog enlargement, embed fallback links |

## Dynamic data, privacy and security

All destinations come from `get_permalink()` on real records or native menu data. The
brief's slug references are only lookup keys; they never fabricate links when missing.
No automatic homepage paragraph extraction, HTML replacement, image-to-project inference,
taxonomy mutation, SEO duplication, database migration or production write exists.

`the_content()` is intentionally rendered through trusted WordPress/plugin filters,
not escaped wholesale. Theme-owned text/attributes/URLs are escaped by context.
Customizer values use sanitization callbacks. Private/draft/password-protected records
are excluded from curated previews. Core and plugins remain responsible for access control.

Menu import is read-only: a valid Twenty Twenty `primary` mapping is used only when
this theme has none, and can be disabled. No menu option is changed automatically.
Core may save ordinary theme-switch settings; the theme defines no activation mutator.

## Progressive enhancement

Menus start expanded without JavaScript. Once controls exist, responsive styles collapse
them; the drawer uses `inert`, a bounded tab sequence and Escape to restore focus. Nested
links remain links beside separate disclosure buttons. Native `<dialog>` provides modal
semantics and keyboard dismissal for optional image enlargement. Original image anchors
are never intercepted. Disabling JavaScript leaves content, galleries, resources, search
and navigation usable. Core block lightboxes and explicitly marked plugins are excluded.

## Extension boundaries

Use the native Customizer, menus, Site Identity, featured images and editor first. If
future curation requires taxonomy filters, validate actual metadata and make that a
separate opt-in feature. Official brand verification, production-specific plugin adapters
and a real content inventory require staging access, not guessed replacement templates.

## v1.1 additions

See [the post-install audit](post-install-audit-v1.md) and [update guide](update-v1.1.md). `inc/media.php` reads existing library previews without changing content or metadata. The editorial hero, compatible-media fallback, original CSS concept graphic, menu-based relationships and empty-page navigation aid are presentation-only additions. Native Customizer controls preserve v1 keys and add optional composition/content-preview controls.
