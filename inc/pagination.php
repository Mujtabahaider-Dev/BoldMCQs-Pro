<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * BoldMCQs Pro Pagination Logic
 */

// Custom page title for pagination pages (Moved from functions.php)
function boldmcqspro_custom_page_title( $title ) {
    if ( is_home() && is_paged() ) {
        $page_number = get_query_var( 'paged' );
        $title['title'] = sprintf( esc_html__( 'MCQ Questions - Page %d', 'boldmcqspro' ), $page_number );
        if ( isset( $title['page'] ) ) {
            unset( $title['page'] );
        }
    }
    return $title;
}
add_filter( 'document_title_parts', 'boldmcqspro_custom_page_title' );

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
