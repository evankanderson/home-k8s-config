<?php
/**
 * Customizer & Front-End modification rules.
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_add = array();

/**
 * ====================================================
 * Header > Element: Logo
 * ====================================================
 */

$nanospace_add['header_logo_width']        = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-logo .nanospace-logo-image',
		'property' => 'width',
	),
);
$nanospace_add['header_mobile_logo_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-logo .nanospace-logo-image',
		'property' => 'width',
	),
);

/**
 * ====================================================
 * Header > Element: Search
 * ====================================================
 */

$nanospace_add['header_search_bar_width']      = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-search-bar .search-form',
		'property' => 'width',
	),
);


/**
 * ====================================================
 * Header > Element: Shopping Cart
 * ====================================================
 */

$nanospace_add['header_cart_count_bg_color']   = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-shopping-cart .shopping-cart-count',
		'property' => 'background-color',
	),
);
$nanospace_add['header_cart_count_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-shopping-cart .shopping-cart-count',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Header > Element: Social
 * ====================================================
 */

$nanospace_add['header_social_links_target'] = array(
	array(
		'type'     => 'html',
		'element'  => '.nanospace-header-social-links a',
		'property' => 'target',
		'pattern'  => '_$',
	),
);

/**
 * ====================================================
 * Header > Element: layout
 * ====================================================
 */
$nanospace_add['nanospace_section_header_layout_select'] = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-header-column',
		'pattern' => 'nanospace-flex-align-$',
	),
);

$nanospace_add['nanospace_section_header_off_canvas_position'] = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-header-full-vertical',
		'pattern' => 'nanospace-header-full-vertical-position-$',
	),
);

$nanospace_add['nanospace_section_header_off_canvas_align'] = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-header-full-vertical',
		'pattern' => 'nanospace-text-align-$',
	),
);

$nanospace_add['vertical_header_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-vertical-color',
		'property' => 'background-color',
	),
);

$nanospace_add['off_canvas_header_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-off-canvas-color',
		'property' => 'background-color',
	),
);

