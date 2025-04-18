/**
 * Directory System JavaScript
 * 
 * Handles directory listing filtering, search, and map integration.
 */
(function($) {
    'use strict';
    
    const CE_Directory = {
        init: function() {
            this.initSearch();
            this.initFiltering();
            this.initMapView();
        },
        
        initSearch: function() {
            $('.ce-directory-search-input').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                
                $('.ce-directory-item').each(function() {
                    const $item = $(this);
                    const title = $item.find('.ce-directory-item-title').text().toLowerCase();
                    const description = $item.find('.ce-directory-item-description').text().toLowerCase();
                    const categories = $item.find('.ce-directory-item-category').text().toLowerCase();
                    
                    if (title.indexOf(searchTerm) > -1 || description.indexOf(searchTerm) > -1 || categories.indexOf(searchTerm) > -1) {
                        $item.show();
                    } else {
                        $item.hide();
                    }
                });
            });
        },
        
        initFiltering: function() {
            $('.ce-directory-filter select').on('change', function() {
                const category = $('.ce-directory-filter-category').val();
                const location = $('.ce-directory-filter-location').val();
                const sort = $('.ce-directory-filter-sort').val();
                
                CE_Directory.loadFilteredListings(category, location, sort);
            });
        },
        
        loadFilteredListings: function(category, location, sort) {
            const $container = $('.ce-directory-list');
            
            $container.addClass('ce-loading');
            
            $.ajax({
                url: common_elements_platform.ajax_url,
                type: 'POST',
                data: {
                    action: 'ce_ajax_filter_directory',
                    nonce: common_elements_platform.nonce,
                    category: category,
                    location: location,
                    sort: sort
                },
                success: function(response) {
                    if (response.success) {
                        $container.html(response.data.html);
                    } else {
                        console.error('Failed to filter directory');
                    }
                    $container.removeClass('ce-loading');
                },
                error: function() {
                    console.error('AJAX error');
                    $container.removeClass('ce-loading');
                }
            });
        },
        
        initMapView: function() {
            const $mapContainer = $('#ce-directory-map');
            
            if ($mapContainer.length && typeof google !== 'undefined' && google.maps) {
                const map = new google.maps.Map($mapContainer[0], {
                    center: { lat: parseFloat($mapContainer.data('lat')), lng: parseFloat($mapContainer.data('lng')) },
                    zoom: parseInt($mapContainer.data('zoom')),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                
                $('.ce-directory-item').each(function() {
                    const $item = $(this);
                    const lat = parseFloat($item.data('lat'));
                    const lng = parseFloat($item.data('lng'));
                    
                    if (lat && lng) {
                        const marker = new google.maps.Marker({
                            position: { lat: lat, lng: lng },
                            map: map,
                            title: $item.find('.ce-directory-item-title').text()
                        });
                        
                        const infoWindow = new google.maps.InfoWindow({
                            content: '<div class="ce-map-info-window">' +
                                    '<h3>' + $item.find('.ce-directory-item-title').text() + '</h3>' +
                                    '<p>' + $item.find('.ce-directory-item-address').text() + '</p>' +
                                    '<a href="' + $item.find('.ce-directory-item-link').attr('href') + '">View Details</a>' +
                                    '</div>'
                        });
                        
                        marker.addListener('click', function() {
                            infoWindow.open(map, marker);
                        });
                    }
                });
            }
        }
    };
    
    $(document).ready(function() {
        CE_Directory.init();
    });
    
})(jQuery);
