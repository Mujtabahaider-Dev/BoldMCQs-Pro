<?php
/**
 * Demo Import Handler for BoldMCQs Theme
 * 
 * Handles AJAX requests to import demo content
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * AJAX handler for importing demo content
 */
function boldmcqs_import_demo_content() {
    // Verify nonce
    check_ajax_referer('boldmcqs_import_demo', 'nonce');
    
    // Check user permissions
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array(
            'message' => 'You do not have permission to perform this action.'
        ));
        return;
    }
    
    // Check if demo already imported
    if (get_option('boldmcqs_demo_imported', false)) {
        wp_send_json_error(array(
            'message' => 'Demo content has already been imported. To avoid duplicates, please delete existing demo content before importing again.'
        ));
        return;
    }
    
    // Include demo data file
    require_once get_template_directory() . '/admin/demo-data.php';
    
    // Initialize counters
    $stats = array(
        'categories' => 0,
        'tags' => 0,
        'mcqs' => 0,
        'errors' => array()
    );
    
    try {
        // Import Categories
        $demo_categories = boldmcqs_get_demo_categories();
        $category_map = array(); // Map slug to term_id
        
        foreach ($demo_categories as $category) {
            $term = wp_insert_term(
                $category['name'],
                'mcq_category',
                array(
                    'slug' => $category['slug'],
                    'description' => $category['description']
                )
            );
            
            if (!is_wp_error($term)) {
                $stats['categories']++;
                $category_map[$category['slug']] = $term['term_id'];
            } else {
                // If category already exists, get its ID
                $existing_term = get_term_by('slug', $category['slug'], 'mcq_category');
                if ($existing_term) {
                    $category_map[$category['slug']] = $existing_term->term_id;
                } else {
                    $stats['errors'][] = 'Error creating category: ' . $category['name'];
                }
            }
        }
        
        // Import Tags
        $demo_tags = boldmcqs_get_demo_tags();
        
        foreach ($demo_tags as $tag) {
            $term = wp_insert_term(
                ucfirst(str_replace('-', ' ', $tag)),
                'mcq_tag',
                array('slug' => $tag)
            );
            
            if (!is_wp_error($term)) {
                $stats['tags']++;
            }
        }
        
        // Import MCQs
        $demo_mcqs = boldmcqs_get_demo_mcqs();
        
        foreach ($demo_mcqs as $mcq) {
            // Create the post
            $post_data = array(
                'post_title'    => $mcq['title'],
                'post_type'     => 'mcqs',
                'post_status'   => 'publish',
                'post_author'   => get_current_user_id(),
                'post_content'  => ''
            );
            
            $post_id = wp_insert_post($post_data);
            
            if ($post_id && !is_wp_error($post_id)) {
                // Add meta fields
                update_post_meta($post_id, 'mcq_option_a', sanitize_text_field($mcq['option_a']));
                update_post_meta($post_id, 'mcq_option_b', sanitize_text_field($mcq['option_b']));
                update_post_meta($post_id, 'mcq_option_c', sanitize_text_field($mcq['option_c']));
                update_post_meta($post_id, 'mcq_option_d', sanitize_text_field($mcq['option_d']));
                update_post_meta($post_id, 'mcq_correct_option', sanitize_text_field($mcq['correct_option']));
                update_post_meta($post_id, 'mcq_explanation', sanitize_textarea_field($mcq['explanation']));
                update_post_meta($post_id, 'mcq_difficulty', sanitize_text_field($mcq['difficulty']));
                
                // Assign category
                if (isset($category_map[$mcq['category']])) {
                    wp_set_object_terms($post_id, $category_map[$mcq['category']], 'mcq_category');
                }
                
                // Assign tags
                if (isset($mcq['tags']) && is_array($mcq['tags'])) {
                    wp_set_object_terms($post_id, $mcq['tags'], 'mcq_tag');
                }
                
                $stats['mcqs']++;
            } else {
                $stats['errors'][] = 'Error creating MCQ: ' . $mcq['title'];
            }
        }
        
        // Mark demo as imported
        update_option('boldmcqs_demo_imported', true);
        update_option('boldmcqs_demo_import_date', current_time('mysql'));
        
        // Send success response
        wp_send_json_success(array(
            'message' => 'Demo content imported successfully!',
            'stats' => $stats
        ));
        
    } catch (Exception $e) {
        wp_send_json_error(array(
            'message' => 'An error occurred during import: ' . $e->getMessage()
        ));
    }
}

/**
 * AJAX handler for resetting demo import flag
 * This allows re-importing after deleting demo content
 */
function boldmcqs_reset_demo_flag() {
    // Verify nonce
    check_ajax_referer('boldmcqs_reset_demo', 'nonce');
    
    // Check user permissions
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array(
            'message' => 'You do not have permission to perform this action.'
        ));
        return;
    }
    
    // Reset the flag
    delete_option('boldmcqs_demo_imported');
    delete_option('boldmcqs_demo_import_date');
    
    wp_send_json_success(array(
        'message' => 'Demo import flag reset successfully. You can now import demo content again.'
    ));
}
