<?php
/**
 * Customizer settings:
 * - Header > Top Bar
 * - Header > Main Bar
 * - Header > Bottom Bar
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

foreach ( array( 'top_bar', 'main_bar', 'bottom_bar' ) as $nanospace_bar ) {

	$nanospace_section = 'nanospace_section_header_' . $nanospace_bar;

	/**
	 * ====================================================
	 * Layout
	 * ====================================================
	 */
	if ( $nanospace_bar !== 'main_bar' ) {
		// Merge inside Main Bar.
		$nanospace_key = 'header_' . $nanospace_bar . '_merged';

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
					'section'     => $nanospace_section,
					'label'       => esc_html__( 'Merge inside Main Bar wrapper', 'nanospace' ),
					'description' => esc_html__( 'If enabled, this section layout is limited inside the Main Bar content wrapper. &mdash; Main Bar must have at least 1 element. &mdash; You might need to make the Main Bar height bigger to accommodate this bar height.', 'nanospace' ),
					'priority'    => 10,
				)
			)
		);

		// Merged gap.
		$nanospace_key = 'header_' . $nanospace_bar . '_merged_gap';
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
					'label'    => esc_html__( 'Gap with Main Bar content', 'nanospace' ),
					'units'    => array(
						'px' => array(
							'min'  => 0,
							'step' => 1,
						),
					),
					'priority' => 10,
				)
			)
		);

		$wp_customize->add_control(
			new NanoSpace_Customize_Control_HR(
				$wp_customize, 'hr_header_' . $nanospace_bar . '_merged',
				array(
					'section'  => $nanospace_section,
					'settings' => array(),
					'priority' => 10,
				)
			)
		);
	}

	// Layout.
	$nanospace_key = 'header_' . $nanospace_bar . '_container';
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
	) );

	$wp_customize->add_control( $nanospace_key, array(
		'type'     => 'select',
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Layout', 'nanospace' ),
		'choices'  => array(
			'default'    => esc_html__( 'Full width section, wrapped content', 'nanospace' ),
			'full-width' => esc_html__( 'Full width content', 'nanospace' ),
			'contained'  => esc_html__( 'Contained section', 'nanospace' ),
		),
		'priority' => 10,
	) );

	// Height.
	$nanospace_key = 'header_' . $nanospace_bar . '_height';
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
	) );

	$wp_customize->add_control( new NanoSpace_Customize_Control_Slider( $wp_customize, $nanospace_key, array(
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Height', 'nanospace' ),
		'units'    => array(
			'px' => array(
				'min'  => 20,
				'max'  => 300,
				'step' => 1,
			),
		),
		'priority' => 10,
	) ) );

	// Padding.
	$nanospace_key = 'header_' . $nanospace_bar . '_padding';
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimensions' ),
	) );
	$wp_customize->add_control( new NanoSpace_Customize_Control_Dimensions( $wp_customize, $nanospace_key, array(
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Padding', 'nanospace' ),
		'units'    => array(
			'px' => array(
				'min'  => 0,
				'step' => 1,
			),
			'em' => array(
				'min'  => 0,
				'step' => 0.05,
			),
			'%'  => array(
				'min'  => 0,
				'step' => 0.01,
			),
		),
		'priority' => 10,
	) ) );

	// Border.
	$nanospace_key = 'header_' . $nanospace_bar . '_border';
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimensions' ),
	) );
	$wp_customize->add_control( new NanoSpace_Customize_Control_Dimensions( $wp_customize, $nanospace_key, array(
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Border', 'nanospace' ),
		'units'    => array(
			'px' => array(
				'min'  => 0,
				'step' => 1,
			),
		),
		'priority' => 10,
	) ) );

	// Items gutter.
	$nanospace_key = 'header_' . $nanospace_bar . '_items_gutter';
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
	) );
	$wp_customize->add_control( new NanoSpace_Customize_Control_Slider( $wp_customize, $nanospace_key, array(
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Spacing between elements', 'nanospace' ),
		'units'    => array(
			'px' => array(
				'min'  => 0,
				'max'  => 40,
				'step' => 1,
			),
		),
		'priority' => 10,
	) ) );

	/**
	 * ====================================================
	 * Typography
	 * ====================================================
	 */

	// Heading: Typography.
	$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_' . $nanospace_bar . '_typography', array(
		'section'  => $nanospace_section,
		'settings' => array(),
		'label'    => esc_html__( 'Typography', 'nanospace' ),
		'priority' => 20,
	) ) );

	// Text typography.
	$nanospace_settings = array(
		'font_family'    => 'header_' . $nanospace_bar . '_font_family',
		'font_weight'    => 'header_' . $nanospace_bar . '_font_weight',
		'font_style'     => 'header_' . $nanospace_bar . '_font_style',
		'text_transform' => 'header_' . $nanospace_bar . '_text_transform',
		'font_size'      => 'header_' . $nanospace_bar . '_font_size',
		'line_height'    => 'header_' . $nanospace_bar . '_line_height',
		'letter_spacing' => 'header_' . $nanospace_bar . '_letter_spacing',
	);

	foreach ( $nanospace_settings as $nanospace_key ) {
		$wp_customize->add_setting( $nanospace_key, array(
			'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'typography' ),
		) );
	}

	$wp_customize->add_control( new NanoSpace_Customize_Control_Typography( $wp_customize, 'header_' . $nanospace_bar . '_typography', array(
		'settings' => $nanospace_settings,
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Text typography', 'nanospace' ),
		'priority' => 20,
	) ) );

	// Menu link typography.
	$nanospace_settings = array(
		'font_family'    => 'header_' . $nanospace_bar . '_menu_font_family',
		'font_weight'    => 'header_' . $nanospace_bar . '_menu_font_weight',
		'font_style'     => 'header_' . $nanospace_bar . '_menu_font_style',
		'text_transform' => 'header_' . $nanospace_bar . '_menu_text_transform',
		'font_size'      => 'header_' . $nanospace_bar . '_menu_font_size',
		'line_height'    => 'header_' . $nanospace_bar . '_menu_line_height',
		'letter_spacing' => 'header_' . $nanospace_bar . '_menu_letter_spacing',
	);

	foreach ( $nanospace_settings as $nanospace_key ) {
		$wp_customize->add_setting( $nanospace_key, array(
			'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'typography' ),
		) );
	}

	$wp_customize->add_control( new NanoSpace_Customize_Control_Typography( $wp_customize, 'header_' . $nanospace_bar . '_menu_typography', array(
		'settings' => $nanospace_settings,
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Menu link typography', 'nanospace' ),
		'priority' => 20,
	) ) );

	// Submenu link typography.
	$nanospace_settings = array(
		'font_family'    => 'header_' . $nanospace_bar . '_submenu_font_family',
		'font_weight'    => 'header_' . $nanospace_bar . '_submenu_font_weight',
		'font_style'     => 'header_' . $nanospace_bar . '_submenu_font_style',
		'text_transform' => 'header_' . $nanospace_bar . '_submenu_text_transform',
		'font_size'      => 'header_' . $nanospace_bar . '_submenu_font_size',
		'line_height'    => 'header_' . $nanospace_bar . '_submenu_line_height',
		'letter_spacing' => 'header_' . $nanospace_bar . '_submenu_letter_spacing',
	);

	foreach ( $nanospace_settings as $nanospace_key ) {
		$wp_customize->add_setting( $nanospace_key, array(
			'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'typography' ),
		) );
	}

	$wp_customize->add_control( new NanoSpace_Customize_Control_Typography( $wp_customize, 'header_' . $nanospace_bar . '_submenu_typography', array(
		'settings' => $nanospace_settings,
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Submenu link typography', 'nanospace' ),
		'priority' => 20,
	) ) );

	// Icon size.
	$nanospace_key = 'header_' . $nanospace_bar . '_icon_size';
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
	) );

	$wp_customize->add_control( new NanoSpace_Customize_Control_Slider( $wp_customize, $nanospace_key, array(
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Icon size', 'nanospace' ),
		'units'    => array(
			'px' => array(
				'min'  => 0,
				'max'  => 60,
				'step' => 1,
			),
		),
		'priority' => 20,
	) ) );

	/**
	 * ====================================================
	 * Colors
	 * ====================================================
	 */

	// Heading: Colors.
	$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_header_' . $nanospace_bar . '_colors', array(
		'section'  => $nanospace_section,
		'settings' => array(),
		'label'    => esc_html__( 'Colors', 'nanospace' ),
		'priority' => 30,
	) ) );

	// Colors.
	$nanospace_colors = array(
		'header_' . $nanospace_bar . '_bg_color'               => esc_html__( 'Background color', 'nanospace' ),
		'header_' . $nanospace_bar . '_border_color'           => esc_html__( 'Border color', 'nanospace' ),
		'header_' . $nanospace_bar . '_text_color'             => esc_html__( 'Text color', 'nanospace' ),
		'header_' . $nanospace_bar . '_link_text_color'        => esc_html__( 'Link text color', 'nanospace' ),
		'header_' . $nanospace_bar . '_link_hover_text_color'  => esc_html__( 'Link text color :hover', 'nanospace' ),
		'header_' . $nanospace_bar . '_link_active_text_color' => esc_html__( 'Link text color :active', 'nanospace' ),
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
			'priority' => 30,
		) ) );
	}

	$wp_customize->add_control( new NanoSpace_Customize_Control_HR( $wp_customize, 'hr_header_' . $nanospace_bar . '_submenu_colors', array(
		'section'  => $nanospace_section,
		'settings' => array(),
		'priority' => 30,
	) ) );

	// Colors.
	$nanospace_colors = array(
		'header_' . $nanospace_bar . '_submenu_bg_color'               => esc_html__( 'Submenu background color', 'nanospace' ),
		'header_' . $nanospace_bar . '_submenu_border_color'           => esc_html__( 'Submenu border color', 'nanospace' ),
		'header_' . $nanospace_bar . '_submenu_text_color'             => esc_html__( 'Submenu text color', 'nanospace' ),
		'header_' . $nanospace_bar . '_submenu_link_text_color'        => esc_html__( 'Submenu link text color', 'nanospace' ),
		'header_' . $nanospace_bar . '_submenu_link_hover_text_color'  => esc_html__( 'Submenu link text color :hover', 'nanospace' ),
		'header_' . $nanospace_bar . '_submenu_link_active_text_color' => esc_html__( 'Submenu link text color :active', 'nanospace' ),
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
			'priority' => 30,
		) ) );
	}

	$wp_customize->add_control( new NanoSpace_Customize_Control_HR( $wp_customize, 'hr_header_' . $nanospace_bar . '_menu_highlight_colors', array(
		'section'  => $nanospace_section,
		'settings' => array(),
		'priority' => 30,
	) ) );

	// Top level menu items highlight.
	$nanospace_key = 'header_' . $nanospace_bar . '_menu_highlight';
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
	) );

	$wp_customize->add_control( $nanospace_key, array(
		'type'     => 'select',
		'section'  => $nanospace_section,
		'label'    => esc_html__( 'Top level menu items highlight', 'nanospace' ),
		'choices'  => array(
			'none'                      => esc_html__( 'None', 'nanospace' ),
			'underline'                 => esc_html__( 'Underline', 'nanospace' ),
			'line-below-menu'           => esc_html__( 'Line Below Menu', 'nanospace' ),
			'line-above-menu'           => esc_html__( 'Line Above Menu', 'nanospace' ),
			'highlight-style1'          => esc_html__( 'Highlight Style 1', 'nanospace' ),
			'highlight-style2'          => esc_html__( 'Highlight Style 2', 'nanospace' ),
			'double-horizontal-lines'   => esc_html__( 'Double Horizontal Lines', 'nanospace' ),
			'double-vertcal-lines'      => esc_html__( 'Double Vertcal Lines', 'nanospace' ),
			'border-with-sharp-edges'   => esc_html__( 'Border With Sharp Edges', 'nanospace' ),
			'border-with-rounded-edges' => esc_html__( 'Border with Rounded Edges', 'nanospace' ),
			'brackets'                  => esc_html__( 'Brackets', 'nanospace' ),
			'modern'                    => esc_html__( 'Modern', 'nanospace' )
		),
		'priority' => 30,
	) );

	// Colors.
	$nanospace_colors = array(
		'header_' . $nanospace_bar . '_menu_hover_highlight_color'       => esc_html__( 'Highlight color :hover', 'nanospace' ),
		'header_' . $nanospace_bar . '_menu_hover_highlight_text_color'  => esc_html__( 'Highlight text color :hover', 'nanospace' ),
		'header_' . $nanospace_bar . '_menu_active_highlight_color'      => esc_html__( 'Highlight color :active', 'nanospace' ),
		'header_' . $nanospace_bar . '_menu_active_highlight_text_color' => esc_html__( 'Highlight text color :active', 'nanospace' ),
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
			'priority' => 30,
		) ) );
	}
}
