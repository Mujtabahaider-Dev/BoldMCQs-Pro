<?php get_header(); ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Breadcrumbs -->
            <?php boldmcqspro_breadcrumbs(); ?>
            
            <?php while (have_posts()) : the_post(); ?>
                <?php if (get_post_type() === 'mcqs') : ?>
                    <!-- MCQ Single View -->
                    <div class="mcq-card bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 border dark:border-gray-700">
                        <header class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <?php
                                    $categories = get_the_terms(get_the_ID(), 'mcq_category');
                                    if ($categories && !is_wp_error($categories)) :
                                        foreach ($categories as $category) : ?>
                                            <span class="px-3 py-1 bg-primary text-white text-sm rounded-full">
                                                <?php echo esc_html($category->name); ?>
                                            </span>
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo get_the_date(); ?>
                                </div>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                <?php the_title(); ?>
                            </h1>
                        </header>

                        <?php
                        // Get MCQ meta fields
                        $option_a = get_post_meta(get_the_ID(), 'mcq_option_a', true);
                        $option_b = get_post_meta(get_the_ID(), 'mcq_option_b', true);
                        $option_c = get_post_meta(get_the_ID(), 'mcq_option_c', true);
                        $option_d = get_post_meta(get_the_ID(), 'mcq_option_d', true);
                        $correct_option = get_post_meta(get_the_ID(), 'mcq_correct_option', true);
                        $explanation = get_post_meta(get_the_ID(), 'mcq_explanation', true);

                        $options = array($option_a, $option_b, $option_c, $option_d);
                        $options = array_filter($options); // Remove empty options
                        ?>

                        <?php if (!empty($options)) : ?>
                            <div class="space-y-2.5 mcq-options mb-6">
                                <?php
                                $option_letters = array('A', 'B', 'C', 'D');
                                foreach ($options as $index => $option) :
                                    if (!empty(trim($option))) :
                                        $is_correct = $correct_option === $option_letters[$index];
                                ?>
                                <div class="mcq-option flex items-center gap-3 p-3.5 rounded-xl border-2 transition-all duration-200
                                    <?php echo $is_correct ? 'mcq-correct border-emerald-400' : 'border-gray-200 dark:border-gray-600'; ?>"
                                    <?php if ($is_correct) echo 'style="background: rgba(16,185,129,0.12); border-color: #10b981;"'; ?>
                                    data-option-index="<?php echo $index; ?>"
                                    data-mcq-id="<?php echo get_the_ID(); ?>">

                                    <!-- Letter circle badge -->
                                    <div class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm
                                        <?php echo $is_correct ? 'bg-emerald-500 text-white' : 'bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-300'; ?>">
                                        <?php echo $option_letters[$index]; ?>
                                    </div>

                                    <!-- Option text -->
                                    <span class="flex-1 text-sm sm:text-base font-medium
                                        <?php echo $is_correct ? 'text-emerald-700 dark:text-emerald-300 font-semibold' : 'text-gray-700 dark:text-gray-300'; ?>">
                                        <?php echo esc_html($option); ?>
                                    </span>

                                    <!-- Correct SVG checkmark badge -->
                                    <?php if ($is_correct) : ?>
                                    <div class="shrink-0 w-7 h-7 rounded-full bg-emerald-500 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        <?php endif; ?>


                        <?php if (!empty($explanation)) : ?>
                            <div class="mt-6 p-4 bg-primary/5 dark:bg-primary/10 border-l-4 border-primary rounded-r-lg">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">📝 Explanation</h4>
                                <p class="text-gray-700 dark:text-gray-300">
                                    <?php echo wp_kses_post($explanation); ?>
                                </p>
                            </div>
                        <?php endif; ?>

                        <!-- Post Content Area -->
                        <?php if (!empty(get_the_content())) : ?>
                        <div class="mt-6 pt-6 border-t dark:border-gray-600">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-primary/10">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </span>
                                <h4 class="font-semibold text-gray-900 dark:text-white text-sm tracking-wide uppercase">Additional Information</h4>
                            </div>
                            <div class="additional-info-content text-gray-700 dark:text-gray-300 leading-relaxed space-y-3 text-sm">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <?php endif; ?>


                        <!-- Share Icons -->
                        <div class="mt-6 pt-6 border-t dark:border-gray-600">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-4">🔗 Share This Question</h4>
                            <div class="flex flex-wrap items-center gap-3">
                                <?php
                                $post_url = get_permalink();
                                $post_title = get_the_title();
                                $post_excerpt = wp_trim_words(get_the_content(), 20);
                                ?>
                                
                                <!-- Facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($post_url); ?>" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    Facebook
                                </a>
                                
                                <!-- Twitter -->
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($post_url); ?>&text=<?php echo urlencode($post_title . ' - ' . $post_excerpt); ?>" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                    Twitter
                                </a>
                                
                                <!-- LinkedIn -->
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($post_url); ?>" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                    LinkedIn
                                </a>
                                
                                <!-- WhatsApp -->
                                <a href="https://wa.me/?text=<?php echo urlencode($post_title . ' - ' . $post_url); ?>" 
                                   target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                    </svg>
                                    WhatsApp
                                </a>
                                
                                <!-- Copy Link -->
                                <button onclick="copyToClipboard('<?php echo esc_js($post_url); ?>')" 
                                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Copy Link
                                </button>
                            </div>
                        </div>

                       
                    </div>

                    <!-- Enhanced Navigation to other MCQs -->
                    <div class="mt-8">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-4">🧭 Navigate Questions</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php
                        $prev_post = get_previous_post(false, '', 'mcq_category');
                        $next_post = get_next_post(false, '', 'mcq_category');
                        ?>
                            
                            <!-- Previous MCQ -->
                            <div class="order-2 md:order-1">
                            <?php if ($prev_post) : ?>
                                    <a href="<?php echo get_permalink($prev_post); ?>" class="group block p-4 bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 hover:shadow-md">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Previous Question</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate group-hover:text-primary transition-colors">
                                                    <?php echo esc_html($prev_post->post_title); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                <?php else : ?>
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Previous Question</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">No previous question</p>
                                            </div>
                                        </div>
                                    </div>
                            <?php endif; ?>
                        </div>
                            
                            <!-- Next MCQ -->
                            <div class="order-1 md:order-2">
                            <?php if ($next_post) : ?>
                                    <a href="<?php echo get_permalink($next_post); ?>" class="group block p-4 bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 hover:shadow-md">
                                        <div class="flex items-center">
                                            <div class="flex-1 min-w-0 text-right md:text-left">
                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Next Question</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate group-hover:text-primary transition-colors">
                                                    <?php echo esc_html($next_post->post_title); ?>
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0 ml-3">
                                                <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                                    <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php else : ?>
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="flex-1 text-right md:text-left">
                                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Next Question</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">No next question</p>
                                            </div>
                                            <div class="flex-shrink-0 ml-3">
                                                <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Back to Questions List -->
                        <div class="mt-4 text-center">
                            <a href="<?php echo home_url(); ?>" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v0a2 2 0 01-2 2H10a2 2 0 01-2-2v0z" />
                                </svg>
                                Back to All Questions
                            </a>
                        </div>
                    </div>

                <?php else : ?>
                    <!-- Regular Post Single View -->
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 border dark:border-gray-700'); ?>>
                        <header class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <?php
                                    $categories = get_the_category();
                                    if ($categories) :
                                        foreach ($categories as $category) : ?>
                                            <a href="<?php echo get_category_link($category->term_id); ?>" class="px-3 py-1 bg-primary text-white text-sm rounded-full hover:bg-primary/80 transition-colors">
                                                <?php echo esc_html($category->name); ?>
                                            </a>
                                    <?php endforeach;
                                    endif; ?>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo get_the_date(); ?>
                                </div>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                                <?php the_title(); ?>
                            </h1>
                            <div class="flex items-center space-x-4 mt-4 text-sm text-gray-500 dark:text-gray-400">
                                <span>👤 <?php echo esc_html(get_the_author()); ?></span>
                                <span>💬 <?php comments_number('0 Comments', '1 Comment', '% Comments'); ?></span>
                            </div>
                        </header>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="mb-6">
                                <?php the_post_thumbnail('large', array('class' => 'w-full h-64 object-cover rounded-lg')); ?>
                            </div>
                        <?php endif; ?>

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

                        <?php
                        $tags = get_the_tags();
                        if ($tags) : ?>
                            <div class="mt-6 pt-6 border-t dark:border-gray-600">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Tags:</span>
                                    <?php foreach ($tags as $tag) : ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-sm rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </article>

                    <!-- Post Navigation -->
                    <div class="mt-8 flex justify-between">
                        <div>
                            <?php
                            $prev_post = get_previous_post();
                            if ($prev_post) : ?>
                                <a href="<?php echo get_permalink($prev_post); ?>" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Previous Post
                                </a>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php
                            $next_post = get_next_post();
                            if ($next_post) : ?>
                                <a href="<?php echo get_permalink($next_post); ?>" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    Next Post
                                    <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (comments_open() || get_comments_number()) : ?>
                        <div class="mt-8">
                            <?php comments_template(); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Related MCQs -->
                <?php if (get_post_type() === 'mcqs') :
                    $categories    = get_the_terms(get_the_ID(), 'mcq_category');
                    $category_ids  = ($categories && !is_wp_error($categories)) ? wp_list_pluck($categories, 'term_id') : [];
                    $related_mcqs  = new WP_Query(array(
                        'post_type'      => 'mcqs',
                        'post__not_in'   => array(get_the_ID()),
                        'posts_per_page' => 5,
                        'orderby'        => 'rand',
                        'tax_query'      => $category_ids ? array(array(
                            'taxonomy' => 'mcq_category',
                            'field'    => 'term_id',
                            'terms'    => $category_ids,
                        )) : '',
                    ));
                ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

                    <!-- Header -->
                    <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-primary/10">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </span>
                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm tracking-wide uppercase">Related MCQs</h3>
                    </div>

                    <?php if ($related_mcqs->have_posts()) : ?>
                    <!-- Items -->
                    <ul class="divide-y divide-gray-50 dark:divide-gray-700/60">
                        <?php $rel_num = 1; while ($related_mcqs->have_posts()) : $related_mcqs->the_post();
                            $rel_cats    = get_the_terms(get_the_ID(), 'mcq_category');
                            $rel_cat_name = ($rel_cats && !is_wp_error($rel_cats)) ? $rel_cats[0]->name : '';
                        ?>
                        <li>
                            <a href="<?php echo get_permalink(); ?>"
                               class="group flex items-start gap-3 px-4 py-3.5 hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors duration-150 no-underline">
                                <!-- Number badge -->
                                <span class="shrink-0 mt-0.5 w-6 h-6 rounded-full bg-primary/10 text-primary text-xs font-bold flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-150">
                                    <?php echo $rel_num; ?>
                                </span>
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-100 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-150 leading-snug line-clamp-2">
                                        <?php the_title(); ?>
                                    </p>
                                    <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                        <?php if ($rel_cat_name) : ?>
                                        <span class="inline-block px-2 py-0.5 bg-primary/8 dark:bg-primary/15 text-primary text-xs rounded-full font-medium">
                                            <?php echo esc_html($rel_cat_name); ?>
                                        </span>
                                        <?php endif; ?>
                                        <span class="text-xs text-gray-400 dark:text-gray-500">
                                            <?php echo get_the_date('M j, Y'); ?>
                                        </span>
                                    </div>
                                </div>
                                <!-- Arrow -->
                                <svg class="shrink-0 w-3.5 h-3.5 text-gray-300 dark:text-gray-600 group-hover:text-primary group-hover:translate-x-0.5 transition-all duration-150 mt-1" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </li>
                        <?php $rel_num++; endwhile; wp_reset_postdata(); ?>
                    </ul>

                    <?php else : ?>
                    <!-- Empty state -->
                    <div class="flex flex-col items-center justify-center py-8 px-5 text-center">
                        <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-2.5">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No related questions found</p>
                    </div>
                    <?php wp_reset_postdata(); endif; ?>

                </div>
                <?php endif; ?>


                <!-- Categories -->
                <?php get_template_part('template-parts/sidebar/categories'); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
