# BoldMCQs Pro - Complete Customization Implementation Plan

**Created:** February 15, 2026  
**Goal:** Make ALL theme UI features dynamically customizable through WordPress Customizer  
**Approach:** Build From Scratch - Clean, Organized, Professional

---

## 📊 Current State Analysis

### ✅ What You Have
- **1518-line customizer** with many options defined
- **Modern UI** with Tailwind CSS
- **MCQ-specific features** (quiz mode, explanations, navigation)
- **Clean templates** (header, footer, index, single)

### ❌ The Problem
- **Typography system**: Defined but NOT applied
- **Header buttons**: Defined but NOT rendered
- **Many hardcoded values**: Colors, sizes, spacing in templates
- **No layout customization**: Sidebar, grid, spacing
- **Limited single page control**: Share buttons, navigation fixed

---

## 🎯 Strategic Approach

We'll build customization in **7 themed phases**, each focused on one aspect:

1. **Foundation** → Core typography & colors (working base)
2. **Header System** → Logo, navigation, buttons
3. **Content Layout** → Homepage, archives, sidebars
4. **MCQ Features** → Questions, options, explanations
5. **Single Pages** → Individual MCQ display, sharing
6. **Footer System** → Layout, copyright, widgets
7. **Polish & Advanced** → Animations, responsive, performance

Each phase:
- ✅ Adds new customizer options
- ✅ Updates templates to use them
- ✅ Tests in real-time
- ✅ Documents settings

---

## 📋 Phase 1: Foundation System (Week 1)
**Goal:** Get typography and color system working perfectly  
**Time:** 6-8 hours  
**Impact:** HIGH - affects entire site

### 1.1 Typography Implementation

#### Customizer Options to Add/Fix
```php
// Already defined in customizer.php (lines 1177-1481)
✅ Primary font (headings)
✅ Secondary font (body)
✅ MCQ question font
✅ MCQ options font
✅ Font weights
✅ Font sizes
✅ Line height
✅ Letter spacing
✅ Google Fonts toggle
```

#### New File to Create: `inc/typography.php`

**Purpose:** Load fonts & generate dynamic CSS

