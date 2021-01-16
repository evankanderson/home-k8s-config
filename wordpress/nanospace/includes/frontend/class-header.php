<?php

/**
 * Header Class
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
 *  10) HTML head
 *  20) Body start
 *  30) Site header
 *  40) Setup
 * 100) Others
 */
class NanoSpace_Header {
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

		add_action( 'nanospace_html_before', __CLASS__ . '::doctype' );

		add_action( 'wp_head', __CLASS__ . '::head', 1 );

		add_action( 'nanospace_body_top', __CLASS__ . '::oldie', 5 );

		add_action( 'nanospace_body_top', __CLASS__ . '::skip_links', 5 );

		add_action( 'nanospace_body_top', __CLASS__ . '::site_open' );

		add_action( 'nanospace_header_top', __CLASS__ . '::open', 1 );
		add_action( 'nanospace_header_top', __CLASS__ . '::open_inner', 2 );

		add_action( 'nanospace_header_bottom', __CLASS__ . '::close', 101 );

		// jQuery.scrollWatch IE11 helpers:

		add_action( 'nanospace_header_top', __CLASS__ . '::ie_sticky_header_wrapper_open', 0 );
		add_action( 'nanospace_header_bottom', __CLASS__ . '::ie_sticky_header_wrapper_close', 102 );

		// Filters
		add_filter( 'body_class', __CLASS__ . '::body_class', 98 );
		add_filter( 'tiny_mce_before_init', __CLASS__ . '::editor_body_class' );

