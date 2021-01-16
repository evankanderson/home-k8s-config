<?php
/**
 * Customizer settings: Header > Header Builder
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_defaults = nanospace_get_setting_defaults();

$nanospace_section = 'nanospace_section_header_builder';

/**
 * ====================================================
 * Builder
 * ====================================================
 */

ob_start(); ?>
	<div class="nanospace-responsive-switcher nav-tab-wrapper wp-clearfix">

		<a href="#" class="nav-tab preview-desktop nanospace-responsive-switcher-button" data-device="desktop">
			<span class="dashicons dashicons-desktop"></span>
			<span><?php esc_html_e( 'Desktop', 'nanospace' ); ?></span>
		</a>

		<a href="#" class="nav-tab preview-vertical nanospace-responsive-switcher-button" data-device="vertical">
			<span class="dashicons dashicons-desktop"></span>
			<span><?php esc_html_e( 'Vertical', 'nanospace' ); ?></span>
		</a>

		<a href="#" class="nav-tab preview-tablet preview-mobile nanospace-responsive-switcher-button" data-device="tablet">
			<span class="dashicons dashicons-smartphone"></span>
			<span><?php esc_html_e( 'Tablet / Mobile', 'nanospace' ); ?></span>
		</a>

	</div>

	<span class="button button-secondary nanospace-builder-hide nanospace-builder-toggle">
	<span class="dashicons dashicons-no"></span><?php esc_html_e( 'Hide', 'nanospace' ); ?></span>
	<span class="button button-primary nanospace-builder-show nanospace-builder-toggle">
	<span class="dashicons dashicons-edit"></span><?php esc_html_e( 'Header Builder', 'nanospace' ); ?></span>
<?php $nanospace_switcher = ob_get_clean();

// --- Blank: Header Builder Switcher.
$wp_customize->add_control( new NanoSpace_Customize_Control_Blank( $wp_customize, 'header_builder_actions', array(
	'section'     => $nanospace_section,
	'settings'    => array(),
	'description' => $nanospace_switcher,
	'priority'    => 10,
) ) );

// Vertical Header.
$nanospace_settings = array(
	'vertical_main_left'   => 'header_vertical_elements_top_left',
	'vertical_main_center' => 'header_vertical_elements_main_center',
	'vertical_main_right'  => 'header_vertical_elements_bottom_right',
);
foreach ( $nanospace_settings as $nanospace_key ) {
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'sanitize_callback' => array( 'NanoSpace_Customizer_Sanitization', 'builder' ),
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Builder( $wp_customize, 'header_elements_vertical', array(
	'settings'    => $nanospace_settings,
	'section'     => $nanospace_section,
	'label'       => esc_html__( 'Vertical Header', 'nanospace' ),
	'description' => esc_html__( 'Drag and drop the elements into the location you want. Some elements can only be added to certain locations.', 'nanospace' ),
	'choices'     => array(
		'vertical-logo'      => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Vertical Logo', 'nanospace' ),
		'menu-1'             => '<span class="dashicons dashicons-admin-links"></span>' . esc_html__( 'Primary Menu', 'nanospace' ),
		'html-1'             => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 1 ),
		'html-2'             => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 2 ),
		'html-3'             => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 3 ),
		'button-1'           => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 1 ),
		'button-2'           => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 2 ),
		'button-3'           => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 3 ),
		/* translators: %s: instance number. */
		'search-bar'         => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'nanospace' ),
		'shopping-cart-link' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'nanospace' ),
		'social'             => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'nanospace' ),
	),
	'labels'      => array(
		'vertical_main_left'   => is_rtl() ? esc_html__( 'Top', 'nanospace' ) : esc_html__( 'Top', 'nanospace' ),
		'vertical_main_center' => is_rtl() ? esc_html__( 'Center', 'nanospace' ) : esc_html__( 'Center', 'nanospace' ),
		'vertical_main_right'  => is_rtl() ? esc_html__( 'Bottom', 'nanospace' ) : esc_html__( 'Bottom', 'nanospace' ),
	),
	'limitations' => array(
		'logo'               => array( 'vertical_main_center', 'vertical_main_right' ),
		'menu-1'             => array( 'vertical_main_left' ),
		'html-1'             => array( 'vertical_main_left' ),
		'html-2'             => array( 'vertical_main_left' ),
		'html-3'             => array( 'vertical_main_left' ),
		'button-1'           => array( 'vertical_main_left' ),
		'button-2'           => array( 'vertical_main_left' ),
		'button-3'           => array( 'vertical_main_left' ),
		'search-bar'         => array( 'vertical_main_left' ),
		'shopping-cart-link' => array( 'vertical_main_left' ),
		'social'             => array( 'vertical_main_left' ),
	),
	'priority'    => 10,
) ) );