```php
<?php
/**
 * Typography System
 * Loads Google Fonts and applies typography settings
 */

// Load Google Fonts
function boldmcqspro_load_google_fonts() {
    if (!boldmcqspro_get_option('boldmcqspro_enable_google_fonts', true)) {
        return;
    }
    
    $fonts_to_load = array();
    
    // Get selected fonts
    $primary_font = boldmcqspro_get_option('boldmcqspro_primary_font', 'Inter');
    $secondary_font = boldmcqspro_get_option('boldmcqspro_secondary_font', 'Inter');
    $mcq_question_font = boldmcqspro_get_option('boldmcqspro_mcq_question_font', 'Inter');
    $mcq_options_font = boldmcqspro_get_option('boldmcqspro_mcq_options_font', 'Inter');
    
    // System fonts don't need Google Fonts
    $system_fonts = array('system-ui', 'Arial', 'Georgia', 'Times New Roman', 'Courier New');
    
    // Add unique fonts to load array
    $all_fonts = array($primary_font, $secondary_font, $mcq_question_font, $mcq_options_font);
    $unique_fonts = array_unique($all_fonts);
    
    foreach ($unique_fonts as $font) {
        if (!in_array($font, $system_fonts)) {
            $fonts_to_load[] = str_replace(' ', '+', $font) . ':wght@300;400;500;600;700;800';
        }
    }
    
    if (!empty($fonts_to_load)) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts_to_load) . '&display=swap';
        wp_enqueue_style('boldmcqspro-google-fonts', $fonts_url, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'boldmcqspro_load_google_fonts');

// Output dynamic typography CSS
function boldmcqspro_typography_css() {
    // Get all typography options
    $primary_font = boldmcqspro_get_option('boldmcqspro_primary_font', 'Inter');
    $primary_weight = boldmcqspro_get_option('boldmcqspro_primary_font_weight', '700');
    $secondary_font = boldmcqspro_get_option('boldmcqspro_secondary_font', 'Inter');
    $secondary_weight = boldmcqspro_get_option('boldmcqspro_secondary_font_weight', '400');
    
    $base_size = boldmcqspro_get_option('boldmcqspro_base_font_size', '16');
    $h1_size = boldmcqspro_get_option('boldmcqspro_h1_font_size', '36');
    $h2_size = boldmcqspro_get_option('boldmcqspro_h2_font_size', '30');
    $h3_size = boldmcqspro_get_option('boldmcqspro_h3_font_size', '24');
    
    $line_height = boldmcqspro_get_option('boldmcqspro_line_height', '1.6');
    $letter_spacing = boldmcqspro_get_option('boldmcqspro_letter_spacing', 'normal');
    
    $mcq_question_font = boldmcqspro_get_option('boldmcqspro_mcq_question_font', 'Inter');
    $mcq_question_size = boldmcqspro_get_option('boldmcqspro_mcq_question_size', '20');
    $mcq_options_font = boldmcqspro_get_option('boldmcqspro_mcq_options_font', 'Inter');
    $mcq_options_size = boldmcqspro_get_option('boldmcqspro_mcq_options_size', '16');
    
    // Convert letter spacing
    $letter_spacing_value = $letter_spacing;
    if ($letter_spacing === 'tight') $letter_spacing_value = '-0.025em';
    if ($letter_spacing === 'normal') $letter_spacing_value = '0';
    if ($letter_spacing === 'wide') $letter_spacing_value = '0.025em';
    if ($letter_spacing === 'wider') $letter_spacing_value = '0.05em';
    
    ?>
    <style id="boldmcqspro-typography-css">
        :root {
            --font-primary: '<?php echo esc_attr($primary_font); ?>', sans-serif;
            --font-secondary: '<?php echo esc_attr($secondary_font); ?>', sans-serif;
            --font-base-size: <?php echo intval($base_size); ?>px;
            --line-height: <?php echo floatval($line_height); ?>;
            --letter-spacing: <?php echo $letter_spacing_value; ?>;
        }
        
        /* Base Typography */
        body {
            font-family: var(--font-secondary);
            font-size: var(--font-base-size);
            font-weight: <?php echo intval($secondary_weight); ?>;
            line-height: var(--line-height);
            letter-spacing: var(--letter-spacing);
        }
        
        /* Headings */
        h1, h2, h3, h4, h5, h6,
        .site-title {
            font-family: var(--font-primary);
            font-weight: <?php echo intval($primary_weight); ?>;
            line-height: 1.2;
        }
        
        h1 { font-size: <?php echo intval($h1_size); ?>px; }
        h2 { font-size: <?php echo intval($h2_size); ?>px; }
        h3 { font-size: <?php echo intval($h3_size); ?>px; }
        
        /* MCQ Specific */
        .mcq-card h3,
        .mcq-question-title {
            font-family: '<?php echo esc_attr($mcq_question_font); ?>', sans-serif;
            font-size: <?php echo intval($mcq_question_size); ?>px;
        }
        
        .mcq-option,
        .mcq-option span,
        .mcq-option .flex-1 {
            font-family: '<?php echo esc_attr($mcq_options_font); ?>', sans-serif;
            font-size: <?php echo intval($mcq_options_size); ?>px !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'boldmcqspro_typography_css', 100);
```

#### Files to Modify
- [ ] `functions.php` - Add `require_once get_template_directory() . '/inc/typography.php';`
- [ ] Test in Customizer with live preview

### 1.2 Enhanced Color System

#### Current Colors (Already Working)
- ✅ Primary color
- ✅ Secondary color
- ✅ MCQ option text
- ✅ MCQ letters
- ✅ Correct answer indicator

#### NEW Colors to Add

**In `inc/customizer.php` - Colors Section:**

