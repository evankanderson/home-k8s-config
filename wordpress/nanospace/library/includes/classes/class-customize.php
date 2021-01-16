<?php

/**
 * Customize Options Generator class
 *
 * @uses  `nanospace_theme_options` global hook
 *
 * @package     Labinator NanoSpace WordPress Theme Framework
 * @subpackage  Customize
 *
 * @since 1.0.0
 * @version 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Assets
 * 20) Customizer core
 */
final class NanoSpace_Library_Customize {
	/**
	 * 0) Init
	 */

	private $_info;

	/**
	 * Initialization.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @version 1.0.0
	 */
	public static function init() {
		add_filter( 'nanospace_customizer_setting_defaults', __CLASS__ . '::add_setting_defaults' );
		add_filter( 'nanospace_customizer_setting_postmessages', __CLASS__ . '::add_setting_postmessages' );

		// Actions.
		add_action( 'customize_register', __CLASS__ . '::customize', 100 );
		add_action( 'customize_controls_enqueue_scripts', __CLASS__ . '::assets' );

		//render custom typography.
		add_action( 'customize_controls_enqueue_scripts', __CLASS__ . '::controls_scripts' );

		add_action( 'widgets_init', __CLASS__ . '::register_widgets' );
		add_action( 'widgets_init', __CLASS__ . '::register_sidebars' );

		add_action( 'nanospace_frontend_before_enqueue_main_css', __CLASS__ . '::enqueue_frontend_google_fonts_css' );

		if ( is_customize_preview() ) {
			add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_preview_scripts' );
			add_action( 'wp_head', __CLASS__ . '::print_preview_styles', 20 );
			add_action( 'wp_footer', __CLASS__ . '::print_preview_scripts', 20 );
		}

		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_frontend_styles' );
		add_action( 'wp_head', __CLASS__ . '::print_custom_css' );

		// Customizer CSS.
		if ( ! is_customize_preview() ) {
			// Add inline CSS on frontend only.
			add_filter( 'nanospace_frontend_inline_css', __CLASS__ . '::add_frontend_css', 20 );
		}

	} // /init
	/**
	 * 10) Assets
	 */

