<?php

/**
 * Required Plugins Class
 *
 * @package    NanoSpace
 * @copyright  Labinator
 *
 * @since    1.0.0
 * @version  1.4.0
 *
 * Contents:
 *
 *   0) Init
 *  10) Recommend
 * 100) Helpers
 */
class NanoSpace_TGMPA_Plugins {
	/**
	 * 0) Init
	 */

	private static $instance;

	/**
	 * Constructor
	 *
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	private function __construct() {
// Actions

		add_action( 'tgmpa_register', __CLASS__ . '::recommend' );

		add_action( 'admin_notices', __CLASS__ . '::notice' );

		// Filters

		add_filter( 'tgmpa_table_columns', __CLASS__ . '::table_columns' );

		add_filter( 'tgmpa_table_data_item', __CLASS__ . '::table_data', 10, 2 );

	} // /__construct

	/**
	 * Initialization (get instance)
	 *
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}


		return self::$instance;

	} // /init
	/**
	 * 10) Recommend
	 */

	/**
	 * Recommend plugins
	 *
	 * @link  https://github.com/thomasgriffin/TGM-Plugin-Activation/blob/master/example.php
	 *
	 * @since    1.0.0
	 * @version  1.4.0
	 */
	public static function recommend() {
		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = apply_filters( 'nanospace_tgmpa_plugins_recommend_plugins', array(

			/**
			 * WordPress Repository plugins
			 */
			'advanced-custom-fields' => array(
				'name'        => 'Advanced Custom Fields',
				'description' => esc_html__( 'For displaying extra metaboxes and controlling custom field data', 'nanospace' ),
				'slug'        => 'advanced-custom-fields',
				'required'    => false,
				'is_callable' => 'acf_add_local_field_group',
			),
		) );

		$config = apply_filters( 'nanospace_tgmpa_plugins_recommend_config', array() );

		tgmpa( $plugins, $config );

	} // /recommend
	/**
	 * 100) Helpers
	 */

	/**
	 * TGMPA plugins table: Columns
	 *
	 * @since    1.0.0
	 * @version  1.0.0
	 *
	 * @param  array $columns
	 */
	public static function table_columns( $columns = array() ) {
		$columns = array_merge(
			array_slice( $columns, 0, 2 ),
			array( 'description' => esc_html__( 'Description', 'nanospace' ) ),
			array_slice( $columns, 2 )
		);


		return $columns;

	} // /table_columns

	/**
	 * TGMPA plugins table: Plugin description
	 *
	 * @since    1.0.0
	 * @version  1.0.0
	 *
	 * @param  array $table_data
	 * @param  array $plugin
	 */
	public static function table_data( $table_data = array(), $plugin = array() ) {
		$table_data['description'] = ( isset( $plugin['description'] ) ) ? ( wp_kses_post( $plugin['description'] ) ) : ( '' );


		return $table_data;

	} // /table_data

	/**
	 * Display admin notice
	 *
	 * @since    1.0.0
	 * @version  1.0.0
	 */
	public static function notice() {


		$current_screen = get_current_screen();
// Requirements check

		if (
			! is_admin()
			|| ! isset( $current_screen->id )
			|| 'appearance_page_tgmpa-install-plugins' !== $current_screen->id
			|| isset( $_GET['plugin'] )
			|| ( isset( $_GET['plugin_status'] ) && 'all' !== $_GET['plugin_status'] )
		) {
			return;
		}


		?>

        <div class="notice-info notice is-dismissible" style="padding: 1em 2em;">
            <h2>
				<?php echo esc_html_x( 'Highly Recommended', 'Plugins.', 'nanospace' ); ?>
            </h2>
            <p>
				<?php esc_html_e( 'Please note that the "Advanced Custom Fields" WordPress plugin is highly recommended to be installed if you are using the NanoSpace theme. It displays extra meta boxes for better control over your layout and content.', 'nanospace' ); ?>
            </p>
        </div>

		<?php

	} // /notice
} // /NanoSpace_TGMPA_Plugins

add_action( 'after_setup_theme', 'NanoSpace_TGMPA_Plugins::init' );
