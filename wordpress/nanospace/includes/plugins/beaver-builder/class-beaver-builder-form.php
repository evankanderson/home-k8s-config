<?php

/**
 * Beaver Builder: Form Class
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
 * 10) Custom options
 * 20) Classes
 */
class NanoSpace_Beaver_Builder_Form {
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
// Filters

		add_filter( 'fl_builder_register_settings_form', __CLASS__ . '::register_settings_form', 10, 2 );

		add_filter( 'fl_builder_field_js_config', __CLASS__ . '::predefined_classes_dropdown', 10, 2 );

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
	 * 10) Custom options
	 */

	/**
	 * Settings form alterations
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $form
	 * @param  string $id
	 */
	public static function register_settings_form( $form, $id ) {
// Row and/or column settings only

		if ( in_array( $id, array( 'col', 'row' ) ) ) {

			// Adding column content vertical centering option

			$form['tabs']['style']['sections']['general']['fields']['vertical_alignment'] = array(
				'type'    => 'select',
				'label'   => esc_html__( 'Content Vertical Alignment', 'nanospace' ),
				'help'    => esc_html__( 'As the theme makes all columns in a row equally high automatically, it allows you to set the column content vertical alignment here.', 'nanospace' ),
				'default' => '',
				'options' => array(
					''                      => esc_html_x( 'Initial', 'Vertical content alignment value', 'nanospace' ),
					'vertical-align-top'    => esc_html_x( 'Top', 'Vertical content alignment value', 'nanospace' ),
					'vertical-align-middle' => esc_html_x( 'Middle', 'Vertical content alignment value', 'nanospace' ),
					'vertical-align-bottom' => esc_html_x( 'Bottom', 'Vertical content alignment value', 'nanospace' ),
				),
				'preview' => array(
					'type' => 'none',
				),
			);

			// Adding "Predefined colors" section just after the "General" section

			// Backing up all the sections to keep the order of the fields

			$sections = $form['tabs']['style']['sections'];

			// Backing up and removing the first section ("General"), so we can merge it later in the correct order

			$section_general = array( 'general' => $form['tabs']['style']['sections']['general'] );

			unset( $sections['general'] );

			// "Predefined colors" section setup

			$section_colors_predefined = array(

				'colors_predefined' => array(
					'title'  => esc_html__( 'Predefined Colors', 'nanospace' ),
					'fields' => array(

						'predefined_color' => array(
							'type'        => 'select',
							'label'       => esc_html__( 'Assign predefined colors', 'nanospace' ),
							'help'        => esc_html__( 'You can override these further below by setting up a custom background or text color', 'nanospace' ),
							'description' => '<br><br>' . esc_html__( 'Set this to match the colors of theme predefined sections', 'nanospace' ),
							'default'     => '',
							'options'     => array(
								'' => esc_html__( '- No predefined color -', 'nanospace' ),

								// Color classes

								'optgroup-sections' => array(
									'label'   => esc_html__( 'Theme sections colors:', 'nanospace' ),
									'options' => array(

										'set-colors-header'                   => esc_html__( 'Set header colors', 'nanospace' ),
										'set-colors-header-widgets'           => esc_html__( 'Set header widgets colors', 'nanospace' ),
										'set-colors-intro'                    => esc_html__( 'Set intro colors', 'nanospace' ),
										'set-colors-intro-widgets'            => esc_html__( 'Set intro widgets colors', 'nanospace' ),
										'set-colors-content'                  => esc_html__( 'Set content colors', 'nanospace' ),
										'set-colors-footer'                   => esc_html__( 'Set footer colors', 'nanospace' ),
										'set-colors-footer-secondary-widgets' => esc_html__( 'Set footer secondary widgets colors', 'nanospace' ),

									),
								),

								// Accent colors

								'optgroup-accents' => array(
									'label'   => esc_html__( 'Accent colors:', 'nanospace' ),
									'options' => array(

										'set-colors-accent'  => esc_html__( 'Set primary accent colors', 'nanospace' ),
										'hover-color-accent' => esc_html__( 'Set primary accent colors on mouse hover', 'nanospace' ),

										'set-colors-error'  => esc_html__( 'Set error colors', 'nanospace' ),
										'hover-color-error' => esc_html__( 'Set error colors on mouse hover', 'nanospace' ),

										'set-colors-info'  => esc_html__( 'Set info colors', 'nanospace' ),
										'hover-color-info' => esc_html__( 'Set info colors on mouse hover', 'nanospace' ),

										'set-colors-success'  => esc_html__( 'Set success colors', 'nanospace' ),
										'hover-color-success' => esc_html__( 'Set success colors on mouse hover', 'nanospace' ),

										'set-colors-warning'  => esc_html__( 'Set warning colors', 'nanospace' ),
										'hover-color-warning' => esc_html__( 'Set warning colors on mouse hover', 'nanospace' ),

									),
								),

							),
							'preview'     => array(
								'type' => 'none',
							),
						),

					),
				),

			);

			// Putting the sections all together in specific order

			$form['tabs']['style']['sections'] = array_merge( $section_general, $section_colors_predefined, $sections );

		}


		return $form;

	} // /register_settings_form
	/**
	 * 20) Classes
	 */

	/**
	 * Add predefined classes helper dropdown
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $field
	 * @param  name $name
	 */
	public static function predefined_classes_dropdown( $field, $name ) {
		if ( 'class' == $name ) {

			$field['options'] = array(

				'' => esc_html__( '- Choose from predefined classes -', 'nanospace' ),

				// Posts list classes

				'optgroup-posts' => array(
					'label'   => esc_html__( 'Post lists:', 'nanospace' ),
					'options' => array(

						'masonry' => esc_html__( 'Masonry items layout', 'nanospace' ),

						'compact-layout' => esc_html__( 'Posts: Compact layout', 'nanospace' ),

						'hide-title'       => esc_html__( 'Content Module: Hide title', 'nanospace' ),
						'hide-more-button' => esc_html__( 'Content Module: Hide "Read more" button', 'nanospace' ),
						'item-border'      => esc_html__( 'Content Module: Border around items', 'nanospace' ),

					),
				),

				// Decoration classes

				'optgroup-decoration' => array(
					'label'   => esc_html__( 'Decorations:', 'nanospace' ),
					'options' => array(

						'box-shadow-small'  => esc_html__( 'Column shadow, small', 'nanospace' ),
						'box-shadow-medium' => esc_html__( 'Column shadow, medium', 'nanospace' ),
						'box-shadow-large'  => esc_html__( 'Column shadow, large', 'nanospace' ),

					),
				),

				// Layout classes

				'optgroup-layout' => array(
					'label'   => esc_html__( 'Layout:', 'nanospace' ),
					'options' => array(

						'text-center' => esc_html__( 'Text center', 'nanospace' ),
						'text-left'   => esc_html__( 'Text left', 'nanospace' ),
						'text-right'  => esc_html__( 'Text right', 'nanospace' ),

						'fullwidth' => esc_html__( 'Fullwidth elements', 'nanospace' ),

						'hide-accessibly' => esc_html__( 'Hide accessibly (displayed in page builder edit mode only)', 'nanospace' ),

						'split-screen-row' => esc_html__( 'Split screen row (apply on full-height row only)', 'nanospace' ),

						'zindex-10' => esc_html__( 'Bring element to front (CSS z-index)', 'nanospace' ),

					),
				),

				// Widget classes

				'optgroup-widget' => array(
					'label'   => esc_html__( 'Widgets:', 'nanospace' ),
					'options' => array(

						'widget-title-style'           => esc_html__( 'Use default widget title styling', 'nanospace' ),
						'hide-widget-title-accessibly' => esc_html__( 'Hide widget title accessibly', 'nanospace' ),
						'hide-widget-title'            => esc_html__( 'Hide widget title forcefully', 'nanospace' ),

					),
				),

				// Typography classes

				'optgroup-typography' => array(
					'label'   => esc_html__( 'Typography:', 'nanospace' ),
					'options' => array(

						'font-size-xs' => esc_html__( 'Font size, extra small', 'nanospace' ),
						'font-size-s'  => esc_html__( 'Font size, small', 'nanospace' ),
						'font-size-sm' => esc_html__( 'Font size, smaller', 'nanospace' ),
						'font-size-l'  => esc_html__( 'Font size, large', 'nanospace' ),
						'font-size-xl' => esc_html__( 'Font size, extra large', 'nanospace' ),

					),
				),

			);

		}


		return $field;

	} // /predefined_classes_dropdown
} // /NanoSpace_Beaver_Builder_Form

add_action( 'after_setup_theme', 'NanoSpace_Beaver_Builder_Form::init' );
