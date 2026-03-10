<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * BoldMCQs Pro SEO Functions
 * Comprehensive SEO optimization for MCQs
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add structured data (Schema.org) for MCQs
 */
function boldmcqspro_add_mcq_schema() {
    if (is_singular('mcqs')) {
        global $post;
        
        // Get MCQ data
        $mcq_options = get_post_meta($post->ID, '_mcq_options', true);
        $mcq_correct_answer = get_post_meta($post->ID, '_mcq_correct_answer', true);
        $mcq_explanation = get_post_meta($post->ID, '_mcq_explanation', true);
        $mcq_difficulty = get_post_meta($post->ID, '_mcq_difficulty', true);
        $mcq_categories = wp_get_post_terms($post->ID, 'mcq_category', array('fields' => 'names'));
        $mcq_tags = wp_get_post_terms($post->ID, 'mcq_tag', array('fields' => 'names'));
        
        // Build schema data
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Quiz',
            'name' => get_the_title(),
            'description' => get_the_excerpt() ?: wp_trim_words(get_the_content(), 20),
            'url' => get_permalink(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url()
            )
        );
        
        // Add categories as keywords
        if (!empty($mcq_categories)) {
            $schema['keywords'] = implode(', ', $mcq_categories);
        }
        
        // Add difficulty level
        if (!empty($mcq_difficulty)) {
            $schema['educationalLevel'] = ucfirst($mcq_difficulty);
        }
        
        // Add the main question
        if (!empty($mcq_options)) {
            $question_data = array(
                '@type' => 'Question',
                'name' => get_the_title(),
                'text' => get_the_content(),
                'answerCount' => count($mcq_options),
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => isset($mcq_options[$mcq_correct_answer]) ? $mcq_options[$mcq_correct_answer] : ''
                ),
                'suggestedAnswer' => array()
            );
            
            // Add all answer options
            foreach ($mcq_options as $index => $option) {
                $question_data['suggestedAnswer'][] = array(
                    '@type' => 'Answer',
                    'text' => $option,
                    'isCorrect' => ($index === $mcq_correct_answer)
                );
            }
            
            // Add explanation if available
            if (!empty($mcq_explanation)) {
                $question_data['acceptedAnswer']['explanation'] = $mcq_explanation;
            }
            
            $schema['hasPart'] = array($question_data);
        }
        
        // Output the schema
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
    
    // Add schema for MCQ category archives
    if (is_tax('mcq_category')) {
        $term = get_queried_object();
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $term->name . ' - MCQ Questions',
            'description' => $term->description ?: 'Multiple choice questions about ' . $term->name,
            'url' => get_term_link($term),
            'about' => array(
                '@type' => 'Thing',
                'name' => $term->name
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url()
            )
        );
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'boldmcqspro_add_mcq_schema');

/**
 * Generate dynamic meta descriptions
 */
function boldmcqspro_add_meta_description() {
    $description = '';
    
    if (is_singular('mcqs')) {
        global $post;
        $mcq_categories = wp_get_post_terms($post->ID, 'mcq_category', array('fields' => 'names'));
        $mcq_difficulty = get_post_meta($post->ID, '_mcq_difficulty', true);
        
        $category_text = !empty($mcq_categories) ? ' about ' . implode(', ', $mcq_categories) : '';
        $difficulty_text = !empty($mcq_difficulty) ? ' (' . ucfirst($mcq_difficulty) . ' level)' : '';
        
        $description = 'Test your knowledge with this multiple choice question' . $category_text . $difficulty_text . '. ' . wp_trim_words(get_the_content(), 20);
    } elseif (is_tax('mcq_category')) {
        $term = get_queried_object();
        $count = $term->count;
        $description = 'Practice with ' . $count . ' multiple choice questions about ' . $term->name . '. Test your knowledge and improve your skills.';
    } elseif (is_home() || is_front_page()) {
        $description = 'Practice with multiple choice questions across various topics. Test your knowledge, improve your skills, and track your progress with our interactive MCQ platform.';
    } elseif (is_search()) {
        $search_query = get_search_query();
        $description = 'Search results for "' . $search_query . '" - Find multiple choice questions and test your knowledge on this topic.';
    }
    
    if (!empty($description)) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }
}
add_action('wp_head', 'boldmcqspro_add_meta_description');

/**
 * Add Open Graph and Twitter Card meta tags
 */
