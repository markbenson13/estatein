<?php
/**
 * Search results template.
 */

get_header();
?>

<section class="page-header py-5 text-center">
	<div class="container">
		<h1 class="mb-0">
			<?php
			printf(
				/* translators: %s: search query. */
				esc_html__( 'Search Results for: %s', 'estatein' ),
				'<span>' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
	</div>
</section>

<section class="py-5">
	<div class="container">
		<div class="row g-5">
			<div class="col-lg-8">
				<?php if ( have_posts() ) : ?>
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content' );
					endwhile;
					estatein_pagination();
					?>
				<?php else : ?>
					<div class="no-results card p-5 text-center">
						<h3 class="h5"><?php esc_html_e( 'No results found', 'estatein' ); ?></h3>
						<p class="text-body-secondary"><?php esc_html_e( 'Try a different search term.', 'estatein' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				<?php endif; ?>
			</div>
			<aside class="col-lg-4">
				<?php dynamic_sidebar( 'sidebar-blog' ); ?>
			</aside>
		</div>
	</div>
</section>

<?php
get_footer();
