<?php
require_once 'login.php';
require_once 'redir.php';

// Purpose: Generate the Conservation Plot

// Variable for output image name and location
$img = "/tmp/plotcon.1.png";

// Ensuring that an old conservation plot will not be sent to the website
if (file_exists($img)) {
        unlink($img);
}

// Failsafe if the data has not been selected
if (!$data) {
        echo "<h2 align='center'>Residue Conservation Plot</h2>";
        echo "<p align='center'>No data has been selected yet!</p>";
        exit();
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
$tmpmsa = "/tmp/align.aln";
file_put_contents($tmpmsa, $msa);
$error = stream_get_contents($pipes[2]);

fclose($pipes[1]);
fclose($pipes[2]);

// Terminate the process
proc_close($process1);

// Generating the conservation plot

// Get the selected window size
$win_size = $_SESSION['win_size'];

// Run plotcon to generate conservation plot
$tmpimg = "/tmp/plotcon";
$process2 = proc_open("plotcon -sequences $tmpmsa -graph png -winsize $win_size -goutfile $tmpimg",
        $descriptorspec,
	$pipes);

fclose($pipes[0]);

$output = stream_get_contents($pipes[1]);
$error = stream_get_contents($pipes[2]);

fclose($pipes[1]);
fclose($pipes[2]);

// Terminate the process
proc_close($process2);

// Print image to the screen
$img = "/tmp/plotcon.1.png";
?>
