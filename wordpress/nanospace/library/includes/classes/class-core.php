<?php

/**
 * Core class
 *
 * @package     Labinator NanoSpace WordPress Theme Framework
 * @subpackage  Core
 *
 * @since 1.0.0
 * @version 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Theme upgrade action
 *  20) Post/page
 * 100) Helpers
 */
final class NanoSpace_Library {
	/**
	 * 0) Init
	 */

	/**
	 * Initialization.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @version 1.0.0
	 */
	public static function init() {
		// Actions.
		add_action( 'init', __CLASS__ . '::theme_upgrade' );

		add_action( 'edit_category', __CLASS__ . '::all_categories_transient_flusher' );
		add_action( 'save_post', __CLASS__ . '::all_categories_transient_flusher' );

		// Filters.
		add_filter( 'show_recent_comments_widget_style', '__return_false' );

		add_filter( 'the_content', __CLASS__ . '::add_table_of_contents' );

	} // /init
	/**
	 * 10) Theme upgrade action
	 */

	/**
	 * Do action on theme version change
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @version 1.0.0
	 */
	public static function theme_upgrade() {

		$current_theme_version = get_transient( 'nanospace_version' );
		$new_theme_version     = wp_get_theme( 'nanospace' )->get( 'Version' );
		if (
			empty( $current_theme_version )
			|| $new_theme_version != $current_theme_version
		) {
			do_action( 'nanospace_library_theme_upgrade', $new_theme_version, $current_theme_version );
			set_transient( 'nanospace_version', $new_theme_version );
		}

	} // /theme_upgrade
	/**
	 * 20) Post/page
	 */

	/**
	 * Add table of contents generated from <!--nextpage--> tag
	 *
	 * Will create a table of content in multipage post from
	 * the first H2 heading in each post part.
	 * Appends the output at the top and bottom of post content.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $content
	 */
	public static function add_table_of_contents( $content = '' ) {

		// Pre.
		$pre = apply_filters( 'nanospace_library_add_table_of_contents_pre', false, $content );

		if ( false !== $pre ) {
			return $pre;
		}

		global $page, $numpages, $multipage, $post;

		// Requirements check.
		if (
			! $multipage
			|| ! is_singular()
		) {
			return $content;
		}

		$title_text = apply_filters( 'nanospace_library_add_table_of_contents_title_text', sprintf( esc_html_x( '"%s" table of contents', '%s: post title.', 'nanospace' ), the_title_attribute( 'echo=0' ) ) );
		$title      = apply_filters( 'nanospace_library_add_table_of_contents_title', '<h2 class="screen-reader-text">' . $title_text . '</h2>' );

		$args = apply_filters( 'nanospace_library_add_table_of_contents_args',
			array(
				'disable_first' => true,
				// First part to have a title of the post (part title won't be parsed)?
				'links'         => array(),
				// The output HTML links.
				'post_content'  => ( isset( $post->post_content ) ) ? ( $post->post_content ) : ( '' ),
				// Get the whole post content.
				'tag'           => 'h2',
				// HTML heading tag to parse as a post part title.
			)
		);

		// Post part counter.
		$i                    = 0;
		$args['post_content'] = explode( '<!--nextpage-->', (string) $args['post_content'] );

		// Get post parts titles.
		foreach ( $args['post_content'] as $part ) {

			// Current post part number.
			$i ++;

			// Get the title for post part.
			if ( $args['disable_first'] && 1 === $i ) {

				$part_title = get_the_title();

			} else {

				preg_match( '/<' . tag_escape( $args['tag'] ) . '(.*?)>(.*?)<\/' . tag_escape( $args['tag'] ) . '>/', $part, $matches );

				if ( ! isset( $matches[2] ) || ! $matches[2] ) {
					$part_title = sprintf( esc_html__( 'Page %s', 'nanospace' ), number_format_i18n( $i ) );
				} else {
					$part_title = $matches[2];
				}
			}

			// Set post part class.
			if ( $page === $i ) {
				$class = ' class="is-current"';
			} elseif ( $page > $i ) {
				$class = ' class="is-passed"';
			} else {
				$class = '';
			}

			// Post part item output.
			$args['links'][ $i ] = (string) apply_filters( 'nanospace_library_add_table_of_contents_part', '<li' . $class . '>' . _wp_link_page( $i ) . $part_title . '</a></li>', $i, $part_title, $class, $args );

		} // /foreach

		// Add table of contents into the post/page content.
		$args['links'] = implode( '', $args['links'] );

		$links = apply_filters( 'nanospace_library_add_table_of_contents_links', array(
			// Display table of contents before the post content only in first post part.
			'before' => ( 1 === $page ) ? ( '<div class="post-table-of-contents top" title="' . esc_attr( wp_strip_all_tags( $title_text ) ) . '">' . $title . '<ol>' . $args['links'] . '</ol></div>' ) : ( '' ),
			// Display table of cotnnets after the post cotnent on each post part.
			'after'  => '<div class="post-table-of-contents bottom" title="' . esc_attr( wp_strip_all_tags( $title_text ) ) . '">' . $title . '<ol>' . $args['links'] . '</ol></div>',
		), $args );

		$content = $links['before'] . $content . $links['after'];

		return $content;

	} // /add_table_of_contents

