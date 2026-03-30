<?php
require_once 'login.php';
require_once 'redir.php';

echo<<<_HEAD1
	<html>
<link rel="stylesheet" href="style.css">
_HEAD1;
include 'menuf.php';

// This is in case there are any fatal issues with the data
if (!$data) {
	echo "<div class='content'>";
	echo '<div class="sub_box">';
	echo "<h2 align='center'>Data Download</h2>";
	echo "<p align='center'>No data has been selected yet!</p>";
	echo "</div>";
	echo "</div>";
	die();
}

// Making the connection
try {
        $pdo = new PDO(
                "mysql:host=$hostname;dbname=$database",
                $username,
                $password,
                [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
        );

} catch (PDOException $e) {
        die("Database error " . $e->getMessage());
}       

// Getting the data
$query = "SELECT * FROM $data";
$stmt = $pdo->query($query);
$rows= $stmt->fetchAll();

echo <<<HTML_1
<head>
<div class='content'>
<title>FASTA Entries</title>

<style>

td {
    word-wrap: break-all;
    max-width: 150px;
}
</style>

</head>
<body>
<div class="sub_box">
<h1 align="center">Data Download</h1>
</div>

<table width ="95%" border="0" cellspacing="0">
<tr>
	<th>ID</th>
	<th>Organism</th>
	<th>Sequence</th>
HTML_1;

foreach ($rows as $row) {
	echo "<tr>";
	echo "<td>" . htmlspecialchars($row['id']) . "</td>";
	echo "<td>" . htmlspecialchars($row['organism']) . "</td>";
	echo "<td>" . htmlspecialchars($row['sequence']) . "</td>";
	echo "</tr>";
}

echo <<<HTML_2
<!--Download the File-->
<div>
<form action="fasta_download.php" method="post">
	<button type="submit">Download Data</button>
</form>
</div>
</div>
</body>
</html>
HTML_2;
?>
