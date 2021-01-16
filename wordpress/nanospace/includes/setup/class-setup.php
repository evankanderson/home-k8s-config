<?php

/**
 * Theme Setup Class
 *
 * Theme options with `__` prefix (`get_theme_mod( '__option_id' )`) are theme
 * setup related options and can not be edited via customizer.
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
 * 10) Setup
 * 20) Globals
 * 30) Images
 * 40) Typography
 * 50) Visual editor
 * 60) Others
 */
class NanoSpace_Setup {
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


		self::nanospace_content_width();
		// Actions

		add_action( 'after_setup_theme', __CLASS__ . '::setup' );

		add_action( 'after_setup_theme', __CLASS__ . '::visual_editor' );

		add_action( 'init', __CLASS__ . '::register_meta' );

		add_action( 'admin_init', __CLASS__ . '::image_sizes_notice' );

		add_filter( 'nanospace_customizer_control_contexts', __CLASS__ . '::add_control_contexts' );
		// Filters

		add_filter( 'nanospace_setup_image_sizes', __CLASS__ . '::image_sizes' );

		add_filter( 'nanospace_assets_google_fonts_url_fonts_setup', __CLASS__ . '::google_fonts' );

		add_filter( 'nanospace_library_editor_custom_mce_format', __CLASS__ . '::visual_editor_formats' );

		add_filter( 'nanospace_is_masonry_layout', __CLASS__ . '::is_masonry' );

		add_filter( 'nanospace_widget_css_classes', __CLASS__ . '::widget_css_classes' );

