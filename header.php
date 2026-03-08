<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <style id="boldmcqspro-responsive">

        /* === Menu Styles (from Customizer) === */
        <?php
        $menu_style       = boldmcqspro_get_option('boldmcqspro_menu_style', 'default');
        $menu_hover_effect = boldmcqspro_get_option('boldmcqspro_menu_hover_effect', 'underline');
        if ($menu_style === 'minimal') : ?>
        .main-navigation a { font-weight:400 !important; padding:.5rem .75rem !important; border-radius:.25rem !important; }
        <?php endif; ?>
        <?php if ($menu_style === 'bold') : ?>
        .main-navigation a { font-weight:600 !important; padding:.75rem 1rem !important; border-radius:.5rem !important; text-transform:uppercase !important; letter-spacing:.05em !important; }
        <?php endif; ?>
        <?php if ($menu_hover_effect === 'underline') : ?>
        .main-navigation a:hover { text-decoration:underline !important; text-decoration-color:rgb(var(--cp)) !important; text-underline-offset:4px !important; }
        <?php endif; ?>
        <?php if ($menu_hover_effect === 'background') : ?>
        .main-navigation a:hover { background-color:rgb(var(--cp)) !important; color:#fff !important; }
        <?php endif; ?>
        <?php if ($menu_hover_effect === 'scale') : ?>
        .main-navigation a:hover { transform:scale(1.05) !important; transition:transform .2s ease-in-out !important; }
        <?php endif; ?>
        <?php if ($menu_hover_effect === 'none') : ?>
        .main-navigation a:hover { text-decoration:none !important; background-color:transparent !important; transform:none !important; }
        <?php endif; ?>

        .theme-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }


        
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

<?php
// --- Header layout settings ---
$sticky_header = boldmcqspro_get_option('boldmcqspro_sticky_header', true);
$header_height = absint(boldmcqspro_get_option('boldmcqspro_header_height', 64));
$header_bg     = boldmcqspro_get_option('boldmcqspro_header_bg', '');
$header_shadow = sanitize_text_field(boldmcqspro_get_option('boldmcqspro_header_shadow', 'md'));

$header_position    = $sticky_header ? 'sticky top-0 z-50' : 'relative';
$header_shadow_class = $header_shadow === 'none' ? '' : 'shadow-' . $header_shadow;
$header_style        = $header_bg ? 'background-color:' . esc_attr($header_bg) . ';' : '';
?>
<body <?php body_class('bg-gray-50 dark:bg-gray-900 transition-colors duration-300 theme-blue theme-transition'); ?>>
    <!-- Header -->
    <header
        class="<?php echo esc_attr($header_position); ?> bg-white dark:bg-gray-800 <?php echo esc_attr($header_shadow_class); ?> border-b dark:border-gray-700 transition-colors duration-300"
        style="<?php echo $header_style; ?>">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center" style="height:<?php echo $header_height; ?>px;">
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

                <!-- CTA Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    <?php echo boldmcqspro_render_auth_buttons(); ?>
                    <?php echo boldmcqspro_render_header_buttons(); ?>
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
            
            <!-- Mobile Auth & CTA Buttons -->
            <?php
            $auth_html = boldmcqspro_render_auth_buttons();
            $btn_html  = boldmcqspro_render_header_buttons();
            if ( ! empty( $auth_html ) || ! empty( $btn_html ) ) : ?>
                <div class="pt-4 pb-2 border-t dark:border-gray-600 space-y-2">
                    <?php
                    // Render auth buttons as block-level for mobile
                    echo str_replace(
                        'class="px-4',
                        'class="block w-full text-center px-4',
                        $auth_html
                    );
                    // Render CTA buttons as block-level for mobile
                    echo str_replace(
                        'class="px-',
                        'class="block w-full text-center px-',
                        $btn_html
                    );
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
