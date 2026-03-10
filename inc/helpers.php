<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * BoldMCQs Pro Helper Functions
 */

// Manual flush rewrite rules function
function boldmcqspro_manual_flush_rewrite_rules() {
    if (current_user_can('manage_options') && isset($_GET['flush_rewrite_rules']) && $_GET['flush_rewrite_rules'] === 'boldmcqspro') {
        
        // Verify Nonce
        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'boldmcqspro_flush_rewrite_action' ) ) {
            wp_die( esc_html__( 'Security check failed.', 'boldmcqspro' ) );
        }

        flush_rewrite_rules();
        delete_option('boldmcqspro_rewrite_rules_flushed');
        wp_redirect(admin_url('themes.php?page=boldmcqspro-admin&rewrite_flushed=1'));
        exit;
    }
}
add_action('admin_init', 'boldmcqspro_manual_flush_rewrite_rules');
