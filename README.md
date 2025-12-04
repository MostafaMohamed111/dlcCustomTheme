# dlcCustomTheme

`dlcCustomTheme` is a bespoke WordPress theme crafted for a bilingual (Arabic ↔ English) corporate website. It focuses on showcasing service offerings, news, and blog content through category-driven archives, service grids, and a multilingual experience powered by Polylang. The theme embraces AJAX pagination, reusable template parts, and a clear asset structure so editors and developers can extend it confidently.

---

## Highlights

- **Multilingual-ready** – All key pages and helpers integrate with Polylang, providing language-aware URLs and seamless switching.
- **Service-first layout** – Companies, individual, international, and secure-yourself sections share a unified service card/grid system.
- **AJAX archives** – Category pages load next/previous pages without a full refresh, keeping filters, language, and pagination in sync.
- **Modular templates** – `includes/` hosts page-specific templates and reusable card components to keep markup consistent.
- **Curated assets** – CSS, JS, fonts, and imagery live under `assets/`, making it easy to locate and maintain front-end resources.

---

## Directory Guide

| Path | Description |
| --- | --- |
| `style.css` | Theme metadata and base stylesheet loaded by WordPress. |
| `functions.php` | Theme bootstrap: registers menus, enqueues assets, adds Polylang helpers, and exposes AJAX endpoints. |
| `header.php`, `header-ar.php`, `footer.php`, `footer-ar.php` | Global site chrome for both languages. |
| `front-page.php`, `front-pages/` | Static front-page controller and language-specific templates (`front-en.php`, `front-ar.php`). |
| `about-pages/`, `services-pages/`, `booking-pages/`, `contact-pages/`, `privacy-pages/`, `general-pages/` | Page templates grouped by content type; each folder contains Arabic and English versions. |
| `categories/` | PHP routers for top-level taxonomy archives (blog, news, services variants, secure-yourself, etc.). |
| `includes/` | Building blocks used inside category templates: archive layouts, single cards, pagination, and service cards. Each subfolder mirrors a content vertical (blog, companies, individual, international, news, secure, general). |
| `assets/` | Front-end resources.<br>• `assets/en/` and `assets/ar/`: language-specific CSS bundles (blog, services, booking, secure-yourself, etc.).<br>• `assets/js/`: JavaScript modules (`main.js`, `archive.js`, `booking.js`, `contact-us.js`, `scroll-animations.js`).<br>• `assets/images/`: hero art, thumbnails, and UI icons.<br>• `assets/webfonts/`: Cairo font family and Font Awesome subsets. |
| `bootstrap/` | Bundled Bootstrap CSS/JS (if needed for legacy layouts). |
| `categories/blog.php` etc. | Entry points that select the right template from `includes/` based on context. |
| `includes/pagination.php` | Shared pagination component. Outputs data attributes consumed by the AJAX loader. |
| `includes/post-card.php`, `includes/service-card.php`, `includes/news-card.php` | Reusable card partials for posts, services, and news highlights. |
| `includes/secure-pages/` | Secure-yourself archive templates (Arabic/English) that render service grids. |

---

## AJAX Pagination & Filters

- **Front-end (`assets/js/archive.js`)**
  - Intercepts pagination clicks, requests the next page via `load_archive_posts`, and swaps grid + pagination markup in place.
  - Uses `history.pushState` / `popstate` to keep URLs and browser navigation aligned.
  - Detects whether the current context uses `posts-grid` or `services-grid`, ensuring secure-yourself and service archives keep their layout.

- **Back-end (`functions.php`)**
  - `load_archive_posts_ajax` receives category IDs, parent category IDs, and page numbers.
  - Returns rendered HTML for the grid plus the updated pagination wrapper.
  - Recognizes secure-yourself as a service category, so AJAX results reuse the service card template.

---

## Localization Helpers

`functions.php` exposes template-aware URL helpers so links remain accurate even if slugs change:

- `dlc_get_page_url_by_template( $template, $language, $fallback_urls = [] )`
- Wrappers: `dlc_get_services_page_url()`, `dlc_get_booking_page_url()`, `dlc_get_about_us_page_url()`, `dlc_get_contact_us_page_url()`

Templates call these helpers instead of hardcoding `/services` or `/الخدمات`, giving editors freedom to rename pages without breaking the navigation.

---

## Assets Overview

### CSS (`assets/en/`, `assets/ar/`)
- **`main.css` / `main-ar.css`** – Global typography, layout variables, header/footer styles.
- **`blog.css`** – Blog archives, sidebar layout, responsive grid adjustments.
- **`companies-individual-services.css`** – Services and secure-yourself sections, including service cards and pagination alignment.
- **`secure-yourself.css`**, `home-international.css`, `news.css`, etc. – Section-specific styling.
- Page-level sheets (`about-us.css`, `contact-us.css`, `booking.css`, `privacy-policy.css`, `page.css`) keep single-page tweaks isolated.

### JavaScript (`assets/js/`)
- `main.js` – Navigation toggles, carousels, counters, and miscellaneous UI behaviors.
- `archive.js` – Category filtering, AJAX pagination, and history management.
- `booking.js` – Multi-step booking form logic and service lookups.
- `contact-us.js` – Contact form validation and submission UX.
- `scroll-animations.js` – Intersection Observer–based reveal animations.

### Media & Fonts
- `assets/images/` contains hero artwork, service imagery, and UI icons optimized for both languages.
- `assets/webfonts/` ships the Cairo typeface plus Font Awesome subsets used across the theme.

---

## Getting Started

1. **Copy the theme** into `wp-content/themes/dlcCustomTheme`.
2. **Activate** it from **Appearance → Themes** in WordPress.
3. **Set the front page** to use `front-en.php` / `front-ar.php` via WordPress page templates.
4. **Create bilingual pages** for Services, Booking, About, Contact, and Privacy, linking each pair with Polylang.
5. **Assign categories** for companies, individual, international, secure-yourself, blog, news, and general content—use matching slugs for both languages.
6. **Translate menus** and widgets as needed; the theme reads Polylang’s current language to render the proper templates and assets.

That’s it—`dlcCustomTheme` is ready to showcase services, news, and blog content with a polished multilingual experience and smooth AJAX-powered archives.

