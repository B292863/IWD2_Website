<?php
session_start();
// require_once 'login.php';
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

$tmpfa = '/tmp/search_fasta.fa';
if (file_exists($tmpfa)) {
	unlink($tmpfa);
}

if (isset($_SESSION['selection']) && $_SESSION['selection'] === 'search') {

	// echo "Running NCBI search for " . $_SESSION['protein'] . " in " . $_SESSION['family'];

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

	// Troubleshooting
	// var_dump($family);
	// var_dump($protein);
	//$family = "Homo sapiens";
        //$protein = "insulin";

	// Alternate Option exec(): https://www.geeksforgeeks.org/php/php-shell_exec-vs-exec-function/
	// $command = escapeshellcmd("$python data_extractor.py 'Homo sapiens' 'insulin'");
	$command = escapeshellcmd($python) . " data_extractor.py " . $family . " " . $protein; 

	$ncbi = shell_exec($command);
	// echo "<pre>";
	// echo $ncbi;
	// echo "</pre>";
	file_put_contents($tmpfa, $ncbi);
	
	// Check file was generated: https://www.w3schools.com/php/func_filesystem_file_exists.asp
        // https://stackoverflow.com/questions/43027624/php-wait-for-file-to-exist
	$start_time = time();
        while (!file_exists($tmpfa)) {
                // Kill if takes too long
                if(time() - $start_time > 100) {
                        die("Took too long");
                }
		sleep(1);
	}
	// var_dump(trim($ncbi));
	// exit();
	if (trim($ncbi) == "EMPTY") {
		$_SESSION['message'] = "NCBI search generated 0 results";
		header("Location: home.php");
		exit();
	}

$_SESSION['search_message'] = 'Results Generated!';
header("Location: data_sql.php");
exit();
}
?>
