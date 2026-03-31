<?php
require_once 'login.php';
require_once 'redir.php';
include 'menuf.php';
include 'phylo_tree.php';

// Purpose: Set up the Phylogenetic Analysis page

// Specify the name of the tree file
$tree = "/tmp/tree.png";

echo <<<HEAD_
<!-- Resource: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_image_center -->
<html>
<body>
<link rel="stylesheet" href="style.css">
<div class='content'>
<div class="sub_box">
<h1 align=center>Phylogenetic Analysis</h1>
</div>
HEAD_;

// Make PDO connection with the database
if (!$data) {
        echo "<p align='center'>No data has been selected yet!</p>";
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
$query = "SELECT id,organism FROM $data";
$stmt = $pdo->query($query);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Print the phylogenetic tree if the file exists
// Reference: https://www.w3schools.com/tags/tag_meta.asp
echo "<p>This phylogenetic tree is the inferred evolutionary relationship  between the input protein sequences based on sequence similarity</p>";
echo "<p><b>Note:</b> Generating the underlying treefile that is used for creating the phylogenetic tree takes some time. Please wait around a minute for the visual to show up.</p>";
echo "<div class='vert_layout'>";
echo "<div>";
if (!file_exists($tree)) {
	echo '<meta http-equiv="refresh" content="30">';
} else {
	echo "<div>";
	echo '<img src="get_phylo_tree.php" alt="Gene Tree" width="500" class="center">'; //height="600"
	echo "</div>";
}
echo "</div>";

// Return list of Organisms and IDs
echo "<div>";
echo "<div class='data'>";
echo "<table style='margin: 0 auto'>";
echo "<tr><th>ID</th><th>Organism</th></tr>";

// Printing the data as a table
// Reference: https://www.w3schools.com/php/php_looping_foreach.asp
// Reference: https://www.ibm.com/docs/en/db2/11.5.x?topic=rqrs-fetching-rows-columns-from-result-sets
foreach ($rows as $row) {
	echo "<tr><td>{$row['id']}</td><td>{$row['organism']}</td></tr>";
}
echo "</table>";
echo "</div>";
echo "</div>";
echo "</div>";
echo <<<END_
</html>
</body>
END_
?>
