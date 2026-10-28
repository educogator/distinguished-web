# Design system

Direction: restrained institutional portfolio, generous whitespace, strong native
typography and uncropped media. This is an independent design, with no copied Apple
interface, generated crest or bundled school photography.

| Token | Default | Use |
| --- | --- | --- |
| Red | `#A51D2D` | Accessible links, hero emphasis, focus |
| Decorative accent | `#A51D2D` | Rules/dots; native Customizer control |
| Gold | `#D8AA38` | Optional block highlight, not small text on white |
| Charcoal | `#181818` | Text and primary buttons |
| White | `#FFFFFF` | Main canvas |
| Surface | `#F6F6F4` | Cards, media mounts and footer |
| Muted | `#666666` | Secondary text on white/surface |
| Line | `#DEDED8` | Decorative borders, not focus indicators |

Palette values are provisional from the brief, not certified official brand specifications.
`theme.json` exposes shared block colors; frontend tokens are in `main.css`. Customizer's
accent affects decoration only so arbitrary user colors do not lower text contrast.

System stack: `-apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif`. Body 18px,
line height 1.7; mobile content 16.8px. Fluid hero and heading sizes scale to the viewport.
Content measure is 800px; wide content 1240px. Gutters scale from 20px to 64px. Cards
use 16px radii and fine borders. Motion is limited to subtle pointer affordances and
is removed under reduced-motion preferences. No autoplay or reveal-on-scroll dependencies.

## Components and responsive behavior

- Header: original logo in `object-fit: contain`, site identity, real menu, native search.
  Desktop at 960px+, drawer below 960px. All nested levels remain accessible.
- Hero: three supplied pillar words, actual site description, real Learning/Showcase/
  Teaching links. Optional approved library image, otherwise typographic layout.
- Discovery: 3 columns desktop, 2 tablet, 1 phone. Public pages use their stored title,
  optional authored excerpt and existing featured image. No invented summaries.
- Media: uncropped student work/document previews; classic/block galleries, caption
  styling, correct video proportions, optional dialog with original-resource link.
- Singular content: readable measure, wide/full blocks, preserved order and native filters.
- Breadcrumbs: real ancestor hierarchy. Related cards use actual children/siblings or
  the explicit known learning-page lookup. Search and empty states remain native.
- Footer: site identity, optional assigned footer menu, editable text, native privacy link.

## Accessibility contract

Target WCAG 2.2 AA. Skip link, semantic landmarks, disclosure states, keyboard escape,
focus restoration, touch targets, reduced motion and readable text are included.
Red on white is approximately 7.4:1; charcoal on white approximately 17.8:1; muted on
white approximately 5.7:1. Automated axe evidence covers the tested fixtures, not the
unknown production content. Existing unlabelled images, low-contrast authored blocks,
third-party players and legacy heading order need human staging review. See QA report.

## v1.1 additions

See [the post-install audit](post-install-audit-v1.md) and [update guide](update-v1.1.md). `inc/media.php` reads existing library previews without changing content or metadata. The editorial hero, compatible-media fallback, original CSS concept graphic, menu-based relationships and empty-page navigation aid are presentation-only additions. Native Customizer controls preserve v1 keys and add optional composition/content-preview controls.
