<?php
/**
 * Frontend Debug File
 * Add this to your theme root to debug frontend issues
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Test if basic WordPress functions work
echo "<h2>WordPress Core Test</h2>";
echo "WordPress Version: " . get_bloginfo('version') . "<br>";
echo "Theme Directory: " . get_template_directory() . "<br>";
echo "Theme URI: " . get_template_directory_uri() . "<br>";

// Test if customizer functions work
echo "<h2>Customizer Functions Test</h2>";
if (function_exists('boldmcqspro_get_option')) {
    echo "boldmcqspro_get_option function exists<br>";
    $test_option = boldmcqspro_get_option('boldmcqspro_primary_color', '#3B82F6');
    echo "Primary color: " . $test_option . "<br>";
} else {
    echo "ERROR: boldmcqspro_get_option function does not exist<br>";
}

// Test if hex_to_rgb function works
echo "<h2>Hex to RGB Test</h2>";
if (function_exists('boldmcqspro_hex_to_rgb')) {
    echo "boldmcqspro_hex_to_rgb function exists<br>";
    $rgb = boldmcqspro_hex_to_rgb('#3B82F6');
    echo "RGB conversion: " . $rgb . "<br>";
} else {
    echo "ERROR: boldmcqspro_hex_to_rgb function does not exist<br>";
}

// Test if MCQ post type exists
echo "<h2>MCQ Post Type Test</h2>";
$mcq_posts = get_posts(array(
    'post_type' => 'mcqs',
    'numberposts' => 1
));
if (!empty($mcq_posts)) {
    echo "MCQ posts exist: " . count($mcq_posts) . " found<br>";
} else {
    echo "No MCQ posts found<br>";
}

// Test if taxonomies exist
echo "<h2>Taxonomy Test</h2>";
$mcq_categories = get_terms(array('taxonomy' => 'mcq_category', 'hide_empty' => false));
if (!is_wp_error($mcq_categories)) {
    echo "MCQ categories exist: " . count($mcq_categories) . " found<br>";
} else {
    echo "ERROR: MCQ categories not found<br>";
}

// Test file existence
echo "<h2>File Existence Test</h2>";
$files_to_check = array(
    'functions.php',
    'inc/setup.php',
    'inc/enqueue.php',
    'inc/customizer.php',
    'inc/nav-menus.php',
    'header.php',
    'index.php',
    'footer.php'
);

foreach ($files_to_check as $file) {
    $file_path = get_template_directory() . '/' . $file;
    if (file_exists($file_path)) {
        echo "✓ " . $file . " exists<br>";
    } else {
        echo "✗ " . $file . " MISSING<br>";
    }
}

// Test if required functions are loaded
echo "<h2>Required Functions Test</h2>";
$required_functions = array(
    'boldmcqspro_setup',
    'boldmcqspro_register_mcq_cpt',
    'boldmcqspro_register_mcq_taxonomy',
    'boldmcqspro_enqueue_scripts'
);

foreach ($required_functions as $function) {
    if (function_exists($function)) {
        echo "✓ " . $function . " exists<br>";
    } else {
        echo "✗ " . $function . " MISSING<br>";
    }
}

echo "<h2>Debug Complete</h2>";
?>
