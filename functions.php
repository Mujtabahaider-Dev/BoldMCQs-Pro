<?php
/**
 * BoldMCQs Pro Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BoldMCQs_Pro
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Load theme modules
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/widgets.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/dynamic-colors.php';
require_once get_template_directory() . '/inc/nav-menus.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/typography.php';
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/header-buttons.php';
require_once get_template_directory() . '/inc/social-helpers.php';
require_once get_template_directory() . '/inc/search.php';
require_once get_template_directory() . '/inc/pagination.php';
require_once get_template_directory() . '/inc/admin-notices.php';
require_once get_template_directory() . '/inc/helpers.php';

// Admin panel setup
if (is_admin()) {
    require_once get_template_directory() . '/admin-loader.php';
}
