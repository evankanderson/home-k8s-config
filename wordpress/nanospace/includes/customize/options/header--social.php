<?php
/**
 * Customizer settings: Header > Social Links
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_header_social';

/**
 * ====================================================
 * Social Links
 * ====================================================
 */

// Heading: Social Links.
$wp_customize->add_control(
	new NanoSpace_Customize_Control_Heading(
		$wp_customize,
		'heading_header_social',
		array(
			'section'     => $nanospace_section,
			'settings'    => array(),
			'label'       => esc_html__( 'Social Links', 'nanospace' ),
			'description' => sprintf(
			/* translators: %s: link to "Global Settings" section. */
				esc_html__( 'You can edit Social Media URLs via %s.', 'nanospace' ),
				'<a href="' . esc_attr( add_query_arg( 'autofocus[panel]', 'nanospace_panel_global_settings', remove_query_arg( 'autofocus' ) ) ) . '" class="nanospace-customize-goto-control">' . esc_html__( 'Global Settings', 'nanospace' ) . '</a>'
			),
			'priority'    => 10,
		)
	)
);

// Social links.
$nanospace_key = 'header_social_links';
$wp_customize->add_setting(
	$nanospace_key,
	array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'multiselect' ),
	)
);

$wp_customize->add_control(
	new NanoSpace_Customize_Control_Builder(
		$wp_customize,
		$nanospace_key,
		array(
			'section'  => $nanospace_section,
			'label'    => esc_html__( 'Active links', 'nanospace' ),
			'choices'  => nanospace_get_social_media_types(),
			'priority' => 10,
		)
	)
);

// Selective Refresh.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		$nanospace_key,
		array(
			'selector'            => '.nanospace-header-social',
			'container_inclusive' => true,
			'render_callback'     => 'nanospace_header_element__social',
			'fallback_refresh'    => false,
		)
	);
}

// Social links target.
$nanospace_key = 'header_social_links_target';
$wp_customize->add_setting(
	$nanospace_key,
	array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
	)
);

$wp_customize->add_control(
	$nanospace_key,
	array(
		'type'     => 'select',
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Open links in', 'nanospace' ),
		'choices'  => array(
			'self'  => esc_html__( 'Same tab', 'nanospace' ),
			'blank' => esc_html__( 'New tab', 'nanospace' ),
		),
		'priority' => 10,
	)
);
