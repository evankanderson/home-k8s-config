<?php
/**
 * Template part for displaying a message that posts cannot be found.
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

<section class="no-results not-found">

	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'nanospace' ); ?></h1>
	</header>

	<div class="page-content">

		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) {
			?>

			<p>
			<?php

				printf(
					wp_kses(
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'nanospace' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);

			?>
			</p>

			<?php
		} elseif ( is_search() ) {
			?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'nanospace' ); ?></p>

			<?php get_search_form(); ?>

			<?php
		} else {
			?>

			<p><?php esc_html_e( 'It seems we can not find what you are looking for. Perhaps searching can help.', 'nanospace' ); ?></p>

			<?php get_search_form(); ?>

		<?php } ?>

	</div>

</section>
