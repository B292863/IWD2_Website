<?php
include 'phylo_tree.php';

// Purpose: read the phylogenetic tree in the appropriate format

$img = "/tmp/tree.png";

if (file_exists($img)) {
	header("Content-Type: image/png");
        //header("Cache-Control: no-cache, no-store, must-revalidate");
        //header("Pragma: no-cache");
        //header("Expires: 0");
	readfile($img);
	exit;
} else {
	header("Content-Type: text/plain");
	echo "No plot";
}
?>
