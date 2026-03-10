<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * BoldMCQs Pro Admin Notices
 */

// Admin notice for permalink structure
function boldmcqspro_permalink_notice() {
    if (is_admin() && current_user_can('manage_options')) {
        $permalink_structure = get_option('permalink_structure');
        if (empty($permalink_structure)) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><strong><?php esc_html_e('BoldMCQs Pro:', 'boldmcqspro'); ?></strong> <?php esc_html_e('Your permalink structure is set to default. To get clean URLs like', 'boldmcqspro'); ?> <code>/mcq-category/general-knowledge/</code> <?php esc_html_e('instead of', 'boldmcqspro'); ?> <code>/index.php/mcq-category/general-knowledge/</code>, <?php esc_html_e('please go to', 'boldmcqspro'); ?> <a href="<?php echo esc_url(admin_url('options-permalink.php')); ?>"><?php esc_html_e('Settings → Permalinks', 'boldmcqspro'); ?></a> <?php esc_html_e('and select "Post name" or any other option except "Plain".', 'boldmcqspro'); ?></p>
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
                <p><strong><?php esc_html_e('BoldMCQs Pro:', 'boldmcqspro'); ?></strong> <?php esc_html_e('To customize your header navigation menu, go to', 'boldmcqspro'); ?> <a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>"><?php esc_html_e('Appearance → Menus', 'boldmcqspro'); ?></a> <?php esc_html_e('and create a new menu, then assign it to the "Primary Menu" location. You can also customize menu appearance in', 'boldmcqspro'); ?> <a href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=boldmcqspro_navigation')); ?>"><?php esc_html_e('Appearance → Customize → Navigation Menu', 'boldmcqspro'); ?></a>.</p>
            </div>
            <?php
        }
    }
}
add_action('admin_notices', 'boldmcqspro_menu_setup_notice');
