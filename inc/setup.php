<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Theme setup
function boldmcqspro_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'boldmcqspro_setup');

// Register MCQ custom post type
function boldmcqspro_register_mcq_cpt()
{
    $labels = array(
        'name'               => _x( 'MCQs', 'Post Type General Name', 'boldmcqspro' ),
        'singular_name'      => _x( 'MCQ', 'Post Type Singular Name', 'boldmcqspro' ),
        'menu_name'          => __( 'MCQs', 'boldmcqspro' ),
        'name_admin_bar'     => __( 'MCQ', 'boldmcqspro' ),
        'archives'           => __( 'MCQ Archives', 'boldmcqspro' ),
        'attributes'         => __( 'MCQ Attributes', 'boldmcqspro' ),
        'parent_item_colon'  => __( 'Parent MCQ:', 'boldmcqspro' ),
        'all_items'          => __( 'All MCQs', 'boldmcqspro' ),
        'add_new_item'       => __( 'Add New MCQ', 'boldmcqspro' ),
        'add_new'            => __( 'Add New', 'boldmcqspro' ),
        'new_item'           => __( 'New MCQ', 'boldmcqspro' ),
        'edit_item'          => __( 'Edit MCQ', 'boldmcqspro' ),
        'update_item'        => __( 'Update MCQ', 'boldmcqspro' ),
        'view_item'          => __( 'View MCQ', 'boldmcqspro' ),
        'view_items'         => __( 'View MCQs', 'boldmcqspro' ),
        'search_items'       => __( 'Search MCQ', 'boldmcqspro' ),
        'not_found'          => __( 'Not found', 'boldmcqspro' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'boldmcqspro' ),
        'featured_image'     => __( 'Featured Image', 'boldmcqspro' ),
        'set_featured_image' => __( 'Set featured image', 'boldmcqspro' ),
        'remove_featured_image' => __( 'Remove featured image', 'boldmcqspro' ),
        'use_featured_image' => __( 'Use as featured image', 'boldmcqspro' ),
        'insert_into_item'   => __( 'Insert into MCQ', 'boldmcqspro' ),
        'uploaded_to_this_item' => __( 'Uploaded to this MCQ', 'boldmcqspro' ),
        'items_list'         => __( 'MCQs list', 'boldmcqspro' ),
        'items_list_navigation' => __( 'MCQs list navigation', 'boldmcqspro' ),
        'filter_items_list'  => __( 'Filter MCQs list', 'boldmcqspro' ),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'mcqs'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'menu_position' => 3,
    );
    register_post_type('mcqs', $args);
}
add_action('init', 'boldmcqspro_register_mcq_cpt');



// Register meta fields for MCQ CPT (fallback if ACF not available)
function boldmcqspro_register_mcq_meta()
{
    $fields = [
        'mcq_option_a' => __( 'Option A', 'boldmcqspro' ),
        'mcq_option_b' => __( 'Option B', 'boldmcqspro' ),
        'mcq_option_c' => __( 'Option C', 'boldmcqspro' ),
        'mcq_option_d' => __( 'Option D', 'boldmcqspro' ),
        'mcq_correct_option' => __( 'Correct Option', 'boldmcqspro' ),
        'mcq_explanation' => __( 'Explanation', 'boldmcqspro' ),
        'mcq_difficulty' => __( 'Difficulty Level', 'boldmcqspro' ),
    ];
    foreach ($fields as $key => $label) {
        register_post_meta('mcqs', $key, [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
        ]);
    }
}
add_action('init', 'boldmcqspro_register_mcq_meta');

