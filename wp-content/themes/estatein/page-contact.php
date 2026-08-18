<?php
/**
 * Template Name: Contact Page
 */

get_header();

$contact_status = isset( $_GET['contact'] ) ? sanitize_text_field( wp_unslash( $_GET['contact'] ) ) : '';
?>

<section class="page-header py-5 text-center">
	<div class="container">
		<h1 class="mb-0"><?php the_title(); ?></h1>
	</div>
</section>

<section class="py-5">
	<div class="container">
		<div class="row g-5">
			<div class="col-lg-7">
				<?php
				while ( have_posts() ) :
					the_post();
					if ( trim( get_the_content() ) ) :
						?>
						<div class="single-post-content mb-4"><?php the_content(); ?></div>
						<?php
					endif;
				endwhile;
				?>

				<?php if ( 'sent' === $contact_status ) : ?>
					<div class="alert alert-primary"><?php esc_html_e( 'Thanks for reaching out! We will get back to you within one business day.', 'estatein' ); ?></div>
				<?php elseif ( 'error' === $contact_status ) : ?>
					<div class="alert alert-danger"><?php esc_html_e( 'Please fill in all required fields and try again.', 'estatein' ); ?></div>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="card p-4">
					<input type="hidden" name="action" value="estatein_contact_form" />
					<?php wp_nonce_field( 'estatein_contact_form', 'estatein_contact_nonce' ); ?>
					<div class="visually-hidden" aria-hidden="true">
						<label for="contact-website">Website</label>
						<input type="text" id="contact-website" name="website" tabindex="-1" autocomplete="off" />
					</div>

					<div class="row g-3 mb-3">
						<div class="col-md-6">
							<label for="contact-name" class="form-label small"><?php esc_html_e( 'Name', 'estatein' ); ?></label>
							<input type="text" id="contact-name" name="name" class="form-control" required />
						</div>
						<div class="col-md-6">
							<label for="contact-email" class="form-label small"><?php esc_html_e( 'Email', 'estatein' ); ?></label>
							<input type="email" id="contact-email" name="email" class="form-control" required />
						</div>
					</div>
					<div class="mb-3">
						<label for="contact-phone" class="form-label small"><?php esc_html_e( 'Phone', 'estatein' ); ?></label>
						<input type="text" id="contact-phone" name="phone" class="form-control" />
					</div>
					<div class="mb-3">
						<label for="contact-message" class="form-label small"><?php esc_html_e( 'Message', 'estatein' ); ?></label>
						<textarea id="contact-message" name="message" class="form-control" rows="6" required></textarea>
					</div>
					<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Send Message', 'estatein' ); ?></button>
				</form>
			</div>

			<div class="col-lg-5">
				<div class="agent-card card p-4">
					<h3 class="h5 mb-3"><?php esc_html_e( 'Get in Touch', 'estatein' ); ?></h3>
					<ul class="list-unstyled d-flex flex-column gap-2 small mb-0">
						<li><?php echo esc_html( get_theme_mod( 'estatein_phone' ) ); ?></li>
						<li><?php echo esc_html( get_theme_mod( 'estatein_email' ) ); ?></li>
						<li><?php echo esc_html( get_theme_mod( 'estatein_address' ) ); ?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
