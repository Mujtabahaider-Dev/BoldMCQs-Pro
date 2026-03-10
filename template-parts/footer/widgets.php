<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Footer Widgets Template
 */

// Get footer columns from customizer
$footer_columns = boldmcqspro_get_option('boldmcqspro_footer_columns', 4);
$show_newsletter = boldmcqspro_get_option('boldmcqspro_footer_show_newsletter', true);

$grid_classes = array(
    1 => 'grid-cols-1',
    2 => 'grid-cols-1 md:grid-cols-2',
    3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    4 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
);

// Check if any footer widgets are active
$has_widgets = false;
for ($i = 1; $i <= $footer_columns; $i++) {
    if (is_active_sidebar('footer-widget-' . $i)) {
        $has_widgets = true;
        break;
    }
}
?>

<div class="bg-gray-100 dark:bg-gray-900 border-t dark:border-gray-700 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ($has_widgets) : ?>
            <div class="grid <?php echo esc_attr($grid_classes[$footer_columns]); ?> gap-12">
                <?php for ($i = 1; $i <= $footer_columns; $i++) : ?>
                    <?php if (is_active_sidebar('footer-widget-' . $i)) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar('footer-widget-' . $i); ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php else : ?>
            <!-- Fallback / Demo Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                
                <!-- Column 1: About -->
                <div class="space-y-6">
                    <?php 
                    $footer_logo = boldmcqspro_get_option('boldmcqspro_footer_logo', '');
                    if ($footer_logo) : ?>
                        <img src="<?php echo esc_url($footer_logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-10 w-auto">
                    <?php else : ?>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white"><?php bloginfo('name'); ?><span class="text-primary">.</span></h2>
                    <?php endif; ?>
                    
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm">
                        <?php echo esc_html(boldmcqspro_get_option('boldmcqspro_footer_about', 'BoldMCQs Pro is the leading platform for practicing high-quality MCQs across various computer science topics.')); ?>
                    </p>
                    
                    <?php boldmcqspro_display_social_links('flex space-x-4', 'w-5 h-5 transition-colors'); ?>
                </div>

                <!-- Column 2: Quick Links / Custom Menu 1 -->
                <div>
                    <h3 class="text-gray-900 dark:text-white font-bold uppercase tracking-wider text-xs mb-6">
                        <?php echo esc_html(boldmcqspro_get_option('boldmcqspro_footer_menu_1_title', 'Quick Links')); ?>
                    </h3>
                    <?php 
                    $footer_menu_1 = boldmcqspro_get_option('boldmcqspro_footer_menu_1', '');
                    if ($footer_menu_1) :
                        wp_nav_menu(array(
                            'menu'           => $footer_menu_1,
                            'menu_class'     => 'space-y-3',
                            'container'      => false,
                            'depth'          => 1,
                            'link_before'    => '<span class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary transition-colors no-underline">',
                            'link_after'     => '</span>',
                        ));
                    elseif (has_nav_menu('primary')) : ?>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'space-y-3',
                            'container'      => false,
                            'depth'          => 1,
                            'link_before'    => '<span class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary transition-colors no-underline">',
                            'link_after'     => '</span>',
                        ));
                        ?>
                    <?php else: ?>
                        <ul class="space-y-3">
                            <li><a href="<?php echo home_url('/'); ?>" class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary no-underline transition-colors">Home</a></li>
                            <li><a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary no-underline transition-colors">About Us</a></li>
                            <li><a href="#" class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary no-underline transition-colors">Contact</a></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Column 3: Custom Menu 2 / Categories -->
                <div>
                    <h3 class="text-gray-900 dark:text-white font-bold uppercase tracking-wider text-xs mb-6">
                        <?php echo esc_html(boldmcqspro_get_option('boldmcqspro_footer_menu_2_title', 'Popular Categories')); ?>
                    </h3>
                    <?php 
                    $footer_menu_2 = boldmcqspro_get_option('boldmcqspro_footer_menu_2', '');
                    if ($footer_menu_2) :
                        wp_nav_menu(array(
                            'menu'           => $footer_menu_2,
                            'menu_class'     => 'space-y-3',
                            'container'      => false,
                            'depth'          => 1,
                            'link_before'    => '<span class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary transition-colors no-underline">',
                            'link_after'     => '</span>',
                        ));
                    else :
                        $categories = get_terms(array(
                            'taxonomy'   => 'mcq_category',
                            'number'     => 5,
                            'hide_empty' => false,
                        ));
                        if (!empty($categories) && !is_wp_error($categories)) : ?>
                            <ul class="space-y-3">
                                <?php foreach ($categories as $cat) : ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary no-underline transition-colors flex items-center group">
                                            <svg class="w-3 h-3 mr-2 text-gray-400 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            <?php echo esc_html($cat->name); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; 
                    endif; ?>
                </div>

                <!-- Column 4: Newsletter -->
                <div>
                    <?php if ($show_newsletter) : ?>
                        <h3 class="text-gray-900 dark:text-white font-bold uppercase tracking-wider text-xs mb-6">
                            <?php echo esc_html(boldmcqspro_get_option('boldmcqspro_footer_newsletter_title', 'Newsletter')); ?>
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            <?php echo esc_html(boldmcqspro_get_option('boldmcqspro_footer_newsletter_desc', 'Get the latest MCQs and updates delivered to your inbox.')); ?>
                        </p>
                        <form class="space-y-3">
                            <div class="relative">
                                <input type="email" placeholder="Your Email" class="w-full px-4 py-3 text-sm bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none text-gray-900 dark:text-white">
                            </div>
                            <button type="button" class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-4 rounded-lg transition-all text-sm">
                                Subscribe Now
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        <?php endif; ?>
    </div>
</div>

