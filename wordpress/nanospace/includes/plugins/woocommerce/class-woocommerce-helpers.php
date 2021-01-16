<?php

/**
 * WooCommerce: Helpers Class
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
 * 10) Numbers
 * 20) Product
 */
class NanoSpace_WooCommerce_Helpers {
	/**
	 * 0) Init
	 */

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	private function __construct() {
	}
	/**
	 * 10) Numbers
	 */

	/**
	 * Helper setup function to return numbers depending on context
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $context Which number to return.
	 */
	public static function return_number( $context = '' ) {


		$output                         = array();
		$output['shop_columns']         = 3;
		$output['shop_columns_sidebar'] = 2;

		$output['thumbnails_columns'] = ( version_compare( WC_VERSION, '3.0', '<' ) ) ? ( 20 ) : ( 5 );

		$output['cross_sells_total']   = 2;
		$output['cross_sells_columns'] = 1;

		$output = (array) apply_filters( 'nanospace_woocommerce_helpers_return_number', $output, $context );


		return ( isset( $output[ $context ] ) ) ? ( absint( $output[ $context ] ) ) : ( 1 );

	} // /return_number
	/**
	 * 20) Product
	 */

	/**
	 * Get cart product ID
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function get_cart_product_id( $product ) {


		return ( isset( $product['product_id'] ) ) ? ( $product['product_id'] ) : ( null );

	} // /get_cart_product_id

	/**
	 * Get product gallery image IDs
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function get_product_gallery_image_ids( $product ) {

		// Requirements check

		if ( ! is_a( $product, 'WC_Product' ) ) {
			return;
		}


		if ( is_callable( 'WC_Product::get_gallery_image_ids' ) ) {
			return $product->get_gallery_image_ids();
		} else {
			return $product->get_gallery_attachment_ids();
		}

	} // /get_product_gallery_image_ids
} // /NanoSpace_WooCommerce_Helpers
