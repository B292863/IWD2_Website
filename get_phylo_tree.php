<?php
include 'phylo_tree.php';

// Purpose: read the phylogenetic tree in the appropriate format

// Name and logation of image file
$img = "/tmp/tree.png";

// If the file exists, extract and print it, if not print a message about the failure to the screen (prevent error)
if (file_exists($img)) {
	header("Content-Type: image/png");
	readfile($img);
	exit;
} else {
	header("Content-Type: text/plain");
	echo "No plot";
}
?>
