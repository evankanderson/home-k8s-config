<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

/**
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

do_action( 'nanospace_comments_before' );

?>

	<div id="comments" class="comments-area">
		<div class="comments-area-inner">
			<?php
			nanospace_comments_title();

			/**
			 * Comments list
			 */
			if ( have_comments() ) {

				nanospace_comments_closed();

				// Actual comments list.
				?>
				<ol class="comment-list">
					<?php
					wp_list_comments(
						array(
							'avatar_size' => 240,
							'style'       => 'ol',
							'short_ping'  => true,
						)
					);
					?>
				</ol>

				<?php

				// Are there comments to navigate through?
				if (
					1 < get_comment_pages_count()
					&& get_option( 'page_comments' )
				) :

					$total   = get_comment_pages_count();
					$current = ( get_query_var( 'cpage' ) ) ? ( absint( get_query_var( 'cpage' ) ) ) : ( 1 );
					?>

					<nav id="comment-nav-below" class="pagination comment-pagination"
						 aria-label="<?php esc_attr_e( 'Comments', 'nanospace' ); ?>"
						 data-current="<?php echo esc_attr( $current ); ?>"
						 data-total="<?php echo esc_attr( $total ); ?>">

						<?php

						paginate_comments_links( (array) apply_filters('nanospace_pagination_args', array(
							'prev_text' => esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'nanospace' ) . '<span class="screen-reader-text"> '
										   . esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'nanospace' ) . '</span>',
							'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'nanospace' )
										   . ' </span>' . esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'nanospace' ),
						), 'comments' ) );
						?>

					</nav>

					<?php
				endif;

			} // /have_comments()

			/**
			 * Comments form
			 */
			comment_form();

			?>

		</div>
	</div><!-- #comments -->

<?php

do_action( 'nanospace_comments_after' );
