<?php
/**
 * Custom helper functions that can be used globally.
 *
 * @package nanospace
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================================
 * Helper functions
 * ====================================================
 */

/**
 * Check if specified key exists on an array, then return the value.
 * Otherwise return the specified fallback value, or null if no fallback is specified.
 *
 * @param array $item
 * @param mixed $index
 * @param mixed $fallback
 *
 * @return mixed
 */
function nanospace_array_value( $array, $index, $fallback = null ) {
	if ( ! is_array( $array ) ) {
		return null;
	}

	return isset( $array[ $index ] ) ? $array[ $index ] : $fallback;
}

/**
 * Recursively flatten a multi-dimensional array into a one-dimensional array.
 *
 * @param array @array
 *
 * @return array
 */
function nanospace_flatten_array( $array ) {
	$flattened = array();

	foreach ( $array as $nanospace_key => $value ) {
		if ( is_array( $value ) ) {
			$flattened = array_merge( $flattened, nanospace_flatten_array( $value ) );
		} else {
			$flattened[ strval( $nanospace_key ) ] = $value;
		}
	}

	return $flattened;
}

/**
 * Wrapper function to get page setting value of the specified post ID.
 *
 * @param string $key
 * @param integer $post_id
 *
 * @return mixed
 */
function nanospace_get_page_setting_by_post_id( $key, $post_id ) {
	if ( ! is_numeric( $post_id ) ) {
		return;
	}

	$post = get_post( $post_id );

	// Abort if no post found.
	if ( empty( $post ) ) {
		return null;
	}

	// Get individual settings merged with global customizer settings.
	$settings = wp_parse_args( get_post_meta( $post->ID, '_nanospace_page_settings', true ), nanospace_get_theme_mod( 'page_settings_' . $post->post_type . '_singular', array() ) );

	// Get the value.
	$value = nanospace_array_value( $settings, $key, '' );

	return $value;
}

/**
 * Wrapper function to get page setting of specified key.
 *
 * @param string $key
 *
 * @return array
 */
function nanospace_get_current_page_setting( $key ) {
	$settings = array();

	if ( is_search() ) {
		$settings = nanospace_get_theme_mod( 'page_settings_search', array() );
	} // Static page
	elseif ( is_page() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			$settings = wp_parse_args( get_post_meta( $obj->ID, '_nanospace_page_settings', true ), array() );
		}
	} // Single post page (any post type)
	elseif ( is_singular() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			$settings = wp_parse_args( get_post_meta( $obj->ID, '_nanospace_page_settings', true ), nanospace_get_theme_mod( 'page_settings_' . $obj->post_type . '_singular', array() ) );
		}
	} // Other post types index page
	elseif ( is_post_type_archive() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			$settings = nanospace_get_theme_mod( 'page_settings_' . $obj->name . '_archive', array() );
		}
	} // Other archive page
	elseif ( is_archive() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			$post_type = 'post';

			global $wp_taxonomies;
			if ( isset( $wp_taxonomies[ $obj->taxonomy ] ) ) {
				$post_types                 = $wp_taxonomies[ $obj->taxonomy ]->object_type;
				$post_type_archive_settings = nanospace_get_theme_mod( 'page_settings_' . $post_types[0] . '_archive', array() );
			}

			$term_meta_settings = get_term_meta( $obj->term_id, 'nanospace_page_settings', true );
			if ( '' === $term_meta_settings ) {
				$term_meta_settings = array();
			}

			$settings = wp_parse_args( $term_meta_settings, $post_type_archive_settings );
		}
	} // 404 page
	elseif ( is_404() ) {
		$settings = nanospace_get_theme_mod( 'page_settings_404', array() );
	}

	// Get the value.
	$value = nanospace_array_value( $settings, $key, '' );

	$value = apply_filters( 'nanospace_page_settings_setting_value', $value, $key );
	$value = apply_filters( 'nanospace_page_settings_setting_value/' . $key, $value );

	return $value;
}

/**
 * Wrapper function to get theme_mod value.
 *
 * @param string $key
 * @param mixed $default
 *
 * @return mixed
 */
function nanospace_get_theme_mod( $key, $default = null ) {
	$value = get_theme_mod( $key, null );

	// Fallback to defaults array
	if ( is_null( $value ) ) {
		$value = nanospace_array_value( nanospace_get_setting_defaults(), $key, null );
	}

	// Fallback to default parameter
	if ( is_null( $value ) || empty( $value ) ) {
		$value = $default;
	}

	$value = apply_filters( 'nanospace_customizer_setting_value', $value, $key );
	$value = apply_filters( 'nanospace_customizer_setting_value_' . $key, $value );

	return $value;
}

