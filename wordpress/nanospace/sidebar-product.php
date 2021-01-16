<?php
/**
 * Widget area displayed on single product page.
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

// Requirements check.
if ( ! is_active_sidebar( 'product' ) ) {
	return;
}

?>

<div class="product-widgets-container">
	<div class="product-widgets-inner">

		<aside id="product-widgets" class="widget-area product-widgets" aria-label="<?php echo esc_attr_x( 'Product sidebar', 'Sidebar aria label', 'nanospace' ); ?>">

			<?php dynamic_sidebar( 'product' ); ?>

		</aside>

	</div>
</div>
