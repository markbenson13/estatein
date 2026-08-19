<?php
/**
 * Property card used in grids across the homepage, archive, and related listings.
 *
 * @var array $args {
 *     @type array $meta Optional pre-fetched estatein_property_meta() array.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$meta      = ( isset( $args['meta'] ) ) ? $args['meta'] : estatein_property_meta( get_the_ID() );
$type_term = get_the_terms( get_the_ID(), 'property_type' );
$type_name = ( $type_term && ! is_wp_error( $type_term ) ) ? $type_term[0]->name : '';
?>
<article class="card property-card h-100 p-3">
	<div class="position-relative overflow-hidden rounded-3 mb-3">
		<a href="<?php the_permalink(); ?>" class="ratio ratio-4x3 d-block">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'estatein-card', array( 'class' => 'w-100 h-100 object-fit-cover' ) ); ?>
			<?php else : ?>
				<span class="no-image d-block w-100 h-100"></span>
			<?php endif; ?>
		</a>
	</div>
	<div class="card-body d-flex flex-column px-2 pb-0 pt-0">
		<h3 class="card-title h5"><a href="<?php the_permalink(); ?>" class="text-decoration-none text-reset stretched-link"><?php the_title(); ?></a></h3>
		<p class="card-text text-body-secondary small">
			<?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?>
			<a href="<?php the_permalink(); ?>" class="text-decoration-underline position-relative" style="z-index:2;"><?php esc_html_e( 'Read More', 'estatein' ); ?></a>
		</p>
		<div class="d-flex flex-wrap gap-2 mb-3">
			<?php if ( '' !== $meta['bedrooms'] ) : ?>
				<span class="property-pill"><img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/bed-icon.png' ); ?>" alt="" loading="lazy" /> <?php echo esc_html( $meta['bedrooms'] ); ?>-<?php esc_html_e( 'Bedroom', 'estatein' ); ?></span>
			<?php endif; ?>
			<?php if ( '' !== $meta['bathrooms'] ) : ?>
				<span class="property-pill"><img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/bath-icon.png' ); ?>" alt="" loading="lazy" /> <?php echo esc_html( $meta['bathrooms'] ); ?>-<?php esc_html_e( 'Bathroom', 'estatein' ); ?></span>
			<?php endif; ?>
			<?php if ( $type_name ) : ?>
				<span class="property-pill"><img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/villa-icon.png' ); ?>" alt="" loading="lazy" /> <?php echo esc_html( $type_name ); ?></span>
			<?php endif; ?>
		</div>
		<hr class="text-body-secondary opacity-25 mt-0 mb-3" />
		<div class="d-flex flex-row gap-3 mt-auto justify-content-between">
			<div>
				<div class="property-price-label"><?php esc_html_e( 'Price', 'estatein' ); ?></div>
				<div class="property-price-value"><?php echo esc_html( estatein_format_price( $meta['price'], $meta['price_suffix'] ) ); ?></div>
			</div>
			<a href="<?php the_permalink(); ?>" class="btn btn-primary property-card-btn position-relative" style="z-index:2;"><?php esc_html_e( 'View Property Details', 'estatein' ); ?></a>
		</div>
	</div>
</article>
