<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 border dark:border-gray-700'); ?>>
            <header class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    <?php the_title(); ?>
                </h1>
                <?php if (get_the_excerpt()) : ?>
                    <div class="text-lg text-gray-600 dark:text-gray-400">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
            </header>

            <div class="prose prose-lg max-w-none dark:prose-invert prose-primary">
                <?php the_content(); ?>
            </div>

            <?php
            wp_link_pages(array(
                'before' => '<div class="page-links mt-8 pt-6 border-t dark:border-gray-600"><span class="page-links-title text-gray-600 dark:text-gray-400">' . __('Pages:', 'boldmcqspro') . '</span>',
                'after'  => '</div>',
                'link_before' => '<span class="inline-block px-3 py-1 mx-1 bg-primary text-white rounded">',
                'link_after'  => '</span>',
            ));
            ?>

            <?php if (comments_open() || get_comments_number()) : ?>
                <div class="mt-8 pt-8 border-t dark:border-gray-600">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
