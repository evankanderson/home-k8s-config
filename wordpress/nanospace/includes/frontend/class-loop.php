<?php

/**
 * Loop Class
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
 *  10) Pagination
 *  20) Search
 *  30) Archives
 * 100) Others
 */
class NanoSpace_Loop {
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

		add_action( 'nanospace_postslist_after', __CLASS__ . '::pagination' );

		add_action( 'nanospace_postslist_before', __CLASS__ . '::search_form' );

		// Filters

		add_filter( 'get_the_archive_description', __CLASS__ . '::archive_author_description' );

		add_filter( 'nanospace_sidebar_disable', __CLASS__ . '::sidebar_disable' );

		add_filter( 'theme_mod_header_image', __CLASS__ . '::intro_image', 20 );

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
	 * 10) Pagination
	 */

	/**
	 * Pagination
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function pagination() {

		// Requirements check

		// Don't display pagination if Jetpack Infinite Scroll in use

		if ( class_exists( 'The_Neverending_Home_Page' ) ) {
			return;
		}


		$output = '';

		$args = (array) apply_filters( 'nanospace_pagination_args', array(
			'prev_text' => esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'nanospace' ) . '<span class="screen-reader-text"> '
			               . esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'nanospace' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'nanospace' )
			               . ' </span>' . esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'nanospace' ),
		), 'loop' );
		if ( $output = paginate_links( $args ) ) {
			global $wp_query;

			$total   = ( isset( $wp_query->max_num_pages ) ) ? ( $wp_query->max_num_pages ) : ( 1 );
			$current = ( get_query_var( 'paged' ) ) ? ( absint( get_query_var( 'paged' ) ) ) : ( 1 );

			$output = '<nav class="pagination" aria-label="' . esc_attr__( 'Posts', 'nanospace' ) . '" data-current="' . esc_attr( $current ) . '" data-total="' . esc_attr( $total ) . '">'
			          . $output
			          . '</nav>';
		}


		echo $output;

	} // /pagination

	/**
	 * Parted post navigation
	 *
	 * Shim for passing the Theme Check review.
	 * Using table of contents generator instead.
	 *
	 * @see  NanoSpace_Library::add_table_of_contents()
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function shim() {


		wp_link_pages();

	} // /shim
	/**
	 * 20) Search
	 */

	/**
	 * Output search form on top of search results page
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function search_form() {

		// Requirements check

		if ( ! is_search() ) {
			return;
		}


		get_search_form( true );

	} // /search_form

	/**
	 * Intro image
	 *
	 * Do not display intro image on search results page.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/get_header_image/
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $url Image URL or other custom header value.
	 */
	public static function intro_image( $url ) {

		// Requirements check

		if ( ! is_search() ) {
			return $url;
		}


		return 'remove-header';

	} // /intro_image
	/**
	 * 30) Archives
	 */

	/**
	 * Author archive description
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $desc
	 */
	public static function archive_author_description( $desc = '' ) {

		// Requirements check

		if ( ! is_author() ) {
			return $desc;
		}


		return apply_filters( 'the_content', get_the_author_meta( 'description' ) );

	} // /archive_author_description
	/**
	 * 100) Others
	 */

	/**
	 * Hide sidebar on minimal posts list layout
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  boolean $disabled
	 */
	public static function sidebar_disable( $disabled = false ) {

		// Requirements check

		if ( ! (
			is_home()
			|| is_category()
			|| is_tag()
			|| is_date()
			|| is_author()
		) ) {
			return $disabled;
		}


		return ( 'minimal' === get_theme_mod( 'blog_style', 'masonry' ) );

	} // /sidebar_disable
} // /NanoSpace_Loop

add_action( 'after_setup_theme', 'NanoSpace_Loop::init' );
