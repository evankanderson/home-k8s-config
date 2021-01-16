<?php
/**
 * Template Name: Project layout
 * Template Post Type: wm_projects
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

/* translators: Custom page template name. */
__( 'Project layout', 'nanospace' );

get_template_part( 'single', get_post_type() );
