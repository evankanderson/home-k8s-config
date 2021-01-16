<?php
/**
 * Customizer settings: Footer > Copyright
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_footer_copyright';

/**
 * ====================================================
 * Copyright
 * ====================================================
 */

// Heading: HTML.
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_footer_copyright', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => esc_html__( 'Copyright', 'nanospace' ),
	'priority' => 10,
) ) );

// Copyright.
$nanospace_key = 'footer_copyright_content';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'html' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'        => 'textarea',
	'section'     => $nanospace_section,
	'label'       => esc_html__( 'Copyright Text', 'nanospace' ),
	'description' => esc_html__( 'Available tags: {{year}}, {{sitename}}, {{theme}}, {{themeauthor}}', 'nanospace' ),
	'priority'    => 10,
) );

// Selective Refresh.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $nanospace_key, array(
		'selector'            => '.nanospace-footer-copyright',
		'container_inclusive' => true,
		'render_callback'     => 'nanospace_footer_element__copyright',
		'fallback_refresh'    => false,
	) );
}
