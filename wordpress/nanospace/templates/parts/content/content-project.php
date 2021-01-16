<?php
/**
 * Project post content for archives
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

$args = ( ! isset( $helper ) ) ? ( null ) : ( array( 'helper' => $helper ) );
?>

<?php do_action( 'nanospace_entry_before', $args ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'nanospace_entry_top', $args ); ?>

	<div class="entry-content">
		<?php

		do_action( 'nanospace_entry_content_before', $args );

		if ( is_single( get_the_ID() ) ) {
			the_content();
		}

		do_action( 'nanospace_entry_content_after', $args );

		?>
		</div>

	<?php do_action( 'nanospace_entry_bottom', $args ); ?>

</article>

<?php do_action( 'nanospace_entry_after', $args ); ?>
