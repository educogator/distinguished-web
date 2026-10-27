# Content preservation plan

This is a presentation layer. No activation hook writes content, options, menus, slugs,
metadata, roles, users, taxonomies, attachments, rewrite rules, or database schemas.
The theme never imports a demo, creates pages, or copies production content into PHP.

## Rendering contract

Each singular item uses the WordPress Loop and `the_content()` once. The static front
page displays its entire editor content in a clearly labelled section. Its original
ordering, blocks, shortcodes and links are retained. The editorial hero and pillar labels
are theme interface; they do not claim to reproduce or summarize unavailable source copy.
No excerpts of the homepage are extracted. Existing Inspire / Imagine / Impact prose
therefore remains in its original editor content, once. This safe automatic treatment
can show similar labels in the hero and editor content; it does not duplicate the content.

Discovery grids query only real published public pages; navigation labels and permalinks
come from those records. Default slug references come from the supplied brief. A native
Customizer setting can choose existing page IDs for curated student-work cards. These
are links to existing content, never independent fabricated projects. Featured images
come from the media library and render without cropping. No remote APIs run on page load.

Assigned menus take precedence. Fallback navigation uses real published pages and their
hierarchy. Search, archives, posts, attachments and pagination use native WordPress queries.
Password-protected content uses the native form and is excluded from curated previews.
No custom canonical, SEO metadata, external-link rewriting or search-query mutations.

## Compatibility boundary

Plugins remain responsible for their shortcodes, forms, galleries, SEO and privacy rules.
Content is not sanitized destructively or run through string replacements. Output from
`the_content()` remains under core/plugin filters; all theme-owned attributes and interface
text are escaped. Styling supports common Twenty Twenty and classic content classes, but
cannot reconstruct unavailable plugin CSS or parent-theme-specific template files.

Original image links, captions and attachment destinations remain intact. The lightbox
only enhances ordinary same-origin image-file links with one image, respects download,
target, block lightbox settings and plugin exclusions, and can be disabled in Customizer.
No blanket cropping, autoplay or embedding of guessed external URLs. Existing external
embeds remain available through native content with an optional adjacent fallback link
when an original safe HTTP(S) iframe source can be read; their URLs are never replaced.

## Before and after activation on staging

1. Back up database, uploads, configuration, current theme, custom CSS and menu assignments.
2. Export IDs, post types, statuses, slugs, parents and permalinks. Record Reading/Permalinks
   settings, plugin versions and shortcode dependencies. Preserve restricted records privately.
3. Save a list of rendered public links/media URLs and representative page HTML.
4. Install and activate only on an authorized staging copy. Assign existing menus and logo;
   inspect the complete static homepage content and all known supplied reference pages.
5. Compare record IDs, slugs, counts, content hashes and permalinks; no content edits are expected.
   Follow YouTube, Google Drive, submission links, PDFs, audio, image/attachment and download links.
6. Inspect every plugin-dependent page and actual Environment child, then review mobile,
   keyboard, search, archives, post pagination, comments and privacy boundaries.
7. Roll back the theme if needed; never restore/overwrite the production database merely
   to change the active theme. See deployment-and-rollback.md.
