<?php
/**
 * Customizer settings: Footer > Widgets Bar
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_section = 'nanospace_section_footer_widgets_bar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Layout.
$nanospace_key = 'footer_widgets_bar_container';
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

// Padding.
$nanospace_key      = 'footer_widgets_bar_padding';
$nanospace_settings = array(
	$nanospace_key,
	$nanospace_key . '__tablet',
	$nanospace_key . '__mobile',
);
foreach ( $nanospace_settings as $nanospace_setting ) {
	$wp_customize->add_setting( $nanospace_setting, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_setting ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimensions' ),
	) );
}
$wp_customize->add_control( new NanoSpace_Customize_Control_Dimensions( $wp_customize, $nanospace_key, array(
	'settings' => $nanospace_settings,
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
$nanospace_key = 'footer_widgets_bar_border';
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

// Columns gutter.
$nanospace_key = 'footer_widgets_bar_columns_gutter';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
) );

$wp_customize->add_control( new NanoSpace_Customize_Control_Slider( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Columns gutter', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority' => 10,
) ) );

// Gap between widgets.
$nanospace_key = 'footer_widgets_bar_widgets_gap';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'dimension' ),
) );

$wp_customize->add_control( new NanoSpace_Customize_Control_Slider( $wp_customize, $nanospace_key, array(
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Gap between widgets', 'nanospace' ),
	'units'    => array(
		'px' => array(
			'min'  => 0,
			'max'  => 80,
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
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_footer_widgets_bar_typography', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => esc_html__( 'Typography', 'nanospace' ),
	'priority' => 20,
) ) );

// Text typography.
$nanospace_settings = array(
	'font_family'    => 'footer_widgets_bar_font_family',
	'font_weight'    => 'footer_widgets_bar_font_weight',
	'font_style'     => 'footer_widgets_bar_font_style',
	'text_transform' => 'footer_widgets_bar_text_transform',
	'font_size'      => 'footer_widgets_bar_font_size',
	'line_height'    => 'footer_widgets_bar_line_height',
	'letter_spacing' => 'footer_widgets_bar_letter_spacing',
);

foreach ( $nanospace_settings as $nanospace_key ) {
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'typography' ),
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Typography( $wp_customize, 'footer_widgets_bar_typography', array(
	'settings' => $nanospace_settings,
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Text typography', 'nanospace' ),
	'priority' => 20,
) ) );

// Widget title typography.
$nanospace_settings = array(
	'font_family'    => 'footer_widgets_bar_widget_title_font_family',
	'font_weight'    => 'footer_widgets_bar_widget_title_font_weight',
	'font_style'     => 'footer_widgets_bar_widget_title_font_style',
	'text_transform' => 'footer_widgets_bar_widget_title_text_transform',
	'font_size'      => 'footer_widgets_bar_widget_title_font_size',
	'line_height'    => 'footer_widgets_bar_widget_title_line_height',
	'letter_spacing' => 'footer_widgets_bar_widget_title_letter_spacing',

	'font_size_tablet'      => 'footer_widgets_bar_widget_title_font_size__tablet',
	'line_height_tablet'    => 'footer_widgets_bar_widget_title_line_height__tablet',
	'letter_spacing_tablet' => 'footer_widgets_bar_widget_title_letter_spacing__tablet',

	'font_size_mobile'      => 'footer_widgets_bar_widget_title_font_size__mobile',
	'line_height_mobile'    => 'footer_widgets_bar_widget_title_line_height__mobile',
	'letter_spacing_mobile' => 'footer_widgets_bar_widget_title_letter_spacing__mobile',
);

foreach ( $nanospace_settings as $nanospace_key ) {
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'transport'         => 'postMessage',
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'typography' ),
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Typography( $wp_customize, 'footer_widgets_bar_widget_title_typography', array(
	'settings' => $nanospace_settings,
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Widget title typography', 'nanospace' ),
	'priority' => 20,
) ) );

// Widget title alignment.
$nanospace_key = 'footer_widgets_bar_widget_title_alignment';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Widget title alignment', 'nanospace' ),
	'choices'  => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'nanospace' ) : esc_html__( 'Left', 'nanospace' ),
		'center' => esc_html__( 'Center', 'nanospace' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'nanospace' ) : esc_html__( 'Right', 'nanospace' ),
	),
	'priority' => 20,
) );

// Widget title decoration.
$nanospace_key = 'footer_widgets_bar_widget_title_decoration';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'transport'         => 'postMessage',
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Widget title decoration', 'nanospace' ),
	'choices'  => array(
		'none'          => esc_html__( 'None', 'nanospace' ),
		'box'           => esc_html__( 'Box', 'nanospace' ),
		'border-bottom' => esc_html__( 'Border bottom', 'nanospace' ),
	),
	'priority' => 20,
) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors.
$wp_customize->add_control( new NanoSpace_Customize_Control_Heading( $wp_customize, 'heading_footer_widgets_bar_colors', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'label'    => esc_html__( 'Colors', 'nanospace' ),
	'priority' => 30,
) ) );

// Colors.
$nanospace_colors = array(
	'footer_widgets_bar_bg_color'                  => esc_html__( 'Background color', 'nanospace' ),
	'footer_widgets_bar_border_color'              => esc_html__( 'Border color', 'nanospace' ),
	'footer_widgets_bar_text_color'                => esc_html__( 'Text color', 'nanospace' ),
	'footer_widgets_bar_link_text_color'           => esc_html__( 'Link text color', 'nanospace' ),
	'footer_widgets_bar_link_hover_text_color'     => esc_html__( 'Link text color :hover', 'nanospace' ),
	'footer_widgets_bar_widget_title_text_color'   => esc_html__( 'Widget title text color', 'nanospace' ),
	'footer_widgets_bar_widget_title_bg_color'     => esc_html__( 'Widget title background color', 'nanospace' ),
	'footer_widgets_bar_widget_title_border_color' => esc_html__( 'Widget title border color', 'nanospace' ),
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
