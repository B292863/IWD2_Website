<?php
// Purpose: read the gap composition histogram in the appropriate format

// Name and location of image
$img = "/tmp/gaps_hist.png";

// Print image
// Reference (Cache Directives): https://www.php.net/manual/en/function.header.php
if (file_exists($img)) {
	header("Content-Type: image/png");
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");
	readfile($img);
	exit;
} else {
	header("Content-Type: text/plain");
	echo "No plot";
}
?>
