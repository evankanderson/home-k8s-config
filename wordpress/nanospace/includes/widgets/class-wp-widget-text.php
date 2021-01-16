<?php
/**
 * Widget: WordPress Text
 *
 * Altering native WordPress Text widget.
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Widget functionality
 */
/**
 * 1) Requirements check
 */

if (
	! class_exists( 'WP_Widget' )
	|| ! class_exists( 'WP_Widget_Text' )
) {
	return;
}
/**
 * 10) Widget functionality
 */

/**
 * Widget class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * Contents:
 *
 *  0) Init
 * 10) Output
 * 20) Options
 * 30) Admin
 * 40) Icon fallback
 */
class NanoSpace_WP_Widget_Text extends WP_Widget_Text {
	/**
	 * 0) Init
	 */

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public function __construct() {
		parent::__construct();
		// Actions

		add_action( 'admin_print_scripts-widgets.php', __CLASS__ . '::enqueue' );

		add_action( 'wp_head', __CLASS__ . '::style_icon_fallback', 5 );

	} // /__construct
	/**
	 * 10) Output
	 */

	/**
	 * Enqueue assets
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function enqueue() {
		// Styles

		wp_enqueue_style(
			'nanospace-widget-text',
			get_theme_file_uri( 'assets/css/options-widget-text.css' ),
			array(),
			esc_attr( NANOSPACE_THEME_VERSION )
		);

		// Scripts

		wp_enqueue_media();

		wp_enqueue_script(
			'nanospace-widget-text',
			get_theme_file_uri( 'assets/js/scripts-widget-text.js' ),
			array( 'media-upload' ),
			esc_attr( NANOSPACE_THEME_VERSION ),
			true
		);

	} // /widget

	/**
	 * Icon fallback styles
	 *
	 * For cases when no icons font is loaded.
	 *
	 * IMPORTANT:
	 * This has to be loaded early enough, before the icons font
	 * stylesheet is enqueued (with any plugin)!
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	public static function style_icon_fallback() {

		echo '<style id="nanospace-text-widget-icon-fallback">'
		     . '.widget-symbol::before { content: "?"; font-family: inherit; }'
		     . '</style>';

	} // /get_widget_media_image

	/**
	 * Outputs the content for the current widget instance
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $args Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param  array $instance Settings for the current Text widget instance.
	 */
	public function widget( $args, $instance ) {


		$output = '';

		$widget_media = array_filter( array(
			'icon'  => ( isset( $instance['icon'] ) ) ? ( trim( $instance['icon'] ) ) : ( '' ),
			'image' => ( isset( $instance['image'] ) ) ? ( $instance['image'] ) : ( 0 ),
		) );
		// Requirements check

		if ( empty( $widget_media ) ) {
			parent::widget( $args, $instance );

			return;
		}
		// Adding widget media before widget title

		$args['before_widget'] .= self::get_widget_media_image( $widget_media );
		$args['before_widget'] .= self::get_widget_media_icon( $widget_media );

		// Wrapping widget title and content with custom div

		$args['before_widget'] .= '<div class="widget-text-content">';
		$args['after_widget']  = '</div>' . $args['after_widget'];


		// Now everything is set and we can output the widget HTML
		parent::widget( $args, $instance );

	} // /get_widget_media_icon
	/**
	 * 20) Options
	 */

	/**
	 * Get output HTML of widget media: Image
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $widget_media Media setup array.
	 */
	public static function get_widget_media_image( $widget_media = array() ) {

		// Requirements check

		if (
			! isset( $widget_media['image'] )
			|| empty( $widget_media['image'] )
		) {
			return '';
		}


		$output = '';
		$output .= '<div class="widget-text-media widget-text-media-image">';

		if ( is_numeric( $widget_media['image'] ) ) {
			$output .= wp_get_attachment_image( absint( $widget_media['image'] ), 'medium' );
		} else {
			$output .= '<img
							src="' . esc_url( $widget_media['image'] ) . '"
							alt="' . esc_attr__( 'Widget featured image', 'nanospace' ) . '"
							/>';
		}

		$output .= '</div>';


		return $output;

	} // /form

	/**
	 * Get output HTML of widget media: Icon
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $widget_media Media setup array.
	 */
	public static function get_widget_media_icon( $widget_media = array() ) {

		// Requirements check

		if (
			! isset( $widget_media['icon'] )
			|| empty( $widget_media['icon'] )
		) {
			return '';
		}


		$output = '';
		$output .= '<div class="widget-text-media widget-text-media-icon h3">'; // Heading class is to inherit heading colors.
		$output .= '<span class="widget-symbol ' . esc_attr( $widget_media['icon'] ) . '" aria-hidden="true"></span>';
		$output .= '</div>';


		return $output;

	} // /field_icon

