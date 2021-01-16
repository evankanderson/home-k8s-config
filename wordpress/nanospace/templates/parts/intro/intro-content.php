<?php
/**
 * Page intro content
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 */

$postid       = get_the_ID();
$posts_page   = get_option( 'page_for_posts' );
$page_summary = '';

$class_title  = ( is_single() ) ? ( 'entry-title' ) : ( 'page-title' );
$class_title .= ' h1 intro-title';

$intro_title_tag   = 'h1';
$pagination_suffix = NanoSpace_Library::get_the_paginated_suffix( 'small' );

if ( is_home() && $posts_page && ! is_front_page() ) {
	$postid = $posts_page;
}

$post_title          = get_the_title( $postid );
$title_paginated_url = get_permalink( $postid );
$intro_title_tag     = apply_filters( 'nanospace_intro_title_tag', $intro_title_tag, $postid );
$post_title          = apply_filters( 'nanospace_intro_title', $post_title, $postid );

if ( ! $pagination_suffix ) {

	// Page summary setup.
	add_filter( 'nanospace_summary_continue_reading_pre', '__return_empty_string' );

	if ( is_singular() && has_excerpt() ) {
		$page_summary = get_the_excerpt();
	} elseif ( is_home() && ! is_front_page() && $posts_page && has_excerpt( $posts_page ) ) {
		$page_summary = get_the_excerpt( absint( $posts_page ) );
	} elseif ( is_archive() ) {
		$page_summary = get_the_archive_description();
	}

	remove_filter( 'nanospace_summary_continue_reading_pre', '__return_empty_string' );

	if ( $page_summary ) {
		$class_title .= ' has-page-summary';
	}
} else {
	// Title setup.
	$post_title = '<a href="' . esc_url( $title_paginated_url ) . '">' . $post_title . '</a>' . $pagination_suffix;
}

$post_title = '<' . tag_escape( $intro_title_tag ) . ' class="' . esc_attr( $class_title ) . '">' . $post_title . '</' . tag_escape( $intro_title_tag ) . '>';

/**
 * Page title.
 */
if ( is_archive() ) { // For archive pages.

	$post_title  = '<' . tag_escape( $intro_title_tag ) . ' class="' . esc_attr( $class_title ) . '">';
	$post_title .= get_the_archive_title();
	$post_title .= $pagination_suffix;
	$post_title .= '</' . tag_escape( $intro_title_tag ) . '>';

} elseif ( is_search() ) { // For search results.

	$post_title  = '<' . tag_escape( $intro_title_tag ) . ' class="' . esc_attr( $class_title ) . '">';
	$post_title .= sprintf(
		esc_html__( 'Search Results for: %s', 'nanospace' ),
		'<span>' . get_search_query() . '</span>'
	);
	$post_title .= $pagination_suffix;
	$post_title .= '</' . tag_escape( $intro_title_tag ) . '>';

} elseif ( is_front_page() && is_home() ) { // For blog front page.

	$post_title  = '<' . tag_escape( $intro_title_tag ) . ' class="' . esc_attr( $class_title ) . '">';
	$post_title .= get_bloginfo( 'name' );
	$post_title .= $pagination_suffix;

	if ( $site_description = get_bloginfo( 'description', 'display' ) ) {
		$post_title .= '<span class="intro-title-separator"> &mdash; </span>';
		$post_title .= '<small class="intro-title-tagline">' . $site_description . '</small>';
	}

	$post_title .= '</' . tag_escape( $intro_title_tag ) . '>';

}

echo $post_title;

/**
 * Page summary.
 */
if ( $page_summary ) {

	if ( strpos( $page_summary, 'entry-summary' ) ) {
		$page_summary = str_replace(
			'entry-summary',
			'page-summary entry-summary',
			$page_summary
		);
	} else {
		$page_summary = '<div class="page-summary">' . PHP_EOL . $page_summary . PHP_EOL . '</div>';
	}

	echo apply_filters( 'the_excerpt', $page_summary );

}
