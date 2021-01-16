<?php

/**
 * Visual Editor class
 *
 * This is a helper class and does not load automatically with the library.
 * Load it directly from within your theme's `functions.php` file.
 *
 * @package     Labinator NanoSpace WordPress Theme Framework
 * @subpackage  Visual Editor
 *
 * @since 1.0.0
 * @version 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Buttons
 * 20) Custom formats
 * 30) Body class
 */
final class NanoSpace_Library_Visual_Editor {
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
	// Actions.

		// Editor body class on page template change.

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', __CLASS__ . '::scripts_post_edit', 1000 );
		}

		// Filters.

		// Editor body class.

		if ( is_admin() ) {
			add_filter( 'tiny_mce_before_init', __CLASS__ . '::body_class' );
		}

		// Editor addons.

		add_filter( 'mce_buttons', __CLASS__ . '::add_buttons_row1' );

		add_filter( 'mce_buttons_2', __CLASS__ . '::add_buttons_row2' );

		add_filter( 'tiny_mce_before_init', __CLASS__ . '::custom_mce_format' );

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
	 * 10) Buttons
	 */

	/**
	 * Add buttons to visual editor
	 *
	 * First row.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $buttons
	 */
	public static function add_buttons_row1( $buttons ) {

		// Pre.

		$pre = apply_filters( 'nanospace_library_editor_add_buttons_row1_pre', false, $buttons );

		if ( false !== $pre ) {
			return $pre;
		}

		// Inserting buttons after "more" button.

		$pos = array_search( 'wp_more', $buttons, true );

		if ( false !== $pos ) {
			$add     = array_slice( $buttons, 0, $pos + 1 );
			$add[]   = 'wp_page';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		return $buttons;

	} // /add_buttons_row1

	/**
	 * Add buttons to visual editor
	 *
	 * Second row.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $buttons
	 */
	public static function add_buttons_row2( $buttons ) {

		// Pre.
		$pre = apply_filters( 'nanospace_library_editor_add_buttons_row2_pre', false, $buttons );

		if ( false !== $pre ) {
			return $pre;
		}

		// Inserting buttons at the beginning of the row.
		array_unshift( $buttons, 'styleselect' );

		return $buttons;

	} // /add_buttons_row2
	/**
	 * 20) Custom formats
	 */

	/**
	 * Customizing format dropdown items
	 *
	 * @link  http://codex.wordpress.org/TinyMCE_Custom_Styles
	 * @link  http://www.tinymce.com/wiki.php/Configuration:style_formats
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $init
	 */
	public static function custom_mce_format( $init ) {

		// Pre.
		$pre = apply_filters( 'nanospace_library_editor_custom_mce_format_pre', false, $init );

		if ( false !== $pre ) {
			return $pre;
		}

		// Add custom formats.
		$style_formats = (array) apply_filters( 'nanospace_library_editor_custom_mce_format', array(

			// Group: Text styles.

			100 . 'text_styles' => array(
				'title' => esc_html__( 'Text styles', 'nanospace' ),
				'items' => array(

					100 . 'text_styles' . 100 => array(
						'title'    => esc_html__( 'Dropcap text', 'nanospace' ),
						'selector' => 'p',
						'classes'  => 'dropcap-text',
					),

					100 . 'text_styles' . 110 => array(
						'title'    => esc_html__( 'Uppercase heading or paragraph', 'nanospace' ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6, address',
						'classes'  => 'uppercase',
					),

					100 . 'text_styles' . 120 => array(
						'title'  => esc_html__( 'Highlighted (marked) text', 'nanospace' ),
						'inline' => 'mark',
						'icon'   => ( is_admin() ) ? ( 'backcolor' ) : ( '' ),
					),

					100 . 'text_styles' . 130 => array(
						'title'  => esc_html__( 'Small text', 'nanospace' ),
						'inline' => 'small',
					),

					100 . 'text_styles' . 140 => array(
						'title'  => esc_html__( 'Superscript', 'nanospace' ),
						'icon'   => ( is_admin() ) ? ( 'superscript' ) : ( '' ),
						'format' => 'superscript',
					),

					100 . 'text_styles' . 150 => array(
						'title'  => esc_html__( 'Subscript', 'nanospace' ),
						'icon'   => ( is_admin() ) ? ( 'subscript' ) : ( '' ),
						'format' => 'subscript',
					),

					100 . 'text_styles' . 160 => array(
						'title'    => sprintf( esc_html_x( 'Heading %d text style', '%d = HTML heading size number.', 'nanospace' ), 1 ),
						'selector' => 'h2, h3, h4, h5, h6, p, address',
						'classes'  => 'h1',
					),

					100 . 'text_styles' . 170 => array(
						'title'    => sprintf( esc_html_x( 'Heading %d text style', '%d = HTML heading size number.', 'nanospace' ), 2 ),
						'selector' => 'h3, h4, h5, h6, h1, p, address',
						'classes'  => 'h2',
					),

					100 . 'text_styles' . 180 => array(
						'title'    => sprintf( esc_html_x( 'Heading %d text style', '%d = HTML heading size number.', 'nanospace' ), 3 ),
						'selector' => 'h4, h5, h6, h1, h2, p, address',
						'classes'  => 'h3',
					),

				),
			),

			// Group: Text size.

			200 . 'text_sizes' => array(
				'title' => esc_html__( 'Text sizes', 'nanospace' ),
				'items' => array(

					200 . 'text_sizes' . 100 => array(
						'title'    => sprintf( esc_html_x( 'Display %d', '%d: Display text size number.', 'nanospace' ), 1 ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6, address',
						'classes'  => 'display-1',
					),

					200 . 'text_sizes' . 110 => array(
						'title'    => sprintf( esc_html_x( 'Display %d', '%d: Display text size number.', 'nanospace' ), 2 ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6, address',
						'classes'  => 'display-2',
					),

					200 . 'text_sizes' . 120 => array(
						'title'    => sprintf( esc_html_x( 'Display %d', '%d: Display text size number.', 'nanospace' ), 3 ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6, address',
						'classes'  => 'display-3',
					),

					200 . 'text_sizes' . 130 => array(
						'title'    => sprintf( esc_html_x( 'Display %d', '%d: Display text size number.', 'nanospace' ), 4 ),
						'selector' => 'p, h1, h2, h3, h4, h5, h6, address',
						'classes'  => 'display-4',
					),

				),
			),

			// Group: Quotes.

			300 . 'quotes' => array(
				'title' => esc_html_x( 'Quotes', 'Visual editor blockquote formats group title.', 'nanospace' ),
				'items' => array(

					300 . 'quotes' . 100 => array(
						'title' => esc_html__( 'Blockquote', 'nanospace' ),
						'block' => 'blockquote',
						'icon'  => ( is_admin() ) ? ( 'blockquote' ) : ( '' ),
					),

					300 . 'quotes' . 110 => array(
						'title'   => esc_html__( 'Pullquote - align left', 'nanospace' ),
						'block'   => 'blockquote',
						'classes' => 'pullquote alignleft',
						'icon'    => ( is_admin() ) ? ( 'alignleft' ) : ( '' ),
					),

					300 . 'quotes' . 120 => array(
						'title'   => esc_html__( 'Pullquote - align right', 'nanospace' ),
						'block'   => 'blockquote',
						'classes' => 'pullquote alignright',
						'icon'    => ( is_admin() ) ? ( 'alignright' ) : ( '' ),
					),

					300 . 'quotes' . 130 => array(
						'title'  => esc_html_x( 'Cite', 'Visual editor format label for HTML CITE tag used to set the blockquote source.', 'nanospace' ),
						'inline' => 'cite',
					),

				),
			),

		) );

		ksort( $style_formats );

		foreach ( $style_formats as $group_key => $group ) {
			if ( isset( $group['items'] ) ) {

				ksort( $group['items'] );
				$style_formats[ $group_key ]['items'] = $group['items'];

			}
		} // /foreach

		if ( ! empty( $style_formats ) ) {

			// Merge old & new formats.

			$init['style_formats_merge'] = false;

			// New formats.

			$init['style_formats'] = json_encode( $style_formats );

		}

		// Removing obsolete tags (this is localized already).
		$heading_1 = ( ! is_admin() ) ? ( 'Heading 1=h1;' ) : ( '' ); // Accounting for page builders front-end editing when page title is disabled.

		$init['block_formats'] = 'Paragraph=p;' . $heading_1 . 'Heading 2=h2;Heading 3=h3;Heading 4=h4;Address=address;Preformatted=pre;Code=code';

		return $init;

	} // /custom_mce_format
	/**
	 * 30) Body class
	 */

	/**
	 * Adding editor HTML body classes
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $init
	 */
	public static function body_class( $init ) {

		// Requirements check.

		if ( ! isset( $init['body_class'] ) ) {
			return $init;
		}
		// Compatibility with `main.css` styles.
		$init['body_class'] .= ' entry-content '; // TinyMCE only.

		return $init;

	} // /body_class

	/**
	 * Adding scripts to post edit screen
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $hook_suffix
	 */
	public static function scripts_post_edit( $hook_suffix = '' ) {
		global $wp_version;

		$current_screen = get_current_screen();

		// Requirements check.
		if (
			version_compare( $wp_version, '4.7', '>=' )
			|| ( isset( $current_screen->base ) && 'post' != $current_screen->base )
		) {
			return;
		}

		// Scripts.
		wp_enqueue_script(
			'nanospace-post-edit',
			get_theme_file_uri( NANOSPACE_LIBRARY_DIR . 'js/post.js' ),
			array( 'jquery' ),
			esc_attr( NANOSPACE_THEME_VERSION ),
			true
		);

	} // /scripts_post_edit
} // /NanoSpace_Library_Visual_Editor

add_action( 'init', 'NanoSpace_Library_Visual_Editor::init' );
