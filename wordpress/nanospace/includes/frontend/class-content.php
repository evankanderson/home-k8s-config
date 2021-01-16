<?php

/**
 * Content Class
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
 *  10) Main
 * 100) Helpers
 */
class NanoSpace_Content {
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

		add_action( 'nanospace_content_top', __CLASS__ . '::open_container', 10 );

		add_action( 'nanospace_content_top', __CLASS__ . '::open_container_inner', 20 );

		add_action( 'nanospace_content_top', __CLASS__ . '::open_primary', 30 );

		add_action( 'nanospace_content_top', __CLASS__ . '::open_main', 40 );

		add_action( 'nanospace_content_bottom', __CLASS__ . '::close_main', 70 );

		add_action( 'nanospace_content_bottom', __CLASS__ . '::close_primary', 80 );

		add_action( 'nanospace_content_bottom', __CLASS__ . '::close_container_inner', 90 );

		add_action( 'nanospace_content_bottom', __CLASS__ . '::close_container', 100 );

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
	 * 10) Main
	 */

	/**
	 * Content container: Open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function open_container() {


		$layout = nanospace_get_theme_mod( 'nanospace_section_header_layout_select' );

		if ( $layout == 'left-header' ) {
			echo "\r\n\r\n" . '<div id="content" class="site-content left-header">';
		} elseif ( $layout == 'right-header' ) {
			echo "\r\n\r\n" . '<div id="content" class="site-content right-header">';
		} else {
			echo "\r\n\r\n" . '<div id="content" class="site-content">';
		}
	} // /open_container

	/**
	 * Content container inner: Open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function open_container_inner() {


		echo "\r\n" . '<div class="site-content-inner">';

	} // /open_container_inner

	/**
	 * Content primary: Open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function open_primary() {


		echo "\r\n\t" . '<div id="primary" class="content-area">';

	} // /open_primary

	/**
	 * Content main: Open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function open_main() {


		echo "\r\n\t\t" . '<main id="main" class="site-main" role="main">' . "\r\n\r\n";

	} // /open_main

	/**
	 * Content main: Close
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function close_main() {


		echo "\r\n\r\n\t\t" . '</main><!-- /#main -->';

	} // /close_main

	/**
	 * Content primary: Close
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function close_primary() {


		echo "\r\n\t" . '</div><!-- /#primary -->';

	} // /close_primary

	/**
	 * Content container inner: Close
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function close_container_inner() {


		echo "\r\n" . '</div><!-- /.site-content-inner -->';

	} // /close_container_inner

	/**
	 * Content container: Close
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function close_container() {


		echo "\r\n" . '</div><!-- /#content -->' . "\r\n\r\n";

	} // /close_container
	/**
	 * 100) Helpers
	 */

	/**
	 * Level up heading tags
	 *
	 * Levels up the HTML headings in single post/page view.
	 * Transforms H3 to H2 and H4 to H3.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $html
	 */
	public static function headings_level_up( $html ) {

		// Pre

		$pre = apply_filters( 'nanospace_content_headings_level_up_pre', false, $html );

		if ( false !== $pre ) {
			return $pre;
		}
// Requirements check

		if ( ! NanoSpace_Post::is_singular() ) {
			return $html;
		}
		switch ( $html ) {

			case 'h3':
				$html = tag_escape( 'h2' );
				break;

			case 'h4':
				$html = tag_escape( 'h3' );
				break;

			default:
				$html = str_replace(
					array(
						'<h3',
						'</h3', // 1) H3...
						'<h4',
						'</h4', // 2) H4...
					),
					array(
						'<h2',
						'</h2', // 1) ...to H2
						'<h3',
						'</h3', // 2) ...to H3
					),
					$html
				);
				break;

		} // /switch


		return $html;

	} // /headings_level_up
} // /NanoSpace_Content

add_action( 'after_setup_theme', 'NanoSpace_Content::init' );