$nanospace_add['off_canvas_text_color'] = array(

	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-off-canvas-color .menu',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Header > Top Bar
 * Header > Main Bar
 * Header > Bottom Bar
 * ====================================================
 */

// Main bar is placed first because top bar and bottom bar can be merged into main bar.
foreach ( array( 'main_bar', 'top_bar', 'bottom_bar' ) as $nanospace_bar ) {
	$nanospace_slug = str_replace( '_', '-', $nanospace_bar );

	if ( 'main_bar' !== $nanospace_bar ) {
		$nanospace_add[ 'header_' . $nanospace_bar . '_merged_gap' ] = array(
			array(
				'type'     => 'css',
				'element'  => '.nanospace-header-main-bar.nanospace-header-main-bar-with-' . $nanospace_slug . ' .nanospace-header-main-bar-row',
				'property' => 'padding-' . ( 'top_bar' === $nanospace_bar ? 'top' : 'bottom' ),
			),
		);
	}

	// Layout
	$nanospace_add[ 'header_' . $nanospace_bar . '_container' ] = array(
		array(
			'type'    => 'class',
			'element' => '.nanospace-header-' . $nanospace_slug,
			'pattern' => 'nanospace-section-$',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_height' ]    = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug,
			'property' => 'height',
		),
	);

	if ( 'main_bar' !== $nanospace_bar ) {
		$nanospace_add[ 'header_' . $nanospace_bar . '_height' ][] = array(
			'type'     => 'css',
			'element'  => '.nanospace-header-main-bar.nanospace-header-main-bar-with-' . $nanospace_slug . ' > .nanospace-section-inner > .nanospace-wrapper',
			'property' => 'padding-' . ( 'top_bar' === $nanospace_bar ? 'top' : 'bottom' ),
		);
	}

	$nanospace_add[ 'header_' . $nanospace_bar . '_padding' ]      = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . '-inner',
			'property' => 'padding',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_border' ]       = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . '-inner',
			'property' => 'border-width',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_items_gutter' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .nanospace-header-column > *',
			'property' => 'padding',
			'pattern'  => '0 $',
		),
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . '-row',
			'property' => 'margin',
			'pattern'  => '0 -$',
		),
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .nanospace-header-menu .menu-item',
			'property' => 'padding',
			'pattern'  => '0 $',
		),
	);

	foreach (
		array(
			'font_family',
			'font_weight',
			'font_style',
			'text_transform',
			'font_size',
			'line_height',
			'letter_spacing'
		) as $nanospace_prop
	) {
		$nanospace_element  = '.nanospace-header-' . $nanospace_slug;
		$nanospace_property = str_replace( '_', '-', $nanospace_prop );

		$nanospace_add[ 'header_' . $nanospace_bar . '_' . $nanospace_prop ] = array(
			array(
				'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
			),
		);
	}

	foreach (
		array(
			'font_family',
			'font_weight',
			'font_style',
			'text_transform',
			'font_size',
			'line_height',
			'letter_spacing'
		) as $nanospace_prop
	) {
		$nanospace_element  = '.nanospace-header-' . $nanospace_slug . ' .menu .menu-item > .nanospace-menu-item-link';
		$nanospace_property = str_replace( '_', '-', $nanospace_prop );

		$nanospace_add[ 'header_' . $nanospace_bar . '_menu_' . $nanospace_prop ] = array(
			array(
				'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
			),
		);
	}

	foreach (
		array(
			'font_family',
			'font_weight',
			'font_style',
			'text_transform',
			'font_size',
			'line_height',
			'letter_spacing'
		) as $nanospace_prop
	) {
		$nanospace_element  = '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu .menu-item > .nanospace-menu-item-link';
		$nanospace_property = str_replace( '_', '-', $nanospace_prop );

		$nanospace_add[ 'header_' . $nanospace_bar . '_submenu_' . $nanospace_prop ] = array(
			array(
				'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
			),
		);
	}

	$nanospace_add[ 'header_' . $nanospace_bar . '_icon_size' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .nanospace-menu-icon',
			'property' => 'font-size',
		),
	);

	$nanospace_add[ 'header_' . $nanospace_bar . '_bg_color' ]               = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . '-inner',
			'property' => 'background-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu',
			'property' => 'background-color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_border_color' ]           = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' *',
			'property' => 'border-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu',
			'property' => 'border-color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_text_color' ]             = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug,
			'property' => 'color',
		),
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu',
			'property' => 'color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_link_text_color' ]        = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' a:not(.button), .nanospace-header-' . $nanospace_slug . ' .nanospace-toggle',
			'property' => 'color',
		),
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu a:not(.button)',
			'property' => 'color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_link_hover_text_color' ]  = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' a:not(.button):hover, .nanospace-header-' . $nanospace_slug . ' a:not(.button):focus, .nanospace-header-' . $nanospace_slug . ' .nanospace-toggle:hover, .nanospace-header-' . $nanospace_slug . ' .nanospace-toggle:focus',
			'property' => 'color',
		),
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu a:not(.button):hover, .nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu a:not(.button):focus',
			'property' => 'color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_link_active_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .current-menu-item > .nanospace-menu-item-link, .nanospace-header-' . $nanospace_slug . ' .current-menu-ancestor > .nanospace-menu-item-link',
			'property' => 'color',
		),
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu .current-menu-item > .nanospace-menu-item-link, .nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu .current-menu-ancestor > .nanospace-menu-item-link',
			'property' => 'color',
		),
	);

	$nanospace_add[ 'header_' . $nanospace_bar . '_submenu_bg_color' ]               = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu',
			'property' => 'background-color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_submenu_border_color' ]           = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu',
			'property' => 'border-color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_submenu_text_color' ]             = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu',
			'property' => 'color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_submenu_link_text_color' ]        = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu a:not(.button)',
			'property' => 'color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_submenu_link_hover_text_color' ]  = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu a:not(.button):hover, .nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu a:not(.button):focus',
			'property' => 'color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_submenu_link_active_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu .current-menu-item > .nanospace-menu-item-link, .nanospace-header-' . $nanospace_slug . ' .menu > .menu-item .sub-menu .current-menu-ancestor > .nanospace-menu-item-link',
			'property' => 'color',
		),
	);

	$nanospace_add[ 'header_' . $nanospace_bar . '_menu_highlight' ] = array(
		array(
			'type'    => 'class',
			'element' => '.nanospace-header-' . $nanospace_slug,
			'pattern' => 'nanospace-header-menu-highlight-$',
		),
	);

	$nanospace_add[ 'header_' . $nanospace_bar . '_menu_hover_highlight_color' ]       = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ':not(.nanospace-header-menu-highlight-none) .nanospace-header-menu > .menu > .menu-item > .nanospace-menu-item-link:hover:after, .nanospace-header-' . $nanospace_slug . ':not(.nanospace-header-menu-highlight-none) .nanospace-header-menu > .menu > .menu-item > .nanospace-menu-item-link:focus:after',
			'property' => 'background-color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_menu_hover_highlight_text_color' ]  = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ':not(.nanospace-header-menu-highlight-none) .nanospace-header-menu > .menu > .menu-item > .nanospace-menu-item-link:hover, .nanospace-header-' . $nanospace_slug . ':not(.nanospace-header-menu-highlight-none) .nanospace-header-menu > .menu > .menu-item > .nanospace-menu-item-link:focus',
			'property' => 'color',
			'pattern'  => '$ !important',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_menu_active_highlight_color' ]      = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ':not(.nanospace-header-menu-highlight-none) .nanospace-header-menu > .menu > .current-menu-item > .nanospace-menu-item-link:after, .nanospace-header-' . $nanospace_slug . ':not(.nanospace-header-menu-highlight-none) .nanospace-header-menu > .menu > .current-menu-ancestor > .nanospace-menu-item-link:after',
			'property' => 'background-color',
		),
	);
	$nanospace_add[ 'header_' . $nanospace_bar . '_menu_active_highlight_text_color' ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-' . $nanospace_slug . ':not(.nanospace-header-menu-highlight-none) .nanospace-header-menu > .menu > .current-menu-item > .nanospace-menu-item-link, .nanospace-header-' . $nanospace_slug . ':not(.nanospace-header-menu-highlight-none) .nanospace-header-menu > .menu > .current-menu-ancestor > .nanospace-menu-item-link',
			'property' => 'color',
		),
	);
}

