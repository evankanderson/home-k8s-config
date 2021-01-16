<?php
/**
 * Post meta: Comments count
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

// Requirements check.
if (
	post_password_required()
	|| ! comments_open( get_the_ID() )
) {
	return;
}

$comments_number = absint( get_comments_number( get_the_ID() ) );
?>

<span class="entry-meta-element comments-link">
	<a href="<?php the_permalink(); ?>#comments" title="<?php echo esc_attr( sprintf( esc_html_x( 'Comments: %s', '%s: number of comments.', 'nanospace' ), number_format_i18n( $comments_number ) ) ); ?>">
		<span class="entry-meta-description">
			<?php echo esc_html_x( 'Comments:', 'Post meta info description: comments count.', 'nanospace' ); ?>
		</span>
		<span class="comments-count">
			<?php echo esc_html( $comments_number ); /* WPCS: XSS OK. */ ?>
		</span>
	</a>
</span>
