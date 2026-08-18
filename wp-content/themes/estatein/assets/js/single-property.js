( function () {
	'use strict';

	var mainImg = document.getElementById( 'property-gallery-main-img' );
	var modalImg = document.getElementById( 'property-gallery-modal-img' );
	var thumbs = document.querySelectorAll( '.property-gallery-thumb' );

	if ( thumbs.length ) {
		thumbs.forEach( function ( thumb ) {
			thumb.addEventListener( 'click', function () {
				thumbs.forEach( function ( t ) {
					t.classList.remove( 'active' );
				} );
				thumb.classList.add( 'active' );
				if ( mainImg ) {
					mainImg.src = thumb.getAttribute( 'data-src' );
				}
			} );
		} );
	}

	var galleryModal = document.getElementById( 'propertyGalleryModal' );
	if ( galleryModal && modalImg && mainImg ) {
		galleryModal.addEventListener( 'show.bs.modal', function () {
			modalImg.src = mainImg.src;
		} );
	}
} )();
