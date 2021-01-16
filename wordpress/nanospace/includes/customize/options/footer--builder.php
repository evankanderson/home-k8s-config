<?php
/**
 * Customizer settings: Footer > Builder
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_defaults = nanospace_get_setting_defaults();

$nanospace_section = 'nanospace_section_footer_builder';

/**
 * ====================================================
 * Builder
 * ====================================================
 */

ob_start(); ?>
<span class="button button-secondary nanospace-builder-hide nanospace-builder-toggle">
<span class="dashicons dashicons-no"></span><?php esc_html_e( 'Hide', 'nanospace' ); ?></span>
<span class="button button-primary nanospace-builder-show nanospace-builder-toggle">
<span class="dashicons dashicons-edit"></span><?php esc_html_e( 'Footer Builder', 'nanospace' ); ?></span>
<?php
$nanospace_switcher = ob_get_clean();

// --- Blank: Footer Builder Switcher.
$wp_customize->add_control( new NanoSpace_Customize_Control_Blank( $wp_customize, 'footer_builder_actions', array(
	'section'     => $nanospace_section,
	'settings'    => array(),
	'description' => $nanospace_switcher,
	'priority'    => 10,
) ) );

// Widgets columns.
$nanospace_key = 'footer_widgets_bar';
$wp_customize->add_setting( $nanospace_key, array(
	'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
	'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'select' ),
) );

$wp_customize->add_control( $nanospace_key, array(
	'type'     => 'select',
	'section'  => $nanospace_section,
	'label'    => esc_html__( 'Widgets columns', 'nanospace' ),
	'choices'  => array(
		0 => esc_html__( '-- Disabled --', 'nanospace' ),
		1 => esc_html__( '1 column', 'nanospace' ),
		2 => esc_html__( '2 columns', 'nanospace' ),
		3 => esc_html__( '3 columns', 'nanospace' ),
		4 => esc_html__( '4 columns', 'nanospace' ),
		5 => esc_html__( '5 columns', 'nanospace' ),
		6 => esc_html__( '6 columns', 'nanospace' ),
	),
	'priority' => 10,
) );

$wp_customize->add_control( new NanoSpace_Customize_Control_HR( $wp_customize, 'hr_footer_builder', array(
	'section'  => $nanospace_section,
	'settings' => array(),
	'priority' => 20,
) ) );

// Bottom bar elements.
$nanospace_key = 'footer_elements';

$nanospace_settings = array(
	'top_left'      => $nanospace_key . '_top_left',
	'top_center'    => $nanospace_key . '_top_center',
	'top_right'     => $nanospace_key . '_top_right',
	'bottom_left'   => $nanospace_key . '_bottom_left',
	'bottom_center' => $nanospace_key . '_bottom_center',
	'bottom_right'  => $nanospace_key . '_bottom_right',
);

foreach ( $nanospace_settings as $nanospace_setting ) {
	$wp_customize->add_setting( $nanospace_setting, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_setting ),
		'sanitize_callback' => array( 'Nanospace_Customizer_Sanitization', 'builder' ),
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Builder( $wp_customize, $nanospace_key, array(
	'settings'    => $nanospace_settings,
	'section'     => $nanospace_section,
	'label'       => esc_html__( 'Bottom bar elements', 'nanospace' ),
	'description' => esc_html__( 'Drag and drop the elements into the location you want. Some elements can only be added to certain locations.', 'nanospace' ),
	'choices'     => array(
		'copyright' => '<span class="dashicons dashicons-editor-code"></span>' . esc_html__( 'Copyright', 'nanospace' ),
		/* translators: %s: instance number. */
		'menu-1'    => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Footer Menu', 'nanospace' ) ),
		'html-1'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 1 ),
		'html-2'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 2 ),
		'html-3'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 3 ),
		'html-4'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 4 ),
		'html-5'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 5 ),
		'html-6'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 6 ),
		'html-7'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 7 ),
		'html-8'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 8 ),
		'html-9'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 9 ),
		'social'    => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'nanospace' ),
	),
	'labels'      => array(
		'top_left'      => is_rtl() ? esc_html__( 'Top - Right', 'nanospace' ) : esc_html__( 'Top - Left', 'nanospace' ),
		'top_center'    => esc_html__( 'Top - Center', 'nanospace' ),
		'top_right'     => is_rtl() ? esc_html__( 'Top - Left', 'nanospace' ) : esc_html__( 'Top - Right', 'nanospace' ),
		'bottom_left'   => is_rtl() ? esc_html__( 'Bottom - Right', 'nanospace' ) : esc_html__( 'Bottom - Left', 'nanospace' ),
		'bottom_center' => esc_html__( 'Bottom - Center', 'nanospace' ),
		'bottom_right'  => is_rtl() ? esc_html__( 'Bottom - Left', 'nanospace' ) : esc_html__( 'Bottom - Right', 'nanospace' ),
	),
	'limitations' => array(),
	'priority'    => 20,
) ) );
