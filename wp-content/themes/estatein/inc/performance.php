<?php
/**
 * Front-end performance tweaks that don't belong in functions.php's asset
 * enqueue block: resource hints and image-loading priority.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Preconnect to the Google Fonts origins so the connection (DNS + TLS) is
 * already warm by the time the @font-face request fires, instead of paying
 * that latency after the stylesheet response arrives.
 */
function estatein_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$hints[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'estatein_resource_hints', 10, 2 );
