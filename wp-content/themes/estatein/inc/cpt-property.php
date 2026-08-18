<?php
/**
 * Property custom post type + taxonomies.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatein_register_property_cpt() {
	register_post_type(
		'property',
		array(
			'labels'             => array(
				'name'               => __( 'Properties', 'estatein' ),
				'singular_name'      => __( 'Property', 'estatein' ),
				'add_new_item'       => __( 'Add New Property', 'estatein' ),
				'edit_item'          => __( 'Edit Property', 'estatein' ),
				'new_item'           => __( 'New Property', 'estatein' ),
				'view_item'          => __( 'View Property', 'estatein' ),
				'view_items'         => __( 'View Properties', 'estatein' ),
				'search_items'       => __( 'Search Properties', 'estatein' ),
				'not_found'          => __( 'No properties found', 'estatein' ),
				'not_found_in_trash' => __( 'No properties found in Trash', 'estatein' ),
				'all_items'          => __( 'All Properties', 'estatein' ),
				'menu_name'          => __( 'Properties', 'estatein' ),
			),
			'public'             => true,
			'has_archive'        => true,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-admin-multisite',
			'rewrite'            => array( 'slug' => 'properties', 'with_front' => false ),
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'menu_position'      => 5,
		)
	);

	register_taxonomy(
		'property_type',
		'property',
		array(
			'labels'            => array(
				'name'          => __( 'Property Types', 'estatein' ),
				'singular_name' => __( 'Property Type', 'estatein' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'property-type' ),
		)
	);

	register_taxonomy(
		'property_status',
		'property',
		array(
			'labels'            => array(
				'name'          => __( 'Property Status', 'estatein' ),
				'singular_name' => __( 'Status', 'estatein' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'property-status' ),
		)
	);

	register_taxonomy(
		'property_location',
		'property',
		array(
			'labels'            => array(
				'name'          => __( 'Locations', 'estatein' ),
				'singular_name' => __( 'Location', 'estatein' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'property-location' ),
		)
	);
}
add_action( 'init', 'estatein_register_property_cpt' );

/**
 * Flush rewrite rules once on theme activation so /properties/ works immediately.
 */
function estatein_flush_rewrites() {
	estatein_register_property_cpt();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'estatein_flush_rewrites' );

/**
 * Seed a few sensible default terms the first time the theme is activated,
 * so the filter sidebar isn't empty on a fresh install.
 */
function estatein_seed_default_terms() {
	if ( get_option( 'estatein_terms_seeded' ) ) {
		return;
	}

	$defaults = array(
		'property_type'   => array( 'House', 'Apartment', 'Villa', 'Condo', 'Commercial' ),
		'property_status' => array( 'For Sale', 'For Rent' ),
	);

	foreach ( $defaults as $taxonomy => $terms ) {
		foreach ( $terms as $term ) {
			if ( ! term_exists( $term, $taxonomy ) ) {
				wp_insert_term( $term, $taxonomy );
			}
		}
	}

	update_option( 'estatein_terms_seeded', 1 );
}
add_action( 'after_switch_theme', 'estatein_seed_default_terms' );

/**
 * Filter the main query on the property archive and taxonomy pages based on
 * the filter sidebar's GET parameters (type, status, location, price, bedrooms, keyword).
 */
function estatein_property_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	$is_property_context = is_post_type_archive( 'property' ) || is_tax( array( 'property_type', 'property_status', 'property_location' ) );
	if ( ! $is_property_context ) {
		return;
	}

	$meta_query = array();

	if ( ! empty( $_GET['min_price'] ) || ! empty( $_GET['max_price'] ) ) {
		$price_query = array(
			'key'  => '_property_price',
			'type' => 'NUMERIC',
		);

		if ( ! empty( $_GET['min_price'] ) && ! empty( $_GET['max_price'] ) ) {
			$price_query['value']   = array( absint( $_GET['min_price'] ), absint( $_GET['max_price'] ) );
			$price_query['compare'] = 'BETWEEN';
		} elseif ( ! empty( $_GET['min_price'] ) ) {
			$price_query['value']   = absint( $_GET['min_price'] );
			$price_query['compare'] = '>=';
		} else {
			$price_query['value']   = absint( $_GET['max_price'] );
			$price_query['compare'] = '<=';
		}

		$meta_query[] = $price_query;
	}

	if ( ! empty( $_GET['bedrooms'] ) ) {
		$meta_query[] = array(
			'key'     => '_property_bedrooms',
			'value'   => absint( $_GET['bedrooms'] ),
			'compare' => '>=',
			'type'    => 'NUMERIC',
		);
	}

	if ( $meta_query ) {
		$query->set( 'meta_query', $meta_query );
	}

	$tax_query = array();
	foreach ( array( 'property_type', 'property_status', 'property_location' ) as $taxonomy ) {
		if ( ! empty( $_GET[ $taxonomy ] ) ) {
			$tax_query[] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => sanitize_title( wp_unslash( $_GET[ $taxonomy ] ) ),
			);
		}
	}
	if ( $tax_query ) {
		$query->set( 'tax_query', $tax_query );
	}

	if ( ! empty( $_GET['keyword'] ) ) {
		$query->set( 's', sanitize_text_field( wp_unslash( $_GET['keyword'] ) ) );
	}

	$query->set( 'posts_per_page', 9 );
}
add_action( 'pre_get_posts', 'estatein_property_archive_query' );
