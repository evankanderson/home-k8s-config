<?php
/**
 * Customizer custom control: Slider
 *
 * @package nanospace
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'NanoSpace_Customize_Control_Slider' ) ) :
	/**
	 * Slider control class
	 */
	class NanoSpace_Customize_Control_Slider extends NanoSpace_Customize_Control {
		/**
		 * @var string
		 */
		public $type = 'nanospace-slider';

		/**
		 * Available choices: px, em, %.
		 *
		 * @var array
		 */
		public $units = array( '' );

		/**
		 * @var boolean
		 */
		public $hide_units = false;

		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			// Make sure there is at least 1 unit type.
			if ( empty( $this->units ) ) {
				$this->units = array( '' );
			}

			// Sanitize unit attributes.
			foreach ( $this->units as $key => $unit ) {
				$this->units[ $key ] = wp_parse_args( $unit, array(
					'min'   => '',
					'max'   => '',
					'step'  => '',
					'label' => $key,
				) );
			}
		}

		/**
		 * Setup parameters for content rendering by Underscore JS template.
		 */
		public function to_json() {
			parent::to_json();

			$this->json['name']  = $this->id;
			$this->json['units'] = $this->units;

			$this->json['inputs']     = array();
			$this->json['structures'] = array();

			foreach ( $this->settings as $setting_key => $setting ) {
				$value = $this->value( $setting_key );
				if ( false === $value ) {
					$value = '';
				}

				// Convert raw value string into number and unit.
				$number = '' === $value ? '' : floatval( $value );
				$unit   = str_replace( $number, '', $value );
				if ( ! array_key_exists( $unit, $this->units ) ) {
					$units = array_keys( $this->units );
					$unit  = reset( $units );
				}

				// Add to inputs array.
				$this->json['inputs'][ $setting_key ] = array(
					'__link' => $this->get_link( $setting_key ),
					'value'  => $value,
					'number' => $number,
					'unit'   => $unit,
				);

				// Add reset value.
				if ( isset( $setting->default ) ) {
					$reset_number = '' === $value ? '' : floatval( $setting->default );
					$reset_unit   = str_replace( $reset_number, '', $setting->default );

					$this->json['inputs'][ $setting_key ]['reset_number'] = $reset_number;
					$this->json['inputs'][ $setting_key ]['reset_unit']   = $reset_unit;
				}

				// Add to structures array.
				$device = 'desktop';
				if ( false !== strpos( $setting->id, '__' ) ) {
					$chunks = explode( '__', $setting->id );
					if ( in_array( $chunks[1], array( 'desktop', 'tablet', 'mobile' ) ) ) {
						$device = $chunks[1];
					}
				}
				$this->json['structures'][ $device ] = $setting_key;
			}

			$this->json['responsive'] = 1 < count( $this->json['structures'] ) ? true : false;

			$this->json['hide_units'] = 1 == $this->hide_units ? true : false;
		}

		/**
		 * Enqueue additional control's CSS or JS scripts.
		 */
		public function enqueue() {
			wp_enqueue_style( 'jquery-ui-slider' );
		}

		/**
		 * Render Underscore JS template for this control's content.
		 */
		protected function content_template() {
			?>
            <# if ( data.label ) { #>
            <span class="customize-control-title {{ data.responsive ? 'nanospace-responsive-title' : '' }}">
				{{{ data.label }}}
				<# if ( data.responsive ) { #>
					<span class="nanospace-responsive-switcher">
						<# _.each( data.structures, function( setting_key, device ) { #>
							<span class="nanospace-responsive-switcher-button preview-{{ device }}"
                                  data-device="{{ device }}"><span
                                        class="dashicons dashicons-{{ 'mobile' === device ? 'smartphone' : device }}"></span></span>
						<# }); #>
					</span>
				<# } #>
			</span>
            <# } #>
            <# if ( data.description ) { #>
            <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>
            <div class="customize-control-content">
                <# _.each( data.structures, function( setting_key, device ) { #>
                <div class="nanospace-slider-fieldset nanospace-row {{ data.responsive ? 'nanospace-responsive-fieldset' : '' }} {{ 'desktop' == device ? 'active' : '' }} {{ 'preview-' + device }}">
                    <div class="nanospace-row-item" style="width: 100%;">
                        <div class="nanospace-slider-ui"></div>
                    </div>
                    <div class="nanospace-row-item" style="width: 50px;">
                        <input class="nanospace-slider-input" type="number"
                               value="{{ data.inputs[ setting_key ].number }}"
                               min="{{ data.units[ data.inputs[ setting_key ].unit ].min }}"
                               max="{{ data.units[ data.inputs[ setting_key ].unit ].max }}"
                               step="{{ data.units[ data.inputs[ setting_key ].unit ].step }}">
                    </div>
                    <div class="nanospace-row-item" style="width: 30px; {{ data.hide_units ? 'display: none;' : '' }}">
                        <select class="nanospace-slider-unit nanospace-unit">
                            <# _.each( data.units, function( unit_data, unit ) { #>
                            <option value="{{ unit }}" {{ unit== data.inputs[ setting_key ].unit ?
                            'selected' : '' }} data-min="{{ unit_data.min }}" data-max="{{ unit_data.max }}"
                            data-step="{{ unit_data.step }}">{{{ unit_data.label }}}</option>
                            <# }); #>
                        </select>
                    </div>
                    <div class="nanospace-row-item" style="width: 20px;">
                        <span class="nanospace-slider-reset dashicons dashicons-image-rotate"
                              data-number="{{ data.inputs[ setting_key ].reset_number }}"
                              data-unit="{{ data.inputs[ setting_key ].reset_unit }}" tabindex="0"></span>
                    </div>

                    <input type="hidden" class="nanospace-slider-value" value="{{ data.inputs[ setting_key ].value }}"
                           {{{ data.inputs[ setting_key ].__link }}}>
                </div>
                <# }); #>
            </div>
			<?php
		}
	}

// Register control type.
	$wp_customize->register_control_type( 'NanoSpace_Customize_Control_Slider' );
endif;