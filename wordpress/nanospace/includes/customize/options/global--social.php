<?php
/**
 * Customizer settings: Global Settings > Social Media URLs
 *
 * @package Nanospace
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nanospace_defaults = nanospace_get_setting_defaults();

$nanospace_section = 'nanospace_section_social';

/**
 * ====================================================
 * Links
 * ====================================================
 */

$nanospace_links = nanospace_get_social_media_types();
ksort( $nanospace_links );

foreach ( $nanospace_links as $nanospace_slug => $nanospace_label ) {
	// Social media link.
	$nanospace_key = 'social_' . $nanospace_slug;
	$wp_customize->add_setting( $nanospace_key, array(
		'default'           => nanospace_array_value( $nanospace_defaults, $nanospace_key ),
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( $nanospace_key, array(
		'section'  => $nanospace_section,
		'label'    => $nanospace_label,
		'priority' => 10,
	) );
}