	/**
	 * Customizer controls assets
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function assets() {
		// Styles.
		wp_enqueue_style( 'nanospace-customize-controls', get_theme_file_uri( NANOSPACE_LIBRARY_DIR . 'css/customize.css' ), false, esc_attr( NANOSPACE_THEME_VERSION ), 'screen' );
		wp_style_add_data( 'nanospace-customize-controls', 'rtl', 'replace' );

		wp_enqueue_style( 'nanospace-header-footer-controls', get_theme_file_uri( NANOSPACE_LIBRARY_DIR . 'css/customize-controls.css' ), array(), esc_attr( NANOSPACE_THEME_VERSION ) );
		wp_style_add_data( 'nanospace-header-footer-controls', 'rtl', 'replace' );

		// Scripts.
		wp_enqueue_script( 'nanospace-customize-controls', get_theme_file_uri( NANOSPACE_LIBRARY_DIR . 'js/customize-controls.js' ), array( 'customize-controls' ), esc_attr( NANOSPACE_THEME_VERSION ), true );
		wp_enqueue_script( 'nanospace-customize-controls-header-footer', get_theme_file_uri( NANOSPACE_LIBRARY_DIR . 'js/customize-controls-header.js' ), array( 'customize-controls' ), esc_attr( NANOSPACE_THEME_VERSION ), true );
		wp_localize_script( 'nanospace-customize-controls-header-footer', 'nanospaceCustomizerControlsData', array(
			'contexts' => self::get_control_contexts(),
		) );

		wp_enqueue_script( 'nanospace-customize-controls-color-piker', get_theme_file_uri( NANOSPACE_LIBRARY_DIR . 'js/alpha-color-picker.js' ), array( 'customize-controls' ), esc_attr( NANOSPACE_THEME_VERSION ), true );

	} // /assets

	public static function get_control_contexts() {
		return apply_filters( 'nanospace_customizer_control_contexts', array() );
	}

	public static function controls_scripts() {

		$string = self::generate_font_dropdown();

		wp_localize_script(
			'nanospace-customize-controls',
			'nanospace',
			array(
				'customizer' => array(
					'settings' => array(
						'custom_fonts' => $string,
					),
				),
			)
		);
	}

	public static function generate_font_dropdown() {

		// Add Custom Font List Into Customizer.
		return apply_filters( 'nanospace_customfont_list', array() );

	}

	public static function register_widgets() {
		// Include custom widgets.
		require_once( NANOSPACE_PATH_INCLUDES . 'widgets/class-nanospace-widget-posts.php' );

		// Register widgets.
		register_widget( 'Nanospace_Widget_Posts' );
	}

	public static function register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar', 'nanospace' ),
				'id'            => 'sidebar',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title h4">',
				'after_title'   => '</h2>',
			)
		);

		for ( $i = 1; $i <= 6; $i ++ ) {
			register_sidebar(
				array(
					/* translators: %s: footer widgets column number. */
					'name'          => sprintf( esc_html__( 'Footer Widgets Column %s', 'nanospace' ), $i ),
					'id'            => 'footer-widgets-' . $i,
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h2 class="widget-title h4">',
					'after_title'   => '</h2>',
				)
			);
		}
	}

	public static function enqueue_frontend_google_fonts_css() {
		// Customizer Google Fonts.
		$google_fonts_url = self::generate_active_google_fonts_embed_url();
		if ( ! empty( $google_fonts_url ) ) {
			wp_enqueue_style( 'nanospace-google-fonts', $google_fonts_url, array(), NANOSPACE_THEME_VERSION );
		}
	}

	public static function generate_active_google_fonts_embed_url() {
		return nanospace_build_google_fonts_embed_url( self::get_active_fonts( 'google_fonts' ) );
	}

	public static function get_active_fonts( $group = null ) {
		$fonts = array(
			'web_safe_fonts' => array(),
			'custom_fonts'   => array(),
			'google_fonts'   => array(),
		);

		$count = 0;

		$saved_settings = get_theme_mods();
		if ( empty( $saved_settings ) ) {
			$saved_settings = array();
		}

		// Iterate through the saved customizer settings, to find all font family settings.
		foreach ( $saved_settings as $key => $value ) {
			// Check if this setting is not a font family, then skip this setting.
			if ( false === strpos( $key, '_font_family' ) ) {
				continue;
			}

			// Split value format to [font provider, font name].
			$args = explode( '|', $value );

			// Only add if value format is valid.
			if ( 2 === count( $args ) ) {
				// Add to active fonts list.
				// Make sure it is has not been added before.
				if ( ! in_array( $args[1], $fonts[ $args[0] ] ) ) {
					$fonts[ $args[0] ][] = $args[1];
				}

				// Increment counter.
				$count += 1;
			}
		}

		// Check using the counter, if there is no saved settings about font family, add the default system font as active.
		if ( 0 === $count ) {
			$fonts['web_safe_fonts'][] = 'Default System Font';
		}

		// Return values.
		if ( is_null( $group ) ) {
			return $fonts;
		} else {
			return nanospace_array_value( $fonts, $group, array() );
		}
	}

	public static function enqueue_frontend_styles( $hook ) {
		/**
		 * Hook: Styles to be included before main CSS
		 */
		do_action( 'nanospace_frontend_before_enqueue_main_css', $hook );

		// Main CSS.
		wp_enqueue_style( 'nanospace_main', get_theme_file_uri( 'assets/css/header-main.css' ), array(), NANOSPACE_THEME_VERSION );
		wp_style_add_data( 'nanospace_main', 'rtl', 'replace' );

		/**
		 * Hook: Styles to included after main CSS.
		 */
		do_action( 'nanospace_frontend_after_enqueue_main_css', $hook );
	}

	public static function print_custom_css() {
		echo '<style type="text/css" id="nanospace-custom-css">' . "\n" . wp_strip_all_tags( apply_filters( 'nanospace_frontend_inline_css', '' ) ) . "\n" . '</style>' . "\n";
	}

	public static function add_frontend_css( $inline_css ) {
		$css = self::generate_frontend_css();

		if ( '' !== trim( $css ) ) {
			$inline_css .= "\n/* Customizer CSS */\n" . nanospace_minify_css_string( $css ); // WPCS: XSS OK
		}

		return $inline_css;
	}

	public static function generate_frontend_css() {
		// Get all postmessage rules.
		$postmessages = self::get_setting_postmessages();

		// Declare empty array to hold all default values.
		// Will be populated later, only when needed.
		$default_values = array();

		// Temporary CSS array to organize output.
		// Media groups are defined now, for proper responsive orders.
		$css_array = array(
			'global'                                => array(),
			'@media screen and (max-width: 1023px)' => array(),
			'@media screen and (max-width: 499px)'  => array(),
		);

		// Loop through each setting.
		foreach ( $postmessages as $key => $rules ) {
			// Get saved value.
			$setting_value = get_theme_mod( $key );

			// Skip this setting if value is not valid (only accepts string and number).
			if ( ! is_numeric( $setting_value ) && ! is_string( $setting_value ) ) {
				continue;
			}

			// Skip this setting if value is empty string.
			if ( '' === $setting_value ) {
				continue;
			}

			// Populate $default_values if haven't.
			if ( empty( $default_values ) ) {
				$default_values = nanospace_get_setting_defaults();
			}

			// Skip rule if value === default value.
			if ( $setting_value === nanospace_array_value( $default_values, $key ) ) {
				continue;
			}

			// Loop through each rule.
			foreach ( $rules as $rule ) {
				// Check rule validity, and then skip if it's not valid.
				if ( ! self::_check_postmessage_rule_for_css( $rule ) ) {
					continue;
				}

				// Sanitize rule.
				$rule = self::_sanitize_postmessage_rule( $rule, $setting_value );

				// Add to CSS array.
				$css_array[ $rule['media'] ][ $rule['element'] ][ $rule['property'] ] = $rule['value'];
			}
		}

		return nanospace_convert_css_array_to_string( $css_array );
	}

	public static function get_setting_postmessages() {
		return apply_filters( 'nanospace_customizer_setting_postmessages', array() );
	}

	private static function _check_postmessage_rule_for_css( $rule ) {
		// Check if there is no type defined, then return false.
		if ( ! isset( $rule['type'] ) ) {
			return false;
		}

		// Skip rule if it's not CSS related.
		if ( ! in_array( $rule['type'], array( 'css', 'font' ) ) ) {
			return false;
		}

		// Check if no element selector is defined, then return false.
		if ( ! isset( $rule['element'] ) ) {
			return false;
		}

		// Check if no property is defined, then return false.
		if ( ! isset( $rule['property'] ) || empty( $rule['property'] ) ) {
			return false;
		}

		// Passed all checks, return true.
		return true;
	}

	private static function _sanitize_postmessage_rule( $rule, $setting_value ) {
		// Declare empty array to hold all available fonts.
		// Will be populated later, only when needed.
		$fonts = array();

		// If "media" attribute is not specified, set it to "global".
		if ( ! isset( $rule['media'] ) || empty( $rule['media'] ) ) {
			$rule['media'] = 'global';
		}

		// If "pattern" attribute is not specified, set it to "$".
		if ( ! isset( $rule['pattern'] ) || empty( $rule['pattern'] ) ) {
			$rule['pattern'] = '$';
		}

		// Check if there is function attached.
		if ( isset( $rule['function'] ) && isset( $rule['function']['name'] ) ) {
			// Apply function to the original value.
			switch ( $rule['function']['name'] ) {
				/**
				 * Explode raw value by space (' ') as the delimiter and then return value from the specified index.
				 *
				 * args[0] = index of exploded array to return
				 */
				case 'explode_value':
					if ( ! isset( $rule['function']['args'][0] ) ) {
						break;
					}

					$index = $rule['function']['args'][0];

					if ( ! is_numeric( $index ) ) {
						break;
					}

					$array = explode( ' ', $setting_value );

					$setting_value = isset( $array[ $index ] ) ? $array[ $index ] : '';
					break;

				/**
				 * Scale all dimensions found in the raw value according to the specified scale amount.
				 *
				 * args[0] = scale amount
				 */
				case 'scale_dimensions':
					if ( ! isset( $rule['function']['args'][0] ) ) {
						break;
					}

					$scale = $rule['function']['args'][0];

					if ( ! is_numeric( $scale ) ) {
						break;
					}

					$parts     = explode( ' ', $setting_value );
					$new_parts = array();
					foreach ( $parts as $i => $part ) {
						$number = floatval( $part );
						$unit   = str_replace( $number, '', $part );

						$new_parts[ $i ] = ( $number * $scale ) . $unit;
					}

					$setting_value = implode( ' ', $new_parts );
					break;
			}
		}

		// Parse value for "font" type.
		if ( 'font' === $rule['type'] ) {
			$chunks = explode( '|', $setting_value );

			if ( 2 === count( $chunks ) ) {
				// Populate $fonts array if haven't.
				if ( empty( $fonts ) ) {
					$fonts = nanospace_get_all_fonts();
				}
				$setting_value = nanospace_array_value( $fonts[ $chunks[0] ], $chunks[1], $chunks[1] );
			}
		}

		// Replace any $ found in the pattern to value.
		$rule['value'] = str_replace( '$', $setting_value, $rule['pattern'] );

		// Replace any $ found in the media screen to value.
		$rule['media'] = str_replace( '$', $setting_value, $rule['media'] );

		return $rule;
	}

	public static function enqueue_preview_scripts() {
		wp_enqueue_script( 'nanospace-customize-postmessages', get_theme_file_uri( NANOSPACE_LIBRARY_DIR . 'js/customize-postmessages.js' ), array( 'customize-preview' ), esc_attr( NANOSPACE_THEME_VERSION ), true );

		wp_localize_script( 'nanospace-customize-postmessages', 'nanospaceCustomizerPreviewData', array(
			'postMessages' => self::get_setting_postmessages(),
			'fonts'        => nanospace_get_all_fonts(),
		) );
	}

	public static function add_setting_defaults( $nanospace_defaults = array() ) {
		include( NANOSPACE_PATH_INCLUDES . '/customize/defaults.php' );

		return $nanospace_defaults;
	}

	public static function add_setting_postmessages( $postmessages = array() ) {
		include( NANOSPACE_PATH_INCLUDES . '/customize/postmessages.php' );

		return $nanospace_postmessages;
	}

	public static function print_preview_styles() {
		// Print global preview CSS.
		echo '<style id="nanospace-preview-css" type="text/css">.customize-partial-edit-shortcut button:hover,.customize-partial-edit-shortcut button:focus{border-color: currentColor}</style>' . "\n";

		/**
		 * Print saved theme_mods CSS.
		 */
		$postmessages   = self::get_setting_postmessages();
		$default_values = nanospace_get_setting_defaults();

		// Loop through each setting.
		foreach ( $postmessages as $key => $rules ) {
			// Get saved value.
			$setting_value = get_theme_mod( $key );

			// Get default value.
			$default_value = nanospace_array_value( $default_values, $key );
			if ( is_null( $default_value ) ) {
				$default_value = '';
			}

			// Temporary CSS array to organize output.
			$css_array = array();

			// Add CSS only if value is not the same as default value and not empty.
			if ( $setting_value !== $default_value && '' !== $setting_value ) {
				foreach ( $rules as $rule ) {
					// Check rule validity, and then skip if it's not valid.
					if ( ! self::_check_postmessage_rule_for_css( $rule ) ) {
						continue;
					}

					// Sanitize rule.
					$rule = self::_sanitize_postmessage_rule( $rule, $setting_value );

					// Add to CSS array.
					$css_array[ $rule['media'] ][ $rule['element'] ][ $rule['property'] ] = $rule['value'];
				}
			}

			echo '<style id="nanospace-customize-preview-css-' . $key . '" type="text/css">' . nanospace_convert_css_array_to_string( $css_array ) . '</style>' . "\n"; // WPCS: XSS OK
		}
	}

	public static function print_preview_scripts() {
		?>
		<script type="text/javascript">
			(function () {
				'use strict';

				document.addEventListener('DOMContentLoaded', function () {
					if ('undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh && wp.customize.widgetsPreview && wp.customize.widgetsPreview.WidgetPartial) {
						wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {
							// Nav Menu
							if (placement.partial.id.indexOf('nav_menu_instance')) {
								window.nanospace.initAll();
							}
						});
					}
				});
			})();
		</script>
		<?php
	}

	/**
	 * Outputs customizer JavaScript
	 *
	 * This function automatically outputs theme customizer preview JavaScript for each theme option,
	 * where the `preview_js` property is set.
	 *
	 * For CSS theme option change it works by inserting a `<style>` tag into a preview HTML head for
	 * each theme option separately. This is to prevent inline styles on elements when applied with
	 * pure JS.
	 * Also, we need to create the `<style>` tag for each option separately so way we gain control
	 * over the output. If we put all the CSS into a single `<style>` tag, it would be bloated with
	 * CSS styles for every single subtle change in the theme option(s).
	 *
	 * It is possible to set up a custom JS action, not just CSS styles change. That can be used
	 * to trigger a class on an element, for example.
	 *
	 * If `preview_js => false` set, the change of the theme option won't trigger the customizer
	 * preview refresh.
	 *
	 * The actual JavaScript is outputted in the footer of the page.
	 *
	 * @example
	 *   'preview_js' => array(
	 *
	 *     // Setting CSS styles:
	 *     'css' => array(
	 *
	 *       // CSS variables (the `[[id]]` gets replaced with option ID)
	 *             ':root' => array(
	 *         '--[[id]]',
	 *       ),
	 *             ':root' => array(
	 *         array(
	 *           'property' => '--[[id]]',
	 *           'suffix'   => 'px',
	 *         ),
	 *       ),
	 *
	 *       // Sets the whole value to the `css-property-name` of the `selector`
	 *       'selector' => array(
	 *         'background-color',...
	 *       ),
	 *
	 *       // Sets the `css-property-name` of the `selector` with specific settings
	 *       'selector' => array(
	 *         array(
	 *           'property'         => 'text-shadow',
	 *           'prefix'           => '0 1px 1px rgba(',
	 *           'suffix'           => ', .5)',
	 *           'process_callback' => 'hexToRgb',
	 *           'custom'           => '0 0 0 1em [[value]] ), 0 0 0 2em transparent, 0 0 0 3em [[value]]',
	 *         ),...
	 *       ),
	 *
	 *       // Replaces "@" in `selector` for `selector-replace-value` (such as "@ h2, @ h3" to ".footer h2, .footer h3")
	 *       'selector' => array(
	 *         'selector_replace' => 'selector-replace-value',
	 *         'selector_before'  => '@media only screen and (min-width: 80em) {',
	 *         'selector_after'   => '}',
	 *         'background-color',...
	 *       ),
	 *
	 *     ),
	 *
	 *     // And/or setting custom JavaScript:
	 *     'custom' => 'JavaScript here', // Such as "jQuery( '.site-title.type-text' ).toggleClass( 'styled' );"
	 *
	 *   );
	 *
	 * @uses  `nanospace_theme_options` global hook
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @version 1.0.0
	 */
	public static function preview_scripts() {

		// Pre.
		$pre = apply_filters( 'nanospace_library_customize_preview_scripts_pre', false );

		if ( false !== $pre ) {
			return $pre;
		}

		$theme_options = apply_filters( 'nanospace_theme_options', array() );

		ksort( $theme_options );

		$output = $output_single = '';
		if (
			is_array( $theme_options )
			&& ! empty( $theme_options )
		) {

			foreach ( $theme_options as $theme_option ) {

				if (
					isset( $theme_option['preview_js'] )
					&& is_array( $theme_option['preview_js'] )
				) {

					$output_single = "wp.customize(" . "\r\n";
					$output_single .= "\t" . "'" . $theme_option['id'] . "'," . "\r\n";
					$output_single .= "\t" . "function( value ) {" . "\r\n";
					$output_single .= "\t\t" . 'value.bind( function( to ) {' . "\r\n";

					// CSS.
					if ( isset( $theme_option['preview_js']['css'] ) ) {
						$output_single .= "\t\t\t" . "var newCss = '';" . "\r\n\r\n";
						$output_single .= "\t\t\t" . "if ( jQuery( '#jscss-" . $theme_option['id'] . "' ).length ) { jQuery( '#jscss-" . $theme_option['id'] . "' ).remove() }" . "\r\n\r\n";

						foreach ( $theme_option['preview_js']['css'] as $selector => $properties ) {
							if ( is_array( $properties ) ) {
								$output_single_css = $selector_before = $selector_after = '';

								foreach ( $properties as $key => $property ) {

									// Selector setup.
									if ( 'selector_replace' === $key ) {
										$selector = str_replace( '@', $property, $selector );
										continue;
									}

									if ( 'selector_before' === $key ) {
										$selector_before = $property;
										continue;
									}

									if ( 'selector_after' === $key ) {
										$selector_after = $property;
										continue;
									}

									// CSS properties setup.
									if ( ! is_array( $property ) ) {
										$property = array( 'property' => (string) $property );
									}

									$property = wp_parse_args( (array) $property, array(
										'custom'           => '',
										'prefix'           => '',
										'process_callback' => '',
										'property'         => '',
										'suffix'           => '',
									) );

									// Replace `[[id]]` placeholder with option ID.
									$property['property'] = str_replace(
										'[[id]]',
										$theme_option['id'],
										$property['property']
									);

									$value = ( empty( $property['process_callback'] ) ) ? ( 'to' ) : ( trim( $property['process_callback'] ) . '( to )' );

									if ( empty( $property['custom'] ) ) {
										$output_single_css .= $property['property'] . ": " . $property['prefix'] . "' + " . $value . " + '" . $property['suffix'] . "; ";
									} else {
										$output_single_css .= $property['property'] . ": " . str_replace( '[[value]]', "' + " . $value . " + '", $property['custom'] ) . "; ";
									}
								}

								$output_single .= "\t\t\t" . "newCss += '" . $selector_before . $selector . " { " . $output_single_css . "}" . $selector_after . " ';" . "\r\n";
							}
						}

						$output_single .= "\r\n\t\t\t" . "jQuery( document ).find( 'head' ).append( jQuery( '<style id=\'jscss-" . $theme_option['id'] . "\'> ' + newCss + '</style>' ) );" . "\r\n";
					}

					// Custom JS.
					if ( isset( $theme_option['preview_js']['custom'] ) ) {
						$output_single .= "\t\t" . $theme_option['preview_js']['custom'] . "\r\n";
					}

					$output_single .= "\t\t" . '} );' . "\r\n";
					$output_single .= "\t" . '}' . "\r\n";
					$output_single .= ');' . "\r\n";
					$output_single = apply_filters( 'nanospace_library_customize_preview_scripts_option_' . $theme_option['id'], $output_single );

					$output .= $output_single;

				}

			}

		}

		if ( $output = trim( $output ) ) {
			echo apply_filters( 'nanospace_library_customize_preview_scripts_output', '<!-- Theme custom scripts -->' . "\r\n" . '<script type="text/javascript"><!--' . "\r\n" . '( function( $ ) {' . "\r\n\r\n" . trim( $output ) . "\r\n\r\n" . '} )( jQuery );' . "\r\n" . '//--></script>' );
		}

	} // /preview_scripts
	/**
	 * 20) Customizer core
	 */

	/**
	 * Customizer renderer
	 *
	 * @uses  `nanospace_theme_options` global hook
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @version 1.0.0
	 *
	 * @param  object $wp_customize WP customizer object.
	 */
	public static function customize( $wp_customize ) {

		// Requirements check.
		if ( ! isset( $wp_customize ) ) {
			return;
		}

		// Pre.
		$pre = apply_filters( 'nanospace_library_customize_pre', false, $wp_customize );

		if ( false !== $pre ) {
			return $pre;
		}

		$theme_options = (array) apply_filters( 'nanospace_theme_options', array() );

		ksort( $theme_options );

		$allowed_option_types = apply_filters(
			'nanospace_library_customize_allowed_option_types',
			array(
				'checkbox',
				'color',
				'email',
				'hidden',
				'html',
				'image',
				'multicheckbox',
				'multiselect',
				'password',
				'radio',
				'radiomatrix',
				'range',
				'section',
				'select',
				'text',
				'textarea',
				'url',
			)
		);

		// To make sure our customizer sections start after WordPress default ones.
		$priority = absint( apply_filters( 'nanospace_library_customize_priority', 0 ) );

		// Default section name in case not set (should be overwritten anyway).
		$customizer_panel   = '';
		$customizer_section = 'nanospace';

		// Option type.
		$type = 'theme_mod';

		// Set live preview for predefined controls.
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		// Move background color setting alongside background image.

		$wp_customize->get_control( 'background_color' )->section  = 'background_image';
		$wp_customize->get_control( 'background_color' )->priority = 20;

		// Change background image section priority.
		$wp_customize->get_section( 'background_image' )->priority = 30;

		// Change header image section priority.
		$wp_customize->get_section( 'header_image' )->priority = 25;

		// Custom controls.
		/**
		 * @link  https://github.com/bueltge/Wordpress-Theme-Customizer-Custom-Controls
		 * @link  http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
		 */

		require_once NANOSPACE_LIBRARY . 'includes/classes/class-customize-control-hidden.php';
		require_once NANOSPACE_LIBRARY . 'includes/classes/class-customize-control-html.php';
		require_once NANOSPACE_LIBRARY . 'includes/classes/class-customize-control-multiselect.php';
		require_once NANOSPACE_LIBRARY . 'includes/classes/class-customize-control-radio-matrix.php';
		require_once NANOSPACE_LIBRARY . 'includes/classes/class-customize-control-select.php';

		do_action( 'nanospace_library_customize_load_controls', $wp_customize );

		require_once 'class-nanospace-pro-customizer.php';
		$wp_customize->register_section_type( 'NanoSpace_Pro_Customizer' );

		$wp_customize->add_section(
			new NanoSpace_Pro_Customizer(
				$wp_customize,
				'nanospace_pro',
				array(
					'name'             => 'nanospace-pro',
					'section_callback' => 'NanoSpace_Pro_Customizer',
				)
			)
		);

		// Generate customizer options.
		if (
			is_array( $theme_options )
			&& ! empty( $theme_options )
		) {
			foreach ( $theme_options as $theme_option ) {
				if (
					is_array( $theme_option )
					&& isset( $theme_option['type'] )
					&& in_array( $theme_option['type'], $allowed_option_types )
				) {

					$priority ++;

					$option_id = $default = $description = '';

					if ( isset( $theme_option['id'] ) ) {
						$option_id = $theme_option['id'];
					}
					if ( isset( $theme_option['default'] ) ) {
						$default = $theme_option['default'];
					}
					if ( isset( $theme_option['description'] ) ) {
						$description = $theme_option['description'];
					}

					$transport = ( isset( $theme_option['preview_js'] ) ) ? ( 'postMessage' ) : ( 'refresh' );
					/**
					 * Panels
					 *
					 * Panels are wrappers for customizer sections.
					 * Note that the panel will not display unless sections are assigned to it.
					 * Set the panel name in the section declaration with `in_panel`:
					 * - if text, this will become a panel title (ID defaults to `theme-options`)
					 * - if array, you can set `title`, `id` and `type` (the type will affect panel class)
					 * Panel has to be defined for each section to prevent all sections within a single panel.
					 *
					 * @link  http://make.wordpress.org/core/2014/07/08/customizer-improvements-in-4-0/
					 */
					if ( isset( $theme_option['in_panel'] ) ) {

						$panel_type = 'theme-options';

						if ( is_array( $theme_option['in_panel'] ) ) {
							$panel_title = isset( $theme_option['in_panel']['title'] ) ? ( $theme_option['in_panel']['title'] ) : ( '&mdash;' );
							$panel_id    = isset( $theme_option['in_panel']['id'] ) ? ( $theme_option['in_panel']['id'] ) : ( $panel_type );
							$panel_type  = isset( $theme_option['in_panel']['type'] ) ? ( $theme_option['in_panel']['type'] ) : ( $panel_type );
						} else {
							$panel_title = $theme_option['in_panel'];
							$panel_id    = $panel_type;
						}

						$panel_type = apply_filters( 'nanospace_library_customize_panel_type', $panel_type, $theme_option, $theme_options );
						$panel_id   = apply_filters( 'nanospace_library_customize_panel_id', $panel_id, $theme_option, $theme_options );

						if ( $customizer_panel !== $panel_id ) {
							$wp_customize->add_panel(
								$panel_id,
								array(
									'title'       => esc_html( $panel_title ),
									'description' => ( isset( $theme_option['in_panel-description'] ) ) ? ( $theme_option['in_panel-description'] ) : ( '' ),
									// Hidden at the top of the panel.
									'priority'    => $priority,
									'type'        => $panel_type,
									// Sets also the panel class.
								)
							);
							$customizer_panel = $panel_id;
						}
					}
					/**
					 * Sections
					 */
					if ( isset( $theme_option['create_section'] ) && trim( $theme_option['create_section'] ) ) {

						if ( empty( $option_id ) ) {
							$option_id = sanitize_title( trim( $theme_option['create_section'] ) );
						}

						$customizer_section = array(
							'id'    => $option_id,
							'setup' => array(
								'title'       => $theme_option['create_section'],
								// Section title.
								'description' => ( isset( $theme_option['create_section-description'] ) ) ? ( $theme_option['create_section-description'] ) : ( '' ),
								// Displayed at the top of section.
								'priority'    => $priority,
								'type'        => 'theme-options',
								// Sets also the section class.
							)
						);

						if ( ! isset( $theme_option['in_panel'] ) ) {
							$customizer_panel = '';
						} else {
							$customizer_section['setup']['panel'] = $customizer_panel;
						}

						$wp_customize->add_section(
							$customizer_section['id'],
							$customizer_section['setup']
						);

						$customizer_section = $customizer_section['id'];

					}
					/**
					 * Generic settings
					 */
					$generic = array(
						'label'           => ( isset( $theme_option['label'] ) ) ? ( $theme_option['label'] ) : ( '' ),
						'description'     => $description,
						'section'         => ( isset( $theme_option['section'] ) ) ? ( $theme_option['section'] ) : ( $customizer_section ),
						'priority'        => ( isset( $theme_option['priority'] ) ) ? ( $theme_option['priority'] ) : ( $priority ),
						'type'            => $theme_option['type'],
						'active_callback' => ( isset( $theme_option['active_callback'] ) ) ? ( $theme_option['active_callback'] ) : ( null ),
						'input_attrs'     => ( isset( $theme_option['input_attrs'] ) ) ? ( $theme_option['input_attrs'] ) : ( array() ),
					);
					/**
					 * Options generator
					 */
					switch ( $theme_option['type'] ) {

						case 'checkbox':
						case 'radio':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( 'checkbox' === $theme_option['type'] ) ? ( 'NanoSpace_Library_Sanitize::checkbox' ) : ( 'NanoSpace_Library_Sanitize::select' ),
									'sanitize_js_callback' => ( 'checkbox' === $theme_option['type'] ) ? ( 'NanoSpace_Library_Sanitize::checkbox' ) : ( 'NanoSpace_Library_Sanitize::select' ),
								)
							);
							$wp_customize->add_control(
								$option_id,
								array_merge( $generic, array(
									'choices' => ( isset( $theme_option['choices'] ) ) ? ( $theme_option['choices'] ) : ( '' ),
								) )
							);
							break;

						case 'multicheckbox':
						case 'multiselect':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'NanoSpace_Library_Sanitize::multi_array' ),
									'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'NanoSpace_Library_Sanitize::multi_array' ),
								)
							);
							$wp_customize->add_control( new NanoSpace_Customize_Control_Multiselect(
								$wp_customize,
								$option_id,
								array_merge( $generic, array(
									'choices' => ( isset( $theme_option['choices'] ) ) ? ( $theme_option['choices'] ) : ( '' ),
								) )
							) );
							break;

						case 'color':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => trim( $default, '#' ),
									'transport'            => $transport,
									'sanitize_callback'    => 'sanitize_hex_color_no_hash',
									'sanitize_js_callback' => 'maybe_hash_hex_color',
								)
							);
							$wp_customize->add_control( new WP_Customize_Color_Control(
								$wp_customize,
								$option_id,
								$generic
							) );
							break;

						case 'email':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => 'sanitize_email',
									'sanitize_js_callback' => 'sanitize_email',
								)
							);
							$wp_customize->add_control(
								$option_id,
								$generic
							);
							break;

						case 'hidden':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
									'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
								)
							);
							$wp_customize->add_control( new NanoSpace_Customize_Control_Hidden(
								$wp_customize,
								$option_id,
								array(
									'label'    => 'HIDDEN FIELD',
									'section'  => $customizer_section,
									'priority' => $priority,
								)
							) );
							break;

						case 'html':
							if ( empty( $option_id ) ) {
								$option_id = 'custom-title-' . $priority;
							}
							$wp_customize->add_setting(
								$option_id,
								array(
									'sanitize_callback'    => 'wp_kses_post',
									'sanitize_js_callback' => 'wp_filter_post_kses',
								)
							);
							$wp_customize->add_control( new NanoSpace_Customize_Control_HTML(
								$wp_customize,
								$option_id,
								array(
									'label'           => ( isset( $theme_option['label'] ) ) ? ( $theme_option['label'] ) : ( '' ),
									'description'     => $description,
									'content'         => $theme_option['content'],
									'section'         => ( isset( $theme_option['section'] ) ) ? ( $theme_option['section'] ) : ( $customizer_section ),
									'priority'        => ( isset( $theme_option['priority'] ) ) ? ( $theme_option['priority'] ) : ( $priority ),
									'active_callback' => ( isset( $theme_option['active_callback'] ) ) ? ( $theme_option['active_callback'] ) : ( null ),
								)
							) );
							break;

						case 'image':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_url_raw' ),
									'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_url_raw' ),
								)
							);
							$wp_customize->add_control( new WP_Customize_Image_Control(
								$wp_customize,
								$option_id,
								array_merge( $generic, array(
									'context' => $option_id,
								) )
							) );
							break;

						case 'range':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'absint' ),
									'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'absint' ),
								)
							);
							$wp_customize->add_control(
								$option_id,
								array_merge( $generic, array(
									'input_attrs' => array(
										'min'           => $theme_option['min'],
										'max'           => $theme_option['max'],
										'step'          => $theme_option['step'],
										'data-multiply' => ( isset( $theme_option['multiplier'] ) ) ? ( $theme_option['multiplier'] ) : ( 1 ),
										'data-prefix'   => ( isset( $theme_option['prefix'] ) ) ? ( $theme_option['prefix'] ) : ( '' ),
										'data-suffix'   => ( isset( $theme_option['suffix'] ) ) ? ( $theme_option['suffix'] ) : ( '' ),
										'data-decimals' => ( isset( $theme_option['decimal_places'] ) ) ? ( absint( $theme_option['decimal_places'] ) ) : ( 0 ),
									),
								) )
							);
							break;

						case 'password':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
									'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
								)
							);
							$wp_customize->add_control(
								$option_id,
								$generic
							);
							break;

						case 'radiomatrix':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
									'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_attr' ),
								)
							);
							$wp_customize->add_control( new NanoSpace_Customize_Control_Radio_Matrix(
								$wp_customize,
								$option_id,
								array_merge( $generic, array(
									'choices' => ( isset( $theme_option['choices'] ) ) ? ( $theme_option['choices'] ) : ( '' ),
									'class'   => ( isset( $theme_option['class'] ) ) ? ( $theme_option['class'] ) : ( '' ),
								) )
							) );
							break;

						case 'select':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => 'NanoSpace_Library_Sanitize::select',
									'sanitize_js_callback' => 'NanoSpace_Library_Sanitize::select',
								)
							);
							$wp_customize->add_control( new NanoSpace_Customize_Control_Select(
								$wp_customize,
								$option_id,
								array_merge( $generic, array(
									'choices' => ( isset( $theme_option['choices'] ) ) ? ( $theme_option['choices'] ) : ( '' ),
								) )
							) );
							break;

						case 'text':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_textarea' ),
									'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_textarea' ),
								)
							);
							$wp_customize->add_control(
								$option_id,
								$generic
							);
							break;

						case 'textarea':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_textarea' ),
									'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_textarea' ),
								)
							);
							$wp_customize->add_control(
								$option_id,
								$generic
							);
							break;

						case 'url':
							$wp_customize->add_setting(
								$option_id,
								array(
									'type'                 => $type,
									'default'              => $default,
									'transport'            => $transport,
									'sanitize_callback'    => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_url' ),
									'sanitize_js_callback' => ( isset( $theme_option['validate'] ) ) ? ( $theme_option['validate'] ) : ( 'esc_url' ),
								)
							);
							$wp_customize->add_control(
								$option_id,
								$generic
							);
							break;

						default:
							break;

					}

				}
			}
		}

		// Header Footer builder code start.
		require_once NANOSPACE_PATH_INCLUDES . 'customize/_sections.php';

		// Assets needed for customizer preview.
		if ( $wp_customize->is_preview() ) {
			add_action( 'wp_footer', __CLASS__ . '::preview_scripts', 99 );
		}

	} // /customize
} // /NanoSpace_Library_Customize

add_action( 'after_setup_theme', 'NanoSpace_Library_Customize::init', 20 );
