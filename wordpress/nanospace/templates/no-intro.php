<?php
/**
 * Template Name: No intro
 * Template Post Type: page, post, wm_projects, wm_staff, product, jetpack-portfolio
 *
 * Removes page intro.
 * Other than that it is normal page (or post, or custom post type).
 *
 * @see  includes/custom-header/custom-header.php
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

/* translators: Custom page template name. */
__( 'No intro', 'nanospace' );

if ( is_page() ) {
	get_template_part( 'page' );
} else {
	get_template_part( 'single', get_post_type() );
}
