> Historical v1.0 validation. See [v1.1 validation](qa-v1.1.md) for the post-install fixes and latest release.

# Validation report · MCKK ADS Showcase 1.0.0

Tested 28 October 2026 (Asia/Kuala_Lumpur). This report describes real execution on an
isolated, synthetic local WordPress site. It does not certify the inaccessible production
database, hosting, content accessibility, external resources or plugin configuration.

## Environment

WordPress **6.8.3**, PHP **8.4.24**, official SQLite database integration (local only),
Chromium **154.0.8037.57**, Playwright **1.64.1**, axe-core Playwright **4.14.0**,
PHPCS **3.13.5**, WordPress Coding Standards **3.2.0**, Lighthouse **13.0.1**.
Theme minimum targets are WordPress 6.6 / PHP 8.0; those minimum versions were not
separately executed. Real hosting and MySQL/MariaDB integration remain unverified.

## Executed checks

| Check | Result | Evidence / scope |
| --- | --- | --- |
| PHP syntax | Passed, all 26 theme PHP files | `php -l` on every production PHP file |
| JavaScript syntax | Passed | `node --check assets/js/main.js` |
| Theme configuration | Passed | Parsed `theme.json` as JSON; real WordPress rendered its styles |
| Full WordPress Coding Standards | Passed, zero errors/warnings | Full `WordPress` ruleset, all theme PHP; no excluded sniffs |
| Browser suite | 38/38 passed | `tests/browser.mjs`; JSON evidence under test-results and reviewed previews |
| Local mode/option checks | 4/4 passed | `tests/modes.mjs`; restores original local settings |
| Integration/content preservation | 11/11 passed | `tests/integration.php`; whole fixture post/meta hashes and native behavior |
| Local public URL responses | 25/25 HTTP 200 | `docs/qa-url-comparison.md`; local synthetic records only |
| ZIP packaging and integrity | Passed | Single theme root, required files, CRC check and SHA-256; deterministic packager |
| ZIP installation and activation | Passed | Real WordPress native upgrader through WP-CLI; no missing-parent/fatal error |
| Frontend from installed theme | Passed | Browser validation against the actual local theme directory |
| Screenshots | Generated | Homepage and resource/gallery page at 390, 768, 1440px, plus theme screenshot |

The browser suite checks horizontal overflow and automated axe WCAG 2.2 AA/best-practice
rules on the homepage and a representative media page at **360, 390, 768, 1024 and
1440px** (10 page/viewport scans). It also exercises mobile focus containment, Escape and
focus restoration, nested disclosures, desktop keyboard navigation, an open-drawer axe
scan, shortcode output, classic galleries, original Drive/YouTube/download links, iframe
fallback links, optional dialog behavior, protected content, search success/empty results,
404 HTTP status, Gutenberg columns, archive/single/comments, native pagination, 200%
text resizing, reduced motion, JavaScript disabled and enhancement-script failure recovery.
No JavaScript runtime errors were observed. Automated checks do not establish complete
WCAG conformance or replace screen-reader testing.

Mode checks verify posts-on-front behavior, its pagination, disabling the lightbox while
retaining image links, and the actual-page fallback menu. Integration checks verify that
activation/switching preserves fixture content, IDs, metadata, URLs and Reading settings;
missing pages do not produce fabricated destinations; unpublished/protected pages are
excluded from curation; Twenty Twenty menu reuse is read-only and optional; standalone
theme recognition works; shortcode source remains intact; temporary records are removed.

## Controlled performance observation

One local desktop Lighthouse run after the first-paint correction scored **100 Performance,
100 Accessibility, 100 Best Practices**. LCP was **0.5s**, CLS **0**, and total blocking
time **0ms**. See `lighthouse-local.json` for the compact measured values. This is a local
synthetic-content baseline, not a production guarantee. INP requires real interaction/field
measurement; zero blocking time must not be reported as a measured INP result.

An earlier run reported CLS 0.227 and Performance 89: submenu collapse after first paint
shifted the main content. CSS-only desktop disclosures and an early mobile pending class
with fail-open recovery corrected it. Browser regression checks and the subsequent
Lighthouse run passed. An initial local WordPress URL-prefix error left assets unloaded;
correcting the isolated fixture URL resolved it. Neither issue involved production content.

## Installation and runtime observations

The ZIP was installed and activated using WordPress's native theme upgrader through
WP-CLI, and frontend requests were served by the installed theme. Dashboard upload itself
was not automated; the exact dashboard procedure is in installation-guide.md.
No theme PHP warning, notice or fatal error was observed in the exercised frontend paths.
WordPress admin/CLI update checks emitted core connectivity warnings because the environment
could not reach WordPress.org; these are infrastructure restrictions, not evidence of
a theme exception. Verification was never disabled to bypass those restrictions.

The theme screenshot and six previews are from actual local rendering with labelled
synthetic media. No school claims, projects, original photography or database content
were manufactured or bundled into the theme.

## Unresolved access and manual release checks

- Public crawl: egress proxy returned CONNECT 403 for homepage, robots, sitemap and REST
  requests. The full page hierarchy, real IDs, media, Environment children (including the
  Creative Week 2 reference), Twenty Twenty dependencies and plugin versions are unverified.
- Production preservation: local hashes passed, but the actual school's database and
  external links/downloads were unavailable. No claim that every production URL works.
- Real galleries, Google Drive, YouTube, submission workflows, ePub/AR resources, audio,
  plugin shortcodes, SEO and protected resources need an authorized staging smoke test.
- Human screen-reader review, Safari/iOS/iPadOS, Firefox, Edge, real 200% browser zoom,
  orientation changes and touch devices remain manual. Automated 200% text-size testing
  is included but is not a substitute for every browser zoom/reflow scenario.
- Core Web Vitals on real hosting and fresh-task cloud snapshot restoration were not tested.
- Official logo, photography and brand specifications must be selected/verified by the school.
  The theme uses a typographic fallback and provisional configurable design tokens.

## Exact staging acceptance procedure

1. Back up and record current theme, menus, plugins, custom CSS, Reading and Permalinks.
   Run `wp eval-file tests/export-public-inventory.php` before and after theme activation
   on the authorized staging copy; compare IDs, slugs, parents, URLs and content hashes.
   This helper exports only public unprotected pages/posts; reconcile restricted items
   privately using the school's normal process.
2. Upload/install the release ZIP via Appearance > Themes; activate on staging only.
   Assign original menus/logo and retain all homepage/permalink settings. Open the homepage
   and verify every original editorial section appears once in its original order.
3. Visit every supplied inventory URL and every discovered additional page/Environment child.
   Compare titles, headings, text, resource hrefs, media srcs, captions, downloads and plugin
   output with the baseline. Never treat inaccessible production content as deletable.
4. At each required viewport, use Tab/Shift+Tab/Enter/Space/Escape through nested navigation,
   search and the lightbox. Confirm focus is visible and returns to its trigger. Test
   without JavaScript and with reduced motion. Repeat with VoiceOver/Safari and another
   screen reader/browser; inspect 200% zoom and iPad portrait/landscape on real devices.
5. Follow existing Drive/YouTube/submission/download links; play existing audio/video
   manually; verify gallery proportions, page/post pagination, attachments, comments,
   search, 404, protected content and SEO plugin canonical/meta output.
6. Measure performance with real photography/embeds and hosting; purge caches and repeat
   the smoke list. Complete institutional review before manual production activation.
   Roll back by reactivating the previous theme if needed; do not overwrite content data.
