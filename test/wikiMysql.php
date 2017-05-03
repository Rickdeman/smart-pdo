<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Bootstrap 101 Template</title>
		<!-- Bootstrap -->
		<link href="/bootsdo/assets/components/bootstrap/css/bootstrap.css" rel="stylesheet">
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>
		<script src="/bootsdo/assets/components/bootsdo/js/bootsdo.js" type="text/javascript"></script>
		<link href="/bootsdo/assets/components/bootsdo/css/bootsdo.css" rel="stylesheet">
	</head>
	<body style="padding-top: 120px;">
<?php
use SmartPDO\Config;

/**
 * File: wikiMysql.php
 */
require_once __DIR__ . '/../vendor/autoload.php';
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
?>
	</body>
</html>