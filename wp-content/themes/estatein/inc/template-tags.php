<?php
/**
 * Reusable template helpers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Minimal inline SVG glyph for a social network, used by the footer icon buttons.
 */
function estatein_social_icon_svg( $network ) {
	$icons = array(
		'facebook'  => '<path d="M22 12a10 10 0 1 0-11.5 9.87v-6.98H7.9V12h2.6V9.8c0-2.57 1.53-4 3.87-4 1.12 0 2.29.2 2.29.2v2.5h-1.29c-1.27 0-1.67.79-1.67 1.6V12h2.85l-.46 2.89h-2.39v6.98A10 10 0 0 0 22 12"/>',
		'linkedin'  => '<path d="M6.94 5a2 2 0 1 1-4-.002 2 2 0 0 1 4 .002M7 8.48H3V21h4zm6.32 0H9.34V21h3.94v-6.57c0-3.66 4.77-4 4.77 0V21H22v-7.93c0-6.17-7.06-5.94-8.68-2.91z"/>',
		'twitter'   => '<path d="M18.9 2H22l-7.2 8.2L23 22h-6.6l-5.2-6.8L5 22H2l7.7-8.8L1.5 2h6.8l4.7 6.2zm-1.2 18h1.8L7.4 4H5.5z"/>',
		'youtube'   => '<path d="M23 12s0-3.6-.46-5.3a3 3 0 0 0-2.1-2.1C18.7 4.1 12 4.1 12 4.1s-6.7 0-8.44.5a3 3 0 0 0-2.1 2.1C1 8.4 1 12 1 12s0 3.6.46 5.3a3 3 0 0 0 2.1 2.1c1.74.5 8.44.5 8.44.5s6.7 0 8.44-.5a3 3 0 0 0 2.1-2.1C23 15.6 23 12 23 12M9.75 15.5v-7l6 3.5z"/>',
		'instagram' => '<path d="M12 2c2.72 0 3.06.01 4.12.06 1.06.05 1.79.22 2.43.47.66.26 1.21.6 1.76 1.15.5.5.9 1.1 1.15 1.76.25.64.42 1.37.47 2.43.05 1.06.06 1.4.06 4.12s-.01 3.06-.06 4.12c-.05 1.06-.22 1.79-.47 2.43a4.9 4.9 0 0 1-1.15 1.76 4.9 4.9 0 0 1-1.76 1.15c-.64.25-1.37.42-2.43.47-1.06.05-1.4.06-4.12.06s-3.06-.01-4.12-.06c-1.06-.05-1.79-.22-2.43-.47a4.9 4.9 0 0 1-1.76-1.15 4.9 4.9 0 0 1-1.15-1.76c-.25-.64-.42-1.37-.47-2.43C2.01 15.06 2 14.72 2 12s.01-3.06.06-4.12c.05-1.06.22-1.79.47-2.43.26-.66.6-1.21 1.15-1.76A4.9 4.9 0 0 1 5.45.54C6.09.29 6.82.12 7.88.07 8.94.02 9.28.01 12 .01M12 4.87a7.13 7.13 0 1 0 0 14.26 7.13 7.13 0 0 0 0-14.26m0 2a5.13 5.13 0 1 1 0 10.26A5.13 5.13 0 0 1 12 6.87m7.4-2.3a1.2 1.2 0 1 1-2.4 0 1.2 1.2 0 0 1 2.4 0"/>',
	);

	return isset( $icons[ $network ] ) ? $icons[ $network ] : '';
}

/**
 * Format a stored price + optional suffix (e.g. "/mo") for display.
 */
function estatein_format_price( $price, $suffix = '' ) {
	if ( '' === $price || null === $price ) {
		return __( 'Price on request', 'estatein' );
	}
	$formatted = '$' . number_format( (float) $price );
	if ( $suffix ) {
		$formatted .= ' ' . $suffix;
	}
	return $formatted;
}

/**
 * Collect all property meta for a post into one array.
 */
function estatein_property_meta( $post_id ) {
	return array(
		'price'        => get_post_meta( $post_id, '_property_price', true ),
		'price_suffix' => get_post_meta( $post_id, '_property_price_suffix', true ),
		'bedrooms'     => get_post_meta( $post_id, '_property_bedrooms', true ),
		'bathrooms'    => get_post_meta( $post_id, '_property_bathrooms', true ),
		'area'         => get_post_meta( $post_id, '_property_area', true ),
		'area_unit'    => get_post_meta( $post_id, '_property_area_unit', true ) ? get_post_meta( $post_id, '_property_area_unit', true ) : 'sqft',
		'garage'       => get_post_meta( $post_id, '_property_garage', true ),
		'year_built'   => get_post_meta( $post_id, '_property_year_built', true ),
		'address'      => get_post_meta( $post_id, '_property_address', true ),
		'featured'     => '1' === get_post_meta( $post_id, '_property_featured', true ),
		'gallery'      => array_filter( explode( ',', (string) get_post_meta( $post_id, '_property_gallery', true ) ) ),
	);
}

/**
 * Human readable area unit label.
 */
function estatein_area_unit_label( $unit ) {
	return 'sqm' === $unit ? __( 'sq m', 'estatein' ) : __( 'sq ft', 'estatein' );
}

/**
 * First property_status term for a listing, or null.
 */
function estatein_get_status_term( $post_id ) {
	$terms = get_the_terms( $post_id, 'property_status' );
	return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
}

/**
 * Themed pagination for archives.
 */
function estatein_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => __( '&larr; Prev', 'estatein' ),
			'next_text' => __( 'Next &rarr;', 'estatein' ),
		)
	);
}

/**
 * Render the shared taxonomy/price/bedroom filter form used on the
 * property archive and taxonomy pages.
 */
