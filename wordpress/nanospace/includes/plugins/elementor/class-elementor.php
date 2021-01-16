<?php

/**
 * Elementor Class
 *
 * Elementor Theme Builder compatibility:
 * ======================================
 * This is quite a lot more complicated integration than with Beaver Themer!
 *
 * Though I understand Elementor is trying to make Theme Builder compatible
 * out of the box with ANY theme, it is not a good idea in my opinion, as
 * every theme is different and the whole concept of Theme Builder might
 * be too complicated for basic WP user as you need to know something about
 * WP theme hierarchy!
 *
 * Besides, I've encountered numerous (logical) issues even when using native
 * TwentySeventeen theme (and those does not occur with Beaver Themer's logic),
 * such as not displaying any (even the theme's default) header when a custom
 * header is set to display on some, not all pages, for example.
 *
 * The code below should be future proof enough, unless something is changed
 * in Elementor's Theme Builder code, of course.
 *
 * Hope Elementor is not next Visual Composer...
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
 *  10) Upgrade
 *  20) Setup
 *  30) Display
 *  40) Getters
 * 100) Others
 */
class NanoSpace_Elementor {
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


		$theme_builder = self::get_theme_builder( false );
// Actions

		add_action( 'wp', __CLASS__ . '::disable_sidebar' );

		if ( $theme_builder ) {
			add_action( 'elementor/theme/register_locations', __CLASS__ . '::register_locations' );
			/**
			 * The `get_header` is the first action hook where `elementor_location_exits()`
			 * function is working and we still have time to dequeue assets and set up custom
			 * theme builder sections display.
			 */
			add_action( 'get_header', __CLASS__ . '::display_setup', - 10 );
		}

		// Filters

