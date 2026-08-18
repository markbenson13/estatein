<?php
/**
 * Single blog post template.
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="page-header py-5 text-center">
		<div class="container">
			<div class="post-meta text-body-secondary small text-uppercase mb-2"><?php echo esc_html( get_the_date() ); ?> &middot; <?php the_author(); ?></div>
			<h1 class="mb-0"><?php the_title(); ?></h1>
		</div>
	</section>

	<section class="py-5">
		<div class="container">
			<div class="row g-5">
				<div class="col-lg-8">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="mb-4 rounded overflow-hidden"><?php the_post_thumbnail( 'estatein-hero', array( 'class' => 'img-fluid w-100' ) ); ?></div>
					<?php endif; ?>
					<div class="single-post-content">
						<?php the_content(); ?>
					</div>

					<?php if ( comments_open() || get_comments_number() ) : ?>
						<div class="comments-area mt-5">
							<?php comments_template(); ?>
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
endwhile;

get_footer();
