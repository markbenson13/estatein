<?php
/**
 * Themed search form.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="site-search-form d-flex gap-2 mt-3 justify-content-center" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="site-search-input" class="visually-hidden"><?php esc_html_e( 'Search for:', 'estatein' ); ?></label>
	<input type="search" id="site-search-input" name="s" class="form-control" style="max-width:280px;" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search…', 'estatein' ); ?>" />
	<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'estatein' ); ?></button>
</form>
