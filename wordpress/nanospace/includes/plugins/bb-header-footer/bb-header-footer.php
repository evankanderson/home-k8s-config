<?php
/**
 * Plugin compatibility file.
 *
 * Beaver Builder Header Footer
 *
 * @link  https://wordpress.org/plugins/bb-header-footer/
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

if ( ! class_exists( 'BB_Header_Footer' ) ) {
	return;
}
/**
 * 10) Plugin integration
 */

require NANOSPACE_PATH_PLUGINS . 'bb-header-footer/class-bb-header-footer.php';
