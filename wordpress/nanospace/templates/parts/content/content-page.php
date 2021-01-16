<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

?>

<?php do_action( 'nanospace_entry_before' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'nanospace_entry_top' ); ?>

	<div class="entry-content">
		<?php

		do_action( 'nanospace_entry_content_before' );

		the_content();

		do_action( 'nanospace_entry_content_after' );

		?>
		</div>

	<?php do_action( 'nanospace_entry_bottom' ); ?>

</article>

<?php do_action( 'nanospace_entry_after' ); ?>
