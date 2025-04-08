jQuery( document ).ready( function ( $ ) {
	"use strict";

	/*---------
	 Thumbnail
	 ---------*/
// Only show the "remove image" button when needed
	if ( !$( '#product_collection_thumb_id' ).val() ) {
		$( '.remove_image_button' ).hide();
	}

// Uploading files
	var file_frame;

	$( '#product-collection-thumb-box' ).on( 'click', '.upload_image_button', function ( event ) {

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		// Create the media frame.
		file_frame = wp.media.frames.downloadable_file = wp.media( {
			multiple: false
		} );

		// When an image is selected, run a callback.
		file_frame.on( 'select', function () {
			var attachment = file_frame.state().get( 'selection' ).first().toJSON();
			var url = '';
			$( '#product_collection_thumb_id' ).val( attachment.id );
			var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
			$( '#product_collection_thumb' ).find( 'img' ).attr( 'src', attachment_image );
			$( '.remove_image_button' ).show();
		} );

		// Finally, open the modal.
		file_frame.open();
	} );

	$( '#product-collection-thumb-box' ).on( 'click', '.remove_image_button', function () {
		var image_src = $( '#product_collection_thumb' ).data( 'rel' );
		$( '#product_collection_thumb' ).find( 'img' ).attr( 'src', image_src );
		$( '#product_collection_thumb_id' ).val( '' );
		$( '.remove_image_button' ).hide();
		return false;
	} );

	// // Image ordering.
	// $collection_images.sortable( {
	// 	items               : 'li.image',
	// 	cursor              : 'move',
	// 	scrollSensitivity   : 40,
	// 	forcePlaceholderSize: true,
	// 	forceHelperSize     : false,
	// 	helper              : 'clone',
	// 	opacity             : 0.65,
	// 	placeholder         : 'wc-metabox-sortable-placeholder',
	// 	start               : function ( event, ui ) {
	// 		ui.item.css( 'background-color', '#f6f6f6' );
	// 	},
	// 	stop                : function ( event, ui ) {
	// 		ui.item.removeAttr( 'style' );
	// 	},
	// 	update              : function () {
	// 		var attachment_ids = '';

	// 		$collection_images.find( 'li.image' ).css( 'cursor', 'default' ).each( function () {
	// 			var attachment_id = $( this ).attr( 'data-attachment_id' );
	// 			attachment_ids = attachment_ids + attachment_id + ',';
	// 		} );
	// 	}
	// } );

	/*------------
	 Ajax Complete
	 ------------*/

	$( document ).ajaxComplete( function ( event, request, options ) {
		if ( request && 4 === request.readyState && 200 === request.status
			&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

			var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
			if ( !res || res.errors ) {
				return;
			}
			// Clear Thumbnail fields on submit
			$( '#product_collection_thumb' ).find( 'img' ).attr( 'src', $( '#product_collection_thumb' ).data( 'rel' ) );
			$( '#product_collection_thumb_id' ).val( '' );
			$( '.remove_image_button' ).hide();

			return;
		}
	} );

} );