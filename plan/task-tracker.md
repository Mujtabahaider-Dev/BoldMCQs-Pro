# BoldMCQs Pro — Customizer Implementation Task Tracker

**Last Updated:** March 7, 2026

> ✅ = Done &nbsp;|&nbsp; ⬜ = Pending &nbsp;|&nbsp; 🔄 = In Progress

---

## Phase 1 — Foundation (Typography & Colors)

| # | Task | File(s) | Status |
|---|------|---------|--------|
| 1.1 | Create `inc/typography.php` | `inc/typography.php` | ✅ |
| 1.2 | Google Fonts loader (modern `wght@` URL format) | `inc/typography.php` | ✅ |
| 1.3 | Generate dynamic CSS for body, headings, MCQ | `inc/typography.php` | ✅ |
| 1.4 | Add `.mcq-card h3` to MCQ question CSS rule | `inc/typography.php` | ✅ |
| 1.5 | Responsive font sizes (mobile breakpoints) | `inc/typography.php` | ✅ |
| 1.6 | Include typography file in `functions.php` | `functions.php` | ✅ |
| 1.7 | Typography customizer settings (fonts, sizes, weight, line-height, letter-spacing) | `inc/customizer.php` | ✅ |
| 1.8 | Color system — Primary & Secondary CSS vars | `header.php` | ✅ |
| 1.9 | Color system — MCQ option, letter, correct-answer colors | `header.php` | ✅ |
| 1.10 | Add Accent, Success, Error, Link, Card-BG color options | `inc/customizer.php` | ⬜ |
| 1.11 | Apply new extended colors via CSS variables | `header.php` | ⬜ |

---

## Phase 2 — Header System

| # | Task | File(s) | Status |
|---|------|---------|--------|
| 2.1 | Create `inc/header-buttons.php` with helper functions | `inc/header-buttons.php` | ✅ |
| 2.2 | `boldmcqspro_render_header_button()` (solid/outline/ghost styles) | `inc/header-buttons.php` | ✅ |
| 2.3 | `boldmcqspro_render_auth_buttons()` using customizer text | `inc/header-buttons.php` | ✅ |
| 2.4 | Wire auth buttons into `header.php` desktop nav | `header.php` | ✅ |
| 2.5 | Wire CTA buttons 1 & 2 into `header.php` desktop nav | `header.php` | ✅ |
| 2.6 | Mobile menu: render auth + CTA buttons as block-level | `header.php` | ✅ |
| 2.7 | Add **Header Layout & Styling** customizer section | `inc/customizer.php` | ✅ |
| 2.8 | Sticky header toggle (customizer → header class) | `inc/customizer.php` + `header.php` | ✅ |
| 2.9 | Header height control (customizer → inline style) | `inc/customizer.php` + `header.php` | ✅ |
| 2.10 | Header background color (live postMessage preview) | `inc/customizer.php` + `header.php` | ✅ |
| 2.11 | Header shadow level selector | `inc/customizer.php` + `header.php` | ✅ |
| 2.12 | Logo branding — mode (logo/text/both) | `template-parts/header/site-branding.php` | ✅ |
| 2.13 | Logo size (width/height) controls | `template-parts/header/site-branding.php` | ✅ |
| 2.14 | Site title size & text-transform | `template-parts/header/site-branding.php` | ✅ |

---

## Phase 3 — Content Layout

| # | Task | File(s) | Status |
|---|------|---------|--------|
| 3.1 | Add **Homepage Layout** customizer section | `inc/customizer.php` | ⬜ |
| 3.2 | Container width control (max-w-5xl … max-w-7xl / full) | `inc/customizer.php` + `index.php` | ⬜ |
| 3.3 | Sidebar position — left / right / none | `inc/customizer.php` + `index.php` | ⬜ |
| 3.4 | Sidebar width ratio (narrow vs balanced) | `inc/customizer.php` + `index.php` | ⬜ |
| 3.5 | MCQ grid columns for full-width layout (1/2/3) | `inc/customizer.php` + `index.php` | ⬜ |
| 3.6 | Vertical spacing between cards | `inc/customizer.php` + `index.php` | ⬜ |
| 3.7 | Section padding top/bottom | `inc/customizer.php` + `index.php` | ⬜ |
| 3.8 | Show/hide breadcrumbs toggle | `inc/customizer.php` + templates | ⬜ |
| 3.9 | Breadcrumb separator choice | `inc/customizer.php` + templates | ⬜ |
| 3.10 | Apply layout options to `index.php` | `index.php` | ⬜ |

---

## Phase 4 — MCQ Features

