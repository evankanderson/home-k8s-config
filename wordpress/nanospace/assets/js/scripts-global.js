/**
 * Theme frontend scripts
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 * 10) Basics
 * 20) Content
 * 30) Custom header
 * 40) Sticky header
 */

(function ($) {

	'use strict';


	/**
	 * 10) Basics
	 */

	var
		$breakpoints = ('undefined' !== typeof $nanospaceBreakpoints) ? ($nanospaceBreakpoints) : ({'xl': 1280}),
		$introMedia = $(document.getElementById('intro-media')),
		$compactLayoutProjects = $('.portfolio-style-compact .posts .type-wm_projects');


	/**
	 * Tell CSS that JS is enabled...
	 */

	$('.no-js')
		.removeClass('no-js');

	/**
	 * Fixing Recent Comments widget multiple appearances
	 */

	$('.widget_recent_comments ul')
		.attr('id', '');

	/**
	 * Responsive videos
	 */

	if ($().fitVids) {

		$(document.getElementById('page'))
			.fitVids();

	} // /fitVids

	/**
	 * 20) Content
	 */

	  /**
	 * Compact projects layout focus
	 */

	$compactLayoutProjects
		.on('focus.aria mouseenter.aria', 'a', function (e) {

			// Processing

			$(this)
				.closest('.type-wm_projects')
				.addClass('focus');

		})
		.on('blur.aria mouseleave.aria', 'a', function (e) {

			// Processing

			$(this)
				.closest('.type-wm_projects')
				.removeClass('focus');

		});


	/**
	 * 30) Custom header
	 */

	if ($introMedia.length) {
		$introMedia
			.parent('.intro-special')
			.addClass('intro-special-has-media');
	}

	$(document)
		.on('wp-custom-header-video-loaded', function () {

			// Processing

			$introMedia
				.addClass('has-header-video');

		});

	/**
	 * 40) Sticky header
	 */

	if ($().scrollWatch && $('body').hasClass('has-sticky-header')) {

		$(document.getElementById('masthead'))
			.scrollWatch({
				offset: 50,
			});

	} // /scrollWatch

	/* SCROLLER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - */

	// SCROLL TO TOP
	var $window = $(window);
	var $to_top = jQuery('.back-to-top');
	$window.on('scroll', function () {
		if ($to_top.length > 0) {
			if (jQuery(window).scrollTop() > 80) $to_top.stop().animate({bottom: 17, opacity: 1}, 700);
			else $to_top.stop().animate({bottom: -17, opacity: 0}, 700);
		}
		if (jQuery(window).scrollTop() > (jQuery(window).height() / 8)) {
			jQuery('body').addClass('site-scrolled');
		} else {
			jQuery('body').removeClass('site-scrolled');
		}
	});
	$to_top.click(function (e) {
		e.preventDefault();
		jQuery('html, body').animate({scrollTop: 0}, 800);
		return false;
	});


})(jQuery);
