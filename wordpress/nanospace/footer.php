<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

do_action( 'nanospace_content_bottom' );
do_action( 'nanospace_before_footer' );
do_action( 'nanospace_content_after' );

if ( NanoSpace_Footer::is_enabled() ) {
	do_action( 'nanospace_footer_before' );
	do_action( 'nanospace_footer_top' );
	do_action( 'nanospace_footer_bottom' );
	do_action( 'nanospace_footer_after' );
}

do_action( 'nanospace_body_bottom' );
do_action( 'nanospace_after_footer' );
if ( 'yes' == get_theme_mod( 'nanospace_enable_scroll_top', 'yes' ) ) {
	$layout = nanospace_get_theme_mod( 'nanospace_section_header_layout_select' );

	if ( 'right-header' == $layout ) {
		echo '<div class="back-to-top back-to-top-right-header" aria-hidden="true">';
		echo nanospace_icon( 'submenu-down', array( 'class' => 'nanospace-top-icon' ), false );
		echo '</div>';
	} else {
		echo '<div class="back-to-top" aria-hidden="true">';
		echo nanospace_icon( 'submenu-down', array( 'class' => 'nanospace-top-icon' ), false );
		echo '</div>';
	}
}

wp_footer();
?>

</body>

</html>
