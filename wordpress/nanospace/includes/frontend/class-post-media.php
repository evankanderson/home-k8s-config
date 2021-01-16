<?php

/**
 * Post Media Class
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Size
 * 20) Display
 * 30) Media
 */
class NanoSpace_Post_Media {
	/**
	 * 0) Init
	 */

	private static $instance;

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	private function __construct() {
// Actions

		add_action( 'nanospace_entry_top', __CLASS__ . '::media' );

		// Filters

		add_filter( 'nanospace_post_media_pre', __CLASS__ . '::media_disable' );

		add_filter( 'nanospace_post_media_image_size', __CLASS__ . '::size' );
		add_filter( 'nanospace_post_media_image_size', __CLASS__ . '::size_masonry' );

	} // /__construct

	/**
	 * Initialization (get instance)
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}


		return self::$instance;

	} // /init
	/**
	 * 10) Size
	 */

	/**
	 * Post thumbnail (featured image) display size
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $image_size
	 */
	public static function size( $image_size ) {
		if ( is_attachment() ) {
			$image_size = 'thumbnail';
		} else if ( is_single( get_the_ID() ) ) {
			$image_size = 'medium';
		} else {
			$image_size = 'nanospace-thumbnail';
		}


		return $image_size;

	} // /size

	/**
	 * Post thumbnail display size on masonry blog
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $image_size
	 */
	public static function size_masonry( $image_size ) {
		if (
			( is_home() || is_category() || is_tag() || is_date() || is_author() )
			&& 'masonry' === get_theme_mod( 'blog_style', 'masonry' )
		) {
			$image_size = get_theme_mod( 'blog_style_masonry_image_size', 'thumbnail' );
		}


		return $image_size;

	} // /size_masonry
	/**
	 * 20) Display
	 */

	/**
	 * Entry media
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $args Optional post helper variables.
	 */
	public static function media( $args = array() ) {

		// Pre

		$pre = apply_filters( 'nanospace_post_media_pre', false, $args );

		if ( false !== $pre ) {
			echo $pre; // Method bypass via filter.

			return;
		}


		$output     = apply_filters( 'nanospace_post_media_output_pre', '', $args );
		$image_size = apply_filters( 'nanospace_post_media_image_size', 'thumbnail', $args );
		$class      = 'entry-media';
		if ( empty( $output ) ) {
			$output .= self::image_featured( $image_size );
		}


		if ( $output ) {
			echo '<div class="' . esc_attr( $class ) . '">' . $output . '</div>';
		}

	} // /media

	/**
	 * Featured image
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  string $image_size
	 */
	public static function image_featured( $image_size ) {

		// Pre

		$pre = apply_filters( 'nanospace_post_media_image_featured_pre', false, $image_size );

		if ( false !== $pre ) {
			return $pre;
		}


		$output   = '';
		$post_id  = get_the_ID();
		$image_id = ( is_attachment() ) ? ( $post_id ) : ( get_post_thumbnail_id( $post_id ) );
		if (
			has_post_thumbnail( $post_id )
			|| ( is_attachment() && $attachment_image = wp_get_attachment_image( $image_id, (string) $image_size ) )
		) {

			$image_link = ( is_single( $post_id ) || is_attachment() ) ? ( wp_get_attachment_image_src( $image_id, 'full' ) ) : ( array( esc_url( get_permalink() ) ) );
			$image_link = array_filter( (array) apply_filters( 'nanospace_post_media_image_featured_link', $image_link ) );

			$output .= '<figure class="post-thumbnail">';

			if ( ! empty( $image_link ) ) {
				$output .= '<a href="' . esc_url( $image_link[0] ) . '">';
			}

			if ( is_attachment() ) {

				$output .= $attachment_image;

			} else {

				$output .= get_the_post_thumbnail(
					null,
					(string) $image_size
				);

			}

			if ( ! empty( $image_link ) ) {
				$output .= '</a>';
			}

			$output .= '</figure>';

		}


		return $output;

	} // /media_disable
	/**
	 * 30) Media
	 */

	/**
	 * Do not display entry media on top of single post content
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  mixed $pre
	 */
	public static function media_disable( $pre ) {
		if ( NanoSpace_Post::is_singular() && ! is_attachment() ) {
			$pre = '';
		}


		return $pre;

	} // /image_featured
} // /NanoSpace_Post_Media

add_action( 'after_setup_theme', 'NanoSpace_Post_Media::init' );