```php
// Add to existing colors section around line 479

// === ADDITIONAL THEME COLORS ===

// Accent Color
$wp_customize->add_setting('boldmcqspro_accent_color', array(
    'default'           => '#F59E0B',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_accent_color', array(
    'label'       => __('Accent Color', 'boldmcqspro'),
    'description' => __('Used for highlights, badges, and special elements', 'boldmcqspro'),
    'section'     => 'boldmcqspro_colors',
)));

// Link Color
$wp_customize->add_setting('boldmcqspro_link_color', array(
    'default'           => '', // Empty = use primary
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_link_color', array(
    'label'       => __('Link Color', 'boldmcqspro'),
    'description' => __('Leave empty to use primary color', 'boldmcqspro'),
    'section'     => 'boldmcqspro_colors',
)));

// Link Hover Color
$wp_customize->add_setting('boldmcqspro_link_hover_color', array(
    'default'           => '', // Empty = use darker primary
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_link_hover_color', array(
    'label'       => __('Link Hover Color', 'boldmcqspro'),
    'description' => __('Leave empty to auto-darken link color', 'boldmcqspro'),
    'section'     => 'boldmcqspro_colors',
)));

// Success Color (for correct answers)
$wp_customize->add_setting('boldmcqspro_success_color', array(
    'default'           => '#10B981',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_success_color', array(
    'label'       => __('Success Color', 'boldmcqspro'),
    'description' => __('Used for correct answers and success messages', 'boldmcqspro'),
    'section'     => 'boldmcqspro_colors',
)));

// Error/Wrong Color
$wp_customize->add_setting('boldmcqspro_error_color', array(
    'default'           => '#EF4444',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_error_color', array(
    'label'       => __('Error Color', 'boldmcqspro'),
    'description' => __('Used for wrong answers and error messages', 'boldmcqspro'),
    'section'     => 'boldmcqspro_colors',
)));

// Background Color (Light Mode)
$wp_customize->add_setting('boldmcqspro_bg_color_light', array(
    'default'           => '#F9FAFB',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_bg_color_light', array(
    'label'       => __('Background Color (Light)', 'boldmcqspro'),
    'description' => __('Main page background in light mode', 'boldmcqspro'),
    'section'     => 'boldmcqspro_colors',
)));

// Card Background Color
$wp_customize->add_setting('boldmcqspro_card_bg_light', array(
    'default'           => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_card_bg_light', array(
    'label'       => __('Card Background (Light)', 'boldmcqspro'),
    'description' => __('Background for cards and widgets', 'boldmcqspro'),
    'section'     => 'boldmcqspro_colors',
)));
```

#### Apply Colors in `header.php`

Update the `:root` CSS variables section (around line 21-29):

```php
:root {
    <?php
    // Get all colors
    $primary_hex = boldmcqspro_get_option('boldmcqspro_primary_color', '#3B82F6');
    $secondary_hex = boldmcqspro_get_option('boldmcqspro_secondary_color', '#10B981');
    $accent_hex = boldmcqspro_get_option('boldmcqspro_accent_color', '#F59E0B');
    $success_hex = boldmcqspro_get_option('boldmcqspro_success_color', '#10B981');
    $error_hex = boldmcqspro_get_option('boldmcqspro_error_color', '#EF4444');
    $link_hex = boldmcqspro_get_option('boldmcqspro_link_color', '') ?: $primary_hex;
    $link_hover_hex = boldmcqspro_get_option('boldmcqspro_link_hover_color', '') ?: boldmcqspro_darken_color($link_hex, 10);
    ?>
    --color-primary: <?php echo boldmcqspro_hex_to_rgb($primary_hex); ?>;
    --color-secondary: <?php echo boldmcqspro_hex_to_rgb($secondary_hex); ?>;
    --color-accent: <?php echo boldmcqspro_hex_to_rgb($accent_hex); ?>;
    --color-success: <?php echo boldmcqspro_hex_to_rgb($success_hex); ?>;
    --color-error: <?php echo boldmcqspro_hex_to_rgb($error_hex); ?>;
    --color-link: <?php echo $link_hex; ?>;
    --color-link-hover: <?php echo $link_hover_hex; ?>;
}
```

### Phase 1 Deliverables
- [x] `inc/typography.php` created and working
- [x] Typography options applied to all text elements
- [x] Google Fonts loading correctly
- [x] Enhanced color system with 8 total colors
- [x] All colors applied via CSS variables
- [x] Test in Customizer - see changes live

---

## 📋 Phase 2: Header System (Week 1-2)
**Goal:** Complete header customization  
**Time:** 4-6 hours  
**Impact:** HIGH - first thing users see

