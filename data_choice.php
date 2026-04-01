<?php
session_start();
require_once 'login.php';

// Purpose: save and process user data selections
// Saves POST actions as SESSION variables to be used throughout the website

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['family']) || isset($_POST['protein'])) {
		header("Location: home.php");
		$_SESSION['message1'] = 'Please specify both a family and a protein';
	}
	if (isset($_POST['family']) && $_POST['family'] != '' && isset($_POST['protein']) && $_POST['protein'] != '') {
		$_SESSION['selection'] = 'search';
		$_SESSION['family'] = $_POST['family'];
		$_SESSION['protein'] = $_POST['protein'];
		header("Location: search.php");
		// Begin executing the tree code
		// exec("php phylo_tree.php > /dev/null 2>&1 &");
		exit();
	} 
	if (isset($_POST['old_search'])) {
		$_SESSION['selection'] = 'old';
		header("Location: home.php");
		// exec("php phylo_tree.php > /dev/null 2>&1 &");
		exit();
	}
	if (isset($_POST['example_data'])) {
		$_SESSION['selection'] = 'example';
		header("Location: home.php");
		// exec("php phylo_tree.php > /dev/null 2>&1 &");
		exit();
	}
}

// header("Location: home.php");
// exit();
?>
