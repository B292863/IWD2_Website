<?php
require_once 'login.php';
require_once 'redir.php';
include 'pat_plot.php';
echo<<<_HEAD1
<html>
<body>
<link rel="stylesheet" href="style.css">
_HEAD1;
include 'menuf.php';

// This is in case there are any fatal issues with the data
if (!$data) {
	echo "<div class='content'>";
	echo "<div class='sub_box'>";
	echo "<h2 align='center'>Motif Analysis</h2>";
	echo "</div>";
	echo "<p align='center'>No data has been selected yet!</p>";
	echo "</div>";
        die();
}

$tmpfasta = "/tmp/fasta.fa";
$tmpout = "/tmp/motifs.txt";

// Remove pre-existing file, so old data doesn't get printed
if (file_exists($tmpfasta)) {
	unlink($tmpfasta);
}

if (file_exists($tmpout)) {
	unlink($tmpout);
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
$rows = $stmt->fetchAll();

// https://www.w3schools.com/php/func_var_var_dump.asp
//var_dump($rows);

// Getting the data
$query = "SELECT * FROM $data";
$stmt = $pdo->query($query);
$rows = $stmt->fetchAll();

// https://www.w3schools.com/php/func_var_var_dump.asp
//var_dump($rows);

// Generate the FASTA string (stdin) [by appending each row to the string]
foreach ($rows as $row) {
        $fasta_stdin = "";
        $fasta_stdin .= ">" . $row['id'] . " " . $row['protein'] . " [" . $row['organism'] . "]\n";
        $fasta_stdin .= $row['sequence'] . "\n";


        $msa = file_put_contents($tmpfasta, $fasta_stdin);


        // Run the MSA command: https://stackoverflow.com/questions/6014819/how-to-get-output-of-proc-open
        $descriptorspec = array(
            0 => array("pipe", "r"), // stdin
            1 => array("pipe", "w"), // stdout
            2 => array("pipe", "w") // stderrors
        );

        $tmpout1 = '/tmp/motifs_o.txt';

        $process = proc_open("patmatmotifs -sequence $tmpfasta -outfile $tmpout1",

                $descriptorspec,
                $pipes);

        fclose($pipes[0]);
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        exec("cat $tmpout1 >> $tmpout");
        // Terminate the process
        proc_close($process);
};

$python = __DIR__ . "/directed_learning/bin/python3";
$command = escapeshellcmd($python) . " patmat_parser.py " . escapeshellarg($tmpout);
// echo "<pre>";
// echo $command;
// echo "</pre>";
exec($command, $out, $err);
$parsed = json_decode(implode("", $out), true);
$_SESSION['pats'] = array();
echo "<div class='content'>";

$img = "/tmp/pat_plot.png";

echo "<div class='sub_box'><h1 align='center'>Motif Report</h1></div>"; //<pre align='center'>

if (file_exists($img)) {
	echo '<img src=get_pat_plot.php alt="PROSITE Motif Summary" width="500" height="600" class="center">';
} else {
        echo '<p align="center">No PROSITE Motif Summary</p>';
}

// Initialize
$_SESSION['pats'] = [];

// Simple print to screen
if (file_exists($tmpout)) {
	echo "<div class='data'>";
        echo "<table align='center'>";
                echo "<tr><th>ID</th><th>Hit</th><th>Length</th><th>Start</th><th>End</th><th>Motif</th><th>Motif Sequence</th></tr>";
	// Reference: https://www.w3schools.com/php/php_looping_foreach.asp;
	foreach ($parsed as $key => $value) {
		foreach ($value as $key1 => $val1) {
			if ($key1 != 0) {
				for ($i = 0; $i < count($val1); $i=$i+5) {
					echo "<tr><td>$key</td><td>$key1</td>";
					$len = $val1[$i];
					$start = $val1[$i+1];
					$end = $val1[$i+2];
					$motif = $val1[$i+3];
					$motif_sequence = $val1[$i+4];
					$_SESSION['pats'][] = $motif;
					echo "<td>$len</td>";
					echo "<td>$start</td>";
					echo "<td>$end</td>";
					echo "<td>$motif</td>";
					echo "<td>$motif_sequence</td>";
					echo "</tr>";
				}
			}
		}
	}
	echo "</table>";
	echo "</div>";
	// echo "<h1 align='center'>Motif Report</h1><pre align='center'>" . file_get_contents($tmpout) . "</pre>";
} else {
	echo "<div class='sub_box'><h1 align='center'>Motif Report</h1></div><p align='center'>Sorry, I've got nothing for you :(</p>";

echo "</div>";
}
?>