### 2.1 Logo & Branding (Already 90% Done!)

✅ **Current file:** `template-parts/header/site-branding.php`  
✅ **Already uses:**
- Branding mode (logo/text/both)
- Logo width/height
- Site title size/transform

**Nothing to do here - already perfect!**

### 2.2 Header Buttons System

#### Problem
Customizer has 3 buttons defined (lines 149-463) but NOT rendered in `header.php`

#### Solution: Create Helper Function

**New file:** `inc/header-helpers.php`

```php
<?php
/**
 * Header Helper Functions
 */

/**
 * Render a header button
 * 
 * @param int $button_num Button number (1-3)
 * @return void
 */
function boldmcqspro_render_header_button($button_num) {
    // Check if button is enabled
    if (!boldmcqspro_get_option("boldmcqspro_button{$button_num}_show", false)) {
        return;
    }
    
    // Get button settings
    $text = boldmcqspro_get_option("boldmcqspro_button{$button_num}_text", '');
    $url = boldmcqspro_get_option("boldmcqspro_button{$button_num}_url", '#');
    $style = boldmcqspro_get_option("boldmcqspro_button{$button_num}_style", 'solid');
    $size = boldmcqspro_get_option("boldmcqspro_button{$button_num}_size", 'medium');
    $bg_color = boldmcqspro_get_option("boldmcqspro_button{$button_num}_bg_color", '');
    $text_color = boldmcqspro_get_option("boldmcqspro_button{$button_num}_text_color", '#FFFFFF');
    
    if (empty($text)) {
        return;
    }
    
    // Size classes
    $size_classes = array(
        'small' => 'px-3 py-1.5 text-sm',
        'medium' => 'px-4 py-2 text-base',
        'large' => 'px-6 py-3 text-lg'
    );
    
    // Style base classes
    $style_classes = array(
        'solid' => 'bg-primary text-white hover:bg-primary/80 border border-primary',
        'outline' => 'border-2 border-primary text-primary hover:bg-primary hover:text-white',
        'ghost' => 'text-primary hover:bg-primary/10'
    );
    
    $size_class = isset($size_classes[$size]) ? $size_classes[$size] : $size_classes['medium'];
    $base_style_class = isset($style_classes[$style]) ? $style_classes[$style] : $style_classes['solid'];
    
    // Custom color override
    $custom_style = '';
    if (!empty($bg_color)) {
        if ($style === 'solid') {
            $custom_style = "background-color: {$bg_color}; color: {$text_color}; border-color: {$bg_color};";
        } elseif ($style === 'outline') {
            $custom_style = "border-color: {$bg_color}; color: {$bg_color};";
        }
    }
    
    printf(
        '<a href="%s" class="%s %s rounded-lg transition-all duration-200 no-underline font-medium" style="%s">%s</a>',
        esc_url($url),
        $size_class,
        $base_style_class,
        esc_attr($custom_style),
        esc_html($text)
    );
}

/**
 * Render auth buttons (Login/Register/Logout/Dashboard)
 */
function boldmcqspro_render_auth_buttons() {
    if (!boldmcqspro_get_option('boldmcqspro_show_auth_buttons', true)) {
        return;
    }
    
    $login_text = boldmcqspro_get_option('boldmcqspro_login_text', 'Login');
    $register_text = boldmcqspro_get_option('boldmcqspro_register_text', 'Register');
    $logout_text = boldmcqspro_get_option('boldmcqspro_logout_text', 'Logout');
    $dashboard_text = boldmcqspro_get_option('boldmcqspro_dashboard_text', 'Dashboard');
    
    if (is_user_logged_in()) {
        ?>
        <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" 
           class="px-4 py-2 text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">
            <?php echo esc_html($logout_text); ?>
        </a>
        <a href="<?php echo esc_url(admin_url()); ?>" 
           class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/80 transition-colors">
            <?php echo esc_html($dashboard_text); ?>
        </a>
        <?php
    } else {
        ?>
        <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" 
           class="px-4 py-2 text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">
            <?php echo esc_html($login_text); ?>
        </a>
        <a href="<?php echo esc_url(wp_registration_url()); ?>" 
           class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/80 transition-colors">
            <?php echo esc_html($register_text); ?>
        </a>
        <?php
    }
}
```

