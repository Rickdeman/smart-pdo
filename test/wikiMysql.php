<?php
use SmartPDO\Config;

/**
 * File: wikiMysql.php
 */
require_once __DIR__ . '/../vendor/autoload.php';
header ( "Content-Type: text/plain" );
Config::$readOnly = true;
/**
 * SmartPDO MySQL handler
 *
 * @var \SmartPDO\MySQL $MySQL
 */
$MySQL = new \SmartPDO\MySQL ( "smartpdo", "PvZZMGeeAp0UPtC4", "smartpdo", "spdo" );

/**
 *
 * @var FilesystemIterator $it
 */
$it = new FilesystemIterator ( __DIR__ . "/wiki", FilesystemIterator::SKIP_DOTS );

$id = "";
$counter = 0;
foreach ( $it as $fileinfo ) {
	$Method = preg_replace ( '/(_[0-9]{1,}){0,1}(.[a-z]{1,3})$/', '', $fileinfo->getFilename () );
	if ($id == "" || $Method != $id) {
		$id = $Method;
		$counter = 0;
	}
	$counter ++;
	echo "# " . $Method . " - " . $counter . PHP_EOL . PHP_EOL;
	echo "Code: " . PHP_EOL . PHP_EOL;

	echo str_replace ( "\n", "\n\t", "\t" . file_get_contents ( $fileinfo->getRealPath () ) );

	echo PHP_EOL . PHP_EOL . "Result: " . PHP_EOL . PHP_EOL;

	$output = ob_get_contents ();
	ob_clean ();

	require_once $fileinfo->getRealPath ();

	$script = ob_get_contents ();
	ob_clean ();

	echo $output;
	echo str_replace ( "\n", "\n\t", "\t" . $script ) . PHP_EOL . PHP_EOL;
}