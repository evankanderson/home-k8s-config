<?php
/**
 * Primary widget area in site footer.
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

// Requirements check.
if ( ! is_active_sidebar( 'footer' ) ) {
	return;
}

?>

<div class="site-footer-area footer-area-footer-widgets">
	<div class="footer-widgets-inner site-footer-area-inner">

		<div id="footer-widgets" class="widget-area footer-widgets" aria-label="<?php echo esc_attr_x( 'Footer widgets', 'Sidebar aria label', 'nanospace' ); ?>">

			<?php dynamic_sidebar( 'footer' ); ?>

		</div>

	</div>
</div>
