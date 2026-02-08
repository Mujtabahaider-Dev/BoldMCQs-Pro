<?php
// Register widget areas
function boldmcqspro_register_widgets() {
    // Header Widget Area
    register_sidebar(array(
        'name'          => __('Header Widget Area', 'boldmcqspro'),
        'id'            => 'header-widget-area',
        'description'   => __('Widgets in this area will be shown in the header.', 'boldmcqspro'),
        'before_widget' => '<div id="%1$s" class="header-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="header-widget-title font-semibold text-gray-900 dark:text-white">',
        'after_title'   => '</h3>',
    ));

    // Footer Widget Area 1
    register_sidebar(array(
        'name'          => __('Footer Column 1', 'boldmcqspro'),
        'id'            => 'footer-widget-1',
        'description'   => __('Widgets in this area will be shown in the first footer column.', 'boldmcqspro'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title font-semibold text-gray-900 dark:text-white mb-4">',
        'after_title'   => '</h3>',
    ));

    // Footer Widget Area 2
    register_sidebar(array(
        'name'          => __('Footer Column 2', 'boldmcqspro'),
        'id'            => 'footer-widget-2',
        'description'   => __('Widgets in this area will be shown in the second footer column.', 'boldmcqspro'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title font-semibold text-gray-900 dark:text-white mb-4">',
        'after_title'   => '</h3>',
    ));

    // Footer Widget Area 3
    register_sidebar(array(
        'name'          => __('Footer Column 3', 'boldmcqspro'),
        'id'            => 'footer-widget-3',
        'description'   => __('Widgets in this area will be shown in the third footer column.', 'boldmcqspro'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title font-semibold text-gray-900 dark:text-white mb-4">',
        'after_title'   => '</h3>',
    ));

    // Footer Widget Area 4
    register_sidebar(array(
        'name'          => __('Footer Column 4', 'boldmcqspro'),
        'id'            => 'footer-widget-4',
        'description'   => __('Widgets in this area will be shown in the fourth footer column.', 'boldmcqspro'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="footer-widget-title font-semibold text-gray-900 dark:text-white mb-4">',
        'after_title'   => '</h3>',
    ));

    // Sidebar Widget Area
    register_sidebar(array(
        'name'          => __('Sidebar', 'boldmcqspro'),
        'id'            => 'sidebar',
        'description'   => __('Widgets in this area will be shown in the sidebar.', 'boldmcqspro'),
        'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border dark:border-gray-700 mb-6">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="sidebar-widget-title font-semibold text-gray-900 dark:text-white mb-4">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'boldmcqspro_register_widgets');
