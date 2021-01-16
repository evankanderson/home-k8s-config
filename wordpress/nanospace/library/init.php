<?php
/**
 * Labinator NanoSpace WordPress Theme Framework
 *
 * Theme options with `__` prefix (`get_theme_mod( '__option_id' )`) are theme
 * setup related options and can not be edited via customizer.
 * This way we prevent creating additional options in the database.
 *
 * @copyright  Labinator
 * @license    GPL-3.0, http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @link  https://labinator.com/wordpress-marketplace/themes/nanospace
 * @link  https://labinator.com
 *
 * @package     Labinator NanoSpace WordPress Theme Framework
 * @subpackage  Core
 *
 * @version 1.0.0
 *
 * Used global hooks:
 *
 * @uses  nanospace_theme_options
 *
 * Used development prefixes:
 *
 * @uses  theme_slug
 * @uses  text_domain
 * @uses  prefix_var
 * @uses  prefix_hook
 * @uses  theme_name
 * @uses  prefix_class
 * @uses  prefix_constant
 *
 * Contents:
 *
 * 10) Constants
 * 20) Load
 */

/**
 * 10) Constants
 */

// Theme version.
if ( ! defined( 'NANOSPACE_THEME_VERSION' ) ) {
	define( 'NANOSPACE_THEME_VERSION', wp_get_theme( 'nanospace' )->get( 'Version' ) );
}

// Paths.
if ( ! defined( 'NANOSPACE_PATH' ) ) {
	define( 'NANOSPACE_PATH', trailingslashit( get_template_directory() ) );
}

if ( ! defined( 'NANOSPACE_LIBRARY_DIR' ) ) {
	define( 'NANOSPACE_LIBRARY_DIR', trailingslashit( basename( dirname( __FILE__ ) ) ) );
}

define( 'NANOSPACE_LIBRARY', trailingslashit( NANOSPACE_PATH . NANOSPACE_LIBRARY_DIR ) );
/**
 * 20) Load
 */

// Core class.

require NANOSPACE_LIBRARY . 'includes/classes/class-core.php';

// Customize (has to be frontend accessible, otherwise it hides the theme settings).

// Sanitize class.
require NANOSPACE_LIBRARY . 'includes/classes/class-sanitize.php';

// Customize class.
require NANOSPACE_LIBRARY . 'includes/classes/class-customize.php';

// CSS variables generator class.
require NANOSPACE_LIBRARY . 'includes/classes/class-css-variables.php';

// Admin.
if ( is_admin() ) {

	// Optional plugins suggestions.
	$nanospace_plugins_suggestions = get_theme_file_path( 'includes/tgmpa/plugins.php' );
	if ( (bool) apply_filters( 'nanospace_plugins_suggestion_enabled', file_exists( $nanospace_plugins_suggestions ) ) ) {
		require NANOSPACE_LIBRARY . 'includes/vendor/tgmpa/class-tgm-plugin-activation.php';
		require $nanospace_plugins_suggestions;
	}
}


if ( ! function_exists( 'nanospace_get_single_sidebar_layout' ) ) {
	/**
	 * GET SINGLE SIDEBAR LAYOUT
	 */
	function nanospace_get_single_sidebar_layout() {
		global $post;

		if ( isset( $post->ID ) ) {
			$sidebar = get_post_meta( $post->ID, '_nanospace_post_layout_override', 1 );
			if ( $sidebar && 'default' !== $sidebar ) {
				return $sidebar;
			}
		}

		$sidebar = get_theme_mod( 'nanospace_post_layout', 'sidebar-none' );

		return $sidebar;
	}
}


if ( ! function_exists( 'nanospace_get_single_sidebar_id' ) ) {
	/**
	 * GET SINGLE SIDEBAR LAYOUT
	 */
	function nanospace_get_single_sidebar_id() {

		$sidebar = nanospace_get_single_sidebar_layout();
		$ids     = array();

		switch ( $sidebar ) {
			case 'sidebar-right':
				$ids[] = 'sidebar';
				break;

			case 'sidebar-left-right':
				$ids[] = 'sidebar';

			case 'sidebar-left':
				$ids[] = 'left-sidebar';
				break;
		}

		return $ids;
	}
}