/**
 * ====================================================
 * Header > Mobile Main Bar
 * ====================================================
 */

$nanospace_add['header_mobile_main_bar_height'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar',
		'property' => 'height',
	),
);
$nanospace_responsive                           = array(
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $nanospace_responsive as $nanospace_suffix => $nanospace_media ) {
	$nanospace_add[ 'header_mobile_main_bar_padding' . $nanospace_suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-header-mobile-main-bar-inner',
			'property' => 'padding',
			'media'    => $nanospace_media,
		),
	);
}
$nanospace_add['header_mobile_main_bar_border']       = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar-inner',
		'property' => 'border-width',
	),
);
$nanospace_add['header_mobile_main_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar .nanospace-header-column > *',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar .nanospace-header-row',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar .nanospace-header-menu .menu-item',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
);

$nanospace_add['header_mobile_main_bar_icon_size'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar .nanospace-menu-icon',
		'property' => 'font-size',
	),
);

$nanospace_add['header_mobile_main_bar_bg_color']              = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar-inner',
		'property' => 'background-color',
	),
);
$nanospace_add['header_mobile_main_bar_border_color']          = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar *',
		'property' => 'border-color',
	),
);
$nanospace_add['header_mobile_main_bar_link_text_color']       = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar a:not(.button), .nanospace-header-mobile-main-bar .nanospace-toggle',
		'property' => 'color',
	),
);
$nanospace_add['header_mobile_main_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-main-bar a:not(.button):hover, .nanospace-header-mobile-main-bar a:not(.button):focus, .nanospace-header-mobile-main-bar .nanospace-toggle:hover, .nanospace-header-mobile-main-bar .nanospace-toggle:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Header > Mobile Drawer (Popup)
 * ====================================================
 */

$nanospace_add['header_mobile_vertical_bar_position']  = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-header-mobile-vertical',
		'pattern' => 'nanospace-header-mobile-vertical-position-$',
	),
);
$nanospace_add['header_mobile_vertical_bar_alignment'] = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-header-mobile-vertical',
		'pattern' => 'nanospace-text-align-$',
	),
);

