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
    $primary   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_primary_color',   '#02411c' ) );
    $secondary = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_secondary_color', '#10B981' ) );
    $accent    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_accent_color',    '#F59E0B' ) );

    // Semantic colors
    $success   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_success_color',   '#10B981' ) );
    $error     = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_error_color',     '#EF4444' ) );
    $warning   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_warning_color',   '#F59E0B' ) );
    $info      = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_info_color',      '#3B82F6' ) );

    // UI state colors
    $icon_color       = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_icon_color',        '' ) );
    $icon_muted_color = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_icon_muted_color', '' ) );
    $link_hover_color = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_link_hover_color', '' ) );

    // Background & surface colours (empty = use default theme styles)
    $body_bg      = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_body_bg_color',    '' ) );
    $card_bg      = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_card_bg_color',    '' ) );
    $header_bg    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_header_bg_color',  '' ) );
    $footer_bg    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_footer_bg_color',  '' ) );
    $text_color   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_text_color',       '' ) );
    $heading_color = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_heading_color',   '' ) );
    $muted_bg     = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_muted_bg_color',    '' ) );
    $border_color = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_border_color',      '' ) );

    // MCQ-specific
    $opt_text_color  = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_option_text_color',   '#FFFFFF' ) );
    $letter_color    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_option_letter_color', '' ) );
    $correct_color   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_correct_color',       '' ) );
    $mcq_bg          = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_background_color',    '' ) );
    $mcq_border      = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_border_color',        '' ) );
    $mcq_hover       = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_mcq_hover_color',         '' ) );
    $explain_btn_clr = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_explanation_btn_color',   '' ) );
    $quiz_btn_clr    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_quiz_btn_color',          '' ) );
    $btn_rounding    = boldmcqspro_get_option( 'boldmcqspro_btn_rounding', '12' );
    $btn_primary_bg  = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_btn_primary_color', '' ) );

    // Derived values (RGB conversions for use with rgba())
    $primary_rgb   = boldmcqspro_hex_to_rgb( $primary );
    $secondary_rgb = boldmcqspro_hex_to_rgb( $secondary );
    $accent_rgb    = boldmcqspro_hex_to_rgb( $accent );
    $success_rgb   = boldmcqspro_hex_to_rgb( $success );
    $error_rgb     = boldmcqspro_hex_to_rgb( $error );
    $warning_rgb   = boldmcqspro_hex_to_rgb( $warning );
    $info_rgb      = boldmcqspro_hex_to_rgb( $info );

    // Conditional CSS for MCQ-specific elements
    $letter_css  = $letter_color  ? "color: {$letter_color} !important;"  : 'color: rgb(var(--cp)) !important;';
    $correct_css = $correct_color ? "color: {$correct_color} !important;" : 'color: rgb(var(--color-success)) !important;';

    // Icon color CSS
    $icon_css       = $icon_color       ? "color: {$icon_color} !important;"       : 'color: rgb(var(--cp)) !important;';
    $icon_muted_css = $icon_muted_color ? "color: {$icon_muted_color} !important;" : 'color: #6B7280 !important;'; // gray-500
    $link_hover_css = $link_hover_color ? "color: {$link_hover_color} !important;" : 'color: rgba(var(--cp), 0.80) !important;';

    ?>
    <!-- BoldMCQs Pro: Dynamic Color System -->
    <style id="boldmcqspro-colors">

        /* ─── 1. CSS Custom Properties ──────────────────────────────────── */
        :root {
            /* ═══ Main Brand Colors (RGB format) ═══ */
            --cp: <?php echo esc_attr( $primary_rgb ); ?>;   /* Primary */
            --cs: <?php echo esc_attr( $secondary_rgb ); ?>; /* Secondary */
            --ca: <?php echo esc_attr( $accent_rgb ); ?>;    /* Accent */

            /* ═══ Semantic Colors (RGB format) ═══ */
            --color-success: <?php echo esc_attr( $success_rgb ); ?>;  /* Success/Correct */
            --color-error:   <?php echo esc_attr( $error_rgb ); ?>;    /* Error/Wrong */
            --color-warning: <?php echo esc_attr( $warning_rgb ); ?>;  /* Warning/Alert */
            --color-info:    <?php echo esc_attr( $info_rgb ); ?>;     /* Info/Help */

            /* ═══ Full hex values for places that need them ═══ */
            --color-primary-hex:   <?php echo esc_attr( $primary ); ?>;
            --color-secondary-hex: <?php echo esc_attr( $secondary ); ?>;
            --color-accent-hex:    <?php echo esc_attr( $accent ); ?>;
            --color-success-hex:   <?php echo esc_attr( $success ); ?>;
            --color-error-hex:     <?php echo esc_attr( $error ); ?>;
            --color-warning-hex:   <?php echo esc_attr( $warning ); ?>;
            --color-info-hex:      <?php echo esc_attr( $info ); ?>;

            /* ═══ Legacy aliases (backward compatibility) ═══ */
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

        /* ─── 4a. Semantic Color Utilities (Success, Error, Warning, Info) ── */

        /* Success (Correct answers, confirmations) */
        .bg-success              { background-color: rgb(var(--color-success)) !important; }
        .text-success            { color:            rgb(var(--color-success)) !important; }
        .border-success          { border-color:     rgb(var(--color-success)) !important; }
        .hover\:bg-success:hover    { background-color: rgb(var(--color-success)) !important; }
        .hover\:text-success:hover  { color:            rgb(var(--color-success)) !important; }
        .bg-success\/10  { background-color: rgba(var(--color-success), 0.10) !important; }
        .bg-success\/20  { background-color: rgba(var(--color-success), 0.20) !important; }
        .bg-success\/80  { background-color: rgba(var(--color-success), 0.80) !important; }

        /* Error / Danger (Wrong answers, errors, destructive) */
        .bg-error              { background-color: rgb(var(--color-error)) !important; }
        .text-error            { color:            rgb(var(--color-error)) !important; }
        .border-error          { border-color:     rgb(var(--color-error)) !important; }
        .hover\:bg-error:hover    { background-color: rgb(var(--color-error)) !important; }
        .hover\:text-error:hover  { color:            rgb(var(--color-error)) !important; }
        .bg-error\/10  { background-color: rgba(var(--color-error), 0.10) !important; }
        .bg-error\/20  { background-color: rgba(var(--color-error), 0.20) !important; }
        .bg-error\/80  { background-color: rgba(var(--color-error), 0.80) !important; }

        /* Warning (Alerts, cautions) */
        .bg-warning              { background-color: rgb(var(--color-warning)) !important; }
        .text-warning            { color:            rgb(var(--color-warning)) !important; }
        .border-warning          { border-color:     rgb(var(--color-warning)) !important; }
        .hover\:bg-warning:hover    { background-color: rgb(var(--color-warning)) !important; }
        .hover\:text-warning:hover  { color:            rgb(var(--color-warning)) !important; }
        .bg-warning\/10  { background-color: rgba(var(--color-warning), 0.10) !important; }
        .bg-warning\/20  { background-color: rgba(var(--color-warning), 0.20) !important; }
        .bg-warning\/80  { background-color: rgba(var(--color-warning), 0.80) !important; }

        /* Info (Informational messages, tips, help) */
        .bg-info              { background-color: rgb(var(--color-info)) !important; }
        .text-info            { color:            rgb(var(--color-info)) !important; }
        .border-info          { border-color:     rgb(var(--color-info)) !important; }
        .hover\:bg-info:hover    { background-color: rgb(var(--color-info)) !important; }
        .hover\:text-info:hover  { color:            rgb(var(--color-info)) !important; }
        .bg-info\/10  { background-color: rgba(var(--color-info), 0.10) !important; }
        .bg-info\/20  { background-color: rgba(var(--color-info), 0.20) !important; }
        .bg-info\/80  { background-color: rgba(var(--color-info), 0.80) !important; }

        /* ─── 5. Link Colours ───────────────────────────────────────────── */
        a:not([class]) {
            color: rgb(var(--cp));
        }
        a:not([class]):hover {
            color: rgba(var(--cp), 0.80);
        }

        /* ─── Additional Information / post content area ────────────────── */
        /* Ensures links inside the_content() always use primary colour */
        .additional-info-content a,
        .additional-info-content a:link,
        .additional-info-content a:visited {
            color: rgb(var(--cp)) !important;
            text-decoration: underline;
        }
        .additional-info-content a:hover {
            color: rgba(var(--cp), 0.75) !important;
        }
        .additional-info-content h2,
        .additional-info-content h3,
        .additional-info-content h4,
        .additional-info-content strong {
            color: #111827;
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

        /* ─── 7. Global Button Styles ─────────────────────────────────── */
        
        /* Global Rounding */
        .btn-base,
        .mcq-option,
        .rounded-xl {
            border-radius: <?php echo intval( $btn_rounding ); ?>px !important;
        }

        /* Primary Button Color Override */
        <?php if ( $btn_primary_bg ) : ?>
        .btn-primary {
            background-color: <?php echo esc_attr( $btn_primary_bg ); ?> !important;
        }
        .btn-primary:hover {
            background-color: <?php echo esc_attr( $btn_primary_bg ); ?> !important;
            opacity: 0.9;
        }
        <?php endif; ?>

        /* ─── 8. Background & Surface Colours (Customizer-controlled) ──── */

        <?php if ( $body_bg ) : ?>
        body,
        .site,
        #page {
            background-color: <?php echo esc_attr( $body_bg ); ?> !important;
        }
        /* Tailwind max-w container inherits body bg */
        .max-w-7xl,
        .max-w-3xl,
        .max-w-5xl {
            background-color: transparent !important;
        }
        <?php endif; ?>

        <?php if ( $card_bg ) : ?>
        /* MCQ cards, sidebar widgets, panels */
        .mcq-card,
        .bg-white,
        div[class*="bg-white"],
        aside .bg-white,
        .rounded-xl.shadow-md,
        .boldmcqs-stat-card {
            background-color: <?php echo esc_attr( $card_bg ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $header_bg ) : ?>
        /* Site header */
        header,
        header.sticky,
        nav.header-nav,
        #site-header,
        .site-header {
            background-color: <?php echo esc_attr( $header_bg ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $footer_bg ) : ?>
        /* Site footer */
        footer,
        #colophon,
        .site-footer {
            background-color: <?php echo esc_attr( $footer_bg ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $text_color ) : ?>
        /* Body / paragraph text */
        body,
        p,
        .text-gray-600,
        .text-gray-700,
        .text-slate-600,
        .text-slate-700 {
            color: <?php echo esc_attr( $text_color ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $heading_color ) : ?>
        /* Headings */
        h1, h2, h3, h4, h5, h6,
        .text-gray-900,
        .text-slate-900 {
            color: <?php echo esc_attr( $heading_color ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $muted_bg ) : ?>
        /* Muted / Soft backgrounds (gray-50, gray-100, gray-200) */
        .bg-gray-50,
        .bg-gray-100,
        .bg-gray-200,
        .hover\:bg-gray-50:hover,
        .hover\:bg-gray-100:hover,
        .dark .dark\:bg-gray-700,
        .dark .dark\:bg-gray-700\/50,
        .category-badge,
        .pagination a:hover,
        .jump-to-page-btn {
            background-color: <?php echo esc_attr( $muted_bg ); ?> !important;
        }
        <?php endif; ?>

        <?php if ( $border_color ) : ?>
        /* Borders and dividers */
        border,
        .border,
        [class*="border-gray-"],
        .dark [class*="dark\:border-gray-"],
        hr,
        .mcq-option,
        .search-input {
            border-color: <?php echo esc_attr( $border_color ); ?> !important;
        }
        <?php endif; ?>

        /* ─── 9. Search Bar (was hardcoded in style.css) ────────────────── */

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
    $primary   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_primary_color',   '#02411c' ) );
    $secondary = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_secondary_color', '#10B981' ) );
    $accent    = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_accent_color',    '#F59E0B' ) );
    $success   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_success_color',   '#10B981' ) );
    $error     = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_error_color',     '#EF4444' ) );
    $warning   = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_warning_color',   '#F59E0B' ) );
    $info      = sanitize_hex_color( boldmcqspro_get_option( 'boldmcqspro_info_color',      '#3B82F6' ) );
    ?>
    <script id="boldmcqspro-tailwind-config">
        window._boldmcqsColors = {
            primary:   '<?php echo esc_js( $primary ); ?>',
            secondary: '<?php echo esc_js( $secondary ); ?>',
            accent:    '<?php echo esc_js( $accent ); ?>',
            success:   '<?php echo esc_js( $success ); ?>',
            error:     '<?php echo esc_js( $error ); ?>',
            warning:   '<?php echo esc_js( $warning ); ?>',
            info:      '<?php echo esc_js( $info ); ?>',
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
                                success:   window._boldmcqsColors.success,
                                error:     window._boldmcqsColors.error,
                                warning:   window._boldmcqsColors.warning,
                                info:      window._boldmcqsColors.info,
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

