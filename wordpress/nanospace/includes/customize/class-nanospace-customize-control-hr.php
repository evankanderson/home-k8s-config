<?php
/**
 * Customizer custom control: Horizontal Line
 *
 * @package nanospace
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'NanoSpace_Customize_Control_HR' ) ) :
	/**
	 * Horizontal line control class
	 */
	class NanoSpace_Customize_Control_HR extends NanoSpace_Customize_Control {
		/**
		 * @var string
		 */
		public $type = 'nanospace-hr';

		/**
		 * Render control's content
		 */
		protected function render_content() {
			?>
			<hr>
			<?php
		}
	}
endif;