$nanospace_add['header_mobile_vertical_bar_width']   = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar',
		'property' => 'width',
	),
);
$nanospace_add['header_mobile_vertical_bar_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar-inner',
		'property' => 'padding',
	),
);

$nanospace_add['header_mobile_vertical_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar .nanospace-header-section-vertical-row, .nanospace-header-mobile-vertical-bar .nanospace-header-section-vertical-row > *',
		'property' => 'padding',
		'pattern'  => '$ 0',
	),
);

foreach (
	array(
		'font_family',
		'font_weight',
		'font_style',
		'text_transform',
		'font_size',
		'line_height',
		'letter_spacing'
	) as $nanospace_prop
) {
	$nanospace_add[ 'header_mobile_vertical_bar_' . $nanospace_prop ] = array(
		array(
			'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
			'element'  => '.nanospace-header-mobile-vertical-bar',
			'property' => str_replace( '_', '-', $nanospace_prop ),
		),
	);
}

foreach (
	array(
		'font_family',
		'font_weight',
		'font_style',
		'text_transform',
		'font_size',
		'line_height',
		'letter_spacing'
	) as $nanospace_prop
) {
	$nanospace_add[ 'header_mobile_vertical_bar_menu_' . $nanospace_prop ] = array(
		array(
			'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
			'element'  => '.nanospace-header-mobile-vertical-bar .menu .menu-item > .nanospace-menu-item-link, .nanospace-header-mobile-vertical-bar .menu-item > .nanospace-toggle',
			'property' => str_replace( '_', '-', $nanospace_prop ),
		),
	);
}

foreach (
	array(
		'font_family',
		'font_weight',
		'font_style',
		'text_transform',
		'font_size',
		'line_height',
		'letter_spacing'
	) as $nanospace_prop
) {
	$nanospace_add[ 'header_mobile_vertical_bar_submenu_' . $nanospace_prop ] = array(
		array(
			'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
			'element'  => '.nanospace-header-mobile-vertical-bar .menu .sub-menu .menu-item > .nanospace-menu-item-link, .nanospace-header-mobile-vertical-bar .sub-menu .menu-item > .nanospace-toggle',
			'property' => str_replace( '_', '-', $nanospace_prop ),
		),
	);
}

$nanospace_add['header_mobile_vertical_bar_icon_size'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar .nanospace-menu-icon',
		'property' => 'font-size',
	),
);

$nanospace_add['header_mobile_vertical_bar_bg_color']               = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar-inner',
		'property' => 'background-color',
	),
);
$nanospace_add['header_mobile_vertical_bar_border_color']           = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar *',
		'property' => 'border-color',
	),
);
$nanospace_add['header_mobile_vertical_bar_text_color']             = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar',
		'property' => 'color',
	),
);
$nanospace_add['header_mobile_vertical_bar_link_text_color']        = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar a:not(.button), .nanospace-header-mobile-vertical-bar .nanospace-toggle',
		'property' => 'color',
	),
);
$nanospace_add['header_mobile_vertical_bar_link_hover_text_color']  = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar a:not(.button):hover, .nanospace-header-mobile-vertical-bar a:not(.button):focus, .nanospace-header-mobile-vertical-bar .nanospace-toggle:hover, .nanospace-header-mobile-vertical-bar .nanospace-toggle:focus',
		'property' => 'color',
	),
);
$nanospace_add['header_mobile_vertical_bar_link_active_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-header-mobile-vertical-bar .current-menu-item > .nanospace-menu-item-link, .nanospace-header-mobile-vertical-bar .current-menu-ancestor > .nanospace-menu-item-link',
		'property' => 'color',
	),
);
/**
 * ====================================================
 * Content & Sidebar > Section
 * ====================================================
 */