		add_filter( 'nanospace_library_link_skip_to_pre', __CLASS__ . '::skip_links_no_header', 10, 2 );

	} // /__construct

    public static function dib(){
	    return 'oho';
    }

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
	 * 10) HTML head
	 */

	/**
	 * HTML DOCTYPE
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function doctype() {


		echo '<!DOCTYPE html>';

	} // /doctype

	/**
	 * HTML HEAD
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function head() {
		get_template_part( 'templates/parts/header/head' );

	} // /head
	/**
	 * 20) Body start
	 */

	/**
	 * IE upgrade message
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function oldie() {

		// Requirements check

		if ( ! isset( $GLOBALS['is_IE'] ) || ! $GLOBALS['is_IE'] ) {
			return;
		}
		get_template_part( 'templates/parts/component', 'oldie' );

	} // /oldie

	/**
	 * Skip links: Body top
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function skip_links() {


		get_template_part( 'templates/parts/header/links', 'skip' );

	} // /skip_links

	/**
	 * Site container: Open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function site_open() {


		echo '<div id="page" class="site">' . "\r\n";

	} // /site_open
	/**
	 * 30) Site header
	 *
	 * Header widgets:
	 * @see  includes/frontend/class-sidebar.php
	 *
	 * Header menu:
	 * @see  includes/frontend/class-menu.php
	 */

	/**
	 * Header: Open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function open() {


		echo "\r\n\r\n" . '<header id="masthead" class="site-header" role="banner">' . "\r\n\r\n";

	} // /open

	/**
	 * Header: Close
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function close() {


		echo "\r\n\r\n" . '</header>' . "\r\n\r\n";

	} // /close

	/**
	 * Header inner container: Open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function open_inner() {
		do_action( 'nanospace_frontend_before_canvas' );
		do_action( 'nanospace_frontend_header' );
		do_action( 'nanospace_frontend_header_mobile' );

	}
	/**
	 * 40) Setup
	 */

	/**
	 * HTML Body classes
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $classes
	 */
	public static function body_class( $classes = array() ) {


		$classes = (array) $classes; // Just in case...
// JS fallback

		$classes[] = 'no-js';

		// Website layout

		if ( $layout_site = get_theme_mod( 'layout_site', 'boxed' ) ) {
			$classes[] = esc_attr( 'site-layout-' . $layout_site );
		}

		// Header layout

		if ( $layout_header = get_theme_mod( 'layout_header', 'boxed' ) ) {
			$classes[] = esc_attr( 'header-layout-' . $layout_header );
		}

		// Footer layout

		if ( $layout_footer = get_theme_mod( 'layout_footer', 'boxed' ) ) {
			$classes[] = esc_attr( 'footer-layout-' . $layout_footer );
		}

		// Is mobile navigation enabled?
		$classes[] = 'has-navigation-mobile';


		// Singular?

		if ( is_singular() ) {
			$classes[] = 'is-singular';

			$post_id = get_the_ID();

			// Has featured image?

			if ( has_post_thumbnail() ) {
				$classes[] = 'has-post-thumbnail';
			}

			// Has custom intro image?

			if ( get_post_meta( $post_id, 'intro_image', true ) ) {
				$classes[] = 'has-custom-intro-image';
			}

			// Any page builder layout

			$content_layout = (string) get_post_meta( $post_id, 'content_layout', true );

			if ( 'stretched' === $content_layout ) {
				$classes[] = 'content-layout-no-paddings';
				$classes[] = 'content-layout-stretched';
			} elseif ( 'no-paddings' === $content_layout ) {
				$classes[] = 'content-layout-no-paddings';
			}

		} else {

			// Add a class of hfeed to non-singular pages

			$classes[] = 'hfeed';

		}

		// Has more than 1 published author?

		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Sticky header enabled?

		if (
			self::is_enabled()
			&& get_theme_mod( 'layout_header_sticky', true )
		) {
			$classes[] = 'has-sticky-header';
		}

		// Intro displayed?

		if ( ! (bool) apply_filters( 'nanospace_intro_disable', false ) ) {
			$classes[] = 'has-intro';
		} else {
			$classes[] = 'no-intro';
		}

		// Widget areas

		foreach ( (array) apply_filters( 'nanospace_header_body_classes_sidebars', array() ) as $sidebar ) {
			if ( ! is_active_sidebar( $sidebar ) ) {
				$classes[] = 'no-widgets-' . $sidebar;
			} else {
				$classes[] = 'has-widgets-' . $sidebar;
			}
		}

		// Posts layout

		if (
			is_home()
			|| is_category()
			|| is_tag()
			|| is_date()
			|| is_author()
		) {
			$classes[] = 'posts-layout-' . sanitize_html_class( get_theme_mod( 'blog_style', 'masonry' ) );
		}

		if ( (bool) apply_filters( 'nanospace_is_masonry_layout', false ) ) {
			$classes[] = 'posts-layout-masonry';
		}

		// Outdented page layout

		if (
			is_page()
			&& ! is_attachment() // This is required for attachments added to a page.
			&& ! is_page_template( 'templates/sidebar.php' )
			&& get_theme_mod( 'layout_page_outdent', false )
		) {
			$classes[] = 'page-layout-outdented';
		}


		asort( $classes );

		return array_unique( $classes );

	} // /body_class

	/**
	 * Is header enabled?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function is_enabled() {
		return (bool) apply_filters( 'nanospace_header_is_enabled', absint(nanospace_get_theme_mod( 'nanospace_header_enable' )) ? 1 : 0 );

	} // /editor_body_class
	/**
	 * 100) Others
	 */

	/**
	 * Is header disabled?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function is_disabled() {

		return (bool) apply_filters( 'nanospace_header_is_disabled', absint(nanospace_get_theme_mod( 'nanospace_header_enable' )) ? 0 : 1 );

	} // /is_disabled

	/**
	 * HTML Body classes in content editor (TinyMCE)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $init
	 */
	public static function editor_body_class( $init = array() ) {

		// Requirements check

		global $post;

		if (
			! isset( $init['body_class'] )
			|| ! is_admin()
			|| ! $post instanceof WP_Post
		) {
			return $init;
		}
		if (
			'page' === get_post_type( $post )
			&& false === strpos( $init['body_class'], 'excerpt' )
		) {

			// Outdented page layout

			if ( get_theme_mod( 'layout_page_outdent', true ) ) {
				$init['body_class'] .= ' page-layout-outdented';
			}

			// Any page builder ready

			$content_layout = (string) get_post_meta( $post->ID, 'content_layout', true );

			if ( in_array( $content_layout, array( 'stretched', 'no-paddings' ) ) ) {
				$init['body_class'] .= ' content-layout-no-paddings';
			}

		}


		return $init;

	} // /is_enabled

	/**
	 * Skip links: Remove header related links.
	 *
	 * When we display no header, remove all related skip links.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $pre Pre output.
	 * @param  string $id Link target element ID.
	 */
	public static function skip_links_no_header( $pre, $id ) {
		if (
			(bool) apply_filters( 'nanospace_skip_links_no_header', self::is_disabled() )
			&& in_array( $id, array( 'header-menu-1' ) )
		) {
			$pre = '';
		}


		return $pre;

	} // /skip_links_no_header
	/**
	 * Sticky header wrapper for Internet Explorer 11
	 *
	 * As we are displaying SVG icons in header, and we still
	 * support Internet Explorer 11, we need to add the sticky
	 * header wrapper with PHP to prevent IE11 SVG icons not
	 * displaying when the header is wrapped with JS.
	 *
	 * This is a jQuery.scrollWatch script helper.
	 */

	/**
	 * Sticky header wrapper: Open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function ie_sticky_header_wrapper_open() {

		// Requirements check

		if (
			( ! isset( $GLOBALS['is_IE'] ) || ! $GLOBALS['is_IE'] )
			|| ! get_theme_mod( 'layout_header_sticky', true )
		) {
			return;
		}


		echo '<div class="scroll-watch-placeholder masthead-placeholder">';

	} // /ie_sticky_header_wrapper_open

	/**
	 * Sticky header wrapper: Close
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function ie_sticky_header_wrapper_close() {

		// Requirements check

		if (
			( ! isset( $GLOBALS['is_IE'] ) || ! $GLOBALS['is_IE'] )
			|| ! get_theme_mod( 'layout_header_sticky', true )
		) {
			return;
		}


		echo '</div>';

	} // /ie_sticky_header_wrapper_close
} // /NanoSpace_Header

add_action( 'after_setup_theme', 'NanoSpace_Header::init' );
