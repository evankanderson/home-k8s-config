<?php
/**
 * Customizer sections
 *
 * @package NanoSpace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-section-spacer.php';

// Global Settings.
$nanospace_panel = 'nanospace_panel_global_settings';

$wp_customize->add_panel( $nanospace_panel, array(
	'title'    => esc_html__( 'Global Settings', 'nanospace' ),
	'priority' => 178,
) );

// Google Fonts.
$wp_customize->add_section( 'nanospace_section_google_fonts', array(
	'title'    => esc_html__( 'Google Fonts', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 20,
) );

// Social.
$wp_customize->add_section( 'nanospace_section_social', array(
	'title'       => esc_html__( 'Social Media Links', 'nanospace' ),
	'description' => '<p>' . esc_html__( 'Please use full URL format with http:// or https://', 'nanospace' ) . '</p><p>'. esc_html__( 'Use it in the Header and Footer Builders.', 'nanospace' ) . '</p>',
	'panel'       => $nanospace_panel,
	'priority'    => 20,
) );

$wp_customize->add_section( new NanoSpace_Customize_Section_Spacer( $wp_customize, 'nanospace_section_spacer_global_settings', array(
	'panel'    => $nanospace_panel,
	'priority' => 20,
) ) );

$wp_customize->add_section( new NanoSpace_Customize_Section_Spacer( $wp_customize, 'nanospace_section_spacer_170', array(
	'priority' => 170,
) ) );

// Header.
$nanospace_panel = 'nanospace_panel_header';
$wp_customize->add_panel( $nanospace_panel, array(
	'title'       => esc_html__( 'Header Builder', 'nanospace' ),
	'description' => '<p>' . esc_html__( 'Tips: you can customize the Mobile Header by switching to tablet / mobile view.', 'nanospace' ) . '<br/><br/>' . esc_html__( 'Note: Settings applied here will override related settings from theme options.', 'nanospace' ) . '</p>',
	'priority'    => 173,
) );

// Header Builder.
$wp_customize->add_section( 'nanospace_section_header_builder', array(
	'title'    => esc_html__( 'Header Builder', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 10,
) );

$wp_customize->add_section( new NanoSpace_Customize_Section_Spacer( $wp_customize, 'nanospace_section_spacer_header_bars', array(
	'panel'    => $nanospace_panel,
	'priority' => 10,
) ) );

// header layout.
$wp_customize->add_section( 'nanospace_section_header_layout', array(
	'title'    => esc_html__( 'Header Layout', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 10,
) );

// Top Bar.
$wp_customize->add_section( 'nanospace_section_header_top_bar', array(
	'title'    => esc_html__( 'Top Bar', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 10,
) );

// Main Bar.
$wp_customize->add_section( 'nanospace_section_header_main_bar', array(
	'title'    => esc_html__( 'Main Bar', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 10,
) );

// Bottom Bar.
$wp_customize->add_section( 'nanospace_section_header_bottom_bar', array(
	'title'    => esc_html__( 'Bottom Bar', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 10,
) );

$wp_customize->add_section( new NanoSpace_Customize_Section_Spacer( $wp_customize, 'nanospace_section_spacer_header_mobile_bars', array(
	'panel'    => $nanospace_panel,
	'priority' => 20,
) ) );

// Mobile Main Bar.
$wp_customize->add_section( 'nanospace_section_header_mobile_main_bar', array(
	'title'    => esc_html__( 'Mobile Main Bar', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 20,
) );

// Mobile Drawer.
$wp_customize->add_section( 'nanospace_section_header_mobile_vertical_bar', array(
	'title'    => esc_html__( 'Mobile Drawer (Popup)', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 20,
) );


$wp_customize->add_section( new NanoSpace_Customize_Section_Spacer( $wp_customize, 'nanospace_section_spacer_header_elements', array(
	'panel'    => $nanospace_panel,
	'priority' => 40,
) ) );

// Logo.
$wp_customize->add_section( 'nanospace_section_header_logo', array(
	'title'    => esc_html__( 'Element: Logo', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 40,
) );

// Search.
$wp_customize->add_section( 'nanospace_section_header_search', array(
	'title'    => esc_html__( 'Element: Search', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 40,
) );

// HTML.
$wp_customize->add_section( 'nanospace_section_header_html', array(
	'title'    => esc_html__( 'Element: HTML', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 40,
) );

// BUTTON.
$wp_customize->add_section( 'nanospace_section_header_button', array(
	'title'    => esc_html__( 'Element: Buttons', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 40,
) );

// Cart.
$wp_customize->add_section( 'nanospace_section_header_cart', array(
	'title'    => esc_html__( 'Element: Shopping Cart', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 40,
) );

// Social.
$wp_customize->add_section( 'nanospace_section_header_social', array(
	'title'    => esc_html__( 'Element: Social', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 40,
) );

// Footer.
$nanospace_panel = 'nanospace_panel_footer';
$wp_customize->add_panel( $nanospace_panel, array(
	'title'       => esc_html__( 'Footer Builder', 'nanospace' ),
	'description' => '<p>' . esc_html__( 'Please note: settings applied here will override related settings from theme options.', 'nanospace' ) . '</p>',
	'priority'    => 174,
) );

// Footer Builder.
$wp_customize->add_section( 'nanospace_section_footer_builder', array(
	'title'    => esc_html__( 'Footer Builder', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 10,
) );

$wp_customize->add_section( new NanoSpace_Customize_Section_Spacer( $wp_customize, 'nanospace_section_spacer_footer_bars', array(
	'panel'    => $nanospace_panel,
	'priority' => 10,
) ) );

// header layout.
$wp_customize->add_section( 'nanospace_section_footer_layout', array(
	'title'    => esc_html__( 'Footer Layout', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 10,
) );

// Widgets Bar.
$wp_customize->add_section( 'nanospace_section_footer_widgets_bar', array(
	'title'    => esc_html__( 'Widgets Bar', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 20,
) );

// Top Bar.
$wp_customize->add_section( 'nanospace_section_footer_top_bar', array(
	'title'    => esc_html__( 'Top Bar', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 20,
) );

// Bottom Bar.
$wp_customize->add_section( 'nanospace_section_footer_bottom_bar', array(
	'title'    => esc_html__( 'Bottom Bar', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 20,
) );

$wp_customize->add_section( new NanoSpace_Customize_Section_Spacer( $wp_customize, 'nanospace_section_spacer_footer_elements', array(
	'panel'    => $nanospace_panel,
	'priority' => 30,
) ) );

// Copyright.
$wp_customize->add_section( 'nanospace_section_footer_copyright', array(
	'title'    => esc_html__( 'Element: Copyright', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 30,
) );

// Social.
$wp_customize->add_section( 'nanospace_section_footer_social', array(
	'title'    => esc_html__( 'Element: Social', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 30,
) );

// Html.
$wp_customize->add_section( 'nanospace_section_footer_html', array(
	'title'    => esc_html__( 'Element: HTML(s)', 'nanospace' ),
	'panel'    => $nanospace_panel,
	'priority' => 30,
) );

$wp_customize->add_section( new NanoSpace_Customize_Section_Spacer( $wp_customize, 'nanospace_section_spacer_180', array(
	'priority' => 180,
) ) );

require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-blank.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-builder.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-toggle.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-dimension.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-hr.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-slider.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-dimensions.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-heading.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-typography.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-color.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customize-control-multicheck.php' );
require_once( NANOSPACE_PATH_INCLUDES . 'customize/class-nanospace-customizer-sanitization.php' );

// social links.
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/global--social.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/global--google-fonts.php' );

// Header.
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--builder.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--top-main-bottom-bar.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--mobile-main-bar.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--mobile-vertical-bar.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--logo.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--html.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--button.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--search.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--cart.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--social.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/header--layout.php' );

// Footer.
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/footer--builder.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/footer--bottom-bar.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/footer--top-bar.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/footer--copyright.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/footer--social.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/footer--html.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/footer--widgets-bar.php' );
require_once( NANOSPACE_PATH_INCLUDES . '/customize/options/footer--layout.php' );
