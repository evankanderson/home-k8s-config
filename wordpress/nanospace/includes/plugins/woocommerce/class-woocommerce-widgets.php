<?php

/**
 * WooCommerce: Widgets Class
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
 * 10) Sidebars
 * 20) Widget: Product Search
 */
class NanoSpace_WooCommerce_Widgets {
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
		// Removing.
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

		// Actions.
		add_action( 'widgets_init', __CLASS__ . '::register_widget_areas', 1 );

		add_action( 'woocommerce_after_single_product_summary', __CLASS__ . '::sidebar_product', 20 );

		add_action( 'woocommerce_before_shop_loop', __CLASS__ . '::sidebar_shop_before', 5 );

		// Filters.
		add_filter( 'sidebars_widgets', __CLASS__ . '::shop_sidebar', 5 );

		add_filter( 'nanospace_sidebar_disable', __CLASS__ . '::sidebar_disable' );

		add_filter( 'get_product_search_form', __CLASS__ . '::product_search_form' );

		if ( is_callable( 'NanoSpace_Sidebar::widget_tag_cloud_args' ) ) {
			add_filter( 'woocommerce_product_tag_cloud_widget_args', 'NanoSpace_Sidebar::widget_tag_cloud_args' );
		}

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
	 * 10) Sidebars
	 */

	/**
	 * Product widget area: registration
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function register_widget_areas() {
		register_sidebar( array(
			'id'            => 'shop',
			'name'          => esc_html__( 'Shop Sidebar', 'nanospace' ),
			'description'   => esc_html__( 'This sidebar replaces the default sidebar area for shop page and product archive pages.', 'nanospace' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title screen-reader-text">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'id'            => 'product',
			'name'          => esc_html__( 'Product', 'nanospace' ),
			'description'   => esc_html__( 'This widget area is displayed on single product page, just above the related products list.', 'nanospace' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'id'            => 'shop-before',
			'name'          => esc_html__( 'Before Products List', 'nanospace' ),
			'description'   => esc_html__( 'This widget area is displayed on shop archive pages before the products list.', 'nanospace' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title screen-reader-text">',
			'after_title'   => '</h2>',
		) );

	} // /register_widget_areas

	/**
	 * Product widgets area: display
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function sidebar_product() {

		get_sidebar( 'product' );

	} // /sidebar_product

	/**
	 * Before Products List widgets area: display
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function sidebar_shop_before() {

		get_sidebar( 'shop-before' );

	} // /sidebar_shop_before

	/**
	 * Replace default sidebar with Shop Sidebar
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function shop_sidebar( $sidebars_widgets ) {

		// Requirements check.
		if (
			! ( is_shop() || is_product_taxonomy() )
			|| ! isset( $sidebars_widgets['shop'] )
			|| empty( $sidebars_widgets['shop'] )
		) {
			return $sidebars_widgets;
		}

		$shop_sidebar_widgets = $sidebars_widgets['shop'];

		// Replace default sidebar widgets with the shop sidebar ones.
		$sidebars_widgets['sidebar'] = $shop_sidebar_widgets;

		return $sidebars_widgets;

	} // /shop_sidebar

	/**
	 * Sidebar disabling
	 *
	 * Disable sidebar on single products.
	 * Enable shop sidebar on product archives.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  boolean $disabled
	 */
	public static function sidebar_disable( $disabled = false ) {
		if ( is_product() ) {
			return true;
		} elseif ( is_shop() || is_product_taxonomy() ) {
			return ! is_active_sidebar( 'shop' );
		}

		return $disabled;

	} // /sidebar_disable

	/**
	 * 20) Widget: Product Search
	 */

	/**
	 * Fixing search field ID for multiple display
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function product_search_form( $html ) {

		return str_replace( 'woocommerce-product-search-field', 'woocommerce-product-search-field-' . esc_attr( uniqid() ), $html );

	} // /product_search_form
} // /NanoSpace_WooCommerce_Widgets

add_action( 'after_setup_theme', 'NanoSpace_WooCommerce_Widgets::init' );
