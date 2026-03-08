<?php
/**
 * Sidebar – Categories Widget
 * Reused on index.php, archive.php, single.php, search.php
 *
 * @var int    $cat_limit  (optional) Number of categories to show. Default 8.
 * @var string $taxonomy   (optional) Taxonomy slug. Default 'mcq_category'.
 */

$cat_limit = isset( $cat_limit ) ? (int) $cat_limit : 8;
$taxonomy  = isset( $taxonomy )  ? $taxonomy         : 'mcq_category';

$cats = get_terms( array(
    'taxonomy'   => $taxonomy,
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => $cat_limit,
) );
?>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

    <!-- Header -->
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-primary/10">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </span>
            <h3 class="font-semibold text-gray-900 dark:text-white text-sm tracking-wide uppercase">Categories</h3>
        </div>
        <?php
        $archive_link = get_post_type_archive_link('mcqs');
        if ( $archive_link ) : ?>
            <a href="<?php echo esc_url( $archive_link ); ?>"
               class="text-xs text-primary hover:text-primary/70 font-medium transition-colors no-underline">
                View all →
            </a>
        <?php endif; ?>
    </div>

    <!-- List -->
    <?php if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) : ?>
    <ul class="divide-y divide-gray-50 dark:divide-gray-700/60">
        <?php foreach ( $cats as $cat ) :
            $link  = get_term_link( $cat );
            $name  = esc_html( $cat->name );
            $count = (int) $cat->count;
        ?>
        <li>
            <a href="<?php echo esc_url( $link ); ?>"
               class="group flex items-center justify-between px-5 py-3 hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors duration-150 no-underline">
                <div class="flex items-center gap-3 min-w-0">
                    <!-- Dot indicator -->
                    <span class="shrink-0 w-2 h-2 rounded-full bg-primary/40 group-hover:bg-primary transition-colors duration-150"></span>
                    <span class="text-sm text-gray-700 dark:text-gray-300 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-150 truncate font-medium">
                        <?php echo $name; ?>
                    </span>
                </div>
                <!-- Count pill -->
                <span class="shrink-0 ml-3 inline-flex items-center justify-center min-w-[1.5rem] px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 group-hover:bg-primary group-hover:text-white transition-all duration-150">
                    <?php echo $count; ?>
                </span>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>

    <?php else : ?>
    <!-- Empty state -->
    <div class="flex flex-col items-center justify-center py-10 px-5 text-center">
        <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">No categories yet</p>
        <?php if ( current_user_can('manage_categories') ) : ?>
            <a href="<?php echo esc_url( admin_url('edit-tags.php?taxonomy=mcq_category&post_type=mcqs') ); ?>"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-white text-xs font-medium rounded-lg hover:bg-primary/80 transition-colors no-underline">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Category
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</div>
