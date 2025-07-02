<?php
/**
 * Edit link
 *
 * This function shows edit links.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

function print_edit_link() {

	global $post;

	if ( ! isset( $post->ID ) ) {
		return;
	}

	$edit_link = '';

	if ( is_singular() ) {

		if ( ! get_edit_post_link() ) {
			return;
		}

		$edit_link = get_edit_post_link( $post );

	} elseif ( is_tax() ) {
		$object    = get_queried_object();
		$edit_link = get_edit_term_link( $object );

	} elseif ( is_home() ) {
		$page_for_posts = get_option( 'page_for_posts' );
		$edit_link      = get_edit_post_link( $page_for_posts );
	}

	if ( ! $edit_link ) {
		return;
	} ?>

	<div class="edit-link">
		<a href="<?php echo esc_url( $edit_link ); ?>">
				<?php esc_html_e( 'Modifier', 'wp_eclipse' ); ?>
			</a>
		</div>
	<?php
}