	/**
	 * Display the paginated heading suffix
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $tag Wrapper tag.
	 * @param  string $singular_only Display only on singular posts of specific type.
	 */
	public static function the_paginated_suffix( $tag = '', $singular_only = false ) {

		$output = self::get_the_paginated_suffix( $tag, $singular_only );

		if ( $output ) {
			echo $output;
		}

	} // /get_the_paginated_suffix

	/**
	 * Get the paginated heading suffix
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $tag Wrapper tag.
	 * @param  string $singular_only Display only on singular posts of specific type.
	 */
	public static function get_the_paginated_suffix( $tag = '', $singular_only = false ) {

		// Pre.
		$pre = apply_filters( 'nanospace_library_get_the_paginated_suffix_pre', false, $tag, $singular_only );

		if ( false !== $pre ) {
			return $pre;
		}

		// Requirements check.
		if (
			$singular_only
			&& ! is_singular( $singular_only )
		) {
			return;
		}

		global $page, $paged;

		$output    = '';
		$paginated = max( absint( $page ), absint( $paged ) );

		$tag = trim( $tag );
		if ( $tag ) {
			$tag = array( '<' . tag_escape( $tag ) . '>', '</' . tag_escape( $tag ) . '>' );
		} else {
			$tag = array( '', '' );
		}
		if ( 1 < $paginated ) {
			$output = ' ' . $tag[0] . sprintf( esc_html_x( '(page %s)', 'Paginated content title suffix, %s: page number.', 'nanospace' ), number_format_i18n( $paginated ) ) . $tag[1];
		}

		return $output;

	} // /the_paginated_suffix

	/**
	 * Checks for <!--more--> tag in post content
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  mixed $post
	 */
	public static function has_more_tag( $post = null ) {

		// Pre.
		$pre = apply_filters( 'nanospace_library_has_more_tag_pre', false, $post );

		if ( false !== $pre ) {
			return $pre;
		}

		if ( empty( $post ) ) {
			$post = $GLOBALS['post'];
		} elseif ( is_numeric( $post ) ) {
			$post = get_post( absint( $post ) );
		}

		// Requirements check.
		if (
			! is_object( $post )
			|| ! isset( $post->post_content )
		) {
			return;
		}

		return strpos( $post->post_content, '<!--more-->' );

	} // /has_more_tag
	/**
	 * 100) Helpers
	 */

	/**
	 * Fixing URLs in `is_ssl()` returns TRUE
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $content
	 */
	static public function fix_ssl_urls( $content ) {
		if ( is_ssl() ) {
			$content = str_ireplace( 'http:', 'https:', $content );
		} else {
			$content = str_ireplace( 'https:', 'http:', $content );
		}

		// Has to be `http:` only.
		$content = str_ireplace( 'xmlns="https:', 'xmlns="http:', $content );
		$content = str_ireplace( "xmlns='https:", "xmlns='http:", $content );

		return $content;

	} // /fix_ssl_urls

	/**
	 * Remove shortcodes from string
	 *
	 * This function keeps the text between shortcodes,
	 * unlike WordPress native strip_shortcodes() function.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $content
	 */
	public static function remove_shortcodes( $content ) {

		// Pre.
		$pre = apply_filters( 'nanospace_library_remove_shortcodes_pre', false, $content );

		if ( false !== $pre ) {
			return $pre;
		}

		return preg_replace( '|\[(.+?)\]|s', '', $content );

	} // /remove_shortcodes

	/**
	 * Accessibility skip links
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $id Link target element ID.
	 * @param  string $text Link text.
	 * @param  string $class Additional link CSS classes.
	 * @param  string $html Output html, use "%s" for actual link
	 */
	public static function link_skip_to( $id = 'content', $text = '', $class = '', $html = '%s' ) {

		// Pre.
		$pre = apply_filters( 'nanospace_library_link_skip_to_pre', false, $id, $text, $class, $html );

		if ( false !== $pre ) {
			return $pre;
		}
		if ( empty( $text ) ) {
			$text = __( 'Skip to main content', 'nanospace' );
		}

		return sprintf(
			(string) $html,
			'<a class="' . esc_attr( trim( 'skip-link screen-reader-text ' . $class ) ) . '" href="#' . esc_attr( trim( $id ) ) . '">' . esc_html( $text ) . '</a>'
		);

	} // /link_skip_to

	/**
	 * Returns true if a blog has more than 1 category
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function is_categorized_blog() {

		// Pre.
		$pre = apply_filters( 'nanospace_library_is_categorized_blog_pre', false );

		if ( false !== $pre ) {
			return $pre;
		}
		if ( false === ( $all_cats = get_transient( 'nanospace_all_categories' ) ) ) {

			// Create an array of all the categories that are attached to posts.
			$all_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				'number'     => 2, // We only need to know if there is more than one category.
			) );

			// Count the number of categories that are attached to the posts.
			$all_cats = count( $all_cats );

			set_transient( 'nanospace_all_categories', $all_cats );

		}

		if ( $all_cats > 1 ) {

			// This blog has more than 1 category.
			return true;

		} else {

			// This blog has only 1 category.
			return false;

		}

	} // /is_categorized_blog

	/**
	 * Flush out the transients used in `is_categorized_blog`
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function all_categories_transient_flusher() {

		// Requirements check.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?

		delete_transient( 'nanospace_all_categories' );

	} // /all_categories_transient_flusher
} // /NanoSpace_Library

add_action( 'after_setup_theme', 'NanoSpace_Library::init', - 50 );
