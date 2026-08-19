# Estatein

A custom dark-themed WordPress theme for a real estate business, built on
Bootstrap 5. Fully self-contained — no required plugins.

## Requirements

- WordPress 6.x
- PHP 7.4+
- A permalink structure other than "Plain" (custom post types use pretty
  permalinks)

## Installation

1. Copy the `estatein` folder into `wp-content/themes/`.
2. In **Appearance → Themes**, activate **Estatein**.
3. Go to **Settings → Permalinks** and click **Save Changes** once to
   flush rewrite rules for the custom post types.
4. In **Appearance → Customize**, set the site's contact info, social
   links, and hero content.
5. Under **Properties**, **Testimonials**, and **FAQs** in the admin
   menu, add content — the homepage and archive pages populate from
   these automatically.
6. Assign a **Primary Menu** and **Footer Menu** under
   **Appearance → Menus**.

## Custom Post Types

| Post Type | Purpose | Taxonomies |
|---|---|---|
| `property` | Listings | `property_type`, `property_status`, `property_location` |
| `testimonial` | Client reviews | — |
| `faq` | Frequently asked questions | — |

Property meta fields (price, bedrooms, bathrooms, area, garage, year
built, address, gallery, featured flag) are edited from the standard
post editor via a custom meta box — no ACF or other field plugin
required.

## Features

- Homepage sections: hero with stats, features, featured properties
  slider, testimonials slider, FAQ slider, CTA
- Property archive with keyword/type/status/location/price/bedroom
  filtering
- Single property template with image gallery and an inquiry form
- Contact page with a validated, nonce-protected, honeypot-guarded form
- SEO meta tags, Open Graph/Twitter cards, and per-page canonical URLs
- Self-hosted Bootstrap 5.3 and Google Fonts, lazy-loaded images,
  resource hints for performance

## Development Notes

`style.css` is the editable source stylesheet; `style.min.css` is the
minified build actually served in production. After editing
`style.css`, regenerate `style.min.css` before deploying.

For local development without re-minifying on every change, define in
`wp-config.php`:

```php
define( 'SCRIPT_DEBUG', true );
```

This serves the readable `style.css` directly. Remove it (or set it to
`false`) before deploying so the site serves the minified file.

See [DOCUMENTATION.md](DOCUMENTATION.md) for the full write-up of the
development process, architectural choices, and tools used.