$nanospace_responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $nanospace_responsive as $nanospace_suffix => $nanospace_media ) {
	$nanospace_add[ 'content_padding' . $nanospace_suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-content-inner',
			'property' => 'padding',
			'media'    => $nanospace_media,
		),
	);
}

/**
 * ====================================================
 * Content & Sidebar > Main Content Area
 * ====================================================
 */

$nanospace_responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $nanospace_responsive as $nanospace_suffix => $nanospace_media ) {
	$nanospace_add[ 'content_main_padding' . $nanospace_suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.content-area .site-main',
			'property' => 'padding',
			'media'    => $nanospace_media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default:first-child .entry-thumbnail.nanospace-entry-thumbnail-ignore-padding:first-child',
			'property' => 'margin-top',
			'pattern'  => '-$ !important',
			'media'    => $nanospace_media,
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 1st part = top
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-thumbnail.nanospace-entry-thumbnail-ignore-padding',
			'property' => 'margin-right',
			'pattern'  => '-$ !important',
			'media'    => $nanospace_media,
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 1 ), // 2nd part = right
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-thumbnail.nanospace-entry-thumbnail-ignore-padding',
			'property' => 'margin-left',
			'pattern'  => '-$ !important',
			'media'    => $nanospace_media,
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4rd part = left
			),
		),
	);
}
$nanospace_add['content_main_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'border-width',
	),
);

$nanospace_add['content_main_bg_color']     = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'background-color',
	),
);
$nanospace_add['content_main_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Sidebar Area
 * ====================================================
 */

$nanospace_add['sidebar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => 'min-width',
	),
);
$nanospace_add['sidebar_gap']   = array(
	array(
		'type'     => 'css',
		'element'  => '.ltr .nanospace-content-layout-right-sidebar .sidebar',
		'property' => 'margin-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl .nanospace-content-layout-right-sidebar .sidebar',
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.ltr .nanospace-content-layout-left-sidebar .sidebar',
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl .nanospace-content-layout-left-sidebar .sidebar',
		'property' => 'margin-right',
	),
);

$nanospace_add['sidebar_widgets_mode'] = array(
	array(
		'type'    => 'class',
		'element' => '.sidebar',
		'pattern' => 'nanospace-sidebar-widgets-mode-$',
	),
);
$nanospace_add['sidebar_widgets_gap']  = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget',
		'property' => 'margin-bottom',
	),
);

$nanospace_responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $nanospace_responsive as $nanospace_suffix => $nanospace_media ) {
	$nanospace_add[ 'sidebar_padding' . $nanospace_suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.sidebar.nanospace-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.nanospace-sidebar-widgets-mode-separated .widget',
			'property' => 'padding',
			'media'    => $nanospace_media,
		),
	);
}
$nanospace_add['sidebar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.nanospace-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.nanospace-sidebar-widgets-mode-separated .widget',
		'property' => 'border-width',
	),
);

