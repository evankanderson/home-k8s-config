<?php
/**
 * Customizer settings: Header > Logo
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_header_logo';

/**
 * ====================================================
 * Desktop Logo
 * ====================================================
 */

// Heading: Logo.
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_logo', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => esc_html__( 'Logo', 'nanospace' ),
	'priority' => 10,
) ) );

// Logo.
$nanospace_key = 'custom_logo';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $nanospace_key, array(
	'section'   => $nanospace_section,
	'label'     => esc_html__( 'Logo image', 'nanospace' ),
	'mime_type' => 'image',
	'priority'  => 10,
) ) );

// Max width.
$nanospace_key = 'header_logo_width';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new NanoSpace_Customize_Control_Dimension( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Max width', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority' => 10,
) ) );

/**
 * ====================================================
 * Mobile Logo
 * ====================================================
 */

// Heading: Mobile Logo.
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_logo', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => esc_html__( 'Mobile Logo', 'nanospace' ),
	'priority' => 20,
) ) );

// Mobile Logo.
$nanospace_key = 'custom_logo_mobile';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $nanospace_key, array(
	'section'   => $nanospace_section,
	'label'     => esc_html__( 'Mobile Logo image', 'nanospace' ),
	'mime_type' => 'image',
	'priority'  => 20,
) ) );

// Max width.
$nanospace_key = 'header_mobile_logo_width';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new NanoSpace_Customize_Control_Dimension( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Max width', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority' => 20,
) ) );
