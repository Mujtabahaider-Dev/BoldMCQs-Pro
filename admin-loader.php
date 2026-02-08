<?php
/**
 * BoldMCQs Admin Menu Loader
 * Alternative approach to ensure menu appears
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Hook into WordPress admin initialization
add_action('init', function() {
    // Only run in admin area
    if (is_admin()) {
        add_action('admin_menu', 'boldmcqs_force_add_menu');
    }
});

function boldmcqs_force_add_menu() {
    // Check if user has proper permissions
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Add the main menu page
    add_menu_page(
        'BoldMCQs Dashboard',          // Page title
        'BoldMCQs',                    // Menu title
        'manage_options',              // Capability
        'boldmcqs-main',              // Menu slug
        'boldmcqs_render_dashboard',   // Function to display page
        'dashicons-welcome-learn-more', // Icon
        2                             // Position (2 = right after Dashboard)
    );
    
    // Add submenus
    add_submenu_page(
        'boldmcqs-main',
        'Dashboard',
        'Dashboard', 
        'manage_options',
        'boldmcqs-main',
        'boldmcqs_render_dashboard'
    );
    

    

    

}

// Page rendering functions
function boldmcqs_render_dashboard() {
    $file = get_template_directory() . '/admin/dashboard.php';
    if (file_exists($file)) {
        include_once $file;
    } else {
        echo '<div class="wrap"><h1>BoldMCQs Dashboard</h1><p>Dashboard file not found at: ' . $file . '</p></div>';
    }
}







// Enqueue admin styles and scripts
add_action('admin_enqueue_scripts', function($hook_suffix) {
    // Only load on our admin pages
    if (strpos($hook_suffix, 'boldmcqs') === false) {
        return;
    }

    // Get theme directory URI
    $theme_uri = get_template_directory_uri();
    
    // Enqueue admin CSS
    if (file_exists(get_template_directory() . '/admin/style.css')) {
        wp_enqueue_style(
            'boldmcqs-admin-style',
            $theme_uri . '/admin/style.css',
            array(),
            filemtime(get_template_directory() . '/admin/style.css')
        );
    }

    // Enqueue Font Awesome
    wp_enqueue_style(
        'boldmcqs-fontawesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
        array(),
        '6.0.0'
    );

    // Enqueue admin JS
    if (file_exists(get_template_directory() . '/admin/admin.js')) {
        wp_enqueue_script(
            'boldmcqs-admin-script',
            $theme_uri . '/admin/admin.js',
            array('jquery'),
            filemtime(get_template_directory() . '/admin/admin.js'),
            true
        );

        // Localize script for AJAX
        wp_localize_script('boldmcqs-admin-script', 'boldmcqs_admin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('boldmcqs_admin_nonce'),
            'import_nonce' => wp_create_nonce('boldmcqs_import_demo'),
            'reset_nonce' => wp_create_nonce('boldmcqs_reset_demo'),
            'demo_imported' => get_option('boldmcqs_demo_imported', false),
            'text' => array(
                'confirm_delete' => 'Are you sure you want to delete this item?',
                'loading' => 'Loading...',
                'importing' => 'Importing demo content...',
                'import_success' => 'Demo content imported successfully!',
                'import_error' => 'Error importing demo content.',
            )
        ));

    }
});


// Simple test to ensure this file is loaded
add_action('wp_loaded', function() {
    if (is_admin() && defined('WP_DEBUG') && WP_DEBUG) {
        error_log('BoldMCQs: Admin loader file executed successfully');
    }
});

// Include demo import handler
require_once get_template_directory() . '/admin/import-handler.php';

// Register AJAX actions for demo import
add_action('wp_ajax_boldmcqs_import_demo', 'boldmcqs_import_demo_content');
add_action('wp_ajax_boldmcqs_reset_demo', 'boldmcqs_reset_demo_flag');
?>
