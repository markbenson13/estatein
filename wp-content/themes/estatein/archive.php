<?php
/**
 * Generic archive template (categories, tags, dates, authors).
 * The Property post type has its own archive-property.php.
 */

get_header();
?>

<section class="page-header py-5 text-center">
	<div class="container">
		<h1 class="mb-2"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="text-body-secondary">', '</div>' ); ?>
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
						<h3 class="h5 mb-0"><?php esc_html_e( 'Nothing found', 'estatein' ); ?></h3>
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
