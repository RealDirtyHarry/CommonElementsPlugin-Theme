
/**
 * Navigation JavaScript
 * 
 * Handles menu navigation, dropdowns, and accessibility.
 */
(function($) {
    'use strict';

    const CE_Navigation = {
        init: function() {
            this.initMainMenu();
            this.initMegaMenu();
            this.initKeyboardNavigation();
            this.initCurrentMenuHighlight();
        },

        initMainMenu: function() {
            $('.ce-main-menu .menu-item-has-children > a').append('<span class="ce-dropdown-toggle"><i class="fas fa-chevron-down"></i></span>');
            
            $('.ce-dropdown-toggle').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const $toggle = $(this);
                const $menuItem = $toggle.closest('.menu-item-has-children');
                const $submenu = $menuItem.find('> .sub-menu');
                
                $menuItem.siblings('.menu-item-has-children.submenu-open').removeClass('submenu-open').find('> .sub-menu').slideUp(200);
                
                $submenu.slideToggle(200);
                $menuItem.toggleClass('submenu-open');
                $toggle.find('i').toggleClass('fa-chevron-down fa-chevron-up');
                
                if ($menuItem.hasClass('submenu-open')) {
                    $menuItem.find('> a').attr('aria-expanded', 'true');
                } else {
                    $menuItem.find('> a').attr('aria-expanded', 'false');
                }
            });
            
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.ce-main-menu').length) {
                    $('.ce-main-menu .submenu-open').removeClass('submenu-open').find('> .sub-menu').slideUp(200);
                    $('.ce-main-menu .menu-item-has-children > a').attr('aria-expanded', 'false');
                    $('.ce-dropdown-toggle i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                }
            });
        },

        initMegaMenu: function() {
            $('.ce-mega-menu-item').each(function() {
                const $megaMenuItem = $(this);
                const $megaMenu = $megaMenuItem.find('.ce-mega-menu');
                
                $megaMenuItem.on('mouseenter', function() {
                    const menuItemOffset = $megaMenuItem.offset();
                    const menuItemWidth = $megaMenuItem.outerWidth();
                    const megaMenuWidth = $megaMenu.outerWidth();
                    
                    const leftPosition = menuItemOffset.left + (menuItemWidth / 2) - (megaMenuWidth / 2);
                    
                    const windowWidth = $(window).width();
                    let adjustedLeftPosition = leftPosition;
                    
                    if (leftPosition < 0) {
                        adjustedLeftPosition = 0;
                    } else if (leftPosition + megaMenuWidth > windowWidth) {
                        adjustedLeftPosition = windowWidth - megaMenuWidth;
                    }
                    
                    $megaMenu.css('left', adjustedLeftPosition + 'px');
                    $megaMenuItem.addClass('submenu-open');
                });
                
                $megaMenuItem.on('mouseleave', function() {
                    $megaMenuItem.removeClass('submenu-open');
                });
            });
        },

        initKeyboardNavigation: function() {
            $('.ce-main-menu .menu-item > a').attr('tabindex', '0');
            
            $('.ce-main-menu .menu-item > a').on('keydown', function(e) {
                const $menuItem = $(this).parent();
                
                if (e.keyCode === 13 || e.keyCode === 32) {
                    if ($menuItem.hasClass('menu-item-has-children')) {
                        e.preventDefault();
                        $menuItem.find('.ce-dropdown-toggle').trigger('click');
                    }
                }
                
                if (e.keyCode === 40) {
                    e.preventDefault();
                    
                    if ($menuItem.hasClass('menu-item-has-children') && !$menuItem.hasClass('submenu-open')) {
                        $menuItem.find('.ce-dropdown-toggle').trigger('click');
                    } else if ($menuItem.hasClass('submenu-open')) {
                        $menuItem.find('> .sub-menu > .menu-item:first-child > a').focus();
                    } else {
                        $menuItem.next('.menu-item').find('> a').focus();
                    }
                }
                
                if (e.keyCode === 38) {
                    e.preventDefault();
                    
                    if ($menuItem.parent().hasClass('sub-menu')) {
                        const $prevMenuItem = $menuItem.prev('.menu-item');
                        
                        if ($prevMenuItem.length) {
                            $prevMenuItem.find('> a').focus();
                        } else {
                            $menuItem.parent().closest('.menu-item').find('> a').focus();
                        }
                    } else {
                        $menuItem.prev('.menu-item').find('> a').focus();
                    }
                }
                
                if (e.keyCode === 27) {
                    if ($menuItem.parent().hasClass('sub-menu')) {
                        e.preventDefault();
                        
                        $menuItem.parent().closest('.menu-item').removeClass('submenu-open').find('> a').focus();
                        $menuItem.parent().slideUp(200);
                    }
                }
            });
        },

        initCurrentMenuHighlight: function() {
            const currentUrl = window.location.href;
            
            $('.ce-main-menu .menu-item > a').each(function() {
                const menuItemUrl = $(this).attr('href');
                
                if (currentUrl === menuItemUrl || currentUrl.indexOf(menuItemUrl) > -1) {
                    $(this).closest('.menu-item').addClass('current-menu-item');
                    
                    $(this).parents('.menu-item').addClass('current-menu-parent');
                }
            });
        }
    };

    $(document).ready(function() {
        CE_Navigation.init();
    });

})(jQuery);
