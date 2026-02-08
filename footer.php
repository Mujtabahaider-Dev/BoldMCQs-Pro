<!-- Footer -->
<footer class="mt-16">
    <?php get_template_part('template-parts/footer/widgets'); ?>
    
    <div class="bg-white dark:bg-gray-800 border-t dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center">
            <div class="flex flex-col md:flex-row justify-center md:justify-between items-center space-y-4 md:space-y-0">
                <div class="text-sm text-gray-600 dark:text-gray-400 text-center md:text-left">
                    <?php echo wp_kses_post(boldmcqspro_get_option('boldmcqspro_footer_copyright', '© 2025 BoldMcqs Pro. All rights reserved.')); ?>
                </div>
                
                <?php if (has_nav_menu('footer')) : ?>
                    <nav class="flex justify-center space-x-6">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'flex space-x-6',
                            'container'      => false,
                            'depth'          => 1,
                            'link_before'    => '<span class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary transition-colors no-underline">',
                            'link_after'     => '</span>',
                        ));
                        ?>
                    </nav>
                <?php endif; ?>
                
                <?php if (has_nav_menu('social')) : ?>
                    <div class="flex justify-center space-x-3">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'social',
                            'menu_class'     => 'flex space-x-3',
                            'container'      => false,
                            'depth'          => 1,
                            'walker'         => new BoldMcqsPro_Social_Walker_Nav_Menu(),
                        ));
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>