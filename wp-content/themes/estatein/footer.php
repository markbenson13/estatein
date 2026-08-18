<?php
/**
 * The footer for the Estatein theme.
 */

$estatein_newsletter_status = isset( $_GET['newsletter'] ) ? sanitize_text_field( wp_unslash( $_GET['newsletter'] ) ) : '';
$estatein_properties_url    = get_post_type_archive_link( 'property' );
$estatein_about_url         = home_url( '/about/' );
$estatein_services_url      = home_url( '/services/' );
$estatein_contact_url       = home_url( '/contact/' );

$estatein_footer_columns = array(
	'home'       => array(
		'title' => __( 'Home', 'estatein' ),
		'links' => array(
			__( 'Hero Section', 'estatein' )  => home_url( '/#hero' ),
			__( 'Features', 'estatein' )      => home_url( '/#features' ),
			__( 'Properties', 'estatein' )    => home_url( '/#properties' ),
			__( 'Testimonials', 'estatein' )  => home_url( '/#testimonials' ),
			__( "FAQ's", 'estatein' )         => home_url( '/#faq' ),
		),
	),
	'about'      => array(
		'title' => __( 'About Us', 'estatein' ),
		'links' => array(
			__( 'Our Story', 'estatein' )    => $estatein_about_url,
			__( 'Our Works', 'estatein' )    => $estatein_about_url,
			__( 'How It Works', 'estatein' ) => $estatein_about_url,
			__( 'Our Team', 'estatein' )     => $estatein_about_url,
			__( 'Our Clients', 'estatein' )  => $estatein_about_url,
		),
	),
	'properties' => array(
		'title' => __( 'Properties', 'estatein' ),
		'links' => array(
			__( 'Portfolio', 'estatein' )  => $estatein_properties_url,
			__( 'Categories', 'estatein' ) => $estatein_properties_url,
		),
	),
	'services'   => array(
		'title' => __( 'Services', 'estatein' ),
		'links' => array(
			__( 'Valuation Mastery', 'estatein' )    => $estatein_services_url,
			__( 'Strategic Marketing', 'estatein' )  => $estatein_services_url,
			__( 'Negotiation Wizardry', 'estatein' ) => $estatein_services_url,
			__( 'Closing Success', 'estatein' )      => $estatein_services_url,
			__( 'Property Management', 'estatein' )  => $estatein_services_url,
		),
	),
	'contact'    => array(
		'title' => __( 'Contact Us', 'estatein' ),
		'links' => array(
			__( 'Contact Form', 'estatein' ) => $estatein_contact_url,
			__( 'Our Offices', 'estatein' )  => $estatein_contact_url,
		),
	),
);
?>
	<footer class="site-footer border-top border-secondary-subtle">
		<div class="container footer-main">
			<div class="row gy-4 footer-columns-row">
				<div class="col-12 col-lg-3">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="d-inline-block mb-3">
						<?php
						if ( has_custom_logo() ) {
							the_custom_logo();
						} else {
							?>
							<img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/estatein-logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="site-logo-img" />
							<?php
						}
						?>
					</a>

					<?php if ( 'sent' === $estatein_newsletter_status ) : ?>
						<div class="alert alert-primary py-2 px-3 small"><?php esc_html_e( 'Thanks for subscribing!', 'estatein' ); ?></div>
					<?php elseif ( 'error' === $estatein_newsletter_status ) : ?>
						<div class="alert alert-danger py-2 px-3 small"><?php esc_html_e( 'Please enter a valid email.', 'estatein' ); ?></div>
					<?php else : ?>
						<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="newsletter-form">
							<input type="hidden" name="action" value="estatein_newsletter_signup" />
							<?php wp_nonce_field( 'estatein_newsletter_signup', 'estatein_newsletter_nonce' ); ?>
							<div class="visually-hidden" aria-hidden="true">
								<label for="newsletter-website">Website</label>
								<input type="text" id="newsletter-website" name="website" tabindex="-1" autocomplete="off" />
							</div>
							<div class="newsletter-input-group d-flex align-items-center">
								<img class="newsletter-icon" src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/email-icon.png' ); ?>" alt="" aria-hidden="true" />
								<label for="newsletter-email" class="visually-hidden"><?php esc_html_e( 'Email address', 'estatein' ); ?></label>
								<input type="email" id="newsletter-email" name="email" class="form-control border-0" placeholder="<?php esc_attr_e( 'Enter Your Email', 'estatein' ); ?>" required />
								<button type="submit" class="newsletter-submit" aria-label="<?php esc_attr_e( 'Subscribe', 'estatein' ); ?>">
									<img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/send-icon.png' ); ?>" alt="" />
								</button>
							</div>
						</form>
					<?php endif; ?>
				</div>

				<?php foreach ( $estatein_footer_columns as $column ) : ?>
					<div class="col-6 col-lg">
						<h4 class="footer-col-title"><?php echo esc_html( $column['title'] ); ?></h4>
						<ul class="list-unstyled d-flex flex-column footer-col-links">
							<?php foreach ( $column['links'] as $label => $url ) : ?>
								<li><a class="text-decoration-none" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="footer-copyright border-top border-secondary-subtle">
			<div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
				<div class="d-flex align-items-center gap-3 footer-copyright-text">
					<span><?php echo wp_kses_post( get_theme_mod( 'estatein_footer_text' ) ); ?></span>
					<a class="text-decoration-none" href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>"><?php esc_html_e( 'Terms & Conditions', 'estatein' ); ?></a>
				</div>
				<div class="d-flex gap-2">
					<?php
					foreach ( array( 'facebook', 'linkedin', 'twitter', 'youtube' ) as $network ) {
						$url = get_theme_mod( 'estatein_social_' . $network );
						if ( $url ) {
							printf(
								'<a href="%1$s" target="_blank" rel="noopener noreferrer" aria-label="%2$s" class="social-icon d-flex align-items-center justify-content-center">%3$s</a>',
								esc_url( $url ),
								esc_attr( ucfirst( $network ) ),
								'<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">' . estatein_social_icon_svg( $network ) . '</svg>'
							);
						}
					}
					?>
				</div>
			</div>
		</div>
	</footer>

<?php wp_footer(); ?>
</body>
</html>
