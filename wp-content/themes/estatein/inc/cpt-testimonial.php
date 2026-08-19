<?php
/**
 * Testimonial custom post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatein_register_testimonial_cpt() {
	register_post_type(
		'testimonial',
		array(
			'labels'        => array(
				'name'               => __( 'Testimonials', 'estatein' ),
				'singular_name'      => __( 'Testimonial', 'estatein' ),
				'add_new_item'       => __( 'Add New Testimonial', 'estatein' ),
				'edit_item'          => __( 'Edit Testimonial', 'estatein' ),
				'new_item'           => __( 'New Testimonial', 'estatein' ),
				'view_item'          => __( 'View Testimonial', 'estatein' ),
				'view_items'         => __( 'View Testimonials', 'estatein' ),
				'search_items'       => __( 'Search Testimonials', 'estatein' ),
				'not_found'          => __( 'No testimonials found', 'estatein' ),
				'not_found_in_trash' => __( 'No testimonials found in Trash', 'estatein' ),
				'all_items'          => __( 'All Testimonials', 'estatein' ),
				'menu_name'          => __( 'Testimonials', 'estatein' ),
			),
			'description'   => __( 'Real stories from Estatein clients who found or sold a property with our help.', 'estatein' ),
			'public'        => true,
			'has_archive'   => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-format-quote',
			'rewrite'       => array( 'slug' => 'testimonials', 'with_front' => false ),
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'menu_position' => 6,
		)
	);
}
add_action( 'init', 'estatein_register_testimonial_cpt' );

/**
 * Client Details meta box: name + location shown under the quote on each card.
 */
function estatein_add_testimonial_meta_boxes() {
	add_meta_box(
		'estatein_testimonial_details',
		__( 'Client Details', 'estatein' ),
		'estatein_render_testimonial_details_meta_box',
		'testimonial',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'estatein_add_testimonial_meta_boxes' );

function estatein_render_testimonial_details_meta_box( $post ) {
	wp_nonce_field( 'estatein_save_testimonial_details', 'estatein_testimonial_nonce' );
	$name     = get_post_meta( $post->ID, '_testimonial_name', true );
	$location = get_post_meta( $post->ID, '_testimonial_location', true );
	?>
	<p>
		<label for="testimonial_name"><?php esc_html_e( 'Client Name', 'estatein' ); ?></label>
		<input type="text" id="testimonial_name" name="testimonial_name" value="<?php echo esc_attr( $name ); ?>" class="widefat" />
	</p>
	<p>
		<label for="testimonial_location"><?php esc_html_e( 'Location', 'estatein' ); ?></label>
		<input type="text" id="testimonial_location" name="testimonial_location" value="<?php echo esc_attr( $location ); ?>" class="widefat" placeholder="USA, California" />
	</p>
	<p class="description">
		<?php esc_html_e( 'Use the Title field above for the testimonial headline (e.g. "Exceptional Service!"), the content editor for the quote, and the Featured Image for the client\'s avatar. If no avatar is set, initials from the Client Name are shown instead.', 'estatein' ); ?>
	</p>
	<?php
}

function estatein_save_testimonial_meta( $post_id ) {
	if ( ! isset( $_POST['estatein_testimonial_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['estatein_testimonial_nonce'] ), 'estatein_save_testimonial_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['testimonial_name'] ) ) {
		update_post_meta( $post_id, '_testimonial_name', sanitize_text_field( wp_unslash( $_POST['testimonial_name'] ) ) );
	}
	if ( isset( $_POST['testimonial_location'] ) ) {
		update_post_meta( $post_id, '_testimonial_location', sanitize_text_field( wp_unslash( $_POST['testimonial_location'] ) ) );
	}
}
add_action( 'save_post_testimonial', 'estatein_save_testimonial_meta' );

/**
 * Seed the original homepage testimonials as real posts the first time this
 * ships, so existing content carries over instead of disappearing.
 */
function estatein_seed_default_testimonials() {
	if ( get_option( 'estatein_testimonials_seeded' ) ) {
		return;
	}

	$defaults = array(
		array(
			'title'    => 'Exceptional Service!',
			'quote'    => 'Our experience with Estatein was outstanding. Their team\'s dedication and professionalism made finding our dream home a breeze. Highly recommended!',
			'name'     => 'Wade Warren',
			'location' => 'USA, California',
		),
		array(
			'title'    => 'Efficient and Reliable',
			'quote'    => 'Estatein provided us with top-notch service. They helped us sell our property quickly and at a great price. We couldn\'t be happier with the results.',
			'name'     => 'Emelie Thomson',
			'location' => 'USA, Florida',
		),
		array(
			'title'    => 'Trusted Advisors',
			'quote'    => 'The Estatein team guided us through the entire buying process. Their knowledge and commitment to our needs were impressive. Thank you for your support!',
			'name'     => 'John Mans',
			'location' => 'USA, Nevada',
		),
	);

	foreach ( $defaults as $index => $item ) {
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'testimonial',
				'post_title'   => $item['title'],
				'post_content' => $item['quote'],
				'post_status'  => 'publish',
				'menu_order'   => $index,
			)
		);
		if ( $post_id && ! is_wp_error( $post_id ) ) {
			update_post_meta( $post_id, '_testimonial_name', $item['name'] );
			update_post_meta( $post_id, '_testimonial_location', $item['location'] );
		}
	}

	update_option( 'estatein_testimonials_seeded', 1 );
}
add_action( 'after_switch_theme', 'estatein_seed_default_testimonials' );
