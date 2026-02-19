<?php
/**
 * Unregister Gutenberg blocks
 *
 * @package wp_eclipse
 */

namespace NicoGill\wp_eclipse;

function unregister_custom_blocks( $allowed_blocks, $editor_context ) {
	$blocks = array_keys( \WP_Block_Type_Registry::get_instance()->get_all_registered() );

	$blacklist = [
		'core/archives',
		'core/avatar',
		'core/calendar',
		'core/categories',
		'core/code',
		'core/comment-author-name',
		'core/comment-content',
		'core/comment-date',
		'core/comment-edit-link',
		'core/comment-template',
		'core/comment-reply-link',
		'core/comments',
		'core/comments-form',
		'core/comments-pagination',
		'core/footnotes',
		'core/missing',
		'core/query',
		'core/query-no-results',
		'core/query-pagination',
		'core/query-pagination-next',
		'core/query-pagination-numbers',
		'core/query-pagination-previous',
		'core/query-title',
		'core/latest-posts',
		'core/page-list',
		'core/page-list-item',
		'core/post-author',
		'core/post-author-biography',
		'core/post-author-name',
		'core/post-excerpt',
		'core/post-navigation-link',
		'core/post-template',
		'core/post-comments-form',
		'core/preformatted',
		'core/read-more',
		'core/rss',
		'core/site-tagline',
		'core/site-title',
		'core/loginout',
		'core/navigation',
		'core/navigation-link',
		'core/tag-cloud',
		'core/term-description',
		'core/verse',
		'core/search',
	];

	return array_values( array_diff( $blocks, $blacklist ) );
}
add_filter( 'allowed_block_types_all', __NAMESPACE__ . '\unregister_custom_blocks', 100, 2 );