#### Update `header.php`

**Replace lines 620-640** with:

```php
<!-- CTA Buttons & Theme Toggle -->
<div class="hidden md:flex items-center space-x-3">
    <!-- Theme Toggle (keep existing) -->
    <div class="relative">
        <!-- existing theme toggle code -->
    </div>
    
    <!-- Auth Buttons -->
    <?php boldmcqspro_render_auth_buttons(); ?>
    
    <!-- Custom Header Buttons 1, 2, 3 -->
    <?php boldmcqspro_render_header_button(1); ?>
    <?php boldmcqspro_render_header_button(2); ?>
    <?php boldmcqspro_render_header_button(3); ?>
</div>
```

### 2.3 Header Layout Options (NEW!)

Add customizer settings to control header appearance:

```php
// === HEADER LAYOUT SECTION ===
$wp_customize->add_section('boldmcqspro_header_layout', array(
    'title'       => __('🎛️ Header Layout & Styling', 'boldmcqspro'),
    'description' => __('Control header appearance, spacing, and behavior', 'boldmcqspro'),
    'priority'    => 35,
));

// Header Height
$wp_customize->add_setting('boldmcqspro_header_height', array(
    'default'           => '64',
    'sanitize_callback' => 'absint',
    'transport'         => 'postMessage',
));

$wp_customize->add_control('boldmcqspro_header_height', array(
    'label'       => __('Header Height (px)', 'boldmcqspro'),
    'description' => __('Height of the header bar', 'boldmcqspro'),
    'section'     => 'boldmcqspro_header_layout',
    'type'        => 'number',
    'input_attrs' => array(
        'min' => 48,
        'max' => 120,
        'step' => 4,
    ),
));

// Sticky Header
$wp_customize->add_setting('boldmcqspro_sticky_header', array(
    'default'           => true,
    'sanitize_callback' => 'wp_validate_boolean',
    'transport'         => 'refresh',
));

$wp_customize->add_control('boldmcqspro_sticky_header', array(
    'label'       => __('Enable Sticky Header', 'boldmcqspro'),
    'description' => __('Header stays fixed at top when scrolling', 'boldmcqspro'),
    'section'     => 'boldmcqspro_header_layout',
    'type'        => 'checkbox',
));

// Header Background Color
$wp_customize->add_setting('boldmcqspro_header_bg', array(
    'default'           => '#FFFFFF',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
));

$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_header_bg', array(
    'label'       => __('Header Background', 'boldmcqspro'),
    'section'     => 'boldmcqspro_header_layout',
)));

// Header Shadow
$wp_customize->add_setting('boldmcqspro_header_shadow', array(
    'default'           => 'md',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'postMessage',
));

$wp_customize->add_control('boldmcqspro_header_shadow', array(
    'label'       => __('Header Shadow', 'boldmcqspro'),
    'section'     => 'boldmcqspro_header_layout',
    'type'        => 'select',
    'choices'     => array(
        'none' => __('None', 'boldmcqspro'),
        'sm'   => __('Small', 'boldmcqspro'),
        'md'   => __('Medium', 'boldmcqspro'),
        'lg'   => __('Large', 'boldmcqspro'),
    ),
));
```

### Phase 2 Deliverables
- [x] `inc/header-helpers.php` created
- [x] Header buttons 1, 2, 3 rendering correctly
- [x] Auth buttons using helper function
- [x] Header layout options in customizer
- [x] Sticky header toggle working
- [x] Test all button styles (solid, outline, ghost)

---

## 📋 Phase 3: Content Layout System (Week 2)
**Goal:** Control page layouts, spacing, sidebars  
**Time:** 6-8 hours  
**Impact:** MEDIUM-HIGH

### 3.1 Homepage Layout Options

**New Customizer Section:**

