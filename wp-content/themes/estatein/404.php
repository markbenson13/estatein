<?php
/**
 * 404 template.
 */

get_header();
?>

<section class="error-404 py-5 text-center">
	<div class="container">
		<div class="error-code display-1 fw-bold text-primary mb-2">404</div>
		<h1><?php esc_html_e( 'Page Not Found', 'estatein' ); ?></h1>
		<p class="text-body-secondary"><?php esc_html_e( 'The page you are looking for may have been moved or no longer exists.', 'estatein' ); ?></p>
		<?php get_search_form(); ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary mt-4"><?php esc_html_e( 'Back to Homepage', 'estatein' ); ?></a>
	</div>
</section>

<?php
get_footer();
