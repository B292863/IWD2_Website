<?php
require_once 'login.php';
require_once 'redir.php';
include 'menuf.php';
include 'phylo_tree.php';

$tree = "/tmp/tree.png";
// if (!file_exists($tree)) {
//	echo "Tree is still being generated, thank you for your patience!";
// }

echo <<<HEAD_
<!-- Resource: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_image_center -->
<html>
<body>
<link rel="stylesheet" href="style.css">
<div class='content'>
<div class="sub_box">
<h1 align=center>Phylogenetic Analysis</h1>
</div>
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

// Print the phylogenetic tree
// Reference: https://www.w3schools.com/tags/tag_meta.asp
echo "<div class='content'>";
if (!file_exists($tree)) {
	echo '<meta http-equiv="refresh" content="30">';
} else {
	echo '<img src="get_phylo_tree.php" alt="Gene Tree" width="500" height="600" class="center">';
}

// Return list of Organisms and IDs
echo "<div class='data'>";
echo "<table>";
echo "<tr><th>ID</th><th>Organism</th></tr>";
// Reference: https://www.w3schools.com/php/php_looping_foreach.asp
// Reference: https://www.ibm.com/docs/en/db2/11.5.x?topic=rqrs-fetching-rows-columns-from-result-sets
foreach ($rows as $row) {
	echo "<tr><td>{$row['id']}</td><td>{$row['organism']}</td></tr>";
}
echo "</table>";
echo "</div>";
echo "</div";
echo <<<END_
</html>
</body>
END_
?>
