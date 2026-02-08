<?php 
/*
Template Name: MCQ Admin Dashboard
*/

// Ensure only administrators can access this page
if (!current_user_can('manage_options')) {
    wp_redirect(home_url());
    exit;
}

// Fetch dashboard stats for MCQs custom post type
$mcq_counts = wp_count_posts('mcqs');
$total_mcqs = isset($mcq_counts->publish) ? $mcq_counts->publish : 0;
$unpublished_mcqs = isset($mcq_counts->draft) ? $mcq_counts->draft : 0;
$pending_mcqs = isset($mcq_counts->pending) ? $mcq_counts->pending : 0;

// Calculate MCQs uploaded in the previous week and month
$date_query_week = array(
    'after'     => '1 week ago',
    'inclusive' => true,
);
$date_query_month = array(
    'after'     => '1 month ago',
    'inclusive' => true,
);
$args_week = array(
    'post_type'      => 'mcqs',
    'post_status'    => 'publish',
    'date_query'     => $date_query_week,
    'posts_per_page' => -1,
    'fields'         => 'ids'
);
$args_month = array(
    'post_type'      => 'mcqs',
    'post_status'    => 'publish',
    'date_query'     => $date_query_month,
    'posts_per_page' => -1,
    'fields'         => 'ids'
);
$query_week = new WP_Query($args_week);
$query_month = new WP_Query($args_month);
$mcqs_last_week = $query_week->found_posts;
$mcqs_last_month = $query_month->found_posts;

// Get user statistics
$user_count_data = count_users();
$total_users = isset($user_count_data['total_users']) ? $user_count_data['total_users'] : 0;
$total_admins = isset($user_count_data['avail_roles']['administrator']) ? $user_count_data['avail_roles']['administrator'] : 0;

// Fetch MCQ category information
$mcq_categories = get_terms(array(
    'taxonomy' => 'mcq_category',
    'hide_empty' => false
));
$total_categories = is_array($mcq_categories) ? count($mcq_categories) : 0;
$child_categories = is_array($mcq_categories) ? array_filter($mcq_categories, function($cat) {
    return isset($cat->parent) && $cat->parent != 0;
}) : array();
$total_child_categories = count($child_categories);

// Fetch recent MCQs
$recent_mcqs = get_posts(array(
    'numberposts' => 5,
    'post_type'   => 'mcqs',
    'post_status' => 'publish',
    'orderby'     => 'date',
    'order'       => 'DESC'
));

// Get pending MCQ submissions
$pending_posts = get_posts(array(
    'numberposts' => 3,
    'post_type'   => 'mcqs',
    'post_status' => 'pending',
    'orderby'     => 'date',
    'order'       => 'DESC'
));

// Get system information
$php_version = PHP_VERSION;
$wp_version = get_bloginfo('version');
$memory_limit = ini_get('memory_limit');
$upload_max_size = ini_get('upload_max_filesize');

// Calculate growth percentages
$growth_week = $mcqs_last_month > 0 ? round((($mcqs_last_week / $mcqs_last_month) * 100), 1) : 0;

