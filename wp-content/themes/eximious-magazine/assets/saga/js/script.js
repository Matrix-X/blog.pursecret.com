!function (e) {
    "use strict";
    var n = window.SAGA_JS || {};

    var prevScrollPos = window.pageYOffset;

    var navBar = e(".em-header-menu-wrap");
    var navOffset = navBar.offset().top;

    n.stickyMenu = function () {
        var currentScrollPos = window.pageYOffset;
        if (navOffset < currentScrollPos) {
            navBar.addClass("em-nav-affix");
            navBar.addClass("scrolling-down").removeClass("scrolling-up");
        } else {
            navBar.removeClass("em-nav-affix");
        }

        if (prevScrollPos > currentScrollPos) {
            navBar.addClass("scrolling-up").removeClass("scrolling-down");
        }

        prevScrollPos = currentScrollPos;

    },

    n.stickySidebar = function () {
        var stickyOption = eximiousMagazine.stickySidebar;
        if(stickyOption){
            if('home' === stickyOption){
                if(e('body').hasClass('home')){
                    jQuery('body.home #secondary.sidebar-area').theiaStickySidebar({
                        containerSelector: '.container',
                        additionalMarginTop: 70,
                        additionalMarginBottom: 0
                    });
                }
            }else{
                jQuery('#secondary.sidebar-area').theiaStickySidebar({
                    containerSelector: '.container',
                    additionalMarginTop: 70,
                    additionalMarginBottom: 0
                });
            }
        }
    },

    n.mobileMenu = {
        init: function () {
            this.toggleMenu(), this.menuMobile(), this.menuArrow()
        },
        toggleMenu: function () {
            e('#masthead').on('click', '.toggle-menu', function (event) {
                var ethis = e('.main-navigation .menu .menu-mobile');
                if (ethis.css('display') == 'block') {
                    ethis.slideUp('300');
                    e("#masthead").removeClass('mmenu-active');
                } else {
                    ethis.slideDown('300');
                    e("#masthead").addClass('mmenu-active');
                }
                e('.ham').toggleClass('exit');
            });
            e('#masthead .main-navigation ').on('click', '.menu-mobile a i', function (event) {
                event.preventDefault();
                var ethis = e(this),
                    eparent = ethis.closest('li'),
                    esub_menu = eparent.find('> .sub-menu');
                if (esub_menu.css('display') == 'none') {
                    esub_menu.slideDown('300');
                    ethis.addClass('active');
                } else {
                    esub_menu.slideUp('300');
                    ethis.removeClass('active');
                }
                return false;
            });
        },
        menuMobile: function () {
            if (e('.main-navigation .menu > ul').length) {
                var ethis = e('.main-navigation .menu > ul'),
                    eparent = ethis.closest('.main-navigation'),
                    pointbreak = eparent.data('epointbreak'),
                    window_width = window.innerWidth;
                if (typeof pointbreak == 'undefined') {
                    pointbreak = 991;
                }
                if (pointbreak >= window_width) {
                    ethis.addClass('menu-mobile').removeClass('menu-desktop');
                    e('.main-navigation .toggle-menu').css('display', 'block');
                } else {
                    ethis.addClass('menu-desktop').removeClass('menu-mobile').css('display', '');
                    e('.main-navigation .toggle-menu').css('display', '');
                }
            }
        },
        menuArrow: function () {
            if (e('#masthead .main-navigation div.menu > ul').length) {
                e('#masthead .main-navigation div.menu > ul .sub-menu').parent('li').find('> a').append('<i class="fas fa-angle-down"></i>');
            }
        }
    },

    n.searchReveal = function () {
        e('.search-overlay .search-icon').on('click', function() {
            e(this).parent().toggleClass('reveal-search');
            return false;
        });
    },

    n.DataBackground = function () {
        e('.em-bg-image').each(function () {
            var src = e(this).children('img').attr('src');
            e(this).css('background-image', 'url(' + src + ')').children('img').hide();
        });
    },

    n.jQueryMarquee = function () {
        e('.marquee').marquee({
            /*speed: 30000,
            gap: 0,
            delayBeforeStart: 0,
            direction: 'left',
            duplicated: true,
            pauseOnHover: true,
            startVisible: true*/
            duration: 60000,
            gap: 0,
            delayBeforeStart: 0,
            direction: 'left',
            duplicated: true,
            pauseOnHover: true,
            startVisible: true
        });
    },

    n.owlCarousel = function () {
        e(".em-banner-slider").owlCarousel({
            animateIn: 'slideInRight',
            animateOut: 'slideOutLeft',
            items:1,
            loop:true,
            nav:true,
            dots: false,
            smartSpeed:450
        });
        e('.eximious_magazine_posts_slider .owl-carousel').owlCarousel({
            loop:true,
            nav:true,
            items:1,
            dots: false
        });
        e('.general-widget-area .eximious_magazine_posts_carousel .owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            dots: false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        });
        e('.widget-area .eximious_magazine_posts_carousel .owl-carousel').owlCarousel({
            loop:true,
            nav:true,
            dots: false,
            items:1
        });
        e('.saga-footer .eximious_magazine_posts_carousel .owl-carousel').owlCarousel({
            loop:true,
            nav:true,
            dots: false,
            items:1
        });
    },

    n.show_hide_scroll_top = function () {
        if (e(window).scrollTop() > e(window).height() / 2) {
            e("#scroll-up").fadeIn(300);
        } else {
            e("#scroll-up").fadeOut(300);
        }
    },

    n.scroll_up = function () {
        e("#scroll-up").on("click", function () {
            e("html, body").animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    },

    e(document).ready(function () {
        n.mobileMenu.init(), n.searchReveal(), n.DataBackground(), n.jQueryMarquee(), n.owlCarousel(), n.stickySidebar(), n.scroll_up();
    });
    e(window).load(function () {
        e('.preloader').fadeOut('slow');
    });
    e(window).scroll(function () {
        n.stickyMenu(), n.show_hide_scroll_top();
    });
    e(window).resize(function () {
        n.mobileMenu.menuMobile();
    });
}(jQuery);