// Desktop Header.
$nanospace_settings = array(
	'top_left'      => 'header_elements_top_left',
	'top_center'    => 'header_elements_top_center',
	'top_right'     => 'header_elements_top_right',
	'main_left'     => 'header_elements_main_left',
	'main_center'   => 'header_elements_main_center',
	'main_right'    => 'header_elements_main_right',
	'bottom_left'   => 'header_elements_bottom_left',
	'bottom_center' => 'header_elements_bottom_center',
	'bottom_right'  => 'header_elements_bottom_right',
);

foreach ( $nanospace_settings as $nanospace_key ) {
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'sanitize_callback' => array( 'NanoSpace_Customizer_Sanitization', 'builder' ),
	) );
}
$wp_customize->add_control( new NanoSpace_Customize_Control_Builder( $wp_customize, 'header_elements', array(
	'settings'    => $nanospace_settings,
	'section'     => $nanospace_section,
	'label'       => esc_html__( 'Desktop Header', 'nanospace' ),
	'description' => esc_html__( 'Drag and drop the elements into the location you want. Some elements can only be added to certain locations. If elements are too wide, they will be displayed on a new row.', 'nanospace' ),
	'choices'     => array(
		'logo'                   => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Logo', 'nanospace' ),
		/* translators: %s: instance number. */
		'menu-1'                 => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Primary Menu', 'nanospace' ) ),
		'menu-2'                 => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Secondary Menu', 'nanospace' ) ),
		/* translators: %s: instance number. */
		'html-1'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 1 ),
		'html-2'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 2 ),
		'html-3'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 3 ),
		'html-4'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 4 ),
		'html-5'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 5 ),
		'html-6'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 6 ),
		'html-7'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 7 ),
		'button-1'               => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 1 ),
		'button-2'               => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 2 ),
		'button-3'               => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 3 ),
		'button-4'               => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 4 ),
		'button-5'               => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 5 ),
		'button-6'               => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 6 ),
		'button-7'               => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'Button %s', 'nanospace' ), 7 ),
		'search-bar'             => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'nanospace' ),
		'shopping-cart-link'     => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'nanospace' ),
		'shopping-cart-dropdown' => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Dropdown', 'nanospace' ),
		'social'                 => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'nanospace' ),
	),
	'labels'      => array(
		'top_left'      => is_rtl() ? esc_html__( 'Top - Right', 'nanospace' ) : esc_html__( 'Top - Left', 'nanospace' ),
		'top_center'    => esc_html__( 'Top - Center', 'nanospace' ),
		'top_right'     => is_rtl() ? esc_html__( 'Top - Left', 'nanospace' ) : esc_html__( 'Top - Right', 'nanospace' ),
		'main_left'     => is_rtl() ? esc_html__( 'Main - Right', 'nanospace' ) : esc_html__( 'Main - Left', 'nanospace' ),
		'main_center'   => esc_html__( 'Main - Center', 'nanospace' ),
		'main_right'    => is_rtl() ? esc_html__( 'Main - Left', 'nanospace' ) : esc_html__( 'Main - Right', 'nanospace' ),
		'bottom_left'   => is_rtl() ? esc_html__( 'Bottom - Right', 'nanospace' ) : esc_html__( 'Bottom - Left', 'nanospace' ),
		'bottom_center' => esc_html__( 'Bottom - Center', 'nanospace' ),
		'bottom_right'  => is_rtl() ? esc_html__( 'Bottom - Left', 'nanospace' ) : esc_html__( 'Bottom - Right', 'nanospace' ),
	),
	'limitations' => array(
		'logo'     => array( 'top_left', 'top_center', 'top_right', 'bottom_left', 'bottom_center', 'bottom_right' ),
		'html-4'   => array( 'main_center' ),
		'html-5'   => array( 'main_center' ),
		'html-6'   => array( 'main_center' ),
		'html-7'   => array( 'main_center' ),
		'button-4' => array( 'main_center' ),
		'button-5' => array( 'main_center' ),
		'button-6' => array( 'main_center' ),
		'button-7' => array( 'main_center' ),
	),
	'priority'    => 10,
) ) );

