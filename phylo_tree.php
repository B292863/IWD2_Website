<?php
require_once 'login.php';
require_once 'redir.php';

// Purpose: Extract the data and generate the phylogenetic tree

// Makes sure that if there is no table existing with the name $data, that no error shows up
if (!$data) {
	echo "<div class='content'>";
        echo "<h2 align='center'>Phylogenetic Tree</h2>";
	echo "<p align='center'>No data has been selected yet!</p>";
	echo "</div>";
        die();
}

$img = "/tmp/tree.png";

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

// Generate the FASTA string (stdin) [by appending each row to the string]
$fasta_stdin = "";
foreach ($rows as $row) {
	$fasta_stdin .= ">" . $row['id'] . "_" . str_replace(" ", "_", $row['organism']) . "\n";
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

// Verify that the MSA file was generated; this makes sure that if there wasa failure here, no error will be generated, only this message
if (!file_exists($tmpmsa)) {
	echo "<div class='content'>";
	echo "MSA failed to produce file";
	echo "</div";
	exit;
}

// Generating the treefile
$tmptree = "/tmp/treefile";
$tmptreefile = "/tmp/treefile.treefile";

// Define the program
$iqtree = '/localdisk/home/ubuntu-software/iqtree-2.2.0-Linux/bin/iqtree';
$command = escapeshellcmd($iqtree);
exec("which $iqtree", $out);

// Run the command to generate the treefile
$command1 = escapeshellcmd($iqtree) . " -m Blosum62 -s " . escapeshellarg($tmpmsa) . " -pre " . escapeshellarg($tmptree) . ' -redo'; // -nt 4
exec($command1);

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
exec($command2);

# Make sure that the image was generated
if (!file_exists($tmptreepng)) {
    die("Tree NOT generated.");
}

// Print image to the screen
$img = "/tmp/tree.png";
?>
