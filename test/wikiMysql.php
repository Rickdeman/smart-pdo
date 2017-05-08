<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>SmartPdo Test</title>
<!-- Bootstrap -->
<link href="https://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://getbootstrap.com/assets/css/docs.min.css"
	rel="stylesheet">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"
	type="text/javascript"></script>
<script src="../vendor/highlight.pack.js" type="text/javascript"></script>
<link href="../vendor/styles/tomorrow.css" rel="stylesheet">


</head>
<body style="padding-top: 120px;">
	<div class="container">
		<div class="row">
			<div class="col-md-9">

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
$methods = array ();
foreach ( $it as $fileinfo ) {
	$Method = preg_replace ( '/(_[0-9]{1,}){0,1}(.[a-z]{1,3})$/', '', $fileinfo->getFilename () );
	if ($id == "" || $Method != $id) {
		$id = $Method;
		echo "<h1 id='$Method'>" . $Method . "</h1>" . PHP_EOL;
		$counter = 0;
		$methods [$Method] = array ();
	}
	$counter ++;

	$code = file_get_contents ( $fileinfo->getRealPath () );
	if (preg_match ( '/^\$desc = "(.+).?";/m', $code, $matches )) {
		$methods [$Method] [] = $matches [1];
		$code = preg_replace ( '/^\$desc = "(.+).?";/m', '', $code );
	} else {
		$methods [$Method] [] = "N/A";
	}

	echo "<div style='margin-bottom:10px;' id='$Method-" . ($counter - 1) . "'><h2>" . end (
			$methods [$Method] ) . "</h2></div>" . PHP_EOL . PHP_EOL;
	echo '<pre><code class="php" style="background: none;">' . htmlentities ( $code ) . "</code></pre>";
	// echo str_replace ( "\n", "\n\t", "\t" . file_get_contents ( $fileinfo->getRealPath () ) );

	echo PHP_EOL . PHP_EOL . "<div style='margin-bottom:10px;'>Result</div> " . PHP_EOL . PHP_EOL;

	$output = ob_get_contents ();
	ob_clean ();

	require_once $fileinfo->getRealPath ();

	$script = ob_get_contents ();
	ob_clean ();

	echo $output;
	echo '<pre>' . $script . "</pre>" . PHP_EOL . PHP_EOL;
	// echo str_replace ( "\n", "\n\t", "\t" . $script ) . PHP_EOL . PHP_EOL;
}
?>
				</div>

			<div class="col-md-3">
				<nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs affix">
					<ul class="nav bs-docs-sidenav">
<?php

foreach ( $methods as $m => $v ) {
	?>
						<li>
							<a href="#<?=$m?>"><?=$m?></a>
							<ul class="nav">
<?php

	foreach ( $v as $k => $desc ) {
		?>
								<li>
									<a href="#<?=$m?>-<?=$k?>"><?=$desc?></a>
								</li>
<?php
	}
	?>
							</ul>
						</li>
<?php
}
?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<script>hljs.initHighlightingOnLoad();</script>
	<script src=https://getbootstrap.com/dist/js/bootstrap.min.js></script>
	<script src=https://getbootstrap.com/assets/js/docs.min.js></script>
</body>
</html>