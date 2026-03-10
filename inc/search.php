<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * BoldMCQs Pro Search Enhancements
 */

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
