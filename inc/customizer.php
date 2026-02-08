<?php
// Theme Customizer Settings
function boldmcqspro_customize_register($wp_customize) {
    
    // Brand/Logo Section
    $wp_customize->add_section('boldmcqspro_branding', array(
        'title'       => __('Site Branding', 'boldmcqspro'),
        'description' => __('Customize your site logo and branding', 'boldmcqspro'),
        'priority'    => 30,
    ));

    // Logo Upload
    $wp_customize->add_setting('boldmcqspro_logo', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'boldmcqspro_logo', array(
        'label'       => __('Upload Logo', 'boldmcqspro'),
        'section'     => 'boldmcqspro_branding',
        'settings'    => 'boldmcqspro_logo',
        'description' => __('Upload your site logo. Recommended size: 200x60px', 'boldmcqspro'),
    )));

    // Site Title Display
    $wp_customize->add_setting('boldmcqspro_show_site_title', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_site_title', array(
        'label'   => __('Show Site Title', 'boldmcqspro'),
        'section' => 'boldmcqspro_branding',
        'type'    => 'checkbox',
    ));

    // Header Section
    $wp_customize->add_section('boldmcqspro_header', array(
        'title'       => __('Header Settings', 'boldmcqspro'),
        'description' => __('Customize your header area', 'boldmcqspro'),
        'priority'    => 31,
    ));

    // Header Button Text
    $wp_customize->add_setting('boldmcqspro_header_button_text', array(
        'default'           => 'Get Started',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_header_button_text', array(
        'label'   => __('Header Button Text', 'boldmcqspro'),
        'section' => 'boldmcqspro_header',
        'type'    => 'text',
    ));

    // Header Button Link
    $wp_customize->add_setting('boldmcqspro_header_button_link', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_header_button_link', array(
        'label'   => __('Header Button Link', 'boldmcqspro'),
        'section' => 'boldmcqspro_header',
        'type'    => 'url',
    ));

    // Show Login/Register Buttons
    $wp_customize->add_setting('boldmcqspro_show_auth_buttons', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_auth_buttons', array(
        'label'   => __('Show Login/Register Buttons', 'boldmcqspro'),
        'section' => 'boldmcqspro_header',
        'type'    => 'checkbox',
    ));

    // Navigation Menu Section
    $wp_customize->add_section('boldmcqspro_navigation', array(
        'title'       => __('Navigation Menu', 'boldmcqspro'),
        'description' => __('Customize your navigation menu settings', 'boldmcqspro'),
        'priority'    => 32,
    ));

    // Show Primary Menu
    $wp_customize->add_setting('boldmcqspro_show_primary_menu', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_primary_menu', array(
        'label'       => __('Show Primary Menu', 'boldmcqspro'),
        'section'     => 'boldmcqspro_navigation',
        'type'        => 'checkbox',
        'description' => __('Display the primary navigation menu in the header', 'boldmcqspro'),
    ));

    // Menu Style
    $wp_customize->add_setting('boldmcqspro_menu_style', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_menu_style', array(
        'label'       => __('Menu Style', 'boldmcqspro'),
        'section'     => 'boldmcqspro_navigation',
        'type'        => 'select',
        'choices'     => array(
            'default' => __('Default Style', 'boldmcqspro'),
            'minimal' => __('Minimal Style', 'boldmcqspro'),
            'bold'    => __('Bold Style', 'boldmcqspro'),
        ),
        'description' => __('Choose the visual style for your navigation menu', 'boldmcqspro'),
    ));

    // Menu Hover Effect
    $wp_customize->add_setting('boldmcqspro_menu_hover_effect', array(
        'default'           => 'underline',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_menu_hover_effect', array(
        'label'       => __('Menu Hover Effect', 'boldmcqspro'),
        'section'     => 'boldmcqspro_navigation',
        'type'        => 'select',
        'choices'     => array(
            'underline' => __('Underline', 'boldmcqspro'),
            'background' => __('Background Color', 'boldmcqspro'),
            'scale'     => __('Scale', 'boldmcqspro'),
            'none'      => __('None', 'boldmcqspro'),
        ),
        'description' => __('Choose the hover effect for menu items', 'boldmcqspro'),
    ));

    // Show Mobile Menu
    $wp_customize->add_setting('boldmcqspro_show_mobile_menu', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_mobile_menu', array(
        'label'       => __('Show Mobile Menu', 'boldmcqspro'),
        'section'     => 'boldmcqspro_navigation',
        'type'        => 'checkbox',
        'description' => __('Display mobile menu toggle button on smaller screens', 'boldmcqspro'),
    ));

    // Mobile Menu Breakpoint
    $wp_customize->add_setting('boldmcqspro_mobile_menu_breakpoint', array(
        'default'           => 'md',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_mobile_menu_breakpoint', array(
        'label'       => __('Mobile Menu Breakpoint', 'boldmcqspro'),
        'section'     => 'boldmcqspro_navigation',
        'type'        => 'select',
        'choices'     => array(
            'sm' => __('Small (640px)', 'boldmcqspro'),
            'md' => __('Medium (768px)', 'boldmcqspro'),
            'lg' => __('Large (1024px)', 'boldmcqspro'),
        ),
        'description' => __('Screen size at which mobile menu becomes active', 'boldmcqspro'),
    ));

    // Footer Section
    $wp_customize->add_section('boldmcqspro_footer', array(
        'title'       => __('Footer Settings', 'boldmcqspro'),
        'description' => __('Customize your footer area', 'boldmcqspro'),
        'priority'    => 32,
    ));

    // Footer Column Count
    $wp_customize->add_setting('boldmcqspro_footer_columns', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_footer_columns', array(
        'label'   => __('Footer Columns', 'boldmcqspro'),
        'section' => 'boldmcqspro_footer',
        'type'    => 'select',
        'choices' => array(
            1 => __('1 Column', 'boldmcqspro'),
            2 => __('2 Columns', 'boldmcqspro'),
            3 => __('3 Columns', 'boldmcqspro'),
            4 => __('4 Columns', 'boldmcqspro'),
        ),
    ));

    // Footer Copyright Text
    $wp_customize->add_setting('boldmcqspro_footer_copyright', array(
        'default'           => '© 2025 BoldMcqs Pro. All rights reserved.',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_footer_copyright', array(
        'label'   => __('Copyright Text', 'boldmcqspro'),
        'section' => 'boldmcqspro_footer',
        'type'    => 'textarea',
    ));

    // Colors Section
    $wp_customize->add_section('boldmcqspro_colors', array(
        'title'       => __('🎨 Theme Colors', 'boldmcqspro'),
        'description' => __('Customize all theme colors including MCQ-specific colors', 'boldmcqspro'),
        'priority'    => 40,
    ));

    // === MAIN THEME COLORS ===
    
    // Primary Color
    $wp_customize->add_setting('boldmcqspro_primary_color', array(
        'default'           => '#3B82F6',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_primary_color', array(
        'label'       => __('🔵 Primary Color', 'boldmcqspro'),
        'description' => __('Main brand color used for buttons, links, and highlights', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));

    // Secondary Color
    $wp_customize->add_setting('boldmcqspro_secondary_color', array(
        'default'           => '#10B981',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_secondary_color', array(
        'label'       => __('🟢 Secondary Color', 'boldmcqspro'),
        'description' => __('Secondary color for success states and call-to-action elements', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));



    // === MCQ SPECIFIC COLORS ===
    
    // MCQ Option Text Color
    $wp_customize->add_setting('boldmcqspro_mcq_option_text_color', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_mcq_option_text_color', array(
        'label'       => __('📝 MCQ Option Text Color', 'boldmcqspro'),
        'description' => __('Text color for MCQ answer options (A, B, C, D text)', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));

    // MCQ Option Letter Color (A, B, C, D)
    $wp_customize->add_setting('boldmcqspro_mcq_option_letter_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_mcq_option_letter_color', array(
        'label'       => __('🔤 MCQ Option Letters Color', 'boldmcqspro'),
        'description' => __('Color for option letters (A, B, C, D). Leave empty to use Primary Color.', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));

    // MCQ Correct Answer Indicator Color
    $wp_customize->add_setting('boldmcqspro_mcq_correct_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_mcq_correct_color', array(
        'label'       => __('✅ Correct Answer Color', 'boldmcqspro'),
        'description' => __('Color for correct answer indicators. Leave empty to use Secondary Color.', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));

    // MCQ Background Colors
    $wp_customize->add_setting('boldmcqspro_mcq_background_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_mcq_background_color', array(
        'label'       => __('🎨 MCQ Card Background', 'boldmcqspro'),
        'description' => __('Background color for MCQ cards. Leave empty for default theme background.', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));

    // MCQ Border Color
    $wp_customize->add_setting('boldmcqspro_mcq_border_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_mcq_border_color', array(
        'label'       => __('🔳 MCQ Card Border Color', 'boldmcqspro'),
        'description' => __('Border color for MCQ cards. Leave empty for default gray borders.', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));

    // MCQ Hover State Color
    $wp_customize->add_setting('boldmcqspro_mcq_hover_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_mcq_hover_color', array(
        'label'       => __('🖱️ MCQ Option Hover Color', 'boldmcqspro'),
        'description' => __('Background color when hovering over MCQ options. Leave empty for default.', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));

    // === BUTTON COLORS ===
    
    // Show Explanation Button Color
    $wp_customize->add_setting('boldmcqspro_explanation_btn_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_explanation_btn_color', array(
        'label'       => __('🔍 Explanation Button Color', 'boldmcqspro'),
        'description' => __('Color for "Show Explanation" buttons. Leave empty to use Accent Color.', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));

    // Quiz Mode Button Color
    $wp_customize->add_setting('boldmcqspro_quiz_btn_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'boldmcqspro_quiz_btn_color', array(
        'label'       => __('🎯 Quiz Mode Button Color', 'boldmcqspro'),
        'description' => __('Color for "Start Quiz Mode" button. Leave empty to use Primary Color.', 'boldmcqspro'),
        'section'     => 'boldmcqspro_colors',
    )));

    // Homepage MCQs Loop Section
    $wp_customize->add_section('boldmcqspro_homepage_mcqs', array(
        'title'       => __('🏠 Homepage MCQs Loop', 'boldmcqspro'),
        'description' => __('Customize how MCQs are displayed on your homepage', 'boldmcqspro'),
        'priority'    => 50,
    ));
    
    // === HOMEPAGE MCQS LOOP SETTINGS ===
    
    // Homepage MCQs Title
    $wp_customize->add_setting('boldmcqspro_homepage_mcqs_title', array(
        'default'           => 'Practice Questions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_homepage_mcqs_title', array(
        'label'       => __('📝 Homepage MCQs Section Title', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'text',
        'description' => __('Change the main title shown above MCQs list', 'boldmcqspro'),
    ));
    
    // MCQs Per Page (Homepage)
    $wp_customize->add_setting('boldmcqspro_homepage_mcqs_per_page', array(
        'default'           => 10,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_homepage_mcqs_per_page', array(
        'label'       => __('📊 MCQs Per Page', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'number',
        'description' => __('Number of MCQs to display per page', 'boldmcqspro'),
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 100,
            'step' => 1,
        ),
    ));
    
    // MCQs Order By
    $wp_customize->add_setting('boldmcqspro_homepage_mcqs_orderby', array(
        'default'           => 'date',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_homepage_mcqs_orderby', array(
        'label'       => __('📅 Order MCQs By', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'select',
        'description' => __('Choose how to order MCQs on homepage', 'boldmcqspro'),
        'choices'     => array(
            'date'          => __('📅 Date (Newest First)', 'boldmcqspro'),
            'title'         => __('🔤 Title (A-Z)', 'boldmcqspro'),
            'rand'          => __('🎲 Random', 'boldmcqspro'),
            'comment_count' => __('💬 Most Discussed', 'boldmcqspro'),
            'menu_order'    => __('📋 Custom Order', 'boldmcqspro'),
        ),
    ));
    
    // MCQs Order (ASC/DESC)
    $wp_customize->add_setting('boldmcqspro_homepage_mcqs_order', array(
        'default'           => 'DESC',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_homepage_mcqs_order', array(
        'label'       => __('🔄 Sort Direction', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'select',
        'description' => __('Choose sort direction', 'boldmcqspro'),
        'choices'     => array(
            'DESC' => __('⬇️ Descending (High to Low)', 'boldmcqspro'),
            'ASC'  => __('⬆️ Ascending (Low to High)', 'boldmcqspro'),
        ),
    ));
    
    // Filter by Specific Category
    $wp_customize->add_setting('boldmcqspro_homepage_mcqs_category', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    // Get MCQ categories for dropdown
    $mcq_categories = get_terms(array(
        'taxonomy'   => 'mcq_category',
        'hide_empty' => false,
    ));
    
    $category_choices = array('' => __('🌐 All Categories', 'boldmcqspro'));
    if (!empty($mcq_categories) && !is_wp_error($mcq_categories)) {
        foreach ($mcq_categories as $category) {
            $category_choices[$category->slug] = '📂 ' . $category->name . ' (' . $category->count . ')';
        }
    }
    
    $wp_customize->add_control('boldmcqspro_homepage_mcqs_category', array(
        'label'       => __('📂 Filter by Category', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'select',
        'description' => __('Show only MCQs from specific category', 'boldmcqspro'),
        'choices'     => $category_choices,
    ));
    
    // Show Quiz Mode Button
    $wp_customize->add_setting('boldmcqspro_show_quiz_mode_btn', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_show_quiz_mode_btn', array(
        'label'       => __('🎯 Show Quiz Mode Button', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'checkbox',
        'description' => __('Display the "Start Quiz Mode" button', 'boldmcqspro'),
    ));
    
    // Show Search Box
    $wp_customize->add_setting('boldmcqspro_show_search_box', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_show_search_box', array(
        'label'       => __('🔍 Show Search Box', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'checkbox',
        'description' => __('Display search box in sidebar', 'boldmcqspro'),
    ));
    
    // Show Top Contributors
    $wp_customize->add_setting('boldmcqspro_show_top_contributors', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_show_top_contributors', array(
        'label'       => __('🏆 Show Top Contributors', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'checkbox',
        'description' => __('Display top contributors widget in sidebar', 'boldmcqspro'),
    ));
    
    // Show Categories Widget
    $wp_customize->add_setting('boldmcqspro_show_categories_widget', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_show_categories_widget', array(
        'label'       => __('📂 Show Categories Widget', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'checkbox',
        'description' => __('Display categories widget in sidebar', 'boldmcqspro'),
    ));
    
    // MCQ Card Layout Style
    $wp_customize->add_setting('boldmcqspro_mcq_card_style', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_mcq_card_style', array(
        'label'       => __('🎨 MCQ Card Style', 'boldmcqspro'),
        'section'     => 'boldmcqspro_homepage_mcqs',
        'type'        => 'select',
        'description' => __('Choose the visual style of MCQ cards', 'boldmcqspro'),
        'choices'     => array(
            'default'  => __('🔷 Default (Rounded with Shadow)', 'boldmcqspro'),
            'minimal'  => __('⬜ Minimal (Clean & Simple)', 'boldmcqspro'),
            'bordered' => __('🔳 Bordered (Classic Look)', 'boldmcqspro'),
            'gradient' => __('🌈 Gradient (Modern Style)', 'boldmcqspro'),
        ),
    ));
    
    // MCQ Settings Section (General Settings)
    $wp_customize->add_section('boldmcqspro_mcq_settings', array(
        'title'       => __('⚙️ MCQ General Settings', 'boldmcqspro'),
        'description' => __('Global MCQ display and functionality settings', 'boldmcqspro'),
        'priority'    => 51,
    ));
    
    // === ARCHIVE & GENERAL DISPLAY SETTINGS ===
    
    // Default MCQs Per Page (for archives, single posts, etc.)
    $wp_customize->add_setting('boldmcqspro_mcqs_per_page', array(
        'default'           => 10,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_mcqs_per_page', array(
        'label'       => __('📄 Default MCQs Per Page', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'number',
        'description' => __('Default number of MCQs per page (archive pages, search results)', 'boldmcqspro'),
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 100,
            'step' => 1,
        ),
    ));
    
    // === MCQ CONTENT DISPLAY SETTINGS ===

    // Show Explanations by Default
    $wp_customize->add_setting('boldmcqspro_show_explanations', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_explanations', array(
        'label'       => __('💡 Show Explanations by Default', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'checkbox',
        'description' => __('Show explanation text without clicking "Show Explanation" button', 'boldmcqspro'),
    ));
    
    // Show Explanation Button
    $wp_customize->add_setting('boldmcqspro_show_explanation_btn', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_explanation_btn', array(
        'label'       => __('🔍 Show Explanation Button', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'checkbox',
        'description' => __('Display "Show Explanation" toggle button for each MCQ', 'boldmcqspro'),
    ));

    // Show Author Info
    $wp_customize->add_setting('boldmcqspro_show_author', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_author', array(
        'label'       => __('👤 Show Author Information', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'checkbox',
        'description' => __('Display the author name who created the MCQ', 'boldmcqspro'),
    ));

    // Show Category Tags
    $wp_customize->add_setting('boldmcqspro_show_categories', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_categories', array(
        'label'       => __('📂 Show Category Tags', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'checkbox',
        'description' => __('Display category badges for each MCQ', 'boldmcqspro'),
    ));
    
    // Show Date Information
    $wp_customize->add_setting('boldmcqspro_show_date', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_date', array(
        'label'       => __('📅 Show Publication Date', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'checkbox',
        'description' => __('Display when the MCQ was published', 'boldmcqspro'),
    ));
    
    // === MCQ INTERACTION SETTINGS ===
    
    // Enable MCQ Links
    $wp_customize->add_setting('boldmcqspro_enable_mcq_links', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_enable_mcq_links', array(
        'label'       => __('🔗 Enable MCQ Title Links', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'checkbox',
        'description' => __('Allow clicking on MCQ titles to view single MCQ page', 'boldmcqspro'),
    ));
    
    // MCQ Numbering
    $wp_customize->add_setting('boldmcqspro_show_mcq_numbers', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_mcq_numbers', array(
        'label'       => __('🔢 Show MCQ Numbers', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'checkbox',
        'description' => __('Display question numbers (Q1, Q2, Q3...) before each MCQ', 'boldmcqspro'),
    ));
    
    // === DIFFICULTY & CATEGORY DISPLAY ===
    
    // Show Difficulty Level
    $wp_customize->add_setting('boldmcqspro_show_difficulty', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_show_difficulty', array(
        'label'       => __('🎚️ Show Difficulty Level', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'checkbox',
        'description' => __('Display difficulty badges (Easy, Medium, Hard)', 'boldmcqspro'),
    ));
    
    // Default Difficulty Level
    $wp_customize->add_setting('boldmcqspro_default_difficulty', array(
        'default'           => 'medium',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('boldmcqspro_default_difficulty', array(
        'label'       => __('🎯 Default Difficulty Level', 'boldmcqspro'),
        'section'     => 'boldmcqspro_mcq_settings',
        'type'        => 'select',
        'description' => __('Default difficulty when not specified', 'boldmcqspro'),
        'choices'     => array(
            'easy'   => __('🟢 Easy', 'boldmcqspro'),
            'medium' => __('🟡 Medium', 'boldmcqspro'),
            'hard'   => __('🔴 Hard', 'boldmcqspro'),
        ),
    ));
    
    // === TYPOGRAPHY SECTION ===
    $wp_customize->add_section('boldmcqspro_typography', array(
        'title'       => __('🔤 Typography & Fonts', 'boldmcqspro'),
        'description' => __('Customize fonts and typography for your theme', 'boldmcqspro'),
        'priority'    => 52,
    ));
    
    // === PRIMARY FONT (HEADINGS) ===
    
    // Primary Font Family (for headings, titles)
    $wp_customize->add_setting('boldmcqspro_primary_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_primary_font', array(
        'label'       => __('📝 Primary Font (Headings)', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'select',
        'description' => __('Font for headings, titles, and site branding', 'boldmcqspro'),
        'choices'     => array(
            // Sans-Serif Fonts
            'Inter'         => __('Inter (Modern Sans-Serif)', 'boldmcqspro'),
            'Poppins'       => __('Poppins (Rounded Sans-Serif)', 'boldmcqspro'),
            'Roboto'        => __('Roboto (Clean Sans-Serif)', 'boldmcqspro'),
            'Open Sans'     => __('Open Sans (Friendly Sans-Serif)', 'boldmcqspro'),
            'Lato'          => __('Lato (Humanist Sans-Serif)', 'boldmcqspro'),
            'Montserrat'    => __('Montserrat (Geometric Sans-Serif)', 'boldmcqspro'),
            'Nunito'        => __('Nunito (Rounded Sans-Serif)', 'boldmcqspro'),
            'Source Sans Pro' => __('Source Sans Pro (Adobe Sans-Serif)', 'boldmcqspro'),
            'Raleway'       => __('Raleway (Elegant Sans-Serif)', 'boldmcqspro'),
            'Ubuntu'        => __('Ubuntu (Canonical Sans-Serif)', 'boldmcqspro'),
            // Serif Fonts
            'Playfair Display' => __('Playfair Display (Elegant Serif)', 'boldmcqspro'),
            'Merriweather'  => __('Merriweather (Reading Serif)', 'boldmcqspro'),
            'Crimson Text'  => __('Crimson Text (Classic Serif)', 'boldmcqspro'),
            'Lora'          => __('Lora (Modern Serif)', 'boldmcqspro'),
            'PT Serif'      => __('PT Serif (Traditional Serif)', 'boldmcqspro'),
            // Monospace Fonts
            'JetBrains Mono' => __('JetBrains Mono (Developer Mono)', 'boldmcqspro'),
            'Fira Code'     => __('Fira Code (Programming Mono)', 'boldmcqspro'),
            'Source Code Pro' => __('Source Code Pro (Adobe Mono)', 'boldmcqspro'),
            // System Fonts
            'system-ui'     => __('System UI (Native System Font)', 'boldmcqspro'),
            'Arial'         => __('Arial (Classic Sans-Serif)', 'boldmcqspro'),
            'Georgia'       => __('Georgia (Web Serif)', 'boldmcqspro'),
            'Times New Roman' => __('Times New Roman (Traditional Serif)', 'boldmcqspro'),
        ),
    ));
    
    // Primary Font Weight
    $wp_customize->add_setting('boldmcqspro_primary_font_weight', array(
        'default'           => '600',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_primary_font_weight', array(
        'label'       => __('⚖️ Primary Font Weight', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'select',
        'description' => __('Font weight for headings and titles', 'boldmcqspro'),
        'choices'     => array(
            '300' => __('Light (300)', 'boldmcqspro'),
            '400' => __('Normal (400)', 'boldmcqspro'),
            '500' => __('Medium (500)', 'boldmcqspro'),
            '600' => __('Semi Bold (600)', 'boldmcqspro'),
            '700' => __('Bold (700)', 'boldmcqspro'),
            '800' => __('Extra Bold (800)', 'boldmcqspro'),
            '900' => __('Black (900)', 'boldmcqspro'),
        ),
    ));
    
    // === SECONDARY FONT (BODY TEXT) ===
    
    // Secondary Font Family (for body text)
    $wp_customize->add_setting('boldmcqspro_secondary_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_secondary_font', array(
        'label'       => __('📖 Secondary Font (Body Text)', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'select',
        'description' => __('Font for body text, paragraphs, and general content', 'boldmcqspro'),
        'choices'     => array(
            // Sans-Serif Fonts
            'Inter'         => __('Inter (Modern Sans-Serif)', 'boldmcqspro'),
            'Poppins'       => __('Poppins (Rounded Sans-Serif)', 'boldmcqspro'),
            'Roboto'        => __('Roboto (Clean Sans-Serif)', 'boldmcqspro'),
            'Open Sans'     => __('Open Sans (Friendly Sans-Serif)', 'boldmcqspro'),
            'Lato'          => __('Lato (Humanist Sans-Serif)', 'boldmcqspro'),
            'Montserrat'    => __('Montserrat (Geometric Sans-Serif)', 'boldmcqspro'),
            'Nunito'        => __('Nunito (Rounded Sans-Serif)', 'boldmcqspro'),
            'Source Sans Pro' => __('Source Sans Pro (Adobe Sans-Serif)', 'boldmcqspro'),
            'Raleway'       => __('Raleway (Elegant Sans-Serif)', 'boldmcqspro'),
            'Ubuntu'        => __('Ubuntu (Canonical Sans-Serif)', 'boldmcqspro'),
            // Serif Fonts
            'Playfair Display' => __('Playfair Display (Elegant Serif)', 'boldmcqspro'),
            'Merriweather'  => __('Merriweather (Reading Serif)', 'boldmcqspro'),
            'Crimson Text'  => __('Crimson Text (Classic Serif)', 'boldmcqspro'),
            'Lora'          => __('Lora (Modern Serif)', 'boldmcqspro'),
            'PT Serif'      => __('PT Serif (Traditional Serif)', 'boldmcqspro'),
            // System Fonts
            'system-ui'     => __('System UI (Native System Font)', 'boldmcqspro'),
            'Arial'         => __('Arial (Classic Sans-Serif)', 'boldmcqspro'),
            'Georgia'       => __('Georgia (Web Serif)', 'boldmcqspro'),
            'Times New Roman' => __('Times New Roman (Traditional Serif)', 'boldmcqspro'),
        ),
    ));
    
    // Secondary Font Weight
    $wp_customize->add_setting('boldmcqspro_secondary_font_weight', array(
        'default'           => '400',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_secondary_font_weight', array(
        'label'       => __('⚖️ Secondary Font Weight', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'select',
        'description' => __('Font weight for body text and paragraphs', 'boldmcqspro'),
        'choices'     => array(
            '300' => __('Light (300)', 'boldmcqspro'),
            '400' => __('Normal (400)', 'boldmcqspro'),
            '500' => __('Medium (500)', 'boldmcqspro'),
            '600' => __('Semi Bold (600)', 'boldmcqspro'),
            '700' => __('Bold (700)', 'boldmcqspro'),
        ),
    ));
    
    // === MCQ-SPECIFIC FONTS ===
    
    // MCQ Question Font
    $wp_customize->add_setting('boldmcqspro_mcq_question_font', array(
        'default'           => 'same_as_primary',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_mcq_question_font', array(
        'label'       => __('❓ MCQ Question Font', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'select',
        'description' => __('Font specifically for MCQ questions', 'boldmcqspro'),
        'choices'     => array(
            'same_as_primary' => __('Same as Primary Font', 'boldmcqspro'),
            'same_as_secondary' => __('Same as Secondary Font', 'boldmcqspro'),
            // Sans-Serif Fonts
            'Inter'         => __('Inter (Modern Sans-Serif)', 'boldmcqspro'),
            'Poppins'       => __('Poppins (Rounded Sans-Serif)', 'boldmcqspro'),
            'Roboto'        => __('Roboto (Clean Sans-Serif)', 'boldmcqspro'),
            'Open Sans'     => __('Open Sans (Friendly Sans-Serif)', 'boldmcqspro'),
            'Lato'          => __('Lato (Humanist Sans-Serif)', 'boldmcqspro'),
            'Montserrat'    => __('Montserrat (Geometric Sans-Serif)', 'boldmcqspro'),
            'Source Sans Pro' => __('Source Sans Pro (Adobe Sans-Serif)', 'boldmcqspro'),
        ),
    ));
    
    // MCQ Options Font
    $wp_customize->add_setting('boldmcqspro_mcq_options_font', array(
        'default'           => 'same_as_secondary',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_mcq_options_font', array(
        'label'       => __('🔤 MCQ Options Font', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'select',
        'description' => __('Font for MCQ answer options (A, B, C, D)', 'boldmcqspro'),
        'choices'     => array(
            'same_as_primary' => __('Same as Primary Font', 'boldmcqspro'),
            'same_as_secondary' => __('Same as Secondary Font', 'boldmcqspro'),
            // Sans-Serif Fonts
            'Inter'         => __('Inter (Modern Sans-Serif)', 'boldmcqspro'),
            'Poppins'       => __('Poppins (Rounded Sans-Serif)', 'boldmcqspro'),
            'Roboto'        => __('Roboto (Clean Sans-Serif)', 'boldmcqspro'),
            'Open Sans'     => __('Open Sans (Friendly Sans-Serif)', 'boldmcqspro'),
            'Lato'          => __('Lato (Humanist Sans-Serif)', 'boldmcqspro'),
            'Montserrat'    => __('Montserrat (Geometric Sans-Serif)', 'boldmcqspro'),
            'Source Sans Pro' => __('Source Sans Pro (Adobe Sans-Serif)', 'boldmcqspro'),
        ),
    ));
    
    // === FONT SIZES ===
    
    // Base Font Size
    $wp_customize->add_setting('boldmcqspro_base_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_base_font_size', array(
        'label'       => __('📏 Base Font Size', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'range',
        'description' => __('Base font size in pixels (affects all other sizes)', 'boldmcqspro'),
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));
    
    // MCQ Question Font Size
    $wp_customize->add_setting('boldmcqspro_mcq_question_size', array(
        'default'           => '18',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_mcq_question_size', array(
        'label'       => __('❓ MCQ Question Font Size', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'range',
        'description' => __('Font size for MCQ questions in pixels', 'boldmcqspro'),
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 28,
            'step' => 1,
        ),
    ));
    
    // MCQ Options Font Size
    $wp_customize->add_setting('boldmcqspro_mcq_options_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_mcq_options_size', array(
        'label'       => __('🔤 MCQ Options Font Size', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'range',
        'description' => __('Font size for MCQ answer options in pixels', 'boldmcqspro'),
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));
    
    // === ADVANCED TYPOGRAPHY OPTIONS ===
    
    // Line Height
    $wp_customize->add_setting('boldmcqspro_line_height', array(
        'default'           => '1.6',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_line_height', array(
        'label'       => __('📐 Line Height', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'select',
        'description' => __('Line spacing for better readability', 'boldmcqspro'),
        'choices'     => array(
            '1.2' => __('Tight (1.2)', 'boldmcqspro'),
            '1.4' => __('Snug (1.4)', 'boldmcqspro'),
            '1.6' => __('Normal (1.6)', 'boldmcqspro'),
            '1.8' => __('Relaxed (1.8)', 'boldmcqspro'),
            '2.0' => __('Loose (2.0)', 'boldmcqspro'),
        ),
    ));
    
    // Letter Spacing
    $wp_customize->add_setting('boldmcqspro_letter_spacing', array(
        'default'           => 'normal',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_letter_spacing', array(
        'label'       => __('🔤 Letter Spacing', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'select',
        'description' => __('Spacing between letters', 'boldmcqspro'),
        'choices'     => array(
            'tighter' => __('Tighter (-0.05em)', 'boldmcqspro'),
            'tight'   => __('Tight (-0.025em)', 'boldmcqspro'),
            'normal'  => __('Normal (0)', 'boldmcqspro'),
            'wide'    => __('Wide (0.025em)', 'boldmcqspro'),
            'wider'   => __('Wider (0.05em)', 'boldmcqspro'),
            'widest'  => __('Widest (0.1em)', 'boldmcqspro'),
        ),
    ));
    
    // Enable Google Fonts
    $wp_customize->add_setting('boldmcqspro_enable_google_fonts', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('boldmcqspro_enable_google_fonts', array(
        'label'       => __('🌐 Load Google Fonts', 'boldmcqspro'),
        'section'     => 'boldmcqspro_typography',
        'type'        => 'checkbox',
        'description' => __('Automatically load selected Google Fonts (disable to use system fonts only)', 'boldmcqspro'),
    ));
}
add_action('customize_register', 'boldmcqspro_customize_register');

// Helper function to get customizer options
function boldmcqspro_get_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}

// Helper function to convert hex color to RGB
function boldmcqspro_hex_to_rgb($hex) {
    $hex = str_replace('#', '', $hex);
    
    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    
    return "$r, $g, $b";
}

// Customizer live preview JavaScript
function boldmcqspro_customize_preview_js() {
    wp_enqueue_script(
        'boldmcqspro-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js',
        array('customize-preview'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'boldmcqspro_customize_preview_js');
