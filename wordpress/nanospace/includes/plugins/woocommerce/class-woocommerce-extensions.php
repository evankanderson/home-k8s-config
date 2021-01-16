<?php

/**
 * WooCommerce: Extensions Class
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 * 0) Init
 */
class NanoSpace_WooCommerce_Extensions {
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

		/**
		 * WooCommerce Product Image Flipper
		 *
		 * @see  https://wordpress.org/plugins/woocommerce-product-image-flipper/
		 */
		add_filter( 'woocommerce_product_image_flipper_styles', '__return_false' );

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
} // /NanoSpace_WooCommerce_Extensions

add_action( 'after_setup_theme', 'NanoSpace_WooCommerce_Extensions::init' );