foreach (
	array(
		'font_family',
		'font_weight',
		'font_style',
		'text_transform',
		'font_size',
		'line_height',
		'letter_spacing'
	) as $nanospace_prop
) {
	$nanospace_element  = '.sidebar';
	$nanospace_property = str_replace( '_', '-', $nanospace_prop );

	$nanospace_add[ 'sidebar_' . $nanospace_prop ] = array(
		array(
			'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
			'element'  => $nanospace_element,
			'property' => $nanospace_property,
		),
	);

	if ( in_array( $nanospace_prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$nanospace_add[ 'sidebar_' . $nanospace_prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$nanospace_add[ 'sidebar_' . $nanospace_prop . '__mobile' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

foreach (
	array(
		'font_family',
		'font_weight',
		'font_style',
		'text_transform',
		'font_size',
		'line_height',
		'letter_spacing'
	) as $nanospace_prop
) {
	$nanospace_element  = '.sidebar .widget-title';
	$nanospace_property = str_replace( '_', '-', $nanospace_prop );

	$nanospace_add[ 'sidebar_widget_title_' . $nanospace_prop ] = array(
		array(
			'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
			'element'  => $nanospace_element,
			'property' => $nanospace_property,
		),
	);

	if ( in_array( $nanospace_prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$nanospace_add[ 'sidebar_widget_title_' . $nanospace_prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$nanospace_add[ 'sidebar_widget_title_' . $nanospace_prop . '__mobile' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$nanospace_add['sidebar_widget_title_alignment']  = array(
	array(
		'type'    => 'class',
		'element' => '.sidebar',
		'pattern' => 'nanospace-widget-title-alignment-$',
	),
);
$nanospace_add['sidebar_widget_title_decoration'] = array(
	array(
		'type'    => 'class',
		'element' => '.sidebar',
		'pattern' => 'nanospace-widget-title-decoration-$',
	),
);

$nanospace_add['sidebar_bg_color']                  = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.nanospace-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.nanospace-sidebar-widgets-mode-separated .widget',
		'property' => 'background-color',
	),
);
$nanospace_add['sidebar_border_color']              = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar *',
		'property' => 'border-color',
	),
);
$nanospace_add['sidebar_text_color']                = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => 'color',
	),
);
$nanospace_add['sidebar_link_text_color']           = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar a',
		'property' => 'color',
	),
);
$nanospace_add['sidebar_link_hover_text_color']     = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar a:hover, .sidebar a:focus',
		'property' => 'color',
	),
);
$nanospace_add['sidebar_widget_title_text_color']   = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget-title',
		'property' => 'color',
	),
);
$nanospace_add['sidebar_widget_title_bg_color']     = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.nanospace-widget-title-decoration-box .widget-title',
		'property' => 'background-color',
	),
);
$nanospace_add['sidebar_widget_title_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget-title',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Footer > Widgets Bar
 * ====================================================
 */

$nanospace_add['footer_widgets_bar_container'] = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-footer-widgets-bar',
		'pattern' => 'nanospace-section-$',
	),
);
$nanospace_responsive                          = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $nanospace_responsive as $nanospace_suffix => $nanospace_media ) {
	$nanospace_add[ 'footer_widgets_bar_padding' . $nanospace_suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-footer-widgets-bar-inner',
			'property' => 'padding',
			'media'    => $nanospace_media,
		),
	);
}
$nanospace_add['footer_widgets_bar_border']         = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar-inner',
		'property' => 'border-width',
	),
);
$nanospace_add['footer_widgets_bar_columns_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar-column',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar-row',
		'property' => 'margin-left',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar-row',
		'property' => 'margin-right',
		'pattern'  => '-$',
	),
);
$nanospace_add['footer_widgets_bar_widgets_gap']    = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar .widget',
		'property' => 'margin-bottom',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar-row',
		'property' => 'margin-bottom',
		'pattern'  => '-$',
	),
);

