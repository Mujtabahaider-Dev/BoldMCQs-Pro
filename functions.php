<?php
// Theme includes
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/widgets.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/nav-menus.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/typography.php';
require_once get_template_directory() . '/inc/seo.php';

// Admin panel setup
if (is_admin()) {
    require_once get_template_directory() . '/admin-loader.php';
}

// Enhance search to prioritize MCQs and handle homepage pagination
function boldmcqspro_enhance_search($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_search()) {
            // Set post type to MCQs only for search
            $query->set('post_type', 'mcqs');
            
            // Increase posts per page for search results
            $query->set('posts_per_page', 20);
        } elseif ($query->is_home() || $query->is_front_page()) {
            // Handle homepage pagination by setting post type to MCQs
            $query->set('post_type', 'mcqs');
            
            // Get customization settings
            $posts_per_page = boldmcqspro_get_option('boldmcqspro_homepage_mcqs_per_page', 10);
            $orderby = boldmcqspro_get_option('boldmcqspro_homepage_mcqs_orderby', 'date');
            $order = boldmcqspro_get_option('boldmcqspro_homepage_mcqs_order', 'DESC');
            $category_filter = boldmcqspro_get_option('boldmcqspro_homepage_mcqs_category', '');
            
            $query->set('posts_per_page', intval($posts_per_page));
            $query->set('orderby', $orderby);
            $query->set('order', $order);
            
            // Add category filter if selected
            if (!empty($category_filter)) {
                $query->set('tax_query', array(
                    array(
                        'taxonomy' => 'mcq_category',
                        'field'    => 'slug',
                        'terms'    => $category_filter,
                    ),
                ));
            }
        }
    }
}
add_action('pre_get_posts', 'boldmcqspro_enhance_search');

// Admin notice for permalink structure
function boldmcqspro_permalink_notice() {
    if (is_admin() && current_user_can('manage_options')) {
        $permalink_structure = get_option('permalink_structure');
        if (empty($permalink_structure)) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><strong>BoldMCQs Pro:</strong> Your permalink structure is set to default. To get clean URLs like <code>/mcq-category/general-knowledge/</code> instead of <code>/index.php/mcq-category/general-knowledge/</code>, please go to <a href="<?php echo admin_url('options-permalink.php'); ?>">Settings → Permalinks</a> and select "Post name" or any other option except "Plain".</p>
            </div>
            <?php
        }
    }
}
add_action('admin_notices', 'boldmcqspro_permalink_notice');

// Admin notice for navigation menu setup
function boldmcqspro_menu_setup_notice() {
    if (is_admin() && current_user_can('manage_options')) {
        $primary_menu = wp_get_nav_menu_object('primary');
        if (!$primary_menu) {
            ?>
            <div class="notice notice-info is-dismissible">
                <p><strong>BoldMCQs Pro:</strong> To customize your header navigation menu, go to <a href="<?php echo admin_url('nav-menus.php'); ?>">Appearance → Menus</a> and create a new menu, then assign it to the "Primary Menu" location. You can also customize menu appearance in <a href="<?php echo admin_url('customize.php?autofocus[section]=boldmcqspro_navigation'); ?>">Appearance → Customize → Navigation Menu</a>.</p>
            </div>
            <?php
        }
    }
}
add_action('admin_notices', 'boldmcqspro_menu_setup_notice');

// Manual flush rewrite rules function
function boldmcqspro_manual_flush_rewrite_rules() {
    if (current_user_can('manage_options') && isset($_GET['flush_rewrite_rules']) && $_GET['flush_rewrite_rules'] === 'boldmcqspro') {
        flush_rewrite_rules();
        delete_option('boldmcqspro_rewrite_rules_flushed');
        wp_redirect(admin_url('themes.php?page=boldmcqspro-admin&rewrite_flushed=1'));
        exit;
    }
}
add_action('admin_init', 'boldmcqspro_manual_flush_rewrite_rules');

// Custom page title for pagination pages
function boldmcqspro_custom_page_title($title) {
    if (is_home() && is_paged()) {
        $page_number = get_query_var('paged');
        $site_name = get_bloginfo('name');
        $title = "MCQ Questions - Page $page_number | $site_name";
    }
    return $title;
}
add_filter('wp_title', 'boldmcqspro_custom_page_title');
add_filter('document_title_parts', function($title_parts) {
    if (is_home() && is_paged()) {
        $page_number = get_query_var('paged');
        $title_parts['title'] = 'MCQ Questions - Page ' . $page_number;
        if (empty($title_parts['page'])) {
            unset($title_parts['page']);
        }
    }
    return $title_parts;
});

// Fix pagination for custom post types on homepage
function boldmcqspro_fix_pagination_404() {
    global $wp_rewrite;
    if (empty($wp_rewrite->permalink_structure)) {
        return;
    }
    
    // Add pagination rewrite rules for homepage
    add_rewrite_rule(
        '^page/([0-9]{1,})/?$',
        'index.php?paged=$matches[1]',
        'top'
    );
}
add_action('init', 'boldmcqspro_fix_pagination_404');


