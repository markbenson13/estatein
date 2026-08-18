<?php
/**
 * Lead-capture forms: per-property inquiry form + general contact page form.
 * Both post to admin-post.php, verify a nonce + honeypot, email the admin,
 * then redirect back to the referring page with a status flag.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatein_handle_property_inquiry() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if ( ! isset( $_POST['estatein_inquiry_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['estatein_inquiry_nonce'] ), 'estatein_property_inquiry' ) ) {
		wp_safe_redirect( add_query_arg( 'inquiry', 'error', $redirect ) );
		exit;
	}

	// Honeypot: real visitors never fill this hidden field in.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'inquiry', 'sent', $redirect ) );
		exit;
	}

	$name       = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone      = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message    = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$property_id = isset( $_POST['property_id'] ) ? absint( $_POST['property_id'] ) : 0;

	if ( ! $name || ! is_email( $email ) || ! $property_id ) {
		wp_safe_redirect( add_query_arg( 'inquiry', 'error', $redirect ) );
		exit;
	}

	$property_title = get_the_title( $property_id );
	$to      = get_theme_mod( 'estatein_email', get_option( 'admin_email' ) );
	$subject = sprintf( __( 'New inquiry about "%s"', 'estatein' ), $property_title );
	$body    = sprintf(
		"Name: %s\nEmail: %s\nPhone: %s\n\nMessage:\n%s\n\nProperty: %s (%s)",
		$name,
		$email,
		$phone,
		$message,
		$property_title,
		get_permalink( $property_id )
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'inquiry', 'sent', $redirect ) );
	exit;
}
add_action( 'admin_post_estatein_property_inquiry', 'estatein_handle_property_inquiry' );
add_action( 'admin_post_nopriv_estatein_property_inquiry', 'estatein_handle_property_inquiry' );

function estatein_handle_contact_form() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if ( ! isset( $_POST['estatein_contact_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['estatein_contact_nonce'] ), 'estatein_contact_form' ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', $redirect ) );
		exit;
	}

	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact', 'sent', $redirect ) );
		exit;
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', $redirect ) );
		exit;
	}

	$to      = get_theme_mod( 'estatein_email', get_option( 'admin_email' ) );
	$subject = sprintf( __( 'New contact form message from %s', 'estatein' ), $name );
	$body    = sprintf( "Name: %s\nEmail: %s\nPhone: %s\n\nMessage:\n%s", $name, $email, $phone, $message );
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'contact', 'sent', $redirect ) );
	exit;
}
add_action( 'admin_post_estatein_contact_form', 'estatein_handle_contact_form' );
add_action( 'admin_post_nopriv_estatein_contact_form', 'estatein_handle_contact_form' );

function estatein_handle_newsletter_signup() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );

	if ( ! isset( $_POST['estatein_newsletter_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['estatein_newsletter_nonce'] ), 'estatein_newsletter_signup' ) ) {
		wp_safe_redirect( add_query_arg( 'newsletter', 'error', $redirect ) );
		exit;
	}

	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'newsletter', 'sent', $redirect ) );
		exit;
	}

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'newsletter', 'error', $redirect ) );
		exit;
	}

	$to      = get_theme_mod( 'estatein_email', get_option( 'admin_email' ) );
	$subject = __( 'New newsletter signup', 'estatein' );
	$body    = sprintf( "A visitor subscribed to the newsletter:\n%s", $email );

	wp_mail( $to, $subject, $body );

	wp_safe_redirect( add_query_arg( 'newsletter', 'sent', $redirect ) );
	exit;
}
add_action( 'admin_post_estatein_newsletter_signup', 'estatein_handle_newsletter_signup' );
add_action( 'admin_post_nopriv_estatein_newsletter_signup', 'estatein_handle_newsletter_signup' );
