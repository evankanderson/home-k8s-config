<?php
/**
 * Attachment post content
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

		<?php do_action( 'nanospace_entry_content_before' ); ?>

		<div class="attachment-download">
			<span class="attachment-download-label"><?php esc_html_e( 'Download attachment file:', 'nanospace' ); ?></span>
			<?php the_attachment_link(); ?>
		</div>

		<?php

		if ( has_excerpt() ) {
			the_excerpt();
		}

		the_content();

		do_action( 'nanospace_entry_content_after' );

		?>

	</div>

	<?php do_action( 'nanospace_entry_bottom' ); ?>

</article>

<?php do_action( 'nanospace_entry_after' ); ?>
