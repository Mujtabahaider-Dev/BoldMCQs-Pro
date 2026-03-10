<?php get_header(); ?>

<?php
// Custom search query to prioritize MCQs and search within question content
$search_query = get_search_query();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

if (!empty($search_query)) {
    // Create custom query to search specifically in MCQs
    $mcq_search_args = array(
        'post_type' => 'mcqs',
        'post_status' => 'publish',
        'posts_per_page' => 20,
        'paged' => $paged,
        's' => $search_query,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'mcq_option_a',
                'value' => $search_query,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'mcq_option_b',
                'value' => $search_query,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'mcq_option_c',
                'value' => $search_query,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'mcq_option_d',
                'value' => $search_query,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'mcq_explanation',
                'value' => $search_query,
                'compare' => 'LIKE'
            )
        )
    );
    
    // First try to search with meta query
    $mcq_search_query = new WP_Query($mcq_search_args);
    $total_mcq_results = $mcq_search_query->found_posts;
    
    // If no results found, try a broader search in post content
    if ($total_mcq_results == 0) {
        $broader_search_args = array(
            'post_type' => 'mcqs',
            'post_status' => 'publish',
            'posts_per_page' => 20,
            'paged' => $paged,
            's' => $search_query
        );
        
        $mcq_search_query = new WP_Query($broader_search_args);
        $total_mcq_results = $mcq_search_query->found_posts;
    }
} else {
    $mcq_search_query = null;
    $total_mcq_results = 0;
}
?>

