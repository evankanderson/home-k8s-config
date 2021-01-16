/**
 * Customizer custom controls scripts
 *
 * Customizer multiple checkboxes.
 *
 * @package     Labinator NanoSpace WordPress Theme Framework
 * @subpackage  Customize
 *
 * @since 1.0.0
 * @version 1.0.0
 * @version 1.0.0
 */

( function( wp, $ ) {

	'use strict';

	$( wp.customize ).on( 'ready', function() {
$( '.customize-control-multicheckbox' )
			.on( 'change', 'input[type="checkbox"]', function() {

				

					var
						$this   = $( this ),
						$values = $this
							.closest( '.customize-control' )
							.find( 'input[type="checkbox"]:checked' )
								.map( function() {

									

										return this.value;

								} )
								.get()
								.join( ',' );
$this
						.closest( '.customize-control' )
						.find( 'input[type="hidden"]' )
							.val( $values )
							.trigger( 'change' );

			} );
} );

} )( wp, jQuery );
