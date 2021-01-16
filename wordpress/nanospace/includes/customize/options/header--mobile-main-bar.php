<?php
/**
 * Customizer settings: Header > Mobile Main Bar
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_header_mobile_main_bar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Height.
$nanospace_key = 'header_mobile_main_bar_height';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new NanoSpace_Customize_Control_Slider( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Height', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 20,
			'max'  => 150,
			'step' => 1,
		),
	),
	'priority' => 10,
) ) );

// Padding.
$nanospace_key      = 'header_mobile_main_bar_padding';
$nanospace_settings = array(
	$nanospace_key . '__tablet',
	$nanospace_key . '__mobile',
);

foreach ( $nanospace_settings as $nanospace_setting ) {
	$wp_customize->add_setting( $nanospace_setting, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_setting ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimensions' ),
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Dimensions( $wp_customize, $nanospace_key, array(
	'settings' => $nanospace_settings,
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

// Border.
$nanospace_key = 'header_mobile_main_bar_border';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimensions' ),
) );

$wp_customize->add_control( new NanoSpace_Customize_Control_Dimensions( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Border', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority' => 10,
) ) );

// Items gutter.
$nanospace_key = 'header_mobile_main_bar_items_gutter';
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
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_main_bar_typography', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => esc_html__( 'Typography', 'nanospace' ),
	'priority' => 20,
) ) );

// Icon size.
$nanospace_key = 'header_mobile_main_bar_icon_size';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'NanoSpace_Customizer_Sanitization', 'dimension' ),
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
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_main_bar_colors', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => esc_html__( 'Colors', 'nanospace' ),
	'priority' => 30,
) ) );

// Colors.
$nanospace_colors = array(
	'header_mobile_main_bar_bg_color'              => esc_html__( 'Background color', 'nanospace' ),
	'header_mobile_main_bar_border_color'          => esc_html__( 'Border color', 'nanospace' ),
	'header_mobile_main_bar_link_text_color'       => esc_html__( 'Link text color', 'nanospace' ),
	'header_mobile_main_bar_link_hover_text_color' => esc_html__( 'Link text color :hover', 'nanospace' ),
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
