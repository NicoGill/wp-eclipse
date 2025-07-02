<?php
/**
 * Print the link for the current post primary category.
 * The link is not the wp archive link but filtered blog page link.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Print the first category associated with a post.
 *
 * @param int $post_id The ID of the post.
 * @param string $taxonomy
 */
function print_post_primary_term_link(int $post_id = 0, string $taxonomy = 'category' ): void
{
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$term = get_primary_term( $post_id, $taxonomy );

	if ( $term ) {
		$term_name 	= $term->name;
		$url 		= get_term_link( $term );

		if( !empty($url) && !is_wp_error($url)) :
			echo sprintf(
				'<a href="%s">%s</a>',
				esc_url($url),
				esc_html($term_name)
			);
		endif;
	}
}
