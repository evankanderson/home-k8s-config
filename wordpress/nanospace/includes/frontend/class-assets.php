<?php

/**
 * Assets Class
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
 * 10) Register
 * 20) Enqueue
 * 30) Typography
 * 40) Setup
 */
class NanoSpace_Assets {
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

		add_action( 'wp_enqueue_scripts', __CLASS__ . '::register_inline_styles', 0 );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::register_styles' );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::register_scripts' );

		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_styles', 100 );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_inline_styles', 105 );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_theme_stylesheet', 110 );
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::enqueue_scripts', 100 );

		add_action( 'customize_preview_init', __CLASS__ . '::enqueue_customize_preview' );

		add_action( 'comment_form_before', __CLASS__ . '::enqueue_comments_reply' );

		// Filters

		add_filter( 'wp_resource_hints', __CLASS__ . '::resource_hints', 10, 2 );

		add_filter( 'nanospace_setup_editor_stylesheets', __CLASS__ . '::editor_stylesheets' );

		add_filter( 'editor_stylesheets', __CLASS__ . '::editor_frontend_stylesheets' );

		if ( ! ( current_theme_supports( 'jetpack-responsive-videos' ) && function_exists( 'jetpack_responsive_videos_init' ) ) ) {
			add_filter( 'embed_handler_html', __CLASS__ . '::enqueue_fitvids' );
			add_filter( 'embed_oembed_html', __CLASS__ . '::enqueue_fitvids' );
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
	 * 10) Register
	 */

	/**
	 * Registering theme styles
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function register_styles() {


		$min             = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$register_assets = array(
			'genericons-neue'                 => array( 'src' => get_theme_file_uri( 'assets/fonts/genericons-neue/genericons-neue.css' ) ),
			'nanospace-google-fonts'          => array( 'src' => self::google_fonts_url() ),
			'nanospace-stylesheet-main'       => array(
				'src' => get_theme_file_uri( 'assets/css/main.css' ),
				'rtl' => 'replace'
			),
			'nanospace-header-footer-builder' => array(
				'src' => get_theme_file_uri( 'assets/css/header-main.css' ),
				'rtl' => 'replace'
			),
			'nanospace-stylesheet-shortcodes' => array(
				'src' => get_theme_file_uri( 'assets/css/shortcodes.css' ),
				'rtl' => 'replace'
			),
			'nanospace-stylesheet-custom' => array( 'src' => get_theme_file_uri( 'assets/css/custom-styles.css' ) ),

			'nanospace-stylesheet-global' => array(
				'src'  => '',
				'deps' => array(
					'nanospace-stylesheet-main',
					'nanospace-stylesheet-shortcodes',
					'nanospace-stylesheet-custom',
				)
			),

			'nanospace-stylesheet-print' => array(
				'src'   => get_theme_file_uri( 'assets/css/print.css' ),
				'media' => 'print',
				'rtl'   => 'replace'
			),
		);

		$register_assets = (array) apply_filters( 'nanospace_assets_register_styles', $register_assets );
		foreach ( $register_assets as $handle => $atts ) {

			$src   = ( isset( $atts['src'] ) ) ? ( $atts['src'] ) : ( $atts[0] );
			$deps  = ( isset( $atts['deps'] ) ) ? ( $atts['deps'] ) : ( false );
			$ver   = ( isset( $atts['ver'] ) ) ? ( $atts['ver'] ) : ( NANOSPACE_THEME_VERSION );
			$media = ( isset( $atts['media'] ) ) ? ( $atts['media'] ) : ( 'screen' );

			wp_register_style( $handle, $src, $deps, $ver, $media );

			if ( isset( $atts['rtl'] ) && $atts['rtl'] ) {
				wp_style_add_data( $handle, 'rtl', $atts['rtl'] );
			}

		}

	} // /register_styles

	/**
	 * Get Google Fonts link
	 *
	 * Returns a string such as:
	 * http://fonts.googleapis.com/css?family=Alegreya+Sans:300,400|Exo+2:400,700|Allan&subset=latin,latin-ext
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $fonts Fallback fonts.
	 */
	public static function google_fonts_url( $fonts = array() ) {

		// Pre

		$pre = apply_filters( 'nanospace_assets_google_fonts_url_pre', false, $fonts );

		if ( false !== $pre ) {
			return $pre;
		}
// Variables

		$output = '';
		$family = array();
		$subset = ( 'sk_SK' !== get_locale() ) ? ( array( 'latin' ) ) : ( array( 'latin', 'latin-ext' ) );
		$subset = (array) apply_filters( 'nanospace_assets_google_fonts_url_subset', $subset );

		$fonts_setup = array_filter( (array) apply_filters( 'nanospace_assets_google_fonts_url_fonts_setup', array() ) );

		if ( empty( $fonts_setup ) && ! empty( $fonts ) ) {
			$fonts_setup = (array) $fonts;
		}

		$url_base = NanoSpace_Library::fix_ssl_urls( 'http://fonts.googleapis.com/css' );
// Requirements check

		if ( empty( $fonts_setup ) ) {
			return $output;
		}
		foreach ( $fonts_setup as $section ) {

			$font = trim( $section );

			if ( $font ) {
				$family[] = str_replace( ' ', '+', $font );
			}

		} // /foreach

		if ( ! empty( $family ) ) {

			$output = esc_url_raw( add_query_arg( array( // Use `esc_url_raw()` for HTTP requests.
				'family' => implode( '|', (array) array_unique( $family ) ),
				'subset' => implode( ',', (array) $subset ),
				// Subset can be array if multiselect Customizer input field used
			), $url_base ) );

		}


		return $output;

	} // /register_scripts
	/**
	 * 20) Enqueue
	 */

	/**
	 * Registering theme scripts
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function register_scripts() {


		$script_global_deps = ( ! ( current_theme_supports( 'jetpack-responsive-videos' ) && function_exists( 'jetpack_responsive_videos_init' ) ) ) ? ( array( 'jquery-fitvids' ) ) : ( array( 'jquery' ) );

		$register_assets = array(
			'jquery-fitvids'                   => array( get_theme_file_uri( 'assets/js/jquery.fitvids.js' ) ),
			'jquery-scroll-watch'              => array( get_theme_file_uri( 'assets/js/jquery.scroll-watch.js' ) ),
			'nanospace-skip-link-focus-fix'    => array(
				'src'  => get_theme_file_uri( 'assets/js/skip-link-focus-fix.js' ),
				'deps' => array()
			),
			'nanospace-scripts-global'         => array(
				'src'  => get_theme_file_uri( 'assets/js/scripts-global.js' ),
				'deps' => $script_global_deps
			),
			'nanospace-scripts-masonry'        => array(
				'src'  => get_theme_file_uri( 'assets/js/scripts-masonry.js' ),
				'deps' => array( 'jquery-masonry' )
			),
			'nanospace-scripts'       => array( get_theme_file_uri( 'assets/js/scripts-navigation.js' ) ),
			'nanospace-scripts-main-header-js' => array( 'src' => get_theme_file_uri( 'assets/js/main.js' ) ),

		);

		$register_assets = (array) apply_filters( 'nanospace_assets_register_scripts', $register_assets );
		foreach ( $register_assets as $handle => $atts ) {

			$src       = ( isset( $atts['src'] ) ) ? ( $atts['src'] ) : ( $atts[0] );
			$deps      = ( isset( $atts['deps'] ) ) ? ( $atts['deps'] ) : ( array( 'jquery' ) );
			$ver       = ( isset( $atts['ver'] ) ) ? ( $atts['ver'] ) : ( NANOSPACE_THEME_VERSION );
			$in_footer = ( isset( $atts['in_footer'] ) ) ? ( $atts['in_footer'] ) : ( true );

			wp_register_script( $handle, $src, $deps, $ver, $in_footer );

		} // /foreach

	} // /enqueue_styles

	/**
	 * Frontend styles enqueue
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function enqueue_styles() {


		$enqueue_assets = array();
		// Google Fonts

		if ( self::google_fonts_url() ) {
			$enqueue_assets[0] = 'nanospace-google-fonts';
		}

		// Genericons Neue
		$enqueue_assets[5] = 'genericons-neue';

		// Main
		$enqueue_assets[10] = 'nanospace-stylesheet-global';

		// Print
		$enqueue_assets[100] = 'nanospace-stylesheet-print';

		// Filter enqueue array
		$enqueue_assets = (array) apply_filters( 'nanospace_assets_enqueue_styles', $enqueue_assets );

		// Enqueue
		ksort( $enqueue_assets );

		foreach ( $enqueue_assets as $handle ) {
			wp_enqueue_style( $handle );
		}

	} // /enqueue_scripts

	/**
	 * Frontend scripts enqueue
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function enqueue_scripts() {


		$enqueue_assets = array();

		$body_classes = (array) NanoSpace_Header::body_class();

		$breakpoints = (array) apply_filters( 'nanospace_assets_enqueue_scripts_breakpoints', array(
			's'     => 448,
			'm'     => 672,
			'l'     => 880,
			'xl'    => 1280,
			'xxl'   => 1600,
			'xxxl'  => 1920,
			'xxxxl' => 2560,
		) );
// Skip link focus fix

		$enqueue_assets[10] = 'nanospace-skip-link-focus-fix';

		// Navigation scripts

		if ( NanoSpace_Header::is_enabled() ) {
			$enqueue_assets[20] = 'nanospace-scripts';
		}

		// Sticky header

		if ( in_array( 'has-sticky-header', $body_classes ) ) {
			$enqueue_assets[30] = 'jquery-scroll-watch';
		}

		// Masonry

		if ( (bool) apply_filters( 'nanospace_is_masonry_layout', false ) ) {
			$enqueue_assets[40] = 'nanospace-scripts-masonry';
		}

		// Global theme scripts

		$enqueue_assets[100] = 'nanospace-scripts-global';
		$enqueue_assets[200] = 'jquery-scroll';

		//Header Footer js

		$enqueue_assets[300] = 'nanospace-scripts-main-header-js';
		// Filter enqueue array

		$enqueue_assets = (array) apply_filters( 'nanospace_assets_enqueue_scripts', $enqueue_assets );

		// Pass CSS breakpoint into JS (from `assets/scss/_setup.scss`)

		if ( ! empty( $breakpoints ) ) {
			wp_localize_script(
				'nanospace-skip-link-focus-fix',
				'$nanospaceBreakpoints',
				$breakpoints
			);
		}

		// Enqueue

		ksort( $enqueue_assets );

		foreach ( $enqueue_assets as $handle ) {
			wp_enqueue_script( $handle );
		}

	} // /enqueue_theme_stylesheet

	/**
	 * Enqueue theme `style.css` file late
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function enqueue_theme_stylesheet() {
		if ( is_child_theme() ) {
			wp_enqueue_style(
				'nanospace-stylesheet',
				get_stylesheet_uri()
			);
		}

	} // /register_inline_styles

	/**
	 * Placeholder for adding inline styles: register.
	 *
	 * This should be loaded after all of the theme stylesheets are enqueued,
	 * and before the child theme stylesheet is enqueued.
	 * Use the `nanospace` handle in `wp_add_inline_style`.
	 * Early registration is required!
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function register_inline_styles() {
		wp_register_style( 'nanospace', '' );

	} // /enqueue_inline_styles

	/**
	 * Placeholder for adding inline styles: enqueue.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function enqueue_inline_styles() {
		wp_enqueue_style( 'nanospace' );

	} // /enqueue_customize_preview

	/**
	 * Customizer preview assets enqueue
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function enqueue_customize_preview() {
// Styles

		if ( file_exists( get_theme_file_path( 'assets/css/customize-preview.css' ) ) ) {

			wp_enqueue_style(
				'nanospace-customize-preview',
				get_theme_file_uri( 'assets/css/customize-preview.css' ),
				array(),
				esc_attr( trim( NANOSPACE_THEME_VERSION ) ),
				'screen'
			);

		}

	} // /enqueue_comments_reply

	/**
	 * Enqueue `comment-reply.js` the right way
	 *
	 * @link  http://wpengineer.com/2358/enqueue-comment-reply-js-the-right-way/
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function enqueue_comments_reply() {
		if (
			is_singular()
			&& comments_open()
			&& get_option( 'thread_comments' )
		) {
			wp_enqueue_script( 'comment-reply' );
		}

	} // /enqueue_fitvids
	/**
	 * 30) Typography
	 */

	/**
	 * Enqueues FitVids only when needed
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $html The generated HTML of the shortcodes
	 */
	public static function enqueue_fitvids( $html ) {

		// Requirements check

		if (
			is_admin()
			|| empty( $html )
			|| ! is_string( $html )
		) {
			return $html;
		}
		wp_enqueue_script( 'jquery-fitvids' );


		return $html;

	} // /google_fonts_url
	/**
	 * 40) Setup
	 */

	/**
	 * Editor stylesheets array
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function editor_stylesheets() {

		$stylesheet_suffix = '';
		if ( is_rtl() ) {
			$stylesheet_suffix .= '-rtl';
		}

		$visual_editor_stylesheets = array();
		// Google Fonts stylesheet

		$visual_editor_stylesheets[0] = str_replace( ',', '%2C', self::google_fonts_url() );

		// Genericons Neue

		$content_editor_stylesheets[5] = get_theme_file_uri( 'assets/fonts/genericons-neue/genericons-neue.css' );

		// Editor stylesheet

		$visual_editor_stylesheets[10] = esc_url_raw( add_query_arg(
			'ver',
			NANOSPACE_THEME_VERSION,
			get_theme_file_uri( 'assets/css/main' . $stylesheet_suffix . '.css' )
		) );

		$visual_editor_stylesheets[15] = esc_url_raw( add_query_arg(
			'ver',
			NANOSPACE_THEME_VERSION,
			get_theme_file_uri( 'assets/css/editor-style' . $stylesheet_suffix . '.css' )
		) );

		$visual_editor_stylesheets[20] = esc_url_raw( add_query_arg(
			'ver',
			NANOSPACE_THEME_VERSION,
			get_theme_file_uri( 'assets/css/custom-styles-editor.css' )
		) );

		// Icons stylesheet

		if ( class_exists( 'WM_Icons' ) && $icons_font_stylesheet = get_option( 'wmamp-icon-font' ) ) {
			$visual_editor_stylesheets[100] = esc_url_raw( $icons_font_stylesheet );
		}

		// Filter and order

		$visual_editor_stylesheets = (array) apply_filters( 'nanospace_assets_editor', $visual_editor_stylesheets );

		ksort( $visual_editor_stylesheets );


		return $visual_editor_stylesheets;

	} // /editor_stylesheets

	/**
	 * Load editor styles for any frontend editor
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function editor_frontend_stylesheets( $stylesheets ) {

		// Requirements check

		if ( is_admin() ) {
			return $stylesheets;
		}


		return array_merge(
			(array) $stylesheets,
			array_filter( (array) apply_filters( 'nanospace_setup_editor_stylesheets', array() ) )
		);

	} // /editor_frontend_stylesheets

	/**
	 * Add preconnect for Google Fonts
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $urls URLs to print for resource hints.
	 * @param  string $relation_type The relation type the URLs are printed.
	 */
	public static function resource_hints( $urls, $relation_type ) {

		// Variables

		$url_fonts = NanoSpace_Library::fix_ssl_urls( 'http://fonts.gstatic.com' );
		if (
			wp_style_is( 'nanospace-google-fonts', 'queue' )
			&& 'preconnect' === $relation_type
		) {

			if ( version_compare( $GLOBALS['wp_version'], '4.7', '>=' ) ) {

				$urls[] = array(
					'href' => $url_fonts,
					'crossorigin',
				);

			} else {

				$urls[] = $url_fonts;

			}

		}


		return $urls;

	} // /resource_hints
} // /NanoSpace_Assets

add_action( 'after_setup_theme', 'NanoSpace_Assets::init' );
