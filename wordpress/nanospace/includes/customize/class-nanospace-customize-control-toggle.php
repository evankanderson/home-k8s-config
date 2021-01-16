<?php
/**
 * Customizer custom control: Toggle
 *
 * @package nanospace
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'NanoSpace_Customize_Control_Toggle' ) ) :
	/**
	 * Toggle control class
	 */
	class NanoSpace_Customize_Control_Toggle extends NanoSpace_Customize_Control {
		/**
		 * @var string
		 */
		public $type = 'nanospace-toggle';

		/**
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			parent::to_json();

			$this->json['name']  = $this->id;
			$this->json['value'] = $this->value();

			$this->json['__link'] = $this->get_link();
		}

		/**
		 * Render Underscore JS template for this control's content.
		 */
		protected function content_template() {
			?>
            <# if ( data.label ) { #>
            <span class="customize-control-title">{{{ data.label }}}</span>
            <# } #>
            <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>
            <div class="customize-control-content">
                <label>
                    <input type="checkbox" value="1" {{{ data.__link }}}>
                    <span class="nanospace-toggle-ui">
					<span class="nanospace-toggle-ui-handle"></span>
				</span>
                </label>
            </div>
			<?php
		}
	}

// Register control type.
	$wp_customize->register_control_type( 'NanoSpace_Customize_Control_Toggle' );
endif;