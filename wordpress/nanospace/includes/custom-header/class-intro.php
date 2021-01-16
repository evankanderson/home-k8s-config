<?php

/**
 * Custom Header / Intro Class
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
 *  10) Setup
 *  20) Output
 *  30) Conditions
 *  40) Assets
 *  50) Special intro
 * 100) Helpers
 */
class NanoSpace_Intro {

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

		self::setup();

		// Actions.
		add_action( 'nanospace_content_top', __CLASS__ . '::container', 15 );
		add_action( 'nanospace_intro_before', __CLASS__ . '::special_wrapper_open', - 10 );
		add_action( 'nanospace_intro_before', __CLASS__ . '::media' );
		add_action( 'nanospace_intro', __CLASS__ . '::content' );
		add_action( 'nanospace_intro_after', __CLASS__ . '::special_wrapper_close', - 10 );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::special_image', 120 );

		// Filters.
		add_filter( 'nanospace_intro_disable', __CLASS__ . '::disable', 5 );
		add_filter( 'theme_mod_header_image', __CLASS__ . '::image', 15 ); // Has to be priority 15 for correct customizer previews.
		add_filter( 'customize_partial_render_' . 'custom_header', __CLASS__ . '::special_image_partial_refresh' );
		add_filter( 'get_header_image_tag', __CLASS__ . '::image_alt_text', 10, 3 );

	} // /__construct

	/**
	 * 10) Setup
	 *
	 * Setup custom header.
	 *
	 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Header
	 * @link  https://make.wordpress.org/core/2016/11/26/video-headers-in-4-7/
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function setup() {

		$image_sizes = array_filter( apply_filters( 'nanospace_setup_image_sizes', array() ) );
		add_theme_support(
			'custom-header',
			apply_filters(
				'nanospace_custom_header_args',
				array(
					'header-text'    => false,
					'width'          => ( isset( $image_sizes['nanospace-intro'] ) ) ? ( $image_sizes['nanospace-intro'][0] ) : ( 1920 ),
					'height'         => ( isset( $image_sizes['nanospace-intro'] ) ) ? ( $image_sizes['nanospace-intro'][1] ) : ( 1080 ),
					'flex-width'     => true,
					'flex-height'    => true,
					'video'          => true,
					'random-default' => true,
				)
			)
		);

		// Default custom headers packed with the theme.
		register_default_headers(
			array(
				'header' => array(
					'url'           => '%s/assets/images/header/header.png',
					'thumbnail_url' => '%s/assets/images/header/thumbnail/header-thumbnail.png',
					'description'   => esc_html_x( 'Header Image', 'Header Sample Image.', 'nanospace' ),
				),
			)
		);

	} // /init

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

	} // /setup

	/**
	 * 20) Output
	 *
	 * Container
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function container() {

		// Pre.
		$disable = (bool) apply_filters( 'nanospace_intro_disable', false );

		$pre = apply_filters( 'nanospace_intro_container_pre', $disable );

		if ( false !== $pre ) {
			if ( true !== $pre ) {
				echo $pre; // Method bypass via filter.
			}

			return;
		}

		get_template_part( 'templates/parts/intro/intro', 'container' );

	} // /container

	/**
	 * Content
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function content() {

		$post_type = ( is_singular() ) ? ( get_post_type() ) : ( '' );
		get_template_part( 'templates/parts/intro/intro-content', $post_type );

	} // /content

	/**
	 * Media
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function media() {

		$post_type = ( is_singular() ) ? ( get_post_type() ) : ( '' );
		get_template_part( 'templates/parts/intro/intro-media', $post_type );

	} // /media

	/**
	 * 30) Conditions
	 *
	 * Disabling conditions
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  boolean $disable
	 */
	public static function disable( $disable = false ) {

		// Check if is_singular() to prevent issues in archives.
		$meta_no_intro = ( is_singular() ) ? ( get_post_meta( get_the_ID(), 'no_intro', true ) ) : ( '' );

		return is_404() || is_attachment() || ! empty( $meta_no_intro );

	} // /disable

	/**
	 * 40) Assets
	 *
	 * Header image URL
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $url Image URL or other custom header value.
	 */
	public static function image( $url ) {

		// Requirements check.
		if ( ! is_singular() && ! is_home() ) {
			return $url;
		}

		$image_size = 'nanospace-intro';
		$post_id    = ( is_home() && ! is_front_page() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

		if ( empty( $post_id ) ) {
			$post_id = get_the_ID();
		}

		$intro_image = trim( get_post_meta( $post_id, 'intro_image', true ) );

		if ( $intro_image ) {

			if ( is_numeric( $intro_image ) ) {
				$url = wp_get_attachment_image_src( absint( $intro_image ), $image_size );
				$url = $url[0];
			} else {
				$url = (string) $intro_image;
			}

		} elseif ( has_post_thumbnail( $post_id ) && ! ( is_home() && is_front_page() ) ) {

			$url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $image_size );
			$url = $url[0];

		} elseif ( ! is_front_page() ) {

			/**
			 * Remove custom header on single post/page if:
			 * - there is no featured image
			 * - there is no intro image
			 *
			 * @link  https://developer.wordpress.org/reference/functions/get_header_image/
			 */
			$url = 'remove-header';

		}

		return $url;

	} // /image

	/**
	 * 50) Special intro
	 *
	 * Front page special intro wrapper: open
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function special_wrapper_open() {

		// Requirements check.
		if ( ! is_front_page() || NanoSpace_Post::is_paged() ) {
			return;
		}

		echo '<div class="intro-special">';

	} // /special_wrapper_open

	/**
	 * Front page special intro wrapper: close
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function special_wrapper_close() {

		// Requirements check.
		if ( ! is_front_page() || NanoSpace_Post::is_paged() ) {
			return;
		}

		echo '</div>';

	} // /special_wrapper_close

	/**
	 * Setting custom header image as an intro background for special intro
	 *
	 * @uses  `nanospace_esc_css` global hook
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function special_image() {

		// Pre.
		$disable = (bool) apply_filters( 'nanospace_intro_disable', false );

		$pre = apply_filters( 'nanospace_intro_special_image_pre', $disable );

		if ( false !== $pre ) {
			if ( true !== $pre ) {
				echo $pre; // Method bypass via filter.
			}

			return;
		}

		if ( $css = self::get_special_image_css() ) {
			wp_add_inline_style(
				'nanospace',
				(string) apply_filters( 'nanospace_esc_css', $css . "\r\n\r\n" )
			);
		}

	} // /special_image

	/**
	 * Get custom header special intro CSS
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function get_special_image_css() {

		// Requirements check.
		if (
			! is_front_page()
			|| NanoSpace_Post::is_paged()
			|| ! $image_url = get_header_image()
		) {
			return;
		}

		return ".intro-special { background-image: url('" . esc_url_raw( $image_url ) . "'); }";

	} // /get_special_image_css

	/**
	 * Output custom image CSS in customizer partial refresh
	 *
	 * Simply replace the last "</div>" (6 characters) with custom HTML output.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function special_image_partial_refresh( $rendered ) {

		return substr( $rendered, 0, - 6 )
		       . '<style>'
		       . '.intro-special { background-image: none; }'
		       . self::get_special_image_css()
		       . '</style>'
		       . '</div>';

	} // /special_image_partial_refresh

	/**
	 * 100) Helpers
	 *
	 * Custom header image alt text fix.
	 *
	 * However, this does not always work. If the image URL is overridden
	 * with `self::image()` above, the attachment ID is different, thus
	 * the alt text could not be applied. This has to be fixed in WP core
	 * or completely redone in theme with custom code...
	 *
	 * @link  https://core.trac.wordpress.org/ticket/46124
	 * @todo  Remove with WordPress 5.2?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function image_alt_text( $html, $header, $attr ) {
		if ( isset( $header->attachment_id ) ) {
			$image_alt = get_post_meta( $header->attachment_id, '_wp_attachment_image_alt', true );
			if (
				! empty( $image_alt )
				&& wp_get_attachment_url( $header->attachment_id ) === $attr['src']
			) {
				$attr['alt'] = $image_alt;
				$html        = '<img';
				foreach ( $attr as $name => $value ) {
					$html .= ' ' . $name . '="' . esc_attr( $value ) . '"';
				}
				$html .= ' />';
			}
		}

		return $html;

	} // /image_alt_text
} // /NanoSpace_Intro

add_action( 'after_setup_theme', 'NanoSpace_Intro::init' );