<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
        <!-- Main Content -->
        <div class="order-1 lg:col-span-2">
            <!-- Breadcrumbs -->
            <?php boldmcqspro_breadcrumbs(); ?>
            
            <!-- Search Header -->
            <div class="mb-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">🔍</span>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            Search Results
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400">
                            Searching for: "<strong><?php echo esc_html($search_query); ?></strong>"
                        </p>
                    </div>
                </div>

                <!-- Results count -->
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <?php if ($total_mcq_results > 0) : ?>
                        <span class="text-green-600 dark:text-green-400 font-medium">
                            <?php printf(_n('%d question found', '%d questions found', $total_mcq_results, 'boldmcqspro'), $total_mcq_results); ?>
                        </span>
                        <span class="text-gray-500"> - Searching within question content, options, and explanations</span>
                    <?php else : ?>
                        <span class="text-red-600 dark:text-red-400">No questions found</span>
                        <span class="text-gray-500"> - Try different keywords or check spelling</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quiz Mode Toggle -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white"><?php echo esc_html(boldmcqspro_get_option('boldmcqspro_homepage_mcqs_title', 'Practice Questions')); ?></h2>
                <?php if (boldmcqspro_get_option('boldmcqspro_show_quiz_mode_btn', true)) : ?>
                <button id="quizModeBtn"
                    class="btn-base btn-full btn-primary quiz-mode-btn">
                    🎯 Start Quiz Mode
                </button>
                <?php endif; ?>
            </div>
            
            <!-- Quiz Mode Banner (Hidden by default) -->
            <div id="quizBanner"
                class="hidden mb-6 p-4 bg-accent/10 border-l-4 border-accent rounded-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Quiz Mode Active</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Select your answers and track your progress
                        </p>
                    </div>
                    <button id="exitQuizBtn"
                        class="btn-base btn-full btn-danger">
                        Exit Quiz
                    </button>
                </div>
            </div>

            <!-- MCQ Cards -->
            <div id="mcqContainer" class="space-y-6">
                    <?php
                if ($mcq_search_query && $mcq_search_query->have_posts()) :
                    $question_number = 1;
                    while ($mcq_search_query->have_posts()) : $mcq_search_query->the_post();
                        // Get MCQ meta fields
                        $option_a = get_post_meta(get_the_ID(), 'mcq_option_a', true);
                        $option_b = get_post_meta(get_the_ID(), 'mcq_option_b', true);
                        $option_c = get_post_meta(get_the_ID(), 'mcq_option_c', true);
                        $option_d = get_post_meta(get_the_ID(), 'mcq_option_d', true);
                        $correct_option = get_post_meta(get_the_ID(), 'mcq_correct_option', true);
                        $explanation = get_post_meta(get_the_ID(), 'mcq_explanation', true);
                        
                        // Get categories and author
                        $categories = get_the_terms(get_the_ID(), 'mcq_category');
                        $category_name = !empty($categories) ? $categories[0]->name : 'General';
                        $author_name = get_the_author();
                        
                        // Create options array
                        $options = array($option_a, $option_b, $option_c, $option_d);
                        $options = array_filter($options); // Remove empty options
                        
                        if (!empty($options) && !empty(get_the_title())) :
                            // Get MCQ card styling from customizer
                            $card_style = boldmcqspro_get_option('boldmcqspro_mcq_card_style', 'default');
                            $card_classes = 'mcq-card transition-all duration-200 hover:shadow-lg';
                            
                            // Apply card styling
                            switch ($card_style) {
                                case 'minimal':
                                    $card_classes .= ' bg-white dark:bg-gray-800 p-6 border-b border-gray-200 dark:border-gray-700';
                                    break;
                                case 'bordered':
                                    $card_classes .= ' bg-white dark:bg-gray-800 p-6 border-2 border-gray-300 dark:border-gray-600';
                                    break;
                                case 'gradient':
                                    $card_classes .= ' bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md p-6 border dark:border-gray-700';
                                    break;
                                default:
                                    $card_classes .= ' bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border dark:border-gray-700';
                            }
                        ?>
                <div class="<?php echo esc_attr($card_classes); ?>" 
                     data-mcq-id="<?php echo get_the_ID(); ?>" 
                     data-correct-option="<?php echo esc_attr($correct_option); ?>">
                                <div class="mb-4">
                        <?php if (boldmcqspro_get_option('boldmcqspro_show_mcq_numbers', false)) : ?>
                        <div class="mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary text-white">
                                Q<?php echo $question_number; ?>
                                                    </span>
                                        </div>
                        <?php endif; ?>
                        
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            <?php if (boldmcqspro_get_option('boldmcqspro_enable_mcq_links', true)) : ?>
                            <a href="<?php echo get_permalink(); ?>" 
                               class="text-gray-900 dark:text-white hover:text-primary dark:hover:text-primary transition-colors duration-200 no-underline hover:underline"
                               title="View full question details">
                                            <?php
                                            $title = get_the_title();
                                            if ($search_query) {
                                                $highlighted_title = str_ireplace($search_query, '<mark class="bg-yellow-200 dark:bg-yellow-600">' . $search_query . '</mark>', $title);
                                                echo $highlighted_title;
                                            } else {
                                                echo esc_html($title);
                                            }
                                            ?>
                                        </a>
                            <?php else : ?>
                                <?php
                                $title = get_the_title();
                                if ($search_query) {
                                    $highlighted_title = str_ireplace($search_query, '<mark class="bg-yellow-200 dark:bg-yellow-600">' . $search_query . '</mark>', $title);
                                    echo $highlighted_title;
                                } else {
                                    echo esc_html($title);
                                }
                                ?>
                            <?php endif; ?>
                                    </h3>
                        <div class="space-y-2 mcq-options">
                                    <?php
                            $option_letters = array('A', 'B', 'C', 'D');
                            foreach ($options as $index => $option) :
                                                if (!empty(trim($option))) :
                                            ?>
                            <div class="mcq-option flex items-center p-3 rounded-lg border-2 cursor-pointer transition-all duration-200 border-gray-200 dark:border-gray-600 hover:border-primary hover:bg-primary/5" 
                                 data-option-index="<?php echo $index; ?>" 
                                 data-mcq-id="<?php echo get_the_ID(); ?>">
                                <div class="flex items-center space-x-3">
                                    <div class="quiz-radio w-4 h-4 rounded-full border-2 border-gray-300 hidden items-center justify-center"></div>
                                    <span class="flex-1">
                                        <span class='practice-letter font-semibold mr-2'><?php echo $option_letters[$index]; ?>.</span> 
                                                        <?php
                                                        if ($search_query) {
                                                            echo str_ireplace($search_query, '<mark class="bg-yellow-200 dark:bg-yellow-600">' . $search_query . '</mark>', esc_html($option));
                                                        } else {
                                                            echo esc_html($option);
                                                        }
                                                        ?>
                                                    </span>
                                    <span class="correct-indicator hidden">✓</span>
                                </div>
                                                </div>
                                            <?php 
                                                endif;
                                            endforeach; 
                            ?>
                        </div>
                                                </div>
                    <?php if (boldmcqspro_get_option('boldmcqspro_show_explanation_btn', true) || boldmcqspro_get_option('boldmcqspro_show_explanations', false)) : ?>
                    <div class="mt-6">
                        <?php if (boldmcqspro_get_option('boldmcqspro_show_explanation_btn', true)) : ?>
                        <button onclick="toggleExplanation(<?php echo get_the_ID(); ?>)" 
                                class="flex items-center space-x-2 text-primary hover:text-primary/70 font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Show Explanation</span>
                        </button>
                                            <?php endif; ?>
                        
                        <?php 
                        // Determine if explanation should be visible by default
                        $show_by_default = boldmcqspro_get_option('boldmcqspro_show_explanations', false);
                        $explanation_class = $show_by_default ? '' : 'hidden';
                        ?>
                        <div id="explanation-<?php echo get_the_ID(); ?>" 
                             class="<?php echo $explanation_class; ?> mt-4 p-4 bg-primary/5 dark:bg-primary/10 border-l-4 border-primary rounded-r-lg">
                            <p class="text-gray-700 dark:text-gray-300 mb-2">
                                <?php 
                                $explanation_text = !empty($explanation) ? $explanation : 'No explanation provided for this question.';
                                if ($search_query) {
                                    echo str_ireplace($search_query, '<mark class="bg-yellow-200 dark:bg-yellow-600">' . $search_query . '</mark>', esc_html($explanation_text));
                                } else {
                                    echo esc_html($explanation_text);
                                }
                                ?>
                            </p>
                        </div>
                                        </div>
                                    <?php endif; ?>

                    <?php if (boldmcqspro_get_option('boldmcqspro_show_author', true) || boldmcqspro_get_option('boldmcqspro_show_categories', true) || boldmcqspro_get_option('boldmcqspro_show_date', true) || boldmcqspro_get_option('boldmcqspro_show_difficulty', false)) : ?>
                    <div class="mt-4 pt-4 border-t dark:border-gray-600 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-4">
                            <?php if (boldmcqspro_get_option('boldmcqspro_show_author', true)) : ?>
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 bg-primary/5 dark:bg-primary/10 rounded-full border border-primary/10">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary/60"></span>
                                <span class="text-xs font-bold text-primary/80 tracking-tight"><?php echo esc_html($author_name); ?></span>
                            </span>
                            <?php endif; ?>
                            
                            <?php if (boldmcqspro_get_option('boldmcqspro_show_categories', true)) : ?>
                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-[10px] sm:text-xs font-semibold text-gray-500 dark:text-gray-400">
                                <?php echo esc_html($category_name); ?>
                            </span>
                            <?php endif; ?>
                            
                            <?php if (boldmcqspro_get_option('boldmcqspro_show_difficulty', false)) : ?>
                                <?php 
                                // Get difficulty level from meta or use default
                                $difficulty = get_post_meta(get_the_ID(), 'mcq_difficulty', true);
                                if (empty($difficulty)) {
                                    $difficulty = boldmcqspro_get_option('boldmcqspro_default_difficulty', 'medium');
                                }
                                
                                $difficulty_colors = array(
                                    'easy'   => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', 
                                    'hard'   => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                );
                                
                                $difficulty_icons = array(
                                    'easy'   => '🟢',
                                    'medium' => '🟡',
                                    'hard'   => '🔴'
                                );
                                
                                $color_class = isset($difficulty_colors[$difficulty]) ? $difficulty_colors[$difficulty] : $difficulty_colors['medium'];
                                $icon = isset($difficulty_icons[$difficulty]) ? $difficulty_icons[$difficulty] : $difficulty_icons['medium'];
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $color_class; ?>">
                                    <?php echo $icon; ?> <?php echo esc_html(ucfirst($difficulty)); ?>
                                </span>
                            <?php endif; ?>
                            </div>
                        
                        <?php if (boldmcqspro_get_option('boldmcqspro_show_date', true)) : ?>
                        <div class="text-xs text-gray-600 dark:text-gray-400">
                            <?php echo get_the_date('M j, Y'); ?>
                </div>
                        <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php 
                            $question_number++;
                            endif;
                    endwhile;
                else :
                ?>
                <div class="text-center py-12">
                    <div class="mb-4">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No MCQs Found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        Sorry, we couldn't find any MCQs matching "<strong><?php echo esc_html($search_query); ?></strong>".
                    </p>
                    
                    <!-- Search Suggestions -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 mb-6 text-left max-w-md mx-auto">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">💡 Search Tips</h4>
                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <li>• Try different keywords or phrases</li>
                            <li>• Check your spelling</li>
                            <li>• Use more general terms</li>
                            <li>• Try searching for categories or tags</li>
                        </ul>
                    </div>
                    
                    <div class="space-x-4">
                        <a href="<?php echo esc_url(home_url('/')); ?>" 
                           class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/80 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Back to Home
                        </a>
                        <?php if (get_post_type_archive_link('mcqs')) : ?>
                            <a href="<?php echo get_post_type_archive_link('mcqs'); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-secondary text-white rounded-lg hover:bg-secondary/80 transition-colors">
                                <span>🎯</span>
                                <span class="ml-2">Browse MCQs</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
            
            <!-- Dynamic Pagination -->
            <?php 
            if ($mcq_search_query && $mcq_search_query->max_num_pages > 1) : 
                $current_page = max(1, $paged);
                $total_pages = $mcq_search_query->max_num_pages;
            ?>
            <div class="mt-8">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <!-- Page Numbers -->
                    <div class="flex items-center space-x-2">
                        <?php if ($current_page > 1) : ?>
                            <a href="<?php echo add_query_arg('paged', $current_page - 1, get_search_link($search_query)); ?>" 
                               class="px-3 py-2 bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        <?php else : ?>
                            <span class="px-3 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-400 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        <?php endif; ?>
                        
                        <div class="flex space-x-1">
                            <?php
                            // Calculate page range to display
                            $start_page = max(1, $current_page - 2);
                            $end_page = min($total_pages, $current_page + 2);
                            
                            // Show first page if not in range
                            if ($start_page > 1) :
                            ?>
                                <a href="<?php echo add_query_arg('paged', 1, get_search_link($search_query)); ?>" 
                                   class="px-3 py-2 bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300">
                                    1
                                </a>
                                <?php if ($start_page > 2) : ?>
                                    <span class="px-3 py-2 text-gray-500 dark:text-gray-400">...</span>
                                <?php endif; ?>
        <?php endif; ?>
                            
                            <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                                <?php if ($i == $current_page) : ?>
                                    <span class="px-3 py-2 bg-primary text-white rounded-lg font-medium"><?php echo $i; ?></span>
                                <?php else : ?>
                                    <a href="<?php echo add_query_arg('paged', $i, get_search_link($search_query)); ?>" 
                                       class="px-3 py-2 bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endfor; ?>
                            
                            <!-- Show last page if not in range -->
                            <?php if ($end_page < $total_pages) : ?>
                                <?php if ($end_page < $total_pages - 1) : ?>
                                    <span class="px-3 py-2 text-gray-500 dark:text-gray-400">...</span>
                                <?php endif; ?>
                                <a href="<?php echo add_query_arg('paged', $total_pages, get_search_link($search_query)); ?>" 
                                   class="px-3 py-2 bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300">
                                    <?php echo $total_pages; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($current_page < $total_pages) : ?>
                            <a href="<?php echo add_query_arg('paged', $current_page + 1, get_search_link($search_query)); ?>" 
                               class="px-3 py-2 bg-white dark:bg-gray-800 border dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        <?php else : ?>
                            <span class="px-3 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-400 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Page Info and Jump to Page -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            Page <?php echo $current_page; ?> of <?php echo $total_pages; ?>
                        </span>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Jump to:</span>
                            <form method="get" class="flex items-center space-x-2" onsubmit="return jumpToPage(event)">
                                <input type="hidden" name="s" value="<?php echo esc_attr($search_query); ?>">
                                <input type="number" 
                                       id="jumpPageInput"
                                       name="paged" 
                                       placeholder="Page" 
                                       min="1" 
                                       max="<?php echo $total_pages; ?>"
                                       class="w-16 px-2 py-1 border dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-center text-gray-700 dark:text-gray-300">
                                <button type="submit"
                                        class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors text-gray-700 dark:text-gray-300">
                                    Go
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="order-2 lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                
                <?php if (boldmcqspro_get_option('boldmcqspro_show_search_box', true)) : ?>
                <!-- Search -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border dark:border-gray-700">
                    <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative">
                        <input type="search" 
                               name="s" 
                               placeholder="Search questions..."
                               value="<?php echo esc_attr($search_query); ?>"
                               class="w-full pl-10 pr-4 py-3 border dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                        <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <?php endif; ?>

                <?php if (boldmcqspro_get_option('boldmcqspro_show_top_contributors', true)) : ?>
                <!-- Top Contributors -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border dark:border-gray-700">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Top Contributors</h3>
                    </div>
                    <div class="space-y-3">
                        <?php
                        // Get top contributors by MCQ count
                        global $wpdb;
                        $top_contributors = $wpdb->get_results(
                            "SELECT u.ID, u.display_name, u.user_email, COUNT(p.ID) as mcq_count
                            FROM {$wpdb->users} u
                            INNER JOIN {$wpdb->posts} p ON u.ID = p.post_author
                            WHERE p.post_type = 'mcqs' AND p.post_status = 'publish'
                            GROUP BY u.ID
                            HAVING mcq_count > 0
                            ORDER BY mcq_count DESC
                            LIMIT 5"
                        );
                        
                        if (!empty($top_contributors)) :
                            $bg_classes = [
                                'bg-primary',
                                'bg-secondary',
                                'bg-accent',
                                'bg-blue-600',
                                'bg-purple-600'
                            ];
                            
                            foreach ($top_contributors as $index => $contributor) :
                                $initials = '';
                                $name_parts = explode(' ', trim($contributor->display_name));
                                foreach ($name_parts as $part) {
                                    if (!empty($part)) {
                                        $initials .= strtoupper(substr($part, 0, 1));
                                    }
                                }
                                $initials = substr($initials, 0, 2); // Max 2 initials
                                $bg_class = $bg_classes[$index % count($bg_classes)];
                        ?>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 <?php echo $bg_class; ?> rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm"><?php echo esc_html($initials); ?></span>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900 dark:text-white"><?php echo esc_html($contributor->display_name); ?></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo $contributor->mcq_count; ?> MCQ<?php echo $contributor->mcq_count > 1 ? 's' : ''; ?></p>
                            </div>
                        </div>
                        <?php
                            endforeach;
                        else :
                        ?>
                        <div class="text-center py-4">
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No contributors yet</p>
                            <?php if (current_user_can('publish_posts')) : ?>
                                <a href="<?php echo admin_url('post-new.php?post_type=mcqs'); ?>" class="text-primary hover:text-primary/70 text-sm mt-2 inline-block no-underline">Be the first contributor!</a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (boldmcqspro_get_option('boldmcqspro_show_categories_widget', true)) : ?>
                <!-- Categories -->
                <?php get_template_part('template-parts/sidebar/categories'); ?>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>