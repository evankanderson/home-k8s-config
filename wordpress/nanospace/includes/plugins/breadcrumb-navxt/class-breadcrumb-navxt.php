<?php

/**
 * Breadcrumb NavXT Class
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
 * 10) Admin
 * 20) Frontend
 * 30) Options
 */
class NanoSpace_Breadcrumb_NavXT {
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

		add_action( 'wp', __CLASS__ . '::display' );

		// Filters

		add_filter( 'bcn_show_cpt_private', __CLASS__ . '::admin', 10, 2 );

		add_filter( 'nanospace_theme_options', __CLASS__ . '::options' );

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
	 * 10) Admin
	 */

	/**
	 * Plugin setup admin page modification
	 *
	 * Don't display breadcrumbs settings for posts with no single view.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  boolean $display
	 * @param  string $post_type
	 */
	public static function admin( $display = true, $post_type = '' ) {


		$redirects = (array) apply_filters( 'nanospace_post_type_redirect', array() );
		if (
			! empty( $redirects )
			&& in_array( $post_type, array_keys( $redirects ) )
		) {
			$display = false;
		}


		return $display;

	} // /admin
	/**
	 * 20) Frontend
	 */

	/**
	 * Display
	 *
	 * Controlling where the breadcrumbs are displayed.
	 * Has to be in a separate method hooked into some early THA hook
	 * (such as `nanospace_body_top`) to make it work in theme customizer
	 * preview when editing breadcrumbs display options (see below).
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function display() {


		$display = get_theme_mod( 'breadcrumbs_display', 'after' );
		if ( in_array( $display, array( 'both', 'before' ) ) ) {
			add_action( 'nanospace_content_top', __CLASS__ . '::breadcrumbs', 16 );
		}

		if ( in_array( $display, array( 'both', 'after' ) ) ) {
			add_action( 'nanospace_footer_top', __CLASS__ . '::breadcrumbs', 5 );
		}

	} // /display

	/**
	 * Breadcrumbs
	 *
	 * Breadcrumbs displayed in footer.
	 * Adding random number to breadcrumbs label ID to allow multiple
	 * breadcrumbs displays.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function breadcrumbs() {


		get_template_part( 'templates/parts/component/breadcrumbs' );

	} // /breadcrumbs
	/**
	 * 30) Options
	 */

	/**
	 * Theme options addons and modifications
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $options
	 */
	public static function options( $options = array() ) {
		$options[ 300 . 'layout' . 600 ] = array(
			'type'    => 'html',
			'content' => '<h3>' . esc_html__( 'Breadcrumbs', 'nanospace' ) . '</h3>',
		);

		$options[ 300 . 'layout' . 610 ] = array(
			'type'    => 'radio',
			'id'      => 'breadcrumbs_display',
			'label'   => esc_html__( 'Breadcrumbs display', 'nanospace' ),
			'choices' => array(
				'before' => esc_html__( 'Before content only', 'nanospace' ),
				'both'   => esc_html__( 'Both before and after content', 'nanospace' ),
				'after'  => esc_html__( 'After content only', 'nanospace' ),
			),
			'default' => 'after',
		);


		return $options;

	} // /options
} // /NanoSpace_Breadcrumb_NavXT

add_action( 'after_setup_theme', 'NanoSpace_Breadcrumb_NavXT::init' );
