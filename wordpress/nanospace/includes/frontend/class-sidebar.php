<?php

/**
 * Sidebar Class
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Register
 *  20) Widget areas
 *  30) Conditions
 * 100) Others
 */
class NanoSpace_Sidebar {
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

		add_action( 'widgets_init', __CLASS__ . '::register', 1 );

		add_action( 'nanospace_content_top', __CLASS__ . '::secondary_left', 25 );

		add_action( 'nanospace_content_bottom', __CLASS__ . '::secondary', 85 );

		add_action( 'nanospace_header_bottom', __CLASS__ . '::header' );

		add_action( 'nanospace_intro_after', __CLASS__ . '::intro' );

		add_action( 'nanospace_footer_top', __CLASS__ . '::footer_secondary', 20 );

		add_action( 'nanospace_footer_top', __CLASS__ . '::footer', 30 );

		// Filters

		add_filter( 'is_active_sidebar', __CLASS__ . '::intro_conditions', 10, 2 );

		add_filter( 'is_active_sidebar', __CLASS__ . '::secondary_conditions', 100, 2 );

		add_filter( 'nanospace_header_body_classes_sidebars', __CLASS__ . '::body_class_sidebars' );

		add_filter( 'widget_tag_cloud_args', __CLASS__ . '::widget_tag_cloud_args' );

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
	 * 10) Register
	 */

	/**
	 * Register predefined widget areas (sidebars)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function register() {


		$widget_areas = array(

			'sidebar' => array(
				'name'        => esc_html__( 'Blog Right Sidebar', 'nanospace' ),
				'description' => esc_html__( 'Default sidebar area.', 'nanospace' ),
			),

			'left-sidebar' => array(
				'name'        => esc_html__( 'Blog Left Sidebar', 'nanospace' ),
				'description' => esc_html__( 'Default sidebar area.', 'nanospace' ),
			),

			'header' => array(
				'name'        => esc_html__( 'Header Widgets', 'nanospace' ),
				'description' => esc_html__( 'Widgetized area displayed in website header.', 'nanospace' ),
			),

			'intro' => array(
				'name'        => esc_html__( 'Intro Widgets', 'nanospace' ),
				'description' => esc_html__( 'Widgetized area displayed at the bottom of the Intro title section.', 'nanospace' ),
			),

			'footer' => array(
				'name'        => esc_html__( 'Footer Widgets', 'nanospace' ),
				'description' => esc_html__( 'Widgetized area displaying the main website footer content.', 'nanospace' ),
			),

			'footer-secondary' => array(
				'name'        => esc_html__( 'Footer Secondary Widgets', 'nanospace' ),
				'description' => esc_html__( 'Additional widgetized area displayed in the website footer.', 'nanospace' ),
			),

		);
		foreach ( $widget_areas as $id => $args ) {

			register_sidebar( array(
				'id'            => esc_attr( $id ),
				'name'          => $args['name'],
				'description'   => $args['description'],
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );

		} // /foreach

	} // /register
	/**
	 * 20) Widget areas
	 */

	/**
	 * Sidebar (secondary content)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function secondary() {


		get_sidebar();

	} // /secondary

	/**
	 * Left Sidebar (secondary content)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function secondary_left() {


		get_sidebar( 'left' );

	} // /secondary

	/**
	 * Header sidebar
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function header() {


		get_sidebar( 'header' );

	} // /header

	/**
	 * Intro sidebar
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function intro() {


		get_sidebar( 'intro' );

	} // /intro

	/**
	 * Footer sidebar
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function footer() {


		get_sidebar( 'footer' );

	} // /footer

	/**
	 * Footer secondary sidebar
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function footer_secondary() {


		get_sidebar( 'footer-secondary' );

	} // /footer_secondary
	/**
	 * 30) Conditions
	 */

	/**
	 * Sidebar (secondary content): display conditions
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  bool $is_active_sidebar
	 * @param  int|string $index
	 */
	public static function secondary_conditions( $is_active_sidebar, $index ) {

		// Requirements check

		if ( 'sidebar' !== $index ) {
			return $is_active_sidebar;
		}
		if (
			is_404()
			|| is_attachment()
			|| ( is_page( get_the_ID() ) && ! is_page_template( 'templates/sidebar.php' ) )
			|| NanoSpace_Post::is_page_builder_ready()
			|| apply_filters( 'nanospace_sidebar_disable', false )
		) {
			$is_active_sidebar = false;
		}


		return $is_active_sidebar;

	} // /secondary_conditions

	/**
	 * Intro sidebar: display conditions
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  bool $is_active_sidebar
	 * @param  int|string $index
	 */
	public static function intro_conditions( $is_active_sidebar, $index ) {

		// Requirements check

		if ( 'intro' !== $index ) {
			return $is_active_sidebar;
		}


		$enabled = ( 'always' === get_theme_mod( 'layout_intro_widgets_display' ) ) ? ( ! is_search() ) : ( is_singular() );
		if (
			NanoSpace_Post::is_paged()
			|| ! $enabled
			|| (
				NanoSpace_Post::is_singular()
				&& ! is_page_template( 'templates/intro-widgets.php' )
				&& ! get_post_meta( get_the_ID(), 'show_intro_widgets', true )
			)
		) {
			$is_active_sidebar = false;
		}


		return $is_active_sidebar;

	} // /intro_conditions
	/**
	 * 100) Others
	 */

	/**
	 * Which sidebar classes to apply on HTML body?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $sidebars
	 */
	public static function body_class_sidebars( $sidebars = array() ) {


		$sidebars = nanospace_get_single_sidebar_id();

		$sidebars[] = 'sidebar';

		return (array) $sidebars;

	} // /body_class_sidebars

	/**
	 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $args
	 */
	public static function widget_tag_cloud_args( $args = array() ) {


		$args['largest']  = 1;
		$args['smallest'] = 1;
		$args['unit']     = 'em';


		return $args;

	} // /widget_tag_cloud_args
} // /NanoSpace_Sidebar

add_action( 'after_setup_theme', 'NanoSpace_Sidebar::init' );
