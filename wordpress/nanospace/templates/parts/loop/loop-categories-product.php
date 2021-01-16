<?php
/**
 * WooCommerce product categories loop
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

$taxo = 'product_cat';

$args = array( 'parent' => 0 );

if ( is_tax( $taxo ) ) {
	$args['parent'] = get_queried_object_id();
}

$productTerms = get_terms( $taxo, $args );

// Requirements check.

if (
	is_wp_error( $productTerms )
	|| empty( $productTerms )
	|| ! function_exists( 'wc_get_template' )
) {
	return;
}
?>

<h2 class="screen-reader-text"><?php esc_html_e( 'List of categories', 'nanospace' ); ?></h2>

<ul class="products products-categories">
	<?php

	foreach ( $productTerms as $pterm ) {
		wc_get_template(
			'content-product_cat.php',
			array(
				'category' => $pterm,
			)
		);
	}

	?>
</ul>
