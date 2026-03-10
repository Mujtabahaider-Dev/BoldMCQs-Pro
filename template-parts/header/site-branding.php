<?php
/**
 * Site Branding Template Part
 * Displays logo and/or site title based on customizer settings
 */

// Get customizer settings
$branding_mode = boldmcqspro_get_option('boldmcqspro_branding_mode', 'both');
$logo = boldmcqspro_get_option('boldmcqspro_logo');
$show_title = boldmcqspro_get_option('boldmcqspro_show_site_title', true);
$logo_width = boldmcqspro_get_option('boldmcqspro_logo_width', 150);
$logo_height_mode = boldmcqspro_get_option('boldmcqspro_logo_height_mode', 'auto');
$logo_height = boldmcqspro_get_option('boldmcqspro_logo_height', 60);
$title_size = boldmcqspro_get_option('boldmcqspro_site_title_size', 20);
$title_transform = boldmcqspro_get_option('boldmcqspro_site_title_transform', 'none');

// Determine what to show
$show_logo = ($branding_mode === 'logo' || $branding_mode === 'both') && !empty($logo);
$show_text = ($branding_mode === 'text' || $branding_mode === 'both') && $show_title;

// Build logo style
$logo_style = 'width: ' . intval($logo_width) . 'px;';
if ($logo_height_mode === 'custom') {
    $logo_style .= ' height: ' . intval($logo_height) . 'px;';
} else {
    $logo_style .= ' height: auto;';
}

// Build title style  
$title_style = 'font-size: ' . intval($title_size) . 'px; text-transform: ' . esc_attr($title_transform) . ';';
?>

<!-- Site Branding -->
<div class="flex items-center space-x-3">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center space-x-3">
        <?php if ($show_logo) : ?>
            <img 
                src="<?php echo esc_url($logo); ?>" 
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>" 
                style="<?php echo esc_attr($logo_style); ?>"
                class="max-h-16"
            >
        <?php elseif (!$show_text) : ?>
            <!-- Fallback: Show first letter as icon if no logo and no text -->
            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg"><?php echo esc_html(substr(get_bloginfo('name'), 0, 1)); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if ($show_text) : ?>
            <span 
                class="font-bold text-gray-900 dark:text-white"
                style="<?php echo esc_attr($title_style); ?>"
            >
                <?php echo esc_html(get_bloginfo('name')); ?>
            </span>
        <?php endif; ?>
    </a>
</div>
