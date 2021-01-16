<?php
/**
 * Customizer settings: Header > Cart
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_header_cart';

/**
 * ====================================================
 * Colors
 * ====================================================
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	// Notice.
	$wp_customize->add_control( new NanoSpace_Customize_Control_Blank( $wp_customize, 'notice_header_cart', array(
		'section'     => $nanospace_section,
		'settings'    => array(),
		'description' => '<div class="notice notice-warning notice-alt inline"><p>' . esc_html__( 'Only available if WooCommerce plugin is installed and activated.', 'nanospace' ) . '</p></div>',
		'priority'    => 10,
	) ) );
}

// Colors.
$nanospace_colors = array(
	'header_cart_count_bg_color'   => esc_html__( 'Cart count BG color', 'nanospace' ),
	'header_cart_count_text_color' => esc_html__( 'Cart count text color', 'nanospace' ),
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
		'priority' => 10,
	) ) );
}
