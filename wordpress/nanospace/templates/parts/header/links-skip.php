<?php
/**
 * Skip links
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

$links = array(
	'header-menu-1' => __( 'Skip to main navigation', 'nanospace' ),
	'content'       => __( 'Skip to main content', 'nanospace' ),
	'colophon'      => __( 'Skip to footer', 'nanospace' ),
);

foreach ( $links as $key => $text ) {
	echo NanoSpace_Library::link_skip_to(
		$key,
		$text,
		'',
		'%s'
	);
}
