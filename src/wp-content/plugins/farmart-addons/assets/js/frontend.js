(function ( $ ) {
	'use strict';

	var farmart = farmart || {};

	farmart.init = function () {
		farmart.$body = $( document.body ),
			farmart.$window = $( window ),
			farmart.$header = $( '#masthead' );
		
	};

	
	/**
	 * Document ready
	 */
	$( function () {
		farmart.init();
	} );

})( jQuery );