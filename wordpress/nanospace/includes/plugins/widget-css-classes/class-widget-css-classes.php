<?php

/**
 * Adding Custom Widget CSS CLasses
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Functionality
 */
class NanoSpace_Widget_CSS_Classes {
	/**
	 * 0) Init
	 */

	private static $classes;

	private static $instance;

	/**
	 * Constructor
	 *
	 * @uses  `nanospace_widget_css_classes` global hook
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	private function __construct() {

		// Requirements check

		if ( ! is_admin() ) {
			return;
		}


		self::$classes = (array) apply_filters( 'nanospace_widget_css_classes', array() );
// Filters

		add_filter( 'option_WCSSC_options', __CLASS__ . '::widget_css_classes' );

	} // /__construct

	/**
	 * Initialization (get instance)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}


		return self::$instance;

	} // /init
	/**
	 * 10) Functionality
	 */

	/**
	 * Widget CSS Classes plugin integration
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $settings Widget CSS Classes plugin settings array.
	 */
	public static function widget_css_classes( $settings = array() ) {

		// Requirements check

		if (
			empty( self::$classes )
			|| ! function_exists( 'widget_css_classes_loader' )
		) {
			return $settings;
		}


		$settings = (array) $settings;
// Add predefined theme classes

		if ( isset( $settings['defined_classes'] ) ) {
			if ( is_string( $settings['defined_classes'] ) ) {
				$settings['defined_classes'] = explode( ';', (string) $settings['defined_classes'] );
			}
		} else {
			$settings['defined_classes'] = array();
		}

		$settings['defined_classes'] = array_unique(
			array_filter(
				array_merge(
					(array) $settings['defined_classes'],
					(array) self::$classes
				)
			)
		);

		$settings['defined_classes'] = implode( ';', $settings['defined_classes'] );

		// Make predefined theme classes visible

		if ( apply_filters( 'nanospace_widget_css_classes_force_type', true ) ) {
			$settings['type'] = 3;
		}


		return $settings;

	} // /widget_css_classes
} // /NanoSpace_Widget_CSS_Classes

add_action( 'after_setup_theme', 'NanoSpace_Widget_CSS_Classes::init' );