```php
// === HOMEPAGE LAYOUT ===
$wp_customize->add_section('boldmcqspro_homepage_layout', array(
    'title'       => __('📐 Homepage Layout', 'boldmcqspro'),
    'description' => __('Control homepage structure and spacing', 'boldmcqspro'),
    'priority'    => 50,
));

// Container Width
$wp_customize->add_setting('boldmcqspro_container_width', array(
    'default'           => 'max-w-7xl',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'refresh',
));

$wp_customize->add_control('boldmcqspro_container_width', array(
    'label'       => __('Container Width', 'boldmcqspro'),
    'section'     => 'boldmcqspro_homepage_layout',
    'type'        => 'select',
    'choices'     => array(
        'max-w-5xl'  => __('Small (1024px)', 'boldmcqspro'),
        'max-w-6xl'  => __('Medium (1152px)', 'boldmcqspro'),
        'max-w-7xl'  => __('Large (1280px)', 'boldmcqspro'),
        'max-w-full' => __('Full Width', 'boldmcqspro'),
    ),
));

// Sidebar Layout
$wp_customize->add_setting('boldmcqspro_sidebar_layout', array(
    'default'           => 'right',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'refresh',
));

$wp_customize->add_control('boldmcqspro_sidebar_layout', array(
    'label'       => __('Sidebar Position', 'boldmcqspro'),
    'section'     => 'boldmcqspro_homepage_layout',
    'type'        => 'select',
    'choices'     => array(
        'left'  => __('Left Sidebar', 'boldmcqspro'),
        'right' => __('Right Sidebar', 'boldmcqspro'),
        'none'  => __('No Sidebar (Full Width)', 'boldmcqspro'),
    ),
));

// Sidebar Width Ratio
$wp_customize->add_setting('boldmcqspro_sidebar_width', array(
    'default'           => '1', // For 3-column grid (2 main + 1 sidebar)
    'sanitize_callback' => 'absint',
    'transport'         => 'refresh',
));

$wp_customize->add_control('boldmcqspro_sidebar_width', array(
    'label'       => __('Sidebar Width Ratio', 'boldmcqspro'),
    'description' => __('Sidebar columns (main content gets the rest)', 'boldmcqspro'),
    'section'     => 'boldmcqspro_homepage_layout',
    'type'        => 'select',
    'choices'     => array(
        '1' => __('Narrow (1/3 width)', 'boldmcqspro'),
        '2' => __('Balanced (1/2 width)', 'boldmcqspro'),
    ),
));

// MCQ Grid Columns (for no-sidebar layout)
$wp_customize->add_setting('boldmcqspro_mcq_grid_columns', array(
    'default'           => '1',
    'sanitize_callback' => 'absint',
    'transport'         => 'refresh',
));

$wp_customize->add_control('boldmcqspro_mcq_grid_columns', array(
    'label'       => __('MCQ Grid Columns (Full Width)', 'boldmcqspro'),
    'description' => __('When sidebar is hidden, show MCQs in columns', 'boldmcqspro'),
    'section'     => 'boldmcqspro_homepage_layout',
    'type'        => 'select',
    'choices'     => array(
        '1' => __('1 Column', 'boldmcqspro'),
        '2' => __('2 Columns', 'boldmcqspro'),
        '3' => __('3 Columns', 'boldmcqspro'),
    ),
));

// Vertical Spacing
$wp_customize->add_setting('boldmcqspro_vertical_spacing', array(
    'default'           => '6',
    'sanitize_callback' => 'absint',
    'transport'         => 'postMessage',
));

$wp_customize->add_control('boldmcqspro_vertical_spacing', array(
    'label'       => __('Vertical Spacing (Tailwind Scale)', 'boldmcqspro'),
    'description' => __('Space between MCQ cards (4px × value)', 'boldmcqspro'),
    'section'     => 'boldmcqspro_homepage_layout',
    'type'        => 'number',
    'input_attrs' => array(
        'min' => 2,
        'max' => 12,
        'step' => 1,
    ),
));

// Section Padding
$wp_customize->add_setting('boldmcqspro_section_padding_y', array(
    'default'           => '8',
    'sanitize_callback' => 'absint',
    'transport'         => 'postMessage',
));

$wp_customize->add_control('boldmcqspro_section_padding_y', array(
    'label'       => __('Section Padding Top/Bottom', 'boldmcqspro'),
    'description' => __('Tailwind scale (4px × value)', 'boldmcqspro'),
    'section'     => 'boldmcqspro_homepage_layout',
    'type'        => 'number',
    'input_attrs' => array(
        'min' => 4,
        'max' => 16,
        'step' => 1,
    ),
));
```

