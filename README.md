# MCKK ADS Showcase · 1.0.0

An independent hybrid classic WordPress theme for a digital learning showcase. Existing
WordPress content stays in the database and remains editable. There is no content import,
page recreation, React application, required paid plugin, external font, or production build.

**Release:** `dist/mckk-ads-showcase-v1.0.0.zip` (checksum alongside it).
**Source:** `mckk-ads-showcase/`. **Minimum:** WordPress 6.6, PHP 8.0. Recommended: a
currently supported WordPress/PHP release, verified with your plugins on staging first.
Actual test versions and limits are recorded in [QA](docs/qa-report.md).

## Install and edit

On an authorized staging site, upload the ZIP through Appearance > Themes > Add New >
Upload Theme, install, then activate. Assign the existing menu to Primary navigation,
choose the existing logo under Site Identity, and retain Settings > Reading and Permalinks.
Use Appearance > Customize > Showcase presentation for the optional hero image, curated
existing page IDs, lightbox, decorative accent and footer text. Pages and posts remain
editable with their existing editor. See [installation](docs/installation-guide.md) and
[deployment and rollback](docs/deployment-and-rollback.md) before production use.

## Structure

- `mckk-ads-showcase/`: PHP template hierarchy, `theme.json`, compiled CSS/JS, translation
  template and screenshot. See its [README](mckk-ads-showcase/README.md).
- `docs/`: audit, URL inventory, preservation plan, architecture, design system,
  installation, rollback, local development and QA evidence. `docs/previews/` shows
  synthetic local fixtures, **not a rendering of the production database**.
- `tests/`: guarded local-only fixture, browser checks and read-only integration checks.
- `scripts/package-theme.py`: reproducible allowlisted release ZIP and SHA-256.
- `package.json` / lockfile: development-only Playwright and axe tooling. These do not
  ship in the theme ZIP. No Node.js is required by the deployed theme.

## Development

Run `npm ci`, `npm run check:js`, `npm test` against the documented local fixture, and
`npm run package` to refresh the release. PHP lint and full WordPress Coding Standards
commands are in [local development](docs/local-development.md). The test runner writes
JSON evidence to ignored `test-results/`; reviewed results live in the QA report.

## Compatibility and scope

Public website discovery was blocked by the environment's egress policy. All known
paths in the inventory are labelled as brief-supplied, unverified references. The theme
does not invent missing pages, media, projects or school claims; missing optional pages
produce no cards. The original homepage content is rendered completely once. Its
editorial layout is not automatically rearranged. This intentionally favors preservation.

Plugin-dependent shortcodes, private resources, the real menu/page hierarchy, hosting
versions and production performance require an authorized staging comparison. The local
SQLite integration is a test dependency only and is not installed or required on production.
Existing SEO plugins retain their metadata; the theme adds no competing canonical tags.

Future work can add administrator-selected block patterns or a larger curated index using
existing records. Do not create automatic migrations, change classifications, or promise
taxonomy filters without actual metadata. No deployment or remote push is performed here.

Code is GPL-2.0-or-later. The ZIP contains no school photographs or unofficial crest.
