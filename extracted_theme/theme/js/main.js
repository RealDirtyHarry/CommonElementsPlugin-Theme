
/**
 * Main theme JavaScript
 * 
 * Handles general theme functionality and interactions.
 */
(function($) {
    'use strict';

    const CE_Theme = {
        init: function() {
            this.initMobileMenu();
            this.initStickyHeader();
            this.initScrollToTop();
            this.initAccordions();
            this.initTabs();
            this.initTooltips();
            this.initModals();
        },

        initMobileMenu: function() {
            const $menuToggle = $('.ce-mobile-menu-toggle');
            const $mobileMenu = $('.ce-mobile-menu');
            const $overlay = $('.ce-overlay');

            $menuToggle.on('click', function(e) {
                e.preventDefault();
                
                $mobileMenu.toggleClass('active');
                $overlay.toggleClass('active');
                $('body').toggleClass('ce-menu-open');
                
                if ($mobileMenu.hasClass('active')) {
                    $menuToggle.attr('aria-expanded', 'true');
                } else {
                    $menuToggle.attr('aria-expanded', 'false');
                }
            });

            $overlay.on('click', function() {
                $mobileMenu.removeClass('active');
                $overlay.removeClass('active');
                $('body').removeClass('ce-menu-open');
                $menuToggle.attr('aria-expanded', 'false');
            });

            $('.ce-mobile-menu .menu-item-has-children > a').append('<span class="ce-submenu-toggle"><i class="fas fa-chevron-down"></i></span>');
            
            $(document).on('click', '.ce-submenu-toggle', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const $toggle = $(this);
                const $menuItem = $toggle.closest('.menu-item-has-children');
                const $submenu = $menuItem.find('> .sub-menu');
                
                $submenu.slideToggle(200);
                $menuItem.toggleClass('submenu-open');
                $toggle.find('i').toggleClass('fa-chevron-down fa-chevron-up');
            });
        },

        initStickyHeader: function() {
            const $header = $('.ce-site-header');
            const headerHeight = $header.outerHeight();
            let lastScrollTop = 0;
            
            if ($header.hasClass('ce-sticky-header')) {
                $(window).on('scroll', function() {
                    const scrollTop = $(this).scrollTop();
                    
                    if (scrollTop > headerHeight) {
                        $header.addClass('ce-sticky');
                        $('body').css('padding-top', headerHeight + 'px');
                        
                        if (scrollTop > lastScrollTop && scrollTop > headerHeight * 2) {
                            $header.addClass('ce-header-hidden');
                        } else {
                            $header.removeClass('ce-header-hidden');
                        }
                    } else {
                        $header.removeClass('ce-sticky ce-header-hidden');
                        $('body').css('padding-top', '0');
                    }
                    
                    lastScrollTop = scrollTop;
                });
            }
        },

        initScrollToTop: function() {
            const $scrollTop = $('.ce-scroll-top');
            
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 300) {
                    $scrollTop.addClass('active');
                } else {
                    $scrollTop.removeClass('active');
                }
            });
            
            $scrollTop.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 500);
            });
        },

        initAccordions: function() {
            $('.ce-accordion-title').on('click', function() {
                const $title = $(this);
                const $accordion = $title.closest('.ce-accordion');
                const $content = $accordion.find('.ce-accordion-content');
                const $icon = $title.find('.ce-accordion-icon');
                
                $content.slideToggle(200);
                $accordion.toggleClass('ce-accordion-active');
                $icon.toggleClass('fa-plus fa-minus');
                
                if ($accordion.hasClass('ce-accordion-active')) {
                    $title.attr('aria-expanded', 'true');
                } else {
                    $title.attr('aria-expanded', 'false');
                }
            });
        },

        initTabs: function() {
            $('.ce-tabs-nav-item').on('click', function(e) {
                e.preventDefault();
                
                const $tab = $(this);
                const tabId = $tab.attr('href');
                const $tabsContainer = $tab.closest('.ce-tabs');
                
                $tabsContainer.find('.ce-tabs-nav-item').removeClass('active');
                $tabsContainer.find('.ce-tab-panel').removeClass('active');
                
                $tab.addClass('active');
                $(tabId).addClass('active');
            });
        },

        initTooltips: function() {
            $('.ce-tooltip').each(function() {
                const $tooltip = $(this);
                const $trigger = $tooltip.find('.ce-tooltip-trigger');
                const $content = $tooltip.find('.ce-tooltip-content');
                
                $trigger.on('mouseenter', function() {
                    $content.addClass('active');
                    
                    const triggerOffset = $trigger.offset();
                    const triggerWidth = $trigger.outerWidth();
                    const triggerHeight = $trigger.outerHeight();
                    const contentWidth = $content.outerWidth();
                    
                    $content.css({
                        top: triggerOffset.top + triggerHeight + 10 + 'px',
                        left: triggerOffset.left + (triggerWidth / 2) - (contentWidth / 2) + 'px'
                    });
                });
                
                $trigger.on('mouseleave', function() {
                    $content.removeClass('active');
                });
            });
        },

        initModals: function() {
            $('.ce-modal-trigger').on('click', function(e) {
                e.preventDefault();
                
                const modalId = $(this).data('modal');
                const $modal = $('#' + modalId);
                
                $modal.addClass('active');
                $('body').addClass('ce-modal-open');
            });
            
            $('.ce-modal-close, .ce-modal-overlay').on('click', function() {
                $('.ce-modal').removeClass('active');
                $('body').removeClass('ce-modal-open');
            });
            
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27 && $('.ce-modal.active').length) {
                    $('.ce-modal').removeClass('active');
                    $('body').removeClass('ce-modal-open');
                }
            });
        }
    };

    $(document).ready(function() {
        CE_Theme.init();
    });

})(jQuery);
