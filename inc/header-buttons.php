<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Header Buttons Helper Functions
 * Renders customizable CTA buttons and auth buttons
 */

/**
 * Render a single CTA button based on customizer settings
 * 
 * @param int $button_num Button number (1, 2, or 3)
 * @return string HTML for the button
 */
function boldmcqspro_render_header_button($button_num) {
    // Get button settings
    $show = boldmcqspro_get_option("boldmcqspro_button{$button_num}_show", false);
    
    if (!$show) {
        return '';
    }
    
    $text = boldmcqspro_get_option("boldmcqspro_button{$button_num}_text", 'Get Started');
    $url = boldmcqspro_get_option("boldmcqspro_button{$button_num}_url", '#');
    $bg_color = boldmcqspro_get_option("boldmcqspro_button{$button_num}_bg_color", '');
    $text_color = boldmcqspro_get_option("boldmcqspro_button{$button_num}_text_color", '#FFFFFF');
    $style = boldmcqspro_get_option("boldmcqspro_button{$button_num}_style", 'solid');
    $size = boldmcqspro_get_option("boldmcqspro_button{$button_num}_size", 'medium');
    
    // Set default background color if empty
    if (empty($bg_color)) {
        if ($button_num === 1) {
            $bg_color = boldmcqspro_get_option('boldmcqspro_primary_color', '#3B82F6');
        } elseif ($button_num === 2) {
            $bg_color = boldmcqspro_get_option('boldmcqspro_secondary_color', '#10B981');
        } else {
            $bg_color = '#6B7280'; // Gray for button 3
        }
    }
    
    // Build classes based on size
    $size_classes = array(
        'small'  => 'btn-sm',
        'medium' => '',
        'large'  => 'btn-lg',
    );
    $size_class = $size_classes[$size] ?? '';
    
    // Build style-specific classes and inline styles
    $final_classes = array('btn-base', $size_class);
    $inline_style = '';
    
    if ($style === 'solid') {
        $inline_style = "background-color: {$bg_color}; color: {$text_color};";
    } elseif ($style === 'outline') {
        $inline_style = "border: 2px solid {$bg_color} !important; color: {$bg_color}; background-color: transparent;";
    } else { // ghost
        $inline_style = "color: {$bg_color}; background-color: transparent; border: none;";
    }
    
    // Build final button HTML
    return sprintf(
        '<a href="%s" class="%s" style="%s">%s</a>',
        esc_url($url),
        implode(' ', array_filter($final_classes)),
        esc_attr($inline_style),
        esc_html($text)
    );
}

/**
 * Render all enabled CTA buttons
 * 
 * @return string HTML for all buttons
 */
function boldmcqspro_render_header_buttons() {
    $buttons = '';
    
    // Render only 2 buttons
    for ($i = 1; $i <= 2; $i++) {
        $button = boldmcqspro_render_header_button($i);
        if (!empty($button)) {
            $buttons .= $button;
        }
    }
    
    return $buttons;
}

/**
 * Render auth buttons (Login/Register or Logout/Dashboard)
 * 
 * @return string HTML for auth buttons
 */
function boldmcqspro_render_auth_buttons() {
    $show_auth = boldmcqspro_get_option('boldmcqspro_show_auth_buttons', true);
    
    if (!$show_auth) {
        return '';
    }
    
    // Get custom button text
    $login_text = boldmcqspro_get_option('boldmcqspro_login_text', 'Login');
    $register_text = boldmcqspro_get_option('boldmcqspro_register_text', 'Register');
    $logout_text = boldmcqspro_get_option('boldmcqspro_logout_text', 'Logout');
    $dashboard_text = boldmcqspro_get_option('boldmcqspro_dashboard_text', 'Dashboard');
    
    $primary_color = boldmcqspro_get_option('boldmcqspro_primary_color', '#3B82F6');
    
    ob_start();
    
    if (is_user_logged_in()) : ?>
        <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>"
            class="btn-base btn-ghost">
            <?php echo esc_html($logout_text); ?>
        </a>
        <a href="<?php echo esc_url(admin_url()); ?>"
            class="btn-base btn-primary">
            <?php echo esc_html($dashboard_text); ?>
        </a>
    <?php else : ?>
        <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>"
            class="btn-base btn-ghost">
            <?php echo esc_html($login_text); ?>
        </a>
        <a href="<?php echo esc_url(wp_registration_url()); ?>"
            class="btn-base btn-primary">
            <?php echo esc_html($register_text); ?>
        </a>
    <?php endif;
    
    return ob_get_clean();
}

/**
 * Render legacy header button (for backward compatibility)
 * Falls back to the old single button system if new system isn't configured
 * 
 * @return string HTML for legacy button
 */
function boldmcqspro_render_legacy_header_button() {
    $text = boldmcqspro_get_option('boldmcqspro_header_button_text', '');
    $link = boldmcqspro_get_option('boldmcqspro_header_button_link', '');
    
    if (empty($text) || empty($link)) {
        return '';
    }
    
    $secondary_color = boldmcqspro_get_option('boldmcqspro_secondary_color', '#10B981');
    
    return sprintf(
        '<a href="%s" class="btn-base btn-secondary">%s</a>',
        esc_url($link),
        esc_html($text)
    );
}
