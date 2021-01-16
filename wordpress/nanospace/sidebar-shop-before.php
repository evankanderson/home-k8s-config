<?php
/**
 * Widget area displayed before the shop archive products list.
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

// Requirements check.
if ( ! is_active_sidebar( 'shop-before' ) ) {
	return;
}
?>

<div class="shop-before-widgets-container">
	<div class="shop-before-widgets-inner">

		<aside id="shop-before-widgets" class="widget-area shop-before-widgets" aria-label="<?php echo esc_attr_x( 'Before products list widgets', 'Sidebar aria label', 'nanospace' ); ?>">

			<?php dynamic_sidebar( 'shop-before' ); ?>

		</aside>

	</div>
</div>
