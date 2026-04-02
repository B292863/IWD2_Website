<?php
session_start();
require_once 'login.php';

// Purpose: save and process user data selections
// Saves POST actions as SESSION variables to be used throughout the website

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// If the user did not select both required inputs, return a message to the screen
	if ((empty($_POST['family']) || empty($_POST['protein'])) && !isset($_POST['old_search']) && !isset($_POST['example_data'])) {
		$_SESSION['message1'] = 'Please specify both a family and a protein';
		header("Location: home.php");
		exit();
	}
	// If the user created a search, save the search terms into session variables
	if (isset($_POST['family']) && $_POST['family'] != '' && isset($_POST['protein']) && $_POST['protein'] != '') {
		$_SESSION['selection'] = 'search';
		$_SESSION['family'] = $_POST['family'];
		$_SESSION['protein'] = $_POST['protein'];
		if (isset($_POST['string'])) {
			$_SESSION['stringent'] = 'stringent';
		}
		header("Location: search.php");
		exit();
	} 
	// If the user selected one of the previous search options, that data selection is saved
	if (isset($_POST['old_search'])) {
		$_SESSION['selection'] = 'old';
		$_SESSION['previous'] = $_POST['table_name'];
		header("Location: home.php");
		exit();
	}
	// If the user chose the example data, that data selection is saved
	if (isset($_POST['example_data'])) {
		$_SESSION['selection'] = 'example';
		header("Location: home.php");
		exit();
	}
}
?>
