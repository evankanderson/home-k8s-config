<?php
/**
 * Nanospace Pro Customizer Section
 *
 * @package   Nanospace
 * @copyright Labinator
 * @since     Nanospace 1.0.1
 */

// No direct access, please.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nanospace_Pro_Customizer
 *
 * @since 1.0.1
 */
if ( ! class_exists( 'NanoSpace_Pro_Customizer' ) ) {

	/**
	 * Nanospace_Pro_Customizer Initial setup
	 */
	class NanoSpace_Pro_Customizer extends WP_Customize_Section {

		/**
		 * The type of customize section being rendered.
		 *
		 * @since  1.0.1
		 * @access public
		 * @var    string
		 */
		public $type = 'nanospace-pro';

		/**
		 * The type of customize section title.
		 *
		 * @since  1.0.1
		 * @access public
		 * @var    string
		 */
		public $title = 'Go Pro With NanoSpace Booster';

		/**
		 * Custom pro button priority.
		 *
		 * @since  1.0.1
		 * @access public
		 * @var    integer
		 */
		public $priority = 0;

		/**
		 * Custom pro button URL.
		 *
		 * @since  1.0.1
		 * @access public
		 * @var    string
		 */
		public $pro_url = 'https://labinator.com/wordpress-marketplace/themes/nanospace/';

		public function __construct( $wp_customize, $id ) {
			parent::__construct( $wp_customize, $id );
		}

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 *
		 * @since  1.0.1
		 * @access public
		 * @return string
		 */
		public function json() {
			$json            = parent::json();
			$json['pro_url'] = esc_url_raw( $this->pro_url );

			return $json;
		}

		/**
		 * Outputs the Underscore.js template.
		 *
		 * @since  1.0.1
		 * @access public
		 * @return void
		 */
		protected function render_template() {
			$pluginList = get_option( 'active_plugins' );
			$plugin     = 'labinator-nanospace-booster/nanospace-theme-booster.php';

			if ( ! in_array( $plugin, $pluginList ) ) {
				?>
				<li id="accordion-section-{{ data.id }}"
					class="accordion-section control-section control-section-{{ data.type }} cannot-expand control-section-default">
					<h3 class="wp-ui-highlight" style="background-color: #EEEEEE; text-align: center;">
						<a href="{{ data.pro_url }}" class="wp-ui-text-highlight" rel="noopener"
						   style="padding: 10px; border: 1px solid #c5c9cf; background-color: #AA0000; color:#ffffff; text-decoration: none">{{
							data.title }}</a>
					</h3>
				</li>
			<?php }
		}
	}

}
