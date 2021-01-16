<?php

/**
 * Customized Styles Class
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
 *  10) CSS output
 *  20) Enqueue
 * 100) Others
 */
class NanoSpace_Customize_Styles {
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
		// Actions.
		add_action( 'wp_enqueue_scripts', __CLASS__ . '::inline_styles', 109 );

		add_action( 'wp_ajax_nanospace_editor_styles', __CLASS__ . '::get_editor_css_variables' );
		add_action( 'wp_ajax_no_priv_nanospace_editor_styles', __CLASS__ . '::get_editor_css_variables' );

		add_action( 'customize_save_after', __CLASS__ . '::customize_timestamp' );

		// Filters.
		add_filter( 'nanospace_assets_editor', __CLASS__ . '::editor_stylesheet' );

	} // /init
	/**
	 * 10) CSS output
	 */

	/**
	 * Enqueue HTML head inline styles.
	 *
	 * @uses  `nanospace_esc_css` global hook
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function inline_styles() {

		// Variables
		$css = (string) self::get_css_variables();
		$css .= (string) self::get_css();
		if ( ! empty( $css ) ) {
			wp_add_inline_style(
				'nanospace',
				(string) apply_filters( 'nanospace_esc_css', $css )
			);
		}

	} // /get_css

	/**
	 * Get processed CSS variables string.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function get_css_variables() {

		// Variables
		$css_vars = '';
		if ( is_callable( 'NanoSpace_Library_CSS_Variables::get_variables_string' ) ) {
			$css_vars = NanoSpace_Library_CSS_Variables::get_variables_string();
		}

		if ( ! empty( $css_vars ) ) {
			$css_vars = '/* START CSS variables */'
			            . PHP_EOL
			            . ':root { '
			            . PHP_EOL
			            . $css_vars
			            . PHP_EOL
			            . '}'
			            . PHP_EOL
			            . '/* END CSS variables */';
		}


		return (string) $css_vars;

	} // /get_css_variables
	/**
	 * 20) Enqueue
	 */

	/**
	 * Get custom CSS.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function get_css() {

		// Variables
		$css = '';
		if ( empty( get_theme_mod( 'footer_image', esc_url( trailingslashit( get_template_directory_uri() ) . 'assets/images/footer/footer.png' ) ) ) ) {
			$css .= PHP_EOL . '.site-footer:not(.is-customize-preview)::before { display: none; }';
		}


		return (string) $css;

	} // /inline_styles

	/**
	 * Enqueue custom styles into Visual editor using Ajax.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $visual_editor_stylesheets
	 */
	public static function editor_stylesheet( $visual_editor_stylesheets = array() ) {
		/**
		 * @see  `stargazer_get_editor_styles` https://github.com/justintadlock/stargazer/blob/master/inc/stargazer.php
		 */
		$visual_editor_stylesheets[30] = esc_url_raw( add_query_arg(
			array(
				'action' => 'nanospace_editor_styles',
				'ver'    => NANOSPACE_THEME_VERSION . '.' . get_theme_mod( '__customize_timestamp' ),
			),
			admin_url( 'admin-ajax.php' )
		) );


		return $visual_editor_stylesheets;

	} // /editor_stylesheet

	/**
	 * Ajax callback for outputting custom styles for Visual editor.
	 *
	 * @see  https://github.com/justintadlock/stargazer/blob/master/inc/custom-colors.php
	 * @uses  `nanospace_esc_css` global hook
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function get_editor_css_variables() {

		// Variables

		$css_vars = self::get_css_variables();
		if ( ! empty( $css_vars ) ) {
			header( 'Content-type: text/css' );
			echo (string) apply_filters( 'nanospace_esc_css', $css_vars );
		}

		die();

	} // /get_editor_css_variables
	/**
	 * 100) Others
	 */

	/**
	 * Customizer save timestamp.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function customize_timestamp() {
		set_theme_mod( '__customize_timestamp', esc_attr( gmdate( 'ymdHis' ) ) );

	} // /customize_timestamp
} // /NanoSpace_Customize_Styles

add_action( 'after_setup_theme', 'NanoSpace_Customize_Styles::init' );
