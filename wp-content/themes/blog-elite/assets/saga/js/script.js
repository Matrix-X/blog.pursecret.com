!function ($) {
    "use strict";
    var SAGA = SAGA || {};

    var prevScrollPos = window.pageYOffset;

    var navBar = $(".be-header-menu-wrap");
    var navOffset = navBar.offset().top;

    /* --------------- Sticky Menu ---------------*/
    SAGA.stickyMenu = function () {
        var currentScrollPos = window.pageYOffset;
        if (prevScrollPos > currentScrollPos) {
            if (navOffset > currentScrollPos || currentScrollPos === 0){
                navBar.removeClass("be-nav-affix");
            }else{
                navBar.addClass("be-nav-affix");
            }
        }else{
            navBar.removeClass("be-nav-affix");
        }
        prevScrollPos = currentScrollPos;
    },

    /* --------------- Sticky Sidebar ---------------*/
    SAGA.stickySidebar = function () {
        var stickySidebarGlobal = blogElite.stickySidebarGlobal;
        var stickySidebarFrontPage = blogElite.stickySidebarFrontPage;

        if(stickySidebarFrontPage || stickySidebarGlobal){
            if(stickySidebarFrontPage && !stickySidebarGlobal){
                if($('body').hasClass('be-home')){
                    jQuery('body.home #secondary.sidebar-area').theiaStickySidebar({
                        containerSelector: '.saga-container',
                        additionalMarginTop: 70,
                        additionalMarginBottom: 0
                    });
                }
            }else if(!stickySidebarFrontPage && stickySidebarGlobal){
                if(!$('body').hasClass('be-home')){
                    jQuery('#secondary.sidebar-area').theiaStickySidebar({
                        containerSelector: '.saga-container',
                        additionalMarginTop: 70,
                        additionalMarginBottom: 0
                    });
                }
            }else{
                jQuery('#secondary.sidebar-area').theiaStickySidebar({
                    containerSelector: '.saga-container',
                    additionalMarginTop: 70,
                    additionalMarginBottom: 0
                });
            }
        }

    },

    /* --------------- Mobile Menu ---------------*/
    SAGA.mobileMenu = {
        init: function () {
            this.toggleMenu(), this.menuMobile(), this.menuArrow()
        },
        toggleMenu: function () {
            $('#masthead').on('click', '.toggle-menu', function (event) {
                var ethis = $('.main-navigation .menu .menu-mobile');
                if (ethis.css('display') == 'block') {
                    ethis.slideUp('300');
                    $("#masthead").removeClass('mmenu-active');
                } else {
                    ethis.slideDown('300');
                    $("#masthead").addClass('mmenu-active');
                }
                $('.ham').toggleClass('exit');
            });
            $('#masthead .main-navigation ').on('click', '.menu-mobile a i', function (event) {
                event.preventDefault();
                var ethis = $(this),
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
            if ($('.main-navigation .menu > ul').length) {
                var ethis = $('.main-navigation .menu > ul'),
                    eparent = ethis.closest('.main-navigation'),
                    pointbreak = eparent.data('epointbreak'),
                    window_width = window.innerWidth;
                if (typeof pointbreak == 'undefined') {
                    pointbreak = 991;
                }
                if (pointbreak >= window_width) {
                    ethis.addClass('menu-mobile').removeClass('menu-desktop');
                    $('.main-navigation .toggle-menu').css('display', 'block');
                } else {
                    ethis.addClass('menu-desktop').removeClass('menu-mobile').css('display', '');
                    $('.main-navigation .toggle-menu').css('display', '');
                }
            }
        },
        menuArrow: function () {
            if ($('#masthead .main-navigation div.menu > ul').length) {
                $('#masthead .main-navigation div.menu > ul .sub-menu').parent('li').find('> a').append('<i class="fas fa-angle-down"></i>');
            }
        }
    },

    /* --------------- Search Reveal ---------------*/
    SAGA.searchReveal = function () {
        $('.search-overlay .search-icon').on('click', function() {
            $(this).parent().toggleClass('reveal-search');
            return false;
        });
    },

    /* --------------- Background Image ---------------*/
    SAGA.dataBackground = function () {
        $('.be-bg-image').each(function () {
            var src = $(this).find('img').attr('src');
            if(src){
                $(this).css('background-image', 'url(' + src + ')').find('img').hide();
            }
        });
    },

    /* --------------- Owl Carousel ---------------*/
    SAGA.bannerCarousel = function () {
        $( '.be-owl-banner-carousel' ).each( function () {
            var $this = $( this ),
                $items = 1,
                $margin = 0,
                $auto = false,
                $dots = false,
                $nav = true,
                $loop = true,
                $desktop_items = 1,
                $tab_items = 1,
                $small_tab_items = 1;

            if ( $this.attr('data-margin') ) {
                $margin = parseInt( $this.attr('data-margin') );
            }
            if ( $this.attr('data-dots') ) {
                $dots = true;
            }
            if ( $this.attr('data-nav') ) {
                $nav = false;
            }
            if ( $this.attr('data-loop') ) {
                $loop = false;
            }
            if ( $this.attr('data-auto') ) {
                $auto = true;
            }
            if ( $this.attr('data-desktop') ) {
                $desktop_items = parseInt( $this.attr('data-desktop') );
            }
            if ( $this.attr('data-tab') ) {
                $tab_items = parseInt( $this.attr('data-tab') );
            }
            if ( $this.attr('data-smalltab') ) {
                $small_tab_items = parseInt( $this.attr('data-smalltab') );
            }
            if ( $this.attr('data-items') ) {
                $items = parseInt( $this.attr('data-items') );
            }

            var owl_args = {
                loop              : $loop,
                margin            : $margin,
                items             : $items,
                nav               : $nav,
                dots              : $dots,
                navText           : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                autoplay          : $auto,
                autoHeight        : false,
                autoplayHoverPause: true,
                responsive        : {
                    0   : {
                        items  : 1
                    },
                    480 : {
                        items  : $small_tab_items
                    },
                    768 : {
                        items  : $tab_items
                    },
                    1170: {
                        items  : $desktop_items
                    }
                }
            };

            $this.owlCarousel( owl_args );
        });
    },

    /* --------------- Owl Slider  ---------------*/
    SAGA.owlSlider = function () {
        $( '.be-owl-carousel-slider' ).each( function () {
            var $this = $( this ),
                $items = 1,
                $auto = true,
                $dots = false,
                $nav = true,
                $loop = true,
                $desktop_items = 1,
                $tab_items = 1,
                $small_tab_items = 1;

            if ( $this.attr('data-dots') ) {
                $dots = true;
            }
            if ( $this.attr('data-nav') ) {
                $nav = false;
            }
            if ( $this.attr('data-loop') ) {
                $loop = false;
            }
            if ( $this.attr('data-auto') ) {
                $auto = false;
            }
            if ( $this.attr('data-desktop') ) {
                $desktop_items = parseInt( $this.attr('data-desktop') );
            }
            if ( $this.attr('data-tab') ) {
                $tab_items = parseInt( $this.attr('data-tab') );
            }
            if ( $this.attr('data-smalltab') ) {
                $small_tab_items = parseInt( $this.attr('data-smalltab') );
            }
            if ( $this.attr('data-items') ) {
                $items = parseInt( $this.attr('data-items') );
            }

            var owl_args = {
                loop              : $loop,
                margin            : 0,
                items             : $items,
                slideBy           : $items,
                nav               : $nav,
                dots              : $dots,
                navText           : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                autoplay          : $auto,
                autoHeight        : false,
                autoplayHoverPause: true,
                responsive        : {
                    0   : {
                        items  : 1,
                        slideBy: 1
                    },
                    480 : {
                        items  : $small_tab_items,
                        slideBy: $small_tab_items
                    },
                    768 : {
                        items  : $tab_items,
                        slideBy: $tab_items
                    },
                    1170: {
                        items  : $desktop_items,
                        slideBy: $desktop_items
                    }
                }
            };

            if ( $this.hasClass( 'be-trending-now-posts' ) ) {
                owl_args['animateOut'] = 'slideOutUp';
                owl_args['animateIn'] = 'slideInUp';
            }

            $this.owlCarousel( owl_args );
        });
    },

    /* --------------- Fix margin for top bar trending posts ---------------*/
        SAGA.trendingMargin = function () {
        var $trending_title = $( '.be-trending-posts .trending-now-title' );
        if ( $trending_title.length ) {
            var $trending_title_w = $trending_title.outerWidth() + 64;
            $('.be-trending-now-posts' ).css( 'margin-left', $trending_title_w + 'px' );
        }
    },

    /* --------------- Scroll To Top ---------------*/
    SAGA.scrollTop = {
        scrollClick : function () {
            $("#scroll-up").on("click", function () {
                $("html, body").animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        },
        onScroll : function () {
            if ($(window).scrollTop() > $(window).height() / 2) {
                $("#scroll-up").fadeIn(300);
            } else {
                $("#scroll-up").fadeOut(300);
            }
        }
    },

    $(document).ready(function () {
        SAGA.mobileMenu.init();
        SAGA.searchReveal();
        SAGA.dataBackground();
        SAGA.bannerCarousel();
        SAGA.owlSlider();
        SAGA.trendingMargin();
        SAGA.stickySidebar();
        SAGA.scrollTop.scrollClick();
    });
    $(window).load(function () {
        $('.preloader').fadeOut('slow');
    });
    $(window).scroll(function () {
        SAGA.stickyMenu();
        SAGA.scrollTop.onScroll();
    });
    $(window).resize(function () {
        SAGA.mobileMenu.menuMobile();
    });
}(jQuery);