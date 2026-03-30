<?php
require_once 'login.php';
require_once 'redir.php';

$img = "/tmp/pat_plot.png"; // generate a new filename each time to get around caching issues

// echo "<pre>";
// echo $img;
// echo "</pre>";

if (file_exists($img)) {
        unlink($img);
}

if (!$data) {
        echo "<h2 align='center'>PROSITE Motifs</h2>";
        echo "<p align='center'>No data has been selected yet!</p>";
        exit();
}

// Generating the amino acid heatmap
$python = __DIR__ . "/directed_learning/bin/python3";

// Generate a string from the necessary motif names
// But make sure that a3.php has been run first
if (!isset($_SESSION['pats'])) {
	header("Location: a3.php");
} else {
	$pats = implode(",",$_SESSION['pats']);
}

$command = escapeshellcmd($python) . " pat_image.py " . escapeshellarg($pats) . " " . escapeshellarg($img);
// echo "<pre>";
// echo $command;
// echo "</pre>";
exec($command);
//file_put_contents($img, $heat)

// Print image to the screen
$img = "/tmp/pat_plot.png";
?>
