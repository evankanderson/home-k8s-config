<?php
/**
 * Theme loading
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *   0) Paths
 *   1) Theme framework
 *  10) Theme setup
 *  20) Frontend
 *  30) Features
 * 100) Custom widgets
 * 999) Plugins integration
 */

/**
 * 0) Paths
 */
// Theme directory path.
define( 'NANOSPACE_PATH', trailingslashit( get_template_directory() ) );

// Includes path.
define( 'NANOSPACE_PATH_INCLUDES', trailingslashit( NANOSPACE_PATH . 'includes' ) );

// Plugin compatibility files.
define( 'NANOSPACE_PATH_PLUGINS', trailingslashit( NANOSPACE_PATH_INCLUDES . 'plugins' ) );

/**
 * 1) Theme framework.
 */
require NANOSPACE_PATH . 'library/init.php';

/**
 * 10) Theme setup
 */
require NANOSPACE_PATH_INCLUDES . 'setup/class-setup.php';
require NANOSPACE_PATH_INCLUDES . 'framework/lab_layouts.php';

/**
 * 20) Frontend
 */
// Theme Hook Alliance.
require NANOSPACE_PATH_INCLUDES . 'frontend/theme-hook-alliance.php';

// Assets (styles and scripts).
require NANOSPACE_PATH_INCLUDES . 'frontend/class-assets.php';

// Header.
require NANOSPACE_PATH_INCLUDES . 'frontend/class-header.php';

// Menu.
require NANOSPACE_PATH_INCLUDES . 'frontend/class-menu.php';

// Content.
require NANOSPACE_PATH_INCLUDES . 'frontend/class-content.php';

// Loop.
require NANOSPACE_PATH_INCLUDES . 'frontend/class-loop.php';

// Post.
require NANOSPACE_PATH_INCLUDES . 'frontend/class-post.php';
require NANOSPACE_PATH_INCLUDES . 'frontend/class-post-summary.php';
require NANOSPACE_PATH_INCLUDES . 'frontend/class-post-media.php';

// Footer.
require NANOSPACE_PATH_INCLUDES . 'frontend/class-footer.php';

// Sidebars (widget areas).
require NANOSPACE_PATH_INCLUDES . 'frontend/class-sidebar.php';

/**
 * 30) Features.
 */

// Theme Customization.
require NANOSPACE_PATH_INCLUDES . 'customize/class-customize.php';
require NANOSPACE_PATH_INCLUDES . 'customize/helpers.php';
require NANOSPACE_PATH_INCLUDES . 'customize/template-tags.php';
require NANOSPACE_PATH_INCLUDES . 'customize/template-functions.php';

// Customized Styles.
require NANOSPACE_PATH_INCLUDES . 'customize/class-customize-styles.php';

// Custom Header / Intro.
require NANOSPACE_PATH_INCLUDES . 'custom-header/class-intro.php';

/**
 * 100) Custom widgets.
 */

// WordPress Recent Posts Widget.
require NANOSPACE_PATH_INCLUDES . 'widgets/class-wp-widget-recent-posts.php';

// WordPress Text Widget.
require NANOSPACE_PATH_INCLUDES . 'widgets/class-wp-widget-text.php';

/**
 * 999) Plugins integration.
 */
// Advanced Custom Fields.
if ( function_exists( 'acf_add_local_field_group' ) && is_admin() ) {
	require NANOSPACE_PATH_PLUGINS . 'advanced-custom-fields/advanced-custom-fields.php';
}

// Beaver Builder.
if ( class_exists( 'FLBuilder' ) ) {
	require NANOSPACE_PATH_PLUGINS . 'beaver-builder/beaver-builder.php';
}

// Beaver Themer.
if ( class_exists( 'FLThemeBuilder' ) ) {
	require NANOSPACE_PATH_PLUGINS . 'beaver-themer/beaver-themer.php';
}

// Beaver Builder Header Footer.
if ( class_exists( 'BB_Header_Footer' ) ) {
	require NANOSPACE_PATH_PLUGINS . 'bb-header-footer/bb-header-footer.php';
}

// Breadcrumb NavXT.
if ( function_exists( 'bcn_display' ) ) {
	require NANOSPACE_PATH_PLUGINS . 'breadcrumb-navxt/breadcrumb-navxt.php';
}

// Elementor.
if ( class_exists( '\Elementor\Plugin' ) ) {
	require NANOSPACE_PATH_PLUGINS . 'elementor/elementor.php';
}

// Jetpack.
if ( class_exists( 'Jetpack' ) ) {
	require NANOSPACE_PATH_PLUGINS . 'jetpack/jetpack.php';
}

// Subtitles & WP Subtitle.
if ( function_exists( 'get_the_subtitle' ) ) {
	require NANOSPACE_PATH_PLUGINS . 'subtitles/subtitles.php';
}

// Widget CSS Classes.
if ( function_exists( 'widget_css_classes_loader' ) ) {
	require NANOSPACE_PATH_PLUGINS . 'widget-css-classes/widget-css-classes.php';
}

// WooCommerce.
if ( class_exists( 'WooCommerce' ) ) {
	require NANOSPACE_PATH_PLUGINS . 'woocommerce/woocommerce.php';
}
