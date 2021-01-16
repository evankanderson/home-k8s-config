<?php
/**
 * Created by PhpStorm.
 * User: dev2
 * Date: 31/10/19
 * Time: 4:58 PM
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_header_layout';

$nanospace_key = 'nanospace_header_enable';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'sanitize_callback' => array( 'NanoSpace_Customizer_Sanitization', 'toggle' ),
) );

$wp_customize->add_control( new NanoSpace_Customize_Control_Toggle( $wp_customize, $nanospace_key, array(
	'section'     => $nanospace_section,
	'label'       => esc_html__( 'Enable Header Builder', 'nanospace' ),
	'description' => esc_html__( 'Enable or disable header builder.', 'nanospace' ),
	'priority'    => 10,
) ) );

// Top level menu items highlight.
$nanospace_key = 'nanospace_section_header_layout_select';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Header Layouts', 'nanospace' ),
	'choices'  => array(
		'standard-header' => esc_html__( 'Standard Header', 'nanospace' ),
		'left-header'     => esc_html__( 'Left Aligned Vertical Header', 'nanospace' ),
		'right-header'    => esc_html__( 'Right Aligned Vertical Header', 'nanospace' ),
		'no-header'       => esc_html__( 'No Header', 'nanospace' )
	),
	'priority' => 10,
) );

// Off canvas menu position.
$nanospace_key = 'nanospace_section_header_off_canvas_position';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Off Canvas Position', 'nanospace' ),
	'choices'  => array(
		'left'  => esc_html__( 'Left', 'nanospace' ),
		'right' => esc_html__( 'Right', 'nanospace' ),
	),
	'priority' => 10,
) );

// Off canvas menu align.
$nanospace_key = 'nanospace_section_header_off_canvas_align';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Off Canvas Align', 'nanospace' ),
	'choices'  => array(
		'left'   => esc_html__( 'Left', 'nanospace' ),
		'center' => esc_html__( 'Center', 'nanospace' ),
		'right'  => esc_html__( 'Right', 'nanospace' ),
	),
	'priority' => 10,
) );

// vertical header background color.
// Colors.
$nanospace_colors = array(
	'vertical_header_bg_color' => esc_html__( 'Vertical Header Background color', 'nanospace' ),
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

$nanospace_section = "nanospace_section_header_off_canvas_layout";

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_off_canvas-menu', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => sprintf( esc_html__( 'Off Canvas', 'nanospace' ), 1 ),
	'priority' => 10,
) ) );

// Colors.
$nanospace_colors = array(
	'off_canvas_header_bg_color' => esc_html__( 'Off Canvas Background color', 'nanospace' ),
	'off_canvas_text_color'      => esc_html__( 'Off Canvas Text color', 'nanospace' ),
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
