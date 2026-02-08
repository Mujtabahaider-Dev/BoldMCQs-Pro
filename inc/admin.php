<?php
/**
 * Admin Panel Integration for BoldMCQs Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu pages
 */
function boldmcqspro_add_admin_menu() {
    // Debug: Check if we're in admin
    if (!is_admin()) {
        return;
    }
    
    // Add main menu page
    add_menu_page(
        'BoldMCQs',
        'BoldMCQs',
        'manage_options',
        'boldmcqs-dashboard',
        'boldmcqspro_dashboard_page',
        'dashicons-welcome-learn-more',
        2
    );

    // Add dashboard submenu
    add_submenu_page(
        'boldmcqs-dashboard',
        __('Dashboard', 'boldmcqspro'),
        __('Dashboard', 'boldmcqspro'),
        'manage_options',
        'boldmcqs-dashboard',
        'boldmcqspro_dashboard_page'
    );






}
add_action('admin_menu', 'boldmcqspro_add_admin_menu');

// Debug: Add a simple hook to verify our admin file is loading
add_action('admin_init', function() {
    // This will help us know the admin file is being loaded
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('BoldMCQs Admin: Admin file loaded successfully');
    }
});

/**
 * Dashboard page callback
 */
function boldmcqspro_dashboard_page() {
    include_once get_template_directory() . '/admin/dashboard.php';
}







/**
 * Enqueue admin styles and scripts
 */
function boldmcqspro_admin_enqueue_scripts($hook_suffix) {
    // Only load on our admin pages
    if (strpos($hook_suffix, 'boldmcqs') === false) {
        return;
    }

    // Enqueue admin CSS
    wp_enqueue_style(
        'boldmcqspro-admin-style',
        get_template_directory_uri() . '/admin/style.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // Enqueue Tailwind CSS
    wp_enqueue_style(
        'boldmcqspro-tailwind',
        'https://cdn.tailwindcss.com',
        array(),
        null
    );

    // Enqueue Font Awesome
    wp_enqueue_style(
        'boldmcqspro-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
        array(),
        '6.0.0'
    );

    // Enqueue admin JS if needed
    wp_enqueue_script(
        'boldmcqspro-admin-script',
        get_template_directory_uri() . '/admin/admin.js',
        array('jquery'),
        wp_get_theme()->get('Version'),
        true
    );

    // Localize script for AJAX
    wp_localize_script('boldmcqspro-admin-script', 'boldmcqs_admin', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('boldmcqs_admin_nonce'),
        'text' => array(
            'confirm_delete' => __('Are you sure you want to delete this item?', 'boldmcqspro'),
            'loading' => __('Loading...', 'boldmcqspro'),
        )
    ));
}
add_action('admin_enqueue_scripts', 'boldmcqspro_admin_enqueue_scripts');

/**
 * Add admin body classes for our pages
 */
function boldmcqspro_admin_body_class($classes) {
    $current_screen = get_current_screen();
    
    if (isset($current_screen->id) && strpos($current_screen->id, 'boldmcqs') !== false) {
        $classes .= ' boldmcqs-admin-page';
    }
    
    return $classes;
}
add_filter('admin_body_class', 'boldmcqspro_admin_body_class');

/**
 * Remove admin notices from our pages for cleaner interface
 */
function boldmcqspro_remove_admin_notices() {
    $current_screen = get_current_screen();
    
    if (isset($current_screen->id) && strpos($current_screen->id, 'boldmcqs') !== false) {
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
    }
}
add_action('admin_head', 'boldmcqspro_remove_admin_notices');



/**
 * Get admin page URL
 */
function boldmcqspro_get_admin_url($page = 'dashboard') {
    return admin_url('admin.php?page=boldmcqs-' . $page);
}

/**
 * Check if current page is BoldMCQs admin page
 */
function boldmcqspro_is_admin_page() {
    $current_screen = get_current_screen();
    return isset($current_screen->id) && strpos($current_screen->id, 'boldmcqs') !== false;
}
