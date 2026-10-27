# Deployment and rollback

No production deployment has been performed. Theme switching is not a content migration.

## Staging release gate

1. Take verified backups. Record current theme/version, active plugins, Reading/Permalinks,
   theme-specific CSS, logo, menus, custom templates and widgets. Keep Twenty Twenty installed.
2. Obtain an authorized staging clone with the real database, uploads and plugins. Restrict
   indexing and access appropriately; never expand publication of private student material.
3. Compare the pre-switch ID/slug/content/permalink inventory to the same post-switch data.
   The repository's local synthetic comparisons are not evidence about production records.
4. Check every inventoried destination and every actual Environment child, plus historical
   homepage copy, shortcodes, submissions, media resources, SEO plugin metadata and privacy.
5. Complete responsive, keyboard, human screen-reader and real Safari/iPad tests. Measure
   performance with real media/hosting and review cache/CDN interaction. Resolve regressions.

## Manual production rollout

After institutional acceptance, choose a maintenance window and take a fresh backup.
Install the reviewed release through Appearance > Themes, activate manually, assign
existing menus/logo if required, purge caches and run the agreed read-only smoke list.
Do not change page slugs, content, database schema, users, roles, rewrite settings or
resource URLs. Keep a person available to restore the old theme immediately if needed.

## Rollback

1. In Appearance > Themes, reactivate the previous Twenty Twenty theme (or the exact
   previously active theme/child theme recorded before rollout).
2. Confirm its prior menu, logo, widgets and Customizer settings. Reassign recorded
   locations only if core/theme switching changed them; do not recreate content.
3. Purge page/CDN caches and revisit the same smoke URLs on desktop and mobile.
4. Keep the failed theme ZIP and logs for diagnosis. Remove it only when no longer needed.

Do not restore an old database simply to change a presentation theme: that could overwrite
new editorial work. Restore backups only for a separately verified data-loss incident
under the school's normal recovery procedure. This theme contains no uninstall deletion
or migration routine; all existing content remains in WordPress.
