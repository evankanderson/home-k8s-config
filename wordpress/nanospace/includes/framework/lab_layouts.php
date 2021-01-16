<?php

/**
 * SINGLE LAYOUTS
 **/
if ( ! function_exists( 'nanospace_get_single_layouts' ) ) {
	function nanospace_get_single_layouts() {
		return array(
			'sidebar-right'      => esc_html__( 'Right Sidebar', 'nanospace' ),
			'sidebar-left'       => esc_html__( 'Left Sidebar', 'nanospace' ),
			'sidebar-left-right' => esc_html__( 'Left & Right Sidebars', 'nanospace' ),
			'sidebar-none'       => esc_html__( 'No Sidebar', 'nanospace' )
		);
	}
}

/**
 * SCROLL
 **/
if ( ! function_exists( 'nanospace_get_scroll' ) ) {
	function nanospace_get_scroll() {
		return array(
			'yes' => esc_html__( 'Yes', 'nanospace' ),
			'no'  => esc_html__( 'No', 'nanospace' )
		);
	}
}
if ( ! function_exists( 'nanospace_custom_fonts' ) ) {
	function nanospace_custom_fonts() {
		return NanoSpace_Library_Customize::generate_font_dropdown();
	}
}