<?php
// Get footer columns from customizer
$footer_columns = boldmcqspro_get_option('boldmcqspro_footer_columns', 4);
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

if ($has_widgets) : ?>
    <div class="bg-gray-100 dark:bg-gray-900 border-t dark:border-gray-700 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid <?php echo esc_attr($grid_classes[$footer_columns]); ?> gap-8">
                <?php for ($i = 1; $i <= $footer_columns; $i++) : ?>
                    <?php if (is_active_sidebar('footer-widget-' . $i)) : ?>
                        <div class="footer-column">
                            <?php dynamic_sidebar('footer-widget-' . $i); ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