// Get current user info
$current_user = wp_get_current_user();
$user_name = !empty($current_user->display_name) ? $current_user->display_name : 'Admin';
$user_avatar = get_avatar_url($current_user->ID, array('size' => 40));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BoldMCQs Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                    }
                }
            }
        }
    </script>
    <style>
        #wpcontent { padding: 0 !important; }
        #wpbody-content { padding-bottom: 0 !important; }
        #wpfooter { display: none !important; }
        
        /* Animations */
        .animate-fade-in { animation: fadeIn 0.5s ease-in-out; }
        .animate-slide-up { animation: slideUp 0.5s ease-in-out; }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #22c55e; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #15803d; }
        
        /* Import notification */
        #importNotification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        
        /* Loading spinner */
        .spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #22c55e;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Notification Container -->
    <div id="importNotification" class="hidden"></div>
    
    <div class="min-h-screen">
        <!-- Mobile header -->
        <div class="sticky top-0 z-10 bg-gray-800 p-4 flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">
                <i class="fas fa-bolt mr-2 text-primary-400"></i>BoldMCQs
            </h1>
                    <div class="flex items-center">
                <img class="h-8 w-8 rounded-full" src="<?php echo esc_url($user_avatar); ?>" alt="User Avatar">
                <div class="ml-3 hidden md:block">
                    <p class="text-sm font-medium text-white"><?php echo esc_html($user_name); ?></p>
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="text-xs font-medium text-gray-300 hover:text-gray-200">Logout</a>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1">
            <main class="flex-1 p-5">
                <!-- Welcome message -->
                <div class="mb-8 animate-fade-in">
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Welcome back, <?php echo esc_html($user_name); ?>!
                    </h1>
                    <p class="mt-2 text-lg text-gray-600">
                        Here's what's happening with your MCQs today.
                    </p>
                </div>
                
                <!-- Stats cards -->
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4 mb-8 animate-slide-up">
                    <!-- Total MCQs card -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-2xl border-l-4 border-primary-500 transition-all duration-300 hover:shadow-xl">
                        <div class="p-5 flex items-center">
                            <div class="flex-shrink-0 bg-primary-100 p-3 rounded-lg">
                                        <i class="fas fa-question-circle text-primary-600 text-2xl"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                <div class="text-sm font-medium text-gray-500 truncate">Total MCQs</div>
                                <div class="mt-1 flex items-baseline">
                                    <div class="text-3xl font-semibold text-gray-900"><?php echo number_format($total_mcqs); ?></div>
                                    <div class="ml-2 text-sm text-gray-500">
                                        (+<?php echo $mcqs_last_week; ?> this week)
                                    </div>
                                </div>
                            </div>
                        </div>
                                </div>
                    
                    <!-- Users card -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-2xl border-l-4 border-blue-500 transition-all duration-300 hover:shadow-xl">
                        <div class="p-5 flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                                <i class="fas fa-users text-blue-600 text-2xl"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                <div class="text-sm font-medium text-gray-500 truncate">Total Users</div>
                                <div class="mt-1 flex items-baseline">
                                    <div class="text-3xl font-semibold text-gray-900"><?php echo number_format($total_users); ?></div>
                                    <div class="ml-2 text-sm text-gray-500">
                                        (<?php echo $total_admins; ?> admins)
                                    </div>
                                </div>
                            </div>
                        </div>
                                </div>
                    
                    <!-- Categories card -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-2xl border-l-4 border-purple-500 transition-all duration-300 hover:shadow-xl">
                        <div class="p-5 flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 p-3 rounded-lg">
                                <i class="fas fa-folder text-purple-600 text-2xl"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                <div class="text-sm font-medium text-gray-500 truncate">Categories</div>
                                <div class="mt-1 flex items-baseline">
                                    <div class="text-3xl font-semibold text-gray-900"><?php echo $total_categories; ?></div>
                                    <div class="ml-2 text-sm text-gray-500">
                                        (<?php echo $total_child_categories; ?> subcategories)
                                    </div>
                                </div>
                            </div>
                        </div>
                                </div>
                    
                    <!-- Pending card -->
                    <div class="bg-white overflow-hidden shadow-lg rounded-2xl border-l-4 border-yellow-500 transition-all duration-300 hover:shadow-xl">
                        <div class="p-5 flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-lg">
                                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                <div class="text-sm font-medium text-gray-500 truncate">Pending Review</div>
                                <div class="mt-1 flex items-baseline">
                                    <div class="text-3xl font-semibold text-gray-900"><?php echo count($pending_posts); ?></div>
                                    <div class="ml-2 text-sm text-gray-500">
                                        (<?php echo $unpublished_mcqs; ?> drafts)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Two-column layout for smaller screens, three-column for larger -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent MCQs Table -->
                    <div class="bg-white shadow-lg rounded-2xl overflow-hidden lg:col-span-2 animate-slide-up">
                        <div class="px-6 py-5 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <i class="fas fa-list-ul mr-2 text-primary-500"></i>Recent MCQs
                            </h3>
                            <a href="<?php echo admin_url('edit.php?post_type=mcqs'); ?>" class="bg-primary-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-600 transition-colors duration-200 flex items-center">
                                <i class="fas fa-eye mr-1"></i> View All
                    </a>
                </div>
                <div class="overflow-x-auto">
                            <?php if (empty($recent_mcqs)): ?>
                                <div class="p-6 text-center text-gray-500">
                                    <i class="fas fa-info-circle text-3xl mb-3 text-gray-400"></i>
                                    <p>No MCQs have been published yet.</p>
                                    <a href="<?php echo admin_url('post-new.php?post_type=mcqs'); ?>" class="mt-3 inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors">
                                        <i class="fas fa-plus mr-2"></i> Create Your First MCQ
                                    </a>
                                </div>
                            <?php else: ?>
                    <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($recent_mcqs as $mcq): ?>
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 truncate max-w-xs">
                                                <?php echo esc_html($mcq->post_title); ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php
                                                    $mcq_categories = get_the_terms($mcq->ID, 'mcq_category');
                                                    if (!empty($mcq_categories) && !is_wp_error($mcq_categories)) {
                                    $category_names = array_map(function($cat) {
                                                        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-100 text-primary-800">' . esc_html($cat->name) . '</span>';
                                                        }, $mcq_categories);
                                    echo implode(' ', $category_names);
                                                } else {
                                                    echo '<span class="text-gray-400">Uncategorized</span>';
                                                }
                                    ?>
                                </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                <?php echo get_the_date('M d, Y', $mcq); ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                                <div class="flex space-x-3">
                                                    <a href="<?php echo get_permalink($mcq->ID); ?>" class="text-blue-600 hover:text-blue-900" title="View" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                                    <a href="<?php echo get_edit_post_link($mcq->ID); ?>" class="text-green-600 hover:text-green-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                                </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Quick Actions & Info -->
                    <div class="space-y-6 animate-slide-up">
                        <!-- Quick Actions -->
                        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-bolt mr-2 text-yellow-500"></i>Quick Actions
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <a href="<?php echo admin_url('post-new.php?post_type=mcqs'); ?>" class="w-full flex items-center justify-between px-4 py-3 bg-primary-50 text-primary-700 rounded-lg hover:bg-primary-100 transition-colors duration-150">
                                    <span class="flex items-center">
                                        <i class="fas fa-plus-circle mr-2"></i>
                                        Add New MCQ
                                    </span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                                <a href="<?php echo admin_url('admin.php?page=boldmcqs-bulk-upload'); ?>" class="w-full flex items-center justify-between px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-150">
                                    <span class="flex items-center">
                                        <i class="fas fa-upload mr-2"></i>
                                        Bulk Upload
                                    </span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                                <a href="<?php echo admin_url('edit-tags.php?taxonomy=mcq_category&post_type=mcqs'); ?>" class="w-full flex items-center justify-between px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-colors duration-150">
                                    <span class="flex items-center">
                                        <i class="fas fa-folder-plus mr-2"></i>
                                        Manage Categories
                                    </span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                                
                                <?php 
                                $demo_imported = get_option('boldmcqs_demo_imported', false);
                                $demo_date = get_option('boldmcqs_demo_import_date', '');
                                ?>
                                
                                <!-- Demo Import Button -->
                                <button 
                                    id="importDemoBtn" 
                                    class="w-full flex items-center justify-between px-4 py-3 <?php echo $demo_imported ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gradient-to-r from-orange-50 to-red-50 text-orange-700 hover:from-orange-100 hover:to-red-100'; ?> rounded-lg transition-all duration-150"
                                    <?php echo $demo_imported ? 'disabled' : ''; ?>
                                >
                                    <span class="flex items-center">
                                        <i class="fas fa-download mr-2"></i>
                                        <span>
                                            <?php echo $demo_imported ? 'Demo Imported' : 'Import Demo Content'; ?>
                                        </span>
                                    </span>
                                    <?php if ($demo_imported): ?>
                                        <i class="fas fa-check-circle"></i>
                                    <?php else: ?>
                                        <i class="fas fa-chevron-right"></i>
                                    <?php endif; ?>
                                </button>
                                
                                <?php if ($demo_imported && $demo_date): ?>
                                    <div class="text-xs text-gray-500 px-4 -mt-2">
                                        Imported on <?php echo date('M d, Y', strtotime($demo_date)); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- System Health -->
                        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-heartbeat mr-2 text-green-500"></i>System Health
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">PHP Version</span>
                                    <span class="text-sm font-medium text-gray-900"><?php echo esc_html($php_version); ?></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">WordPress</span>
                                    <span class="text-sm font-medium text-gray-900"><?php echo esc_html($wp_version); ?></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Memory Limit</span>
                                    <span class="text-sm font-medium text-gray-900"><?php echo esc_html($memory_limit); ?></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Upload Max</span>
                                    <span class="text-sm font-medium text-gray-900"><?php echo esc_html($upload_max_size); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Theme Features -->
                        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>Theme Features
                                </h3>
                            </div>
                            <div class="p-6">
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 h-5 w-5 text-primary-500">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">MCQs Quiz Mode with interactive questions</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 h-5 w-5 text-primary-500">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">Bulk upload functionality</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 h-5 w-5 text-primary-500">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">Custom MCQ post type & taxonomies</p>
                                    </li>
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 h-5 w-5 text-primary-500">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">Responsive design for all devices</p>
                                    </li>
                                </ul>
                                <div class="mt-6">
                                    <a href="<?php echo admin_url('customize.php'); ?>" class="text-primary-600 hover:text-primary-800 font-medium">
                                        Customize Theme <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="bg-white shadow-lg mt-6">
                <div class="max-w-7xl mx-auto py-6 px-4 overflow-hidden sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-gray-500">
                        &copy; <?php echo date('Y'); ?> BoldMCQs Theme v2.0.0 by <a href="https://nexich.com" target="_blank" class="text-primary-600 hover:text-primary-800">Nexich.com</a>
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <script>
    // Add some interactive enhancements
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to stat cards
        const statCards = document.querySelectorAll('.bg-white.overflow-hidden.shadow-lg');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add loading states to action buttons
        const actionButtons = document.querySelectorAll('a[href*="admin"]');
        actionButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.style.opacity = '0.7';
                this.style.pointerEvents = 'none';
            });
        });
    });
    </script>
</body>
</html>

