# MCKK ADS Showcase

Version 1.0.0 · Text domain `mckk-ads-showcase` · GPL-2.0-or-later.

Independent hybrid classic theme. Requires WordPress 6.6+ and PHP 8.0+. No parent theme,
mandatory plugin, Node.js, external font or build step is needed on the hosting account.

## Installation

Back up and test on staging first. Upload `mckk-ads-showcase-v1.0.0.zip` using Appearance >
Themes > Add New > Upload Theme. Install and activate on staging. Keep the existing
Reading/Permalink settings. Assign existing menus to Primary and optionally Footer.
Choose the original, unmodified school logo in Appearance > Customize > Site Identity.

## Editing

- Edit every existing page/post normally. The Loop and `the_content()` remain authoritative.
- The static homepage's entire editor content appears once under its existing page title.
  The hero adds the brief's Inspire / Imagine / Impact interface, not replacement school copy.
- Existing page titles, permalinks and featured images power discovery cards. Missing
  references are omitted. Dates shown for journal entries are their stored publication dates.
- Appearance > Customize > Showcase presentation lets administrators select a hero image
  from the media library, enter up to 12 existing page IDs for curated links, edit footer
  text, adjust a decorative accent and disable the compatible image lightbox.
- Page IDs can be read from the `post=123` part of the ordinary Edit Page URL. Curated
  entries must be existing published, non-password-protected pages. No content is created.
- An assigned primary menu wins; otherwise the previous Twenty Twenty primary menu can
  be read without altering its saved mapping. Disable this in Customizer if unwanted.
  If neither exists, the real page hierarchy supplies a fallback.

## Files and architecture

`functions.php` loads `inc/` modules for native features, assets, menus, read-only content
helpers and Customizer settings. PHP templates cover the homepage, pages, posts,
attachments through the single/fallback hierarchy, archives, search, 404 and comments.
`template-parts/` supplies shared cards, header/footer, breadcrumbs and related content.
`theme.json` and `assets/css/editor.css` align Block Editor content with frontend styling.
`assets/css/main.css` and `assets/js/main.js` are directly served, readable frontend assets.
The translation template is `languages/mckk-ads-showcase.pot`.

## Media and accessibility

Student work, logos and document previews retain their proportions. Existing image
anchors are preserved; a separate enlargement button is added to compatible same-origin
image links. Downloads, external targets and marked plugin galleries are excluded. Add
`data-no-lightbox` on a wrapper, or disable the feature globally when a plugin owns it.
Native WordPress block lightboxes are left to core. Safe existing iframe URLs can receive
an adjacent fallback link; the embed itself and its original destination are unchanged.

Navigation has nested disclosure buttons, a mobile drawer, Escape/focus handling and
no-JavaScript fallbacks. Styles include visible focus, reduced motion and large targets.
Automated checks do not replace human screen-reader and cross-browser testing.

## Limitations and safe release

The production site was not accessible from the build environment. No complete production
inventory, plugin list, database or hosting version was available. Test the real site on
an authorized staging copy, especially shortcode plugins, gallery CSS, SEO, submissions,
Google Drive, YouTube, downloads, attachments and historical homepage layout. Native
content is kept in order rather than automatically parsed into a new editorial layout.
No source media is bundled. Theme screenshot shows explicitly labelled local fixtures.

The repository's `docs/` folder contains full audit, validation, installation and rollback
instructions. Reactivate the previous theme to roll back the presentation; do not overwrite
the content database merely to switch themes. Production installation is always manual.
