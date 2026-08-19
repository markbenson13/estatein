<?php
/**
 * FAQ custom post type.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatein_register_faq_cpt() {
	register_post_type(
		'faq',
		array(
			'labels'        => array(
				'name'               => __( 'FAQs', 'estatein' ),
				'singular_name'      => __( 'FAQ', 'estatein' ),
				'add_new_item'       => __( 'Add New FAQ', 'estatein' ),
				'edit_item'          => __( 'Edit FAQ', 'estatein' ),
				'new_item'           => __( 'New FAQ', 'estatein' ),
				'view_item'          => __( 'View FAQ', 'estatein' ),
				'view_items'         => __( 'View FAQs', 'estatein' ),
				'search_items'       => __( 'Search FAQs', 'estatein' ),
				'not_found'          => __( 'No FAQs found', 'estatein' ),
				'not_found_in_trash' => __( 'No FAQs found in Trash', 'estatein' ),
				'all_items'          => __( 'All FAQs', 'estatein' ),
				'menu_name'          => __( 'FAQs', 'estatein' ),
			),
			'description'   => __( "Answers to common questions about Estatein's services, listings, and the real estate process.", 'estatein' ),
			'public'        => true,
			'has_archive'   => 'faq',
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-editor-help',
			'rewrite'       => array( 'slug' => 'faq', 'with_front' => false ),
			'supports'      => array( 'title', 'editor', 'page-attributes' ),
			'menu_position' => 7,
		)
	);
}
add_action( 'init', 'estatein_register_faq_cpt' );

/**
 * Seed the original homepage FAQs as real posts the first time this ships,
 * so existing content carries over instead of disappearing.
 */
function estatein_seed_default_faqs() {
	if ( get_option( 'estatein_faqs_seeded' ) ) {
		return;
	}

	$defaults = array(
		array(
			'question' => 'How do I search for properties on Estatein?',
			'answer'   => 'Learn how to use our user-friendly search tools to find properties that match your criteria.',
		),
		array(
			'question' => 'What documents do I need to sell my property through Estatein?',
			'answer'   => 'Find out about the necessary documentation for listing your property with us.',
		),
		array(
			'question' => 'How can I contact an Estatein agent?',
			'answer'   => 'Discover the different ways you can get in touch with our experienced agents.',
		),
	);

	foreach ( $defaults as $index => $item ) {
		wp_insert_post(
			array(
				'post_type'    => 'faq',
				'post_title'   => $item['question'],
				'post_content' => $item['answer'],
				'post_status'  => 'publish',
				'menu_order'   => $index,
			)
		);
	}

	update_option( 'estatein_faqs_seeded', 1 );
}
add_action( 'after_switch_theme', 'estatein_seed_default_faqs' );
