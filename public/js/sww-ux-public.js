(function( $ ) {
	'use strict';

	$( document ).ready( function() {

		$( ".postbox" ).each( function() {
			var displaytask = $(this).find( '.displaytask' );
			if( !displaytask.text().trim().length ) {
				displaytask.text( tasklist[$(this).data( 'iterator' )] );
			}
		});

		$('.cmb-add-group-row').mouseup(function() {
			setTimeout(function() {
				var boxes = $( ".cmb-field-list").find(".postbox");
				boxes.each( function() {
					$(this).find( '.displaytask' ).text( tasklist[$(this).data( 'iterator' )] );
				});
			}, 10);
		});

	});

	

})( jQuery );
