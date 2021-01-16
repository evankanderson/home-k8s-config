<?php

/**
 * Beaver Builder: Column Class
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
 * 10) Classes
 */
class NanoSpace_Beaver_Builder_Column {
	/**
	 * 0) Init
	 */

	private static $instance;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	private function __construct() {
// Filters

		add_filter( 'fl_builder_column_custom_class', __CLASS__ . '::classes', 10, 2 );

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
	 * 10) Classes
	 */

	/**
	 * Modify CSS classes
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $class
	 * @param  object $node
	 */
	public static function classes( $class, $node ) {
// Content vertical alignment

		if ( ! empty( $node->settings->vertical_alignment ) ) {
			$class .= ' ' . esc_attr( trim( $node->settings->vertical_alignment ) );
		}

		// Predefined colors

		if ( ! empty( $node->settings->predefined_color ) ) {
			$class .= ' ' . esc_attr( trim( $node->settings->predefined_color ) );
		}


		return $class;

	} // /classes
} // /NanoSpace_Beaver_Builder_Column

add_action( 'after_setup_theme', 'NanoSpace_Beaver_Builder_Column::init' );
