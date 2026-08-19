<?php
/**
 * Minimal on-page SEO: meta description, canonical URL, Open Graph and
 * Twitter Card tags. Deliberately hand-rolled rather than pulling in a full
 * SEO plugin, per the project's "avoid unnecessary plugin dependencies"
 * requirement — WP core already handles the <title> tag via the
 * 'title-tag' theme support declared in functions.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plain-text, length-capped description for the current view.
 * Falls back through: explicit excerpt -> post content -> term/post-type
 * archive description -> site tagline.
 */
function estatein_seo_description() {
	$text = '';

	if ( is_front_page() ) {
		$text = get_theme_mod( 'estatein_hero_subtitle', '' );
	} elseif ( is_singular() ) {
		$text = has_excerpt() ? get_the_excerpt() : get_the_content();
	} elseif ( is_post_type_archive() ) {
		$text = post_type_archive_title( '', false );
		$obj  = get_post_type_object( get_query_var( 'post_type' ) );
		if ( $obj && ! empty( $obj->description ) ) {
			$text = $obj->description;
		}
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$text = term_description();
	} elseif ( is_search() ) {
		$text = sprintf( __( 'Search results for "%s" on', 'estatein' ), get_search_query() ) . ' ' . get_bloginfo( 'name' );
	}

	$text = wp_strip_all_tags( strip_shortcodes( (string) $text ) );
	$text = trim( preg_replace( '/\s+/', ' ', $text ) );

	if ( '' === $text ) {
		$text = get_bloginfo( 'description' );
	}

	return wp_trim_words( $text, 30, '…' );
}

/**
 * Absolute URL for the social-share image of the current view.
 * Falls back through: featured image -> hero image -> site logo.
 */
function estatein_seo_image() {
	if ( is_singular() && has_post_thumbnail() ) {
		$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		if ( $src ) {
			return $src[0];
		}
	}

	$hero_image = get_theme_mod( 'estatein_hero_image' );
	if ( $hero_image ) {
		return $hero_image;
	}

	if ( has_custom_logo() ) {
		$logo_id  = get_theme_mod( 'custom_logo' );
		$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );
		if ( $logo_src ) {
			return $logo_src[0];
		}
	}

	return ESTATEIN_URI . '/assets/images/estatein-logo.png';
}

/**
 * The canonical URL for the current view, using WP core's own resolver
 * where possible so paginated/query-string edge cases stay correct.
 */
function estatein_seo_canonical_url() {
	if ( is_front_page() ) {
		return home_url( '/' );
	}

	/*
	 * wp_get_canonical_url() with no argument falls back to the global
	 * $post — which WordPress also populates with the archive's first
	 * result, not just on true singular views. Only trust it when we're
	 * actually on a singular view, or it'll return that first post's URL
	 * for archive/search/taxonomy pages instead of the archive's own URL.
	 */
	if ( is_singular() ) {
		$canonical = wp_get_canonical_url();
		if ( $canonical ) {
			return $canonical;
		}
	}

	global $wp;
	return user_trailingslashit( home_url( add_query_arg( array(), $wp->request ) ) );
}

/**
 * Output <meta name="description">, canonical link, Open Graph and
 * Twitter Card tags for every front-end view.
 */
function estatein_output_seo_meta() {
	if ( is_admin() ) {
		return;
	}

	$description = estatein_seo_description();
	$canonical   = estatein_seo_canonical_url();
	$image       = estatein_seo_image();
	$title       = wp_get_document_title();
	$site_name   = get_bloginfo( 'name' );
	$og_type     = is_singular( array( 'post', 'property' ) ) ? 'article' : 'website';
	?>
	<meta name="description" content="<?php echo esc_attr( $description ); ?>" />
	<?php
	/*
	 * WP core's rel_canonical() already prints a canonical <link> for
	 * singular views (wp_get_canonical_url() only returns non-empty there),
	 * so only add our own for front page / archives / search, which core
	 * leaves uncovered.
	 */
	if ( ! is_singular() ) :
		?>
		<link rel="canonical" href="<?php echo esc_url( $canonical ); ?>" />
	<?php endif; ?>

	<meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>" />
	<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>" />
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>" />
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>" />
	<meta property="og:url" content="<?php echo esc_url( $canonical ); ?>" />
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>" />

	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>" />
	<meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>" />
	<meta name="twitter:image" content="<?php echo esc_url( $image ); ?>" />
	<?php
}
add_action( 'wp_head', 'estatein_output_seo_meta', 1 );