| # | Task | File(s) | Status |
|---|------|---------|--------|
| 4.1 | MCQ card style variations (default/minimal/bordered/gradient) | `inc/customizer.php` + `index.php` | ✅ |
| 4.2 | Show/hide MCQ question numbers | `inc/customizer.php` + `index.php` | ✅ |
| 4.3 | Enable/disable MCQ title links | `inc/customizer.php` + `index.php` | ✅ |
| 4.4 | Show/hide explanation button | `inc/customizer.php` + `index.php` | ✅ |
| 4.5 | Show explanations by default toggle | `inc/customizer.php` + `index.php` | ✅ |
| 4.6 | Show/hide author, date, category, difficulty | `inc/customizer.php` + `index.php` | ✅ |
| 4.7 | Default difficulty level selector | `inc/customizer.php` + `index.php` | ✅ |
| 4.8 | MCQ option hover effects (none/highlight/scale/shadow) | `inc/customizer.php` | ⬜ |
| 4.9 | MCQ option spacing control | `inc/customizer.php` | ⬜ |
| 4.10 | Quiz mode button show/hide | `inc/customizer.php` + `index.php` | ✅ |
| 4.11 | MCQ-specific colors (background, border, hover, explanation) | `inc/customizer.php` + `header.php` | ✅ |
| 4.12 | MCQs per page (homepage) | `inc/customizer.php` + `functions.php` | ✅ |
| 4.13 | Ordering & category filter | `inc/customizer.php` + `functions.php` | ✅ |

---

## Phase 5 — Single Page (MCQ Detail)

| # | Task | File(s) | Status |
|---|------|---------|--------|
| 5.1 | Show/hide social sharing section | `inc/customizer.php` + `single.php` | ⬜ |
| 5.2 | Choose which sharing platforms appear (FB/Twitter/LinkedIn/WhatsApp/Copy) | `inc/customizer.php` + `single.php` | ⬜ |
| 5.3 | Sharing button style (icon+text / icon-only / text-only) | `inc/customizer.php` + `single.php` | ⬜ |
| 5.4 | Show/hide prev/next navigation | `inc/customizer.php` + `single.php` | ⬜ |
| 5.5 | Show/hide "Back to All Questions" button | `inc/customizer.php` + `single.php` | ⬜ |
| 5.6 | Show/hide Related MCQs sidebar widget | `inc/customizer.php` + `single.php` | ⬜ |
| 5.7 | Number of related MCQs to show | `inc/customizer.php` + `single.php` | ⬜ |
| 5.8 | Sidebar layout for single pages (same as homepage / override) | `inc/customizer.php` + `single.php` | ⬜ |

---

## Phase 6 — Footer System

| # | Task | File(s) | Status |
|---|------|---------|--------|
| 6.1 | Footer copyright text (already wired) | `inc/customizer.php` + `footer.php` | ✅ |
| 6.2 | Footer background color | `inc/customizer.php` + `footer.php` | ⬜ |
| 6.3 | Footer text color | `inc/customizer.php` + `footer.php` | ⬜ |
| 6.4 | Footer padding control | `inc/customizer.php` + `footer.php` | ⬜ |
| 6.5 | Show/hide footer navigation menu | `inc/customizer.php` + `footer.php` | ⬜ |
| 6.6 | Show/hide footer social menu | `inc/customizer.php` + `footer.php` | ⬜ |
| 6.7 | Footer widget columns (1–4) | `inc/customizer.php` + `template-parts/footer/widgets.php` | ⬜ |

---

## Phase 7 — Live Preview & Polish

| # | Task | File(s) | Status |
|---|------|---------|--------|
| 7.1 | Live preview — Primary & Secondary colors | `assets/js/customizer.js` | ✅ |
| 7.2 | Live preview — MCQ option/letter/correct colors | `assets/js/customizer.js` | ✅ |
| 7.3 | Live preview — MCQ card background, border, hover | `assets/js/customizer.js` | ✅ |
| 7.4 | Live preview — Base font size | `assets/js/customizer.js` | ✅ |
| 7.5 | Live preview — MCQ question & options font size | `assets/js/customizer.js` | ✅ |
| 7.6 | Live preview — Line height & letter spacing | `assets/js/customizer.js` | ✅ |
| 7.7 | Live preview — Header background color | `assets/js/customizer.js` | ✅ |
| 7.8 | Live preview — Typography font family (needs refresh) | `inc/customizer.php` | ✅ |
| 7.9 | Organize customizer into Panels (Appearance / Typography / Layout / MCQ / Footer) | `inc/customizer.php` | ⬜ |
| 7.10 | Active callbacks (hide irrelevant controls) | `inc/customizer.php` | ⬜ |
| 7.11 | Minify dynamic CSS output | `inc/typography.php` | ✅ |
| 7.12 | Cross-browser testing | — | ⬜ |
| 7.13 | Mobile responsiveness testing | — | ⬜ |

---

## 📊 Overall Progress

| Phase | Total Tasks | Completed | Remaining |
|-------|-------------|-----------|-----------|
| 1 — Foundation | 11 | 9 | 2 |
| 2 — Header System | 14 | 14 | 0 |
| 3 — Content Layout | 10 | 0 | 10 |
| 4 — MCQ Features | 13 | 11 | 2 |
| 5 — Single Pages | 8 | 0 | 8 |
| 6 — Footer System | 7 | 1 | 6 |
| 7 — Live Preview & Polish | 13 | 11 | 2 |
| **Total** | **76** | **46** | **30** |

**Completion: 46 / 76 tasks (≈ 61%)**

---

## 🚀 Up Next (Recommended Order)

1. **Phase 1.10–1.11** — Add extended colors (Accent, Success, Error)
2. **Phase 3** — Content layout (sidebar, container, spacing)
3. **Phase 5** — Single page controls (sharing, navigation)
4. **Phase 6** — Footer colors & columns
5. **Phase 7.9** — Organize into Customizer Panels
