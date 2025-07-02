<?php
/**
 * Global Actions hooks.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Flush out the transients used in wp_eclipse_categorized_blog.
 *
 * @author WebDevStudios
 *
 * @return bool Whether or not transients were deleted.
 */
function category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return false;
	}

	// Like, beat it. Dig?
	return delete_transient( 'wp_eclipse_categories' );
}

add_action( 'delete_category', __NAMESPACE__ . '\category_transient_flusher' );
add_action( 'save_post', __NAMESPACE__ . '\category_transient_flusher' );

/**
 * Filter the machine and post archive query and handle categorie filter.
 */
function pre_get_post_archive( $query ) {

	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\pre_get_post_archive' );
