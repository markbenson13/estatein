<?php
/**
 * The header for the Estatein theme.
 */
?>
<!doctype html>
<html <?php language_attributes(); ?> data-bs-theme="dark">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$estatein_announcement_text = get_theme_mod( 'estatein_announcement_text', 'Discover Your Dream Property with Estatein' );
$estatein_announcement_link = get_theme_mod( 'estatein_announcement_link', get_post_type_archive_link( 'property' ) );
if ( get_theme_mod( 'estatein_show_announcement', true ) && $estatein_announcement_text ) :
	?>
	<div class="announcement-bar position-relative d-flex align-items-center justify-content-center py-2 px-4" id="announcement-bar">
		<div class="d-flex align-items-center justify-content-center gap-2 flex-wrap small mb-0">
			<span class="announcement-icon" aria-hidden="true">&#10024;</span>
			<span><?php echo esc_html( $estatein_announcement_text ); ?></span>
			<?php if ( $estatein_announcement_link ) : ?>
				<a class="link-light" href="<?php echo esc_url( $estatein_announcement_link ); ?>"><?php esc_html_e( 'Learn More', 'estatein' ); ?></a>
			<?php endif; ?>
		</div>
		<button type="button" class="announcement-close btn-close btn-close-white position-absolute top-50 end-0 translate-middle-y me-3" id="announcement-close" aria-label="<?php esc_attr_e( 'Dismiss announcement', 'estatein' ); ?>"></button>
	</div>
<?php endif; ?>

<header class="navbar navbar-expand-lg sticky-top py-3">
	<div class="container">
		<a class="navbar-brand py-0" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/estatein-logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="site-logo-img" />
			<?php endif; ?>
		</a>

		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNav" aria-controls="primaryNav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'estatein' ); ?>">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="primaryNav">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'navbar-nav mx-lg-auto mb-2 mb-lg-0',
					'fallback_cb'    => 'estatein_fallback_menu',
				)
			);
			?>
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn-outline-light btn-sm navbar-contact-btn mt-3 mt-lg-0 align-self-start"><?php esc_html_e( 'Contact Us', 'estatein' ); ?></a>
		</div>
	</div>
</header>
