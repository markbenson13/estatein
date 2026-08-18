jQuery( function ( $ ) {
	'use strict';

	var frame;
	var $list = $( '#estatein-gallery-list' );
	var $input = $( '#property_gallery_ids' );

	function syncInput() {
		var ids = $list.find( 'li' ).map( function () {
			return $( this ).data( 'id' );
		} ).get();
		$input.val( ids.join( ',' ) );
	}

	$( '#estatein-gallery-add' ).on( 'click', function ( e ) {
		e.preventDefault();

		if ( frame ) {
			frame.open();
			return;
		}

		frame = wp.media( {
			title: 'Select Gallery Images',
			button: { text: 'Add to Gallery' },
			multiple: true,
		} );

		frame.on( 'select', function () {
			var selection = frame.state().get( 'selection' );
			selection.each( function ( attachment ) {
				attachment = attachment.toJSON();
				var thumb = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

				if ( $list.find( 'li[data-id="' + attachment.id + '"]' ).length ) {
					return;
				}

				var $item = $( '<li></li>' ).attr( 'data-id', attachment.id );
				$item.append( $( '<img>' ).attr( 'src', thumb ) );
				$item.append( $( '<button type="button" class="estatein-gallery-remove">&times;</button>' ) );
				$list.append( $item );
			} );
			syncInput();
		} );

		frame.open();
	} );

	$list.on( 'click', '.estatein-gallery-remove', function () {
		$( this ).closest( 'li' ).remove();
		syncInput();
	} );
} );
