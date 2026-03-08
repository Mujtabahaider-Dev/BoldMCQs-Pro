# BoldMCQs Pro - Project Documentation

## 📋 Table of Contents
- [Project Overview](#project-overview)
- [Theme Information](#theme-information)
- [Architecture](#architecture)
- [File Structure](#file-structure)
- [Custom Post Types](#custom-post-types)
- [Customizer Settings](#customizer-settings)
- [Color System](#color-system)
- [JavaScript Functionality](#javascript-functionality)
- [Key Features](#key-features)
- [Template Hierarchy](#template-hierarchy)
- [Hooks & Filters](#hooks--filters)
- [Helper Functions](#helper-functions)
- [Development Guidelines](#development-guidelines)

---

## 📌 Project Overview

**BoldMCQs Pro** is a modern WordPress theme specifically designed for creating and managing Multiple Choice Questions (MCQ) quiz platforms. Built with Tailwind CSS and modern JavaScript, it provides an interactive learning experience with both practice and quiz modes.

### Theme Purpose
- Educational quiz platform
- MCQ practice and testing
- Interactive learning management
- Responsive design for all devices

---

## 🎨 Theme Information

```
Theme Name:    BoldMCQs Pro
Version:       1.0
Text Domain:   boldmcqspro
License:       GPL v2 or later
Tags:          quiz, education, responsive, tailwindcss
```

### Author Information
- **Author**: Your Name (needs to be updated in style.css)
- **Author URI**: https://example.com (needs to be updated)
- **Theme URI**: https://example.com/boldmcqspro (needs to be updated)

---

## 🏗️ Architecture

### Technology Stack
- **PHP**: WordPress theme development
- **CSS Framework**: Tailwind CSS (via CDN)
- **JavaScript**: Vanilla JS (ES6+)
- **Storage**: localStorage for quiz state persistence
- **Database**: WordPress custom post types & taxonomies

### Design Patterns
- **Dynamic Color System**: CSS custom properties with PHP generation
- **Template Parts**: Modular component system
- **Event Delegation**: Efficient JavaScript event handling
- **Mobile-First**: Responsive design approach
- **Progressive Enhancement**: Core functionality without JavaScript

---

## 📁 File Structure

```
BoldMCQs-Pro/
├── style.css                    # Theme header & base styles
├── functions.php                # Core theme setup
├── header.php                   # Site header template
├── footer.php                   # Site footer template (referenced but not read)
├── index.php                    # Homepage template (MCQ listing)
├── single.php                   # Single post/MCQ template
├── archive.php                  # Archive pages template
│
├── assets/
│   ├── js/
│   │   └── main.js             # Core JavaScript functionality
│   └── css/                     # Additional stylesheets (if any)
│
├── inc/                         # Theme includes
│   ├── setup.php               # Theme setup & support
│   ├── enqueue.php             # Scripts & styles enqueue
│   ├── widgets.php             # Widget areas registration
│   ├── customizer.php          # Customizer settings
│   ├── dynamic-colors.php      # Dynamic color system
│   ├── nav-menus.php           # Navigation menu walkers
│   ├── acf-fields.php          # ACF/Meta fields configuration
│   ├── typography.php          # Typography settings
│   ├── seo.php                 # SEO enhancements
│   └── header-buttons.php      # Header button helpers
│
├── template-parts/             # Reusable template components
│   ├── header/
│   │   └── site-branding.php  # Logo & site title
│   └── sidebar/
│       └── categories.php      # Categories widget
│
├── admin-loader.php            # Admin panel setup
│
└── PROJECT.md                  # This file
```

---

## 🎯 Custom Post Types

### MCQs Post Type
**Post Type**: `mcqs`

#### Custom Meta Fields
| Meta Key | Description | Type | Required |
|----------|-------------|------|----------|
| `mcq_option_a` | Option A text | string | Yes |
| `mcq_option_b` | Option B text | string | Yes |
| `mcq_option_c` | Option C text | string | No |
| `mcq_option_d` | Option D text | string | No |
| `mcq_correct_option` | Correct answer (A/B/C/D) | string | Yes |
| `mcq_explanation` | Answer explanation | text | No |
| `mcq_difficulty` | Difficulty level | string | No |

**Difficulty Levels**: `easy`, `medium`, `hard`

#### Custom Taxonomies
| Taxonomy | Description | Hierarchical |
|----------|-------------|--------------|
| `mcq_category` | MCQ categories | Yes |
| `mcq_tag` | MCQ tags | No |

#### Example MCQ Structure
```php
// MCQ Post Meta
$mcq_data = array(
    'mcq_option_a' => 'Paris',
    'mcq_option_b' => 'London',
    'mcq_option_c' => 'Berlin',
    'mcq_option_d' => 'Madrid',
    'mcq_correct_option' => 'A',
    'mcq_explanation' => 'Paris is the capital city of France.',
    'mcq_difficulty' => 'easy'
);
```

---

## ⚙️ Customizer Settings

The theme uses WordPress Customizer extensively. Settings are retrieved via:
```php
boldmcqspro_get_option( $option_name, $default_value );
```

### Color Settings
Located in: `Appearance → Customize → Colors`

#### Primary Colors
- `boldmcqspro_primary_color` - Default: `#3B82F6` (Blue)
- `boldmcqspro_secondary_color` - Default: `#10B981` (Green)
- `boldmcqspro_accent_color` - Default: `#F59E0B` (Amber)

#### Background Colors
- `boldmcqspro_body_bg_color` - Body background
- `boldmcqspro_card_bg_color` - Card backgrounds
- `boldmcqspro_header_bg_color` - Header background
- `boldmcqspro_footer_bg_color` - Footer background
- `boldmcqspro_muted_bg_color` - Muted backgrounds

#### Text Colors
- `boldmcqspro_text_color` - Body text
- `boldmcqspro_heading_color` - Headings
- `boldmcqspro_border_color` - Borders

#### MCQ-Specific Colors
- `boldmcqspro_mcq_option_text_color` - Default: `#FFFFFF`
- `boldmcqspro_mcq_option_letter_color` - Option letters (A/B/C/D)
- `boldmcqspro_mcq_correct_color` - Correct answer indicator
- `boldmcqspro_mcq_background_color` - MCQ card background
- `boldmcqspro_mcq_border_color` - MCQ card borders
- `boldmcqspro_mcq_hover_color` - Option hover state
- `boldmcqspro_explanation_btn_color` - Explanation button
- `boldmcqspro_quiz_btn_color` - Quiz mode button

### Header Settings
Located in: `Appearance → Customize → Header`

- `boldmcqspro_sticky_header` - Enable sticky header (Default: true)
- `boldmcqspro_header_height` - Header height in pixels (Default: 64)
- `boldmcqspro_header_bg` - Header background color
- `boldmcqspro_header_shadow` - Shadow style: none/sm/md/lg/xl (Default: 'md')
- `boldmcqspro_show_primary_menu` - Show primary menu (Default: true)
- `boldmcqspro_show_mobile_menu` - Show mobile menu (Default: true)
- `boldmcqspro_mobile_menu_breakpoint` - Breakpoint: sm/md/lg (Default: 'md')

### Navigation Menu Settings
Located in: `Appearance → Customize → Navigation Menu`

- `boldmcqspro_menu_style` - Menu style: default/minimal/bold
- `boldmcqspro_menu_hover_effect` - Hover effect: underline/background/scale/none

### MCQ Display Settings
Located in: `Appearance → Customize → MCQ Display`

- `boldmcqspro_mcq_card_style` - Card style: default/minimal/bordered/gradient
- `boldmcqspro_show_mcq_numbers` - Show question numbers (Default: false)
- `boldmcqspro_enable_mcq_links` - Enable question links (Default: true)
- `boldmcqspro_show_explanation_btn` - Show explanation button (Default: true)
- `boldmcqspro_show_explanations` - Auto-show explanations (Default: false)
- `boldmcqspro_show_author` - Show author info (Default: true)
- `boldmcqspro_show_categories` - Show categories (Default: true)
- `boldmcqspro_show_date` - Show date (Default: true)
- `boldmcqspro_show_difficulty` - Show difficulty level (Default: false)
- `boldmcqspro_default_difficulty` - Default difficulty: easy/medium/hard

### Homepage Settings
Located in: `Appearance → Customize → Homepage`

- `boldmcqspro_homepage_mcqs_title` - Section title (Default: 'Practice Questions')
- `boldmcqspro_homepage_mcqs_per_page` - Posts per page (Default: 10)
- `boldmcqspro_homepage_mcqs_orderby` - Order by: date/title/rand (Default: 'date')
- `boldmcqspro_homepage_mcqs_order` - Order: ASC/DESC (Default: 'DESC')
- `boldmcqspro_homepage_mcqs_category` - Filter by category slug
- `boldmcqspro_show_quiz_mode_btn` - Show quiz mode button (Default: true)

### Sidebar Settings
Located in: `Appearance → Customize → Sidebar`

- `boldmcqspro_show_search_box` - Show search widget (Default: true)
- `boldmcqspro_show_top_contributors` - Show contributors (Default: true)
- `boldmcqspro_show_categories_widget` - Show categories (Default: true)

---

## 🎨 Color System

### How It Works
The theme uses a **dynamic color system** that generates CSS custom properties from Customizer settings.

#### CSS Custom Properties
Located in: [inc/dynamic-colors.php](inc/dynamic-colors.php:60-81)

```css
:root {
    /* RGB triplets for rgba() support */
    --cp: 59, 130, 246;      /* Primary */
    --cs: 16, 185, 129;      /* Secondary */
    --ca: 245, 158, 11;      /* Accent */

    /* Hex values for direct use */
    --color-primary-hex: #3B82F6;
    --color-secondary-hex: #10B981;
    --color-accent-hex: #F59E0B;
}
```

#### Usage in Templates
```php
<!-- PHP -->
<div style="color: rgb(var(--cp));">Primary Color</div>

<!-- CSS Classes (auto-generated) -->
<div class="bg-primary text-white">Button</div>
<div class="hover:bg-primary/80">Hover Effect</div>
<div class="bg-gradient-to-r from-primary to-secondary">Gradient</div>
```

#### Adding New Colors
**Step 1**: Add Customizer setting in `inc/customizer.php`:
```php
$wp_customize->add_setting('boldmcqspro_new_color', array(
    'default' => '#FF0000',
    'sanitize_callback' => 'sanitize_hex_color',
));
```

**Step 2**: Add CSS custom property in `inc/dynamic-colors.php`:
```php
$new_color = boldmcqspro_get_option('boldmcqspro_new_color', '#FF0000');
$new_color_rgb = boldmcqspro_hex_to_rgb($new_color);
```

**Step 3**: Output CSS utilities:
```css
.bg-new-color { background-color: rgb(var(--cn)) !important; }
.text-new-color { color: rgb(var(--cn)) !important; }
```

---

## 💻 JavaScript Functionality

### Main JavaScript File
Located in: [assets/js/main.js](assets/js/main.js)

#### Core Features

##### 1. Quiz Mode System
```javascript
// State Management
let isQuizMode = false;           // Current mode
let quizAnswers = {};             // Stored answers {mcqId: optionIndex}
let quizModeInitialized = false;  // Initialization flag

// Storage
localStorage.setItem('boldmcqs_quiz_mode', 'true');
```

**Functions**:
- `initializeQuizMode()` - Setup event listeners [Line 484]
- `startQuizMode()` - Activate quiz mode [Line 519]
- `exitQuizMode()` - Deactivate quiz mode [Line 545]
- `updateQuizDisplay()` - Refresh UI [Line 236]
- `selectAnswer(mcqId, optionIndex)` - Record answer [Line 336]

##### 2. Theme Switcher
```javascript
// Dark/Light Mode
toggleLightDark()              // Toggle mode [Line 70]
setColorTheme(theme)          // Change color theme [Line 93]

// Storage Keys
localStorage.setItem('mode', 'dark');           // 'light' or 'dark'
localStorage.setItem('colorTheme', 'blue');     // Theme color
```

##### 3. Search Enhancement
```javascript
initializeSearch()  // Setup search functionality [Line 124]
```
- Real-time search indicator
- Empty search prevention
- Keyboard shortcut: `Ctrl/Cmd + K`

##### 4. Mobile Menu
```javascript
initializeMobileMenu()  // Mobile navigation [Line 168]
```
- Hamburger toggle
- Click outside to close
- Auto-close on resize

##### 5. Utility Functions
```javascript
toggleExplanation(mcqId)         // Toggle explanation display [Line 321]
showCorrectAnswer(mcqId)         // Highlight correct option [Line 426]
resetMCQToDefault(mcqId)         // Reset single MCQ [Line 351]
resetAllMCQsToDefault()          // Reset all MCQs [Line 388]
copyToClipboard(text)            // Copy link to clipboard [Line 657]
showCopyNotification(message)    // Show toast notification [Line 700]
```

#### Event Delegation Pattern
The theme uses event delegation for better performance:

```javascript
// Instead of individual listeners
document.body.addEventListener('click', function(event) {
    if (event.target.id === 'quizModeBtn') {
        // Handle quiz mode toggle
    }
    if (event.target.id === 'exitQuizBtn') {
        // Handle exit quiz
    }
});
```

#### LocalStorage Keys
| Key | Value | Description |
|-----|-------|-------------|
| `boldmcqs_quiz_mode` | `'true'/'false'` | Quiz mode state |
| `mode` | `'light'/'dark'` | Theme mode |
| `colorTheme` | `'blue'/'green'/etc` | Color theme |

---

## ✨ Key Features

### 1. Quiz Mode
**Location**: Homepage, Archive pages

**How it works**:
1. User clicks "🎯 Start Quiz Mode" button
2. State saved to localStorage
3. UI updates:
   - Radio buttons appear
   - Practice letters (A/B/C/D) hide
   - Quiz banner shows
4. User selects answers
5. Instant feedback on submission
6. State persists across pages

**Visual States**:
- **Unanswered**: Gray border, pointer cursor
- **Correct**: Green border, green background
- **Incorrect**: Red border, red background, shows correct answer

### 2. Practice Mode (Default)
**Location**: All MCQ pages

**Features**:
- View all questions
- Click "Show Explanation" to reveal answer
- No answer recording
- Option letters visible (A/B/C/D)

### 3. Responsive Design

#### Breakpoints
```css
/* Mobile */
@media (max-width: 640px) { }

/* Tablet */
@media (min-width: 641px) and (max-width: 1024px) { }

/* Desktop */
@media (min-width: 1025px) { }

/* Touch Devices */
@media (hover: none) and (pointer: coarse) { }
```

#### Key Responsive Features
- Mobile-first approach
- Collapsible navigation
- Stacked layouts on mobile
- Larger touch targets
- Optimized typography
- Print styles included

### 4. Dark Mode Support
**Toggle Location**: Theme dropdown (if implemented in header)

**Classes**:
```html
<html class="dark">
  <body class="bg-gray-50 dark:bg-gray-900">
    <div class="text-gray-900 dark:text-white">
```

### 5. Search Functionality
**Location**: Sidebar widget

**Features**:
- Live search indicator
- Empty search prevention
- Keyboard shortcut: `Ctrl/Cmd + K`
- Search only MCQ post type
- 20 results per page

### 6. Social Sharing
**Location**: Single MCQ pages [single.php:130-178]

**Platforms**:
- Facebook
- Twitter (X)
- LinkedIn
- WhatsApp
- Copy Link (with notification)

### 7. Pagination System
**Location**: Homepage, Archive pages

**Features**:
- Previous/Next buttons
- Page numbers (current ±2)
- First/Last page links
- Ellipsis for gaps
- Jump to page input
- Page counter

### 8. Navigation System
**Location**: Header, Single pages

**Types**:
- **Breadcrumbs**: `boldmcqspro_breadcrumbs()` function
- **Previous/Next**: Within same taxonomy
- **Back to Home**: Return to listing
- **Related MCQs**: Sidebar widget

### 9. Top Contributors Widget
**Location**: Sidebar

**Query**: Top 5 authors by published MCQ count
**Display**: Avatar initials, name, MCQ count
**Colors**: Gradient backgrounds

---

## 📄 Template Hierarchy

### Template Files

#### Homepage
**File**: `index.php`
**Query**: Custom post type `mcqs`
**Displays**: MCQ cards with quiz mode

#### Single MCQ
**File**: `single.php`
**Detects**: `get_post_type() === 'mcqs'`
**Shows**: Full question, options, explanation, sharing, navigation

#### Single Post (Regular)
**File**: `single.php` (else block)
**Shows**: Standard blog post layout

#### Archive Pages
**File**: `archive.php`
**Handles**:
- Category archives
- Tag archives
- MCQ category archives (`mcq_category`)
- MCQ tag archives (`mcq_tag`)
- Author archives
- Date archives

### Template Parts

#### Site Branding
**File**: `template-parts/header/site-branding.php`
**Usage**: `get_template_part('template-parts/header/site-branding')`

#### Categories Widget
**File**: `template-parts/sidebar/categories.php`
**Usage**: `get_template_part('template-parts/sidebar/categories')`

---

## 🔗 Hooks & Filters

### Theme Hooks

#### Actions
```php
// Enhance search to prioritize MCQs
add_action('pre_get_posts', 'boldmcqspro_enhance_search');

// Output dynamic colors in <head>
add_action('wp_head', 'boldmcqspro_output_dynamic_colors', 5);

// Output Tailwind config
add_action('wp_head', 'boldmcqspro_output_tailwind_config', 1);

// Admin notices
add_action('admin_notices', 'boldmcqspro_permalink_notice');
add_action('admin_notices', 'boldmcqspro_menu_setup_notice');

// Manual rewrite flush
add_action('admin_init', 'boldmcqspro_manual_flush_rewrite_rules');

// Fix pagination 404s
add_action('init', 'boldmcqspro_fix_pagination_404');
```

#### Filters
```php
// Custom page titles for pagination
add_filter('wp_title', 'boldmcqspro_custom_page_title');
add_filter('document_title_parts', function($title_parts) { });
```

### Custom Functions

#### Search Enhancement
**Function**: `boldmcqspro_enhance_search($query)`
**File**: [functions.php:20-55]

**Purpose**: Modify main query to:
- Show only MCQs on search
- Display MCQs on homepage
- Apply customizer filters
- Handle pagination

#### Breadcrumbs
**Function**: `boldmcqspro_breadcrumbs()`
**Location**: Likely in `inc/setup.php`
**Usage**: Display hierarchical navigation

#### Get Option Helper
**Function**: `boldmcqspro_get_option($option, $default)`
**Location**: Likely in `inc/customizer.php`
**Usage**: Retrieve customizer settings

#### RGB Conversion
**Function**: `boldmcqspro_hex_to_rgb($hex)`
**File**: [inc/dynamic-colors.php]
**Usage**: Convert hex colors to RGB triplets

#### Header Buttons
**Functions**:
- `boldmcqspro_render_auth_buttons()` - Login/Register buttons
- `boldmcqspro_render_header_buttons()` - Custom CTA buttons

**File**: `inc/header-buttons.php`
**Usage**: [header.php:315-316]

---

## 🛠️ Helper Functions

### Navigation Menu Walkers

#### Desktop Menu Walker
**Class**: `BoldMcqsPro_Walker_Nav_Menu`
**File**: `inc/nav-menus.php`
**Usage**: Custom navigation menu HTML structure

#### Mobile Menu Walker
**Class**: `BoldMcqsPro_Mobile_Walker_Nav_Menu`
**File**: `inc/nav-menus.php`
**Usage**: Simplified mobile navigation

### JavaScript Global Functions

```javascript
// Available globally via window object
window.copyToClipboard(text)    // Copy text to clipboard
window.toggleExplanation(id)    // Toggle explanation visibility
```

---

## 📝 Development Guidelines

### Adding a New Customizer Setting

**Step 1**: Add setting in `inc/customizer.php`
```php
$wp_customize->add_setting('boldmcqspro_my_setting', array(
    'default' => 'default_value',
    'sanitize_callback' => 'sanitize_text_field',
    'transport' => 'refresh', // or 'postMessage'
));

$wp_customize->add_control('boldmcqspro_my_setting', array(
    'label' => __('My Setting', 'boldmcqspro'),
    'section' => 'my_section',
    'type' => 'text',
));
```

**Step 2**: Use in templates
```php
$my_value = boldmcqspro_get_option('boldmcqspro_my_setting', 'default_value');
echo esc_html($my_value);
```

### Adding a New MCQ Meta Field

**Step 1**: Add field in `inc/acf-fields.php` or create meta box

**Step 2**: Save field on post save

**Step 3**: Retrieve in template
```php
$my_field = get_post_meta(get_the_ID(), 'mcq_my_field', true);
```

### Adding a New Template Part

**Step 1**: Create file in `template-parts/`
```
template-parts/
  └── my-section/
      └── my-component.php
```

**Step 2**: Use in template
```php
get_template_part('template-parts/my-section/my-component');
```

### Adding JavaScript Functionality

**Step 1**: Add code to `assets/js/main.js`

**Step 2**: Use event delegation pattern
```javascript
document.addEventListener('DOMContentLoaded', function() {
    // Your initialization code
});
```

**Step 3**: Make globally available if needed
```javascript
window.myFunction = function() {
    // Function code
};
```

### Styling Guidelines

#### Use Dynamic Colors
```css
/* ✅ Good - Uses dynamic colors */
.my-element {
    background-color: rgb(var(--cp));
    color: rgb(var(--cs));
}

/* ❌ Avoid - Hardcoded colors */
.my-element {
    background-color: #3B82F6;
}
```

#### Use Tailwind Classes
```html
<!-- ✅ Good - Utility classes -->
<div class="bg-primary text-white p-4 rounded-lg">

<!-- ❌ Avoid - Inline styles -->
<div style="background: blue; color: white; padding: 1rem;">
```

#### Responsive Design
```html
<!-- Mobile-first approach -->
<div class="text-sm sm:text-base md:text-lg lg:text-xl">
```

---

## 🐛 Common Issues & Solutions

### Issue: Permalinks Not Working
**Solution**: Go to `Settings → Permalinks` and re-save

### Issue: Menu Not Showing
**Solution**: Create menu at `Appearance → Menus` and assign to "Primary Menu" location

### Issue: Quiz Mode Not Persisting
**Solution**: Check browser localStorage is enabled

### Issue: Colors Not Updating
**Solution**:
1. Check `inc/dynamic-colors.php` is loaded
2. Clear browser cache
3. Check Customizer values are saved

### Issue: Mobile Menu Not Working
**Solution**: Ensure `main.js` is enqueued in `inc/enqueue.php`

---

## 🔄 Git Workflow

### Recent Changes (from git status)
```
Modified files:
- archive.php
- assets/js/main.js
- header.php
- inc/dynamic-colors.php
- index.php
- single.php

New directory:
- template-parts/sidebar/

Recent commits:
- c839343 Update BG Color Customization
- e838080 Updated Color Customization
- 53ecad2 Header Customization
- 49f8f4f Initialize
- 8267a7c Initial commit
```

### Branch Structure
- **Main Branch**: `main`
- **Current Branch**: `main`

---

## 📚 Additional Resources

### WordPress Functions Used
- `get_post_meta()` - Retrieve MCQ meta fields
- `get_the_terms()` - Get taxonomies
- `wp_nav_menu()` - Display navigation
- `get_template_part()` - Load template parts
- `add_action()` / `add_filter()` - Hook system
- `sanitize_hex_color()` - Sanitize colors
- `esc_html()` / `esc_attr()` / `esc_url()` - Security

### Tailwind CSS Resources
- Using CDN: `https://cdn.tailwindcss.com`
- Custom config via JavaScript
- Dynamic theme colors

### Browser APIs Used
- `localStorage` - State persistence
- `navigator.clipboard` - Copy to clipboard
- Event delegation for performance

---

## 🚀 Future Enhancements

### Potential Features
1. **User Progress Tracking** - Save quiz scores
2. **Leaderboard System** - Top performers
3. **Timer Functionality** - Timed quizzes
4. **Question Bookmarking** - Save favorites
5. **Export Results** - PDF/CSV export
6. **Advanced Filtering** - By difficulty, category, etc.
7. **Question Statistics** - View/answer counts
8. **AJAX Pagination** - Seamless navigation
9. **Question Comments** - Discussion system
10. **REST API Integration** - Mobile app support

### Performance Optimizations
1. Lazy load images
2. Minify assets
3. Implement caching
4. Database query optimization
5. Use local Tailwind build instead of CDN

---

## 📞 Support & Maintenance

### File Locations for Common Tasks

#### Change Theme Colors
- File: `Appearance → Customize → Colors`
- Or directly: `inc/customizer.php`

#### Modify Header
- File: `header.php`
- Settings: `Appearance → Customize → Header`

#### Change Homepage Layout
- File: `index.php`
- Settings: `Appearance → Customize → Homepage`

#### Add New Meta Field
- File: `inc/acf-fields.php`
- Template usage: Get with `get_post_meta()`

#### Modify Quiz Logic
- File: `assets/js/main.js`
- Functions: `startQuizMode()`, `selectAnswer()`, etc.

---

## 📋 Checklist for New Developers

- [ ] Update theme information in `style.css`
- [ ] Configure permalink structure
- [ ] Create and assign navigation menus
- [ ] Set up customizer color scheme
- [ ] Test quiz mode functionality
- [ ] Test responsive design on mobile
- [ ] Check dark mode compatibility
- [ ] Test pagination on various pages
- [ ] Verify social sharing buttons work
- [ ] Test search functionality
- [ ] Review SEO settings
- [ ] Check browser compatibility
- [ ] Test with real MCQ data

---

## 🔐 Security Notes

### Data Sanitization
- All colors: `sanitize_hex_color()`
- Text fields: `sanitize_text_field()`
- Numbers: `absint()` or `intval()`

### Output Escaping
- HTML: `esc_html()`
- Attributes: `esc_attr()`
- URLs: `esc_url()`
- JavaScript: `esc_js()`

### SQL Queries
- Use `$wpdb->prepare()` for custom queries
- Use WordPress query functions when possible

---

## 📖 Code Examples

### Example: Create New MCQ Programmatically
```php
$mcq_data = array(
    'post_title'   => 'What is the capital of France?',
    'post_type'    => 'mcqs',
    'post_status'  => 'publish',
    'tax_input'    => array(
        'mcq_category' => array('general-knowledge'),
    ),
);

$mcq_id = wp_insert_post($mcq_data);

// Add meta fields
update_post_meta($mcq_id, 'mcq_option_a', 'Paris');
update_post_meta($mcq_id, 'mcq_option_b', 'London');
update_post_meta($mcq_id, 'mcq_option_c', 'Berlin');
update_post_meta($mcq_id, 'mcq_option_d', 'Madrid');
update_post_meta($mcq_id, 'mcq_correct_option', 'A');
update_post_meta($mcq_id, 'mcq_explanation', 'Paris is the capital of France.');
update_post_meta($mcq_id, 'mcq_difficulty', 'easy');
```

### Example: Query MCQs by Category
```php
$args = array(
    'post_type' => 'mcqs',
    'posts_per_page' => 10,
    'tax_query' => array(
        array(
            'taxonomy' => 'mcq_category',
            'field'    => 'slug',
            'terms'    => 'science',
        ),
    ),
);

$mcq_query = new WP_Query($args);

if ($mcq_query->have_posts()) {
    while ($mcq_query->have_posts()) {
        $mcq_query->the_post();
        // Display MCQ
    }
    wp_reset_postdata();
}
```

### Example: Add Custom Customizer Color
```php
// In inc/customizer.php
$wp_customize->add_setting('boldmcqspro_custom_color', array(
    'default' => '#FF5733',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport' => 'refresh',
));

$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'boldmcqspro_custom_color',
        array(
            'label' => __('Custom Color', 'boldmcqspro'),
            'section' => 'colors',
        )
    )
);
```

---

## 📄 License

This theme is licensed under GPL v2 or later.
- You can modify and redistribute
- Must maintain GPL license
- No warranty provided

---

## 📝 Version History

### Version 1.0 (Current)
- Initial release
- Core MCQ functionality
- Quiz mode system
- Responsive design
- Dark mode support
- Dynamic color system
- Customizer integration

---

**Last Updated**: 2026-03-08
**Document Version**: 1.0
**Theme Version**: 1.0

---

*This documentation is maintained alongside the theme development. Please update when making significant changes to the theme structure or functionality.*
