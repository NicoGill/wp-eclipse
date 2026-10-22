<?php
/**
 * Build the release archive: dist/<slug>.<version>.zip with every file of the
 * theme except the entries of .distignore. Run after `npm run build`.
 *
 * shortcut: .distignore entries are matched as "/path" prefixes only, no globs;
 * upgrade if an entry needs a wildcard.
 */

$root    = dirname( __DIR__ );
$slug    = basename( $root );
$version = preg_match( '/^Version:\s*(.+)$/m', file_get_contents( "$root/style.css" ), $m ) ? trim( $m[1] ) : 'dev';
$target  = "$root/dist/$slug.$version.zip";

$ignored = array_filter(
	array_map( 'trim', file( "$root/.distignore" ) ),
	fn( $line ) => '' !== $line && '#' !== $line[0]
);
$is_ignored = function ( string $relative ) use ( $ignored ): bool {
	foreach ( $ignored as $entry ) {
		$entry = ltrim( $entry, '/' );
		if ( $relative === $entry || str_starts_with( $relative, "$entry/" ) ) {
			return true;
		}
	}
	return false;
};

if ( ! is_dir( "$root/dist" ) ) {
	mkdir( "$root/dist" );
}
$zip = new ZipArchive();
if ( true !== $zip->open( $target, ZipArchive::CREATE | ZipArchive::OVERWRITE ) ) {
	fwrite( STDERR, "Cannot write $target\n" );
	exit( 1 );
}

$count = 0;
$files = new RecursiveIteratorIterator(
	new RecursiveCallbackFilterIterator(
		new RecursiveDirectoryIterator( $root, FilesystemIterator::SKIP_DOTS ),
		fn( $file ) => ! $is_ignored( str_replace( DIRECTORY_SEPARATOR, '/', substr( $file->getPathname(), strlen( $root ) + 1 ) ) )
	)
);
foreach ( $files as $file ) {
	if ( $file->isFile() ) {
		$relative = str_replace( DIRECTORY_SEPARATOR, '/', substr( $file->getPathname(), strlen( $root ) + 1 ) );
		$zip->addFile( $file->getPathname(), "$slug/$relative" );
		++$count;
	}
}
$zip->close();
echo "$count files -> dist/$slug.$version.zip (" . round( filesize( $target ) / 1024 ) . " KB)\n";
