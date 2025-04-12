/**
 * Common Elements Platform Admin JavaScript
 *
 * Handles all admin-specific JavaScript functionality
 */

jQuery(document).ready(function($) {
    // Tab functionality for settings page
    $('.common-elements-admin-tabs a').on('click', function(e) {
        e.preventDefault();
        
        // Hide all sections
        $('.common-elements-admin-card[id]').hide();
        
        // Show the selected section
        $($(this).attr('href')).show();
        
        // Update active tab
        $('.common-elements-admin-tabs a').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        
        // Store the active tab in localStorage
        localStorage.setItem('commonElementsActiveTab', $(this).attr('href'));
    });
    
    // Check if we have a stored tab preference
    var activeTab = localStorage.getItem('commonElementsActiveTab');
    if (activeTab) {
        // Trigger click on the stored tab
        $('.common-elements-admin-tabs a[href="' + activeTab + '"]').trigger('click');
    } else {
        // Show the first tab by default
        $('.common-elements-admin-card[id]').first().show().siblings('.common-elements-admin-card[id]').hide();
    }
    
    // Media uploader for image fields
    $('.common-elements-admin-button.media-upload').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var field = button.prev('input');
        
        // Create the media frame
        var frame = wp.media({
            title: 'Select or Upload Media',
            button: {
                text: 'Use this media'
            },
            multiple: false
        });
        
        // When an image is selected, run a callback
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            field.val(attachment.url);
        });
        
        // Open the modal
        frame.open();
    });
    
    // Form validation
    $('.common-elements-admin-form').on('submit', function(e) {
        var valid = true;
        
        // Check required fields
        $(this).find('input[required]').each(function() {
            if ($(this).val() === '') {
                $(this).addClass('error');
                valid = false;
            } else {
                $(this).removeClass('error');
            }
        });
        
        if (!valid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
    
    // Toggle sections
    $('.common-elements-admin-toggle').on('click', function() {
        $(this).next('.common-elements-admin-toggle-content').slideToggle();
        $(this).toggleClass('active');
    });
    
    // Initialize tooltips
    $('.common-elements-admin-tooltip').hover(
        function() {
            var tooltip = $(this).find('.common-elements-admin-tooltip-content');
            tooltip.fadeIn(200);
        },
        function() {
            var tooltip = $(this).find('.common-elements-admin-tooltip-content');
            tooltip.fadeOut(200);
        }
    );
    
    // Confirmation dialogs
    $('.common-elements-admin-confirm').on('click', function(e) {
        if (!confirm($(this).data('confirm') || 'Are you sure you want to proceed?')) {
            e.preventDefault();
        }
    });
});
