<?php
/**
 * Estatein theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ESTATEIN_VERSION', '1.0.0' );
define( 'ESTATEIN_DIR', get_template_directory() );
define( 'ESTATEIN_URI', get_template_directory_uri() );

require ESTATEIN_DIR . '/inc/cpt-property.php';
require ESTATEIN_DIR . '/inc/meta-boxes.php';
require ESTATEIN_DIR . '/inc/customizer.php';
require ESTATEIN_DIR . '/inc/template-tags.php';
require ESTATEIN_DIR . '/inc/forms.php';

/**
 * Theme setup.
 */
function estatein_setup() {
	load_theme_textdomain( 'estatein', ESTATEIN_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 60,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	set_post_thumbnail_size( 800, 600, true );
	add_image_size( 'estatein-card', 640, 480, true );
	add_image_size( 'estatein-hero', 1600, 900, true );
	add_image_size( 'estatein-gallery-thumb', 200, 150, true );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'estatein' ),
			'footer'  => __( 'Footer Menu', 'estatein' ),
		)
	);
}
add_action( 'after_setup_theme', 'estatein_setup' );

/**
 * Front-end scripts and styles.
 */
function estatein_scripts() {
	wp_enqueue_style( 'estatein-fonts', 'https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap', array(), null );
	wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3' );
	wp_enqueue_style( 'estatein-style', get_stylesheet_uri(), array( 'bootstrap' ), ESTATEIN_VERSION );
	wp_enqueue_script( 'bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), '5.3.3', true );
	wp_enqueue_script( 'estatein-main', ESTATEIN_URI . '/assets/js/main.js', array( 'bootstrap-bundle' ), ESTATEIN_VERSION, true );

	if ( is_singular( 'property' ) ) {
		wp_enqueue_script( 'estatein-single-property', ESTATEIN_URI . '/assets/js/single-property.js', array( 'bootstrap-bundle' ), ESTATEIN_VERSION, true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'estatein_scripts' );

/**
 * Tag primary/footer menu items with Bootstrap's nav-item/nav-link classes
 * so wp_nav_menu() output drops straight into a Bootstrap navbar.
 */
function estatein_bootstrap_nav_classes( $classes, $item, $args ) {
	if ( isset( $args->theme_location ) && in_array( $args->theme_location, array( 'primary', 'footer' ), true ) ) {
		$classes[] = 'nav-item';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'estatein_bootstrap_nav_classes', 10, 3 );

function estatein_bootstrap_nav_link_attributes( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && in_array( $args->theme_location, array( 'primary', 'footer' ), true ) ) {
		$class          = ( 'primary' === $args->theme_location ) ? 'nav-link' : 'link-light text-decoration-none';
		$atts['class']  = isset( $atts['class'] ) ? $atts['class'] . ' ' . $class : $class;
		if ( 'primary' === $args->theme_location && in_array( 'current-menu-item', $item->classes, true ) ) {
			$atts['class'] .= ' active';
			$atts['aria-current'] = 'page';
		}
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'estatein_bootstrap_nav_link_attributes', 10, 3 );

/**
 * Admin scripts for the Property edit screen (media uploader for the gallery meta box).
 */
function estatein_admin_scripts( $hook ) {
	global $post_type;

	if ( 'property' === $post_type && in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'estatein-admin', ESTATEIN_URI . '/assets/css/admin.css', array(), ESTATEIN_VERSION );
		wp_enqueue_script( 'estatein-admin-property', ESTATEIN_URI . '/assets/js/admin-property.js', array( 'jquery' ), ESTATEIN_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'estatein_admin_scripts' );

/**
 * Widget areas.
 */
function estatein_widgets_init() {
	$common = array(
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);

	register_sidebar( array_merge( $common, array(
		'name' => __( 'Blog Sidebar', 'estatein' ),
		'id'   => 'sidebar-blog',
	) ) );

	register_sidebar( array_merge( $common, array(
		'name' => __( 'Property Sidebar', 'estatein' ),
		'id'   => 'sidebar-property',
	) ) );

	register_sidebar( array_merge( $common, array(
		'name' => __( 'Footer Column 1', 'estatein' ),
		'id'   => 'footer-1',
	) ) );

	register_sidebar( array_merge( $common, array(
		'name' => __( 'Footer Column 2', 'estatein' ),
		'id'   => 'footer-2',
	) ) );
}
add_action( 'widgets_init', 'estatein_widgets_init' );

/**
 * Fallback menu when no "Primary Menu" has been assigned yet.
 */
function estatein_fallback_menu() {
	$links = array(
		'/'            => __( 'Home', 'estatein' ),
		'/about/'      => __( 'About Us', 'estatein' ),
		'/properties/' => __( 'Properties', 'estatein' ),
		'/services/'   => __( 'Services', 'estatein' ),
	);

	echo '<ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0 gap-lg-1">';
	foreach ( $links as $path => $label ) {
		$url      = home_url( $path );
		$is_home  = ( '/' === $path && is_front_page() );
		$is_match = $is_home || ( '/' !== $path && untrailingslashit( $_SERVER['REQUEST_URI'] ?? '' ) === untrailingslashit( wp_make_link_relative( $url ) ) );
		printf(
			'<li class="nav-item"><a class="nav-link%1$s" href="%2$s">%3$s</a></li>',
			$is_match ? ' active' : '',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</ul>';
}

/**
 * Excerpt tweaks.
 */
function estatein_excerpt_length( $length ) {
	return 24;
}
add_filter( 'excerpt_length', 'estatein_excerpt_length' );

function estatein_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'estatein_excerpt_more' );
