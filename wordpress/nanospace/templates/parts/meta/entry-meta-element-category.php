<?php
/**
 * Post meta: Category
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

// Requirements check.
if (
	! NanoSpace_Library::is_categorized_blog()
	|| ! $categories = get_the_category_list( ', ', '', get_the_ID() )
) {
	return;
}
?>

<span class="entry-meta-element cat-links">
	<span class="entry-meta-description">
		<?php echo esc_html_x( 'Categorized in:', 'Post meta info description: categories list.', 'nanospace' ); ?>
	</span>
	<?php echo $categories; /* WPCS: XSS OK. */ ?>
</span>
