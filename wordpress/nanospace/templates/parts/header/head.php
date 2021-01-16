<?php
/**
 * HTML head content
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

?>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">';
	}

	/**
	 * Support for Chrome Theme Color Changer plugin
	 *
	 * @see  https://wordpress.org/plugins/chrome-theme-color-changer
	 */
	if ( ! class_exists( 'Chrome_Theme_Color_Changer' ) ) {
		echo '<meta name="theme-color" content="' . esc_attr( get_theme_mod( 'color_header_background', '#ffffff' ) ) . '">';
	}
