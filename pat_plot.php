<?php
require_once 'login.php';
require_once 'redir.php';

// Purpose: Run the program for generating the piechart summary plot for patmatmotif output

$img = "/tmp/pat_plot.png"; // generate a new filename each time to get around caching issues

// Remove the file if it already exists, to prevent printing an old image
if (file_exists($img)) {
        unlink($img);
}

// Make sure that if there is no data found, no errors are printed to the screen
if (!$data) {
        echo "<h2 align='center'>PROSITE Motifs</h2>";
        echo "<p align='center'>No data has been selected yet!</p>";
        exit();
}

// Generating the patmatmotifs piechart
$python = __DIR__ . "/directed_learning/bin/python3";

// Generate a string from the necessary motif names
// But make sure that a3.php has been run first
if (!isset($_SESSION['pats'])) {
	header("Location: a3.php");
} else {
	$pats = implode(",",$_SESSION['pats']);
}

// Create and execute the command
$command = escapeshellcmd($python) . " pat_image.py " . escapeshellarg($pats) . " " . escapeshellarg($img);
exec($command);

// Print image to the screen
$img = "/tmp/pat_plot.png";
?>
