<?php

// Purpose: read the conservation plot in the appropriate format

$img = "/tmp/plotcon.1.png";

if (file_exists($img)) {
	header("Content-Type: image/png");
	readfile($img);
	exit;
} else {
	header("Content-Type: text/plain");
	echo "No plot";
}
?>
