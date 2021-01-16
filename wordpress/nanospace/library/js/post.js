/**
 * Post edit scripts
 *
 * @see  wp-admin/js/post.js
 *
 * @package     Labinator NanoSpace WordPress Theme Framework
 * @subpackage  Visual Editor
 *
 * @since 1.0.0
 * @version 1.0.0
 * @version 1.0.0
 */

jQuery( document ).ready( function( $ ) {

	'use strict';
/**
	 * Adding page template class on TinyMCE editor HTML body
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	if ( typeof tinymce !== 'undefined' ) {

		$( '#page_template' )
			.on( 'change.set-editor-class', function() {

				

					var
						editor,
						body,
						pageTemplate = $( this ).val() || '';

					pageTemplate = pageTemplate.substr( pageTemplate.lastIndexOf( '/' ) + 1, pageTemplate.length )
					               .replace( /\.php$/, '' )
					               .replace( /\./g, '-' );
if ( pageTemplate && ( editor = tinymce.get( 'content' ) ) ) {
						body = editor.getBody();
						body.className = body.className.replace( /\bpage-template-[^ ]+/, '' );
						editor.dom.addClass( body, 'page-template-' + pageTemplate );
						$( document ).trigger( 'editor-classchange' );
					}

			} );

	}
} );