		add_filter( 'nanospace_esc_css', 'wp_strip_all_tags' );

	} // /__construct

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet
	 *
	 * Priority -100 to make it available to lower priority callbacks.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @global  int $nanospace_content_width
	 */
	public static function nanospace_content_width() {
		$nanospace_content_width = absint( get_theme_mod( 'layout_width_content', 1200 ) );
		$site_width    = absint( get_theme_mod( 'layout_width_site', 1920 ) );

		// Make content width max 88% of site width

		if ( $nanospace_content_width > absint( $site_width * .88 ) ) {
			$nanospace_content_width = absint( $site_width * .88 );
		}

		// Allow filtering

		$GLOBALS['content_width'] = absint( apply_filters( 'nanospace_content_width', $nanospace_content_width ) );

	} // /init
	/**
	 * 10) Setup
	 */

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
	 * 20) Globals
	 */

	/**
	 * Theme setup
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function setup() {


		$image_sizes   = array_filter( (array) apply_filters( 'nanospace_setup_image_sizes', array() ) );
		$editor_styles = array_filter( (array) apply_filters( 'nanospace_setup_editor_stylesheets', array() ) );
		// Localization

		/**
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
		 */
		load_theme_textdomain( 'nanospace', trailingslashit( WP_LANG_DIR ) . 'themes/' . get_template() );

		load_theme_textdomain( 'nanospace', get_stylesheet_directory() . '/languages' );
		load_theme_textdomain( 'nanospace', get_template_directory() . '/languages' );

		// Declare support for child theme stylesheet automatic enqueuing

		add_theme_support( 'child-theme-stylesheet' );

		// Add editor stylesheets

		add_editor_style( $editor_styles );

		// Custom menus

		/**
		 * @see  includes/frontend/class-menu.php
		 */

		// Title tag

		/**
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
		 */
		add_theme_support( 'title-tag' );

		// Site logo

		/**
		 * @link  https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo' );

		// Feed links

		/**
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
		 */
		add_theme_support( 'automatic-feed-links' );

		// Enable HTML5 markup

		/**
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
		 */
		add_theme_support( 'html5', array(
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form',
		) );

		// Custom header

		/**
		 * @see  includes/custom-header/class-intro.php
		 */

		// Custom background

		/**
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Background
		 */
		add_theme_support( 'custom-background', apply_filters( 'nanospace_setup_custom_background_args', array(
			'default-color' => 'ffffff',
		) ) );

		// Post formats

		/**
		 * @see  includes/frontend/class-post-media.php
		 */

		// Thumbnails support

		/**
		 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails', array( 'attachment:audio', 'attachment:video' ) );
		add_theme_support( 'post-thumbnails' );

		// Image sizes (x, y, crop)

		if ( ! empty( $image_sizes ) ) {
			foreach ( $image_sizes as $size => $setup ) {
				if ( ! in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
					add_image_size(
						$size,
						$image_sizes[ $size ][0],
						$image_sizes[ $size ][1],
						$image_sizes[ $size ][2]
					);
				}
			}
		}

	} // /content_width
	/**
	 * 30) Images
	 */

	/**
	 * Image sizes
	 *
	 * @example
	 *
	 *   $image_sizes = array(
	 *     'image_size_id' => array(
	 *       absint( width ),
	 *       absint( height ),
	 *       (bool) cropped?,
	 *       (string) optional_theme_usage_explanation_text
	 *     )
	 *   );
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $image_sizes
	 */
	public static function image_sizes( $image_sizes = array() ) {


		global $nanospace_content_width;

		// Intro image size

		if ( 'boxed' === get_theme_mod( 'layout_site', 'boxed' ) ) {

			$intro_width = absint( get_theme_mod( 'layout_width_site', 1920 ) );

			if ( 1000 > $intro_width ) {
				// Can't set site width less then 1000 px,
				// so default to max boxed site width then.
				$intro_width = 1920;
			}

		} else {

			$intro_width = 1920;

		}
		$image_sizes = array(

			'thumbnail' => array(
				480,
				absint( 480 * 9 / 16 ),
				true,
				esc_html__( 'In shortcodes and page builder modules.', 'nanospace' ),
			),

			'medium' => array(
				absint( $nanospace_content_width * .62 ),
				0,
				false,
				esc_html__( 'As featured image preview on single post page.', 'nanospace' ) . '<br>' .
				esc_html__( 'In Projects.', 'nanospace' ) . '<br>' .
				esc_html__( 'In Staff posts.', 'nanospace' ) . '<br>' .
				esc_html__( 'In list of child pages.', 'nanospace' ),
			),

			'large'        => array(
				absint( $nanospace_content_width ),
				0,
				false,
				esc_html__( 'Not used in the theme.', 'nanospace' ),
			),

			/**
			 * @since 1.0.0
			 */
			'medium_large' => array(
				absint( $nanospace_content_width ),
				0,
				false,
				esc_html__( 'This is WordPress native image size.', 'nanospace' ) . '<br>' .
				esc_html__( 'Not used in the theme.', 'nanospace' ),
			),

			'nanospace-thumbnail' => array(
				absint( $nanospace_content_width * .62 ),
				absint( $nanospace_content_width * .62 / 2 ),
				true,
				esc_html__( 'In posts list.', 'nanospace' ),
			),

			'nanospace-square' => array(
				448,
				448,
				true,
				esc_html__( 'In Testimonials.', 'nanospace' ),
			),

			'nanospace-intro' => array(
				absint( $intro_width ),
				absint( 9 * $intro_width / 16 ),
				true,
				esc_html__( 'In page intro section.', 'nanospace' ),
			),

		);


		return $image_sizes;

	} // /image_sizes

	/**
	 * Register recommended image sizes notice
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function image_sizes_notice() {
		add_settings_field(
			'recommended-image-sizes',
			'',
			__CLASS__ . '::image_sizes_notice_html',
			'media',
			'default',
			array()
		);

		register_setting(
			'media',
			'recommended-image-sizes',
			'esc_attr'
		);

	} // /image_sizes_notice

	public static function add_control_contexts( $nanospace_contexts = array() ) {
		include( NANOSPACE_PATH_INCLUDES . '/customize/contexts.php' );

		return $nanospace_contexts;
	}

	/**
	 * Display recommended image sizes notice
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function image_sizes_notice_html() {
		get_template_part( 'templates/parts/admin/media', 'image-sizes' );

	} // /image_sizes_notice_html
	/**
	 * 40) Typography
	 */

	/**
	 * Google Fonts
	 *
	 * Custom fonts setup left for plugins.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $fonts_setup
	 */
	public static function google_fonts( $fonts_setup ) {

		// Requirements check

		if ( get_theme_mod( 'typography_custom_fonts', false ) ) {
			return array();
		}


		$fonts_setup = array();
		/**
		 * translators: Do not translate into your own language!
		 * If there are characters in your language that are not
		 * supported by the font, translate this to 'off'.
		 * The font will not load then.
		 */
		if ( 'off' !== esc_html_x( 'on', 'Fira Sans font: on or off', 'nanospace' ) ) {
			$fonts_setup[] = 'Fira+Sans:100,300,400,700,900';
		}


		return $fonts_setup;

	} // /google_fonts
	/**
	 * 50) Visual editor
	 */

	/**
	 * Include Visual Editor (TinyMCE) setup
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function visual_editor() {
		if (
			is_admin()
			|| isset( $_GET['fl_builder'] )
		) {

			require_once NANOSPACE_LIBRARY . 'includes/classes/class-visual-editor.php';

		}

	} // /visual_editor

	/**
	 * TinyMCE "Formats" dropdown alteration
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $formats
	 */
	public static function visual_editor_formats( $formats ) {

		// Requirements check

		global $post;

		if ( ! isset( $post ) ) {
			return $formats;
		}
// Font weight classes

		$font_weights = array(

			// Font weight names from https://developer.mozilla.org/en/docs/Web/CSS/font-weight

			100 => esc_html__( 'Thin (hairline) text', 'nanospace' ),
			200 => esc_html__( 'Extra light text', 'nanospace' ),
			300 => esc_html__( 'Light text', 'nanospace' ),
			400 => esc_html__( 'Normal weight text', 'nanospace' ),
			500 => esc_html__( 'Medium text', 'nanospace' ),
			600 => esc_html__( 'Semi bold text', 'nanospace' ),
			700 => esc_html__( 'Bold text', 'nanospace' ),
			800 => esc_html__( 'Extra bold text', 'nanospace' ),
			900 => esc_html__( 'Heavy text', 'nanospace' ),

		);

		$formats[ 250 . 'text_weights' ] = array(
			'title' => esc_html__( 'Text weights', 'nanospace' ),
			'items' => array(),
		);

		foreach ( $font_weights as $weight => $name ) {

			$formats[ 250 . 'text_weights' ]['items'][ 250 . 'text_weights' . $weight ] = array(
				'title'    => $name . ' (' . $weight . ')',
				'selector' => 'p, h1, h2, h3, h4, h5, h6, address, blockquote',
				'classes'  => 'weight-' . $weight,
			);

		} // /foreach

		// Font classes

		$formats[ 260 . 'font' ] = array(
			'title' => esc_html__( 'Fonts', 'nanospace' ),
			'items' => array(

				100 . 'font' . 100 => array(
					'title'    => esc_html__( 'General font', 'nanospace' ),
					'selector' => 'p, h1, h2, h3, h4, h5, h6, address, blockquote',
					'classes'  => 'font-body',
				),

				100 . 'font' . 110 => array(
					'title'    => esc_html__( 'Headings font', 'nanospace' ),
					'selector' => 'p, h1, h2, h3, h4, h5, h6, address, blockquote',
					'classes'  => 'font-headings',
				),

				100 . 'font' . 120 => array(
					'title'    => esc_html__( 'Logo font', 'nanospace' ),
					'selector' => 'p, h1, h2, h3, h4, h5, h6, address, blockquote',
					'classes'  => 'font-logo',
				),

				100 . 'font' . 130 => array(
					'title'    => esc_html__( 'Inherit font', 'nanospace' ),
					'selector' => 'p, h1, h2, h3, h4, h5, h6, address, blockquote',
					'classes'  => 'font-inherit',
				),

			),
		);

		// Columns styles

		$formats[ 400 . 'columns' ] = array(
			'title' => esc_html__( 'Columns', 'nanospace' ),
			'items' => array(),
		);

		for ( $i = 2; $i <= 3; $i ++ ) {

			$formats[ 400 . 'columns' ]['items'][ 400 . 'columns' . ( 100 + 10 * $i ) ] = array(
				'title'   => sprintf( esc_html( _nx( 'Text in %d column', 'Text in %d columns', $i, '%d: Number of columns.', 'nanospace' ) ), $i ),
				'classes' => 'text-columns-' . $i,
				'block'   => 'div',
				'wrapper' => true,
			);

		}

		// Buttons

		$formats[ 500 . 'buttons' ] = array(
			'title' => esc_html__( 'Buttons', 'nanospace' ),
			'items' => array(

				500 . 'buttons' . 100 => array(
					'title'    => esc_html__( 'Button from link', 'nanospace' ),
					'selector' => 'a',
					'classes'  => 'button',
				),

				500 . 'buttons' . 110 => array(
					'title'    => esc_html__( 'Button from link, small', 'nanospace' ),
					'selector' => 'a',
					'classes'  => 'button size-small',
				),

				500 . 'buttons' . 120 => array(
					'title'    => esc_html__( 'Button from link, large', 'nanospace' ),
					'selector' => 'a',
					'classes'  => 'button size-large',
				),

				500 . 'buttons' . 130 => array(
					'title'    => esc_html__( 'Button from link, extra large', 'nanospace' ),
					'selector' => 'a',
					'classes'  => 'button size-extra-large',
				),

			),
		);

		// Outdent styles

		$formats[ 600 . 'media' ] = array(
			'title' => esc_html__( 'Outdent', 'nanospace' ),
			'items' => array(

				600 . 'media' . 100 => array(
					'title'   => esc_html__( 'Outdent selected content', 'nanospace' ),
					'classes' => 'outdent-content',
					'block'   => 'div',
					'wrapper' => true,
				),

			),
		);

		if ( 'page' === get_post_type( $post ) ) {

			$formats[ 600 . 'media' ]['items'][ 600 . 'media' . 110 ] = array(
				'title'    => esc_html__( 'Outdented heading style', 'nanospace' ),
				'selector' => 'p, h1, h2, h3, h4, h5, h6',
				'classes'  => 'outdent-heading',
			);

		}


		return $formats;

	} // /visual_editor_formats
	/**
	 * 60) Others
	 */

	/**
	 * Register post meta
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function register_meta() {
		register_meta( 'post', 'show_intro_widgets', 'absint' );
		register_meta( 'post', 'no_intro', 'absint' );
		register_meta( 'post', 'no_intro_media', 'absint' );
		register_meta( 'post', 'no_thumbnail', 'absint' );
		register_meta( 'post', 'content_layout', 'esc_attr' );
		register_meta( 'post', 'intro_image', 'esc_attr' );

	} // /register_meta

	/**
	 * When to use masonry posts layout?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function is_masonry() {


		$is_masonry_blog = ( 'masonry' === get_theme_mod( 'blog_style', 'masonry' ) );
		$is_masonry_blog = $is_masonry_blog && ( is_home() || is_category() || is_tag() || is_date() || is_author() );


		return $is_masonry_blog || is_search();

	} // /is_masonry

	/**
	 * Widget CSS classes
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $classes
	 */
	public static function widget_css_classes( $classes = array() ) {
		$classes = array_merge( (array) $classes, array(
			'hide-widget-title-accessibly',
			'hide-widget-title',
			'set-flex-grow-2',
			'set-flex-grow-3',
			'set-flex-grow-4',
		) );


		return $classes;

	} // /widget_css_classes
} // /NanoSpace_Setup

add_action( 'after_setup_theme', 'NanoSpace_Setup::init', - 100 ); // Low priority for early $nanospace_content_width setup
