<?php
/**
 * Print the link for the current post primary category.
 * The link is not the wp archive link but filtered blog page link.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

/**
 * Print the taxonomies associated with a post.
 *
 * @param int $post_id The ID of the post.
 * @author WebDevStudios
 */
function print_post_category_link( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$category = get_primary_category( $post_id, 'category' );

	if ( $category ) {
		$blog_page     = get_option( 'page_for_posts' );
		$blog_url      = get_permalink( $blog_page );
		$category_slug = $category->slug;
		$category_name = $category->name;
		$url           = add_query_arg( 'categorie', $category_slug, $blog_url );
		?>
		<a class="teaser-post__category" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $category_name ); ?></a>
		<?php
	}
}
