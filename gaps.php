<?php
require_once 'login.php';
require_once 'redir.php';

$img = "/tmp/gaps_hist.png"; // generate a new filename each time to get around caching issues

// echo "<pre>";
// echo $img;
// echo "</pre>";

if (file_exists($img)) {
        unlink($img);
}

if (!$data) {
        echo "<h2 align='center'>Gap Composition Statistics</h2>";
        echo "<p align='center'>No data has been selected yet!</p>";
        exit();
}

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

// https://www.w3schools.com/php/func_var_var_dump.asp
//var_dump($rows);

// Generate the FASTA string (stdin) [by appending each row to the string]
$fasta_stdin = "";
foreach ($rows as $row) {
	$fasta_stdin .= ">" . $row['id'] . " " . $row['protein'] . " [" . $row['organism'] . "]\n";
	$fasta_stdin .= $row['sequence'] . "\n";
};

// Run the MSA command: https://stackoverflow.com/questions/6014819/how-to-get-output-of-proc-open
$descriptorspec = array(
    0 => array("pipe", "r"), // stdin
    1 => array("pipe", "w"), // stdout
    2 => array("pipe", "w") // stderrors
);

$process1 = proc_open("clustalo -i - -t Protein --force",
	$descriptorspec,
	$pipes);

fwrite($pipes[0], $fasta_stdin);
fclose($pipes[0]);

// Capture the alignment
// plotcon needs MSA in a file, doesn't take stdin
$msa = stream_get_contents($pipes[1]);
$tmpmsa = "/tmp/align.fa";
file_put_contents($tmpmsa, $msa);
$error = stream_get_contents($pipes[2]);

fclose($pipes[1]);
fclose($pipes[2]);

// Terminate the process
proc_close($process1);

// Generating the amino acid heatmap
$python = __DIR__ . "/directed_learning/bin/python3";
$command = escapeshellcmd($python) . " msa_gaps.py " . escapeshellarg($tmpmsa) . " " . escapeshellarg($img);
// echo "<pre>";
// echo $command;
// echo "</pre>";
exec($command, $outgap, $errgap);
$_SESSION['gap_vals'] = json_decode($outgap[0], true); // implode("\n", $out),
// echo "<pre>";
// echo var_dump($_SESSION['gap_vals']);
// echo "</pre>";
//file_put_contents($img, $heat)

// Print image to the screen
$img = "/tmp/gaps_hist.png";;
?>
