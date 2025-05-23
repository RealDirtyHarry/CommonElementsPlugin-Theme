/**
 * Dashboard JavaScript
 * 
 * Handles widget drag-and-drop, toggling, and settings.
 */
(function($) {
    'use strict';
    
    const CE_Dashboard = {
        init: function() {
            this.initWidgetSorting();
            this.initWidgetToggles();
            this.initWidgetSettings();
        },
        
        initWidgetSorting: function() {
            $('.ce-dashboard-widgets-container').sortable({
                handle: '.ce-dashboard-widget-header',
                placeholder: 'ce-dashboard-widget-placeholder',
                forcePlaceholderSize: true,
                update: function(event, ui) {
                    const widgetId = ui.item.data('widget-id');
                    const column = ui.item.parent().data('column');
                    const position = ui.item.index();
                    
                    CE_Dashboard.saveWidgetPosition(widgetId, column, position);
                }
            });
        },
        
        saveWidgetPosition: function(widgetId, column, position) {
            $.ajax({
                url: common_elements_platform.ajax_url,
                type: 'POST',
                data: {
                    action: 'ce_ajax_save_widget_position',
                    nonce: common_elements_platform.nonce,
                    widget_id: widgetId,
                    column: column,
                    position: position
                },
                success: function(response) {
                    if (!response.success) {
                        console.error('Failed to save widget position');
                    }
                },
                error: function() {
                    console.error('AJAX error');
                }
            });
        },
        
        initWidgetToggles: function() {
            $(document).on('click', '.ce-dashboard-widget-toggle', function(e) {
                e.preventDefault();
                
                const $widget = $(this).closest('.ce-dashboard-widget');
                const $content = $widget.find('.ce-dashboard-widget-content');
                const $icon = $(this).find('i');
                
                if ($content.is(':visible')) {
                    $content.slideUp(200);
                    $icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                } else {
                    $content.slideDown(200);
                    $icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                }
            });
        },
        
        initWidgetSettings: function() {
            $(document).on('click', '.ce-dashboard-widget-settings', function(e) {
                e.preventDefault();
                
                const $widget = $(this).closest('.ce-dashboard-widget');
                const widgetId = $widget.data('widget-id');
                
                CE_Dashboard.openWidgetSettings(widgetId);
            });
        },
        
        openWidgetSettings: function(widgetId) {
            $.ajax({
                url: common_elements_platform.ajax_url,
                type: 'POST',
                data: {
                    action: 'ce_ajax_get_widget_settings',
                    nonce: common_elements_platform.nonce,
                    widget_id: widgetId
                },
                success: function(response) {
                    if (response.success) {
                        const $modal = $('<div class="ce-dashboard-widget-settings-modal"></div>');
                        $modal.html(response.data.html);
                        $('body').append($modal);
                        
                        CE_Dashboard.initSettingsForm(widgetId);
                    } else {
                        console.error('Failed to get widget settings');
                    }
                },
                error: function() {
                    console.error('AJAX error');
                }
            });
        },
        
        initSettingsForm: function(widgetId) {
            $(document).on('submit', '#ce-widget-settings-form-' + widgetId, function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                
                $.ajax({
                    url: common_elements_platform.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'ce_ajax_save_widget_settings',
                        nonce: common_elements_platform.nonce,
                        widget_id: widgetId,
                        form_data: formData
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.ce-dashboard-widget-settings-modal').remove();
                            CE_Dashboard.refreshWidget(widgetId);
                        } else {
                            console.error('Failed to save widget settings');
                        }
                    },
                    error: function() {
                        console.error('AJAX error');
                    }
                });
            });
            
            $(document).on('click', '.ce-widget-settings-cancel', function(e) {
                e.preventDefault();
                $('.ce-dashboard-widget-settings-modal').remove();
            });
        },
        
        refreshWidget: function(widgetId) {
            const $widget = $('#ce-widget-' + widgetId);
            
            $.ajax({
                url: common_elements_platform.ajax_url,
                type: 'POST',
                data: {
                    action: 'ce_ajax_refresh_widget',
                    nonce: common_elements_platform.nonce,
                    widget_id: widgetId
                },
                success: function(response) {
                    if (response.success) {
                        $widget.replaceWith(response.data.html);
                    } else {
                        console.error('Failed to refresh widget');
                    }
                },
                error: function() {
                    console.error('AJAX error');
                }
            });
        },
        
        addWidget: function(dashboardId, widgetType) {
            $.ajax({
                url: common_elements_platform.ajax_url,
                type: 'POST',
                data: {
                    action: 'ce_ajax_add_widget',
                    nonce: common_elements_platform.nonce,
                    dashboard_id: dashboardId,
                    widget_type: widgetType
                },
                success: function(response) {
                    if (response.success) {
                        $('.ce-dashboard-column:first').append(response.data.html);
                    } else {
                        console.error('Failed to add widget');
                    }
                },
                error: function() {
                    console.error('AJAX error');
                }
            });
        },
        
        removeWidget: function(widgetId) {
            $.ajax({
                url: common_elements_platform.ajax_url,
                type: 'POST',
                data: {
                    action: 'ce_ajax_remove_widget',
                    nonce: common_elements_platform.nonce,
                    widget_id: widgetId
                },
                success: function(response) {
                    if (response.success) {
                        $('#ce-widget-' + widgetId).fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        console.error('Failed to remove widget');
                    }
                },
                error: function() {
                    console.error('AJAX error');
                }
            });
        }
    };
    
    $(document).ready(function() {
        CE_Dashboard.init();
    });
    
    window.CE_Dashboard = CE_Dashboard;
    
})(jQuery);
