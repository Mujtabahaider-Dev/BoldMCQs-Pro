/**
 * BoldMCQs Admin JavaScript
 */

(function($) {
    'use strict';
    
    // Global BoldMCQs Admin object
    window.BoldMCQsAdmin = {
        
        init: function() {
            this.bindEvents();
            this.initTooltips();
            this.initConfirmations();
        },
        
        bindEvents: function() {
            // Dashboard refresh button
            $(document).on('click', '.refresh-stats', this.refreshStats);
            
            // Quick action buttons
            $(document).on('click', '.quick-action', this.handleQuickAction);
            
            // Bulk operations
            $(document).on('click', '.bulk-action', this.handleBulkAction);
            

            
            // Search functionality
            $(document).on('input', '.admin-search', this.handleSearch);
            
            // Modal handling
            $(document).on('click', '.open-modal', this.openModal);
            $(document).on('click', '.close-modal', this.closeModal);
            $(document).on('click', '.modal-overlay', this.closeModal);
            

            
            // Form validation
            $(document).on('submit', '.validate-form', this.validateForm);
            
            // Copy to clipboard
            $(document).on('click', '.copy-to-clipboard', this.copyToClipboard);
        },
        
        initTooltips: function() {
            // Initialize tooltips for help icons
            $('.tooltip').hover(
                function() {
                    var tooltipText = $(this).attr('data-tooltip');
                    $(this).append('<div class="tooltip-content">' + tooltipText + '</div>');
                },
                function() {
                    $(this).find('.tooltip-content').remove();
                }
            );
        },
        
        initConfirmations: function() {
            // Add confirmation dialogs to dangerous actions
            $('.confirm-action').on('click', function(e) {
                var message = $(this).data('confirm') || boldmcqs_admin.text.confirm_delete;
                if (!confirm(message)) {
                    e.preventDefault();
                    return false;
                }
            });
        },
        
        refreshStats: function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var originalText = $button.html();
            
            $button.html('<i class="fas fa-spinner fa-spin"></i> ' + boldmcqs_admin.text.loading);
            $button.prop('disabled', true);
            
            $.ajax({
                url: boldmcqs_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'boldmcqs_refresh_stats',
                    nonce: boldmcqs_admin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Update stats on page
                        if (response.data.stats) {
                            $.each(response.data.stats, function(key, value) {
                                $('.stat-' + key).text(value);
                            });
                        }
                        BoldMCQsAdmin.showNotice('Stats refreshed successfully!', 'success');
                    } else {
                        BoldMCQsAdmin.showNotice('Error refreshing stats', 'error');
                    }
                },
                error: function() {
                    BoldMCQsAdmin.showNotice('Network error occurred', 'error');
                },
                complete: function() {
                    $button.html(originalText);
                    $button.prop('disabled', false);
                }
            });
        },
        
        handleQuickAction: function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var action = $button.data('action');
            var data = $button.data();
            
            if (!action) return;
            
            var originalText = $button.html();
            $button.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
            $button.prop('disabled', true);
            
            $.ajax({
                url: boldmcqs_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'boldmcqs_' + action,
                    nonce: boldmcqs_admin.nonce,
                    data: data
                },
                success: function(response) {
                    if (response.success) {
                        BoldMCQsAdmin.showNotice(response.data.message || 'Action completed successfully!', 'success');
                        
                        // Handle specific actions
                        if (action === 'delete_mcq' && response.data.redirect) {
                            window.location.href = response.data.redirect;
                        }
                        
                        // Refresh page data if needed
                        if (response.data.refresh) {
                            location.reload();
                        }
                    } else {
                        BoldMCQsAdmin.showNotice(response.data.message || 'Action failed', 'error');
                    }
                },
                error: function() {
                    BoldMCQsAdmin.showNotice('Network error occurred', 'error');
                },
                complete: function() {
                    $button.html(originalText);
                    $button.prop('disabled', false);
                }
            });
        },
        
        handleBulkAction: function(e) {
            e.preventDefault();
            
            var $form = $(this).closest('form');
            var action = $form.find('select[name="bulk_action"]').val();
            var selected = $form.find('input[name="items[]"]:checked');
            
            if (!action || action === '-1') {
                alert('Please select an action');
                return;
            }
            
            if (selected.length === 0) {
                alert('Please select at least one item');
                return;
            }
            
            var confirmMessage = 'Are you sure you want to ' + action + ' ' + selected.length + ' items?';
            if (!confirm(confirmMessage)) {
                return;
            }
            
            var items = [];
            selected.each(function() {
                items.push($(this).val());
            });
            
            $.ajax({
                url: boldmcqs_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'boldmcqs_bulk_action',
                    bulk_action: action,
                    items: items,
                    nonce: boldmcqs_admin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        BoldMCQsAdmin.showNotice(response.data.message, 'success');
                        location.reload();
                    } else {
                        BoldMCQsAdmin.showNotice(response.data.message, 'error');
                    }
                },
                error: function() {
                    BoldMCQsAdmin.showNotice('Network error occurred', 'error');
                }
            });
        },
        

        
        handleSearch: function() {
            var $input = $(this);
            var query = $input.val().toLowerCase();
            var target = $input.data('target');
            
            if (!target) return;
            
            $(target + ' [data-searchable]').each(function() {
                var $item = $(this);
                var text = $item.text().toLowerCase();
                
                if (text.indexOf(query) !== -1 || query === '') {
                    $item.show();
                } else {
                    $item.hide();
                }
            });
            
            // Update results count if available
            var visible = $(target + ' [data-searchable]:visible').length;
            var total = $(target + ' [data-searchable]').length;
            $('.search-results-count').text(visible + ' of ' + total + ' items');
        },
        
        openModal: function(e) {
            e.preventDefault();
            
            var modalId = $(this).data('modal');
            var modal = $('#' + modalId);
            
            if (modal.length) {
                modal.addClass('active');
                $('body').addClass('modal-open');
                
                // Focus first input
                modal.find('input, textarea, select').first().focus();
            }
        },
        
        closeModal: function(e) {
            if (e.target !== this && !$(e.target).hasClass('close-modal')) {
                return;
            }
            
            $('.modal.active').removeClass('active');
            $('body').removeClass('modal-open');
        },
        

        
        validateForm: function(e) {
            var $form = $(this);
            var isValid = true;
            var errors = [];
            
            // Clear previous errors
            $form.find('.error').removeClass('error');
            $form.find('.error-message').remove();
            
            // Required fields
            $form.find('[required]').each(function() {
                var $field = $(this);
                var value = $field.val().trim();
                
                if (!value) {
                    isValid = false;
                    $field.addClass('error');
                    errors.push($field.attr('name') + ' is required');
                }
            });
            
            // Email validation
            $form.find('input[type="email"]').each(function() {
                var $field = $(this);
                var email = $field.val().trim();
                
                if (email && !BoldMCQsAdmin.isValidEmail(email)) {
                    isValid = false;
                    $field.addClass('error');
                    errors.push('Invalid email format');
                }
            });
            
            // URL validation
            $form.find('input[type="url"]').each(function() {
                var $field = $(this);
                var url = $field.val().trim();
                
                if (url && !BoldMCQsAdmin.isValidUrl(url)) {
                    isValid = false;
                    $field.addClass('error');
                    errors.push('Invalid URL format');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                // Show error summary
                var errorHtml = '<div class="notice notice-error error-summary"><ul>';
                errors.forEach(function(error) {
                    errorHtml += '<li>' + error + '</li>';
                });
                errorHtml += '</ul></div>';
                
                $form.prepend(errorHtml);
                
                // Scroll to first error
                $('html, body').animate({
                    scrollTop: $form.find('.error').first().offset().top - 100
                }, 500);
            }
        },
        
        copyToClipboard: function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var text = $button.data('copy') || $button.prev('input').val();
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function() {
                    BoldMCQsAdmin.showNotice('Copied to clipboard!', 'success');
                });
            } else {
                // Fallback for older browsers
                var textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                BoldMCQsAdmin.showNotice('Copied to clipboard!', 'success');
            }
        },
        
        showNotice: function(message, type) {
            type = type || 'info';
            
            var noticeHtml = '<div class="notice notice-' + type + ' is-dismissible boldmcqs-notice">';
            noticeHtml += '<p>' + message + '</p>';
            noticeHtml += '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss</span></button>';
            noticeHtml += '</div>';
            
            // Remove existing notices
            $('.boldmcqs-notice').remove();
            
            // Add new notice
            $('.wrap').first().prepend(noticeHtml);
            
            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                $('.boldmcqs-notice').fadeOut(function() {
                    $(this).remove();
                });
            }, 5000);
        },
        
        isValidEmail: function(email) {
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        },
        
        isValidUrl: function(url) {
            try {
                new URL(url);
                return true;
            } catch (e) {
                return false;
            }
        },
        
        // Utility functions
        formatNumber: function(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        
        debounce: function(func, wait) {
            var timeout;
            return function executedFunction() {
                var later = function() {
                    clearTimeout(timeout);
                    func.apply(this, arguments);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },
        
        // Progress bar utility
        updateProgressBar: function(percentage, $progressBar) {
            $progressBar = $progressBar || $('.progress-bar');
            $progressBar.css('width', percentage + '%');
            $progressBar.attr('aria-valuenow', percentage);
            $progressBar.find('.progress-text').text(percentage + '%');
        }
    };
    
    // Chart functionality for statistics
    BoldMCQsAdmin.Charts = {
        
        init: function() {
            this.initDashboardCharts();
        },
        
        initDashboardCharts: function() {
            // MCQ Growth Chart
            var mcqGrowthCtx = document.getElementById('mcqGrowthChart');
            if (mcqGrowthCtx) {
                this.createMCQGrowthChart(mcqGrowthCtx);
            }
            
            // Category Distribution Chart
            var categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx) {
                this.createCategoryChart(categoryCtx);
            }
            
            // User Activity Chart
            var activityCtx = document.getElementById('activityChart');
            if (activityCtx) {
                this.createActivityChart(activityCtx);
            }
        },
        
        createMCQGrowthChart: function(ctx) {
            // Mock data - in real implementation, this would come from server
            var data = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'MCQs Created',
                    data: [12, 19, 25, 32, 45, 67],
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.3
                }]
            };
            
            if (typeof Chart !== 'undefined') {
                new Chart(ctx, {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        },
        
        createCategoryChart: function(ctx) {
            var data = {
                labels: ['Science', 'History', 'Mathematics', 'Literature', 'Geography'],
                datasets: [{
                    data: [30, 25, 20, 15, 10],
                    backgroundColor: [
                        '#22c55e',
                        '#3b82f6',
                        '#8b5cf6',
                        '#f59e0b',
                        '#ef4444'
                    ]
                }]
            };
            
            if (typeof Chart !== 'undefined') {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        },
        
        createActivityChart: function(ctx) {
            var data = {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'User Activity',
                    data: [65, 78, 90, 81, 56, 42, 38],
                    backgroundColor: 'rgba(34, 197, 94, 0.8)'
                }]
            };
            
            if (typeof Chart !== 'undefined') {
                new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    };
    
    // File upload handling
    BoldMCQsAdmin.FileUpload = {
        
        init: function() {
            this.bindEvents();
        },
        
        bindEvents: function() {
            $(document).on('dragover dragenter', '.file-drop-zone', this.handleDragOver);
            $(document).on('dragleave', '.file-drop-zone', this.handleDragLeave);
            $(document).on('drop', '.file-drop-zone', this.handleDrop);
            $(document).on('change', '.file-input', this.handleFileSelect);
        },
        
        handleDragOver: function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('drag-over');
        },
        
        handleDragLeave: function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('drag-over');
        },
        
        handleDrop: function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $dropZone = $(this);
            $dropZone.removeClass('drag-over');
            
            var files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                BoldMCQsAdmin.FileUpload.processFiles(files, $dropZone);
            }
        },
        
        handleFileSelect: function(e) {
            var files = this.files;
            var $input = $(this);
            var $dropZone = $input.closest('.file-drop-zone');
            
            if (files.length > 0) {
                BoldMCQsAdmin.FileUpload.processFiles(files, $dropZone);
            }
        },
        
        processFiles: function(files, $container) {
            Array.from(files).forEach(function(file) {
                BoldMCQsAdmin.FileUpload.uploadFile(file, $container);
            });
        },
        
        uploadFile: function(file, $container) {
            var formData = new FormData();
            formData.append('file', file);
            formData.append('action', 'boldmcqs_upload_file');
            formData.append('nonce', boldmcqs_admin.nonce);
            
            var $progress = $('<div class="upload-progress"><div class="progress-bar" style="width: 0%"></div><span class="file-name">' + file.name + '</span></div>');
            $container.append($progress);
            
            $.ajax({
                url: boldmcqs_admin.ajax_url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percentage = Math.round((e.loaded / e.total) * 100);
                            BoldMCQsAdmin.updateProgressBar(percentage, $progress.find('.progress-bar'));
                        }
                    });
                    return xhr;
                },
                success: function(response) {
                    if (response.success) {
                        $progress.addClass('upload-success');
                        BoldMCQsAdmin.showNotice('File uploaded successfully!', 'success');
                    } else {
                        $progress.addClass('upload-error');
                        BoldMCQsAdmin.showNotice('Upload failed: ' + response.data.message, 'error');
                    }
                },
                error: function() {
                    $progress.addClass('upload-error');
                    BoldMCQsAdmin.showNotice('Upload failed: Network error', 'error');
                },
                complete: function() {
                    setTimeout(function() {
                        $progress.fadeOut(function() {
                            $progress.remove();
                        });
                    }, 3000);
                }
            });
        }
    };
    
    // Initialize on document ready
    $(document).ready(function() {
        BoldMCQsAdmin.init();
        BoldMCQsAdmin.Charts.init();
        BoldMCQsAdmin.FileUpload.init();
        
        // Restore active tab from localStorage
        var activeTab = localStorage.getItem('boldmcqs_active_tab');
        if (activeTab) {
            $('.nav-tab[href="' + activeTab + '"], .nav-tab[data-target="' + activeTab + '"]').trigger('click');
        }
        
        // Initialize select2 if available
        if (typeof $.fn.select2 !== 'undefined') {
            $('.select2').select2({
                width: '100%'
            });
        }
        
        // Initialize date pickers if available
        if (typeof $.fn.datepicker !== 'undefined') {
            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        }
        
        // Auto-resize textareas
        $(document).on('input', 'textarea.auto-resize', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Sortable lists if jQuery UI available
        if (typeof $.fn.sortable !== 'undefined') {
            $('.sortable').sortable({
                handle: '.sort-handle',
                update: function(event, ui) {
                    var order = $(this).sortable('toArray', {
                        attribute: 'data-id'
                    });
                    
                    $.ajax({
                        url: boldmcqs_admin.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'boldmcqs_update_order',
                            order: order,
                            nonce: boldmcqs_admin.nonce
                        }
                    });
                }
            });
        }
    });
    
    // Demo Import Functionality
    BoldMCQsAdmin.DemoImport = {
        
        init: function() {
            console.log('BoldMCQs: Initializing Demo Import module');
            this.bindEvents();
            
            // Verify button exists
            var $btn = $('#importDemoBtn');
            console.log('Import button found:', $btn.length > 0, 'Button:', $btn);
        },
        
        bindEvents: function() {
            console.log('BoldMCQs: Binding import button event');
            $(document).on('click', '#importDemoBtn', this.handleImport);
        },
        
        handleImport: function(e) {
            e.preventDefault();
            console.log('BoldMCQs: Import button clicked!');
            
            var $btn = $(this);
            
            // Check if already importing or disabled
            if ($btn.prop('disabled') || $btn.hasClass('importing')) {
                return;
            }
            
            // Confirm action
            var message = 'This will import demo MCQs, categories, and tags to your site.\n\n' +
                         'Approximately 30 sample MCQs will be added.\n\nContinue?';
            
            if (!confirm(message)) {
                return;
            }
            
            // Update button state
            $btn.addClass('importing');
            $btn.prop('disabled', true);
            
            var originalHtml = $btn.html();
            $btn.html('<span class="flex items-center"><div class="spinner mr-2"></div><span>Importing Demo Content...</span></span>');
            
            // Show loading notification
            BoldMCQsAdmin.DemoImport.showNotification('Importing demo content...', 'info', false);
            
            // Perform AJAX request
            $.ajax({
                url: boldmcqs_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'boldmcqs_import_demo',
                    nonce: boldmcqs_admin.import_nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message with stats
                        var stats = response.data.stats;
                        var message = '<strong>Demo content imported successfully!</strong><br>';
                        message += '<small>✓ ' + stats.mcqs + ' MCQs<br>';
                        message += '✓ ' + stats.categories + ' Categories<br>';
                        message += '✓ ' + stats.tags + ' Tags</small>';
                        
                        if (stats.errors && stats.errors.length > 0) {
                            message += '<br><small class="text-orange-600">⚠ ' + stats.errors.length + ' warnings</small>';
                        }
                        
                        BoldMCQsAdmin.DemoImport.showNotification(message, 'success', true);
                        
                        // Update button to disabled state
                        $btn.removeClass('importing');
                        $btn.removeClass('bg-gradient-to-r from-orange-50 to-red-50 text-orange-700 hover:from-orange-100 hover:to-red-100');
                        $btn.addClass('bg-gray-100 text-gray-400 cursor-not-allowed');
                        $btn.html('<span class="flex items-center"><i class="fas fa-download mr-2"></i><span>Demo Imported</span></span><i class="fas fa-check-circle"></i>');
                        
                        // Add date info below button
                        var today = new Date();
                        var dateStr = today.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        $btn.after('<div class="text-xs text-gray-500 px-4 -mt-2">Imported on ' + dateStr + '</div>');
                        
                        // Reload after 2 seconds to show new content
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                        
                    } else {
                        // Show error message
                        var errorMsg = response.data && response.data.message ? response.data.message : 'An error occurred during import.';
                        BoldMCQsAdmin.DemoImport.showNotification('<strong>Import Failed</strong><br>' + errorMsg, 'error', true);
                        
                        // Reset button
                        $btn.removeClass('importing');
                        $btn.prop('disabled', false);
                        $btn.html(originalHtml);
                    }
                },
                error: function(xhr, status, error) {
                    // Show network error
                    BoldMCQsAdmin.DemoImport.showNotification('<strong>Network Error</strong><br>Failed to connect to server. Please try again.', 'error', true);
                    
                    // Reset button
                    $btn.removeClass('importing');
                    $btn.prop('disabled', false);
                    $btn.html(originalHtml);
                }
            });
        },
        
        showNotification: function(message, type, dismissible) {
            type = type || 'info';
            dismissible = dismissible !== false;
            
            // Color schemes
            var colors = {
                'success': 'bg-green-50 border-green-400 text-green-800',
                'error': 'bg-red-50 border-red-400 text-red-800',
                'warning': 'bg-yellow-50 border-yellow-400 text-yellow-800',
                'info': 'bg-blue-50 border-blue-400 text-blue-800'
            };
            
            var icons = {
                'success': 'fa-check-circle',
                'error': 'fa-exclamation-circle',
                'warning': 'fa-exclamation-triangle',
                'info': 'fa-info-circle'
            };
            
            var colorClass = colors[type] || colors.info;
            var iconClass = icons[type] || icons.info;
            
            var html = '<div class="animate-fade-in border-l-4 p-4 rounded-lg ' + colorClass + '" role="alert">';
            html += '<div class="flex items-start">';
            html += '<div class="flex-shrink-0"><i class="fas ' + iconClass + ' text-lg"></i></div>';
            html += '<div class="ml-3 flex-1">';
            html += '<div class="text-sm">' + message + '</div>';
            html += '</div>';
            
            if (dismissible) {
                html += '<button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 hover:bg-white" onclick="this.parentElement.parentElement.remove()">';
                html += '<i class="fas fa-times"></i>';
                html += '</button>';
            }
            
            html += '</div></div>';
            
            var $notification = $('#importNotification');
            $notification.html(html);
            $notification.removeClass('hidden');
            
            // Auto-dismiss after 8 seconds if dismissible
            if (dismissible) {
                setTimeout(function() {
                    $notification.fadeOut(function() {
                        $notification.addClass('hidden');
                        $notification.empty();
                    });
                }, 8000);
            }
        }
    };
    
    // Initialize demo import on document ready
    $(document).ready(function() {
        BoldMCQsAdmin.init();
        BoldMCQsAdmin.Charts.init();
        BoldMCQsAdmin.FileUpload.init();
        BoldMCQsAdmin.DemoImport.init();
        
        // Debug log
        if (typeof console !== 'undefined' && console.log) {
            console.log('BoldMCQs Admin: All modules initialized');
            console.log('Demo Import module:', BoldMCQsAdmin.DemoImport);
        }
    });
    
})(jQuery);
