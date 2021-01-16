<?php

/**
 * CSS Variables Generator class
 *
 * @uses  `nanospace_theme_options` global hook
 * @uses  `nanospace_css_rgb_alphas` global hook
 *
 * @package     Labinator NanoSpace WordPress Theme Framework
 * @subpackage  Customize
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Getters
 * 100) Helpers
 */
final class NanoSpace_Library_CSS_Variables {
	/**
	 * 0) Init
	 */

	public static $cache_key = 'nanospace_css_vars';

	/**
	 * Initialization.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function init() {
		// Actions.
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::compatibility', 0 );

		add_action( 'switch_theme', __CLASS__ . '::cache_flush' );
		add_action( 'customize_save_after', __CLASS__ . '::cache_flush' );
		add_action( 'nanospace_library_theme_upgrade', __CLASS__ . '::cache_flush' );

	} // /init
	/**
	 * 10) Getters
	 */

	/**
	 * Get CSS variables from theme options in string.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function get_variables_string() {

		// Variables.
		$css_vars = (array) self::get_variables_array();
		$css_vars = array_map( __CLASS__ . '::get_variable_declaration', array_keys( $css_vars ), $css_vars );
		$css_vars = implode( ' ', $css_vars );

		return trim( (string) $css_vars );

	} // /get_variables_array

	/**
	 * Get CSS variables from theme options in array.
	 *
	 * @uses  `nanospace_theme_options` global hook
	 * @uses  `nanospace_css_rgb_alphas` global hook
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function get_variables_array() {

		// Variables.
		$is_customize_preview = is_customize_preview();

		$css_vars = (array) get_transient( self::$cache_key );
		$css_vars = array_filter( $css_vars, 'trim', ARRAY_FILTER_USE_KEY );

		// Requirements check.

		if (
			! empty( $css_vars )
			&& ! $is_customize_preview
		) {
			return (array) $css_vars;
		}
		foreach ( (array) apply_filters( 'nanospace_theme_options', array() ) as $option ) {
			if ( ! isset( $option['css_var'] ) ) {
				continue;
			}

			// Custom fonts only if they are enabled.
			if (
				'NanoSpace_Library_Sanitize::css_fonts' === $option['css_var']
				&& ! get_theme_mod( 'typography_custom_fonts', false )
			) {
				continue;
			}

			if ( isset( $option['default'] ) ) {
				$value = $option['default'];
			} else {
				$value = '';
			}

			$mod = get_theme_mod( $option['id'] );
			if ( isset( $option['validate'] ) && is_callable( $option['validate'] ) ) {
				$mod = call_user_func( $option['validate'], $mod );
			}
			if ( ! empty( $mod ) || 'checkbox' === $option['type'] ) {
				if ( 'color' === $option['type'] ) {
					$value_check = maybe_hash_hex_color( $value );
					$mod         = maybe_hash_hex_color( $mod );
				} else {
					$value_check = $value;
				}
				// No need to output CSS var if it is the same as default.
				if ( $value_check === $mod ) {
					continue;
				}
				$value = $mod;
			} else {
				// No need to output CSS var if it was not changed in customizer.
				continue;
			}

			// Array value to string. Just in case.
			if ( is_array( $value ) ) {
				$value = (string) implode( ',', (array) $value );
			}

			if ( is_callable( $option['css_var'] ) ) {
				$value = call_user_func( $option['css_var'], $value );
			} else {
				$value = str_replace(
					'[[value]]',
					$value,
					(string) $option['css_var']
				);
			}

			// RGBA colors.
			$rgba_alphas = (array) apply_filters( 'nanospace_css_rgb_alphas', array() );
			if ( isset( $rgba_alphas[ $option['id'] ] ) ) {
				$alphas = (array) $rgba_alphas[ $option['id'] ];
				foreach ( $alphas as $alpha ) {
					$css_vars[ '--' . $option['id'] . '--a' . absint( $alpha ) ] = self::color_hex_to_rgba( $value, absint( $alpha ) );
				}
			}

			$css_vars[ '--' . $option['id'] ] = $value;
		}

		// Cache the results.
		if ( ! $is_customize_preview ) {
			set_transient( self::$cache_key, (array) $css_vars );
		}

		return (array) $css_vars;

	} // /get_variables_string

	/**
	 * Hex color to RGBA
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @link  http://php.net/manual/en/function.hexdec.php
	 *
	 * @param  string $hex
	 * @param  absint $alpha [0-100]
	 *
	 * @return  string Color in rgb() or rgba() format to use in CSS.
	 */
	public static function color_hex_to_rgba( $hex, $alpha = 100 ) {

		// Variables.

		$alpha = absint( $alpha );

		$output = ( 100 === $alpha ) ? ( 'rgb(' ) : ( 'rgba(' );

		$rgb = array();

		$hex = preg_replace( '/[^0-9A-Fa-f]/', '', $hex );
		$hex = substr( $hex, 0, 6 );

		// Converting hex color into rgb.

		$color = (int) hexdec( $hex );

		$rgb['r'] = (int) 0xFF & ( $color >> 0x10 );
		$rgb['g'] = (int) 0xFF & ( $color >> 0x8 );
		$rgb['b'] = (int) 0xFF & $color;

		$output .= implode( ',', $rgb );

		// Using alpha (rgba)?

		if ( 100 > $alpha ) {
			$output .= ',' . ( $alpha / 100 );
		}

		// Closing opening bracket.

		$output .= ')';

		return $output;

	} // /get_variable_declaration
	/**
	 * 100) Helpers
	 */

	/**
	 * Get CSS variable declaration.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $variable
	 * @param  string $value
	 */
	public static function get_variable_declaration( $variable, $value ) {

		return (string) $variable . ': ' . (string) $value . ';';

	} // /compatibility

	/**
	 * Ensure CSS variables compatibility with older browsers.
	 *
	 * @link  https://github.com/jhildenbiddle/css-vars-ponyfill
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function compatibility() {
		wp_enqueue_script(
			'css-vars-ponyfill',
			get_theme_file_uri( NANOSPACE_LIBRARY_DIR . 'js/vendor/css-vars-ponyfill/css-vars-ponyfill.min.js' ),
			array(),
			'1.16.1'
		);

		wp_add_inline_script(
			'css-vars-ponyfill',
			'window.onload = function() {' . PHP_EOL .
			"\t" . 'cssVars( {' . PHP_EOL .
			"\t\t" . 'onlyVars: true,' . PHP_EOL .
			"\t\t" . 'exclude: \'link:not([href^="' . esc_url_raw( get_theme_root_uri() ) . '"])\'' . PHP_EOL .
			"\t" . '} );' . PHP_EOL .
			'};'
		);

	} // /color_hex_to_rgba

	/**
	 * Flush the cached CSS variables array.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function cache_flush() {
		delete_transient( self::$cache_key );

	} // /cache_flush
} // /NanoSpace_Library_CSS_Variables

add_action( 'after_setup_theme', 'NanoSpace_Library_CSS_Variables::init', 20 );
