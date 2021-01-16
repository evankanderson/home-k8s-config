<?php
/**
 * Customizer settings: Global Settings > Google Fonts
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_google_fonts';

/**
 * ====================================================
 * Google Fonts
 * ====================================================
 */

// Google Fonts privacy policy.
$wp_customize->add_control( new NanoSpace_Customize_Control_Blank( $wp_customize, 'notice_google_fonts', array(
	'section'     => $nanospace_section,
	'settings'    => array(),
	'description' => '<div class="notice notice-warning notice-alt inline"><p>' . esc_html__( 'Google Fonts would be served from Google\'s server. There are chances that visitor\'s data might be collected by Google. If you do not accept this, you can use "Self-Hosted Google Fonts" plugin to self-host the fonts on your own server. &mdash; If you are not using any Google Fonts on your settings, you can ignore this notice.', 'nanospace' ) . '</p></div>',
	'priority'    => 10,
) ) );

// Additional subsets.
$nanospace_key = 'google_fonts_subsets';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'multiselect' ),
) );

$wp_customize->add_control( new NanoSpace_Customize_Control_MultiCheck( $wp_customize, $nanospace_key, array(
	'section'     => $nanospace_section,
	'label'       => esc_html__( 'Additional character subsets', 'nanospace' ),
	'description' => esc_html__( '"Latin" character subset is included by default.', 'nanospace' ),
	'choices'     => nanospace_get_google_fonts_subsets(),
	'priority'    => 10,
) ) );
