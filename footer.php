<!-- Footer -->
<footer class="mt-16">
    <?php get_template_part('template-parts/footer/widgets'); ?>
    
    <div class="bg-white dark:bg-gray-800 border-t dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center">
            <div class="flex flex-col md:flex-row justify-center md:justify-between items-center space-y-4 md:space-y-0">
                <div class="text-sm text-gray-600 dark:text-gray-400 text-center md:text-left">
                    <?php 
                    $copyright = boldmcqspro_get_option('boldmcqspro_footer_copyright', '© {year} BoldMcqs Pro. All rights reserved.');
                    echo wp_kses_post(str_replace('{year}', date('Y'), $copyright)); 
                    ?>
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
                
                <?php boldmcqspro_display_social_links('flex justify-center space-x-3', 'w-5 h-5 transition-colors'); ?>
            </div>
        </div>
    </div>
</footer>

<?php if (boldmcqspro_get_option('boldmcqspro_back_to_top', true)) : ?>
<!-- Back to Top -->
<button id="backToTop" class="fixed bottom-8 right-8 p-3 bg-primary text-white rounded-full shadow-lg transform translate-y-20 opacity-0 transition-all duration-300 hover:bg-primary/90 focus:outline-none z-50">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
</button>
<script>
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            backToTop.classList.remove('translate-y-20', 'opacity-0');
        } else {
            backToTop.classList.add('translate-y-20', 'opacity-0');
        }
    });
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
<?php endif; ?>
<?php wp_footer(); ?>
</body>

</html>