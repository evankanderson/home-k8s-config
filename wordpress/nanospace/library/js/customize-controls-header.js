/**
 * Theme Customizer custom controls handlers
 */
(function( exports, $ ) {
	'use strict';

	var $window = $( window ),
		$document = $( document ),
		$body = $( 'body' );

	if ( undefined == getUrlParameter ) {
		var getUrlParameter = function( name, url ) {
			url = decodeURI( url );
			name = name.replace( /[\[]/, '\\[' ).replace( /[\]]/, '\\]' );

			var regex = new RegExp( '[\\?&]' + name + '=([^&#]*)' ),
				results = regex.exec( url );

			return results === null ? '' : decodeURIComponent( results[1].replace( /\+/g, ' ' ) );
		};
	}

	/**
	 * Improve input type number behavior for better UX
	 */
		// Trigger change on all number input fields when "enter" key is pressed.
	var inputNumberValidation = function( e ) {
			var input = e.target;

			if ( '' === input.value ) {
				$( input ).trigger( 'change' );
				return;
			}

			if ( '' !== input.step ) {
				// Validate step / increment value.
				var split = input.step.toString().split( '.' ),
					decimalCount = 0;

				// Detect decimal number.
				if ( undefined !== split[1] ) {
					decimalCount = split[1].length;
				}

				// Check if value mod step is not 0, then round the value to nearest valid value.
				if ( ! Number.isInteger( Number( input.value ) / Number( input.step ) ) ) {
					input.value = Math.round( Number( input.value ) / Number( input.step ), decimalCount ) * Number( input.step );
				}
			}

			// Validate maximum value.
			if ( '' !== input.max ) {
				input.value = Math.min( Number( input.value ), Number( input.max ) );
			}

			// Validate minimum value.
			if ( '' !== input.min ) {
				input.value = Math.max( Number( input.value ), Number( input.min ) );
			}

			$( input ).trigger( 'change' );
		};

	$( '#customize-controls' ).on( 'blur', 'input[type="number"]', inputNumberValidation );
	$( '#customize-controls' ).on( 'keyup', 'input[type="number"]', function( e ) {
		if ( 13 == e.which ) {
			inputNumberValidation( e );
		}
	});
	// Disable mousewheel scroll when input is in focus.
	$( '#customize-controls' ).on( 'focus', 'input[type="number"]', function( e ) {
		$( this ).on( 'mousewheel.disableScroll', function ( e ) { e.preventDefault(); });
	});
	$( '#customize-controls' ).on( 'blur', 'input[type="number"]', function( e ) {
		$( this ).off( 'mousewheel.disableScroll' );
	});

	/**
	 * Contentless sections like: nanospace-section-spacer, nanospace-section-pro-teaser, nanospace-section-pro-link
	 */
	wp.customize.sectionConstructor['nanospace-section-pro-teaser'] =
		wp.customize.sectionConstructor['nanospace-section-pro-link'] =
			wp.customize.sectionConstructor['nanospace-section-spacer'] = wp.customize.Section.extend({
				// No events for this type of section.
				attachEvents: function () {},
				// Always make the section active.
				isContextuallyActive: function () {
					return true;
				}
			});

	/**
	 * nanospace base control
	 *
	 * ref:
	 * - https://github.com/aristath/kirki/blob/develop/controls/js/src/dynamic-control.js
	 * - https://github.com/xwp/wp-customize-posts/blob/develop/js/customize-dynamic-control.js
	 */
	wp.customize.NanospaceControl = wp.customize.Control.extend({
		initialize: function( id, options ) {
			var control = this,
				args    = options || {};

			args.params = args.params || {};
			if ( ! args.params.type ) {
				args.params.type = 'nanospace-base';
			}
			if ( ! args.params.content ) {
				args.params.content = jQuery( '<li></li>' );
				args.params.content.attr( 'id', 'customize-control-' + id.replace( /]/g, '' ).replace( /\[/g, '-' ) );
				args.params.content.attr( 'class', 'customize-control customize-control-' + args.params.type );
			}

			control.propertyElements = [];
			wp.customize.Control.prototype.initialize.call( control, id, args );
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting(s).
		 *
		 * This is copied from wp.customize.Control.prototype.initialize(). It
		 * should be changed in Core to be applied once the control is embedded.
		 *
		 * @private
		 * @returns {null}
		 */
		_setUpSettingRootLinks: function() {
			var control = this,
				nodes   = control.container.find( '[data-customize-setting-link]' );

			nodes.each(function() {
				var node = jQuery( this );

				wp.customize( node.data( 'customizeSettingLink' ), function( setting ) {
					var element = new wp.customize.Element( node );
					control.elements.push( element );
					element.sync( setting );
					element.set( setting() );
				});
			});
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting properties.
		 *
		 * @private
		 * @returns {null}
		 */
		_setUpSettingPropertyLinks: function() {
			var control = this,
				nodes;

			if ( ! control.setting ) {
				return;
			}

			nodes = control.container.find( '[data-customize-setting-property-link]' );

			nodes.each(function() {
				var node = jQuery( this ),
					element,
					propertyName = node.data( 'customizeSettingPropertyLink' );

				element = new wp.customize.Element( node );
				control.propertyElements.push( element );
				element.set( control.setting()[ propertyName ] );

				element.bind(function( newPropertyValue ) {
					var newSetting = control.setting();
					if ( newPropertyValue === newSetting[ propertyName ] ) {
						return;
					}
					newSetting = _.clone( newSetting );
					newSetting[ propertyName ] = newPropertyValue;
					control.setting.set( newSetting );
				});
				control.setting.bind(function( newValue ) {
					if ( newValue[ propertyName ] !== element.get() ) {
						element.set( newValue[ propertyName ] );
					}
				});
			});
		},

		/**
		 * @inheritdoc
		 */
		ready: function() {
			var control = this;

			control._setUpSettingRootLinks();
			control._setUpSettingPropertyLinks();

			wp.customize.Control.prototype.ready.call( control );

			control.deferred.embedded.done(function() {});
		},

		/**
		 * Embed the control in the document.
		 *
		 * Override the embed() method to do nothing,
		 * so that the control isn't embedded on load,
		 * unless the containing section is already expanded.
		 *
		 * @returns {null}
		 */
		embed: function() {
			var control   = this,
				sectionId = control.section();

			if ( ! sectionId ) {
				return;
			}

			wp.customize.section( sectionId, function( section ) {
				if ( section.expanded() || wp.customize.settings.autofocus.control === control.id ) {
					control.actuallyEmbed();
				} else {
					section.expanded.bind(function( expanded ) {
						if ( expanded ) {
							control.actuallyEmbed();
						}
					});
				}
			});
		},

		/**
		 * Deferred embedding of control when actually
		 *
		 * This function is called in Section.onChangeExpanded() so the control
		 * will only get embedded when the Section is first expanded.
		 *
		 * @returns {null}
		 */
		actuallyEmbed: function() {
			var control = this;
			if ( 'resolved' === control.deferred.embedded.state() ) {
				return;
			}
			control.renderContent();
			control.deferred.embedded.resolve(); // This triggers control.ready().

			// Fire event after control is initialized.
			control.container.trigger( 'init' );
		},

		/**
		 * This is not working with autofocus.
		 *
		 * @param {object} [args] Args.
		 * @returns {null}
		 */
		focus: function( args ) {
			var control = this;
			control.actuallyEmbed();
			wp.customize.Control.prototype.focus.call( control, args );
		},
	});
	wp.customize.controlConstructor['nanospace-base'] = wp.customize.NanospaceControl;

	/**
	 * nanospace color control
	 */
	wp.customize.controlConstructor['nanospace-color'] = wp.customize.NanospaceControl.extend({
		ready: function() {
			var control = this,
				$picker = control.container.find( '.color-picker' );

			$picker.alphaColorPicker({
				change: function() {
					control.setting.set( $picker.wpColorPicker( 'color' ) );
				},
				clear: function() {
					control.setting.set( '' );
				},
			});
		}
	});

	/**
	 * nanospace shadow control
	 */
	wp.customize.controlConstructor['nanospace-shadow'] = wp.customize.NanospaceControl.extend({
		ready: function() {
			var control = this,
				$inputs = control.container.find( '.nanospace-shadow-input' ),
				$value = control.container.find( '.nanospace-shadow-value' );

			control.updateValue = function( e ) {
				var values = $inputs.map(function() {
					return $( this ).hasClass( 'color-picker-hex' ) ? ( '' === $( this ).wpColorPicker( 'color' ) ? 'rgba(0,0,0,0)' : $( this ).wpColorPicker( 'color' ) ) : ( '' === this.value ? '0' : this.value.toString() + 'px' );
				}).get();

				$value.val( values.join( ' ' ) ).trigger( 'change' );
			};

			control.container.find( '.nanospace-shadow-color .color-picker-hex' ).alphaColorPicker({
				change: control.updateValue,
				clear: control.updateValue,
			});

			control.container.on( 'change blur', '.nanospace-shadow-input', control.updateValue );
		}
	});

	/**
	 * nanospace dimension control
	 */
	wp.customize.controlConstructor['nanospace-dimension'] = wp.customize.NanospaceControl.extend({
		ready: function() {
			var control = this;

			control.container.find( '.nanospace-dimension-fieldset' ).each(function( i, el ) {
				var $el = $( el ),
					$unit = $el.find( '.nanospace-dimension-unit' ),
					$input = $el.find( '.nanospace-dimension-input' ),
					$value = $el.find( '.nanospace-dimension-value' );

				$unit.on( 'change', function( e ) {
					var $option = $unit.find( 'option[value="' + this.value + '"]' );

					$input.attr( 'min', $option.attr( 'data-min' ) );
					$input.attr( 'max', $option.attr( 'data-max' ) );
					$input.attr( 'step', $option.attr( 'data-step' ) );

					$input.val( '' ).trigger( 'change' );
				});

				$input.on( 'change blur', function( e ) {
					var value = '' === this.value ? '' : this.value.toString() + $unit.val().toString();

					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});

	/**
	 * nanospace slider control
	 */
	wp.customize.controlConstructor['nanospace-slider'] = wp.customize.NanospaceControl.extend({
		ready: function() {
			var control = this;

			control.container.find( '.nanospace-slider-fieldset' ).each(function( i, el ) {
				var $el = $( el ),
					$unit = $el.find( '.nanospace-slider-unit' ),
					$input = $el.find( '.nanospace-slider-input' ),
					$slider = $el.find( '.nanospace-slider-ui' ),
					$reset = $el.find( '.nanospace-slider-reset' ),
					$value = $el.find( '.nanospace-slider-value' );

				$slider.slider({
					value: $input.val(),
					min: +$input.attr( 'min' ),
					max: +$input.attr( 'max' ),
					step: +$input.attr( 'step' ),
					slide: function( e, ui ) {
						$input.val( ui.value ).trigger( 'change' );
					},
				});

				$reset.on( 'click', function( e ) {
					var resetNumber = $( this ).attr( 'data-number' ),
						resetUnit = $( this ).attr( 'data-unit' );

					$unit.val( resetUnit );
					$input.val( resetNumber ).trigger( 'change' );
					$slider.slider( 'value', resetNumber );
				});

				$unit.on( 'change', function( e ) {
					var $option = $unit.find( 'option[value="' + this.value + '"]' );

					$input.attr( 'min', $option.attr( 'data-min' ) );
					$input.attr( 'max', $option.attr( 'data-max' ) );
					$input.attr( 'step', $option.attr( 'data-step' ) );

					$slider.slider( 'option', {
						min: +$input.attr( 'min' ),
						max: +$input.attr( 'max' ),
						step: +$input.attr( 'step' ),
					});

					$input.val( '' ).trigger( 'change' );
				});

				$input.on( 'change blur', function( e ) {
					$slider.slider( 'value', this.value );

					var value = '' === this.value ? '' : this.value.toString() + $unit.val().toString();

					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});

	/**
	 * nanospace dimensions control
	 */
	wp.customize.controlConstructor['nanospace-dimensions'] = wp.customize.NanospaceControl.extend({
		ready: function() {
			var control = this;

			control.container.find( '.nanospace-dimensions-fieldset' ).each(function( i, el ) {
				var $el = $( el ),
					$unit = $el.find( '.nanospace-dimensions-unit' ),
					$link = $el.find( '.nanospace-dimensions-link' ),
					$unlink = $el.find( '.nanospace-dimensions-unlink' ),
					$inputs = $el.find( '.nanospace-dimensions-input' ),
					$value = $el.find( '.nanospace-dimensions-value' );

				$unit.on( 'change', function( e ) {
					var $option = $unit.find( 'option[value="' + this.value + '"]' );

					$inputs.attr( 'min', $option.attr( 'data-min' ) );
					$inputs.attr( 'max', $option.attr( 'data-max' ) );
					$inputs.attr( 'step', $option.attr( 'data-step' ) );

					$inputs.val( '' ).trigger( 'change' );
				});

				$link.on( 'click', function( e ) {
					e.preventDefault();

					$el.attr( 'data-linked', 'true' );
					$inputs.val( $inputs.first().val() ).trigger( 'change' );
					$inputs.first().focus();
				});

				$unlink.on( 'click', function( e ) {
					e.preventDefault();

					$el.attr( 'data-linked', 'false' );
					$inputs.first().focus();
				});

				$inputs.on( 'keyup mouseup', function( e ) {
					if ( 'true' == $el.attr( 'data-linked' ) ) {
						$inputs.not( this ).val( this.value ).trigger( 'change' );
					}
				});

				$inputs.on( 'change blur', function( e ) {
					var values = [],
						unit = $unit.val().toString(),
						isEmpty = true,
						value;

					$inputs.each(function() {
						if ( '' === this.value ) {
							values.push( '0' + unit );
						} else {
							values.push( this.value.toString() + unit );
							isEmpty = false;
						}
					});

					if ( isEmpty ) {
						value = '   ';
					} else {
						value = values.join( ' ' );
					}

					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});

	/**
	 * nanospace typography control
	 */
	wp.customize.controlConstructor['nanospace-typography'] = wp.customize.NanospaceControl.extend({
		ready: function() {
			var control = this;

			control.container.find( '.nanospace-typography-size' ).each(function( i, el ) {
				var $el = $( el ),
					$unit = $el.find( '.nanospace-typography-size-unit' ),
					$input = $el.find( '.nanospace-typography-size-input' ),
					$value = $el.find( '.nanospace-typography-size-value' );

				var setNumberAttrs = function( unit ) {
					var $option = $unit.find( 'option[value="' + unit + '"]' );

					$input.attr( 'min', $option.attr( 'data-min' ) );
					$input.attr( 'max', $option.attr( 'data-max' ) );
					$input.attr( 'step', $option.attr( 'data-step' ) );
				};

				$unit.on( 'change', function( e ) {
					setNumberAttrs( this.value );

					$input.val( '' ).trigger( 'change' );
				});
				setNumberAttrs( $unit.val() );

				$input.on( 'change blur', function( e ) {
					var value = '' === this.value ? '' : this.value.toString() + $unit.val().toString();

					$value.val( value ).trigger( 'change' );
				});
			});
		}
	});

	/**
	 * nanospace multiple checkboxes control
	 */
	wp.customize.controlConstructor['nanospace-multicheck'] = wp.customize.NanospaceControl.extend({
		ready: function() {
			var control = this,
				$checkboxes = control.container.find( '.nanospace-multicheck-input' );

			$checkboxes.on( 'change', function( e ) {
				var value = [];

				$checkboxes.each(function() {
					if ( this.checked ) {
						value.push( this.value );
					}
				});

				control.setting.set( value );
			});
		}
	});

	/**
	 * nanospace builder control
	 */
	wp.customize.controlConstructor['nanospace-builder'] = wp.customize.NanospaceControl.extend({
		ready: function() {
			var control = this;

			control.builder = control.container.find( '.nanospace-builder' );
			control.builderLocations = control.builder.find( '.nanospace-builder-location' );
			control.builderInactive = control.builder.find( '.nanospace-builder-inactive' );

			// Core function to update setting's value.
			control.updateValue = function( location ) {
				if ( '__inactive' === location ) return;

				var $locationPanel = control.builderLocations.filter( '[data-location="' + location + '"]' ),
					$elements = $locationPanel.find( '.nanospace-builder-element' ),
					value = [];

				$elements.each(function() {
					value.push( $( this ).attr( 'data-value' ) );
				});

				if ( null !== control.settings ) {
					control.settings[ location ].set( value );
				} else {
					control.setting.set( value );
				}
			};

			// Trigger click event on all span with tabindex using keyboard.
			control.container.on( 'keyup', '[tabindex]', function( e ) {
				if ( 13 == e.which || 32 == e.which ) {
					$( this ).trigger( 'click' );
				}
			});

			// Expand inactive panel.
			control.container.on( 'click', '.nanospace-builder-element-add', function( e ) {
				e.preventDefault();

				var $this = $( this ),
					$location = $this.closest( '.nanospace-builder-location' ),
					$wrapper = $this.closest( '.nanospace-builder-locations' );

				if ( control.builderInactive.prev().get(0) == $location.get(0) && control.builderInactive.hasClass( 'show' ) ) {
					control.builderInactive.removeClass( 'show' ).appendTo( $wrapper );
				} else {
					control.builderInactive.addClass( 'show' ).insertAfter( $location );
				}
			});

			// Add element to nearby location.
			control.container.on( 'click', '.nanospace-builder-inactive .nanospace-builder-element', function( e ) {
				e.preventDefault();

				if ( control.builderInactive.hasClass( 'show' ) ) {
					var $element = $( this ),
						$location = control.builderInactive.prev( '.nanospace-builder-location' );

					$element.appendTo( $location.children( '.nanospace-builder-sortable-panel' ) );
					control.builderInactive.removeClass( 'show' );

					control.updateValue( $location.attr( 'data-location' ) );
				}
			});

			// Delete element from location.
			control.container.on( 'click', '.nanospace-builder-element-delete', function( e ) {
				e.preventDefault();

				var $element = $( this ).parent( '.nanospace-builder-element' ),
					$location = $element.closest( '.nanospace-builder-location' );

				$element.prependTo( control.builderInactive.children( '.nanospace-builder-sortable-panel' ) );
				control.updateValue( $location.attr( 'data-location' ) );
			});

			// Initialize sortable.
			control.container.find( '.nanospace-builder-sortable-panel' ).sortable({
				items: '.nanospace-builder-element:not(.nanospace-builder-element-disabled)',
				connectWith: '.nanospace-builder-sortable-panel[data-connect="' + control.builder.attr( 'data-name' ) + '"]',
				containment: control.container,
				update: function( e, ui ) {
					control.updateValue( $( e.target ).parent().attr( 'data-location' ) );
				},

				receive: function( e, ui ) {
					var limitations = $( ui.item ).attr( 'data-limitations' ).split( ',' );

					if ( 0 <= limitations.indexOf( $( this ).parent().attr( 'data-location' ) ) ) {
						$( ui.sender ).sortable( 'cancel' );
					}
				},
				start: function( e, ui ) {
					var limitations = $( ui.item ).attr( 'data-limitations' ).split( ',' );

					for ( var i = 0; i < limitations.length; ++i ) {
						var $target = control.builderLocations.filter( '[data-location="' + limitations[ i ] + '"]' );
						if ( undefined === $target ) continue;

						$target.addClass( 'disabled' );
					}
				},
				stop: function( e, ui ) {
					control.builderLocations.removeClass( 'disabled' );
					control.builderInactive.removeClass( 'disabled' );
				}
			})
				.disableSelection();
		}
	});

	/**
	 * API on ready event handlers
	 *
	 * All handlers need to be inside the 'ready' state.
	 */
	wp.customize.bind( 'ready', function() {

		/**
		 * nanospace responsive control
		 */

		// Set handler when custom responsive toggle is clicked.
		$( '#customize-controls' ).on( 'click', '.nanospace-responsive-switcher-button', function( e ) {
			e.preventDefault();

			wp.customize.previewedDevice.set( $( this ).attr( 'data-device' ) );
			var currentVal = wp.customize.control('nanospace_section_header_layout_select').settings.default();

			if($( this ).attr( 'data-device' ) == 'vertical') {
				if ('right-header' == currentVal) {
					$('#sub-accordion-section-nanospace_section_header_builder').css({
						"position": "fixed !important", "top": "0", "bottom": "0", "left": "300px",
						"right": "0", "display": "block", "width": "auto", "height": "auto", "padding": "20px",
						"max-height": "100%", "margin": "0 0 0 -1px", "background-color": "#eee",
						"border-top": "1px solid #ddd", "border-left": "1px solid #ddd", "transition": "all 0.2s",
						"-webkit-backface-visibility": "hidden", "backface-visibility": "hidden", "max-width": "25%"
					});
				} else if ('left-header' == currentVal) {
					$('#sub-accordion-section-nanospace_section_header_builder').css({
						"position": "fixed !important", "top": "0", "bottom": "0", "left": "auto",
						"right": "0", "display": "block", "width": "auto", "height": "auto", "padding": "20px",
						"max-height": "100%", "margin": "0 0 0 -1px", "background-color": "#eee",
						"border-top": "1px solid #ddd", "border-left": "1px solid #ddd", "transition": "all 0.2s",
						"-webkit-backface-visibility": "hidden", "backface-visibility": "hidden", "max-width": "25%"
					});
				}else {
					$('#sub-accordion-section-nanospace_section_header_builder').removeAttr("style");
				}
			}else {
				$('#sub-accordion-section-nanospace_section_header_builder').removeAttr("style");
			}

		});

		// Set all custom responsive toggles and fieldsets.
		var setCustomResponsiveElementsDisplay = function() {

			//set vertical header style
			var headerPenal = $('#sub-accordion-section-nanospace_section_header_builder');
			var currentVal = wp.customize.control('nanospace_section_header_layout_select').settings.default();

			var device = wp.customize.previewedDevice.get();

			if('right-header' == currentVal || 'left-header' == currentVal){
				jQuery('[data-device="vertical"]').css('display','inline');
				jQuery('[data-device="desktop"]').css('display','none');
				if(device != 'tablet'){
					jQuery('[data-device="vertical"]').click();
				}
			}else{
				jQuery('[data-device="desktop"]').css('display','inline');
				jQuery('[data-device="vertical"]').css('display','none');
				if(device != 'tablet'){
					jQuery('[data-device="desktop"]').click();
				}
			}

			if ('right-header' == currentVal && 'tablet' != device) {
				headerPenal.css({
					"position": "fixed !important",
					"top": "0",
					"bottom": "0",
					"left": "300px",
					"right": "0",
					"display": "block",
					"width": "auto",
					"height": "auto",
					"padding": "20px",
					"max-height": "100%",
					"margin": "0 0 0 -1px",
					"background-color": "#eee",
					"border-top": "1px solid #ddd",
					"border-left": "1px solid #ddd",
					"transition": "all 0.2s",
					"-webkit-backface-visibility": "hidden",
					"backface-visibility": "hidden",
					"max-width": "25%"
				});
				wp.customize.previewer.refresh();
			} else if ('left-header' == currentVal  && 'tablet' != device) {
				headerPenal.css({
					"position": "fixed !important",
					"top": "0",
					"bottom": "0",
					"left": "auto",
					"right": "0",
					"display": "block",
					"width": "auto",
					"height": "auto",
					"padding": "20px",
					"max-height": "100%",
					"margin": "0 0 0 -1px",
					"background-color": "#eee",
					"border-top": "1px solid #ddd",
					"border-left": "1px solid #ddd",
					"transition": "all 0.2s",
					"-webkit-backface-visibility": "hidden",
					"backface-visibility": "hidden",
					"max-width": "25%"
				});
				wp.customize.previewer.refresh();
			} else {
				headerPenal.removeAttr("style");
				wp.customize.previewer.refresh();
			}

			wp.customize( 'nanospace_section_header_layout_select', function( value ) {
				value.bind( function( newval ) {

					var device = wp.customize.previewedDevice.get();

					if('right-header' == newval || 'left-header' == newval){
						jQuery('[data-device="vertical"]').css('display','inline');
						jQuery('[data-device="desktop"]').css('display','none');
						if('tablet' != device){
							jQuery('[data-device="vertical"]').click();
						}
					}else{
						jQuery('[data-device="desktop"]').css('display','inline');
						jQuery('[data-device="vertical"]').css('display','none');
						if('tablet' != device){
							jQuery('[data-device="desktop"]').click();
						}
					}

					if (newval == 'right-header' && 'tablet' != device) {
						headerPenal.css({
							"position": "fixed !important",
							"top": "0",
							"bottom": "0",
							"left": "300px",
							"right": "0",
							"display": "block",
							"width": "auto",
							"height": "auto",
							"padding": "20px",
							"max-height": "100%",
							"margin": "0 0 0 -1px",
							"background-color": "#eee",
							"border-top": "1px solid #ddd",
							"border-left": "1px solid #ddd",
							"transition": "all 0.2s",
							"-webkit-backface-visibility": "hidden",
							"backface-visibility": "hidden",
							"max-width": "25%"
						});
						wp.customize.previewer.refresh();
					} else if (newval == 'left-header' && 'tablet' != device) {
						headerPenal.css({
							"position": "fixed !important",
							"top": "0",
							"bottom": "0",
							"left": "auto",
							"right": "0",
							"display": "block",
							"width": "auto",
							"height": "auto",
							"padding": "20px",
							"max-height": "100%",
							"margin": "0 0 0 -1px",
							"background-color": "#eee",
							"border-top": "1px solid #ddd",
							"border-left": "1px solid #ddd",
							"transition": "all 0.2s",
							"-webkit-backface-visibility": "hidden",
							"backface-visibility": "hidden",
							"max-width": "25%"
						});
						wp.customize.previewer.refresh();
					} else {
						headerPenal.removeAttr("style");
						wp.customize.previewer.refresh();
					}

				} );

			} );
var device = wp.customize.previewedDevice.get(),
				$buttons = $( 'span.nanospace-responsive-switcher-button' ),
				$tabs = $( '.nanospace-responsive-switcher-button.nav-tab' ),
				$panels = $( '.nanospace-responsive-fieldset' );

				$panels.removeClass( 'active' ).filter( '.preview-' + device ).addClass( 'active' );
				$buttons.removeClass( 'active' ).filter( '.preview-' + device ).addClass( 'active' );
				$tabs.removeClass( 'nav-tab-active' ).filter( '.preview-' + device ).addClass( 'nav-tab-active' );

		};

		// Refresh all responsive elements when previewedDevice is changed.
		wp.customize.previewedDevice.bind( setCustomResponsiveElementsDisplay );

		// Refresh all responsive elements when any section is expanded.
		// This is required to set responsive elements on newly added controls inside the section.
		wp.customize.section.each(function ( section ) {
			section.expanded.bind( setCustomResponsiveElementsDisplay );
		});

		/**
		 * Event handler for links to set preview URL.
		 */
		$( '#customize-controls' ).on( 'click', '.nanospace-customize-set-preview-url', function( e ) {
			e.preventDefault();

			var $this = $( this ),
				href = $this.attr( 'href' ),
				url = getUrlParameter( 'url', href );

			if ( url !== wp.customize.previewer.previewUrl() ) {
				wp.customize.previewer.previewUrl( url );
			}
		});

		/**
		 * Event handler for links to jump to a certain control / section.
		 */
		$( '#customize-controls' ).on( 'click', '.nanospace-customize-goto-control', function( e ) {
			e.preventDefault();

			var $this = $( this ),
				href = $this.attr( 'href' ),
				targetControl = getUrlParameter( 'autofocus[control]', href ),
				targetSection = getUrlParameter( 'autofocus[section]', href ),
				targetPanel= getUrlParameter( 'autofocus[panel]', href );

			if ( targetControl ) {
				wp.customize.control( targetControl ).focus();
			}
			else if ( targetSection ) {
				wp.customize.section( targetSection ).focus();
			}
			else if ( targetPanel ) {
				wp.customize.panel( targetPanel ).focus();
			}
		});

		if ( nanospaceCustomizerControlsData && nanospaceCustomizerControlsData.contexts ) {
			/**
			 * Active callback script (JS version)
			 * ref: https://make.xwp.co/2016/07/24/dependently-contextual-customizer-controls/
			 */
			_.each( nanospaceCustomizerControlsData.contexts, function( rules, key ) {
				var getSetting = function( settingName ) {
					// Get the dependent setting.
					switch ( settingName ) {
						case '__device':
							return wp.customize.previewedDevice;
							break;

						default:
							return wp.customize( settingName );
							break;
					}
				};

				var initContext = function( element ) {
					// Main function returning the conditional value
					var isDisplayed = function() {
						var displayed = false,
							relation = rules['relation'];

						// Fallback invalid relation type to "AND".
						// Assign default displayed to true for "AND" relation type.
						if ( 'OR' !== relation ) {
							relation = 'AND';
							displayed = true;
						}

						// Each rule iteration
						_.each( rules, function( rule, i ) {
							// Skip "relation" property.
							if ( 'relation' == i ) return;

							// If in "AND" relation and "displayed" already flagged as false, skip the rest rules.
							if ( 'AND' == relation && false == displayed ) return;

							// Skip if no setting propery found.
							if ( undefined === rule['setting'] ) return;

							var result = false,
								setting = getSetting( rule['setting'] );

							// Only process the rule if dependent setting is found.
							// Otherwise leave the result to "false".
							if ( undefined !== setting ) {
								var operator = rule['operator'],
									comparedValue = rule['value'],
									currentValue = setting.get();

								if ( undefined == operator || '=' == operator ) {
									operator = '==';
								}

								switch ( operator ) {
									case '>':
										result = currentValue > comparedValue;
										break;

									case '<':
										result = currentValue < comparedValue;
										break;

									case '>=':
										result = currentValue >= comparedValue;
										break;

									case '<=':
										result = currentValue <= comparedValue;
										break;

									case 'in':
										result = 0 <= comparedValue.indexOf( currentValue );
										break;

									case 'not_in':
										result = 0 < comparedValue.indexOf( currentValue );
										break;

									case 'contain':
										result = 0 <= currentValue.indexOf( comparedValue );
										break;

									case 'not_contain':
										result = 0 < currentValue.indexOf( comparedValue );
										break;

									case '!=':
										result = comparedValue != currentValue;
										break;

									case 'empty':
										result = 0 == currentValue.length;
										break;

									case '!empty':
										result = 0 < currentValue.length;
										break;

									default:
										result = comparedValue == currentValue;
										break;
								}
							}

							// Combine to the final result.
							switch ( relation ) {
								case 'OR':
									displayed = displayed || result;
									break;

								default:
									displayed = displayed && result;
									break;
							}
						});

						return displayed;
					};

					// Wrapper function for binding purpose
					var setActiveState = function() {
						element.active.set( isDisplayed() );
					};

					// Setting changes bind
					_.each( rules, function( rule, i ) {
						// Skip "relation" property.
						if ( 'relation' == i ) return;

						var setting = getSetting( rule['setting'] );

						if ( undefined !== setting ) {
							// Bind the setting for future use.
							setting.bind( setActiveState );
						}
					});

					// Initial run
					element.active.validate = isDisplayed;
					setActiveState();
				};

				if ( 0 == key.indexOf( 'nanospace_section' ) ) {
					wp.customize.section( key, initContext );
				} else {
					wp.customize.control( key, initContext );
				}
			});
		}

		/**
		 * Resize Preview Frame when show / hide Builder.
		 */
		var resizePreviewer = function() {
			var $section = $( '.control-section.nanospace-builder-active' );

			if ( 1324 <= window.innerWidth && $body.hasClass( 'nanospace-has-builder-active' ) && 0 < $section.length && ! $section.hasClass( 'nanospace-hide' ) ) {
				//wp.customize.previewer.container.css({ "bottom" : "" });
				wp.customize.previewer.container.css({ "bottom" : $section.outerHeight() + 'px' });
			} else {
				wp.customize.previewer.container.css({ "bottom" : "" });
			}
		};
		$window.on( 'resize', resizePreviewer );
		wp.customize.previewedDevice.bind(function( device ) {
			setTimeout(function() {
				resizePreviewer();
			}, 250 );
		});

		/**
		 * Init Header & Footer Builder
		 */
		var initHeaderFooterBuilder = function( panel ) {
			var section = 'nanospace_panel_header' === panel.id ? wp.customize.section( 'nanospace_section_header_builder' ) : wp.customize.section( 'nanospace_section_footer_builder' ),
				$section = section.contentContainer;

			// If Header panel is expanded, add class to the body tag (for CSS styling).
			panel.expanded.bind(function( isExpanded ) {
				_.each(section.controls(), function( control ) {
					if ( 'resolved' === control.deferred.embedded.state() ) {
						return;
					}
					control.renderContent();
					control.deferred.embedded.resolve(); // This triggers control.ready().

					// Fire event after control is initialized.
					control.container.trigger( 'init' );
				});

				if ( isExpanded ) {
					$body.addClass( 'nanospace-has-builder-active' );
					$section.addClass( 'nanospace-builder-active' );
				} else {
					$body.removeClass( 'nanospace-has-builder-active' );
					$section.removeClass( 'nanospace-builder-active' );
				}

				resizePreviewer();
			});

			// Attach callback to builder toggle.
			$section.on( 'click', '.nanospace-builder-toggle', function( e ) {
				e.preventDefault();
				$section.toggleClass( 'nanospace-hide' );

				resizePreviewer();
			});

			$section.find( '.nanospace-builder-sortable-panel' ).on( 'sortover', function( e, ui ) {
				resizePreviewer();
			});

			var moveHeaderFooterBuilder = function() {
				if ( 1324 <= window.innerWidth ) {
					$section.insertAfter( $( '.wp-full-overlay-sidebar-content' ) );

					if ( section.expanded() ) {
						section.collapse();
					}
				} else {
					$section.appendTo( $( '#customize-theme-controls' ) );
				}
			};
			wp.customize.bind( 'pane-contents-reflowed', moveHeaderFooterBuilder );
			$window.on( 'resize', moveHeaderFooterBuilder );
		};
		wp.customize.panel( 'nanospace_panel_header', initHeaderFooterBuilder );
		wp.customize.panel( 'nanospace_panel_footer', initHeaderFooterBuilder );
		wp.customize.control( 'footer_elements' ).container.on( 'init', setCustomResponsiveElementsDisplay );

		/**
		 * Init Header Elements Locations Grouping
		 */
		var initHeaderFooterBuilderElements = function( e ) {
			var $control = $( this ),
				mode = 0 <= $control.attr( 'id' ).indexOf( 'header' ) ? 'header' : 'footer',
				$groupWrapper = $control.find( '.nanospace-builder-locations' ).addClass( 'nanospace-builder-groups' ),
				verticalSelector = '.nanospace-builder-location-vertical_top, .nanospace-builder-location-vertical_bottom, .nanospace-builder-location-mobile_vertical_top',
				$verticalLocations = $control.find( verticalSelector ),
				$horizontalLocations = $control.find( '.nanospace-builder-location' ).not( verticalSelector );

			if ( $verticalLocations.length ) {
				$( document.createElement( 'div' ) ).addClass( 'nanospace-builder-group nanospace-builder-group-vertical nanospace-builder-layout-block' ).appendTo( $groupWrapper ).append( $verticalLocations );
			}

			if ( $horizontalLocations.length ) {
				$( document.createElement( 'div' ) ).addClass( 'nanospace-builder-group nanospace-builder-group-horizontal nanospace-builder-layout-inline' ).appendTo( $groupWrapper ).append( $horizontalLocations );
			}

			// Make logo element has button-primary colors.
			$control.find( '.nanospace-builder-element[data-value="logo"], .nanospace-builder-element[data-value="mobile-logo"], .nanospace-builder-element[data-value="vertical-logo"]' ).addClass( 'button-primary' );

			// Element on click jump to element options.
			$control.on( 'click', '.nanospace-builder-location .nanospace-builder-element > span', function( e ) {
				e.preventDefault();

				var $element = $( this ).parent( '.nanospace-builder-element' ),
					targetKey = 'heading_' + mode + '_' + $element.attr( 'data-value' ).replace( '-', '_' ),
					targetControl = wp.customize.control( targetKey );

				if ( targetControl ) targetControl.focus();

			});

			// Group edit button on click jump to group section.
			$control.on( 'click', '.nanospace-builder-group-edit', function( e ) {
				e.preventDefault();

				var targetKey = 'nanospace_section_' + ( 'footer_elements' == control.id ? 'footer' : 'header' ) + '_' + $( this ).attr( 'data-value' ).replace( '-', '_' ),
					targetSection = wp.customize.section( targetKey );

				if ( targetSection ) targetSection.focus();
			});
		};
		wp.customize.control( 'header_elements_vertical' ).container.on( 'init', initHeaderFooterBuilderElements );
		wp.customize.control( 'header_elements' ).container.on( 'init', initHeaderFooterBuilderElements );
		wp.customize.control( 'header_mobile_elements' ).container.on( 'init', initHeaderFooterBuilderElements );
		wp.customize.control( 'footer_elements' ).container.on( 'init', initHeaderFooterBuilderElements );

	});
})( wp, jQuery );
