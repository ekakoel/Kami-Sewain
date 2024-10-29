$(document).ready(function () {
	"use strict"; // start of use strict

	/*==============================
	Header
	==============================*/
	$(window).on('scroll', function () {
		if ( $(window).scrollTop() > 0 ) {
			$('.header').addClass('header--active');
		} else {
			$('.header').removeClass('header--active');
		}
	});
	$(window).trigger('scroll');

	/*==============================
	Menu
	==============================*/
	$('.header-btn').on('click', function() {
		$(this).toggleClass('header-btn--active');
		$('.header-menu').toggleClass('header-menu--active');
	});

	/*==============================
	Multi level dropdowns
	==============================*/
	// $('ul.dropdown-menu [data-bs-toggle="dropdown"]').on('click', function(event) {
	// 	event.preventDefault();
	// 	event.stopPropagation();

	// 	$(this).siblings().toggleClass('show');
	// });

	// $(document).on('click', function (e) {
	// 	$('.dropdown-menu').removeClass('show');
	// });

	/*==============================
	Favorite
	==============================*/
	$('.offer-favorite').on('click', function() {
		$(this).toggleClass('offer-favorite--active');
	});

	$('.car-favorite').on('click', function() {
		$(this).toggleClass('car-favorite--active');
	});

	/*==============================
	Carousel
	==============================*/
	if ($('.main-carousel').length) {
		var elms = document.getElementsByClassName('main-carousel');

		for ( var i = 0; i < elms.length; i++ ) {
			new Splide(elms[ i ], {
				type: 'loop',
				perPage: 1,
				drag: true,
				pagination: false,
				autoWidth: true,
				autoHeight: false,
				speed: 800,
				gap: 30,
				focus: 'center',
				arrows: false,
				breakpoints: {
					767: {
						gap: 20,
						focus: 1,
						autoHeight: true,
						pagination: true,
						arrows: false,
					},
					1199: {
						focus: 1,
						autoHeight: true,
						pagination: true,
						arrows: false,
					},
				}
			}).mount();
		}
	}

	/*==============================
	Car carousel
	==============================*/
	if ($('.car-slider').length) {
		var elms = document.getElementsByClassName('car-slider');

		for ( var i = 0; i < elms.length; i++ ) {
			new Splide(elms[ i ], {
				type: 'loop',
				drag: true,
				pagination: true,
				speed: 800,
				gap: 10,
				arrows: false,
				focus: 0,
			}).mount();
		}
	}
	/*==============================
	Owl carousel
	==============================*/
	(function($) {

		"use strict";
	
		var fullHeight = function() {
	
			$('.js-fullheight').css('height', $(window).height());
			$(window).resize(function(){
				$('.js-fullheight').css('height', $(window).height());
			});
	
		};
		fullHeight();
	
		var carousel = function() {
			$('.featured-carousel').owlCarousel({
			loop:true,
			autoplay: true,
			margin:30,
			animateOut: 'fadeOut',
			animateIn: 'fadeIn',
			nav:true,
			dots: true,
			autoplayHoverPause: false,
			items: 1,
			navText : ["<span class='ion-ios-arrow-back'></span>","<span class='ion-ios-arrow-forward'></span>"],
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
	
		};
		carousel();
	
	})(jQuery);
	/*==============================
	Details
	==============================*/
	if ($('.details-slider').length) {
		var details = new Splide('.details-slider', {
				type: 'loop',
				drag: true,
				pagination: false,
				speed: 800,
				gap: 15,
				arrows: false,
				focus: 0,
		});

		var thumbnails = document.getElementsByClassName("thumbnail");
		var current;

		for (var i = 0; i < thumbnails.length; i++) {
			initThumbnail(thumbnails[i], i);
		}

		function initThumbnail(thumbnail, index) {
			thumbnail.addEventListener("click", function () {
				details.go(index);
			});
		}

		details.on("mounted move", function () {
			var thumbnail = thumbnails[details.index];

			if (thumbnail) {
				if (current) {
					current.classList.remove("is-active");
				}

				thumbnail.classList.add("is-active");
				current = thumbnail;
			}
		});

		details.mount();
	}

	/*==============================
	Partners
	==============================*/
	if ($('#partners-slider').length) {
		var partners = new Splide('#partners-slider', {
			type: 'loop',
			perPage: 6,
			drag: true,
			pagination: false,
			speed: 800,
			gap: 30,
			focus: 1,
			arrows: false,
			autoplay: true,
			interval: 4000,
			breakpoints: {
				575: {
					gap: 20,
					perPage: 2,
				},
				767: {
					gap: 20,
					perPage: 3,
				},
				991: {
					perPage: 4,
				},
				1199: {
					perPage: 5,
				},
			}
		});
		partners.mount();
	}

	/*==============================
	Modal
	==============================*/
	$('.open-video, .open-map').magnificPopup({
		disableOn: 0,
		fixedContentPos: true,
		type: 'iframe',
		preloader: false,
		removalDelay: 300,
		mainClass: 'mfp-fade',
		callbacks: {
			open: function() {
				if ($(window).width() > 1200) {
					$('.header').css('margin-left', "-" + getScrollBarWidth() + "px");
				}
			},
			close: function() {
				if ($(window).width() > 1200) {
					$('.header').css('margin-left', 0);
				}
			}
		}
	});

	$('.open-modal').magnificPopup({
		fixedContentPos: true,
		fixedBgPos: true,
		overflowY: 'auto',
		type: 'inline',
		preloader: false,
		focus: '#username',
		modal: false,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in',
		callbacks: {
			open: function() {
				if ($(window).width() > 1200) {
					$('.header').css('margin-left', "-" + getScrollBarWidth() + "px");
				}
			},
			close: function() {
				if ($(window).width() > 1200) {
					$('.header').css('margin-left', 0);
				}
			}
		}
	});

	$('.modal-close').on('click', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});

	function getScrollBarWidth () {
		var $outer = $('<div>').css({visibility: 'hidden', width: 100, overflow: 'scroll'}).appendTo('body'),
			widthWithScroll = $('<div>').css({width: '100%'}).appendTo($outer).outerWidth();
		$outer.remove();
		return 100 - widthWithScroll;
	};

	/*==============================
	Select
	==============================*/
	$('.main-select').select2({
		minimumResultsForSearch: Infinity
	});

	/*==============================
	Scrollbar
	==============================*/
	var Scrollbar = window.Scrollbar;

	if ($('.cart-table-scroll').length) {
		Scrollbar.init(document.querySelector('.cart-table-scroll'), {
			damping: 0.1,
			renderByPixels: true,
			alwaysShowTracks: true,
			continuousScrolling: true
		});
	}

	/*==============================
	Section bg
	==============================*/
	$('.main--sign').each(function(){
		if ($(this).attr('data-bg')){
			$(this).css({
				'background': 'url(' + $(this).data('bg') + ')',
				'background-position': 'center center',
				'background-repeat': 'no-repeat',
				'background-size': 'cover'
			});
		}
	});

});
jQuery(document).ready(function($){
	//if you change this breakpoint in the style.css file (or _layout.scss if you use SASS), don't forget to update this value as well
	var MqL = 992;
	//move nav element position according to window width
	moveNavigation();
	$(window).on('resize', function(){
		(!window.requestAnimationFrame) ? setTimeout(moveNavigation, 300) : window.requestAnimationFrame(moveNavigation);
	});

	//mobile - open lateral menu clicking on the menu icon
	$('.gn-nav-trigger').on('click', function(event){
		event.preventDefault();
		if( $('.gn-main-content').hasClass('nav-is-visible') ) {
			closeNav();
			$('.gn-overlay').removeClass('is-visible');
		} else {
			$(this).addClass('nav-is-visible');
			$('.gn-primary-nav').addClass('nav-is-visible');
			$('.gn-main-header').addClass('nav-is-visible');
			$('.gn-main-content').addClass('nav-is-visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
				$('body').addClass('overflow-hidden');
			});
			toggleSearch('close');
			$('.gn-overlay').addClass('is-visible');
		}
	});

	//open search form
	$('.gn-search-trigger').on('click', function(event){
		event.preventDefault();
		toggleSearch();
		closeNav();
	});

	//close lateral menu on mobile 
	$('.gn-overlay').on('swiperight', function(){
		if($('.gn-primary-nav').hasClass('nav-is-visible')) {
			closeNav();
			$('.gn-overlay').removeClass('is-visible');
		}
	});
	$('.nav-on-left .gn-overlay').on('swipeleft', function(){
		if($('.gn-primary-nav').hasClass('nav-is-visible')) {
			closeNav();
			$('.gn-overlay').removeClass('is-visible');
		}
	});
	$('.gn-overlay').on('click', function(){
		closeNav();
		toggleSearch('close')
		$('.gn-overlay').removeClass('is-visible');
	});


	//prevent default clicking on direct children of .gn-primary-nav 
	$('.gn-primary-nav').children('.has-children').children('a').on('click', function(event){
		event.preventDefault();
	});
	//open submenu
	$('.has-children').children('a').on('click', function(event){
		if( !checkWindowWidth() ) event.preventDefault();
		var selected = $(this);
		if( selected.next('ul').hasClass('is-hidden') ) {
			//desktop version only
			selected.addClass('selected').next('ul').removeClass('is-hidden').end().parent('.has-children').parent('ul').addClass('moves-out');
			selected.parent('.has-children').siblings('.has-children').children('ul').addClass('is-hidden').end().children('a').removeClass('selected');
			$('.gn-overlay').addClass('is-visible');
		} else {
			selected.removeClass('selected').next('ul').addClass('is-hidden').end().parent('.has-children').parent('ul').removeClass('moves-out');
			$('.gn-overlay').removeClass('is-visible');
		}
		toggleSearch('close');
	});

	//submenu items - go back link
	$('.go-back').on('click', function(){
		$(this).parent('ul').addClass('is-hidden').parent('.has-children').parent('ul').removeClass('moves-out');
	});

	function closeNav() {
		$('.gn-nav-trigger').removeClass('nav-is-visible');
		$('.gn-main-header').removeClass('nav-is-visible');
		$('.gn-primary-nav').removeClass('nav-is-visible');
		$('.has-children ul').addClass('is-hidden');
		$('.has-children a').removeClass('selected');
		$('.moves-out').removeClass('moves-out');
		$('.gn-main-content').removeClass('nav-is-visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			$('body').removeClass('overflow-hidden');
		});
	}

	function toggleSearch(type) {
		if(type=="close") {
			//close serach 
			$('.gn-search').removeClass('is-visible');
			$('.gn-search-trigger').removeClass('search-is-visible');
		} else {
			//toggle search visibility
			$('.gn-search').toggleClass('is-visible');
			$('.gn-search-trigger').toggleClass('search-is-visible');
			if($(window).width() > MqL && $('.gn-search').hasClass('is-visible')) $('.gn-search').find('input[type="search"]').focus();
			($('.gn-search').hasClass('is-visible')) ? $('.gn-overlay').addClass('is-visible') : $('.gn-overlay').removeClass('is-visible') ;
		}
	}

	function checkWindowWidth() {
		//check window width (scrollbar included)
		var e = window, 
            a = 'inner';
        if (!('innerWidth' in window )) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        if ( e[ a+'Width' ] >= MqL ) {
			return true;
		} else {
			return false;
		}
	}

	function moveNavigation(){
		var navigation = $('.gn-nav');
  		var desktop = checkWindowWidth();
        if ( desktop ) {
			navigation.detach();
			navigation.insertBefore('.gn-header-buttons');
		} else {
			navigation.detach();
			navigation.insertAfter('.gn-main-content');
		}
	}
});