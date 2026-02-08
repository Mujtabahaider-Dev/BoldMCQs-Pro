<?php
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
        'name' => 'MCQs',
        'singular_name' => 'MCQ',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New MCQ',
        'edit_item' => 'Edit MCQ',
        'new_item' => 'New MCQ',
        'view_item' => 'View MCQ',
        'search_items' => 'Search MCQs',
        'not_found' => 'No MCQs found',
        'not_found_in_trash' => 'No MCQs found in Trash',
        'menu_name' => 'MCQs',
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
        'mcq_option_a' => 'Option A',
        'mcq_option_b' => 'Option B',
        'mcq_option_c' => 'Option C',
        'mcq_option_d' => 'Option D',
        'mcq_correct_option' => 'Correct Option',
        'mcq_explanation' => 'Explanation',
        'mcq_difficulty' => 'Difficulty Level',
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
            'MCQ Details',
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
        'mcq_option_a' => 'Option A',
        'mcq_option_b' => 'Option B',
        'mcq_option_c' => 'Option C',
        'mcq_option_d' => 'Option D',
        'mcq_correct_option' => 'Correct Option',
        'mcq_explanation' => 'Explanation',
        'mcq_difficulty' => 'Difficulty Level',
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
            $difficulties = ['easy' => 'Easy', 'medium' => 'Medium', 'hard' => 'Hard'];
            foreach ($difficulties as $val => $label_text) {
                echo '<option value="' . $val . '"' . selected($value, $val, false) . '>' . $label_text . '</option>';
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
        'name' => 'MCQ Categories',
        'singular_name' => 'MCQ Category',
        'search_items' => 'Search MCQ Categories',
        'all_items' => 'All MCQ Categories',
        'parent_item' => 'Parent MCQ Category',
        'parent_item_colon' => 'Parent MCQ Category:',
        'edit_item' => 'Edit MCQ Category',
        'update_item' => 'Update MCQ Category',
        'add_new_item' => 'Add New MCQ Category',
        'new_item_name' => 'New MCQ Category Name',
        'menu_name' => 'MCQ Categories',
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
        'name' => 'MCQ Tags',
        'singular_name' => 'MCQ Tag',
        'search_items' => 'Search MCQ Tags',
        'all_items' => 'All MCQ Tags',
        'edit_item' => 'Edit MCQ Tag',
        'update_item' => 'Update MCQ Tag',
        'add_new_item' => 'Add New MCQ Tag',
        'new_item_name' => 'New MCQ Tag Name',
        'menu_name' => 'MCQ Tags',
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
