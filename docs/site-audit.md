# Public site audit

Audit date: 28 October 2026 (Asia/Kuala_Lumpur). Target: https://distinguished.mckk.edu.my/.

## Evidence and access limits

Before implementation, read-only HTTPS requests were attempted for `/`, `/robots.txt`,
`/wp-sitemap.xml`, `/wp-json/`, `/wp-json/wp/v2/pages?per_page=100&_embed=1`, and
`/wp-json/wp/v2/posts?per_page=100&_embed=1`. Each failed at the environment egress proxy:
`CONNECT tunnel failed, response 403`. This is a network-policy observation, not an
origin HTTP response or evidence that the site or its content is absent. No production
administrator, database, credentials, write requests, or deployment was used.

The repository was an empty checkout on an unborn `work` branch. There is no authorized
database export, uploads directory, plugin list, or production configuration here.
The public-domain requirement has been saved in the environment draft; saving does
not apply the network policy to this running machine.

## Known facts versus unverified assumptions

The project brief identifies WordPress with Twenty Twenty, English content, Learning /
Teaching / Environment navigation, and the Inspire / Imagine / Impact homepage pillars.
These are supplied requirements, **not independently crawled findings**. The complete
menu hierarchy, homepage settings, page IDs, titles, publication dates, attachments,
image dimensions, galleries, SEO plugins, shortcodes, and Twenty Twenty dependencies
cannot be verified under the present access restriction. The inventory explicitly
labels the supplied references; inaccessible content must never be deleted or replaced.

## Implementation response

- Use an independent classic hybrid theme and native `the_content()` exactly once for
  each singular page, including the complete static homepage. Do not parse, reorder,
  summarize, or replace its editorial HTML automatically.
- Keep native block, Classic Editor, shortcode, embed, attachment, pagination, and plugin
  output paths. Retain common legacy alignment, caption, gallery, and button classes.
- Resolve optional navigation cards from published, non-password-protected pages in
  the actual local database. Missing references produce no invented destination or card.
- Render assigned WordPress menus; support Twenty Twenty's existing `primary` menu
  location and offer an explicit native Customizer option to reuse its location mapping.
- Do not fetch remote content while serving a frontend request. No runtime REST dependency.
- Avoid cropping student work. Media enlargement is opt-in on existing image-file links;
  external resources retain their original destinations.
- Show real post dates and label the section “From the journal”, without claiming old
  items are current news. Show no fabricated projects, media, achievements, or claims.

## Required staging reconciliation

With an authorized staging clone, export the complete page/post URL inventory, inspect
Settings > Reading and Permalinks, Appearance > Menus, active plugins and SEO behavior,
then compare rendered output and links before/after switching themes. Discover Environment
children (including the brief's Creative Week 2 reference) through the actual database
and navigation rather than guessing their slugs. Check gallery/lightbox plugin conflicts,
shortcodes, protected content, original media proportions and Twenty Twenty custom CSS.
No compatibility conclusion about these unavailable production details is implied.
