<?php
/**
 * Default page template.
 */

get_header();
?>

<section class="page-header py-5 text-center">
	<div class="container">
		<h1 class="mb-0"><?php the_title(); ?></h1>
	</div>
</section>

<section class="py-5">
	<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<div class="single-post-content mx-auto" style="max-width:800px;">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="mb-4 rounded overflow-hidden"><?php the_post_thumbnail( 'estatein-hero', array( 'class' => 'img-fluid w-100' ) ); ?></div>
				<?php endif; ?>
				<?php the_content(); ?>
			</div>
			<?php
		endwhile;
		?>
	</div>
</section>

<?php
get_footer();