foreach (
	array(
		'font_family',
		'font_weight',
		'font_style',
		'text_transform',
		'font_size',
		'line_height',
		'letter_spacing'
	) as $nanospace_prop
) {
	$nanospace_element  = '.nanospace-footer-widgets-bar';
	$nanospace_property = str_replace( '_', '-', $nanospace_prop );

	$nanospace_add[ 'footer_widgets_bar_' . $nanospace_prop ] = array(
		array(
			'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
			'element'  => $nanospace_element,
			'property' => $nanospace_property,
		),
	);

	if ( in_array( $nanospace_prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$nanospace_add[ 'footer_widgets_bar_' . $nanospace_prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$nanospace_add[ 'footer_widgets_bar_' . $nanospace_prop . '__mobile' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

foreach (
	array(
		'font_family',
		'font_weight',
		'font_style',
		'text_transform',
		'font_size',
		'line_height',
		'letter_spacing'
	) as $nanospace_prop
) {
	$nanospace_element  = '.nanospace-footer-widgets-bar .widget-title';
	$nanospace_property = str_replace( '_', '-', $nanospace_prop );

	$nanospace_add[ 'footer_widgets_bar_widget_title_' . $nanospace_prop ] = array(
		array(
			'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
			'element'  => $nanospace_element,
			'property' => $nanospace_property,
		),
	);

	if ( in_array( $nanospace_prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$nanospace_add[ 'footer_widgets_bar_widget_title_' . $nanospace_prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$nanospace_add[ 'footer_widgets_bar_widget_title_' . $nanospace_prop . '__mobile' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$nanospace_add['footer_widgets_bar_widget_title_alignment']  = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-footer-widgets-bar',
		'pattern' => 'nanospace-widget-title-alignment-$',
	),
);
$nanospace_add['footer_widgets_bar_widget_title_decoration'] = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-footer-widgets-bar',
		'pattern' => 'nanospace-widget-title-decoration-$',
	),
);

$nanospace_add['footer_widgets_bar_bg_color']                  = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar-inner',
		'property' => 'background-color',
	),
);
$nanospace_add['footer_widgets_bar_border_color']              = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar *',
		'property' => 'border-color',
	),
);
$nanospace_add['footer_widgets_bar_text_color']                = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar',
		'property' => 'color',
	),
);
$nanospace_add['footer_widgets_bar_link_text_color']           = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar a:not(.button)',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar .woocommerce.widget_price_filter .price_slider',
		'property' => 'color',
	),
);
$nanospace_add['footer_widgets_bar_link_hover_text_color']     = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar a:not(.button):hover, .nanospace-footer-widgets-bar a:not(.button):focus',
		'property' => 'color',
	),
);
$nanospace_add['footer_widgets_bar_widget_title_text_color']   = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar .widget-title',
		'property' => 'color',
	),
);
$nanospace_add['footer_widgets_bar_widget_title_bg_color']     = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar.nanospace-widget-title-decoration-box .widget-title',
		'property' => 'background-color',
	),
);
$nanospace_add['footer_widgets_bar_widget_title_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-widgets-bar .widget-title',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Footer > Top Bar
 * ====================================================
 */

$nanospace_add['footer_top_bar_merged_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar.nanospace-section-merged',
		'property' => 'margin-top',
	),
);

$nanospace_add['footer_top_bar_container'] = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-footer-top-bar',
		'pattern' => 'nanospace-section-$',
	),
);

$nanospace_add['footer_top_bar_container'] = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-footer-top-bar',
		'pattern' => 'nanospace-section-$',
	),
);

$nanospace_responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $nanospace_responsive as $nanospace_suffix => $nanospace_media ) {
	$nanospace_add[ 'footer_top_bar_padding' . $nanospace_suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-footer-top-bar-inner',
			'property' => 'padding',
			'media'    => $nanospace_media,
		),
	);
}
$nanospace_add['footer_top_bar_border']       = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar-inner',
		'property' => 'border-width',
	),
);
$nanospace_add['footer_top_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar .nanospace-footer-column > *',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar-row',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar .nanospace-top-menu .menu-item',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
);

