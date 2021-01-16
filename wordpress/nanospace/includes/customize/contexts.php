<?php
/**
 * Customizer control's conditional display.
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
 * Page Canvas & Wrapper
 * ====================================================
 */

$nanospace_add['heading_boxed_page'] =
$nanospace_add['boxed_page_width'] =
$nanospace_add['boxed_page_shadow'] =
$nanospace_add['hr_boxed_page_outside'] =
$nanospace_add['outside_bg_color'] =
$nanospace_add['outside_bg_image'] =
$nanospace_add['outside_bg_position'] =
$nanospace_add['outside_bg_size'] =
$nanospace_add['outside_bg_repeat'] =
$nanospace_add['outside_bg_attachment'] = array(
	array(
		'setting' => 'page_layout',
		'value'   => 'boxed',
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
	$nanospace_add[ 'nanospace_section_header_' . $nanospace_bar ] = array(
		array(
			'setting' => '__device',
			'value'   => 'desktop',
		),
	);

	if ( 'main_bar' !== $nanospace_bar ) {
		$nanospace_add[ 'header_' . $nanospace_bar . '_container' ]  = array(
			array(
				'setting'  => 'header_' . $nanospace_bar . '_merged',
				'operator' => '!=',
				'value'    => 1,
			),
		);
		$nanospace_add[ 'header_' . $nanospace_bar . '_merged_gap' ] = array(
			array(
				'setting'  => 'header_' . $nanospace_bar . '_merged',
				'operator' => '==',
				'value'    => 1,
			),
		);
	}

	$nanospace_add[ 'header_' . $nanospace_bar . '_menu_hover_highlight_color' ] =
	$nanospace_add[ 'header_' . $nanospace_bar . '_menu_hover_highlight_text_color' ] =
	$nanospace_add[ 'header_' . $nanospace_bar . '_menu_active_highlight_color' ] =
	$nanospace_add[ 'header_' . $nanospace_bar . '_menu_active_highlight_text_color' ] = array(
		array(
			'setting'  => 'header_' . $nanospace_bar . '_menu_highlight',
			'operator' => '!=',
			'value'    => 'none',
		),
	);
}

/**
 * ====================================================
 * Header > Mobile Main Bar
 * Header > Mobile Drawer (Popup)
 * ====================================================
 */

$nanospace_add['nanospace_section_header_mobile_main_bar'] =
$nanospace_add['nanospace_section_header_mobile_vertical_bar'] = array(
	array(
		'setting'  => '__device',
		'operator' => 'in',
		'value'    => array( 'tablet', 'mobile' ),
	),
);

/**
 * ====================================================
 * Header > Header Builder
 * ====================================================
 */

// Header Elements
$nanospace_add['header_elements']          = array(
	array(
		'setting' => '__device',
		'value'   => 'desktop',
	),
);
$nanospace_add['header_elements_vertical'] = array(
	array(
		'setting' => '__device',
		'value'   => 'vertical',
	),
);
// Mobile Header Elements
$nanospace_add['header_mobile_elements'] = array(
	array(
		'setting'  => '__device',
		'operator' => 'in',
		'value'    => array( 'tablet', 'mobile' ),
	),
);

/**
 * ====================================================
 * Page Header (Title Bar)
 * ====================================================
 */

$nanospace_add['page_header_layout_width'] = array(
	array(
		'setting'  => 'page_header_layout',
		'operator' => 'in',
		'value'    => array( 'left', 'center', 'right' ),
	),
);

$nanospace_add['breadcrumb_plugin'] =
$nanospace_add['page_header_breadcrumb_typography'] =
$nanospace_add['page_header_breadcrumb_text_color'] =
$nanospace_add['page_header_breadcrumb_link_text_color'] =
$nanospace_add['page_header_breadcrumb_link_hover_text_color'] = array(
	array(
		'setting' => 'page_header_breadcrumb',
		'value'   => 1,
	),
);

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$nanospace_add['footer_top_bar_container']     = array(
	array(
		'setting'  => 'footer_top_bar_merged',
		'operator' => '!=',
		'value'    => 1,
	),
);
$nanospace_add['footer_bottom_bar_container']  = array(
	array(
		'setting'  => 'footer_bottom_bar_merged',
		'operator' => '!=',
		'value'    => 1,
	),
);
$nanospace_add['footer_bottom_bar_merged_gap'] = array(
	array(
		'setting'  => 'footer_bottom_bar_merged',
		'operator' => '==',
		'value'    => 1,
	),
);

/**
 * ====================================================
 * Blog > Posts Page
 * ====================================================
 */

$nanospace_add['blog_index_grid_columns'] =
$nanospace_add['blog_index_grid_columns_gutter'] = array(
	array(
		'setting' => 'blog_index_loop_mode',
		'value'   => 'grid',
	),
);

$nanospace_contexts = array_merge_recursive( $nanospace_contexts, $nanospace_add );