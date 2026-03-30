<?php
require_once 'login.php';
require_once 'redir.php';

// PURPOSE: Download Multi-Line FASTA file

// Set content type
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename=data.fa');

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
$rows = $stmt->fetchAll();

foreach ($rows as $row) {
	echo ">" . $row['id'] . " " . $row['protein'] . " [" . $row['organism'] . "]\n";
	echo chunk_split($row['sequence'], 80, "\n");
}
?>