foreach (
	array(
		'font_family',
		'font_weight',
		'font_style',
		'text_transform',
		'font_size',
		'line_height',
		'letter_spacing'
	) as $nanospace_prop
) {
	$nanospace_element  = '.nanospace-top-bottom-bar';
	$nanospace_property = str_replace( '_', '-', $nanospace_prop );

	$nanospace_add[ 'footer_top_bar_' . $nanospace_prop ] = array(
		array(
			'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
			'element'  => $nanospace_element,
			'property' => $nanospace_property,
		),
	);

	if ( in_array( $nanospace_prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$nanospace_add[ 'footer_top_bar_' . $nanospace_prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$nanospace_add[ 'footer_top_bar_' . $nanospace_prop . '__mobile' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$nanospace_add['footer_top_bar_bg_color']              = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar-inner',
		'property' => 'background-color',
	),
);
$nanospace_add['footer_top_bar_border_color']          = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar-inner',
		'property' => 'border-color',
	),
);
$nanospace_add['footer_top_bar_text_color']            = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar',
		'property' => 'color',
	),
);
$nanospace_add['footer_top_bar_link_text_color']       = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar a:not(.button)',
		'property' => 'color',
	),
);
$nanospace_add['footer_top_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-top-bar a:not(.button):hover, .nanospace-footer-top-bar a:not(.button):focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$nanospace_add['footer_bottom_bar_merged_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar.nanospace-section-merged',
		'property' => 'margin-top',
	),
);

$nanospace_add['footer_bottom_bar_container'] = array(
	array(
		'type'    => 'class',
		'element' => '.nanospace-footer-bottom-bar',
		'pattern' => 'nanospace-section-$',
	),
);

$nanospace_responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $nanospace_responsive as $nanospace_suffix => $nanospace_media ) {
	$nanospace_add[ 'footer_bottom_bar_padding' . $nanospace_suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.nanospace-footer-bottom-bar-inner',
			'property' => 'padding',
			'media'    => $nanospace_media,
		),
	);
}
$nanospace_add['footer_bottom_bar_border']       = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar-inner',
		'property' => 'border-width',
	),
);
$nanospace_add['footer_bottom_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar .nanospace-footer-column > *',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar-row',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar .nanospace-footer-menu .menu-item',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
);

foreach (
	array(
		'font_family',
		'font_weight',
		'font_style',
		'text_transform',
		'font_size',
		'line_height',
		'letter_spacing'
	) as $nanospace_prop
) {
	$nanospace_element  = '.nanospace-footer-bottom-bar';
	$nanospace_property = str_replace( '_', '-', $nanospace_prop );

	$nanospace_add[ 'footer_bottom_bar_' . $nanospace_prop ] = array(
		array(
			'type'     => 'font_family' === $nanospace_prop ? 'font' : 'css',
			'element'  => $nanospace_element,
			'property' => $nanospace_property,
		),
	);

	if ( in_array( $nanospace_prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$nanospace_add[ 'footer_bottom_bar_' . $nanospace_prop . '__tablet' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$nanospace_add[ 'footer_bottom_bar_' . $nanospace_prop . '__mobile' ] = array(
			array(
				'type'     => 'css',
				'element'  => $nanospace_element,
				'property' => $nanospace_property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$nanospace_add['footer_bottom_bar_bg_color']              = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar-inner',
		'property' => 'background-color',
	),
);
$nanospace_add['footer_bottom_bar_border_color']          = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar-inner',
		'property' => 'border-color',
	),
);
$nanospace_add['footer_bottom_bar_text_color']            = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar',
		'property' => 'color',
	),
);
$nanospace_add['footer_bottom_bar_link_text_color']       = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar a:not(.button)',
		'property' => 'color',
	),
);
$nanospace_add['footer_bottom_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.nanospace-footer-bottom-bar a:not(.button):hover, .nanospace-footer-bottom-bar a:not(.button):focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Footer > Social
 * ====================================================
 */

// Social links
$nanospace_add['footer_social_links_target'] = array(
	array(
		'type'     => 'html',
		'element'  => '.nanospace-footer-social-links a',
		'property' => 'target',
		'pattern'  => '_$',
	),
);
$nanospace_postmessages = array_merge_recursive( $postmessages, $nanospace_add );