		add_filter( 'wp_parse_str', __CLASS__ . '::upgrade_link' );

	} // /init
	/**
	 * 10) Upgrade
	 */

	/**
	 * Get theme builder instance or check if it's loaded
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  boolean $get_instance Get theme builder instance or just check if it's loaded?
	 */
	public static function get_theme_builder( $get_instance = true ) {


		if ( $get_instance ) {
			return ElementorPro\Modules\ThemeBuilder\Module::instance();
		} else {
			return is_callable( 'ElementorPro\Modules\ThemeBuilder\Module::instance' );
		}

	} // /upgrade_link
	/**
	 * 20) Setup
	 */

	/**
	 * Upgrade link
	 *
	 * By defining the `ELEMENTOR_PARTNER_ID` constant, Elementor's `Utils::get_pro_link()`
	 * method produces URL with incorrect `partner_id` argument. Should be `ref` instead.
	 *
	 * Waiting for Elementor to fix the `partner_id` URL argument.
	 * UPDATE 20180507: They will not fix it, basically, this is intended...
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $url_args The array populated with variables.
	 */
	public static function upgrade_link( $url_args = array() ) {

		// Variables

		$ref_id = 2179;

		/**
		 * @see Elementor\Utils::get_pro_link
		 */
		$theme = wp_get_theme( get_stylesheet() )->get( 'Name' );
		$theme = sanitize_key( $theme );
		/**
		 * We need to define this so Elementor runs `add_query_arg()`
		 * second time, after `utm_term` is added.
		 * We can use any value here.
		 */
		if ( ! defined( 'ELEMENTOR_PARTNER_ID' ) ) {
			define( 'ELEMENTOR_PARTNER_ID', $ref_id );
		}

		/**
		 * Setting our referral ID,
		 * Unsetting UTMs.
		 */
		if (
			isset( $url_args['utm_campaign'] )
			&& 'gopro' === $url_args['utm_campaign']
			&& ! isset( $url_args['ref'] )
		) {
			$url_args['ref']        = $ref_id;
			$url_args['utm_source'] = 'wm-theme';
			unset( $url_args['utm_campaign'] );
			unset( $url_args['utm_medium'] );
			unset( $url_args['utm_source'] );
		}

		/**
		 * Unsetting theme name UTM.
		 */
		if (
			isset( $url_args['utm_term'] )
			&& $theme === $url_args['utm_term']
		) {
			unset( $url_args['utm_term'] );
		}


		return $url_args;

	} // /register_locations

	/**
	 * Register locations
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  object $manager
	 */
	public static function register_locations( $manager ) {
		$manager->register_core_location( 'header' );
		$manager->register_core_location( 'footer' );

	} // /display_setup
	/**
	 * 30) Display
	 */

	/**
	 * Setup display of custom sections
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function display_setup() {


		$locations = self::get_locations();
// Requirements check

		if ( empty( $locations ) ) {
			return;
		}
		foreach ( $locations as $location => $location_args ) {
			if ( self::is_location_active( $location ) ) {
				switch ( $location ) {

					/**
					 * Site header
					 *
					 * Removing theme header, displaying the theme builder one, dequeuing header
					 * related assets, and disabling theme's sticky header.
					 */
					case 'header':
						remove_all_actions( 'nanospace_header_top' );
						remove_all_actions( 'nanospace_header_bottom' );

						add_action( 'nanospace_header_top', __CLASS__ . '::header' );

						add_action( 'wp_enqueue_scripts', __CLASS__ . '::dequeue_header_scripts', 110 );

						add_filter( 'theme_mod_' . 'layout_header_sticky', '__return_false', 20 );
						add_filter( 'nanospace_skip_links_no_header', '__return_true' );
						break;

					/**
					 * Site footer
					 *
					 * Removing theme footer, displaying the theme builder one.
					 */
					case 'footer':
						remove_all_actions( 'nanospace_footer_top' );
						remove_all_actions( 'nanospace_footer_bottom' );

						add_action( 'nanospace_footer_top', __CLASS__ . '::footer' );

						add_filter( 'nanospace_skip_links_no_footer', '__return_true' );
						break;

					/**
					 * Site content area (singulars and archives)
					 *
					 * For all the locations that are editable by Elementor in content area we need
					 * to remove theme content wrappers and all sections and elements hooked into
					 * THA content wrapper action hooks.
					 *
					 * As we do not register support for such locations (see `register_locations()`
					 * above), Elementor Theme Builder will take over the whole theme content area
					 * and display content as needed.
					 */
					default:
						if ( $location_args['edit_in_content'] ) {
							// Removing intro.
							remove_action( 'nanospace_content_top', 'NanoSpace_Intro::container', 15 );

							// Make sure we apply correct content layout.
							add_filter( 'get_post_metadata', __CLASS__ . '::content_layout', 10, 3 );

							// We still need to disable sidebar for correct body class.
							add_filter( 'nanospace_sidebar_disable', '__return_true' );
						}
						break;

				}
			}
		}

	} // /header

	/**
	 * Get locations
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function get_locations() {


		return self::get_theme_builder()->get_locations_manager()->get_locations();

	} // /footer
	/**
	 * 40) Getters
	 */

	/**
	 * Does the location have any documents, is it active?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $location
	 */
	public static function is_location_active( $location = '' ) {

		// Requirements check

		if (
			function_exists( 'elementor_location_exits' )
			&& ! elementor_location_exits( $location )
		) {
			return;
		}


		$documents = self::get_documents_for_location( $location );


		return ! empty( $documents );

	} // /get_theme_builder

	/**
	 * Get documents for specific location
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $location
	 */
	public static function get_documents_for_location( $location = '' ) {


		return self::get_theme_builder()->get_conditions_manager()->get_documents_for_location( $location );

	} // /get_locations

	/**
	 * Display header
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function header() {
		elementor_theme_do_location( 'header' );

	} // /get_documents_for_location

	/**
	 * Display footer
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function footer() {
		elementor_theme_do_location( 'footer' );

	} // /is_location_active
	/**
	 * 100) Others
	 */

	/**
	 * Disable sidebar when in edit mode.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function disable_sidebar() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			add_filter( 'nanospace_sidebar_disable', '__return_true' );
		}

	} // /disable_sidebar

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
	 * Page builder content layout setup for Elementor templates
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  null|array|string $value
	 * @param  absint $post_id
	 * @param  string $meta_key
	 */
	public static function content_layout( $value = null, $post_id = 0, $meta_key = '' ) {
		if ( 'content_layout' === $meta_key ) {
			return 'stretched';
		}


		return $value;

	} // /content_layout
} // /NanoSpace_Elementor

add_action( 'after_setup_theme', 'NanoSpace_Elementor::init' );
