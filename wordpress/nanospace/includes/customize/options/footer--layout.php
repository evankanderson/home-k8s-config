<?php
/**
 * Customizer settings: Footer Layout
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_footer_layout';

$nanospace_key = 'nanospace_footer_enable';

$wp_customize->add_setting(
	$nanospace_key,
	array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'sanitize_callback' => array( 'NanoSpace_Customizer_Sanitization', 'toggle' ),
	)
);

$wp_customize->add_control(
	new NanoSpace_Customize_Control_Toggle(
		$wp_customize,
		$nanospace_key,
		array(
			'section'     => 'nanospace_section_footer_layout',
			'label'       => esc_html__( 'Enable Footer Builder', 'nanospace' ),
			'description' => esc_html__( 'Enable or disable footer builder.', 'nanospace' ),
			'priority'    => 10,
		)
	)
);