### 3.2 Update `index.php` to Use Layout Options

**Current line 3:**
```php
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
```

**Replace with:**
```php
<?php
// Get layout options
$container_width = boldmcqspro_get_option('boldmcqspro_container_width', 'max-w-7xl');
$sidebar_layout = boldmcqspro_get_option('boldmcqspro_sidebar_layout', 'right');
$sidebar_width = boldmcqspro_get_option('boldmcqspro_sidebar_width', '1');
$vertical_spacing = boldmcqspro_get_option('boldmcqspro_vertical_spacing', '6');
$section_padding = boldmcqspro_get_option('boldmcqspro_section_padding_y', '8');
$mcq_grid_cols = boldmcqspro_get_option('boldmcqspro_mcq_grid_columns', '1');

// Calculate grid classes
if ($sidebar_layout === 'none') {
    $main_cols = '';
    $sidebar_cols = '';
    $grid_class = '';
} else {
    $main_cols = $sidebar_width === '2' ? 'lg:col-span-1' : 'lg:col-span-2';
    $sidebar_cols = $sidebar_width === '2' ? 'lg:col-span-1' : 'lg:col-span-1';
    $grid_class = $sidebar_width === '2' ? 'lg:grid-cols-2' : 'lg:grid-cols-3';
}

$order_class = $sidebar_layout === 'left' ? 'order-2' : 'order-1';
$sidebar_order = $sidebar_layout === 'left' ? 'order-1' : 'order-2';
?>
<div class="<?php echo esc_attr($container_width); ?> mx-auto px-4 sm:px-6 lg:px-8 py-<?php echo $section_padding; ?>">
    <div class="grid grid-cols-1 <?php echo esc_attr($grid_class); ?> gap-<?php echo $vertical_spacing; ?> lg:gap-8">
        <!-- Main Content -->
        <div class="<?php echo esc_attr($order_class . ' ' . $main_cols); ?>">
```

**For MCQ container (line 36):**
```php
<!-- MCQ Cards -->
<?php
// Grid for full-width layout
if ($sidebar_layout === 'none' && $mcq_grid_cols > 1) {
    $grid_cols_class = $mcq_grid_cols === '3' ? 'md:grid-cols-2 lg:grid-cols-3' : 'md:grid-cols-2';
    echo '<div class="grid grid-cols-1 ' . $grid_cols_class . ' gap-' . $vertical_spacing . '">';
} else {
    echo '<div class="space-y-' . $vertical_spacing . '">';
}
?>
```

### 3.3 Breadcrumb Customization

**Add to customizer:**

```php
// Breadcrumb Options
$wp_customize->add_setting('boldmcqspro_show_breadcrumbs', array(
    'default'           => true,
    'sanitize_callback' => 'wp_validate_boolean',
    'transport'         => 'refresh',
));

$wp_customize->add_control('boldmcqspro_show_breadcrumbs', array(
    'label'       => __('Show Breadcrumbs', 'boldmcqspro'),
    'section'     => 'boldmcqspro_homepage_layout',
    'type'        => 'checkbox',
));

$wp_customize->add_setting('boldmcqspro_breadcrumb_separator', array(
    'default'           => '/',
    'sanitize_callback' => 'sanitize_text_field',
));

$wp_customize->add_control('boldmcqspro_breadcrumb_separator', array(
    'label'       => __('Breadcrumb Separator', 'boldmcqspro'),
    'section'     => 'boldmcqspro_homepage_layout',
    'type'        => 'select',
    'choices'     => array(
        '/'  => __('/ (Slash)', 'boldmcqspro'),
        '>'  => __('> (Greater than)', 'boldmcqspro'),
        '→'  => __('→ (Arrow)', 'boldmcqspro'),
        '·'  => __('· (Dot)', 'boldmcqspro'),
    ),
));
```

