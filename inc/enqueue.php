<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Enqueue styles and scripts
function boldmcqspro_enqueue_scripts()
{
    wp_enqueue_style('boldmcqspro-style', get_stylesheet_uri());
    // Enqueue Tailwind CSS from CDN
    wp_enqueue_style('tailwind', 'https://cdn.tailwindcss.com', array(), null);
    // Enqueue main.js from assets/js
    wp_enqueue_script('boldmcqspro-main', get_template_directory_uri() . '/assets/js/main.js', array(), null, true);

    // Dynamic CSS (from Customizer)
    $menu_style        = boldmcqspro_get_option('boldmcqspro_menu_style', 'default');
    $menu_hover_effect = boldmcqspro_get_option('boldmcqspro_menu_hover_effect', 'underline');
    $custom_css = '';

    if ($menu_style === 'minimal') {
        $custom_css .= '.main-navigation a { font-weight:400 !important; padding:.5rem .75rem !important; border-radius:.25rem !important; }';
    } elseif ($menu_style === 'bold') {
        $custom_css .= '.main-navigation a { font-weight:600 !important; padding:.75rem 1rem !important; border-radius:.5rem !important; text-transform:uppercase !important; letter-spacing:.05em !important; }';
    }

    if ($menu_hover_effect === 'underline') {
        $custom_css .= '.main-navigation a:hover { text-decoration:underline !important; text-decoration-color:rgb(var(--cp)) !important; text-underline-offset:4px !important; }';
    } elseif ($menu_hover_effect === 'background') {
        $custom_css .= '.main-navigation a:hover { background-color:rgb(var(--cp)) !important; color:#fff !important; }';
    } elseif ($menu_hover_effect === 'scale') {
        $custom_css .= '.main-navigation a:hover { transform:scale(1.05) !important; transition:transform .2s ease-in-out !important; }';
    } elseif ($menu_hover_effect === 'none') {
        $custom_css .= '.main-navigation a:hover { text-decoration:none !important; background-color:transparent !important; transform:none !important; }';
    }

    wp_add_inline_style('boldmcqspro-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'boldmcqspro_enqueue_scripts');