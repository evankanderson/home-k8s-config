<?php
/**
 * Customizer settings: Header > Button
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_header_button';

/**
 * ====================================================
 * Button 1 to 7
 * ====================================================
 */

 //TODO: Why is this not a loop?

// Heading: Button.
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_button_1', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of Button element. */
	'label'    => sprintf( esc_html__( 'Button %s', 'nanospace' ), 1 ),
	'priority' => 10,
) ) );

// Content button1.
$nanospace_key = 'header_button_1_id';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button id.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_1_link';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'url',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button link, use full URL with http:// or https://', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_1_text';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button text.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_1_class';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button class.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_1_target';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Button Open links in', 'nanospace' ),
	'choices'  => array(
		'self'  => esc_html__( 'Same tab', 'nanospace' ),
		'blank' => esc_html__( 'New tab', 'nanospace' ),
	),
	'priority' => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_1_id', array(
		'selector'            => '.nanospace-header-button-1',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_1',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_1_link', array(
		'selector'            => '.nanospace-header-button-1',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_1',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_1_text', array(
		'selector'            => '.nanospace-header-button-1',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_1',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_1_class', array(
		'selector'            => '.nanospace-header-button-1',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_1',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_1_target', array(
		'selector'            => '.nanospace-header-button-1',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_1',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_button_2', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of Button element. */
	'label'    => sprintf( esc_html__( 'Button %s', 'nanospace' ), 2 ),
	'priority' => 10,
) ) );

//button2.
$nanospace_key = 'header_button_2_id';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button id.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_2_text';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button text.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_2_link';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'url',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button link, use full URL with http:// or https://', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_2_class';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button class.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_2_target';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Button Open links in', 'nanospace' ),
	'choices'  => array(
		'self'  => esc_html__( 'Same tab', 'nanospace' ),
		'blank' => esc_html__( 'New tab', 'nanospace' ),
	),
	'priority' => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_2_id', array(
		'selector'            => '.nanospace-header-button-2',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_2',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_2_link', array(
		'selector'            => '.nanospace-header-button-2',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_2',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_2_text', array(
		'selector'            => '.nanospace-header-button-2',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_2',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_2_class', array(
		'selector'            => '.nanospace-header-button-2',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_2',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_2_target', array(
		'selector'            => '.nanospace-header-button-2',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_2',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_button_3', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of Button element. */
	'label'    => sprintf( esc_html__( 'Button %s', 'nanospace' ), 3 ),
	'priority' => 10,
) ) );

//button3.
$nanospace_key = 'header_button_3_id';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button id.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_3_text';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button text.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_3_link';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'url',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button link, use full URL with http:// or https://', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_3_class';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button class.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_3_target';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Button Open links in', 'nanospace' ),
	'choices'  => array(
		'self'  => esc_html__( 'Same tab', 'nanospace' ),
		'blank' => esc_html__( 'New tab', 'nanospace' ),
	),
	'priority' => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_3_id', array(
		'selector'            => '.nanospace-header-button-3',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_3',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_3_link', array(
		'selector'            => '.nanospace-header-button-3',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_3',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_3_text', array(
		'selector'            => '.nanospace-header-button-3',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_3',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_3_class', array(
		'selector'            => '.nanospace-header-button-3',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_3',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_3_target', array(
		'selector'            => '.nanospace-header-button-3',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_3',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_button_4', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of Button element. */
	'label'    => sprintf( esc_html__( 'Button %s', 'nanospace' ), 4 ),
	'priority' => 10,
) ) );

//button4.
$nanospace_key = 'header_button_4_id';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button id.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_4_text';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button text.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_4_link';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'url',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button link, use full URL with http:// or https://', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_4_class';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button class.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_4_target';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Button Open links in', 'nanospace' ),
	'choices'  => array(
		'self'  => esc_html__( 'Same tab', 'nanospace' ),
		'blank' => esc_html__( 'New tab', 'nanospace' ),
	),
	'priority' => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_4_id', array(
		'selector'            => '.nanospace-header-button-4',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_4',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_4_link', array(
		'selector'            => '.nanospace-header-button-4',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_4',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_4_text', array(
		'selector'            => '.nanospace-header-button-4',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_4',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_4_class', array(
		'selector'            => '.nanospace-header-button-4',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_4',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_4_target', array(
		'selector'            => '.nanospace-header-button-4',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_4',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_button_5', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of Button element. */
	'label'    => sprintf( esc_html__( 'Button %s', 'nanospace' ), 5 ),
	'priority' => 10,
) ) );

//button5.
$nanospace_key = 'header_button_5_id';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button id.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_5_text';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button text.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_5_link';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'url',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button link, use full URL with http:// or https://', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_5_class';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button class.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_5_target';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Button Open links in', 'nanospace' ),
	'choices'  => array(
		'self'  => esc_html__( 'Same tab', 'nanospace' ),
		'blank' => esc_html__( 'New tab', 'nanospace' ),
	),
	'priority' => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_5_id', array(
		'selector'            => '.nanospace-header-button-5',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_5',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_5_link', array(
		'selector'            => '.nanospace-header-button-5',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_5',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_5_text', array(
		'selector'            => '.nanospace-header-button-5',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_5',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_5_class', array(
		'selector'            => '.nanospace-header-button-5',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_5',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_5_target', array(
		'selector'            => '.nanospace-header-button-5',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_5',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_button_6', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of Button element. */
	'label'    => sprintf( esc_html__( 'Button %s', 'nanospace' ), 6 ),
	'priority' => 10,
) ) );

//button6
$nanospace_key = 'header_button_6_id';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button id.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_6_text';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button text.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_6_link';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'url',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button link, use full URL with http:// or https://', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_6_class';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button class.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_6_target';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Button Open links in', 'nanospace' ),
	'choices'  => array(
		'self'  => esc_html__( 'Same tab', 'nanospace' ),
		'blank' => esc_html__( 'New tab', 'nanospace' ),
	),
	'priority' => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_6_id', array(
		'selector'            => '.nanospace-header-button-6',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_6',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_6_link', array(
		'selector'            => '.nanospace-header-button-6',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_6',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_6_text', array(
		'selector'            => '.nanospace-header-button-6',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_6',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_6_class', array(
		'selector'            => '.nanospace-header-button-6',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_6',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_6_target', array(
		'selector'            => '.nanospace-header-button-6',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_6',
		'fallback_refresh'    => false,
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_button_7', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	/* translators: %s: number of Button element. */
	'label'    => sprintf( esc_html__( 'Button %s', 'nanospace' ), 7 ),
	'priority' => 10,
) ) );

$nanospace_key = 'header_button_7_id';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button id.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_7_text';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button text.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_7_link';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => 'esc_url_raw',
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'url',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button link, use full URL with http:// or https://', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_7_class';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'text',
	'section'     => $nanospace_section,
	'description' => esc_html__( 'Button class.', 'nanospace' ),
	'priority'    => 10,
) );

$nanospace_key = 'header_button_7_target';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Button Open links in', 'nanospace' ),
	'choices'  => array(
		'self'  => esc_html__( 'Same tab', 'nanospace' ),
		'blank' => esc_html__( 'New tab', 'nanospace' ),
	),
	'priority' => 10,
) );

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_7_id', array(
		'selector'            => '.nanospace-header-button-7',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_7',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_7_link', array(
		'selector'            => '.nanospace-header-button-7',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_7',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_7_text', array(
		'selector'            => '.nanospace-header-button-7',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_7',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_7_class', array(
		'selector'            => '.nanospace-header-button-7',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_7',
		'fallback_refresh'    => false,
	) );
}

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'header_button_7_target', array(
		'selector'            => '.nanospace-header-button-7',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_header_element__button_7',
		'fallback_refresh'    => false,
	) );
}
