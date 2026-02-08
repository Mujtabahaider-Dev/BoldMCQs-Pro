<!-- Site Branding -->
<div class="flex items-center space-x-2">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center space-x-2">
        <?php 
        $logo = boldmcqspro_get_option('boldmcqspro_logo');
        $show_title = boldmcqspro_get_option('boldmcqspro_show_site_title', true);
        
        if ($logo) : ?>
            <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="h-8 w-auto">
        <?php else : ?>
            <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg"><?php echo esc_html(substr(get_bloginfo('name'), 0, 1)); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if ($show_title) : ?>
            <span class="text-xl font-bold text-gray-900 dark:text-white"><?php echo esc_html(get_bloginfo('name')); ?></span>
        <?php endif; ?>
    </a>
</div>
