# Installation guide · version 1.1.0

## Before installing

Use an authorized staging clone first. Back up the database, uploads, plugins, current
theme, Customizer settings, menu assignments and custom CSS. Record WordPress/PHP versions
and Settings > Reading / Permalinks. Requires WordPress 6.6+ and PHP 8.0+; choose maintained
versions supported by your hosting and plugins. No parent theme or required paid plugin.
The theme does not contain content, database data, credentials or an uploads archive.

## WordPress dashboard

1. Download `dist/mckk-ads-showcase-v1.1.0.zip`. Optionally verify its adjacent SHA-256.
2. On staging, open **Appearance > Themes > Add New > Upload Theme**.
3. Select the ZIP, click **Install Now**, then **Activate** on staging.
4. Open **Appearance > Menus > Manage Locations** and assign the existing menu to
   **Primary navigation**; optionally assign an existing **Footer navigation** menu.
   If unassigned, the theme can read the previous Twenty Twenty primary mapping; otherwise
   it falls back to actual published pages. No menu records are recreated.
5. In **Appearance > Customize > Site Identity**, select the official existing logo,
   site title and tagline. Keep the original logo proportions and artwork.
6. In **Showcase presentation**, optionally select an approved existing hero image.
   A static homepage featured image is the default fallback. Leave both unset for a
   typographic hero. Add existing page or post IDs to curate student-work destination cards.
7. Keep the existing homepage/posts-page selection in **Settings > Reading** and every
   existing slug/permalink. Do not create replacement pages or change permalink settings.
8. Review the complete homepage content, representative resource/media pages, search,
   archives, mobile menus, 404 and plugins against the QA checklist. Purge staging caches.

There is no demo-import or activation wizard. Normal page, post, media and menu editing
continues through WordPress. No PHP editing is required for routine updates.

## cPanel / File Manager alternative

Upload the ZIP to `wp-content/themes/` on staging and extract it there. The result must
be `wp-content/themes/mckk-ads-showcase/style.css`, not an extra nested folder. Preserve
existing themes and media. Use ordinary hosting permissions (typically directories 755,
files 644) consistent with your host; never use 777. Then activate through WordPress.
Do not upload the entire development repository or overwrite `wp-config.php`.

## Common issues

- Missing image/card: confirm the page is published, unprotected and has the intended
  featured image. Curated IDs must refer to pages. Slug references do not create content.
- Unexpected menu: explicitly assign the existing menu; disable prior-theme menu reuse
  in Showcase presentation if necessary.
- Gallery conflict: disable the optional theme lightbox if the site already has one.
  Keep the responsible plugins enabled; shortcode output belongs to its plugin.
- Different historical layout: the original editor content is complete but may need
  reviewed presentation adjustments in the editor. Do not delete it to match a preview.
- Old CSS: purge page/CDN caches and compare custom CSS inherited from Twenty Twenty.
- No safe hero photography: use the typographic fallback; do not invent an official asset.

Production rollout is a separate manual action after staging acceptance. This project
does not access or automatically install/activate anything on production.
