<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

// Requirements check.
if ( ! is_active_sidebar( 'left-sidebar' ) ) {
	return;
}

$nanospace_sidebar = nanospace_get_single_sidebar_layout();

if ( 'sidebar-none' == $nanospace_sidebar || 'sidebar-right' == $nanospace_sidebar ) {
	return;
}

do_action( 'nanospace_sidebars_before' );

?>

	<aside id="secondary-left" class="widget-area left-sidebar" aria-label="<?php echo esc_attr_x( 'Sidebar', 'Sidebar aria label', 'nanospace' ); ?>">

		<?php

		do_action( 'nanospace_sidebar_top' );

		dynamic_sidebar( 'left-sidebar' );

		do_action( 'nanospace_sidebar_bottom' );

		?>

	</aside><!-- /#secondary -->

<?php

do_action( 'nanospace_sidebars_after' );