function boldmcqspro_add_social_meta_tags() {
    $title = '';
    $description = '';
    $image = '';
    $url = '';
    $type = 'website';
    
    if (is_singular('mcqs')) {
        global $post;
        $title = get_the_title() . ' - MCQ Question';
        $mcq_categories = wp_get_post_terms($post->ID, 'mcq_category', array('fields' => 'names'));
        $category_text = !empty($mcq_categories) ? ' about ' . implode(', ', $mcq_categories) : '';
        $description = 'Test your knowledge with this multiple choice question' . $category_text . '. ' . wp_trim_words(get_the_content(), 15);
        $url = get_permalink();
        $type = 'article';
        
        // Try to get featured image
        if (has_post_thumbnail()) {
            $image = get_the_post_thumbnail_url($post->ID, 'large');
        }
    } elseif (is_tax('mcq_category')) {
        $term = get_queried_object();
        $title = $term->name . ' MCQ Questions';
        $description = 'Practice with multiple choice questions about ' . $term->name . '. Test your knowledge and improve your skills.';
        $url = get_term_link($term);
    } elseif (is_home() || is_front_page()) {
        $title = get_bloginfo('name') . ' - MCQ Practice Platform';
        $description = 'Practice with multiple choice questions across various topics. Test your knowledge and improve your skills.';
        $url = home_url();
    }
    
    // Default image if none found
    if (empty($image)) {
        $image = get_template_directory_uri() . '/assets/images/mcq-default-share.png'; // We'll create this
    }
    
    // Open Graph tags
    if (!empty($title)) {
        echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
        echo '<meta property="og:type" content="' . esc_attr($type) . '">' . "\n";
        echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
        
        if (!empty($image)) {
            echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
            echo '<meta property="og:image:width" content="1200">' . "\n";
            echo '<meta property="og:image:height" content="630">' . "\n";
        }
        
        // Twitter Card tags
        echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
        
        if (!empty($image)) {
            echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'boldmcqspro_add_social_meta_tags');

/**
 * Add canonical URLs
 */
function boldmcqspro_add_canonical_url() {
    $canonical_url = '';
    
    if (is_singular()) {
        $canonical_url = get_permalink();
    } elseif (is_tax()) {
        $canonical_url = get_term_link(get_queried_object());
    } elseif (is_home() || is_front_page()) {
        $canonical_url = home_url();
    } elseif (is_search()) {
        $canonical_url = get_search_link();
    }
    
    if (!empty($canonical_url)) {
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '">' . "\n";
    }
}
add_action('wp_head', 'boldmcqspro_add_canonical_url');

/**
 * Add hreflang tags for international SEO (if needed)
 */
function boldmcqspro_add_hreflang_tags() {
    // This can be expanded if you plan to have multiple languages
    $current_url = '';
    
    if (is_singular()) {
        $current_url = get_permalink();
    } elseif (is_tax()) {
        $current_url = get_term_link(get_queried_object());
    } elseif (is_home() || is_front_page()) {
        $current_url = home_url();
    }
    
    if (!empty($current_url)) {
        echo '<link rel="alternate" hreflang="en" href="' . esc_url($current_url) . '">' . "\n";
        echo '<link rel="alternate" hreflang="x-default" href="' . esc_url($current_url) . '">' . "\n";
    }
}
add_action('wp_head', 'boldmcqspro_add_hreflang_tags');

/**
 * Improve title tags for better SEO
 */
function boldmcqspro_custom_title_tag($title) {
    if (is_singular('mcqs')) {
        global $post;
        $mcq_categories = wp_get_post_terms($post->ID, 'mcq_category', array('fields' => 'names'));
        $mcq_difficulty = get_post_meta($post->ID, '_mcq_difficulty', true);
        
        $category_text = !empty($mcq_categories) ? ' | ' . implode(', ', $mcq_categories) : '';
        $difficulty_text = !empty($mcq_difficulty) ? ' | ' . ucfirst($mcq_difficulty) : '';
        
        return get_the_title() . ' - MCQ Question' . $category_text . $difficulty_text . ' | ' . get_bloginfo('name');
    } elseif (is_tax('mcq_category')) {
        $term = get_queried_object();
        return $term->name . ' MCQ Questions | Practice & Test Your Knowledge | ' . get_bloginfo('name');
    }
    
    return $title;
}
add_filter('pre_get_document_title', 'boldmcqspro_custom_title_tag');

/**
 * Add robots meta tag
 */
function boldmcqspro_add_robots_meta() {
    if (is_search()) {
        // Don't index search pages
        echo '<meta name="robots" content="noindex, follow">' . "\n";
    } elseif (is_404()) {
        // Don't index 404 pages
        echo '<meta name="robots" content="noindex, nofollow">' . "\n";
    } else {
        // Index all other pages
        echo '<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">' . "\n";
    }
}
add_action('wp_head', 'boldmcqspro_add_robots_meta');

/**
 * Add FAQ schema for MCQs with explanations
 */
function boldmcqspro_add_faq_schema() {
    if (is_singular('mcqs')) {
        global $post;
        
        $mcq_explanation = get_post_meta($post->ID, '_mcq_explanation', true);
        
        if (!empty($mcq_explanation)) {
            $faq_schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array(
                    array(
                        '@type' => 'Question',
                        'name' => get_the_title(),
                        'acceptedAnswer' => array(
                            '@type' => 'Answer',
                            'text' => $mcq_explanation
                        )
                    )
                )
            );
            
            echo '<script type="application/ld+json">' . wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
        }
    }
}
add_action('wp_head', 'boldmcqspro_add_faq_schema');

/**
 * Generate breadcrumb navigation
 */
function boldmcqspro_breadcrumbs() {
    // Don't show on homepage
    if (is_front_page()) {
        return;
    }
    
    $breadcrumbs = array();
    $separator = ' <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg> ';
    
    // Home link
    $breadcrumbs[] = '<a href="' . home_url() . '" class="text-primary hover:text-primary/80 transition-colors">Home</a>';
    
    if (is_singular('mcqs')) {
        // MCQ single page
        global $post;
        
        // Add MCQs archive link
        $breadcrumbs[] = '<a href="' . home_url() . '" class="text-primary hover:text-primary/80 transition-colors">MCQs</a>';
        
        // Add category if exists
        $categories = wp_get_post_terms($post->ID, 'mcq_category');
        if (!empty($categories) && !is_wp_error($categories)) {
            $category = $categories[0];
            $breadcrumbs[] = '<a href="' . get_term_link($category) . '" class="text-primary hover:text-primary/80 transition-colors">' . $category->name . '</a>';
        }
        
        // Current page
        $breadcrumbs[] = '<span class="text-gray-600 dark:text-gray-400">' . get_the_title() . '</span>';
        
    } elseif (is_tax('mcq_category')) {
        // MCQ category archive
        $term = get_queried_object();
        $breadcrumbs[] = '<a href="' . home_url() . '" class="text-primary hover:text-primary/80 transition-colors">MCQs</a>';
        $breadcrumbs[] = '<span class="text-gray-600 dark:text-gray-400">' . $term->name . '</span>';
        
    } elseif (is_tax('mcq_tag')) {
        // MCQ tag archive
        $term = get_queried_object();
        $breadcrumbs[] = '<a href="' . home_url() . '" class="text-primary hover:text-primary/80 transition-colors">MCQs</a>';
        $breadcrumbs[] = '<span class="text-gray-600 dark:text-gray-400">Tag: ' . $term->name . '</span>';
        
    } elseif (is_search()) {
        // Search results
        $breadcrumbs[] = '<span class="text-gray-600 dark:text-gray-400">Search Results for "' . get_search_query() . '"</span>';
        
    } elseif (is_404()) {
        // 404 page
        $breadcrumbs[] = '<span class="text-gray-600 dark:text-gray-400">Page Not Found</span>';
    }
    
    if (!empty($breadcrumbs)) {
        echo '<nav class="breadcrumbs mb-6" aria-label="Breadcrumb">';
        echo '<ol class="flex items-center text-sm">';
        
        foreach ($breadcrumbs as $index => $breadcrumb) {
            echo '<li class="flex items-center">';
            if ($index > 0) {
                echo $separator;
            }
            echo $breadcrumb;
            echo '</li>';
        }
        
        echo '</ol>';
        echo '</nav>';
    }
}

/**
 * Add breadcrumb schema markup
 */
function boldmcqspro_breadcrumb_schema() {
    if (is_front_page()) {
        return;
    }
    
    $breadcrumb_items = array();
    $position = 1;
    
    // Home
    $breadcrumb_items[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => 'Home',
        'item' => home_url()
    );
    
    if (is_singular('mcqs')) {
        global $post;
        
        // MCQs
        $breadcrumb_items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'MCQs',
            'item' => home_url()
        );
        
        // Category
        $categories = wp_get_post_terms($post->ID, 'mcq_category');
        if (!empty($categories) && !is_wp_error($categories)) {
            $category = $categories[0];
            $breadcrumb_items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $category->name,
                'item' => get_term_link($category)
            );
        }
        
        // Current page
        $breadcrumb_items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink()
        );
        
    } elseif (is_tax('mcq_category')) {
        $term = get_queried_object();
        
        $breadcrumb_items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'MCQs',
            'item' => home_url()
        );
        
        $breadcrumb_items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $term->name,
            'item' => get_term_link($term)
        );
    }
    
    if (count($breadcrumb_items) > 1) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumb_items
        );
        
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'boldmcqspro_breadcrumb_schema');
