<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '<?php echo boldmcqspro_get_option('boldmcqspro_primary_color', '#3B82F6'); ?>',
                        secondary: '<?php echo boldmcqspro_get_option('boldmcqspro_secondary_color', '#10B981'); ?>',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            <?php
            // Get customizer colors and convert hex to RGB
            $primary_hex = boldmcqspro_get_option('boldmcqspro_primary_color', '#3B82F6');
            $secondary_hex = boldmcqspro_get_option('boldmcqspro_secondary_color', '#10B981');
            ?>
            --color-primary: <?php echo boldmcqspro_hex_to_rgb($primary_hex); ?>;
            --color-secondary: <?php echo boldmcqspro_hex_to_rgb($secondary_hex); ?>;
        }

        /* Override theme classes with customizer colors - HIGH PRIORITY */
        body,
        .theme-blue,
        .theme-purple, 
        .theme-green,
        .theme-orange,
        .theme-pink {
            --color-primary: <?php echo boldmcqspro_hex_to_rgb($primary_hex); ?> !important;
            --color-secondary: <?php echo boldmcqspro_hex_to_rgb($secondary_hex); ?> !important;
        }
        
        /* Backup theme classes (will be overridden by customizer) */
        body:not(.customizer-colors) .theme-blue {
            --color-primary: 59, 130, 246;
            --color-secondary: 16, 185, 129;
        }

        body:not(.customizer-colors) .theme-purple {
            --color-primary: 147, 51, 234;
            --color-secondary: 236, 72, 153;
        }

        body:not(.customizer-colors) .theme-green {
            --color-primary: 34, 197, 94;
            --color-secondary: 6, 182, 212;
        }

        body:not(.customizer-colors) .theme-orange {
            --color-primary: 249, 115, 22;
            --color-secondary: 239, 68, 68;
        }

        body:not(.customizer-colors) .theme-pink {
            --color-primary: 236, 72, 153;
            --color-secondary: 168, 85, 247;
        }

        .bg-primary {
            background-color: rgb(var(--color-primary));
        }

        .text-primary {
            color: rgb(var(--color-primary));
        }

        .border-primary {
            border-color: rgb(var(--color-primary));
        }

        .hover\:bg-primary:hover {
            background-color: rgb(var(--color-primary));
        }

        .hover\:text-primary:hover {
            color: rgb(var(--color-primary));
        }

        .hover\:border-primary:hover {
            border-color: rgb(var(--color-primary));
        }

        /* Menu Styles based on Customizer Settings */
        <?php 
        $menu_style = boldmcqspro_get_option('boldmcqspro_menu_style', 'default');
        $menu_hover_effect = boldmcqspro_get_option('boldmcqspro_menu_hover_effect', 'underline');
        
        if ($menu_style === 'minimal') : ?>
        /* Minimal Menu Style */
        .main-navigation a {
            font-weight: 400 !important;
            padding: 0.5rem 0.75rem !important;
            border-radius: 0.25rem !important;
        }
        <?php endif; ?>
        
        <?php if ($menu_style === 'bold') : ?>
        /* Bold Menu Style */
        .main-navigation a {
            font-weight: 600 !important;
            padding: 0.75rem 1rem !important;
            border-radius: 0.5rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
        }
        <?php endif; ?>
        
        <?php if ($menu_hover_effect === 'underline') : ?>
        /* Underline Hover Effect */
        .main-navigation a:hover {
            text-decoration: underline !important;
            text-decoration-color: rgb(var(--color-primary)) !important;
            text-underline-offset: 4px !important;
        }
        <?php endif; ?>
        
        <?php if ($menu_hover_effect === 'background') : ?>
        /* Background Hover Effect */
        .main-navigation a:hover {
            background-color: rgb(var(--color-primary)) !important;
            color: white !important;
        }
        <?php endif; ?>
        
        <?php if ($menu_hover_effect === 'scale') : ?>
        /* Scale Hover Effect */
        .main-navigation a:hover {
            transform: scale(1.05) !important;
            transition: transform 0.2s ease-in-out !important;
        }
        <?php endif; ?>
        
        <?php if ($menu_hover_effect === 'none') : ?>
        /* No Hover Effect */
        .main-navigation a:hover {
            text-decoration: none !important;
            background-color: transparent !important;
            transform: none !important;
        }
        <?php endif; ?>

        .focus\:ring-primary:focus {
            --tw-ring-color: rgb(var(--color-primary));
        }

        .bg-secondary {
            background-color: rgb(var(--color-secondary));
        }

        .text-secondary {
            color: rgb(var(--color-secondary));
        }

        .border-secondary {
            border-color: rgb(var(--color-secondary));
        }



        .bg-primary\/5 {
            background-color: rgb(var(--color-primary) / 0.05);
        }

        .bg-primary\/10 {
            background-color: rgb(var(--color-primary) / 0.1);
        }

        .bg-secondary\/10 {
            background-color: rgb(var(--color-secondary) / 0.1);
        }

        .bg-secondary\/20 {
            background-color: rgb(var(--color-secondary) / 0.2);
        }



        .from-primary {
            --tw-gradient-from: rgb(var(--color-primary));
        }

        .to-secondary {
            --tw-gradient-to: rgb(var(--color-secondary));
        }

        .from-secondary {
            --tw-gradient-from: rgb(var(--color-secondary));
        }

        .to-primary {
            --tw-gradient-to: rgb(var(--color-primary));
        }



        .to-secondary\/20 {
            --tw-gradient-to: rgb(var(--color-secondary) / 0.2);
        }

        .theme-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* MCQ Option Colors - Customizable */
        .mcq-option,
        .mcq-option *,
        .mcq-option .flex-1,
        .mcq-option span {
            color: <?php echo boldmcqspro_get_option('boldmcqspro_mcq_option_text_color', '#FFFFFF'); ?> !important;
        }

        .dark .mcq-option,
        .dark .mcq-option *,
        .dark .mcq-option .flex-1,
        .dark .mcq-option span {
            color: <?php echo boldmcqspro_get_option('boldmcqspro_mcq_option_text_color', '#FFFFFF'); ?> !important;
        }

        .mcq-option:hover,
        .mcq-option:hover *,
        .mcq-option:hover .flex-1,
        .mcq-option:hover span {
            color: <?php echo boldmcqspro_get_option('boldmcqspro_mcq_option_text_color', '#FFFFFF'); ?> !important;
        }

        .dark .mcq-option:hover,
        .dark .mcq-option:hover *,
        .dark .mcq-option:hover .flex-1,
        .dark .mcq-option:hover span {
            color: <?php echo boldmcqspro_get_option('boldmcqspro_mcq_option_text_color', '#FFFFFF'); ?> !important;
        }

        /* MCQ Option Letters (A, B, C, D) */
        .practice-letter {
            <?php 
            $letter_color = boldmcqspro_get_option('boldmcqspro_mcq_option_letter_color', '');
            if (!empty($letter_color)) {
                echo 'color: ' . $letter_color . ' !important;';
            } else {
                echo 'color: rgb(var(--color-primary)) !important;';
            }
            ?>
        }

        /* Correct Answer Indicators */
        .correct-indicator {
            <?php 
            $correct_color = boldmcqspro_get_option('boldmcqspro_mcq_correct_color', '');
            if (!empty($correct_color)) {
                echo 'color: ' . $correct_color . ' !important;';
            } else {
                echo 'color: rgb(var(--color-secondary)) !important;';
            }
            ?>
        }

        /* MCQ Card Background */
        <?php if ($mcq_bg_color = boldmcqspro_get_option('boldmcqspro_mcq_background_color', '')) : ?>
        .mcq-card {
            background-color: <?php echo $mcq_bg_color; ?> !important;
        }
        <?php endif; ?>

        /* MCQ Card Border */
        <?php if ($mcq_border_color = boldmcqspro_get_option('boldmcqspro_mcq_border_color', '')) : ?>
        .mcq-card {
            border-color: <?php echo $mcq_border_color; ?> !important;
        }
        <?php endif; ?>

        /* MCQ Option Hover Background */
        <?php if ($mcq_hover_color = boldmcqspro_get_option('boldmcqspro_mcq_hover_color', '')) : ?>
        .mcq-option:hover {
            background-color: <?php echo $mcq_hover_color; ?> !important;
        }
        <?php endif; ?>

        /* Explanation Button Color */
        <?php if ($explanation_btn_color = boldmcqspro_get_option('boldmcqspro_explanation_btn_color', '')) : ?>
        .explanation-btn {
            background-color: <?php echo $explanation_btn_color; ?> !important;
        }
        <?php endif; ?>

        /* Quiz Mode Button Color */
        <?php if ($quiz_btn_color = boldmcqspro_get_option('boldmcqspro_quiz_btn_color', '')) : ?>
        .quiz-mode-btn {
            background-color: <?php echo $quiz_btn_color; ?> !important;
        }
        <?php endif; ?>

        /* === RESPONSIVE DESIGN === */
        
        /* Mobile First Approach - Base styles for mobile */
        @media (max-width: 640px) {
            /* Container adjustments */
            .max-w-7xl {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            /* MCQ Cards on mobile */
            .mcq-card {
                padding: 1rem !important;
                margin-bottom: 1rem !important;
                border-radius: 0.75rem !important;
            }
            
            .mcq-option {
                padding: 0.75rem !important;
                font-size: 0.9rem;
                flex-wrap: wrap;
            }
            
            .mcq-option .practice-letter {
                min-width: 1.5rem;
                font-size: 0.875rem;
            }
            
            /* Typography adjustments */
            h1 {
                font-size: 1.5rem !important;
                line-height: 2rem !important;
            }
            
            h3 {
                font-size: 1.125rem !important;
                line-height: 1.5rem !important;
            }
            
            /* Button adjustments */
            .btn, button {
                padding: 0.75rem 1rem !important;
                font-size: 0.875rem !important;
            }
            
            /* Quiz banner on mobile */
            #quizBanner {
                padding: 1rem !important;
                flex-direction: column;
                gap: 0.75rem;
            }
            
            #quizBanner .flex {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            /* Pagination on mobile */
            .pagination-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .pagination-numbers {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            /* Search input on mobile */
            .search-input {
                font-size: 16px !important; /* Prevents zoom on iOS */
            }
            
            /* Sticky sidebar adjustment */
            .sticky {
                position: static !important;
            }
        }
        
        /* Tablet styles */
        @media (min-width: 641px) and (max-width: 1024px) {
            .mcq-card {
                padding: 1.25rem !important;
            }
            
            .mcq-option {
                padding: 0.875rem !important;
            }
            
            /* Grid adjustments for tablet */
            .tablet-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            /* Sidebar on tablet */
            .sidebar-tablet {
                order: -1; /* Put sidebar before main content */
                margin-bottom: 2rem;
            }
        }
        
        /* Large mobile / small tablet landscape */
        @media (min-width: 641px) and (max-width: 768px) {
            .header-buttons {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            
            .header-buttons a, 
            .header-buttons button {
                padding: 0.5rem 1rem !important;
                font-size: 0.8rem !important;
            }
        }
        
        /* Desktop and larger screens */
        @media (min-width: 1025px) {
            /* Enhanced hover effects for desktop */
            .mcq-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }
            
            .mcq-option:hover {
                transform: translateX(4px);
            }
        }
        
        /* Print styles */
        @media print {
            .no-print,
            #quizModeBtn,
            #quizBanner,
            .sidebar,
            .pagination-container,
            button {
                display: none !important;
            }
            
            .mcq-card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
            
            .mcq-option {
                padding: 0.5rem !important;
                border: 1px solid #ccc !important;
            }
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .mcq-option {
                border-width: 2px !important;
            }
            
            .mcq-card {
                border-width: 2px !important;
            }
        }
        
        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            
            .mcq-card:hover,
            .mcq-option:hover {
                transform: none !important;
            }
        }
        
        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .mcq-option {
                min-height: 3rem; /* Larger touch targets */
                padding: 1rem !important;
            }
            
            button, .btn {
                min-height: 2.75rem;
                padding: 0.75rem 1.5rem !important;
            }
            
            /* Remove hover effects on touch devices */
            .mcq-option:hover {
                transform: none;
                border-color: inherit;
            }
        }
        
        /* Landscape phone adjustments */
        @media screen and (max-height: 500px) and (orientation: landscape) {
            .sticky {
                position: static !important;
            }
            
            .max-w-7xl {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
        }
    </style>
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-gray-50 dark:bg-gray-900 transition-colors duration-300 theme-blue theme-transition'); ?>>
    <!-- Header -->
    <header
        class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-md border-b dark:border-gray-700 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <?php get_template_part('template-parts/header/site-branding'); ?>
                <!-- Navigation -->
                <?php if (boldmcqspro_get_option('boldmcqspro_show_primary_menu', true)) : ?>
                <nav class="main-navigation hidden <?php echo boldmcqspro_get_option('boldmcqspro_mobile_menu_breakpoint', 'md'); ?>:flex items-center space-x-2">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'flex items-center space-x-2',
                            'container'      => false,
                            'depth'          => 2,
                            'walker'         => new BoldMcqsPro_Walker_Nav_Menu(),
                        ));
                    } else {
                        // Fallback menu when no menu is assigned
                        echo '<ul class="flex items-center space-x-2">';
                        echo '<li><a href="' . esc_url(home_url('/')) . '" class="text-gray-700 dark:text-gray-300 hover:text-primary transition-colors px-3 py-2 rounded-md text-sm font-medium">Home</a></li>';
                        if (get_post_type_archive_link('mcqs')) {
                            echo '<li><a href="' . esc_url(get_post_type_archive_link('mcqs')) . '" class="text-gray-700 dark:text-gray-300 hover:text-primary transition-colors px-3 py-2 rounded-md text-sm font-medium">MCQs</a></li>';
                        }
                        $mcq_categories = get_terms(array('taxonomy' => 'mcq_category', 'hide_empty' => true, 'number' => 3));
                        if ($mcq_categories && !is_wp_error($mcq_categories)) {
                            echo '<li class="relative group">';
                            echo '<a href="#" class="text-gray-700 dark:text-gray-300 hover:text-primary transition-colors px-3 py-2 rounded-md text-sm font-medium flex items-center">Categories <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></a>';
                            echo '<ul class="sub-menu absolute left-0 top-full mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">';
                            foreach ($mcq_categories as $category) {
                                echo '<li><a href="' . esc_url(get_term_link($category)) . '" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary transition-colors">' . esc_html($category->name) . '</a></li>';
                            }
                            echo '</ul></li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </nav>
                <?php endif; ?>
                <!-- Mobile Menu Button -->
                <?php if (boldmcqspro_get_option('boldmcqspro_show_mobile_menu', true)) : ?>
                <div class="<?php echo boldmcqspro_get_option('boldmcqspro_mobile_menu_breakpoint', 'md'); ?>:hidden">
                    <button id="mobileMenuToggle" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-primary hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary transition-colors">
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <?php endif; ?>

                <!-- CTA Buttons & Theme Toggle -->
                <div class="hidden md:flex items-center space-x-3">
                    <div class="relative">
                        <button id="themeToggle"
                            class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 text-amber-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                        <!-- Theme Dropdown -->
                        <div id="themeDropdown"
                            class="hidden absolute right-0 top-full mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 z-50">
                            <div class="p-2">
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 px-3 py-2">LIGHT/DARK
                                    MODE</div>
                                <button onclick="toggleLightDark()"
                                    class="w-full flex items-center space-x-3 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div id="modeIcon" class="w-4 h-4 text-amber-500 dark:text-blue-400">☀️</div>
                                    <span id="modeText" class="text-sm text-gray-700 dark:text-gray-300">Switch to
                                        Dark</span>
                                </button>
                                <div class="border-t dark:border-gray-600 my-2"></div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400 px-3 py-2">COLOR THEMES
                                </div>
                                <button onclick="setColorTheme('blue')"
                                    class="w-full flex items-center space-x-3 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Ocean Blue</span>
                                </button>
                                <button onclick="setColorTheme('purple')"
                                    class="w-full flex items-center space-x-3 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="w-4 h-4 rounded-full bg-purple-500"></div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Royal Purple</span>
                                </button>
                                <button onclick="setColorTheme('green')"
                                    class="w-full flex items-center space-x-3 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Forest Green</span>
                                </button>
                                <button onclick="setColorTheme('orange')"
                                    class="w-full flex items-center space-x-3 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="w-4 h-4 rounded-full bg-orange-500"></div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Sunset Orange</span>
                                </button>
                                <button onclick="setColorTheme('pink')"
                                    class="w-full flex items-center space-x-3 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="w-4 h-4 rounded-full bg-pink-500"></div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Cherry Pink</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if (boldmcqspro_get_option('boldmcqspro_show_auth_buttons', true)) : ?>
                        <?php if (is_user_logged_in()) : ?>
                            <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"
                                class="px-4 py-2 text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">Logout</a>
                            <a href="<?php echo esc_url(admin_url()); ?>"
                                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">Dashboard</a>
                        <?php else : ?>
                            <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>"
                                class="px-4 py-2 text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">Login</a>
                            <a href="<?php echo esc_url(wp_registration_url()); ?>"
                                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php 
                    $header_button_text = boldmcqspro_get_option('boldmcqspro_header_button_text', '');
                    $header_button_link = boldmcqspro_get_option('boldmcqspro_header_button_link', '');
                    if (!empty($header_button_text) && !empty($header_button_link)) : ?>
                        <a href="<?php echo esc_url($header_button_link); ?>"
                            class="px-4 py-2 bg-secondary text-white rounded-lg hover:bg-green-600 transition-colors"><?php echo esc_html($header_button_text); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <?php if (boldmcqspro_get_option('boldmcqspro_show_mobile_menu', true)) : ?>
    <div id="mobileMenu" class="hidden <?php echo boldmcqspro_get_option('boldmcqspro_mobile_menu_breakpoint', 'md'); ?>:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700 shadow-lg">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <?php
            if (has_nav_menu('mobile') || has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'theme_location' => has_nav_menu('mobile') ? 'mobile' : 'primary',
                    'menu_class'     => 'space-y-1',
                    'container'      => false,
                    'depth'          => 1,
                    'walker'         => new BoldMcqsPro_Mobile_Walker_Nav_Menu(),
                ));
            } else {
                // Fallback mobile menu when no menu is assigned
                echo '<div class="space-y-1">';
                echo '<a href="' . esc_url(home_url('/')) . '" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary transition-colors rounded-md">Home</a>';
                if (get_post_type_archive_link('mcqs')) {
                    echo '<a href="' . esc_url(get_post_type_archive_link('mcqs')) . '" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary transition-colors rounded-md">MCQs</a>';
                }
                $mcq_categories = get_terms(array('taxonomy' => 'mcq_category', 'hide_empty' => true, 'number' => 5));
                if ($mcq_categories && !is_wp_error($mcq_categories)) {
                    echo '<div class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categories</div>';
                    foreach ($mcq_categories as $category) {
                        echo '<a href="' . esc_url(get_term_link($category)) . '" class="block px-3 py-2 pl-6 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary transition-colors rounded-md">' . esc_html($category->name) . '</a>';
                    }
                }
                echo '</div>';
            }
            ?>
            
            <!-- Mobile Auth Buttons -->
            <?php if (boldmcqspro_get_option('boldmcqspro_show_auth_buttons', true)) : ?>
                <div class="pt-4 pb-2 border-t dark:border-gray-600 space-y-2">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(admin_url()); ?>" class="block w-full px-3 py-2 text-center bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">Dashboard</a>
                        <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="block w-full px-3 py-2 text-center text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">Logout</a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="block w-full px-3 py-2 text-center text-primary border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">Login</a>
                        <a href="<?php echo esc_url(wp_registration_url()); ?>" class="block w-full px-3 py-2 text-center bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors">Register</a>
                    <?php endif; ?>
                    
                    <?php 
                    $header_button_text = boldmcqspro_get_option('boldmcqspro_header_button_text', '');
                    $header_button_link = boldmcqspro_get_option('boldmcqspro_header_button_link', '');
                    if (!empty($header_button_text) && !empty($header_button_link)) : ?>
                        <a href="<?php echo esc_url($header_button_link); ?>" class="block w-full px-3 py-2 text-center bg-secondary text-white rounded-lg hover:bg-green-600 transition-colors"><?php echo esc_html($header_button_text); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
