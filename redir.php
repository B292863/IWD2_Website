<?php
if (session_status() === PHP_SESSION_NONE) {
        session_start();
}
require_once 'login.php';

// Purpose: select the dataset that is used in the rest of the web pages

$data = null; // default (for errors)

// Selecting the data
if (isset ($_SESSION['selection'])) {
        if ($_SESSION['selection'] == 'search') {
                $data = $_SESSION['table'] ?? null;
        } else if ($_SESSION['selection'] == 'old') {
                $data = $_SESSION['previous'];
        } else if ($_SESSION['selection'] == 'example') {
                $data = 'Example_Data';
        }
} else {
	header("Location: home.php");
	exit();
}

?>
