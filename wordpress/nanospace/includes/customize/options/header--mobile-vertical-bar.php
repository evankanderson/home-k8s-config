<?php
/**
 * Customizer settings: Header > Mobile Drawer (Popup)
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_header_mobile_vertical_bar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Position.
$nanospace_key = 'header_mobile_vertical_bar_position';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Position', 'nanospace' ),
	'choices'  => array(
		'left'  => is_rtl() ? esc_html__( 'Right', 'nanospace' ) : esc_html__( 'Left', 'nanospace' ),
		'right' => is_rtl() ? esc_html__( 'Left', 'nanospace' ) : esc_html__( 'Right', 'nanospace' ),
	),
	'priority' => 10,
) );

// Alignment.
$nanospace_key = 'header_mobile_vertical_bar_alignment';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Alignment', 'nanospace' ),
	'choices'  => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'nanospace' ) : esc_html__( 'Left', 'nanospace' ),
		'center' => esc_html__( 'Center', 'nanospace' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'nanospace' ) : esc_html__( 'Right', 'nanospace' ),
	),
	'priority' => 10,
) );

// Width.
$nanospace_key = 'header_mobile_vertical_bar_width';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new NanoSpace_Customize_Control_Slider( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Width', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 120,
			'max'  => 400,
			'step' => 1,
		),
	),
	'priority' => 10,
) ) );

// Padding.
$nanospace_key = 'header_mobile_vertical_bar_padding';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new NanoSpace_Customize_Control_Dimensions( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Padding', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'step' => 0.05,
		),
		'%'  => array(
			'min'  => 0,
			'step' => 0.01,
		),
	),
	'priority' => 10,
) ) );

// Items gutter.
$nanospace_key = 'header_mobile_vertical_bar_items_gutter';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new NanoSpace_Customize_Control_Slider( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Spacing between elements', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority' => 10,
) ) );

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// Heading: Typography.
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_vertical_bar_typography', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => esc_html__( 'Typography', 'nanospace' ),
	'priority' => 20,
) ) );

// Text typography.
$nanospace_settings = array(
	'font_family'    => 'header_mobile_vertical_bar_font_family',
	'font_weight'    => 'header_mobile_vertical_bar_font_weight',
	'font_style'     => 'header_mobile_vertical_bar_font_style',
	'text_transform' => 'header_mobile_vertical_bar_text_transform',
	'font_size'      => 'header_mobile_vertical_bar_font_size',
	'line_height'    => 'header_mobile_vertical_bar_line_height',
	'letter_spacing' => 'header_mobile_vertical_bar_letter_spacing',
);

foreach ( $nanospace_settings as $nanospace_key ) {
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'typography' ),
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Typography( $wp_customize, 'header_mobile_vertical_bar_typography', array(
	'settings' => $nanospace_settings,
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Text typography', 'nanospace' ),
	'priority' => 20,
) ) );

// Menu link typography.
$nanospace_settings = array(
	'font_family'    => 'header_mobile_vertical_bar_menu_font_family',
	'font_weight'    => 'header_mobile_vertical_bar_menu_font_weight',
	'font_style'     => 'header_mobile_vertical_bar_menu_font_style',
	'text_transform' => 'header_mobile_vertical_bar_menu_text_transform',
	'font_size'      => 'header_mobile_vertical_bar_menu_font_size',
	'line_height'    => 'header_mobile_vertical_bar_menu_line_height',
	'letter_spacing' => 'header_mobile_vertical_bar_menu_letter_spacing',
);

foreach ( $nanospace_settings as $nanospace_key ) {
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'typography' ),
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Typography( $wp_customize, 'header_mobile_vertical_bar_menu_typography', array(
	'settings' => $nanospace_settings,
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Menu link typography', 'nanospace' ),
	'priority' => 20,
) ) );

// Submenu link typography.
$nanospace_settings = array(
	'font_family'    => 'header_mobile_vertical_bar_submenu_font_family',
	'font_weight'    => 'header_mobile_vertical_bar_submenu_font_weight',
	'font_style'     => 'header_mobile_vertical_bar_submenu_font_style',
	'text_transform' => 'header_mobile_vertical_bar_submenu_text_transform',
	'font_size'      => 'header_mobile_vertical_bar_submenu_font_size',
	'line_height'    => 'header_mobile_vertical_bar_submenu_line_height',
	'letter_spacing' => 'header_mobile_vertical_bar_submenu_letter_spacing',
);

foreach ( $nanospace_settings as $nanospace_key ) {
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'typography' ),
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Typography( $wp_customize, 'header_mobile_vertical_bar_submenu_typography', array(
	'settings' => $nanospace_settings,
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Submenu link typography', 'nanospace' ),
	'priority' => 20,
) ) );

// Icon size.
$nanospace_key = 'header_mobile_vertical_bar_icon_size';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
) );

$wp_customize->add_control( new NanoSpace_Customize_Control_Slider( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Icon size', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 0,
			'max'  => 60,
			'step' => 1,
		),
	),
	'priority' => 20,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors.
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_vertical_bar_colors', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => esc_html__( 'Colors', 'nanospace' ),
	'priority' => 30,
) ) );

// Colors.
$nanospace_colors = array(
	'header_mobile_vertical_bar_bg_color'               => esc_html__( 'Background color', 'nanospace' ),
	'header_mobile_vertical_bar_border_color'           => esc_html__( 'Border color', 'nanospace' ),
	'header_mobile_vertical_bar_text_color'             => esc_html__( 'Text color', 'nanospace' ),
	'header_mobile_vertical_bar_link_text_color'        => esc_html__( 'Link text color', 'nanospace' ),
	'header_mobile_vertical_bar_link_hover_text_color'  => esc_html__( 'Link text color :hover', 'nanospace' ),
	'header_mobile_vertical_bar_link_active_text_color' => esc_html__( 'Link text color :active', 'nanospace' ),
);

foreach ( $nanospace_colors as $nanospace_key => $nanospace_label ) {
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new NanoSpace_Customize_Control_Color( $wp_customize, $nanospace_key, array(
		'section'  => $nanospace_section,
		'label'    => $nanospace_label,
		'priority' => 30,
	) ) );
}
