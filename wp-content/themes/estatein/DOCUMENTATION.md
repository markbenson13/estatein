# Estatein WordPress Theme — Development Documentation

## Overview

Estatein is a custom-built, dark-themed WordPress theme for a real estate
business. It was built from a static design reference (screenshots of a
homepage, property listings, testimonials, FAQs, and contact pages) and
converted into a fully dynamic, content-manageable WordPress theme rather
than a page builder template.

## Development Process

1. **Structural scaffolding first.** Standard template hierarchy files were
   created (`front-page.php`, `archive-property.php`, `single-property.php`,
   `page-contact.php`, `header.php`, `footer.php`, etc.) with plain,
   semantic markup before any visual styling — so every section had a real
   PHP/WordPress data source (a query, a post, a meta field) from day one
   instead of hard-coded placeholder HTML.
2. **Content modeling before layout.** Custom post types and their meta
   fields were defined next (see *Choices* below), so the homepage and
   archive templates could be built against real `WP_Query` loops rather
   than being retrofitted later.
3. **Section-by-section visual fidelity pass.** Each homepage/archive
   section was styled to match the reference screenshots one at a time
   (hero, stats, featured properties, testimonials, FAQ, CTA, footer),
   checked at mobile / tablet / desktop widths, and refined iteratively
   against follow-up screenshots and feedback.
4. **Verification loop.** Every meaningful CSS or template change was
   checked with `php -l` (for PHP files) and headless-Chrome screenshots at
   representative breakpoints (~390px mobile, ~800px tablet, 992/1200/1440px
   desktop) before being considered done — catching, for example, a stale
   minified CSS file being served in place of active edits, and slider
   card-count/breakpoint mismatches between CSS and Bootstrap's own utility
   breakpoints.
5. **Hardening pass.** Once the visual build was stable, a pass was made
   for SEO (meta tags, canonical URLs), performance (self-hosted assets,
   resource hints, lazy-loading), and form security (nonces, honeypot).

## Key Choices

### Custom post types instead of a page builder / ACF

Properties, Testimonials, and FAQs are each registered as a **custom post
type** (`inc/cpt-property.php`, `inc/cpt-testimonial.php`,
`inc/cpt-faq.php`), with supporting taxonomies for properties
(`property_type`, `property_status`, `property_location`). Structured
per-post data (price, bedrooms, bathrooms, area, gallery, etc.) is stored
via native custom meta boxes (`inc/meta-boxes.php`) rather than a plugin
such as Advanced Custom Fields.

**Why:** this keeps the theme fully self-contained — no required plugin
dependency, nothing that can be deactivated and silently break the site,
and full control over sanitization/escaping of every field. It also means
content (listings, testimonials, FAQs) is ordinary WordPress content:
searchable, exportable, and editable through the standard post editor
that any WordPress user already knows.

### Site-wide options via the Customizer

Global, editable settings (contact phone/email, social links, hero copy,
etc.) are exposed through `inc/customizer.php` using the native WordPress
Customizer API, so non-technical site owners can update them from
**Appearance → Customize** without touching code.

### Bootstrap 5 for layout, hand-written CSS for the design system

The grid, responsive utility classes (`d-flex`, `d-none`/`d-lg-*`,
container breakpoints) and JS components (navbar, modal, carousel-style
controls) come from Bootstrap 5.3, self-hosted from
`assets/vendor/bootstrap/` rather than pulled from a CDN. All theme-specific
visual design (colors, cards, the custom slider/pagination component,
typography) is in a single hand-written `style.css`, minified to
`style.min.css` for production.

**Why self-hosted Bootstrap:** avoids an extra external DNS/TLS handshake
on the critical rendering path and removes a dependency on a third-party
CDN's uptime.

**Why not a CSS framework's component classes for everything:** the design
has enough custom, non-Bootstrap components (the stat boxes, the property
cards, the slider/pagination bar) that hand-written CSS gave more direct
control and a smaller footprint than fighting or overriding a heavier
component library.

### Custom lightweight slider, not a JS carousel library

The Featured Properties / Testimonials / FAQ sections use a small
hand-rolled slider (`assets/js/main.js` + `.es-slider-*` classes in
`style.css`) driven by simple prev/next buttons and a counter, showing 1
card on mobile, 2 on tablet, and 3 on desktop.

**Why:** the design's slider needs (fixed card counts per breakpoint, a
counter readout, no autoplay/swipe-gesture requirement) didn't need a full
carousel dependency (e.g. Swiper); a ~100-line vanilla script kept the
JS payload small and fully under the theme's control.

### SEO and performance handled in the theme, not via an SEO/caching plugin

`inc/seo.php` outputs meta description, Open Graph/Twitter card tags, and
a canonical URL per page type (careful here to avoid duplicating WordPress
core's own canonical tag on singular views, and to avoid it defaulting to
the wrong post's canonical URL on archive/search views).

`inc/performance.php` and `functions.php` handle resource hints
(`preconnect` for Google Fonts), `loading="lazy"`/`fetchpriority="high"`
image attributes, and conditional script loading (e.g. the single-property
gallery script only loads on `single-property.php`).

**Why in-theme:** for a project of this size, a general-purpose SEO plugin
brings a large settings surface and its own database tables for a handful
of tags the theme can output directly and predictably.

### Native contact/inquiry forms, no forms plugin

The contact page and the per-property "Send Inquiry" form
(`inc/forms.php`) are handled with a plain `admin-post.php` handler,
a nonce, and a honeypot field for basic spam mitigation — instead of a
forms plugin.

**Why:** the forms are simple (a handful of fixed fields, one destination
action) and this avoids adding another plugin's JS/CSS and admin UI for
functionality that's about 60 lines of PHP.

## Tools Used

- **WordPress core** template hierarchy and APIs (Customizer, `WP_Query`,
  Settings/Rewrite APIs, nonces) — no visual page builder.
- **Bootstrap 5.3** (CSS grid/utilities + bundled JS), self-hosted.
- **Google Fonts** (Urbanist), loaded with a `preconnect` resource hint.
- **XAMPP** as the local PHP/MySQL/Apache development environment.
- **Headless Chrome** screenshots for cross-breakpoint visual verification
  during development (not part of the shipped theme).
- No page builder, no ACF, no SEO plugin, no forms plugin, no caching
  plugin — the theme is designed to run standalone with zero required
  plugin dependencies.

## Plugins Required

None. The theme is fully self-contained; all custom content types, meta
fields, SEO output, and forms are implemented in the theme itself.
