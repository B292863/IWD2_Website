<?php
require_once 'login.php';
require_once 'redir.php';

// Makes sure that if there is no table existing with the name $data, that no error shows up
if (!$data) {
	echo "<div class='content'>";
        echo "<h2 align='center'>Phylogenetic Tree</h2>";
	echo "<p align='center'>No data has been selected yet!</p>";
	echo "</div>";
        die();
}

$img = "/tmp/tree.png";

// if (file_exists($img)) {
//         unlink($img);
// }

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

$process1 = proc_open("clustalo -i - -t Protein --force --outfmt fasta",
	$descriptorspec,
	$pipes);

fwrite($pipes[0], $fasta_stdin);
fclose($pipes[0]);

// Capture the alignment
$msa = stream_get_contents($pipes[1]);
$tmpmsa = "/tmp/align.fasta";
file_put_contents($tmpmsa, $msa);
$error = stream_get_contents($pipes[2]);

fclose($pipes[1]);
fclose($pipes[2]);

// Terminate the process
proc_close($process1);

if (!file_exists($tmpmsa)) {
	echo "<div class='content'>";
	echo "MSA failed to produce file";
	echo "</div";
	exit;
}

// Generating the treefile

$tmptree = "/tmp/treefile";
// $process2 = proc_open("iqtree -m JC -s $tmpmsa -nt 4 -pre $tmptree",
//        $descriptorspec,
//	$pipes);
$tmptreefile = "/tmp/treefile.treefile";

// if (file_exists($tmptreefile)) {
//        unlink($tmptreefile);
//}

$iqtree = '/localdisk/home/ubuntu-software/iqtree-2.2.0-Linux/bin/iqtree';
$command = escapeshellcmd($iqtree);
exec("which $iqtree", $out);
// echo implode("\n", $out);

// fclose($pipes[0]);
// https://iqtree.github.io/doc/Substitution-Models
$command1 = escapeshellcmd($iqtree) . " -m Blosum62 -s " . escapeshellarg($tmpmsa) . " -pre " . escapeshellarg($tmptree) . ' -redo'; // -nt 4
// echo "<pre>";
// echo $command1;
// echo "</pre>";
exec($command1);
// plotcon needs MSA in a file, doesn't take stdin
//$output = stream_get_contents($pipes[1]);
//$error = stream_get_contents($pipes[2]);

//fclose($pipes[1]);
//fclose($pipes[2]);

// Terminate the process
//proc_close($process2);

// TROUBLESHOOTING - REMOVE LATER!!
$tries = 0;
$max_tries = 50;
while (!file_exists($tmptreefile) && $tries < $max_tries) {
    sleep(2);
    $tries++;
}

if (!file_exists($tmptreefile)) {
	echo "<div class='content'>";
	echo "Treefile hasn't yet been generated";
	echo "</div>";
	exit(); // sleep(2)
}

// Generating the tree

$tmptreepng = "/tmp/tree.png";
$python = __DIR__ . "/directed_learning/bin/python3";
$command2 = escapeshellcmd($python) . " phylo_tree.py " . escapeshellarg($tmptreefile) . " " . escapeshellarg($tmptreepng);
// echo "<pre>";
// echo $command2;
// echo "</pre>";
exec($command2);

if (!file_exists($tmptreepng)) {
    die("Tree NOT generated.");
}

// Print image to the screen
$img = "/tmp/tree.png";
?>
