<?php
include "pat_plot.php";

// Purpose: read the gap composition histogram in the appropriate format

// Assign the name of the image to a variable
$img = "/tmp/pat_plot.png";

// If the file exists, load and print it, otherwise provide a message to the user that prevents errors
// Reference (Cache Directives): https://www.php.net/manual/en/function.header.php
if (file_exists($img)) {
	header("Content-Type: image/png");
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	readfile($img);
	exit;
} else {
	header("Content-Type: text/plain");
	echo "No plot";
}
?>
