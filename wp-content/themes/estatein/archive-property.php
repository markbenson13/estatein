<?php
/**
 * Property archive + taxonomy listing template.
 */

get_header();
?>

<section class="archive-header py-5 text-center">
	<div class="container">
		<span class="eyebrow"><?php esc_html_e( 'Listings', 'estatein' ); ?></span>
		<?php if ( is_tax() ) : ?>
			<h1><?php single_term_title(); ?></h1>
		<?php else : ?>
			<h1><?php esc_html_e( 'Browse Properties', 'estatein' ); ?></h1>
		<?php endif; ?>
		<p class="text-body-secondary mb-0"><?php esc_html_e( 'Use the filters to narrow down listings by type, status, location, price and bedrooms.', 'estatein' ); ?></p>
	</div>
</section>

<section class="py-5">
	<div class="container">
		<div class="row g-4">
			<aside class="col-lg-3">
				<?php estatein_render_property_filters(); ?>
			</aside>

			<div class="col-lg-9">
				<div class="d-flex justify-content-between align-items-center mb-4 text-body-secondary small">
					<span>
						<?php
						global $wp_query;
						printf(
							/* translators: %d: number of results. */
							esc_html( _n( '%d property found', '%d properties found', $wp_query->found_posts, 'estatein' ) ),
							(int) $wp_query->found_posts
						);
						?>
					</span>
				</div>

				<?php if ( have_posts() ) : ?>
					<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
						<?php
						while ( have_posts() ) :
							the_post();
							?>
							<div class="col"><?php get_template_part( 'template-parts/property-card' ); ?></div>
							<?php
						endwhile;
						?>
					</div>
					<div class="mt-5">
						<?php estatein_pagination(); ?>
					</div>
				<?php else : ?>
					<div class="no-results card p-5 text-center border-dashed">
						<h3 class="h5"><?php esc_html_e( 'No properties match your filters', 'estatein' ); ?></h3>
						<p class="text-body-secondary"><?php esc_html_e( 'Try widening your price range or clearing a filter.', 'estatein' ); ?></p>
						<a href="<?php echo esc_url( get_post_type_archive_link( 'property' ) ); ?>" class="btn btn-outline-light mx-auto"><?php esc_html_e( 'Reset Filters', 'estatein' ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
