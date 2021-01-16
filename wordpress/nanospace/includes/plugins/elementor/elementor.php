<?php
/**
 * Plugin compatibility file.
 *
 * Elementor
 *
 * @link  https://wordpress.org/plugins/elementor/
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Plugin integration
 */
/**
 * 1) Requirements check
 */

if ( ! class_exists( '\Elementor\Plugin' ) ) {
	return;
}
/**
 * 10) Plugin integration
 */

require NANOSPACE_PATH_PLUGINS . 'elementor/class-elementor.php';
