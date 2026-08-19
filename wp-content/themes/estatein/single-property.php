<?php
/**
 * Single property listing template.
 */

get_header();

while ( have_posts() ) :
	the_post();

	$meta        = estatein_property_meta( get_the_ID() );
	$status      = estatein_get_status_term( get_the_ID() );
	$gallery_ids = $meta['gallery'];
	$main_image  = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'estatein-hero' ) : '';
	$all_images  = array();
	if ( $main_image ) {
		$all_images[] = $main_image;
	}
	foreach ( $gallery_ids as $gid ) {
		$src = wp_get_attachment_image_url( $gid, 'estatein-hero' );
		if ( $src ) {
			$all_images[] = $src;
		}
	}
	$inquiry_status = isset( $_GET['inquiry'] ) ? sanitize_text_field( wp_unslash( $_GET['inquiry'] ) ) : '';
	?>

	<section class="property-hero py-5">
		<div class="container">
			<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
				<div>
					<?php if ( $status ) : ?>
						<span class="eyebrow"><?php echo esc_html( $status->name ); ?></span>
					<?php endif; ?>
					<h1 class="mb-2"><?php the_title(); ?></h1>
					<?php if ( $meta['address'] ) : ?>
						<p class="text-body-secondary mb-0"><?php echo esc_html( $meta['address'] ); ?></p>
					<?php endif; ?>
				</div>
				<div class="text-lg-end">
					<div class="property-price-amount"><?php echo esc_html( estatein_format_price( $meta['price'], $meta['price_suffix'] ) ); ?></div>
				</div>
			</div>

			<?php if ( ! empty( $all_images ) ) : ?>
				<div class="property-gallery mb-5">
					<div class="property-gallery-main ratio ratio-16x9" id="property-gallery-main" role="button" tabindex="0" data-bs-toggle="modal" data-bs-target="#propertyGalleryModal">
						<img src="<?php echo esc_url( $all_images[0] ); ?>" alt="<?php the_title_attribute(); ?>" class="w-100 h-100 object-fit-cover" id="property-gallery-main-img" />
					</div>
					<?php if ( count( $all_images ) > 1 ) : ?>
						<div class="property-gallery-thumbs">
							<?php foreach ( $all_images as $i => $img ) : ?>
								<button type="button" class="property-gallery-thumb ratio ratio-1x1 <?php echo 0 === $i ? 'active' : ''; ?>" data-src="<?php echo esc_url( $img ); ?>">
									<img src="<?php echo esc_url( $img ); ?>" alt="" class="w-100 h-100 object-fit-cover" />
								</button>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="modal fade" id="propertyGalleryModal" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-xl">
						<div class="modal-content bg-transparent border-0">
							<button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'estatein' ); ?>"></button>
							<img src="<?php echo esc_url( $all_images[0] ); ?>" alt="<?php the_title_attribute(); ?>" class="w-100 rounded" id="property-gallery-modal-img" loading="lazy" />
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="row g-5">
				<div class="col-lg-8">
					<div class="row row-cols-2 row-cols-md-4 g-3 property-facts-row card p-4 mb-5">
						<?php if ( '' !== $meta['bedrooms'] ) : ?>
							<div class="col property-fact text-center"><strong class="d-block h5 mb-0"><?php echo esc_html( $meta['bedrooms'] ); ?></strong><span class="small text-body-secondary"><?php esc_html_e( 'Bedrooms', 'estatein' ); ?></span></div>
						<?php endif; ?>
						<?php if ( '' !== $meta['bathrooms'] ) : ?>
							<div class="col property-fact text-center"><strong class="d-block h5 mb-0"><?php echo esc_html( $meta['bathrooms'] ); ?></strong><span class="small text-body-secondary"><?php esc_html_e( 'Bathrooms', 'estatein' ); ?></span></div>
						<?php endif; ?>
						<?php if ( '' !== $meta['area'] ) : ?>
							<div class="col property-fact text-center"><strong class="d-block h5 mb-0"><?php echo esc_html( $meta['area'] ); ?></strong><span class="small text-body-secondary"><?php echo esc_html( estatein_area_unit_label( $meta['area_unit'] ) ); ?></span></div>
						<?php endif; ?>
						<?php if ( '' !== $meta['garage'] ) : ?>
							<div class="col property-fact text-center"><strong class="d-block h5 mb-0"><?php echo esc_html( $meta['garage'] ); ?></strong><span class="small text-body-secondary"><?php esc_html_e( 'Garage', 'estatein' ); ?></span></div>
						<?php endif; ?>
					</div>

					<div class="property-description">
						<h2 class="h4"><?php esc_html_e( 'About This Property', 'estatein' ); ?></h2>
						<?php the_content(); ?>

						<?php if ( '' !== $meta['year_built'] ) : ?>
							<p><strong><?php esc_html_e( 'Year Built:', 'estatein' ); ?></strong> <?php echo esc_html( $meta['year_built'] ); ?></p>
						<?php endif; ?>
					</div>

					<?php if ( $meta['address'] ) : ?>
						<div class="property-map mt-5">
							<h2 class="h4"><?php esc_html_e( 'Location', 'estatein' ); ?></h2>
							<div class="ratio ratio-16x9 rounded overflow-hidden">
								<iframe
									src="https://www.google.com/maps?q=<?php echo rawurlencode( $meta['address'] ); ?>&output=embed"
									loading="lazy"
									referrerpolicy="no-referrer-when-downgrade"
									title="<?php esc_attr_e( 'Property location map', 'estatein' ); ?>"
								></iframe>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<aside class="col-lg-4">
					<div class="agent-card card p-4">
						<h3 class="h5 mb-1"><?php esc_html_e( 'Interested in this property?', 'estatein' ); ?></h3>
						<p class="text-body-secondary"><?php esc_html_e( 'Send an inquiry and our team will get back to you shortly.', 'estatein' ); ?></p>

						<ul class="list-unstyled d-flex flex-column gap-2 small mb-4">
							<?php if ( get_theme_mod( 'estatein_phone' ) ) : ?>
								<li><?php echo esc_html( get_theme_mod( 'estatein_phone' ) ); ?></li>
							<?php endif; ?>
							<?php if ( get_theme_mod( 'estatein_email' ) ) : ?>
								<li><?php echo esc_html( get_theme_mod( 'estatein_email' ) ); ?></li>
							<?php endif; ?>
						</ul>

						<?php if ( 'sent' === $inquiry_status ) : ?>
							<div class="alert alert-primary"><?php esc_html_e( 'Thanks! Your inquiry has been sent.', 'estatein' ); ?></div>
						<?php elseif ( 'error' === $inquiry_status ) : ?>
							<div class="alert alert-danger"><?php esc_html_e( 'Something went wrong, please check the form and try again.', 'estatein' ); ?></div>
						<?php endif; ?>

						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
							<input type="hidden" name="action" value="estatein_property_inquiry" />
							<input type="hidden" name="property_id" value="<?php echo esc_attr( get_the_ID() ); ?>" />
							<?php wp_nonce_field( 'estatein_property_inquiry', 'estatein_inquiry_nonce' ); ?>
							<div class="visually-hidden" aria-hidden="true">
								<label for="property-website">Website</label>
								<input type="text" id="property-website" name="website" tabindex="-1" autocomplete="off" />
							</div>

							<div class="mb-3">
								<label for="inquiry-name" class="form-label small"><?php esc_html_e( 'Name', 'estatein' ); ?></label>
								<input type="text" id="inquiry-name" name="name" class="form-control" required />
							</div>
							<div class="mb-3">
								<label for="inquiry-email" class="form-label small"><?php esc_html_e( 'Email', 'estatein' ); ?></label>
								<input type="email" id="inquiry-email" name="email" class="form-control" required />
							</div>
							<div class="mb-3">
								<label for="inquiry-phone" class="form-label small"><?php esc_html_e( 'Phone', 'estatein' ); ?></label>
								<input type="text" id="inquiry-phone" name="phone" class="form-control" />
							</div>
							<div class="mb-3">
								<label for="inquiry-message" class="form-label small"><?php esc_html_e( 'Message', 'estatein' ); ?></label>
								<textarea id="inquiry-message" name="message" class="form-control" rows="4" placeholder="<?php esc_attr_e( 'I would like to schedule a viewing…', 'estatein' ); ?>"></textarea>
							</div>
							<button type="submit" class="btn btn-primary w-100"><?php esc_html_e( 'Send Inquiry', 'estatein' ); ?></button>
						</form>
					</div>
				</aside>
			</div>

			<?php
			$related_type_ids = wp_get_post_terms( get_the_ID(), 'property_type', array( 'fields' => 'ids' ) );
			$related_args      = array(
				'post_type'      => 'property',
				'posts_per_page' => 3,
				'post__not_in'   => array( get_the_ID() ),
			);
			if ( ! is_wp_error( $related_type_ids ) && ! empty( $related_type_ids ) ) {
				$related_args['tax_query'] = array(
					array(
						'taxonomy' => 'property_type',
						'field'    => 'term_id',
						'terms'    => $related_type_ids,
					),
				);
			}
			$related = new WP_Query( $related_args );
			if ( $related->have_posts() ) :
				?>
				<div class="related-properties mt-5 pt-5">
					<h2 class="h4 mb-4"><?php esc_html_e( 'Similar Properties', 'estatein' ); ?></h2>
					<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
						<?php
						while ( $related->have_posts() ) :
							$related->the_post();
							?>
							<div class="col"><?php get_template_part( 'template-parts/property-card' ); ?></div>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
				<?php
			endif;
			?>
		</div>
	</section>

	<?php
endwhile;

get_footer();
