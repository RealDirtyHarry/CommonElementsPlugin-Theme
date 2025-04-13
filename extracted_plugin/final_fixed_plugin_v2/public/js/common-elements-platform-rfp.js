/**
 * RFP System JavaScript
 * 
 * Handles RFP submission, viewing, and proposals.
 */
(function($) {
    'use strict';
    
    const CE_RFP = {
        init: function() {
            this.initFormValidation();
            this.initFileUploads();
            this.initFilteringAndSorting();
        },
        
        initFormValidation: function() {
            $('.ce-rfp-form').on('submit', function(e) {
                const $form = $(this);
                const $requiredInputs = $form.find('[required]');
                let isValid = true;
                
                $requiredInputs.each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('ce-form-error');
                    } else {
                        $(this).removeClass('ce-form-error');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    $('.ce-form-error-message').show();
                }
            });
        },
        
        initFileUploads: function() {
            $('.ce-file-upload-input').on('change', function() {
                const $input = $(this);
                const $preview = $input.closest('.ce-file-upload').find('.ce-file-preview');
                const allowedTypes = $input.data('allowed-types').split(',');
                const maxSize = $input.data('max-size') * 1024 * 1024; // Convert to bytes
                
                $preview.empty();
                
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    
                    const fileType = file.type.split('/')[1];
                    if (allowedTypes.indexOf(fileType) === -1) {
                        $preview.html('<div class="ce-file-error">Invalid file type. Allowed types: ' + allowedTypes.join(', ') + '</div>');
                        $input.val('');
                        return;
                    }
                    
                    if (file.size > maxSize) {
                        $preview.html('<div class="ce-file-error">File too large. Maximum size: ' + (maxSize / (1024 * 1024)) + 'MB</div>');
                        $input.val('');
                        return;
                    }
                    
                    $preview.html('<div class="ce-file-info"><span class="ce-file-name">' + file.name + '</span><span class="ce-file-size">(' + (file.size / 1024).toFixed(2) + ' KB)</span></div>');
                }
            });
        },
        
        initFilteringAndSorting: function() {
            $('.ce-rfp-filter select').on('change', function() {
                const category = $('.ce-rfp-filter-category').val();
                const status = $('.ce-rfp-filter-status').val();
                const sort = $('.ce-rfp-filter-sort').val();
                
                CE_RFP.loadFilteredRFPs(category, status, sort);
            });
        },
        
        loadFilteredRFPs: function(category, status, sort) {
            const $container = $('.ce-rfp-list');
            
            $container.addClass('ce-loading');
            
            $.ajax({
                url: common_elements_platform.ajax_url,
                type: 'POST',
                data: {
                    action: 'ce_ajax_filter_rfps',
                    nonce: common_elements_platform.nonce,
                    category: category,
                    status: status,
                    sort: sort
                },
                success: function(response) {
                    if (response.success) {
                        $container.html(response.data.html);
                    } else {
                        console.error('Failed to filter RFPs');
                    }
                    $container.removeClass('ce-loading');
                },
                error: function() {
                    console.error('AJAX error');
                    $container.removeClass('ce-loading');
                }
            });
        }
    };
    
    $(document).ready(function() {
        CE_RFP.init();
    });
    
})(jQuery);
