<?php
/**
 * Dynamic Color System
 *
 * Reads all customizer color settings and outputs a single <style> block
 * that drives every color in the theme via CSS custom properties.
 *
 * HOW IT WORKS
 * ─────────────
 * 1. We define CSS custom properties on :root using the saved customizer values.
 * 2. Every Tailwind utility that uses a theme color (bg-primary, text-secondary,
 *    border-primary, hover variants, opacity variants, gradient variants) is
 *    re-declared here so it always reflects the current customizer value.
 * 3. The inline Tailwind CDN config is updated via the same PHP values so the
 *    initial page render also matches.
 *
 * ADDING A NEW COLOR
 * ───────────────────
 * 1. Add the setting + color control in inc/customizer.php
 * 2. Read it here with boldmcqspro_get_option()
 * 3. Add a --color-xxx CSS variable
 * 4. Add the utility classes that need it below
 */

function boldmcqspro_output_dynamic_colors() {
    // ── Read all color settings ────────────────────────────────────────────
    $primary   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_primary_color',   '#3B82F6' ) );
    $secondary = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_secondary_color', '#10B981' ) );
    $accent    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_accent_color',    '#F59E0B' ) );

    // MCQ-specific
    $opt_text_color  = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_option_text_color',   '#FFFFFF' ) );
    $letter_color    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_option_letter_color', '' ) );
    $correct_color   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_correct_color',       '' ) );
    $mcq_bg          = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_background_color',    '' ) );
    $mcq_border      = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_border_color',        '' ) );
    $mcq_hover       = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_hover_color',         '' ) );
    $explain_btn_clr = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_explanation_btn_color',   '' ) );
    $quiz_btn_clr    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_quiz_btn_color',          '' ) );

    // Derived values
    $primary_rgb   = boldmcqspro_hex_to_rgb( $primary );
    $secondary_rgb = boldmcqspro_hex_to_rgb( $secondary );
    $accent_rgb    = boldmcqspro_hex_to_rgb( $accent );

    $letter_css  = $letter_color  ? "color: {$letter_color} !important;"          : 'color: rgb(var(--cp)) !important;';
    $correct_css = $correct_color ? "color: {$correct_color} !important;"         : 'color: rgb(var(--cs)) !important;';

    ?>
    <!-- BoldMCQs Pro: Dynamic Color System -->
    <style id="boldmcqspro-colors">

        /* ─── 1. CSS Custom Properties ──────────────────────────────────── */
        :root {
            /* Primary colour as R,G,B triplet (used in rgb() and rgba()) */
            --cp: <?php echo esc_attr( $primary_rgb ); ?>;
            /* Secondary colour */
            --cs: <?php echo esc_attr( $secondary_rgb ); ?>;
            /* Accent colour */
            --ca: <?php echo esc_attr( $accent_rgb ); ?>;

            /* Full hex values for places that need them */
            --color-primary-hex:   <?php echo esc_attr( $primary ); ?>;
            --color-secondary-hex: <?php echo esc_attr( $secondary ); ?>;
            --color-accent-hex:    <?php echo esc_attr( $accent ); ?>;

            /* Legacy aliases kept for any JS / third-party code */
            --color-primary:   var(--cp);
            --color-secondary: var(--cs);
            --color-accent:    var(--ca);
        }

        /* ─── 2. Primary Colour Utilities ───────────────────────────────── */

        /* Solid */
        .bg-primary                { background-color: rgb(var(--cp)) !important; }
        .text-primary              { color:            rgb(var(--cp)) !important; }
        .border-primary            { border-color:     rgb(var(--cp)) !important; }
        .ring-primary              { --tw-ring-color:  rgb(var(--cp)); }
        .fill-primary              { fill:             rgb(var(--cp)) !important; }

        /* Hover */
        .hover\:bg-primary:hover      { background-color: rgb(var(--cp)) !important; }
        .hover\:text-primary:hover    { color:            rgb(var(--cp)) !important; }
        .hover\:border-primary:hover  { border-color:     rgb(var(--cp)) !important; }

        /* Opacity variants */
        .bg-primary\/5   { background-color: rgba(var(--cp), 0.05) !important; }
        .bg-primary\/10  { background-color: rgba(var(--cp), 0.10) !important; }
        .bg-primary\/20  { background-color: rgba(var(--cp), 0.20) !important; }
        .bg-primary\/30  { background-color: rgba(var(--cp), 0.30) !important; }
        .bg-primary\/50  { background-color: rgba(var(--cp), 0.50) !important; }
        .bg-primary\/80  { background-color: rgba(var(--cp), 0.80) !important; }
        .hover\:bg-primary\/80:hover { background-color: rgba(var(--cp), 0.80) !important; }
        .hover\:bg-primary\/10:hover { background-color: rgba(var(--cp), 0.10) !important; }
        .text-primary\/70  { color: rgba(var(--cp), 0.70) !important; }

        /* Gradient helpers */
        .from-primary   { --tw-gradient-from: rgb(var(--cp)); }
        .to-primary     { --tw-gradient-to:   rgb(var(--cp)); }
        .via-primary    { --tw-gradient-stops: var(--tw-gradient-from), rgb(var(--cp)), var(--tw-gradient-to); }

        /* Focus ring */
        .focus\:ring-primary:focus  { --tw-ring-color: rgb(var(--cp)); }
        .focus\:border-primary:focus { border-color:   rgb(var(--cp)) !important; }

        /* ─── 3. Secondary Colour Utilities ─────────────────────────────── */

        /* Solid */
        .bg-secondary              { background-color: rgb(var(--cs)) !important; }
        .text-secondary            { color:            rgb(var(--cs)) !important; }
        .border-secondary          { border-color:     rgb(var(--cs)) !important; }

        /* Hover */
        .hover\:bg-secondary:hover    { background-color: rgb(var(--cs)) !important; }
        .hover\:text-secondary:hover  { color:            rgb(var(--cs)) !important; }

        /* Opacity variants */
        .bg-secondary\/10  { background-color: rgba(var(--cs), 0.10) !important; }
        .bg-secondary\/20  { background-color: rgba(var(--cs), 0.20) !important; }
        .bg-secondary\/80  { background-color: rgba(var(--cs), 0.80) !important; }

        /* Gradient helpers */
        .from-secondary  { --tw-gradient-from: rgb(var(--cs)); }
        .to-secondary    { --tw-gradient-to:   rgb(var(--cs)); }
        .to-secondary\/20 { --tw-gradient-to:  rgba(var(--cs), 0.20); }

        /* ─── 4. Accent Colour Utilities ────────────────────────────────── */

        /* Solid */
        .bg-accent              { background-color: rgb(var(--ca)) !important; }
        .text-accent            { color:            rgb(var(--ca)) !important; }
        .border-accent          { border-color:     rgb(var(--ca)) !important; }

        /* Hover */
        .hover\:bg-accent:hover    { background-color: rgb(var(--ca)) !important; }
        .hover\:text-accent:hover  { color:            rgb(var(--ca)) !important; }

        /* Opacity variants */
        .bg-accent\/10  { background-color: rgba(var(--ca), 0.10) !important; }
        .bg-accent\/20  { background-color: rgba(var(--ca), 0.20) !important; }
        .bg-accent\/80  { background-color: rgba(var(--ca), 0.80) !important; }

        /* Gradient helpers (used by quiz banner & contributor avatars) */
        .from-accent     { --tw-gradient-from: rgb(var(--ca)); }
        .to-accent       { --tw-gradient-to:   rgb(var(--ca)); }
        .from-accent\/20 { --tw-gradient-from: rgba(var(--ca), 0.20); }

        /* ─── 5. Link Colours ───────────────────────────────────────────── */
        a:not([class]) {
            color: rgb(var(--cp));
        }
        a:not([class]):hover {
            color: rgba(var(--cp), 0.80);
        }

        /* ─── 5. Menu Hover (override hardcoded Tailwind blue/green) ─────── */
        /* Any nav link that uses an explicit colour class gets overridden */
        .main-navigation a:hover {
            color: rgb(var(--cp));
        }
        /* Auth buttons in header */
        .hover\:bg-blue-600:hover,
        .hover\:bg-green-600:hover {
            background-color: rgba(var(--cp), 0.80) !important;
        }

        /* ─── 6. MCQ-Specific Colours ───────────────────────────────────── */

        /* Option text */
        .mcq-option,
        .mcq-option *,
        .mcq-option .flex-1,
        .mcq-option span {
            color: <?php echo esc_attr( $opt_text_color ); ?> !important;
        }

        /* Option letter (A / B / C / D) */
        .practice-letter {
            <?php echo $letter_css; ?>
        }

        /* Correct-answer indicator */
        .correct-indicator {
            <?php echo $correct_css; ?>
        }

        <?php if ( $mcq_bg ) : ?>
        /* MCQ card background */
        .mcq-card {
            background-color: <?php echo esc_attr( $mcq_bg ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $mcq_border ) : ?>
        /* MCQ card border */
        .mcq-card {
            border-color: <?php echo esc_attr( $mcq_border ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $mcq_hover ) : ?>
        /* MCQ option hover background */
        .mcq-option:hover {
            background-color: <?php echo esc_attr( $mcq_hover ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $explain_btn_clr ) : ?>
        .explanation-btn {
            background-color: <?php echo esc_attr( $explain_btn_clr ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $quiz_btn_clr ) : ?>
        .quiz-mode-btn {
            background-color: <?php echo esc_attr( $quiz_btn_clr ); ?> !important;
        }
        <?php endif; ?>

        /* ─── 7. Search Bar (was hardcoded in style.css) ────────────────── */
        .searching,
        form[role="search"] input:focus {
            border-color: rgb(var(--cp)) !important;
            box-shadow: 0 0 0 3px rgba(var(--cp), 0.15) !important;
        }
        .searching::placeholder {
            color: rgb(var(--cp)) !important;
        }

        /* ─── 8. Tailwind CDN config synced via inline script ───────────── */
        /* (handled by boldmcqspro_output_tailwind_config() below) */

    </style>
    <?php
}
add_action( 'wp_head', 'boldmcqspro_output_dynamic_colors', 5 );

/**
 * Output the Tailwind CDN config so Tailwind generates utilities
 * using the customizer primary/secondary colours.
 *
 * This means newly generated classes (e.g. bg-primary-500) also
 * respect the stored colour. Runs before wp_head at priority 1
 * so it appears before the CDN script.
 */
function boldmcqspro_output_tailwind_config() {
    $primary   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_primary_color',   '#3B82F6' ) );
    $secondary = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_secondary_color', '#10B981' ) );
    $accent    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_accent_color',    '#F59E0B' ) );
    ?>
    <script id="boldmcqspro-tailwind-config">
        window._boldmcqsColors = {
            primary:   '<?php echo esc_js( $primary ); ?>',
            secondary: '<?php echo esc_js( $secondary ); ?>',
            accent:    '<?php echo esc_js( $accent ); ?>',
        };
        // Apply config immediately if Tailwind CDN is already loaded, or wait
        function _applyBoldMCQsTailwindConfig() {
            if (window.tailwind) {
                tailwind.config = {
                    theme: {
                        extend: {
                            colors: {
                                primary:   window._boldmcqsColors.primary,
                                secondary: window._boldmcqsColors.secondary,
                                accent:    window._boldmcqsColors.accent,
                            }
                        }
                    }
                };
            }
        }
        // Try immediately then again after DOM ready
        _applyBoldMCQsTailwindConfig();
        document.addEventListener('DOMContentLoaded', _applyBoldMCQsTailwindConfig);
    </script>
    <?php
}
add_action( 'wp_head', 'boldmcqspro_output_tailwind_config', 1 );