### Phase 3 Deliverables
- [x] Homepage layout customizer section
- [x] Container width control
- [x] Sidebar position (left/right/none)
- [x] Sidebar width ratio
- [x] MCQ grid columns for full-width
- [x] Spacing controls (vertical, section padding)
- [x] Breadcrumb customization
-[x] `index.php` updated to use all layout options
- [x] Test all combinations

---

**(Continue with Phases 4-7 in next section...)**

## 📋 Summary of All 7 Phases

| Phase | Focus | Time | Priority | Complexity |
|-------|-------|------|----------|------------|
| 1. Foundation | Typography & Colors | 6-8h | 🔴 CRITICAL | ⭐⭐ Medium |
| 2. Header System | Logo, Buttons, Nav | 4-6h | 🔴 HIGH | ⭐ Low |
| 3. Content Layout | Spacing, Grid, Sidebar | 6-8h | 🟡 MEDIUM | ⭐⭐⭐ High |
| 4. MCQ Features | Questions, Options, Quiz | 8-10h | 🔴 HIGH | ⭐⭐⭐ High |
| 5. Single Pages | MCQ detail, Sharing | 4-6h | 🟡 MEDIUM | ⭐⭐ Medium |
| 6. Footer System | Layout, Widgets, Copyright | 3-4h | 🟢 LOW | ⭐ Low |
| 7. Polish & Advanced | Animations, Performance | 4-6h | 🟢 LOW | ⭐⭐ Medium |

**Total Time Estimate:** 35-48 hours (1-2 weeks of focused work)

---

## 🎯 Immediate Next Steps

### Option A: Start with Quick Wins (Recommended)
1. **Phase 1 - Typography** (6-8 hours)
   - Create `inc/typography.php`
   - See instant visual improvement
   - All font options working

2. **Phase 2 - Header Buttons** (2 hours)
   - Create `inc/header-helpers.php`
   - Update header.php
   - 3 custom buttons working

### Option B: Build Complete System
1. Work through all 7 phases sequentially
2. Test after each phase
3. Update documentation

---

## ✅ Verification Plan

After each phase:

1. **Visual Test in Customizer**
   - Open WordPress Customizer
   - Navigate to each new section
   - Change every setting
   - Verify live preview (where applicable)
   - Publish and check frontend

2. **Browser Testing**
   - Chrome (latest)
   - Firefox (latest)
   - Safari (latest)
   - Mobile responsive (use Chrome DevTools)

3. **Functionality Checklist**
   - [ ] All customizer options save correctly
   - [ ] Changes reflect on frontend
   - [ ] No PHP errors in debug log
   - [ ] No JavaScript console errors
   - [ ] Page load time < 3 seconds

4. **Code Quality**
   - [ ] All functions properly escaped (esc_html, esc_attr, esc_url)
   - [ ] All inputs sanitized
   - [ ] No inline styles without esc_attr()
   - [ ] Follows WordPress coding standards

---

## 📝 Implementation Checklist

**Pre-work:**
- [ ] Create backup of theme
- [ ] Enable WordPress debug mode
- [ ] Document current customizer state

**Phase 1:**
- [ ] Create `inc/typography.php`
- [ ] Add typography to `functions.php`
- [ ] Add enhanced colors to customizer
- [ ] Update header.php CSS variables
- [ ] Test all typography options
- [ ] Test all color options

**Phase 2:**
- [ ] Create `inc/header-helpers.php`
- [ ] Add to `functions.php`
- [ ] Update `header.php` buttons section
- [ ] Add header layout section to customizer
- [ ] Test sticky header
- [ ] Test all button styles

**Phase 3:**
- [ ] Add homepage layout section
- [ ] Update `index.php` grid system
- [ ] Update MCQ container logic
- [ ] Add breadcrumb options
- [ ] Test all layout combinations
- [ ] Test sidebar positions

---

## 🚀 Ready to Start?

**Recommended approach:**
1. ✅ Review this plan
2. ✅ Ask questions/request changes
3. ✅ I implement Phase 1 (Typography) first
4. ✅ You test and approve
5. ✅ Move to Phase 2, etc.

**Want me to start Phase 1 now?** 🎯
