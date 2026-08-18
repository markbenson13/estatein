<?php
/**
 * Post card used in the blog listing (index.php / archive.php / search.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article class="card post-card flex-md-row mb-4">
	<a href="<?php the_permalink(); ?>" class="ratio ratio-4x3 d-block post-card-media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'estatein-card', array( 'class' => 'w-100 h-100 object-fit-cover' ) ); ?>
		<?php else : ?>
			<span class="no-image d-block w-100 h-100"></span>
		<?php endif; ?>
	</a>
	<div class="card-body">
		<div class="post-meta text-body-secondary small text-uppercase mb-2"><?php echo esc_html( get_the_date() ); ?> &middot; <?php the_author(); ?></div>
		<h2 class="card-title h5"><a href="<?php the_permalink(); ?>" class="text-reset text-decoration-none"><?php the_title(); ?></a></h2>
		<p class="card-text text-body-secondary"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 26 ) ); ?></p>
		<a href="<?php the_permalink(); ?>" class="btn btn-outline-light btn-sm"><?php esc_html_e( 'Read More', 'estatein' ); ?></a>
	</div>
</article>
