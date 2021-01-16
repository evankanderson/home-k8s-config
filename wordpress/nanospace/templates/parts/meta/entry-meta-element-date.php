<?php
/**
 * Post meta: Publish and update date
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

?>

<span class="entry-meta-element entry-date posted-on">
	<span class="entry-meta-description label-published">
		<?php echo esc_html_x( 'Posted on:', 'Post meta info description: publish date.', 'nanospace' ); ?>
	</span>
	<a href="<?php the_permalink(); ?>" rel="bookmark">
		<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="published"
			  title="<?php echo esc_attr_x( 'Posted on:', 'Post meta info description: publish date.', 'nanospace' );
			  echo ' ' . esc_attr( get_the_date() ); ?>">
			<?php echo esc_html( get_the_date() ); ?>
		</time>
	</a>
	<span class="entry-meta-description label-updated">
		<?php echo esc_html_x( 'Last updated on:', 'Post meta info description: update date.', 'nanospace' ); ?>
	</span>
	<time class="updated" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"
		  title="<?php echo esc_attr_x( 'Last updated on:', 'Post meta info description: update date.', 'nanospace' );
		  echo ' ' . esc_attr( get_the_modified_date() ); ?>">
		<?php echo esc_html( get_the_modified_date() ); ?>
	</time>
</span>
