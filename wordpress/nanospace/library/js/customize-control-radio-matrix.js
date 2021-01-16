/**
 * Customizer custom controls scripts
 *
 * Customizer matrix radio fields.
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
$( '.custom-radio-container' )
			.on( 'change', 'input', function() {
$( this )
						.parent()
							.addClass( 'is-active' )
							.siblings()
							.removeClass( 'is-active' );

			} );
} );

} )( wp, jQuery );
