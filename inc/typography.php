<?php
/**
 * Typography Functions
 * Handle Google Fonts loading and custom typography CSS
 */

// Get the selected font
function boldmcqspro_get_selected_font($setting, $fallback_font = 'Inter') {
    $font = boldmcqspro_get_option($setting, $fallback_font);
    
    // Handle special cases
    if ($font === 'same_as_primary') {
        return boldmcqspro_get_option('boldmcqspro_primary_font', 'Inter');
    }
    if ($font === 'same_as_secondary') {
        return boldmcqspro_get_option('boldmcqspro_secondary_font', 'Inter');
    }
    
    return $font;
}

// Build CSS font-family property
function boldmcqspro_build_font_family($font_name) {
    $font_stacks = array(
        // Google Fonts
        'Inter' => '"Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Poppins' => '"Poppins", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Roboto' => '"Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
        'Open Sans' => '"Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Lato' => '"Lato", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Montserrat' => '"Montserrat", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Nunito' => '"Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Source Sans Pro' => '"Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Raleway' => '"Raleway", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Ubuntu' => '"Ubuntu", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        
        // Google Serif Fonts
        'Playfair Display' => '"Playfair Display", Georgia, Times, serif',
        'Merriweather' => '"Merriweather", Georgia, Times, serif',
        'Crimson Text' => '"Crimson Text", Georgia, Times, serif',
        'Lora' => '"Lora", Georgia, Times, serif',
        'PT Serif' => '"PT Serif", Georgia, Times, serif',
        
        // Google Monospace Fonts
        'JetBrains Mono' => '"JetBrains Mono", Monaco, "Cascadia Code", "Roboto Mono", Consolas, "Courier New", monospace',
        'Fira Code' => '"Fira Code", Monaco, "Cascadia Code", "Roboto Mono", Consolas, "Courier New", monospace',
        'Source Code Pro' => '"Source Code Pro", Monaco, "Cascadia Code", "Roboto Mono", Consolas, "Courier New", monospace',
        
        // System Fonts
        'system-ui' => 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Arial' => 'Arial, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
        'Georgia' => 'Georgia, Times, "Times New Roman", serif',
        'Times New Roman' => '"Times New Roman", Times, Georgia, serif',
    );
    
    return isset($font_stacks[$font_name]) ? $font_stacks[$font_name] : $font_stacks['Inter'];
}

// Get fonts that need to be loaded from Google Fonts
function boldmcqspro_get_google_fonts_to_load() {
    if (!boldmcqspro_get_option('boldmcqspro_enable_google_fonts', true)) {
        return array();
    }
    
    $google_fonts = array(
        'Inter', 'Poppins', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 
        'Nunito', 'Source Sans Pro', 'Raleway', 'Ubuntu',
        'Playfair Display', 'Merriweather', 'Crimson Text', 'Lora', 'PT Serif',
        'JetBrains Mono', 'Fira Code', 'Source Code Pro'
    );
    
    $fonts_to_load = array();
    
    // Get all selected fonts
    $primary_font = boldmcqspro_get_selected_font('boldmcqspro_primary_font', 'Inter');
    $secondary_font = boldmcqspro_get_selected_font('boldmcqspro_secondary_font', 'Inter');
    $mcq_question_font = boldmcqspro_get_selected_font('boldmcqspro_mcq_question_font', 'same_as_primary');
    $mcq_options_font = boldmcqspro_get_selected_font('boldmcqspro_mcq_options_font', 'same_as_secondary');
    
    $selected_fonts = array($primary_font, $secondary_font, $mcq_question_font, $mcq_options_font);
    
    foreach ($selected_fonts as $font) {
        if (in_array($font, $google_fonts) && !in_array($font, $fonts_to_load)) {
            $fonts_to_load[] = $font;
        }
    }
    
    return $fonts_to_load;
}

// Load Google Fonts
function boldmcqspro_load_google_fonts() {
    $fonts_to_load = boldmcqspro_get_google_fonts_to_load();
    
    if (empty($fonts_to_load)) {
        return;
    }
    
    // Build Google Fonts URL
    $font_families = array();
    $font_weights = array('300', '400', '500', '600', '700');
    
    foreach ($fonts_to_load as $font) {
        $font_name = str_replace(' ', '+', $font);
        $font_families[] = $font_name . ':' . implode(',', $font_weights);
    }
    
    $google_fonts_url = 'https://fonts.googleapis.com/css2?' . 
                       'family=' . implode('&family=', $font_families) .
                       '&display=swap';
    
    wp_enqueue_style('boldmcqspro-google-fonts', $google_fonts_url, array(), null);
}
add_action('wp_enqueue_scripts', 'boldmcqspro_load_google_fonts');

// Convert letter spacing values
function boldmcqspro_get_letter_spacing_value($spacing) {
    $spacing_values = array(
        'tighter' => '-0.05em',
        'tight'   => '-0.025em',
        'normal'  => '0',
        'wide'    => '0.025em',
        'wider'   => '0.05em',
        'widest'  => '0.1em',
    );
    
    return isset($spacing_values[$spacing]) ? $spacing_values[$spacing] : '0';
}

