<form role="search" method="get" class="relative" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="search-field" class="sr-only"><?php echo _x('Search for:', 'label', 'boldmcqspro'); ?></label>
    <input 
        type="search" 
        id="search-field"
        class="w-full pl-10 pr-4 py-3 border dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-transparent transition-colors" 
        placeholder="<?php echo esc_attr_x('Search MCQs, posts...', 'placeholder', 'boldmcqspro'); ?>"
        value="<?php echo get_search_query(); ?>" 
        name="s" 
    />
    <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <span class="sr-only"><?php echo _x('Search', 'submit button', 'boldmcqspro'); ?></span>
    </button>
</form>
