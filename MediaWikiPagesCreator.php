<?php

require __DIR__ . '/vendor/autoload.php';
use Nischayn22\MediaWikiApi;
include( 'settings.php' );

$wikiApi = new MediaWikiApi($settings['wikiApi']);
echo "Logging in to wiki\n";
$wikiApi->login($settings['wikiUser'], $settings['wikiPassword']);

ini_set('auto_detect_line_endings',TRUE);
if (($handle = fopen(__DIR__ . "/" . $settings['csv_file'], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {

		$name = trim( $data[0] );

		if ( empty( $name ) ) {
			break;
		}

		if ( !$wikiApi->createPage( $name, "This is a placeholder page. Please add real content." ) ) {
			echo "Could not create page $name Error: ". $wikiApi->getLastError() ."\n";
			continue;
		} else {
			echo "Created page $name\n";
		}
	}
}
