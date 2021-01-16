<?php

/**
 * WooCommerce: Assets Class
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
 * 10) Setup
 */
class NanoSpace_WooCommerce_Assets {
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
// Actions

		add_action( 'wp_enqueue_scripts', __CLASS__ . '::assets', 100 );

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
	 * 10) Setup
	 */

	/**
	 * Enqueue assets
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function assets() {
// Styles

		wp_enqueue_style(
			'nanospace-stylesheet-woocommerce',
			get_theme_file_uri( 'assets/css/woocommerce.css' ),
			array( 'nanospace-stylesheet-global' ),
			esc_attr( trim( NANOSPACE_THEME_VERSION ) ),
			'screen'
		);
		wp_style_add_data( 'nanospace-stylesheet-woocommerce', 'rtl', 'replace' );

		wp_enqueue_style(
			'nanospace-stylesheet-custom-styles-woocommerce',
			get_theme_file_uri( 'assets/css/custom-styles-woocommerce.css' ),
			array( 'nanospace-stylesheet-global' ),
			esc_attr( trim( NANOSPACE_THEME_VERSION ) ),
			'screen'
		);

		// Scripts

		wp_enqueue_script(
			'nanospace-scripts-woocommerce',
			get_theme_file_uri( 'assets/js/scripts-woocommerce.js' ),
			array( 'jquery' ),
			esc_attr( trim( NANOSPACE_THEME_VERSION ) ),
			true
		);

	} // /assets
} // /NanoSpace_WooCommerce_Assets

add_action( 'after_setup_theme', 'NanoSpace_WooCommerce_Assets::init' );
