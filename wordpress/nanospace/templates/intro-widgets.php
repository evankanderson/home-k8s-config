<?php
/**
 * Template Name: With intro widgets
 * Template Post Type: page, post, wm_projects, wm_staff, product, jetpack-portfolio
 *
 * Displays page intro with dedicated sidebar.
 * Other than that it is normal page (or post, or custom post type).
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

/* translators: Custom page template name. */
__( 'With intro widgets', 'nanospace' );

if ( is_page() ) {
	get_template_part( 'page' );
} else {
	get_template_part( 'single', get_post_type() );
}