function nanospace_get_setting_defaults() {
	return apply_filters( 'nanospace_customizer_setting_defaults', array() );
}

function nanospace_get_setting_postmessages() {
	return apply_filters( 'nanospace_customizer_setting_postmessages', array() );
}

/**
 * Minify CSS string.
 * ref: https://github.com/GaryJones/Simple-PHP-CSS-Minification
 * modified:
 * - add: rem to units
 * - add: remove space after (
 * - remove: remove space before (
 *
 * @param array $css
 *
 * @return string
 */
function nanospace_minify_css_string( $css ) {
	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove spaces before and after comment
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

	// Remove comment blocks, everything between /* and */, unless
	// preserved with /*! ... */ or /** ... */
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } ( */ >
	$css = preg_replace( '/(,|:|;|\{|}|\(|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ) >
	$css = preg_replace( '/ (,|;|\{|}|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|rem|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|rem|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Converts all zeros value into short-hand
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	// Shortern 6-character hex color codes to 3-character where possible
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );
}

/**
 * Build CSS string from array structure.
 *
 * @param array $css_array
 *
 * @return string
 */
function nanospace_convert_css_array_to_string( $css_array ) {
	$final_css = '';

	foreach ( $css_array as $media => $selectors ) {
		if ( empty( $selectors ) ) {
			continue;
		}

		// Add media query open tag.
		if ( 'global' !== $media ) {
			$final_css .= $media . '{';
		}

		// Iterate properties.
		foreach ( $selectors as $selector => $properties ) {
			$final_css .= $selector . '{';

			$i = 1;
			foreach ( $properties as $property => $value ) {
				if ( '' === $value ) {
					continue;
				}

				$final_css .= $property . ':' . $value;

				if ( $i !== count( $properties ) ) {
					$final_css .= ';';
				}

				$i ++;
			}

			$final_css .= '}';
		}

		// Add media query closing tag.
		if ( 'global' !== $media ) {
			$final_css .= '}';
		}
	}

	return $final_css;
}

/**
 * Build Google Fonts embed URL from specified fonts
 *
 * @param array $google_fonts
 *
 * @return string
 */
function nanospace_build_google_fonts_embed_url( $google_fonts = array() ) {
	if ( empty( $google_fonts ) ) {
		return '';
	}

	// Basic embed link.
	$link = '//fonts.googleapis.com/css';
	$args = array();

	// Add font families.
	$families = array();
	foreach ( $google_fonts as $name ) {
		// Add font family and all variants.
		$families[] = str_replace( ' ', '+', $name ) . ':100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
	}
	$args['family'] = implode( '|', $families );

	// Add font subsets.
	$subsets        = array_merge( array( 'latin' ), nanospace_get_theme_mod( 'google_fonts_subsets', array() ) );
	$args['subset'] = implode( ',', $subsets );

	return esc_attr( add_query_arg( $args, $link ) );
}

/**
 * Get more accurate value of content width in pixels, based on current page's content layout and content column's padding and border.
 *
 * @global integer $content_width
 *
 * @param string $content_layout
 *
 * @return integer
 */
function nanospace_get_content_width_by_layout( $content_layout = 'right-sidebar' ) {
	$content_width = intval( nanospace_get_theme_mod( 'container_width' ) );

	// Modify content width based on current page content layout.
	switch ( $content_layout ) {
		case 'narrow':
			$content_width = intval( nanospace_get_theme_mod( 'content_narrow_width' ) );
			break;

		case 'left-sidebar':
		case 'right-sidebar':
			// Sidebar width
			$sidebar_width = nanospace_get_theme_mod( 'sidebar_width' );
			if ( false !== strpos( $sidebar_width, '%' ) ) {
				// %
				$sidebar_width = $content_width * ( floatval( $sidebar_width ) / 100 );
			} else {
				// px
				$sidebar_width = intval( $sidebar_width );
			}

			// Sidebar gap
			$sidebar_gap = nanospace_get_theme_mod( 'sidebar_gap' );
			if ( false !== strpos( $sidebar_gap, '%' ) ) {
				// %
				$sidebar_gap = $content_width * ( floatval( $sidebar_gap ) / 100 );
			} else {
				// px
				$sidebar_gap = intval( $sidebar_gap );
			}

			$content_width = $content_width - $sidebar_width - $sidebar_gap;
			break;
	}

	return $content_width;
}

/**
 * ====================================================
 * Data set functions
 * ====================================================
 */

/**
 * Return all available fonts.
 *
 * @return array
 */
function nanospace_get_all_fonts() {
	return apply_filters( 'nanospace_dataset_all_fonts', array(
		'web_safe_fonts' => nanospace_get_web_safe_fonts(),
		'custom_fonts'   => array(),
		'google_fonts'   => nanospace_get_google_fonts(),
	) );
}

/**
 * Return array of selected Google Fonts list.
 * Selected fonts are configurable from Appearance > nanospace > Settings > Fonts page.
 *
 * @return array
 */
function nanospace_get_google_fonts() {
	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$json = $wp_filesystem->get_contents( NANOSPACE_PATH_INCLUDES . '/customize/google-fonts.json' );

	return json_decode( $json, true );
}

/**
 * Return array of Google Fonts subsets.
 *
 * @return array
 */
function nanospace_get_google_fonts_subsets() {
	return array(
		// 'latin' always chosen by default
		'latin-ext'    => 'Latin Extended',
		'arabic'       => 'Arabic',
		'bengali'      => 'Bengali',
		'cyrillic'     => 'Cyrillic',
		'cyrillic-ext' => 'Cyrillic Extended',
		'devaganari'   => 'Devaganari',
		'greek'        => 'Greek',
		'greek-ext'    => 'Greek Extended',
		'gujarati'     => 'Gujarati',
		'gurmukhi'     => 'Gurmukhi',
		'hebrew'       => 'Hebrew',
		'kannada'      => 'Kannada',
		'khmer'        => 'Khmer',
		'malayalam'    => 'Malayalam',
		'myanmar'      => 'Myanmar',
		'oriya'        => 'Oriya',
		'sinhala'      => 'Sinhala',
		'tamil'        => 'Tamil',
		'telugu'       => 'Telugu',
		'thai'         => 'Thai',
		'vietnamese'   => 'Vietnamese',
	);
}

/**
 * Return array of Web Safe Fonts choices.
 *
 * @return array
 */
function nanospace_get_web_safe_fonts() {
	return apply_filters( 'nanospace_dataset_web_safe_fonts', array(
		// System
		'Default System Font' => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif",

		// Sans Serif
		'Arial'               => "Arial, 'Helvetica Neue', Helvetica, sans-serif",
		'Helvetica'           => "'Helvetica Neue', Helvetica, Arial, sans-serif",
		'Tahoma'              => "Tahoma, Geneva, sans-serif",
		'Trebuchet MS'        => "'Trebuchet MS', Helvetica, sans-serif",
		'Verdana'             => "Verdana, Geneva, sans-serif",

		// Serif
		'Georgia'             => "Georgia, serif",
		'Times New Roman'     => "'Times New Roman', Times, serif",

		// Monospace
		'Courier New'         => "'Courier New', Courier, monospace",
		'Lucida Console'      => "'Lucida Console', Monaco, monospace",
	) );
}

/**
 * Return array of social media types (based on Simple Icons).
 *
 * @return array
 */
function nanospace_get_social_media_types() {
	return apply_filters( 'nanospace_dataset_social_media_types', array(
		'facebook'    => 'Facebook',
		'instagram'   => 'Instagram',
		'linkedin'    => 'LinkedIn',
		'twitter'     => 'Twitter',
		'pinterest'   => 'Pinterest',
		'vk'          => 'VK',
		'behance'     => 'Behance',
		'dribbble'    => 'Dribbble',
		'medium'      => 'Medium',
		'github'      => 'Github',
		'vimeo'       => 'Vimeo',
		'youtube'     => 'Youtube',
		'rss'         => 'RSS',
	) );
}

/**
 * Return array of icons choices.
 *
 * @return array
 */
function nanospace_get_all_icons() {
	return apply_filters( 'nanospace_dataset_all_icons', array(
		'theme_icons'  => array(
			'search'        => esc_html_x( 'Search', 'icon label', 'nanospace' ),
			'close'         => esc_html_x( 'Close', 'icon label', 'nanospace' ),
			'menu'          => esc_html_x( 'Menu', 'icon label', 'nanospace' ),
			'submenu-down'  => esc_html_x( 'Dropdown Arrow -- Down', 'icon label', 'nanospace' ),
			'submenu-right' => esc_html_x( 'Dropdown Arrow -- Right', 'icon label', 'nanospace' ),
			'shopping-cart' => esc_html_x( 'Shopping Cart', 'icon label', 'nanospace' ),
		),
		'social_icons' => nanospace_get_social_media_types(),
	) );
}