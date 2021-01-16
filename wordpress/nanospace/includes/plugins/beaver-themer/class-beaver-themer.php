<?php

/**
 * Beaver Themer Class
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
 * 100) Others
 */
class NanoSpace_Beaver_Themer {
	/**
	 * 0) Init
	 */

	/**
	 * Initialization
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function init() {


		add_theme_support( 'fl-theme-builder-headers' );
		add_theme_support( 'fl-theme-builder-footers' );
		add_theme_support( 'fl-theme-builder-parts' );
// Actions

		add_action( 'init', __CLASS__ . '::late_load', 900 );

		add_action( 'wp', __CLASS__ . '::headers_footers', 999 );
		add_action( 'wp', __CLASS__ . '::site_content', 999 );

		// Filters

		add_filter( 'fl_theme_builder_part_hooks', __CLASS__ . '::parts' );

	} // /init
	/**
	 * 10) Setup
	 */

	/**
	 * Load plugin assets a bit later (see Beaver Builder compatibility)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function late_load() {


		$priority  = 120;
		$callbacks = (array) apply_filters( 'nanospace_beaver_builder_assets_late_load_callbacks', array(
			'FLThemeBuilderLayoutFrontendEdit::enqueue_scripts' => 11,
		), 'themer' );

		// Has to be enqueued after `NanoSpace_Beaver_Builder_Assets::late_load()` UI assets.
		$order = 3;
		foreach ( $callbacks as $callback => $default_priority ) {
			if ( is_callable( $callback ) ) {
				remove_action( 'wp_enqueue_scripts', $callback, $default_priority );
				add_action( 'wp_enqueue_scripts', $callback, $priority + $order ++ );
			}
		}

	} // /late_load

	/**
	 * Custom header and footer renderer
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function headers_footers() {

		// Requirements check

		if ( is_admin() ) {
			return;
		}


		$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();
		$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();
// Custom header

		if ( ! empty( $header_ids ) ) {
			remove_all_actions( 'nanospace_header_top' );
			remove_all_actions( 'nanospace_header_bottom' );

			add_action( 'nanospace_header_top', 'FLThemeBuilderLayoutRenderer::render_header', 20 );

			add_action( 'wp_enqueue_scripts', __CLASS__ . '::dequeue_header_scripts', 110 );

			add_filter( 'theme_mod_' . 'layout_header_sticky', '__return_false', 20 );
			add_filter( 'nanospace_skip_links_no_header', '__return_true' );
		}

		// Custom footer

		if ( ! empty( $footer_ids ) ) {
			remove_all_actions( 'nanospace_footer_top' );
			remove_all_actions( 'nanospace_footer_bottom' );

			add_action( 'nanospace_footer_top', 'FLThemeBuilderLayoutRenderer::render_footer', 20 );

			add_filter( 'nanospace_skip_links_no_footer', '__return_true' );
		}

	} // /headers_footers

	/**
	 * Setup site content.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function site_content() {

		// Requirements check

		if ( is_admin() ) {
			return;
		}


		$layouts = array_keys( (array) FLThemeBuilderLayoutData::get_current_page_layouts() );
		if ( count( array_intersect( $layouts, array( 'singular', '404', 'archive' ) ) ) ) {

			// Removing intro
			remove_action( 'nanospace_content_top', 'NanoSpace_Intro::container', 15 );

			// Disabling sidebar
			add_filter( 'nanospace_sidebar_disable', '__return_true' );

			// Removing post navigation
			// remove_action( 'nanospace_content_bottom', 'NanoSpace_Post::navigation', 95 );

		}

	} // /site_content

	/**
	 * Dequeue theme header scripts
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function dequeue_header_scripts() {
		wp_dequeue_script( 'nanospace-scripts-nav-a11y' );
		wp_dequeue_script( 'nanospace-scripts-nav-mobile' );

	} // /dequeue_header_scripts

	/**
	 * Registers hooks for theme parts
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function parts() {


		return array(

			array(
				'label' => esc_html_x( 'Page', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_body_top'    => esc_html_x( 'Page Open', 'Website hook name.', 'nanospace' ),
					'nanospace_body_bottom' => esc_html_x( 'Page Close', 'Website hook name.', 'nanospace' ),
				),
			),

			array(
				'label' => esc_html_x( 'Header', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_header_before' => esc_html_x( 'Before Header', 'Website hook name.', 'nanospace' ),
					'nanospace_header_top'    => esc_html_x( 'Header Top', 'Website hook name.', 'nanospace' ),
					'nanospace_header_bottom' => esc_html_x( 'Header Bottom', 'Website hook name.', 'nanospace' ),
					'nanospace_header_after'  => esc_html_x( 'After Header', 'Website hook name.', 'nanospace' ),
				),
			),

			array(
				'label' => esc_html_x( 'Intro', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_intro_before' => esc_html_x( 'Before Intro', 'Website hook name.', 'nanospace' ),
					'nanospace_intro'        => esc_html_x( 'Intro Content', 'Website hook name.', 'nanospace' ),
					'nanospace_intro_after'  => esc_html_x( 'After Intro', 'Website hook name.', 'nanospace' ),
				),
			),

			array(
				'label' => esc_html_x( 'Content Area', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_content_before' => esc_html_x( 'Before Content Area', 'Website hook name.', 'nanospace' ),
					'nanospace_content_top'    => esc_html_x( 'Content Area Top', 'Website hook name.', 'nanospace' ),
					'nanospace_content_bottom' => esc_html_x( 'Content Area Bottom', 'Website hook name.', 'nanospace' ),
					'nanospace_content_after'  => esc_html_x( 'After Content Area', 'Website hook name.', 'nanospace' ),
				),
			),

			array(
				'label' => esc_html_x( 'Post Entry', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_entry_before'         => esc_html_x( 'Before Post', 'Website hook name.', 'nanospace' ),
					'nanospace_entry_top'            => esc_html_x( 'Post Top', 'Website hook name.', 'nanospace' ),
					'nanospace_entry_content_before' => esc_html_x( 'Before Post Content', 'Website hook name.', 'nanospace' ),
					'nanospace_entry_content_after'  => esc_html_x( 'After Post Content', 'Website hook name.', 'nanospace' ),
					'nanospace_entry_bottom'         => esc_html_x( 'Post Bottom', 'Website hook name.', 'nanospace' ),
					'nanospace_entry_after'          => esc_html_x( 'After Post', 'Website hook name.', 'nanospace' ),
				),
			),

			array(
				'label' => esc_html_x( 'Comments', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_comments_before' => esc_html_x( 'Before Comments', 'Website hook name.', 'nanospace' ),
					'nanospace_comments_after'  => esc_html_x( 'After Comments', 'Website hook name.', 'nanospace' ),
				),
			),

			array(
				'label' => esc_html_x( 'Posts List', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_postslist_before' => esc_html_x( 'Before Posts List', 'Website hook name.', 'nanospace' ),
					'nanospace_postslist_after'  => esc_html_x( 'After Posts List', 'Website hook name.', 'nanospace' ),
				),
			),

			array(
				'label' => esc_html_x( 'Child Pages List', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_loop_child_pages_before' => esc_html_x( 'Before Child Pages List', 'Website hook name.', 'nanospace' ),
					'nanospace_loop_child_pages_after'  => esc_html_x( 'After Child Pages List', 'Website hook name.', 'nanospace' ),
				),
			),

			array(
				'label' => esc_html_x( 'Sidebar', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_sidebars_before' => esc_html_x( 'Before Sidebar', 'Website hook name.', 'nanospace' ),
					'nanospace_sidebar_top'     => esc_html_x( 'Sidebar Top', 'Website hook name.', 'nanospace' ),
					'nanospace_sidebar_bottom'  => esc_html_x( 'Sidebar Bottom', 'Website hook name.', 'nanospace' ),
					'nanospace_sidebars_after'  => esc_html_x( 'After Sidebar', 'Website hook name.', 'nanospace' ),
				),
			),

			array(
				'label' => esc_html_x( 'Footer', 'Website hooks category name.', 'nanospace' ),
				'hooks' => array(
					'nanospace_footer_before' => esc_html_x( 'Before Footer', 'Website hook name.', 'nanospace' ),
					'nanospace_footer_top'    => esc_html_x( 'Footer Top', 'Website hook name.', 'nanospace' ),
					'nanospace_footer_bottom' => esc_html_x( 'Footer Bottom', 'Website hook name.', 'nanospace' ),
					'nanospace_footer_after'  => esc_html_x( 'After Footer', 'Website hook name.', 'nanospace' ),

					'nanospace_site_info_before' => esc_html_x( 'Before Site Info', 'Website hook name.', 'nanospace' ),
					'nanospace_site_info_after'  => esc_html_x( 'After Site Info', 'Website hook name.', 'nanospace' ),
				),
			),

		);

	} // /parts
} // /NanoSpace_Beaver_Themer

add_action( 'after_setup_theme', 'NanoSpace_Beaver_Themer::init' );
