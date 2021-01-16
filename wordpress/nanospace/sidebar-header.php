<?php
/**
 * Widget area in site header.
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

// Requirements check.
if ( ! is_active_sidebar( 'header' ) ) {
	return;
}

?>

<div class="header-widgets-container">

		<div id="header-widgets" class="widget-area header-widgets" aria-label="<?php echo esc_attr_x( 'Header widgets', 'Sidebar aria label', 'nanospace' ); ?>">

		<?php dynamic_sidebar( 'header' ); ?>

		</div>

</div>
