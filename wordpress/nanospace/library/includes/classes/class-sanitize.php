<?php

/**
 * Sanitization Methods class
 *
 * @link  https://github.com/WPTRT/code-examples/blob/master/customizer/sanitization-callbacks.php
 *
 * @package     Labinator NanoSpace WordPress Theme Framework
 * @subpackage  Core
 *
 * @since 1.0.0
 * @version 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 * 10) General
 * 20) CSS
 */
final class NanoSpace_Library_Sanitize {
	/**
	 * 10) General
	 */

	/**
	 * Sanitize checkbox
	 *
	 * Sanitization callback for checkbox type controls.
	 * This callback sanitizes `$checked` as a boolean value, either TRUE or FALSE.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  bool $value
	 */
	public static function checkbox( $value ) {


		return ( ( isset( $value ) && true == $value ) ? ( true ) : ( false ) );

	} // /checkbox

	/**
	 * Sanitize select/radio
	 *
	 * Sanitization callback for select and radio type controls.
	 * This callback sanitizes `$value` against provided array of `$choices`.
	 * The `$choices` has to be associated array!
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $value
	 * @param  array $choices
	 * @param  string $default
	 */
	public static function select( $value, $choices = array(), $default = '' ) {
		/**
		 * If we pass a customizer control as `$choices`,
		 * get the list of choices and default value from it.
		 */
		if ( is_a( $choices, 'WP_Customize_Setting' ) ) {
			$default = $choices->default;
			$choices = $choices->manager->get_control( $choices->id )->choices;
		}

		return ( array_key_exists( $value, (array) $choices ) ? ( esc_attr( $value ) ) : ( esc_attr( $default ) ) );

	} // /select

	/**
	 * Sanitize array
	 *
	 * Sanitization callback for multiselect type controls.
	 * This callback sanitizes `$value` against provided array of `$choices`.
	 * The `$choices` has to be associated array!
	 * Returns an array of values.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  mixed $value
	 * @param  array $choices
	 */
	public static function multi_array( $value, $choices = array() ) {

		/**
		 * If we get a string in `$value`,
		 * split it to array using `,` as delimiter.
		 */
		$value = ( ! is_array( $value ) ) ? ( explode( ',', (string) $value ) ) : ( $value );

		/**
		 * If we pass a customizer control as `$choices`,
		 * get the list of choices and default value from it.
		 */
		if ( is_a( $choices, 'WP_Customize_Setting' ) ) {
			$choices = $choices->manager->get_control( $choices->id )->choices;
		}

		// Requirements check.
		if ( empty( $choices ) ) {
			return array();
		}
		foreach ( $value as $key => $single_value ) {

			if ( ! array_key_exists( $single_value, $choices ) ) {
				unset( $value[ $key ] );
				continue;
			}

			$value[ $key ] = esc_attr( $single_value );

		} // /foreach

		return (array) $value;

	} // /multi_array

	/**
	 * Sanitize float
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $value
	 */
	public static function float( $value ) {

		return floatval( $value );

	} // /fonts

	/**
	 * Sanitize CSS fonts.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $fonts
	 */
	public static function css_fonts( $fonts ) {

		// Variables.

		/**
		 * @link  https://developer.mozilla.org/en-US/docs/Web/CSS/font-family
		 */
		$font_family_generic = array(
			'serif',
			'sans-serif',
			'monospace',
			'cursive',
			'fantasy',
			'system-ui',
			'inherit',
			'initial',
			'unset',
		);
		$fonts               = explode( ',', (string) self::fonts( $fonts ) );

		foreach ( $fonts as $key => $font_family ) {
			$font_family = trim( $font_family, "\"' \t\n\r\0\x0B" );
			if ( ! in_array( $font_family, $font_family_generic ) ) {
				$font_family = '"' . $font_family . '"';
			}
			$fonts[ $key ] = $font_family;
		}

		$fonts = implode( ', ', (array) $fonts );

		return (string) $fonts;

	} // /float
	/**
	 * 20) CSS
	 */

	/**
	 * Sanitize fonts
	 *
	 * Sanitization callback for `font-family` CSS property value.
	 * Allows only alphanumeric characters, spaces, commas, underscores,
	 * dashes, single and/or double quotes of `$value` variable.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $value
	 * @param  string $default
	 */
	public static function fonts( $value, $default = '' ) {
		$value = trim( preg_replace( '/[^a-zA-Z0-9 ,_\-\'\"]+/', '', (string) $value ) );

		/**
		 * If we pass a customizer control as `$default`,
		 * get the default value from it.
		 */
		if ( is_a( $default, 'WP_Customize_Setting' ) ) {
			$default = $default->default;
		}

		return ( ( $value ) ? ( (string) $value ) : ( (string) $default ) );

	} // /css_fonts

	/**
	 * Sanitize CSS pixel value.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  int $value
	 */
	public static function css_pixels( $value ) {

		return absint( $value ) . 'px';

	} // /css_pixels

	/**
	 * Sanitize CSS image URL.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  mixed $image
	 */
	public static function css_image_url( $image ) {

		// Variables.
		$value = 'none';
		if ( is_array( $image ) && isset( $image['id'] ) ) {
			$image = absint( $image['id'] );
		}

		if ( is_numeric( $image ) ) {
			$image = wp_get_attachment_image_src( absint( $image ), 'full' );
			$image = $image[0];
		}

		if ( ! empty( $image ) ) {
			$value = 'url("' . esc_url_raw( $image ) . '")';
		}

		return $value;

	} // /css_image_url

	/**
	 * Sanitize CSS background-repeat checkbox.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  mixed $repeat
	 */
	public static function css_checkbox_background_repeat( $repeat ) {
		if ( ! is_string( $repeat ) ) {
			$repeat = ( $repeat ) ? ( 'repeat' ) : ( 'no-repeat' );
		}

		return (string) $repeat;

	} // /css_checkbox_background_repeat

	/**
	 * Sanitize CSS background-attachment checkbox.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  mixed $attachment
	 */
	public static function css_checkbox_background_attachment( $attachment ) {
		if ( ! is_string( $attachment ) ) {
			$attachment = ( $attachment ) ? ( 'fixed' ) : ( 'scroll' );
		}

		return (string) $attachment;

	} // /css_checkbox_background_attachment
} // /NanoSpace_Library_Sanitize
