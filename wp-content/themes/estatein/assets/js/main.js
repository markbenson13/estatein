( function () {
	'use strict';

	var announcement = document.getElementById( 'announcement-bar' );
	var announcementClose = document.getElementById( 'announcement-close' );

	if ( announcement && announcementClose ) {
		try {
			if ( sessionStorage.getItem( 'estateinAnnouncementDismissed' ) ) {
				announcement.classList.add( 'is-dismissed' );
			}
		} catch ( e ) {}

		announcementClose.addEventListener( 'click', function () {
			announcement.classList.add( 'is-dismissed' );
			try {
				sessionStorage.setItem( 'estateinAnnouncementDismissed', '1' );
			} catch ( e ) {}
		} );
	}

	var sliders = document.querySelectorAll( '[data-es-slider]' );

	sliders.forEach( function ( slider ) {
		var track = slider.querySelector( '[data-es-slider-track]' );
		var prevBtn = slider.querySelector( '[data-es-slider-prev]' );
		var nextBtn = slider.querySelector( '[data-es-slider-next]' );
		var currentEl = slider.querySelector( '[data-es-slider-current]' );
		var slides = track ? Array.prototype.slice.call( track.children ) : [];

		if ( ! track || ! slides.length || ! prevBtn || ! nextBtn ) {
			return;
		}

		function currentIndex() {
			var scrollLeft = track.scrollLeft;
			var closest = 0;
			var closestDistance = Infinity;

			slides.forEach( function ( slide, index ) {
				var distance = Math.abs( slide.offsetLeft - scrollLeft );
				if ( distance < closestDistance ) {
					closestDistance = distance;
					closest = index;
				}
			} );

			return closest;
		}

		function updateNav() {
			if ( currentEl ) {
				currentEl.textContent = String( currentIndex() + 1 ).padStart( 2, '0' );
			}

			prevBtn.disabled = track.scrollLeft <= 0;
			nextBtn.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
		}

		function goToSlide( index ) {
			index = Math.max( 0, Math.min( index, slides.length - 1 ) );
			track.scrollTo( { left: slides[ index ].offsetLeft, behavior: 'smooth' } );
		}

		prevBtn.addEventListener( 'click', function () {
			goToSlide( currentIndex() - 1 );
		} );

		nextBtn.addEventListener( 'click', function () {
			goToSlide( currentIndex() + 1 );
		} );

		var scrollTimer = null;
		track.addEventListener( 'scroll', function () {
			if ( scrollTimer ) {
				window.clearTimeout( scrollTimer );
			}
			scrollTimer = window.setTimeout( updateNav, 80 );
		} );

		window.addEventListener( 'resize', updateNav );

		updateNav();
	} );
} )();
