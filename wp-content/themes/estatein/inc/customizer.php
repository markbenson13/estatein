<?php
/**
 * Theme Customizer: contact info, social links, homepage hero content.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatein_customize_register( $wp_customize ) {

	// --- Contact info -----------------------------------------------------
	$wp_customize->add_section(
		'estatein_contact',
		array(
			'title'    => __( 'Contact Info', 'estatein' ),
			'priority' => 30,
		)
	);

	$fallbacks     = estatein_theme_mod_fallbacks();
	$contact_fields = array(
		'estatein_phone'   => __( 'Phone Number', 'estatein' ),
		'estatein_email'   => __( 'Email Address', 'estatein' ),
		'estatein_address' => __( 'Office Address', 'estatein' ),
	);

	foreach ( $contact_fields as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $fallbacks[ $id ],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => 'estatein_contact',
				'type'    => 'text',
			)
		);
	}

	// --- Social links -------------------------------------------------------
	$wp_customize->add_section(
		'estatein_social',
		array(
			'title'    => __( 'Social Links', 'estatein' ),
			'priority' => 35,
		)
	);

	foreach ( array( 'facebook', 'linkedin', 'twitter', 'youtube', 'instagram' ) as $network ) {
		$wp_customize->add_setting(
			'estatein_social_' . $network,
			array(
				'default'           => $fallbacks[ 'estatein_social_' . $network ],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'estatein_social_' . $network,
			array(
				'label'   => ucfirst( $network ) . ' ' . __( 'URL', 'estatein' ),
				'section' => 'estatein_social',
				'type'    => 'url',
			)
		);
	}

	// --- Homepage hero --------------------------------------------------------
	$wp_customize->add_section(
		'estatein_hero',
		array(
			'title'    => __( 'Homepage Hero', 'estatein' ),
			'priority' => 25,
		)
	);

	$wp_customize->add_setting(
		'estatein_hero_title',
		array(
			'default'           => 'Discover Your Dream Property with Estatein',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'estatein_hero_title',
		array(
			'label'   => __( 'Hero Heading', 'estatein' ),
			'section' => 'estatein_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'estatein_hero_subtitle',
		array(
			'default'           => 'Your journey to finding the perfect property begins here. Explore our listings to find the home that matches your dreams.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'estatein_hero_subtitle',
		array(
			'label'   => __( 'Hero Subheading', 'estatein' ),
			'section' => 'estatein_hero',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'estatein_hero_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'estatein_hero_image',
			array(
				'label'   => __( 'Hero Image (optional, overrides the default building photo)', 'estatein' ),
				'section' => 'estatein_hero',
			)
		)
	);

	$stat_defaults = array(
		'estatein_stat1_number' => '200+',
		'estatein_stat1_label'  => 'Happy Customers',
		'estatein_stat2_number' => '10k+',
		'estatein_stat2_label'  => 'Properties For Clients',
		'estatein_stat3_number' => '16+',
		'estatein_stat3_label'  => 'Years of Experience',
	);
	foreach ( $stat_defaults as $id => $default ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $default,
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => ucwords( str_replace( array( 'estatein_', '_' ), array( '', ' ' ), $id ) ),
				'section' => 'estatein_hero',
				'type'    => 'text',
			)
		);
	}

	// --- Announcement bar -------------------------------------------------
	$wp_customize->add_section(
		'estatein_announcement',
		array(
			'title'    => __( 'Announcement Bar', 'estatein' ),
			'priority' => 20,
		)
	);

	$wp_customize->add_setting(
		'estatein_show_announcement',
		array(
			'default'           => true,
			'sanitize_callback' => 'wp_validate_boolean',
		)
	);
	$wp_customize->add_control(
		'estatein_show_announcement',
		array(
			'label'   => __( 'Show announcement bar', 'estatein' ),
			'section' => 'estatein_announcement',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'estatein_announcement_text',
		array(
			'default'           => 'Discover Your Dream Property with Estatein',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'estatein_announcement_text',
		array(
			'label'   => __( 'Announcement Text', 'estatein' ),
			'section' => 'estatein_announcement',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'estatein_announcement_link',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'estatein_announcement_link',
		array(
			'label'   => __( '"Learn More" Link (optional)', 'estatein' ),
			'section' => 'estatein_announcement',
			'type'    => 'url',
		)
	);

	// --- Footer ---------------------------------------------------------------
	$wp_customize->add_setting(
		'estatein_footer_text',
		array(
			'default'           => $fallbacks['estatein_footer_text'],
			'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control(
		'estatein_footer_text',
		array(
			'label'   => __( 'Footer Copyright Text', 'estatein' ),
			'section' => 'title_tagline',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'estatein_customize_register' );

/**
 * get_theme_mod() only falls back to the default passed at each call site,
 * not the 'default' registered above with add_setting() (that one only
 * feeds the Customizer control itself). Register the same fallbacks here
 * as theme_mod filters so every get_theme_mod( 'estatein_phone' ) call
 * — regardless of where it's called from — resolves correctly even before
 * a site owner has opened the Customizer.
 */
function estatein_theme_mod_fallbacks() {
	return array(
		'estatein_phone'            => '+1 (555) 123-4567',
		'estatein_email'            => 'hello@estatein.com',
		'estatein_address'          => '123 Market Street, Suite 400, San Francisco, CA',
		'estatein_social_facebook'  => 'https://facebook.com/estatein',
		'estatein_social_linkedin'  => 'https://linkedin.com/company/estatein',
		'estatein_social_twitter'   => 'https://twitter.com/estatein',
		'estatein_social_youtube'   => 'https://youtube.com/@estatein',
		'estatein_social_instagram' => 'https://instagram.com/estatein',
		/* translators: %s: current year. */
		'estatein_footer_text'      => sprintf( __( '&copy; %s Estatein. All rights reserved.', 'estatein' ), gmdate( 'Y' ) ),
	);
}

function estatein_register_theme_mod_fallbacks() {
	foreach ( estatein_theme_mod_fallbacks() as $mod_name => $fallback ) {
		add_filter(
			'theme_mod_' . $mod_name,
			function ( $value ) use ( $fallback ) {
				return ( '' === $value || false === $value || null === $value ) ? $fallback : $value;
			}
		);
	}
}
add_action( 'after_setup_theme', 'estatein_register_theme_mod_fallbacks' );
