<?php
/**
 * The header for our theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

do_action( 'nanospace_html_before' );

?>

<html class="no-js" <?php language_attributes(); ?>>

	<head>
		<?php
		do_action( 'nanospace_before_header' );
		do_action( 'nanospace_head_top' );
		do_action( 'nanospace_head_bottom' );
		wp_head();
		?>
	</head>

<?php
$layout = nanospace_get_theme_mod( 'nanospace_section_header_layout_select' );

if ( 'left-header' == $layout ) {
	$class = 'left';
} elseif ( 'right-header' == $layout ) {
	$class = 'right';
}

?>
<body <?php body_class( isset( $class ) ? $class : '' ); ?>>
<?php
if ( 'framed' === get_theme_mod( 'layout_site' ) ) {
	?>
	<span class="layout_frame frame--top"></span>
	<span class="layout_frame frame--bottom"></span>
	<span class="layout_frame frame--right"></span>
	<span class="layout_frame frame--left"></span>
	<?php
}

if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} else {
	// phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedHooknameFound
	do_action( 'wp_body_open' );
}

do_action( 'nanospace_body_top' );

if ( NanoSpace_Header::is_enabled() ) {
	do_action( 'nanospace_header_before' );
	do_action( 'nanospace_header_top' );
	do_action( 'nanospace_header_bottom' );
	do_action( 'nanospace_header_after' );
}

do_action( 'nanospace_after_header' );
do_action( 'nanospace_content_before' );
do_action( 'nanospace_content_top' );
