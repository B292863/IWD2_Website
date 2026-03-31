<?php

// Purpose: Read/Extract the conservation plot in the appropriate format

// Name of the conservation plot file
$img = "/tmp/plotcon.1.png";

// Verify that the file exists, and if it does, print the image to the screen
if (file_exists($img)) {
	header("Content-Type: image/png");
	readfile($img);
	exit;
} else {
	header("Content-Type: text/plain");
	echo "No plot";
}
?>