// Add meta box for MCQ fields if ACF is not available
function boldmcqspro_mcq_meta_box()
{
    if (!function_exists('acf_add_local_field_group')) {
        add_meta_box(
            'mcq_details',
            __( 'MCQ Details', 'boldmcqspro' ),
            'boldmcqspro_mcq_meta_box_callback',
            'mcqs',
            'normal',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'boldmcqspro_mcq_meta_box');

function boldmcqspro_mcq_meta_box_callback($post)
{
    $fields = [
        'mcq_option_a' => __( 'Option A', 'boldmcqspro' ),
        'mcq_option_b' => __( 'Option B', 'boldmcqspro' ),
        'mcq_option_c' => __( 'Option C', 'boldmcqspro' ),
        'mcq_option_d' => __( 'Option D', 'boldmcqspro' ),
        'mcq_correct_option' => __( 'Correct Option', 'boldmcqspro' ),
        'mcq_explanation' => __( 'Explanation', 'boldmcqspro' ),
        'mcq_difficulty' => __( 'Difficulty Level', 'boldmcqspro' ),
    ];
    wp_nonce_field('boldmcqspro_mcq_meta_box', 'boldmcqspro_mcq_meta_box_nonce');
    echo '<table class="form-table">';
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></th><td>';
        if ($key === 'mcq_correct_option') {
            echo '<select name="' . esc_attr($key) . '" id="' . esc_attr($key) . '">';
            foreach (['A', 'B', 'C', 'D'] as $opt) {
                echo '<option value="' . $opt . '"' . selected($value, $opt, false) . '>' . $opt . '</option>';
            }
            echo '</select>';
        } elseif ($key === 'mcq_difficulty') {
            echo '<select name="' . esc_attr($key) . '" id="' . esc_attr($key) . '">';
            $difficulties = [
                'easy'   => __( 'Easy', 'boldmcqspro' ),
                'medium' => __( 'Medium', 'boldmcqspro' ),
                'hard'   => __( 'Hard', 'boldmcqspro' )
            ];
            foreach ($difficulties as $val => $label_text) {
                echo '<option value="' . esc_attr($val) . '"' . selected($value, $val, false) . '>' . esc_html($label_text) . '</option>';
            }
            echo '</select>';
        } elseif ($key === 'mcq_explanation') {
            echo '<textarea name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" rows="3" style="width:100%">' . esc_textarea($value) . '</textarea>';
        } else {
            echo '<input type="text" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" value="' . esc_attr($value) . '" style="width:100%" />';
        }
        echo '</td></tr>';
    }
    echo '</table>';
}

function boldmcqspro_save_mcq_meta_box($post_id)
{
    if (!isset($_POST['boldmcqspro_mcq_meta_box_nonce']) || !wp_verify_nonce($_POST['boldmcqspro_mcq_meta_box_nonce'], 'boldmcqspro_mcq_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;
    $fields = [
        'mcq_option_a',
        'mcq_option_b',
        'mcq_option_c',
        'mcq_option_d',
        'mcq_correct_option',
        'mcq_explanation',
        'mcq_difficulty'
    ];
    foreach ($fields as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
        }
    }
}
add_action('save_post_mcqs', 'boldmcqspro_save_mcq_meta_box');

// Register MCQ Categories taxonomy for MCQ CPT
function boldmcqspro_register_mcq_taxonomy()
{
    $labels = array(
        'name'                       => _x( 'MCQ Categories', 'Taxonomy General Name', 'boldmcqspro' ),
        'singular_name'              => _x( 'MCQ Category', 'Taxonomy Singular Name', 'boldmcqspro' ),
        'menu_name'                  => __( 'MCQ Categories', 'boldmcqspro' ),
        'all_items'                  => __( 'All MCQ Categories', 'boldmcqspro' ),
        'parent_item'                => __( 'Parent MCQ Category', 'boldmcqspro' ),
        'parent_item_colon'          => __( 'Parent MCQ Category:', 'boldmcqspro' ),
        'new_item_name'              => __( 'New MCQ Category Name', 'boldmcqspro' ),
        'add_new_item'               => __( 'Add New MCQ Category', 'boldmcqspro' ),
        'edit_item'                  => __( 'Edit MCQ Category', 'boldmcqspro' ),
        'update_item'                => __( 'Update MCQ Category', 'boldmcqspro' ),
        'view_item'                  => __( 'View MCQ Category', 'boldmcqspro' ),
        'separate_items_with_commas' => __( 'Separate MCQ categories with commas', 'boldmcqspro' ),
        'add_or_remove_items'        => __( 'Add or remove MCQ categories', 'boldmcqspro' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'boldmcqspro' ),
        'popular_items'              => __( 'Popular MCQ Categories', 'boldmcqspro' ),
        'search_items'               => __( 'Search MCQ Categories', 'boldmcqspro' ),
        'not_found'                  => __( 'Not Found', 'boldmcqspro' ),
        'no_terms'                   => __( 'No MCQ categories', 'boldmcqspro' ),
        'items_list'                 => __( 'MCQ categories list', 'boldmcqspro' ),
        'items_list_navigation'      => __( 'MCQ categories list navigation', 'boldmcqspro' ),
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'mcq-category'),
        'show_in_rest' => true,
    );
    register_taxonomy('mcq_category', array('mcqs'), $args);
}
add_action('init', 'boldmcqspro_register_mcq_taxonomy');

// Register MCQ Tags taxonomy for MCQ CPT
function boldmcqspro_register_mcq_tag_taxonomy()
{
    $labels = array(
        'name'                       => _x( 'MCQ Tags', 'Taxonomy General Name', 'boldmcqspro' ),
        'singular_name'              => _x( 'MCQ Tag', 'Taxonomy Singular Name', 'boldmcqspro' ),
        'menu_name'                  => __( 'MCQ Tags', 'boldmcqspro' ),
        'all_items'                  => __( 'All MCQ Tags', 'boldmcqspro' ),
        'new_item_name'              => __( 'New MCQ Tag Name', 'boldmcqspro' ),
        'add_new_item'               => __( 'Add New MCQ Tag', 'boldmcqspro' ),
        'edit_item'                  => __( 'Edit MCQ Tag', 'boldmcqspro' ),
        'update_item'                => __( 'Update MCQ Tag', 'boldmcqspro' ),
        'view_item'                  => __( 'View MCQ Tag', 'boldmcqspro' ),
        'separate_items_with_commas' => __( 'Separate MCQ tags with commas', 'boldmcqspro' ),
        'add_or_remove_items'        => __( 'Add or remove MCQ tags', 'boldmcqspro' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'boldmcqspro' ),
        'popular_items'              => __( 'Popular MCQ Tags', 'boldmcqspro' ),
        'search_items'               => __( 'Search MCQ Tags', 'boldmcqspro' ),
        'not_found'                  => __( 'Not Found', 'boldmcqspro' ),
        'no_terms'                   => __( 'No MCQ tags', 'boldmcqspro' ),
        'items_list'                 => __( 'MCQ tags list', 'boldmcqspro' ),
        'items_list_navigation'      => __( 'MCQ tags list navigation', 'boldmcqspro' ),
    );
    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'mcq-tag'),
        'show_in_rest' => true,
    );
    register_taxonomy('mcq_tag', array('mcqs'), $args);
}
add_action('init', 'boldmcqspro_register_mcq_tag_taxonomy');

// Flush rewrite rules on theme activation
function boldmcqspro_flush_rewrite_rules() {
    // Flush rewrite rules to ensure proper permalink structure
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'boldmcqspro_flush_rewrite_rules');

// Ensure rewrite rules are flushed when custom post types are registered
function boldmcqspro_maybe_flush_rewrite_rules() {
    if (get_option('boldmcqspro_rewrite_rules_flushed') != '1') {
        flush_rewrite_rules();
        update_option('boldmcqspro_rewrite_rules_flushed', '1');
    }
}
add_action('init', 'boldmcqspro_maybe_flush_rewrite_rules', 20);
