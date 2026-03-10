<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
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
        style="<?php echo esc_attr($header_style); ?>">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center" style="height:<?php echo absint($header_height); ?>px;">
                <?php get_template_part('template-parts/header/site-branding'); ?>
                <!-- Navigation -->
                <?php if (boldmcqspro_get_option('boldmcqspro_show_primary_menu', true)) : ?>
                <nav class="main-navigation hidden <?php echo esc_attr(boldmcqspro_get_option('boldmcqspro_mobile_menu_breakpoint', 'md')); ?>:flex items-center space-x-2">
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
                <div class="<?php echo esc_attr(boldmcqspro_get_option('boldmcqspro_mobile_menu_breakpoint', 'md')); ?>:hidden">
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
    <div id="mobileMenu" class="hidden <?php echo esc_attr(boldmcqspro_get_option('boldmcqspro_mobile_menu_breakpoint', 'md')); ?>:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700 shadow-lg">
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