// Mobile Header.
$nanospace_settings = array(
	'mobile_main_left'    => 'header_mobile_elements_main_left',
	'mobile_main_center'  => 'header_mobile_elements_main_center',
	'mobile_main_right'   => 'header_mobile_elements_main_right',
	'mobile_vertical_top' => 'header_mobile_elements_vertical_top',
);

foreach ( $nanospace_settings as $nanospace_key ) {
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'sanitize_callback' => array( 'NanoSpace_Customizer_Sanitization', 'builder' ),
	) );
}

$wp_customize->add_control( new NanoSpace_Customize_Control_Builder( $wp_customize, 'header_mobile_elements', array(
	'settings'    => $nanospace_settings,
	'section'     => $nanospace_section,
	'label'       => esc_html__( 'Mobile Header', 'nanospace' ),
	'description' => esc_html__( 'Drag and drop the elements into the location you want. Some elements can only be added to certain locations.', 'nanospace' ),
	'choices'     => array(
		'mobile-logo'            => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Mobile Logo', 'nanospace' ),
		'mobile-menu'            => '<span class="dashicons dashicons-admin-links"></span>' . esc_html__( 'Mobile Menu', 'nanospace' ),
		/* translators: %s: instance number. */
		'html-1'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'nanospace' ), 1 ),
		'search-bar'             => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'nanospace' ),
		'shopping-cart-link'     => '<span class="dashicons dashicons-cart"></span>' . esc_html__( 'Cart Link', 'nanospace' ),
		'social'                 => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'nanospace' ),
		'mobile-vertical-toggle' => '<span class="dashicons dashicons-menu"></span>' . esc_html__( 'Toggle', 'nanospace' ),

	),
	'labels'      => array(
		'mobile_main_left'    => is_rtl() ? esc_html__( 'Right', 'nanospace' ) : esc_html__( 'Left', 'nanospace' ),
		'mobile_main_center'  => esc_html__( 'Center', 'nanospace' ),
		'mobile_main_right'   => is_rtl() ? esc_html__( 'Left', 'nanospace' ) : esc_html__( 'Right', 'nanospace' ),
		'mobile_vertical_top' => esc_html__( 'Drawer (Popup)', 'nanospace' ),
	),
	'limitations' => array(
		'mobile-logo'            => array( 'mobile_vertical_top' ),
		'mobile-menu'            => array( 'mobile_main_left', 'mobile_main_center', 'mobile_main_right' ),
		'html-1'                 => array( 'mobile_main_left', 'mobile_main_center', 'mobile_main_right' ),
		'search-bar'             => array( 'mobile_main_left', 'mobile_main_center', 'mobile_main_right' ),
		'shopping-cart-link'     => array( 'mobile_vertical_top' ),
		'social'                 => array( 'mobile_main_left', 'mobile_main_center', 'mobile_main_right' ),
		'mobile-vertical-toggle' => array( 'mobile_vertical_top' ),
	),
	'priority'    => 10,
) ) );
