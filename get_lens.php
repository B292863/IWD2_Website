<?php
// include redir.php;
// include "aa_heat.php";
// Purpose: read the sequence length distributions in the appropriate format

$img = "/tmp/lens_hist.png";

// echo "<pre>";
// echo $img;
// echo "</pre>";

// Reference (Cache Directives): https://www.php.net/manual/en/function.header.php
if (file_exists($img)) {
	header("Content-Type: image/png");
	header("Cache-Control: no-cache, no-store, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");
	//echo "<pre>";
	//echo $img;
	//echo "</pre>";
	readfile($img);
	// fetch("aa_heat.php);
	exit;
} else {
	header("Content-Type: text/plain");
	echo "No plot";
}
?>
