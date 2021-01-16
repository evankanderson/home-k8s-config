<?php

/**
 * Theme Customization Class
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Options
 *  20) Active callbacks
 *  30) Partial refresh
 * 100) Helpers
 */
class NanoSpace_Customize {
	/**
	 * 0) Init
	 *
	 * Initialization.
	 *
	 * @uses  `nanospace_theme_options` global hook
	 * @uses  `nanospace_css_rgb_alphas` global hook
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function init() {

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Actions.
		add_action( 'customize_register', __CLASS__ . '::setup' );

		// Filters.
		add_filter( 'nanospace_theme_options', __CLASS__ . '::options', 5 );

		add_filter( 'nanospace_css_rgb_alphas', __CLASS__ . '::rgba_alphas' );

	} // /init

	/**
	 * 10) Options
	 *
	 * Modify native WordPress options and setup partial refresh
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  object $wp_customize WP customizer object.
	 */
	public static function setup( $wp_customize ) {

		// Partial refresh.
		// Site title.
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title-text',
			'render_callback' => __CLASS__ . '::partial_blogname',
		) );

		// Site description.
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.intro-title-tagline',
			'render_callback' => __CLASS__ . '::partial_blogdescription',
		) );

		// Site info (footer credits).
		$wp_customize->selective_refresh->add_partial( 'texts_site_info', array(
			'selector'        => '.site-info',
			'render_callback' => __CLASS__ . '::partial_texts_site_info',
		) );

		// Option pointers only.
		$wp_customize->selective_refresh->add_partial( 'blog_style', array(
			'selector' => '.blog #main > .posts',
		) );
		$wp_customize->selective_refresh->add_partial( 'layout_page_outdent', array(
			'selector' => '.page-layout-outdented:not(.content-layout-no-paddings):not(.fl-builder) .entry-content',
		) );

	} // /setup

	/**
	 * Set theme options array
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $options
	 */
	public static function options( $options = array() ) {
		// Registered image sizes.
		$image_sizes = (array) get_intermediate_image_sizes();
		$image_sizes = array_combine( $image_sizes, $image_sizes );

		// Registered single post layout.
		$single_layouts = nanospace_get_single_layouts();

		// scroll options.
		$yesno_options = nanospace_get_scroll();

		// Nanospace booster plugin custom font.
		$custom_fonts = nanospace_custom_fonts();

		/**
		 * Theme customizer options array
		 */
		$options = array(
			/**
			 * Theme credits
			 */

			'0' . 90 . 'placeholder' => array(
				'id'                   => 'placeholder',
				'type'                 => 'section',
				'create_section'       => '',
				'in_panel'             => esc_html_x( 'Theme Options', 'Customizer panel title.', 'nanospace' ),
				'in_panel-description' => '<h3>' . esc_html__( 'Theme Credits', 'nanospace' ) . '</h3>'
				                          . '<p class="description">'
				                          . sprintf(
					                          esc_html_x( '%1$s is a WordPress theme developed by %2$s.', '1: linked theme name, 2: theme author name.', 'nanospace' ),
					                          '<a href="' . esc_url( wp_get_theme( 'nanospace' )->get( 'ThemeURI' ) ) . '"><strong>' . esc_html( wp_get_theme( 'nanospace' )->get( 'Name' ) ) . '</strong></a>',
					                          '<strong>' . esc_html( wp_get_theme( 'nanospace' )->get( 'Author' ) ) . '</strong>'
				                          )
				                          . '</p>'
				                          . '<p class="description">'
				                          . sprintf(
					                          esc_html_x( 'You can obtain other professional WordPress themes at %s.', '%s: theme author link.', 'nanospace' ),
					                          '<strong><a href="' . esc_url( wp_get_theme( 'nanospace' )->get( 'AuthorURI' ) ) . '">' . esc_html( str_replace( 'http://', '', untrailingslashit( wp_get_theme( 'nanospace' )->get( 'AuthorURI' ) ) ) ) . '</a></strong>'
				                          )
				                          . '</p>'
				                          . '<p class="description">'
				                          . esc_html__( 'Thank you for using a theme by Labinator', 'nanospace' )
				                          . '</p>',
			),

			/**
			 * Colors: Accents and predefined colors
			 *
			 * Don't use `preview_js` here as these colors affect too many elements.
			 */

			100 . 'colors' . 10 => array(
				'id'             => 'colors-accents',
				'type'           => 'section',
				'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'nanospace' ), esc_html_x( 'Accents', 'Customizer color section title', 'nanospace' ) ),
				'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'nanospace' ),
			),

			/**
			 * Accent colors
			 */

			100 . 'colors' . 10 . 100 => array(
				'type'    => 'html',
				'content' => '<p class="description">' . esc_html__( 'These colors affect links, buttons and other elements.', 'nanospace' ) . '</p>',
			),

			100 . 'colors' . 10 . 200 => array(
				'type'    => 'html',
				'content' => '<h3>' . esc_html__( 'Primary accent color', 'nanospace' ) . '</h3>',
			),

			100 . 'colors' . 10 . 210 => array(
				'type'       => 'color',
				'id'         => 'color_accent',
				'label'      => esc_html__( 'Accent color', 'nanospace' ),
				'default'    => '#213169',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 10 . 220 => array(
				'type'        => 'color',
				'id'          => 'color_accent_text',
				'label'       => esc_html__( 'Accent text color', 'nanospace' ),
				'description' => esc_html__( 'Color of text on accent color background.', 'nanospace' ),
				'default'     => '#ffffff',
				'css_var'     => 'maybe_hash_hex_color',
				'preview_js'  => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),

			/**
			 * Colors: Header
			 */
			100 . 'colors' . 20       => array(
				'id'             => 'colors-header',
				'type'           => 'section',
				'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'nanospace' ), esc_html_x( 'Header', 'Customizer color section title', 'nanospace' ) ),
				'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'nanospace' ),
			),

			/**
			 * Header colors
			 */

			100 . 'colors' . 20 . 100 => array(
				'type'    => 'html',
				'content' => '<h3>' . esc_html__( 'Header', 'nanospace' ) . '</h3>',
			),

			100 . 'colors' . 20 . 110 => array(
				'type'        => 'color',
				'id'          => 'color_header_background',
				'label'       => esc_html__( 'Background color', 'nanospace' ),
				'description' => esc_html__( 'This color is also used to style a mobile device browser address bar.', 'nanospace' ) . ' <a href="https://wordpress.org/plugins/chrome-theme-color-changer/">' . esc_html__( 'You can further customize it with a dedicated plugin.', 'nanospace' ) . '</a>',
				'default'     => '#ffffff',
				'css_var'     => 'maybe_hash_hex_color',
				'preview_js'  => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 20 . 120 => array(
				'type'       => 'color',
				'id'         => 'color_header_text',
				'label'      => esc_html__( 'Text color', 'nanospace' ),
				'default'    => '#000000',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 20 . 130 => array(
				'type'       => 'color',
				'id'         => 'color_header_headings',
				'label'      => esc_html__( 'Site title (logo) color', 'nanospace' ),
				'default'    => '#000000',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),

			/**
			 * Header widgets colors
			 */
			100 . 'colors' . 20 . 300 => array(
				'type'        => 'html',
				'content'     => '<h3>' . esc_html__( 'Header widgets', 'nanospace' ) . '</h3>',
				'description' => esc_html__( 'Please note that this widgets area is displayed only if it contains some widgets.', 'nanospace' ),
			),

			100 . 'colors' . 20 . 310 => array(
				'type'       => 'color',
				'id'         => 'color_header_widgets_background',
				'label'      => esc_html__( 'Background color', 'nanospace' ),
				'default'    => '#000000',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 20 . 320 => array(
				'type'       => 'color',
				'id'         => 'color_header_widgets_text',
				'label'      => esc_html__( 'Text color', 'nanospace' ),
				'default'    => '#ffffff',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),

			/**
			 * Colors: Intro
			 */
			100 . 'colors' . 25       => array(
				'id'             => 'colors-intro',
				'type'           => 'section',
				'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'nanospace' ), esc_html_x( 'Intro', 'Customizer color section title', 'nanospace' ) ),
				'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'nanospace' ),
			),

			/**
			 * Intro colors
			 */
			100 . 'colors' . 25 . 100 => array(
				'type'        => 'html',
				'content'     => '<h3>' . esc_html__( 'Intro', 'nanospace' ) . '</h3>',
				'description' => esc_html__( 'This is a specially styled, main, dominant page title section.', 'nanospace' ),
			),

			100 . 'colors' . 25 . 110 => array(
				'type'       => 'color',
				'id'         => 'color_intro_background',
				'label'      => esc_html__( 'Background color', 'nanospace' ),
				'default'    => '#000000',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 25 . 120 => array(
				'type'       => 'color',
				'id'         => 'color_intro_text',
				'label'      => esc_html__( 'Text color', 'nanospace' ),
				'default'    => '#ffffff',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 25 . 130 => array(
				'type'       => 'color',
				'id'         => 'color_intro_headings',
				'label'      => esc_html__( 'Headings color', 'nanospace' ),
				'default'    => '#ffffff',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),

			/**
			 * Special Intro colors
			 */

			100 . 'colors' . 25 . 200 => array(
				'type'        => 'html',
				'content'     => '<h3>' . esc_html__( 'Intro overlay', 'nanospace' ) . '</h3>',
				'description' => esc_html__( 'Intro overlay is displayed on homepage only.', 'nanospace' ),
			),

			100 . 'colors' . 25 . 210 => array(
				'type'            => 'color',
				'id'              => 'color_intro_overlay_background',
				'label'           => esc_html__( 'Background color', 'nanospace' ),
				'default'         => '#000000',
				'css_var'         => 'maybe_hash_hex_color',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
				'active_callback' => 'is_front_page',
			),
			100 . 'colors' . 25 . 220 => array(
				'type'            => 'color',
				'id'              => 'color_intro_overlay_text',
				'label'           => esc_html__( 'Text color', 'nanospace' ),
				'default'         => '#ffffff',
				'css_var'         => 'maybe_hash_hex_color',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
				'active_callback' => 'is_front_page',
			),
			100 . 'colors' . 25 . 230 => array(
				'type'            => 'range',
				'id'              => 'color_intro_overlay_opacity',
				'label'           => esc_html__( 'Overlay opacity', 'nanospace' ),
				'default'         => .60,
				'min'             => .05,
				'max'             => .95,
				'step'            => .05,
				'multiplier'      => 100,
				'suffix'          => '%',
				'validate'        => 'nanospace_Library_Sanitize::float',
				'css_var'         => 'floatval',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
				'active_callback' => 'is_front_page',
			),

			/**
			 * Intro widgets colors
			 */

			100 . 'colors' . 25 . 500 => array(
				'type'        => 'html',
				'content'     => '<h3>' . esc_html__( 'Intro widgets', 'nanospace' ) . '</h3>',
				'description' => esc_html__( 'Please note that this widgets area is displayed only if it contains some widgets.', 'nanospace' ),
			),

			100 . 'colors' . 25 . 510 => array(
				'type'       => 'color',
				'id'         => 'color_intro_widgets_background',
				'label'      => esc_html__( 'Background color', 'nanospace' ),
				'default'    => '#000000',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 25 . 520 => array(
				'type'       => 'color',
				'id'         => 'color_intro_widgets_text',
				'label'      => esc_html__( 'Text color', 'nanospace' ),
				'default'    => '#ffffff',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 25 . 530 => array(
				'type'       => 'color',
				'id'         => 'color_intro_widgets_headings',
				'label'      => esc_html__( 'Headings color', 'nanospace' ),
				'default'    => '#ffffff',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),

			/**
			 * Colors: Content
			 */
			100 . 'colors' . 30       => array(
				'id'             => 'colors-content',
				'type'           => 'section',
				'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'nanospace' ), esc_html_x( 'Content', 'Customizer color section title', 'nanospace' ) ),
				'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'nanospace' ),
			),
			/**
			 * Content colors
			 */

			100 . 'colors' . 30 . 100 => array(
				'type'    => 'html',
				'content' => '<h3>' . esc_html__( 'Content', 'nanospace' ) . '</h3>',
			),

			100 . 'colors' . 30 . 110 => array(
				'type'       => 'color',
				'id'         => 'color_content_background',
				'label'      => esc_html__( 'Background color', 'nanospace' ),
				'default'    => '#fdfcfc',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 30 . 120 => array(
				'type'       => 'color',
				'id'         => 'color_content_text',
				'label'      => esc_html__( 'Text color', 'nanospace' ),
				'default'    => '#000000',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 30 . 130 => array(
				'type'       => 'color',
				'id'         => 'color_content_headings',
				'label'      => esc_html__( 'Headings color', 'nanospace' ),
				'default'    => '#000000',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),

			/**
			 * Colors: Footer
			 */
			100 . 'colors' . 40       => array(
				'id'             => 'colors-footer',
				'type'           => 'section',
				'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'nanospace' ), esc_html_x( 'Footer', 'Customizer color section title', 'nanospace' ) ),
				'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'nanospace' ),
			),
			/**
			 * Footer colors
			 */

			100 . 'colors' . 40 . 100 => array(
				'type'        => 'html',
				'content'     => '<h3>' . esc_html__( 'Footer', 'nanospace' ) . '</h3>',
				'description' => esc_html__( 'The main footer widgets area is displayed only if it contains some widgets.', 'nanospace' ),
			),

			100 . 'colors' . 40 . 110 => array(
				'type'       => 'color',
				'id'         => 'color_footer_background',
				'label'      => esc_html__( 'Background color', 'nanospace' ),
				'default'    => '#000000',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 40 . 120 => array(
				'type'       => 'color',
				'id'         => 'color_footer_text',
				'label'      => esc_html__( 'Text color', 'nanospace' ),
				'default'    => '#ffffff',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 40 . 130 => array(
				'type'       => 'color',
				'id'         => 'color_footer_headings',
				'label'      => esc_html__( 'Headings color', 'nanospace' ),
				'default'    => '#ffffff',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),

			100 . 'colors' . 40 . 140 => array(
				'type'       => 'image',
				'id'         => 'footer_image',
				'label'      => esc_html__( 'Background image', 'nanospace' ),
				'default'    => esc_url( trailingslashit( get_template_directory_uri() ) . 'assets/images/footer/footer.png' ),
				'css_var'    => 'NanoSpace_Library_Sanitize::css_image_url',
				'preview_js' => array(
					'custom' => "jQuery( '.site-footer' ).addClass( 'is-customize-preview' );",
					'css'    => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'prefix'   => 'url("',
								'suffix'   => '")',
							),
						),
					),
				),
			),
			100 . 'colors' . 40 . 141 => array(
				'type'       => 'select',
				'id'         => 'footer_image_position',
				'label'      => esc_html__( 'Image position', 'nanospace' ),
				'default'    => '50% 50%',
				'choices'    => array(

					'0 0'    => esc_html_x( 'Top left', 'Image position.', 'nanospace' ),
					'50% 0'  => esc_html_x( 'Top center', 'Image position.', 'nanospace' ),
					'100% 0' => esc_html_x( 'Top right', 'Image position.', 'nanospace' ),

					'0 50%'    => esc_html_x( 'Center left', 'Image position.', 'nanospace' ),
					'50% 50%'  => esc_html_x( 'Center', 'Image position.', 'nanospace' ),
					'100% 50%' => esc_html_x( 'Center right', 'Image position.', 'nanospace' ),

					'0 100%'    => esc_html_x( 'Bottom left', 'Image position.', 'nanospace' ),
					'50% 100%'  => esc_html_x( 'Bottom center', 'Image position.', 'nanospace' ),
					'100% 100%' => esc_html_x( 'Bottom right', 'Image position.', 'nanospace' ),

				),
				'css_var'    => 'esc_attr',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 40 . 142 => array(
				'type'       => 'select',
				'id'         => 'footer_image_size',
				'label'      => esc_html__( 'Image size', 'nanospace' ),
				'default'    => 'cover',
				'choices'    => array(
					'auto'    => esc_html_x( 'Original', 'Image size.', 'nanospace' ),
					'contain' => esc_html_x( 'Fit', 'Image size.', 'nanospace' ),
					'cover'   => esc_html_x( 'Fill', 'Image size.', 'nanospace' ),
				),
				'css_var'    => 'esc_attr',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 40 . 143 => array(
				'type'       => 'checkbox',
				'id'         => 'footer_image_repeat',
				'label'      => esc_html__( 'Tile the image', 'nanospace' ),
				'default'    => true,
				'css_var'    => 'NanoSpace_Library_Sanitize::css_checkbox_background_repeat',
				'preview_js' => array(
					'custom' => "jQuery( '.site-footer' ).addClass( 'is-customize-preview' ).css( 'background-repeat', ( to ) ? ( 'repeat' ) : ( 'no-repeat' ) );",
				),
			),
			100 . 'colors' . 40 . 144 => array(
				'type'       => 'checkbox',
				'id'         => 'footer_image_attachment',
				'label'      => esc_html__( 'Fix image position', 'nanospace' ),
				'default'    => false,
				'css_var'    => 'NanoSpace_Library_Sanitize::css_checkbox_background_attachment',
				'preview_js' => array(
					'custom' => "jQuery( '.site-footer' ).addClass( 'is-customize-preview' ).css( 'background-attachment', ( to ) ? ( 'fixed' ) : ( 'scroll' ) );",
				),
			),
			100 . 'colors' . 40 . 145 => array(
				'type'       => 'range',
				'id'         => 'footer_image_opacity',
				'label'      => esc_html__( 'Background image opacity', 'nanospace' ),
				'default'    => .05,
				'min'        => .05,
				'max'        => 1,
				'step'       => .05,
				'multiplier' => 100,
				'suffix'     => '%',
				'validate'   => 'NanoSpace_Library_Sanitize::float',
				'css_var'    => 'floatval',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),

			/**
			 * Footer secondary widgets colors
			 */
			100 . 'colors' . 40 . 200 => array(
				'type'        => 'html',
				'content'     => '<h3>' . esc_html__( 'Secondary widgets', 'nanospace' ) . '</h3>',
				'description' => esc_html__( 'Please note that this widgets area is displayed only if it contains some widgets.', 'nanospace' ),
			),

			100 . 'colors' . 40 . 210 => array(
				'type'       => 'color',
				'id'         => 'color_footer_secondary_background',
				'label'      => esc_html__( 'Background color', 'nanospace' ),
				'default'    => '#213169',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 40 . 220 => array(
				'type'       => 'color',
				'id'         => 'color_footer_secondary_text',
				'label'      => esc_html__( 'Text color', 'nanospace' ),
				'default'    => '#ffffff',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),
			100 . 'colors' . 40 . 230 => array(
				'type'       => 'color',
				'id'         => 'color_footer_secondary_headings',
				'label'      => esc_html__( 'Headings color', 'nanospace' ),
				'default'    => '#ffffff',
				'css_var'    => 'maybe_hash_hex_color',
				'preview_js' => array(
					'css' => array(
						':root' => array(
							'--[[id]]',
						),
					),
				),
			),

			/**
			 * Blog
			 */
			200 . 'blog'              => array(
				'id'             => 'blog',
				'type'           => 'section',
				'create_section' => esc_html_x( 'Blog', 'Customizer section title.', 'nanospace' ),
				'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'nanospace' ),
			),

			200 . 'blog' . 100 => array(
				'type'        => 'radio',
				'id'          => 'blog_style',
				'label'       => esc_html__( 'Blog style', 'nanospace' ),
				'description' => esc_html__( 'This layout style will be applied on blog, category and tag archive pages.', 'nanospace' ),
				'default'     => 'masonry',
				'choices'     => array(
					'masonry' => esc_html_x( 'Masonry', 'Blog style.', 'nanospace' ),
					'list'    => esc_html_x( 'List', 'Blog style.', 'nanospace' ),
					'minimal' => esc_html_x( 'Minimal', 'Blog style.', 'nanospace' ),
				),
			),

			200 . 'blog' . 110 => array(
				'type'            => 'select',
				'id'              => 'blog_style_masonry_image_size',
				'label'           => esc_html__( 'Masonry image size', 'nanospace' ),
				'description'     => esc_html__( 'Select a size for post thumbnail image in masonry style blog.', 'nanospace' ),
				'default'         => 'thumbnail',
				'choices'         => (array) $image_sizes,
				'active_callback' => __CLASS__ . '::is_blog_style_masonry',
			),

			200 . 'blog' . 120 => array(
				'type'         => 'select',
				'id'           => 'nanospace_post_layout',
				'label'        => esc_html__( 'Single Layout', 'nanospace' ),
				'description'  => esc_html__( 'Select layout for single post.', 'nanospace' ),
				'default'      => 'sidebar-none',
				'choices'      => (array) $single_layouts,
			),

			/**
			 * Layout
			 */
			300 . 'layout'       => array(
				'id'             => 'layout',
				'type'           => 'section',
				'create_section' => esc_html_x( 'Layout', 'Customizer section title.', 'nanospace' ),
				'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'nanospace' ),
			),

			/**
			 * Site layout
			 */
			300 . 'layout' . 100 => array(
				'type'    => 'html',
				'content' => '<h3>' . esc_html_x( 'Site Container', 'A website container.', 'nanospace' ) . '</h3>',
			),

			300 . 'layout' . 110 => array(
				'type'    => 'select',
				'id'      => 'layout_site',
				'label'   => esc_html__( 'Website layout', 'nanospace' ),
				'default' => 'boxed',
				'choices' => array(
					'fullwidth' => esc_html__( 'Fullwidth', 'nanospace' ),
					'boxed'     => esc_html__( 'Boxed', 'nanospace' ),
					'framed'    => esc_html__( 'Framed', 'nanospace' ),
					'wide'      => esc_html__( 'Wide', 'nanospace' ),
					'custom'    => esc_html__( 'Custom', 'nanospace' ),
				),
				// No need for `preview_js` here as it won't trigger the `active_callback` below.
			),

			300 . 'layout' . 120 => array(
				'type'            => 'range',
				'id'              => 'layout_width_site',
				'label'           => esc_html__( 'Website max width', 'nanospace' ),
				'description'     => esc_html__( 'For boxed website layout.', 'nanospace' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 1920 ) ),
				'default'         => 1920,
				'min'             => 1000,
				'max'             => 1920, // cca 1920 x 96%
				'step'            => 20,
				'suffix'          => 'px',
				'css_var'         => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'      => array(
					'custom' => "jQuery( '.masthead-placeholder #masthead' ).css( 'width', jQuery( '.masthead-placeholder' ).outerWidth() + 'px' );",
					'css'    => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
				'active_callback' => __CLASS__ . '::is_layout_site_boxed',
			),

			300 . 'layout' . 130 => array(
				'type'        => 'range',
				'id'          => 'layout_width_content',
				'label'       => esc_html__( 'Content width', 'nanospace' ),
				'description' => sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 1200 ) ),
				'default'     => 1200,
				'min'         => 880,
				'max'         => 1620, // cca ( 1920 x 96% ) x 88%
				'step'        => 20,
				'suffix'      => 'px',
				'css_var'     => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'  => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
			),

			300 . 'layout' . 121 => array(
				'type'            => 'range',
				'id'              => 'layout_custom_top_padding_site',
				'name'            => 'layout_custom_top_padding_site',
				'label'           => esc_html__( 'Custom top padding', 'nanospace' ),
				'description'     => esc_html__( 'For custom website top padding.', 'nanospace' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 0 ) ),
				'default'         => 0,
				'min'             => 0,
				'max'             => 300,
				'step'            => 1,
				'suffix'          => 'px',
				'css_var'         => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
				'active_callback' => __CLASS__ . '::is_layout_site_custom',
			),

			300 . 'layout' . 122 => array(
				'type'            => 'range',
				'id'              => 'layout_custom_left_padding_site',
				'name'            => 'layout_custom_left_padding_site',
				'label'           => esc_html__( 'Custom left padding', 'nanospace' ),
				'description'     => esc_html__( 'For custom website left padding.', 'nanospace' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 0 ) ),
				'default'         => 0,
				'min'             => 0,
				'max'             => 300,
				'step'            => 1,
				'suffix'          => 'px',
				'css_var'         => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
				'active_callback' => __CLASS__ . '::is_layout_site_custom',
			),

			300 . 'layout' . 123 => array(
				'type'            => 'range',
				'id'              => 'layout_custom_right_padding_site',
				'name'            => 'layout_custom_right_padding_site',
				'label'           => esc_html__( 'Custom right padding', 'nanospace' ),
				'description'     => esc_html__( 'For custom website right padding.', 'nanospace' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 0 ) ),
				'default'         => 0,
				'min'             => 0,
				'max'             => 300,
				'step'            => 1,
				'suffix'          => 'px',
				'css_var'         => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
				'active_callback' => __CLASS__ . '::is_layout_site_custom',
			),

			300 . 'layout' . 124 => array(
				'type'            => 'range',
				'id'              => 'layout_custom_bottom_padding_site',
				'name'            => 'layout_custom_bottom_padding_site',
				'label'           => esc_html__( 'Custom bottom padding', 'nanospace' ),
				'description'     => esc_html__( 'For custom website bottom padding.', 'nanospace' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 0 ) ),
				'default'         => 0,
				'min'             => 0,
				'max'             => 300,
				'step'            => 1,
				'suffix'          => 'px',
				'css_var'         => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
				'active_callback' => __CLASS__ . '::is_layout_site_custom',
			),

			300 . 'layout' . 125 => array(
				'type'            => 'range',
				'id'              => 'layout_custom_top_margin_site',
				'name'            => 'layout_custom_top_margin_site',
				'label'           => esc_html__( 'Custom top margin', 'nanospace' ),
				'description'     => esc_html__( 'For custom website top margin.', 'nanospace' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 0 ) ),
				'default'         => 0,
				'min'             => 0,
				'max'             => 300,
				'step'            => 1,
				'suffix'          => 'px',
				'css_var'         => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
				'active_callback' => __CLASS__ . '::is_layout_site_custom',
			),

			300 . 'layout' . 126 => array(
				'type'            => 'range',
				'id'              => 'layout_custom_left_margin_site',
				'name'            => 'layout_custom_left_margin_site',
				'label'           => esc_html__( 'Custom left margin', 'nanospace' ),
				'description'     => esc_html__( 'For custom website left margin.', 'nanospace' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 0 ) ),
				'default'         => 0,
				'min'             => 0,
				'max'             => 300,
				'step'            => 1,
				'suffix'          => 'px',
				'css_var'         => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
				'active_callback' => __CLASS__ . '::is_layout_site_custom',
			),

			300 . 'layout' . 127 => array(
				'type'            => 'range',
				'id'              => 'layout_custom_right_margin_site',
				'name'            => 'layout_custom_right_margin_site',
				'label'           => esc_html__( 'Custom right margin', 'nanospace' ),
				'description'     => esc_html__( 'For custom website right margin.', 'nanospace' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 0 ) ),
				'default'         => 0,
				'min'             => 0,
				'max'             => 300,
				'step'            => 1,
				'suffix'          => 'px',
				'css_var'         => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
				'active_callback' => __CLASS__ . '::is_layout_site_custom',
			),

			300 . 'layout' . 128 => array(
				'type'            => 'range',
				'id'              => 'layout_custom_bottom_margin_site',
				'name'            => 'layout_custom_bottom_margin_site',
				'label'           => esc_html__( 'Custom bottom margin', 'nanospace' ),
				'description'     => esc_html__( 'For custom website bottom margin.', 'nanospace' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'nanospace' ), number_format_i18n( 0 ) ),
				'default'         => 0,
				'min'             => 0,
				'max'             => 300,
				'step'            => 1,
				'suffix'          => 'px',
				'css_var'         => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'      => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
				'active_callback' => __CLASS__ . '::is_layout_site_custom',
			),

			300 . 'layout' . 140 => array(
				'type'    => 'select',
				'id'      => 'nanospace_enable_scroll_top',
				'label'   => esc_html__( 'Enable Scroll To Top Feature', 'nanospace' ),
				'default' => 'yes',
				'choices' => (array) $yesno_options,
			),

			300 . 'layout' . 150 => array(
				'type'    => 'select',
				'id'      => 'nanospace_enable_scroll_anchor',
				'label'   => esc_html__( 'Enable Scroll To anchors or IDs', 'nanospace' ),
				'default' => 'no',
				'choices' => (array) $yesno_options,
			),

			/**
			 * Header layout
			 */
			300 . 'layout' . 200 => array(
				'type'    => 'html',
				'content' => '<h3>' . esc_html__( 'Header', 'nanospace' ) . '</h3>',
			),

			300 . 'layout' . 210 => array(
				'type'       => 'radio',
				'id'         => 'layout_header',
				'label'      => esc_html__( 'Header layout', 'nanospace' ),
				'default'    => 'boxed',
				'choices'    => array(
					'fullwidth' => esc_html__( 'Fullwidth', 'nanospace' ),
					'boxed'     => esc_html__( 'Boxed', 'nanospace' ),
				),
				'preview_js' => array(
					'custom' => "jQuery( 'body' ).toggleClass( 'header-layout-boxed' ).toggleClass( 'header-layout-fullwidth' );",
				),
			),

			300 . 'layout' . 220 => array(
				'type'        => 'checkbox',
				'id'          => 'layout_header_sticky',
				'label'       => esc_html__( 'Sticky header', 'nanospace' ),
				'description' => esc_html__( 'Allow header to appear when user attempt to scroll up.', 'nanospace' ),
				'default'     => true,
				// No need for `preview_js` here as we also need to load the scripts.
			),

			/**
			 * Intro layout
			 */
			300 . 'layout' . 300 => array(
				'type'    => 'html',
				'content' => '<h3>' . esc_html__( 'Intro', 'nanospace' ) . '</h3>',
			),

			300 . 'layout' . 310 => array(
				'type'        => 'radio',
				'id'          => 'layout_intro_widgets_display',
				'label'       => esc_html__( 'Enable intro widgets', 'nanospace' ),
				'description' => esc_html__( 'If you enable this widget area also for archives, we recommend using a plugin to control its appearance further more.', 'nanospace' ) . ' <a href="https://wordpress.org/plugins/search/sidebars/">' . esc_html__( 'You can use any sidebar management plugin from WordPress.org.', 'nanospace' ) . '</a>',
				'default'     => '',
				'choices'     => array(
					''       => esc_html__( 'On singular pages only', 'nanospace' ),
					'always' => esc_html__( 'On both archive and singular pages', 'nanospace' ),
				),
			),

			/**
			 * Content layout
			 */
			300 . 'layout' . 400 => array(
				'type'    => 'html',
				'content' => '<h3>' . esc_html__( 'Content', 'nanospace' ) . '</h3>',
			),

			300 . 'layout' . 410 => array(
				'type'        => 'checkbox',
				'id'          => 'layout_page_outdent',
				'label'       => esc_html__( 'Outdented page content', 'nanospace' ),
				'description' => esc_html__( 'Page content will be displayed in 2 columns: H2 headings in first, all the other page content in second column.', 'nanospace' ) . ' ' . esc_html__( 'This does not affect pages using "With sidebar" page template.', 'nanospace' ),
				'default'     => false,
				'preview_js'  => array(
					'custom' => "jQuery( 'body.page:not(.page-template-sidebar)' ).toggleClass( 'page-layout-outdented' );",
				),
			),

			/**
			 * Footer layout
			 */
			300 . 'layout' . 500 => array(
				'type'    => 'html',
				'content' => '<h3>' . esc_html__( 'Footer', 'nanospace' ) . '</h3>',
			),

			300 . 'layout' . 510 => array(
				'type'       => 'radio',
				'id'         => 'layout_footer',
				'label'      => esc_html__( 'Footer layout', 'nanospace' ),
				'default'    => 'boxed',
				'choices'    => array(
					'fullwidth' => esc_html__( 'Fullwidth', 'nanospace' ),
					'boxed'     => esc_html__( 'Boxed', 'nanospace' ),
				),
				'preview_js' => array(
					'custom' => "jQuery( 'body' ).toggleClass( 'footer-layout-boxed' ).toggleClass( 'footer-layout-fullwidth' );",
				),
			),
			/**
			 * Typography
			 */
			900 . 'typography'  => array(
				'id'             => 'typography',
				'type'           => 'section',
				'create_section' => esc_html_x( 'Typography', 'Customizer section title.', 'nanospace' ),
				'in_panel'       => esc_html_x( 'Theme Options', 'Customizer panel title.', 'nanospace' ),
			),

			900 . 'typography' . 100 => array(
				'type'        => 'range',
				'id'          => 'typography_size_html',
				'label'       => esc_html__( 'Basic font size in px', 'nanospace' ),
				'description' => esc_html__( 'All other font sizes are calculated automatically from this basic font size.', 'nanospace' ),
				'default'     => 16,
				'min'         => 12,
				'max'         => 24,
				'step'        => 1,
				'suffix'      => 'px',
				'validate'    => 'absint',
				'css_var'     => 'NanoSpace_Library_Sanitize::css_pixels',
				'preview_js'  => array(
					'css' => array(
						':root' => array(
							array(
								'property' => '--[[id]]',
								'suffix'   => 'px',
							),
						),
					),
				),
			),

			900 . 'typography' . 200 => array(
				'type'        => 'checkbox',
				'id'          => 'typography_custom_fonts',
				'label'       => esc_html__( 'Use custom fonts', 'nanospace' ),
				'description' => esc_html__( 'Disables theme default fonts loading and lets you set up your own custom fonts.', 'nanospace' ),
				'default'     => false,
			),

			900 . 'typography' . 210 => array(
				'type'            => 'html',
				'content'         => '<h3>' . esc_html__( 'Custom fonts setup', 'nanospace' ) . '</h3><p class="description">' . sprintf(
						esc_html_x( 'This theme does not restrict you to choose from a predefined set of fonts. Instead, please use any font service (such as %s) plugin you like.', '%s: linked examples of web fonts libraries such as Google Fonts or Adobe Typekit.', 'nanospace' ),
						'<a href="http://www.google.com/fonts"><strong>Google Fonts</strong></a>, <a href="https://typekit.com/fonts"><strong>Adobe Typekit</strong></a>'
					) . '</p><p class="description">' . esc_html__( 'You can set your fonts plugin according to information provided below, or insert your custom font names (a value of "font-family" CSS property) directly into input fields (you still need to use a plugin to load those fonts on the website).', 'nanospace' ) . '</p>',
				'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
			),

			900 . 'typography' . 290 => array(
				'type'            => 'html',
				'content'         => '<h3>' . esc_html__( 'Info: CSS selectors', 'nanospace' ) . '</h3>'
				                     . '<p class="description">' . esc_html__( 'Here you can find CSS selectors/variables list associated with each font group in the theme. You can use these in your custom font plugin settings.', 'nanospace' ) . '</p>'

				                     . '<p>'
				                     . '<strong>' . esc_html__( 'General text font CSS selectors:', 'nanospace' ) . '</strong>'
				                     . '</p>'
				                     . '<pre>'
				                     . '--typography_fonts_text'
				                     . '</pre>'

				                     . '<p>'
				                     . '<strong>' . esc_html__( 'Headings font CSS selectors:', 'nanospace' ) . '</strong>'
				                     . '</p>'
				                     . '<pre>'
				                     . '--typography_fonts_headings'
				                     . '</pre>'

				                     . '<p>'
				                     . '<strong>' . esc_html__( 'Logo font CSS selectors:', 'nanospace' ) . '</strong>'
				                     . '</p>'
				                     . '<pre>'
				                     . '--typography_fonts_logo'
				                     . '</pre>',
				'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
			),
		);

		if ( ! empty( $custom_fonts ) ) {
			$options = array_merge( $options, array(
				900 . 'typography' . 220 => array(
					'type'            => 'select',
					'id'              => 'typography_fonts_text',
					'label'           => esc_html__( 'General text font', 'nanospace' ),
					'default'         => "",
					'input_attrs'     => array(
						'multiple' => "multiple",
					),
					'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
					'validate'        => 'NanoSpace_Library_Sanitize::fonts',
					'css_var'         => 'NanoSpace_Library_Sanitize::css_fonts',
					'choices'         => $custom_fonts,
				),

				900 . 'typography' . 230 => array(
					'type'            => 'select',
					'id'              => 'typography_fonts_headings',
					'label'           => esc_html__( 'Headings font', 'nanospace' ),
					'default'         => "",
					'input_attrs'     => array(
						'multiple' => "multiple",
					),
					'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
					'validate'        => 'NanoSpace_Library_Sanitize::fonts',
					'css_var'         => 'NanoSpace_Library_Sanitize::css_fonts',
					'choices'         => $custom_fonts,
				),

				900 . 'typography' . 240 => array(
					'type'            => 'select',
					'id'              => 'typography_fonts_logo',
					'label'           => esc_html__( 'Logo font', 'nanospace' ),
					'default'         => "",
					'input_attrs'     => array(
						'multiple' => "multiple",
					),
					'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
					'validate'        => 'NanoSpace_Library_Sanitize::fonts',
					'css_var'         => 'NanoSpace_Library_Sanitize::css_fonts',
					'choices'         => $custom_fonts,
				)
			) );
		} else {
			$options = array_merge( $options, array(
				900 . 'typography' . 220 => array(
					'type'            => 'text',
					'id'              => 'typography_fonts_text',
					'label'           => esc_html__( 'General text font', 'nanospace' ),
					'description'     => sprintf(
						esc_html__( 'Default value: %s', 'nanospace' ),
						'<code>' . "'Fira Sans', 'Helvetica Neue', Arial, sans-serif" . '</code>'
					),
					'default'         => "'Fira Sans', 'Helvetica Neue', Arial, sans-serif",
					'input_attrs'     => array(
						'placeholder' => "'Fira Sans', 'Helvetica Neue', Arial, sans-serif",
					),
					'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
					'validate'        => 'NanoSpace_Library_Sanitize::fonts',
					'css_var'         => 'NanoSpace_Library_Sanitize::css_fonts',
				),

				900 . 'typography' . 230 => array(
					'type'            => 'text',
					'id'              => 'typography_fonts_headings',
					'label'           => esc_html__( 'Headings font', 'nanospace' ),
					'description'     => sprintf(
						esc_html__( 'Default value: %s', 'nanospace' ),
						'<code>' . "'Fira Sans', 'Helvetica Neue', Arial, sans-serif" . '</code>'
					),
					'default'         => "'Fira Sans', 'Helvetica Neue', Arial, sans-serif",
					'input_attrs'     => array(
						'placeholder' => "'Fira Sans', 'Helvetica Neue', Arial, sans-serif",
					),
					'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
					'validate'        => 'NanoSpace_Library_Sanitize::fonts',
					'css_var'         => 'NanoSpace_Library_Sanitize::css_fonts',
				),

				900 . 'typography' . 240 => array(
					'type'            => 'text',
					'id'              => 'typography_fonts_logo',
					'label'           => esc_html__( 'Logo font', 'nanospace' ),
					'description'     => sprintf(
						esc_html__( 'Default value: %s', 'nanospace' ),
						'<code>' . "'Fira Sans', 'Helvetica Neue', Arial, sans-serif" . '</code>'
					),
					'default'         => "'Fira Sans', 'Helvetica Neue', Arial, sans-serif",
					'input_attrs'     => array(
						'placeholder' => "'Fira Sans', 'Helvetica Neue', Arial, sans-serif",
					),
					'active_callback' => __CLASS__ . '::is_typography_custom_fonts',
					'validate'        => 'NanoSpace_Library_Sanitize::fonts',
					'css_var'         => 'NanoSpace_Library_Sanitize::css_fonts',
				)
			) );
		}

		return $options;

	} // /options

	/**
	 * 20) Active callbacks
	 */

	/**
	 * Is site layout: Boxed?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $control
	 */
	public static function is_layout_site_boxed( $control ) {

		$option = $control->manager->get_setting( 'layout_site' );

		return ( 'boxed' == $option->value() );

	} // /is_layout_site_boxed

	/**
	 * Is site layout: Fullwidth?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $control
	 */
	public static function is_layout_site_fullwidth( $control ) {

		$option = $control->manager->get_setting( 'layout_site' );

		return ( 'fullwidth' == $option->value() );

	} // /is_layout_site_fullwidth

	/**
	 * Is site layout: Fullwidth?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $control
	 */
	public static function is_layout_site_custom( $control ) {

		$option = $control->manager->get_setting( 'layout_site' );

		return ( 'custom' == $option->value() );

	} // /is_layout_site_custom

	/**
	 * Do you want to use custom fonts?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $control
	 */
	public static function is_typography_custom_fonts( $control ) {

		$option = $control->manager->get_setting( 'typography_custom_fonts' );

		return (bool) $option->value();

	} // /is_typography_custom_fonts

	/**
	 * Is masonry blog style?
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $control
	 */
	public static function is_blog_style_masonry( $control ) {

		$option = $control->manager->get_setting( 'blog_style' );

		return ( 'masonry' == $option->value() );

	} // /is_blog_style_masonry

	/**
	 * 30) Partial refresh
	 */

	/**
	 * Render the site title for the selective refresh partial
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function partial_blogname() {

		bloginfo( 'name' );

	} // /partial_blogname

	/**
	 * Render the site tagline for the selective refresh partial
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function partial_blogdescription() {

		bloginfo( 'description' );

	} // /partial_blogdescription

	/**
	 * Render the site info in the footer for the selective refresh partial
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function partial_texts_site_info() {

		$site_info_text = trim( get_theme_mod( 'texts_site_info' ) );
		?>

		<div class="site-info">
			<?php
			if ( empty( $site_info_text ) ) {
				esc_html_e( 'Please set your website credits text or the theme default one will be displayed.', 'nanospace' );
			} else {
				echo (string) $site_info_text;
			}
			?>
		</div>

		<?php

	} // /partial_texts_site_info

	/**
	 * 100) Helpers
	 */

	/**
	 * Alpha values (%) for generating rgba() colors.
	 *
	 * Don't forget to update CSS variables too.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $alphas
	 */
	public static function rgba_alphas( $alphas = array() ) {

		return array(
			'color_content_text'          => 20,
			'color_footer_secondary_text' => 20,
			'color_footer_text'           => 20,
			'color_header_text'           => 20,
			'color_header_widgets_text'   => 20,
			'color_intro_text'            => 20,
			'color_intro_widgets_text'    => 20,
		);

	} // /rgba_alphas

} // /NanoSpace_Customize

add_action( 'after_setup_theme', 'NanoSpace_Customize::init' );