	/**
	 * Outputs the settings form
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $instance Current settings.
	 */
	public function form( $instance ) {
		parent::form( $instance );


		/**
		 * Warning:
		 * Do not use static method call here (self::X), keep using $this->X!
		 */
		$this->field_icon( $instance );
		$this->field_image( $instance );

	} // /field_image

	/**
	 * Option field: Icon
	 *
	 * Warning:
	 * Do not feel tempted to make this a static method!
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $instance Current settings.
	 */
	public function field_icon( $instance = array() ) {


		if ( ! isset( $instance['icon'] ) ) {
			$instance['icon'] = '';
		}

		?>

		<p class="text-widget-media-icon">
			<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>">
			<strong><?php esc_html_e( 'Set icon CSS class:', 'nanospace' ); ?></strong><br>
				<span class="description" style="display: inline-block; padding: 0 0 .38em">
								<em>
									<?php

									printf(
										esc_html__( 'For displaying icons on your website use a plugin, such as %1$s or %2$s.', 'nanospace' ),
										'<a href="https://wordpress.org/plugins/better-font-awesome/">' . esc_html_x( 'Better Font Awesome', 'Plugin name.', 'nanospace' ) . '</a>',
										'<a href="https://wordpress.org/plugins/ionicons-official/">' . esc_html_x( 'Ionicons Official', 'Plugin name.', 'nanospace' ) . '</a>'
									);

									if ( class_exists( 'WM_Icons' ) ) {
										echo '<br><strong>' . esc_html__( 'As your theme supports custom icons, you can simply use icon classes from Appearance &rarr; Icon Font.', 'nanospace' ) . '</strong>';
									}

									?>
								</em>
							</span>
			</label>
			<input type="text" class="widefat text-widget-media-icon-class"
                   id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>"
                   value="<?php echo esc_attr( $instance['icon'] ); ?>"/>
		</p>

		<?php

	} // /update
	/**
	 * 30) Admin
	 */

	/**
	 * Option field: Image
	 *
	 * Warning:
	 * Do not feel tempted to make this a static method!
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $instance Current settings.
	 */
	public function field_image( $instance = array() ) {

		if ( ! isset( $instance['image'] ) ) {
			$instance['image'] = 0;
		}

		?>

		<p class="text-widget-media-image">
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>">
			<strong><?php esc_html_e( 'Set image:', 'nanospace' ); ?></strong><br>
				<span class="description" style="display: inline-block; padding: 0 0 .38em">
					<em>
						<?php esc_html_e( 'Choose a featured image for this widget.', 'nanospace' ); ?>
					</em>
				</span>
			</label>
			<br>
			<button class="button button-hero text-widget-media-image-select"><?php esc_html_e( 'Select image', 'nanospace' ); ?></button>
			<input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>"
                   value="<?php echo esc_attr( $instance['image'] ); ?>"/>
			<span class="text-widget-media-image-preview"<?php if ( empty( $instance['image'] ) ) {
				echo ' style="display: none;"';
			} ?>>
							<img src="<?php

							if ( is_numeric( $instance['image'] ) ) {
								$image_url = wp_get_attachment_image_src( absint( $instance['image'] ) );
								if ( $image_url ) {
									echo esc_url( $image_url[0] );
								}
							} elseif ( $instance['image'] ) {
								echo esc_url( $instance['image'] );
							}

							?>" alt="<?php esc_attr_e( 'Widget featured image', 'nanospace' ); ?>"/>
							<button class="button text-widget-media-image-remove">
								<span class="screen-reader-text"><?php esc_html_e( 'Remove image', 'nanospace' ); ?></span>
							</button>
						</span>
        </p>

		<?php

	} // /enqueue
	/**
	 * 40) Icon fallback
	 */

	/**
	 * Handles updating settings for the current widget instance
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  array $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param  array $old_instance Old settings for this instance.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = parent::update( $new_instance, $old_instance );

		if ( ! isset( $new_instance['icon'] ) ) {
			$new_instance['icon'] = '';
		}

		if ( ! isset( $new_instance['image'] ) ) {
			$new_instance['image'] = '';
		}
		$instance['icon']  = sanitize_key( esc_attr( $new_instance['icon'] ) );
		$instance['image'] = ( is_numeric( $new_instance['image'] ) ) ? ( absint( $new_instance['image'] ) ) : ( esc_url_raw( $new_instance['image'] ) );


		return $instance;

	} // /style_icon_fallback
} // /NanoSpace_WP_Widget_Text
/**
 * Widget registration
 *
 * @since 1.0.0
 * @version 1.0.0
 */
function nanospace_register_widget_text() {
	unregister_widget( 'WP_Widget_Text' );

	register_widget( 'NanoSpace_WP_Widget_Text' );

} // /nanospace_register_widget_text

add_action( 'widgets_init', 'nanospace_register_widget_text' );