function estatein_render_property_filters() {
	$archive_url = get_post_type_archive_link( 'property' );
	?>
	<form class="filter-panel card p-4" method="get" action="<?php echo esc_url( $archive_url ); ?>">
		<h3 class="h5 mb-4"><?php esc_html_e( 'Filter Properties', 'estatein' ); ?></h3>

		<div class="mb-3">
			<label for="filter-keyword" class="form-label small"><?php esc_html_e( 'Keyword', 'estatein' ); ?></label>
			<input type="text" id="filter-keyword" name="keyword" class="form-control" value="<?php echo isset( $_GET['keyword'] ) ? esc_attr( wp_unslash( $_GET['keyword'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'e.g. downtown loft', 'estatein' ); ?>" />
		</div>

		<div class="mb-3">
			<label for="filter-type" class="form-label small"><?php esc_html_e( 'Property Type', 'estatein' ); ?></label>
			<?php estatein_taxonomy_dropdown( 'property_type', 'property_type', 'filter-type', __( 'Any Type', 'estatein' ) ); ?>
		</div>

		<div class="mb-3">
			<label for="filter-status" class="form-label small"><?php esc_html_e( 'Status', 'estatein' ); ?></label>
			<?php estatein_taxonomy_dropdown( 'property_status', 'property_status', 'filter-status', __( 'Any Status', 'estatein' ) ); ?>
		</div>

		<div class="mb-3">
			<label for="filter-location" class="form-label small"><?php esc_html_e( 'Location', 'estatein' ); ?></label>
			<?php estatein_taxonomy_dropdown( 'property_location', 'property_location', 'filter-location', __( 'Any Location', 'estatein' ) ); ?>
		</div>

		<div class="mb-3">
			<label class="form-label small"><?php esc_html_e( 'Price Range', 'estatein' ); ?></label>
			<div class="row g-2">
				<div class="col-6">
					<input type="number" name="min_price" class="form-control" placeholder="<?php esc_attr_e( 'Min', 'estatein' ); ?>" value="<?php echo isset( $_GET['min_price'] ) ? esc_attr( absint( $_GET['min_price'] ) ) : ''; ?>" />
				</div>
				<div class="col-6">
					<input type="number" name="max_price" class="form-control" placeholder="<?php esc_attr_e( 'Max', 'estatein' ); ?>" value="<?php echo isset( $_GET['max_price'] ) ? esc_attr( absint( $_GET['max_price'] ) ) : ''; ?>" />
				</div>
			</div>
		</div>

		<div class="mb-4">
			<label for="filter-bedrooms" class="form-label small"><?php esc_html_e( 'Minimum Bedrooms', 'estatein' ); ?></label>
			<select id="filter-bedrooms" name="bedrooms" class="form-select">
				<option value=""><?php esc_html_e( 'Any', 'estatein' ); ?></option>
				<?php
				$selected_bedrooms = isset( $_GET['bedrooms'] ) ? absint( $_GET['bedrooms'] ) : 0;
				for ( $i = 1; $i <= 5; $i++ ) :
					?>
					<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $selected_bedrooms, $i ); ?>><?php echo esc_html( $i ); ?>+</option>
				<?php endfor; ?>
			</select>
		</div>

		<button type="submit" class="btn btn-primary w-100"><?php esc_html_e( 'Apply Filters', 'estatein' ); ?></button>
		<?php if ( $archive_url ) : ?>
			<a href="<?php echo esc_url( $archive_url ); ?>" class="btn btn-outline-light w-100 mt-2"><?php esc_html_e( 'Reset', 'estatein' ); ?></a>
		<?php endif; ?>
	</form>
	<?php
}

/**
 * Counter + prev/next controls for an .es-slider section (see assets/js/main.js).
 */
function estatein_slider_nav( $total ) {
	?>
	<div class="es-slider-nav">
		<span class="es-slider-counter">
			<span data-es-slider-current>01</span>
			<span class="es-slider-counter-sep"><?php esc_html_e( 'of', 'estatein' ); ?></span>
			<span data-es-slider-total><?php echo esc_html( sprintf( '%02d', $total ) ); ?></span>
		</span>
		<div class="es-slider-arrows">
			<button type="button" class="es-slider-arrow" data-es-slider-prev aria-label="<?php esc_attr_e( 'Previous', 'estatein' ); ?>">
				<img class="slider-icon" src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/slider-arrow.png' ); ?>" alt="" />
			</button>
			<button type="button" class="es-slider-arrow" data-es-slider-next aria-label="<?php esc_attr_e( 'Next', 'estatein' ); ?>">
				<img class="slider-active-icon" src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/slider-active-icon.png' ); ?>" alt="" />
			</button>
		</div>
	</div>
	<?php
}

/**
 * Simple <select> for a taxonomy, preserving the currently selected term from $_GET.
 */
function estatein_taxonomy_dropdown( $taxonomy, $name, $id, $placeholder ) {
	$terms   = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => false ) );
	$current = isset( $_GET[ $name ] ) ? sanitize_title( wp_unslash( $_GET[ $name ] ) ) : '';

	$queried_object = get_queried_object();
	if ( $queried_object instanceof WP_Term && $taxonomy === $queried_object->taxonomy ) {
		$current = $queried_object->slug;
	}

	echo '<select id="' . esc_attr( $id ) . '" name="' . esc_attr( $name ) . '" class="form-select">';
	echo '<option value="">' . esc_html( $placeholder ) . '</option>';
	if ( ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s</option>',
				esc_attr( $term->slug ),
				selected( $current, $term->slug, false ),
				esc_html( $term->name )
			);
		}
	}
	echo '</select>';
}
