<?php
/**
 * Customizer settings: Header > HTML
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_header_html';

/**
 * ====================================================
 * HTML 1 to 7
 * ====================================================
 */

 // TODO: Why is this not a loop?

// Heading: HTML.
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_html_1', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of HTML element. */
	'label'    => sprintf( esc_html__( 'HTML %s', 'nanospace' ), 1 ),
	'priority' => 10,
) ) );

// Content.
$nanospace_key = 'header_html_1_content';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'html' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'textarea',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcodes are allowed.', 'nanospace' ),
	'priority'    => 10,
) );

// Selective Refresh.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $nanospace_key, array(
		'selector'            => '.nanospace-header-html-1',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__html_1',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_html_2', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of HTML element. */
	'label'    => sprintf( esc_html__( 'HTML %s', 'nanospace' ), 2 ),
	'priority' => 10,
) ) );

$nanospace_key = 'header_html_2_content';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'html' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'textarea',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcodes are allowed.', 'nanospace' ),
	'priority'    => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $nanospace_key, array(
		'selector'            => '.nanospace-header-html-2',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__html_2',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_html_3', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of HTML element. */
	'label'    => sprintf( esc_html__( 'HTML %s', 'nanospace' ), 3 ),
	'priority' => 10,
) ) );

$nanospace_key = 'header_html_3_content';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'html' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'textarea',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcodes are allowed.', 'nanospace' ),
	'priority'    => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $nanospace_key, array(
		'selector'            => '.nanospace-header-html-3',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__html_3',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_html_4', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of HTML element. */
	'label'    => sprintf( esc_html__( 'HTML %s', 'nanospace' ), 4 ),
	'priority' => 10,
) ) );

$nanospace_key = 'header_html_4_content';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'html' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'textarea',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcodes are allowed.', 'nanospace' ),
	'priority'    => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $nanospace_key, array(
		'selector'            => '.nanospace-header-html-4',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__html_4',
		'fallback_refresh'    => false,
	) );
}
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_html_5', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of HTML element. */
	'label'    => sprintf( esc_html__( 'HTML %s', 'nanospace' ), 5 ),
	'priority' => 10,
) ) );

$nanospace_key = 'header_html_5_content';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'html' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'textarea',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcodes are allowed.', 'nanospace' ),
	'priority'    => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $nanospace_key, array(
		'selector'            => '.nanospace-header-html-5',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__html_5',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_html_6', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of HTML element. */
	'label'    => sprintf( esc_html__( 'HTML %s', 'nanospace' ), 6 ),
	'priority' => 10,
) ) );

$nanospace_key = 'header_html_6_content';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'html' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'textarea',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcodes are allowed.', 'nanospace' ),
	'priority'    => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $nanospace_key, array(
		'selector'            => '.nanospace-header-html-6',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__html_6',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_html_7', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of HTML element. */
	'label'    => sprintf( esc_html__( 'HTML %s', 'nanospace' ), 7 ),
	'priority' => 10,
) ) );

$nanospace_key = 'header_html_7_content';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'html' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'textarea',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcodes are allowed.', 'nanospace' ),
	'priority'    => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $nanospace_key, array(
		'selector'            => '.nanospace-header-html-7',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__html_7',
		'fallback_refresh'    => false,
	) );
}
