( function( $ ) {

	'use strict';

	$.fn.scrollWatch = function( options ) {

		// Helper variables

			var
				settings = $.extend( {

					offset      : 0,
					placeholder : true,
					fixWidth    : true,

				}, options ),
				prototype = {

					setWidth : function( $this ) {
						if ( ! settings.fixWidth ) return;

						$this
							.css( 'width', $this.parent().outerWidth() + 'px' );
					},

					setHeightPlaceholder : function( $this ) {
						if ( ! settings.placeholder ) return;

						$this
							.parent()
								.css( 'height', $this.outerHeight() + 'px' );
					},

				},
				previousScrollTop = 0,
				currentScrollTop = 0,
				$window = $( window ),
				$body = $( 'body' );

				if(jQuery("body").hasClass("left") || jQuery("body").hasClass("right")){
					return false;
				}


		// Processing

			// Set the scroll direction body classes

				$window
					.on( 'load.scrollWatch scroll.scrollWatch', function() {

						var
							currentScrollTop = $window.scrollTop();

						// Window was scrolled?

							if ( currentScrollTop ) {
								$body
									.removeClass( 'scrolled-not' )
									.addClass( 'scrolled' );
							} else {
								$body
									.removeClass( 'scrolled' )
									.addClass( 'scrolled-not' );
							}

						// Scrolling direction

							if ( currentScrollTop < previousScrollTop ) {
								$body
									.removeClass( 'scrolled-down' )
									.addClass( 'scrolled-up' );
							} else if ( currentScrollTop > previousScrollTop ) {
								$body
									.removeClass( 'scrolled-up' )
									.addClass( 'scrolled-down' );
							}

							previousScrollTop = currentScrollTop;

					} );


		// Output

			return this.each( function( index ) {

				// Requirements check

					if ( 0 !== index ) return; // First element only.


				// Helper variables

					var
						$this         = $( this ),
						elementID     = ( $this.data( 'scroll-watch-id' ) || $this.attr( 'id' ) || $this.attr( 'class' ).split( ' ' )[0] ).trim().replace( /\s+/g, '-' ),
						elementTop    = $this.offset().top,
						elementBottom = elementTop + $this.outerHeight();


				// Processing

					// Set body class upon window scroll position in relation to stuck element

						$window
							.on( 'load.scrollWatch scroll.scrollWatch', function() {

								var
									currentScrollTop = $window.scrollTop();

								// Window is on top (no scroll)?

									if ( currentScrollTop === 0 || currentScrollTop < settings.offset ) {
										prototype.setHeightPlaceholder( $this );
									}

								// Window was scrolled to the element?

									if ( currentScrollTop > elementTop ) {
										$body
											.addClass( 'scrolled-to-' + elementID );
									} else {
										$body
											.removeClass( 'scrolled-to-' + elementID );
									}

									if ( settings.offset ) {
										if ( currentScrollTop > ( elementTop + settings.offset ) ) {
											$body
												.addClass( 'scrolled-to-' + elementID + '-offset' );
										} else {
											$body
												.removeClass( 'scrolled-to-' + elementID + '-offset' );
										}
									}

								// Window was scrolled past the element?

									if ( currentScrollTop > elementBottom ) {
										$body
											.addClass( 'scrolled-past-' + elementID );
									} else {
										$body
											.removeClass( 'scrolled-past-' + elementID );
									}

									if ( settings.offset ) {
										if ( currentScrollTop > ( elementBottom + settings.offset ) ) {
											$body
												.addClass( 'scrolled-past-' + elementID + '-offset' );
										} else {
											$body
												.removeClass( 'scrolled-past-' + elementID + '-offset' );
										}
									}

							} )
							.on( 'resize.scrollWatch orientationchange.scrollWatch', function() {

								// Reset variables

									elementTop    = $this.offset().top,
									elementBottom = elementTop + $this.outerHeight();

							} );

					// Fixed element modifications

						if ( settings.placeholder ) {

							// Wrap the element with placeholder and set its height

								if ( ! $this.parent().hasClass( 'scroll-watch-placeholder' ) ) {
									$this
										.wrap( '<div class="scroll-watch-placeholder ' + elementID + '-placeholder"></div>' );
								}

								prototype.setHeightPlaceholder( $this );

							// Set the element width and reset it on window resize

								prototype.setWidth( $this );

								$window
									.on( 'resize.scrollWatch orientationchange.scrollWatch', function() {

										// Reset stuck element width

											prototype.setWidth( $this );

										// Reset stuck element placeholder height

											$this
												.parent()
													.css( 'height', $this.outerHeight() + 'px' );

										// Reset variables

											elementTop    = $this.parent().offset().top,
											elementBottom = elementTop + $this.parent().outerHeight();

									} );

						}

			} );

	};

} )( jQuery );
