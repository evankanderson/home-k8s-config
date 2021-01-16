<?php

/**
 * Footer Class
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
 *  10) Site footer
 *  20) Body ending
 * 100) Others
 */
class NanoSpace_Footer {
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

		add_action( 'nanospace_footer_top', __CLASS__ . '::open', 1 );

		add_action( 'nanospace_footer_bottom', __CLASS__ . '::site_info', 100 );

		add_action( 'nanospace_footer_bottom', __CLASS__ . '::close', 101 );

		add_action( 'nanospace_body_bottom', __CLASS__ . '::site_close', 100 );

		// Filters

		add_filter( 'nanospace_library_link_skip_to_pre', __CLASS__ . '::skip_links_no_footer', 10, 2 );

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
	 * 10) Site footer
	 *
	 * Footer widgets:
	 * @see  includes/frontend/class-sidebar.php
	 *
	 * Footer menu:
	 * @see  includes/frontend/class-menu.php
	 */

	/**
	 * Footer: Open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function open() {


		$layout = nanospace_get_theme_mod( 'nanospace_section_header_layout_select' );

		if ( $layout == 'standard-header' ) {
			echo "\r\n\r\n" . '<footer id="colophon" class="site-footer" role="contentinfo">' . "\r\n\r\n";
		} elseif ( $layout == 'left-header' ) {
			echo "\r\n\r\n" . '<footer id="colophon" class="site-footer footer-left-header" role="contentinfo">' . "\r\n\r\n";
		} elseif ( $layout == 'right-header' ) {
			echo "\r\n\r\n" . '<footer id="colophon" class="site-footer footer-right-header" role="contentinfo">' . "\r\n\r\n";
		}
	} // /open

	/**
	 * Footer: Close
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function close() {


		echo "\r\n\r\n" . '</footer>' . "\r\n\r\n";

	} // /close

	/**
	 * Site info
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function site_info() {

		nanospace_footer_widgets();

		if ( ! intval( nanospace_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
			nanospace_footer_top();
		}
		// Bottom Bar (if not merged)
		if ( ! intval( nanospace_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
			nanospace_footer_bottom();
		}
		//get_template_part( 'templates/parts/footer/site', 'info' );

	} // /site_info
	/**
	 * 20) Body ending
	 */

	/**
	 * Site container: Close
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function site_close() {

		echo "\r\n" . '</div><!-- /#page -->' . "\r\n\r\n";

	} // /site_close
	/**
	 * 100) Others
	 */

	/**
	 * Is footer enabled?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function is_enabled() {


		return (bool) apply_filters( 'nanospace_footer_is_enabled', absint(nanospace_get_theme_mod( 'nanospace_footer_enable' )) ? 1 : 0 );

	} // /is_disabled

	/**
	 * Is footer disabled?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function is_disabled() {


		return (bool) apply_filters( 'nanospace_footer_is_disabled', absint(nanospace_get_theme_mod( 'nanospace_footer_enable' )) ? 0 : 1 );

	} // /is_enabled

	/**
	 * Skip links: Remove footer related links.
	 *
	 * When we display no footer, remove all related skip links.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $pre Pre output.
	 * @param  string $id Link target element ID.
	 */
	public static function skip_links_no_footer( $pre, $id ) {
		if (
			(bool) apply_filters( 'nanospace_skip_links_no_footer', self::is_disabled() )
			&& in_array( $id, array( 'colophon' ) )
		) {
			$pre = '';
		}


		return $pre;

	} // /skip_links_no_footer
} // /NanoSpace_Footer

add_action( 'after_setup_theme', 'NanoSpace_Footer::init' );
