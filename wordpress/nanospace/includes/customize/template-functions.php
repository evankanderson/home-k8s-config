<?php
/**
 * Custom functions to modify frontend templates via hooks.
 *
 * @package Nanospace
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================
 * HTML Head filters
 * ====================================================
 */

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function nanospace_pingback_header() {
	if ( is_singular() && pings_open() ) {
		/* translators: %s: pingback url. */
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'nanospace_pingback_header' );

function nanospace_template_hooks() {
	// Add main header.

	add_action( 'nanospace_frontend_header', 'nanospace_main_header' );

	add_action( 'nanospace_frontend_header', 'nanospace_left_header' );

	add_action( 'nanospace_frontend_header', 'nanospace_right_header' );

	// Add mobile header.
	
	add_action( 'nanospace_frontend_before_canvas', 'nanospace_mobile_vertical_header' );
	add_action( 'nanospace_frontend_header_mobile', 'nanospace_mobile_header' );

	add_action( 'nanospace_frontend_before_canvas', 'nanospace_full_screen_vertical_header' );
}

add_action( 'wp', 'nanospace_template_hooks', 20 );

/**
 * Add preconnect for Google Fonts embed fonts.
 *
 * @param array $urls
 * @param string $relation_type
 *
 * @return array $urls
 */
function nanospace_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'nanospace-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}

add_filter( 'wp_resource_hints', 'nanospace_resource_hints', 10, 2 );

/**
 * ====================================================
 * Template rendering filters
 * ====================================================
 */

/**
 * Add <span> wrapping tag and dropdown caret to menu item title.
 *
 * @param string $title
 * @param WP_Post $item
 * @param stdClass $args
 * @param integer $depth
 *
 * @return string
 */
function nanospace_nav_menu_item_title( $title, $item, $args, $depth ) {

	if ( 'header-menu-1' === $args->theme_location && 0 < $depth || 'header-menu-2' === $args->theme_location && 0 < $depth ) {
		return $title;
	}

	$sign = '';

	// Only add to menu item that has sub menu.
	if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
		// Only add to hover menu.
		if ( is_integer( strpos( $args->menu_class, 'nanospace-hover-menu' ) ) ) {
			$sign = nanospace_icon( 0 < $depth ? 'submenu-right' : 'submenu-down', array( 'class' => 'nanospace-dropdown-sign' ), false );
		}
	}

	return '<span class="nanospace-menu-item-title">' . $title . '</span>' . trim( $sign );
}

add_filter( 'nav_menu_item_title', 'nanospace_nav_menu_item_title', 99, 4 );

/**
 * Add 'nanospace-menu-item-link' class to menu item's anchor tag.
 *
 * @param array $atts
 * @param WP_Post $item
 * @param stdClass $args
 * @param int $depth
 */
function nanospace_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	if ( ! isset( $atts['class'] ) ) {
		$atts['class'] = '';
	}

	$atts['class'] = 'nanospace-menu-item-link ' . $atts['class'];

	return $atts;
}

add_filter( 'nav_menu_link_attributes', 'nanospace_nav_menu_link_attributes', 10, 4 );

/**
 * Add SVG icon to search textbox.
 *
 * @param string $from
 *
 * @return string
 */
function nanospace_get_search_form_add_icon( $form ) {
	$form = preg_replace( '/placeholder="(.*?)"/', 'placeholder="' . esc_attr__( 'Search&hellip;', 'nanospace' ) . '"', $form );
	$form = preg_replace( '/<\/form>/', nanospace_icon( 'search', array( 'class' => 'nanospace-search-icon' ), false ) . '</form>', $form );

	return $form;
}

add_filter( 'get_search_form', 'nanospace_get_search_form_add_icon' );

/**
 * ====================================================
 * Element classes filters
 * ====================================================
 */
/**
 * Add custom classes to the array of mobile vertical header classes.
 *
 * @param array $classes
 *
 * @return array
 */
function nanospace_header_mobile_vertical_classes( $classes ) {
	$classes['position']  = esc_attr( 'nanospace-header-mobile-vertical-position-' . nanospace_get_theme_mod( 'header_mobile_vertical_bar_position' ) );
	$classes['alignment'] = esc_attr( 'nanospace-text-align-' . nanospace_get_theme_mod( 'header_mobile_vertical_bar_alignment' ) );

	return $classes;
}

add_filter( 'nanospace_frontend_header_mobile_vertical_classes', 'nanospace_header_mobile_vertical_classes' );

/**
 * Add custom classes to the array of off canvas vertical header classes.
 *
 * @param array $classes
 *
 * @return array
 */
function nanospace_header_off_vertical_classes( $classes ) {
	$classes['position'] = esc_attr( 'nanospace-header-full-vertical-position-' . nanospace_get_theme_mod( 'nanospace_section_header_off_canvas_position' ) );

	return $classes;
}

add_filter( 'nanospace_frontend_header_off_vertical_classes', 'nanospace_header_off_vertical_classes' );
/**
 * Add custom classes to the array of header top bar section classes.
 *
 * @param array $classes
 *
 * @return array
 */
function nanospace_header_top_bar_classes( $classes ) {
	$classes['container']      = esc_attr( 'nanospace-section-' . nanospace_get_theme_mod( 'header_top_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'nanospace-header-menu-highlight-' . nanospace_get_theme_mod( 'header_top_bar_menu_highlight' ) );

	if ( intval( nanospace_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		$classes['merged'] = 'nanospace-section-merged';
	}

	return $classes;
}

add_filter( 'nanospace_frontend_header_top_bar_classes', 'nanospace_header_top_bar_classes' );

/**
 * Add custom classes to the array of header main bar section classes.
 *
 * @param array $classes
 *
 * @return array
 */
function nanospace_header_main_bar_classes( $classes ) {
	$classes['container']      = esc_attr( 'nanospace-section-' . nanospace_get_theme_mod( 'header_main_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'nanospace-header-menu-highlight-' . nanospace_get_theme_mod( 'header_main_bar_menu_highlight' ) );

	if ( intval( nanospace_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		$classes['top_bar_merged'] = 'nanospace-header-main-bar-with-top-bar';
	}

	if ( intval( nanospace_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		$classes['bottom_bar_merged'] = 'nanospace-header-main-bar-with-bottom-bar';
	}

	return $classes;
}

add_filter( 'nanospace_frontend_header_main_bar_classes', 'nanospace_header_main_bar_classes' );

/**
 * Add custom classes to the array of header bottom bar section classes.
 *
 * @param array $classes
 *
 * @return array
 */
function nanospace_header_bottom_bar_classes( $classes ) {
	$classes['container']      = esc_attr( 'nanospace-section-' . nanospace_get_theme_mod( 'header_bottom_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'nanospace-header-menu-highlight-' . nanospace_get_theme_mod( 'header_bottom_bar_menu_highlight' ) );

	if ( intval( nanospace_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		$classes['merged'] = 'nanospace-section-merged';
	}

	return $classes;
}

add_filter( 'nanospace_frontend_header_bottom_bar_classes', 'nanospace_header_bottom_bar_classes' );
