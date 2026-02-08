    /**
 * BoldMCQs Pro Customizer Live Preview
 * Handles real-time updates for color changes in the WordPress Customizer
 */

(function($) {
    'use strict';

    // Helper function to convert hex to RGB
    function hexToRgb(hex) {
        hex = hex.replace('#', '');
        
        if (hex.length === 3) {
            const r = parseInt(hex.charAt(0) + hex.charAt(0), 16);
            const g = parseInt(hex.charAt(1) + hex.charAt(1), 16);
            const b = parseInt(hex.charAt(2) + hex.charAt(2), 16);
            return r + ', ' + g + ', ' + b;
        } else {
            const r = parseInt(hex.substring(0, 2), 16);
            const g = parseInt(hex.substring(2, 4), 16);
            const b = parseInt(hex.substring(4, 6), 16);
            return r + ', ' + g + ', ' + b;
        }
    }

    // Update CSS custom properties
    function updateCustomProperties(primary, secondary) {
        const root = document.documentElement;
        
        if (primary) {
            root.style.setProperty('--color-primary', hexToRgb(primary));
        }
        if (secondary) {
            root.style.setProperty('--color-secondary', hexToRgb(secondary));
        }
    }

    // Update Tailwind config colors
    function updateTailwindColors(primary, secondary) {
        if (window.tailwind && window.tailwind.config) {
            if (primary) {
                window.tailwind.config.theme.extend.colors.primary = primary;
            }
            if (secondary) {
                window.tailwind.config.theme.extend.colors.secondary = secondary;
            }
        }
    }

    // Primary Color Change
    wp.customize('boldmcqspro_primary_color', function(value) {
        value.bind(function(newColor) {
            updateCustomProperties(newColor, null);
            updateTailwindColors(newColor, null);
            
            // Force re-render of elements using primary color
            $('.bg-primary, .text-primary, .border-primary').each(function() {
                $(this).addClass('color-updated').removeClass('color-updated');
            });
        });
    });

    // Secondary Color Change
    wp.customize('boldmcqspro_secondary_color', function(value) {
        value.bind(function(newColor) {
            updateCustomProperties(null, newColor);
            updateTailwindColors(null, newColor);
            
            // Force re-render of elements using secondary color
            $('.bg-secondary, .text-secondary, .border-secondary').each(function() {
                $(this).addClass('color-updated').removeClass('color-updated');
            });
        });
    });

    // MCQ Option Text Color Change
    wp.customize('boldmcqspro_mcq_option_text_color', function(value) {
        value.bind(function(newColor) {
            if (newColor) {
                $('.mcq-option, .mcq-option *, .mcq-option .flex-1, .mcq-option span').css('color', newColor + ' !important');
            }
        });
    });

    // MCQ Option Letter Color Change
    wp.customize('boldmcqspro_mcq_option_letter_color', function(value) {
        value.bind(function(newColor) {
            if (newColor) {
                $('.practice-letter').css('color', newColor + ' !important');
            } else {
                // Reset to primary color
                const primaryColor = wp.customize('boldmcqspro_primary_color').get();
                if (primaryColor) {
                    $('.practice-letter').css('color', 'rgb(' + hexToRgb(primaryColor) + ') !important');
                }
            }
        });
    });

    // MCQ Correct Answer Color Change
    wp.customize('boldmcqspro_mcq_correct_color', function(value) {
        value.bind(function(newColor) {
            if (newColor) {
                $('.correct-indicator').css('color', newColor + ' !important');
            } else {
                // Reset to secondary color
                const secondaryColor = wp.customize('boldmcqspro_secondary_color').get();
                if (secondaryColor) {
                    $('.correct-indicator').css('color', 'rgb(' + hexToRgb(secondaryColor) + ') !important');
                }
            }
        });
    });

    // MCQ Background Color Change
    wp.customize('boldmcqspro_mcq_background_color', function(value) {
        value.bind(function(newColor) {
            if (newColor) {
                $('.mcq-card').css('background-color', newColor + ' !important');
            } else {
                $('.mcq-card').css('background-color', '');
            }
        });
    });

    // MCQ Border Color Change
    wp.customize('boldmcqspro_mcq_border_color', function(value) {
        value.bind(function(newColor) {
            if (newColor) {
                $('.mcq-card').css('border-color', newColor + ' !important');
            } else {
                $('.mcq-card').css('border-color', '');
            }
        });
    });

    // MCQ Hover Color Change
    wp.customize('boldmcqspro_mcq_hover_color', function(value) {
        value.bind(function(newColor) {
            if (newColor) {
                $('.mcq-option:hover').css('background-color', newColor + ' !important');
            } else {
                $('.mcq-option:hover').css('background-color', '');
            }
        });
    });

    // Explanation Button Color Change
    wp.customize('boldmcqspro_explanation_btn_color', function(value) {
        value.bind(function(newColor) {
            if (newColor) {
                $('.explanation-btn').css('background-color', newColor + ' !important');
            } else {
                $('.explanation-btn').css('background-color', '');
            }
        });
    });

    // Quiz Button Color Change
    wp.customize('boldmcqspro_quiz_btn_color', function(value) {
        value.bind(function(newColor) {
            if (newColor) {
                $('.quiz-mode-btn').css('background-color', newColor + ' !important');
            } else {
                $('.quiz-mode-btn').css('background-color', '');
            }
        });
    });

    // Initialize colors on load
    $(document).ready(function() {
        const primaryColor = wp.customize('boldmcqspro_primary_color').get();
        const secondaryColor = wp.customize('boldmcqspro_secondary_color').get();
        
        if (primaryColor || secondaryColor) {
            updateCustomProperties(primaryColor, secondaryColor);
            updateTailwindColors(primaryColor, secondaryColor);
        }
    });

})(jQuery);
