<?php
if (!array_key_exists('HTTP_REFERER', $_SERVER)) {
	print "invalid referer";
	exit;
}
$referer =  $_SERVER['HTTP_REFERER'];
$hostname = $_SERVER['HTTP_HOST'];
if (!strstr($referer, $hostname)) {
    print "invalid referer";
	exit;
}
$_GET['f'] = str_replace("|", "/", $_GET['f']);
$_GET['f'] = str_replace("resize=150%2C150&", "", $_GET['f']);

header("Content-Type: image/png");
readfile($_GET['f']);
exit;
?>