// Generate custom typography CSS
function boldmcqspro_generate_typography_css() {
    // Get all typography settings
    $primary_font = boldmcqspro_get_selected_font('boldmcqspro_primary_font', 'Inter');
    $primary_font_weight = boldmcqspro_get_option('boldmcqspro_primary_font_weight', '600');
    $secondary_font = boldmcqspro_get_selected_font('boldmcqspro_secondary_font', 'Inter');
    $secondary_font_weight = boldmcqspro_get_option('boldmcqspro_secondary_font_weight', '400');
    $mcq_question_font = boldmcqspro_get_selected_font('boldmcqspro_mcq_question_font', 'same_as_primary');
    $mcq_options_font = boldmcqspro_get_selected_font('boldmcqspro_mcq_options_font', 'same_as_secondary');
    
    // Font sizes
    $base_font_size = boldmcqspro_get_option('boldmcqspro_base_font_size', 16);
    $mcq_question_size = boldmcqspro_get_option('boldmcqspro_mcq_question_size', 18);
    $mcq_options_size = boldmcqspro_get_option('boldmcqspro_mcq_options_size', 16);
    
    // Advanced settings
    $line_height = boldmcqspro_get_option('boldmcqspro_line_height', '1.6');
    $letter_spacing = boldmcqspro_get_letter_spacing_value(boldmcqspro_get_option('boldmcqspro_letter_spacing', 'normal'));
    
    // Build font families
    $primary_font_family = boldmcqspro_build_font_family($primary_font);
    $secondary_font_family = boldmcqspro_build_font_family($secondary_font);
    $mcq_question_font_family = boldmcqspro_build_font_family($mcq_question_font);
    $mcq_options_font_family = boldmcqspro_build_font_family($mcq_options_font);
    
    // Generate CSS
    $css = "
        /* Base Typography */
        body {
            font-family: {$secondary_font_family};
            font-weight: {$secondary_font_weight};
            font-size: {$base_font_size}px;
            line-height: {$line_height};
            letter-spacing: {$letter_spacing};
        }
        
        /* Headings */
        h1, h2, h3, h4, h5, h6,
        .site-title,
        .entry-title,
        .page-title {
            font-family: {$primary_font_family};
            font-weight: {$primary_font_weight};
            line-height: 1.2;
        }
        
        /* MCQ Question Styling */
        .mcq-question,
        .mcq-question-text,
        .boldmcqs-question {
            font-family: {$mcq_question_font_family};
            font-size: {$mcq_question_size}px;
            font-weight: 500;
            line-height: 1.4;
        }
        
        /* MCQ Options Styling */
        .mcq-options,
        .mcq-option,
        .mcq-answer,
        .boldmcqs-option {
            font-family: {$mcq_options_font_family};
            font-size: {$mcq_options_size}px;
            line-height: 1.3;
        }
        
        /* MCQ Option Letters (A, B, C, D) */
        .mcq-option-letter,
        .boldmcqs-option-letter {
            font-family: {$primary_font_family};
            font-weight: {$primary_font_weight};
        }
        
        /* Navigation and Menus */
        .main-navigation,
        .site-navigation,
        nav {
            font-family: {$primary_font_family};
            font-weight: 500;
        }
        
        /* Buttons */
        .btn,
        button,
        input[type='submit'],
        input[type='button'],
        .wp-block-button__link {
            font-family: {$primary_font_family};
            font-weight: 600;
        }
        
        /* Form Elements */
        input,
        textarea,
        select {
            font-family: {$secondary_font_family};
            font-size: {$base_font_size}px;
        }
        
        /* Meta Information */
        .entry-meta,
        .post-meta,
        .mcq-meta {
            font-family: {$secondary_font_family};
            font-size: " . ($base_font_size - 2) . "px;
        }
        
        /* Breadcrumbs */
        .breadcrumb,
        .breadcrumbs {
            font-family: {$secondary_font_family};
            font-size: " . ($base_font_size - 1) . "px;
        }
        
        /* Responsive Font Sizes */
        @media (max-width: 768px) {
            body {
                font-size: " . ($base_font_size - 1) . "px;
            }
            
            .mcq-question,
            .mcq-question-text,
            .boldmcqs-question {
                font-size: " . ($mcq_question_size - 2) . "px;
            }
            
            .mcq-options,
            .mcq-option,
            .mcq-answer,
            .boldmcqs-option {
                font-size: " . ($mcq_options_size - 1) . "px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                font-size: " . ($base_font_size - 2) . "px;
            }
        }
    ";
    
    return $css;
}

// Output custom typography CSS
function boldmcqspro_output_typography_css() {
    $css = boldmcqspro_generate_typography_css();
    
    if (!empty($css)) {
        echo '<style id="boldmcqspro-typography-css" type="text/css">' . $css . '</style>';
    }
}
add_action('wp_head', 'boldmcqspro_output_typography_css', 100);

// Clean and compress CSS
function boldmcqspro_minify_css($css) {
    // Remove comments
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    // Remove whitespace
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
    return $css;
}
