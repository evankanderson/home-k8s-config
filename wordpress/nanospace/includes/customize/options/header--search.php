<?php
/**
 * Customizer settings: Header > Search
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_header_search';

/**
 * ====================================================
 * Search Bar
 * ====================================================
 */

// Heading: Search Bar.
$wp_customize->add_control(
	new NanoSpace_Customize_Control_Heading(
		$wp_customize,
		'heading_header_search_bar',
		array(
			'section'  => $nanospace_section,
			'settings' => array(),
			'label'    => esc_html__( 'Search Bar', 'nanospace' ),
			'priority' => 10,
		)
	)
);

// Search bar width.
$nanospace_key = 'header_search_bar_width';
$wp_customize->add_setting(
	$nanospace_key,
	array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
	)
);

$wp_customize->add_control(
	new NanoSpace_Customize_Control_Dimension(
		$wp_customize,
		$nanospace_key,
		array(
			'section'  => $nanospace_section,
			'label'    => esc_html__( 'Bar width', 'nanospace' ),
			'units'    => array(
				'px' => array(
					'min'  => 100,
					'step' => 1,
				),
			),
			'priority' => 10,
		)
	)
);
