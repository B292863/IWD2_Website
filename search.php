<?php
session_start();
require_once 'redir.php';

// Purpose: conduct search through NCBI, add the data to a MySQL data table

// Check that session variables are indeed set
if (
	!isset($_SESSION['selection']) ||
	$_SESSION['selection'] !== 'search' ||
        !isset($_SESSION['protein']) ||
	!isset($_SESSION['family'])
) {
	header('Location: home.php');
	exit();
}

# Name and location of output fasta
$tmpfa = '/tmp/search_fasta.fa';

# Remove old files so it won't be used in analyses
if (file_exists($tmpfa)) {
	unlink($tmpfa);

}

# Only run the search if the user selected search options
if (isset($_SESSION['selection']) && $_SESSION['selection'] === 'search') {


	// NCBI Search
	$descriptorspec = array(
	    0 => array("pipe", "r"), // stdin
	    1 => array("pipe", "w"), // stdout
	    2 => array("pipe", "w") // stderrors
	);

	// Extracting the necessary global variables
	$family = escapeshellarg($_SESSION['family']);
	$protein = escapeshellarg($_SESSION['protein']);
	$script = __DIR__ . "/data_extractor.py";
	$python = __DIR__ . "/directed_learning/bin/python3";

	// Conduct non-stringent search
	if (!empty($_SESSION['stringent'])) {
		$stringent = escapeshellarg($_SESSION['stringent']);
		$command = escapeshellcmd($python) . " data_extractor.py " . $family . " " . $protein . " " . $stringent;
		// Unset the 'stringent' variable after the search has been made
		// unset($_SESSION['stringent']);
	} else {	
		// Conduct stringent search
		// Alternate Option exec(): https://www.geeksforgeeks.org/php/php-shell_exec-vs-exec-function/
		$command = escapeshellcmd($python) . " data_extractor.py " . $family . " " . $protein; 
	}
	
	// Run command and put outputs in a file
	$ncbi = shell_exec($command);
	file_put_contents($tmpfa, $ncbi);

	// Check that file was generated: https://www.w3schools.com/php/func_filesystem_file_exists.asp
	// https://stackoverflow.com/questions/43027624/php-wait-for-file-to-exist
	$start_time = time();
        while (!file_exists($tmpfa)) {
                // Kill if takes too long
                if(time() - $start_time > 100) {
                        die("Took too long");
                }
		sleep(1);
	}
	
	// If the number of requests to NCBI have been exceeded return this message to the  
	if (is_null($ncbi)) {
		$_SESSION['message'] = "NCBI requests have been exceeded. Please try again later.";
		header("Location: home.php");
		exit();
	}

	// Check if the search returned no results
	// Reference: https://www.php.net/manual/en/function.is-null.php
	if (trim($ncbi) == "EMPTY") { //is_null($ncbi) || 
		$_SESSION['message'] = "NCBI search generated 0 results";
		header("Location: home.php");
		exit();
	}

$_SESSION['search_message'] = 'Results Generated!';
header("Location: data_sql.php");
exit();
}
?>
