<?php
/**
 * Post meta: Tags
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

// Requirements check.
if ( ! $tags = get_the_tag_list( '', ' ', '', get_the_ID() ) ) {
	return;
}

?>

<span class="entry-meta-element tags-links">
	<span class="entry-meta-description">
		<?php echo esc_html_x( 'Tagged as:', 'Post meta info description: tags list.', 'nanospace' ); ?>
	</span>
	<?php echo $tags; /* WPCS: XSS OK. */ ?>
</span>
