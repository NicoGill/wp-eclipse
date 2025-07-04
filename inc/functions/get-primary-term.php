<?php
/**
 * Function : Get primary term for given post ID. Default to category.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

use WP_Term;

if ( ! function_exists( 'get_primary_term' ) ) {
	/**
	 * Get primary term for post.
	 *
	 * @param integer $post_id Which post to get the primary term for, if empty current post is used.
	 * @param string $taxonomy From which taxonomy to get the term from, defaults to term.
	 *
	 * @return false|WP_Term Boolean false of no term, otherwise WP_Term object.
	 *
	 */
	function get_primary_term(int $post_id = 0, string $taxonomy = 'category' ) : false|WP_Term
	{
		$post_id = ! empty( $post_id ) ? $post_id : get_the_id();

		$primary_meta_keys = [
			'_yoast_wpseo_primary_' . $taxonomy, // Primary term from Yoast setting
			'_primary_term_' . $taxonomy, // Autodescription primary term setting
		];

		$cat_id = null;

		// Try to get the primary term id from meta fields
		foreach ( $primary_meta_keys as $primary_meta_key ) {
			$maybe_cat_id = get_post_meta( $post_id, $primary_meta_key, true );
			if ( ! empty( $maybe_cat_id ) ) {
				$cat_id = $maybe_cat_id;
				break;
			}
		}

		// If primary set, try to get and return WP_Term object for it
		$term = ! empty( $cat_id ) ? get_term( $cat_id, $taxonomy ) : false;

		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			return $term;
		}

		// No primary term, get all post terms and return first one
		$cats = wp_get_post_terms( $post_id, $taxonomy );

		if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
			return $cats[0];
		}

		return false;
	} // end get_primary_term
} // end if
