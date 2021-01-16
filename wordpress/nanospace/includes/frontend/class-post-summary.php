<?php

/**
 * Post Summary Class
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
 * 10) Excerpt
 * 20) Continue reading
 */
class NanoSpace_Post_Summary {
	/**
	 * 0) Init
	 */

	/**
	 * Initialization.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function init() {
// Filters

		add_filter( 'the_excerpt', 'NanoSpace_Library::remove_shortcodes' );
		add_filter( 'the_excerpt', __CLASS__ . '::excerpt', 20 );

		add_filter( 'get_the_excerpt', __CLASS__ . '::wrap_excerpt', 20 );
		add_filter( 'get_the_excerpt', __CLASS__ . '::continue_reading', 30, 2 );

		add_filter( 'excerpt_length', __CLASS__ . '::excerpt_length' );

		add_filter( 'excerpt_more', __CLASS__ . '::excerpt_more' );

	} // /init
	/**
	 * 10) Excerpt
	 */

	/**
	 * Excerpt
	 *
	 * Displays the excerpt properly.
	 * If the post is password protected, display a message.
	 * If the post has more tag, display the content appropriately.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $excerpt
	 */
	public static function excerpt( $excerpt = '' ) {

		// Variables

		$post_id = get_the_ID();
// Requirements check

		if ( post_password_required( $post_id ) ) {
			if ( ! is_single( $post_id ) ) {
				return esc_html__( 'This content is password protected.', 'nanospace' )
				       . ' <a href="' . esc_url( get_permalink() ) . '">'
				       . esc_html__( 'Enter the password to view it.', 'nanospace' )
				       . '</a>';
			}

			return;
		}
		if (
			! is_single( $post_id )
			&& NanoSpace_Library::has_more_tag()
		) {

			if ( has_excerpt( $post_id ) ) {
				$excerpt = str_replace(
					'entry-summary',
					'entry-summary has-more-tag',
					$excerpt
				);
			} else {
				$excerpt = '';
			}

			$excerpt = apply_filters( 'the_content', $excerpt . get_the_content( '' ) . self::get_continue_reading_html() );

		}


		return $excerpt;

	} // /excerpt

	/**
	 * Get "Continue reading" HTML.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  WP_Post $post Post object.
	 * @param  string $scope Optional identification of specific "Continue reading" text for better filtering.
	 */
	public static function get_continue_reading_html( $post = null, $scope = '' ) {

		// Pre

		$pre = apply_filters( 'nanospace_summary_continue_reading_pre', false, $post, $scope );

		if ( false !== $pre ) {
			return $pre;
		}
// Variables

		$html     = '';
		$scope    = (string) $scope;
		$template = 'templates/parts/component/link-more';
		ob_start();

		if ( $scope && locate_template( $template . '-' . $scope . '.php' ) ) {
			get_template_part( $template, $scope );
		} else {
			get_template_part( $template, get_post_type() );
		}

		/**
		 * Stripping all new line and tab characters to prevent `wpautop()` messing things up later.
		 *
		 * "\t" - a tab.
		 * "\n" - a new line (line feed).
		 * "\r" - a carriage return.
		 * "\x0B" - a vertical tab.
		 */
		$html = str_replace(
			array( "\t", "\n", "\r", "\x0B" ),
			'',
			ob_get_clean()
		);


		return (string) apply_filters( 'nanospace_summary_continue_reading', $html, $post, $scope );

	} // /wrap_excerpt

	/**
	 * Wrap excerpt within a `div.entry-summary`.
	 *
	 * Line breaks are required for proper functionality of `wpautop()` later on.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $post_excerpt
	 */
	public static function wrap_excerpt( $post_excerpt = '' ) {


		return '<div class="entry-summary">' . PHP_EOL . $post_excerpt . PHP_EOL . '</div>';

	} // /excerpt_length

	/**
	 * Excerpt length
	 *
	 * The number of words.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  absint $length
	 */
	public static function excerpt_length( $length ) {

		if ( is_admin() ) {
			return $length;
		}
		return 55;

	} // /excerpt_more
	/**
	 * 20) Continue reading
	 */

	/**
	 * Excerpt more
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $more
	 */
	public static function excerpt_more( $more ) {

		if ( is_admin() ) {
			return $more;
		}
		return '&hellip;';

	} // /continue_reading

	/**
	 * Adding "Continue reading" link to excerpt
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $post_excerpt The post excerpt.
	 * @param  WP_Post $post Post object.
	 */
	public static function continue_reading( $post_excerpt = '', $post = null ) {

		// Variables

		$post_id = get_the_ID();
		if (
			! post_password_required( $post_id )
			&& ! NanoSpace_Post::is_singular( $post_id )
			&& ! NanoSpace_Library::has_more_tag()
			&& in_array(
				get_post_type( $post_id ),
				(array) apply_filters( 'nanospace_summary_continue_reading_post_type', array( 'post', 'page' ) )
			)
		) {
			$post_excerpt .= self::get_continue_reading_html( $post );
		}


		return $post_excerpt;

	} // /get_continue_reading_html
} // /NanoSpace_Post_Summary

add_action( 'after_setup_theme', 'NanoSpace_Post_Summary::init' );
