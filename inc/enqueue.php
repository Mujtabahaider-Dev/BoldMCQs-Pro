<?php
// Enqueue styles and scripts
function boldmcqspro_enqueue_scripts()
{
    wp_enqueue_style('boldmcqspro-style', get_stylesheet_uri());
    // Enqueue Tailwind CSS from CDN
    wp_enqueue_style('tailwind', 'https://cdn.tailwindcss.com', array(), null);
    // Enqueue main.js from assets/js
    wp_enqueue_script('boldmcqspro-main', get_template_directory_uri() . '/assets/js/main.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'boldmcqspro_enqueue_scripts');