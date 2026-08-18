<?php
/**
 * Property details + gallery meta boxes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatein_add_property_meta_boxes() {
	add_meta_box(
		'estatein_property_details',
		__( 'Property Details', 'estatein' ),
		'estatein_render_property_details_meta_box',
		'property',
		'normal',
		'high'
	);

	add_meta_box(
		'estatein_property_gallery',
		__( 'Property Gallery', 'estatein' ),
		'estatein_render_property_gallery_meta_box',
		'property',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'estatein_add_property_meta_boxes' );

function estatein_render_property_details_meta_box( $post ) {
	wp_nonce_field( 'estatein_save_property_details', 'estatein_property_nonce' );

	$keys = array( 'price', 'price_suffix', 'bedrooms', 'bathrooms', 'area', 'area_unit', 'garage', 'year_built', 'address' );
	$v    = array();
	foreach ( $keys as $key ) {
		$v[ $key ] = get_post_meta( $post->ID, '_property_' . $key, true );
	}
	if ( '' === $v['area_unit'] ) {
		$v['area_unit'] = 'sqft';
	}
	$featured = get_post_meta( $post->ID, '_property_featured', true );
	?>
	<div class="estatein-meta-grid">
		<p>
			<label for="property_price"><?php esc_html_e( 'Price ($)', 'estatein' ); ?></label>
			<input type="number" step="0.01" id="property_price" name="property_price" value="<?php echo esc_attr( $v['price'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="property_price_suffix"><?php esc_html_e( 'Price Suffix', 'estatein' ); ?></label>
			<input type="text" id="property_price_suffix" name="property_price_suffix" value="<?php echo esc_attr( $v['price_suffix'] ); ?>" class="widefat" placeholder="/mo" />
		</p>
		<p>
			<label for="property_bedrooms"><?php esc_html_e( 'Bedrooms', 'estatein' ); ?></label>
			<input type="number" id="property_bedrooms" name="property_bedrooms" value="<?php echo esc_attr( $v['bedrooms'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="property_bathrooms"><?php esc_html_e( 'Bathrooms', 'estatein' ); ?></label>
			<input type="number" id="property_bathrooms" name="property_bathrooms" value="<?php echo esc_attr( $v['bathrooms'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="property_area"><?php esc_html_e( 'Area', 'estatein' ); ?></label>
			<input type="number" id="property_area" name="property_area" value="<?php echo esc_attr( $v['area'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="property_area_unit"><?php esc_html_e( 'Area Unit', 'estatein' ); ?></label>
			<select id="property_area_unit" name="property_area_unit" class="widefat">
				<option value="sqft" <?php selected( $v['area_unit'], 'sqft' ); ?>><?php esc_html_e( 'sq ft', 'estatein' ); ?></option>
				<option value="sqm" <?php selected( $v['area_unit'], 'sqm' ); ?>><?php esc_html_e( 'sq m', 'estatein' ); ?></option>
			</select>
		</p>
		<p>
			<label for="property_garage"><?php esc_html_e( 'Garage (cars)', 'estatein' ); ?></label>
			<input type="number" id="property_garage" name="property_garage" value="<?php echo esc_attr( $v['garage'] ); ?>" class="widefat" />
		</p>
		<p>
			<label for="property_year_built"><?php esc_html_e( 'Year Built', 'estatein' ); ?></label>
			<input type="number" id="property_year_built" name="property_year_built" value="<?php echo esc_attr( $v['year_built'] ); ?>" class="widefat" />
		</p>
		<p class="estatein-meta-full">
			<label for="property_address"><?php esc_html_e( 'Address', 'estatein' ); ?></label>
			<input type="text" id="property_address" name="property_address" value="<?php echo esc_attr( $v['address'] ); ?>" class="widefat" />
		</p>
		<p class="estatein-meta-full">
			<label>
				<input type="checkbox" name="property_featured" value="1" <?php checked( $featured, '1' ); ?> />
				<?php esc_html_e( 'Feature this property on the homepage', 'estatein' ); ?>
			</label>
		</p>
	</div>
	<?php
}

function estatein_render_property_gallery_meta_box( $post ) {
	$gallery = get_post_meta( $post->ID, '_property_gallery', true );
	$ids     = $gallery ? array_filter( array_map( 'trim', explode( ',', $gallery ) ) ) : array();
	?>
	<div id="estatein-gallery-wrap">
		<ul id="estatein-gallery-list" class="estatein-gallery-list">
			<?php
			foreach ( $ids as $id ) :
				$thumb = wp_get_attachment_image_src( $id, 'thumbnail' );
				if ( ! $thumb ) {
					continue;
				}
				?>
				<li data-id="<?php echo esc_attr( $id ); ?>">
					<img src="<?php echo esc_url( $thumb[0] ); ?>" alt="" />
					<button type="button" class="estatein-gallery-remove">&times;</button>
				</li>
			<?php endforeach; ?>
		</ul>
		<input type="hidden" id="property_gallery_ids" name="property_gallery" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>" />
		<button type="button" class="button" id="estatein-gallery-add"><?php esc_html_e( 'Add Images', 'estatein' ); ?></button>
		<p class="description"><?php esc_html_e( 'These images appear in the single property gallery, alongside the Featured Image.', 'estatein' ); ?></p>
	</div>
	<?php
}

function estatein_save_property_meta( $post_id ) {
	if ( ! isset( $_POST['estatein_property_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['estatein_property_nonce'] ), 'estatein_save_property_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$number_fields = array( 'price', 'bedrooms', 'bathrooms', 'area', 'garage', 'year_built' );
	foreach ( $number_fields as $field ) {
		$key = 'property_' . $field;
		if ( isset( $_POST[ $key ] ) && '' !== $_POST[ $key ] ) {
			update_post_meta( $post_id, '_property_' . $field, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		} else {
			delete_post_meta( $post_id, '_property_' . $field );
		}
	}

	$text_fields = array( 'price_suffix', 'address' );
	foreach ( $text_fields as $field ) {
		$key = 'property_' . $field;
		update_post_meta( $post_id, '_property_' . $field, isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '' );
	}

	if ( isset( $_POST['property_area_unit'] ) ) {
		$unit = sanitize_text_field( wp_unslash( $_POST['property_area_unit'] ) );
		update_post_meta( $post_id, '_property_area_unit', in_array( $unit, array( 'sqft', 'sqm' ), true ) ? $unit : 'sqft' );
	}

	update_post_meta( $post_id, '_property_featured', isset( $_POST['property_featured'] ) ? '1' : '0' );

	if ( isset( $_POST['property_gallery'] ) ) {
		$ids = array_filter( array_map( 'absint', explode( ',', wp_unslash( $_POST['property_gallery'] ) ) ) );
		update_post_meta( $post_id, '_property_gallery', implode( ',', $ids ) );
	}
}
add_action( 'save_post_property', 'estatein_save_property_meta' );
