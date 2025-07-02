<?php
/**
 * Displays numeric pagination on archive pages.
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

use WP_Query;

/**
 * Displays numeric pagination on archive pages.
 *
 * @param WP_Query|null $query The Query object; only passed if a custom WP_Query is used.
 * @param array $args Array of params to customize output.
 *
 * @return void
 */
function print_numeric_pagination(?WP_Query $query = null, array $args = []): void
{
	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}

	// Make the pagination work on custom query loops.
	$total_pages = $query->max_num_pages ?? 1;

	// Set defaults.
	$defaults = [
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
		'mid_size'  => 4,
		'total'     => $total_pages,
	];

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	if ( null === paginate_links( $args ) ) {
		return;
	}
	?>

	<div class="is-layout-constrained has-global-padding">
		<nav class="pagination-container" aria-label="<?php esc_attr_e( 'numeric pagination', 'wp_eclipse' ); ?>">
			<?php echo paginate_links( $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- XSS OK. ?>
		</nav>
	</div>

	<?php
}
