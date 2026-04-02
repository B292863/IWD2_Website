<?php
require_once 'login.php';
require_once 'redir.php';
include 'pat_plot.php';

// Purpose: Sets up the Motif Analysis page

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

// Specify the names of the output files
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

// patmatmotifs only searches motifs in one input sequence at a time
// This foreach loop ensures that patmatmotifs scans for motifs in each input sequence
foreach ($rows as $row) {
	// Generate the FASTA string (stdin) [by appending each row to the string]
        $fasta_stdin = "";
        $fasta_stdin .= ">" . $row['id'] . " " . $row['protein'] . " [" . $row['organism'] . "]\n";
        $fasta_stdin .= $row['sequence'] . "\n";

	// Place the output into a file
        $msa = file_put_contents($tmpfasta, $fasta_stdin);


        // Run the patmatmotifs command: https://stackoverflow.com/questions/6014819/how-to-get-output-of-proc-open
        $descriptorspec = array(
            0 => array("pipe", "r"), // stdin
            1 => array("pipe", "w"), // stdout
            2 => array("pipe", "w") // stderrors
        );
	
	// Specify the temporary output
        $tmpout1 = '/tmp/motifs_o.txt';

        $process = proc_open("patmatmotifs -sequence $tmpfasta -outfile $tmpout1",

                $descriptorspec,
                $pipes);

        fclose($pipes[0]);
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
	
	// Generate the final output, that includes identified motifs across all the data
        exec("cat $tmpout1 >> $tmpout");
        // Terminate the process
        proc_close($process);
};

// Parse the patmatmotif file
$python = __DIR__ . "/directed_learning/bin/python3";
$command = escapeshellcmd($python) . " patmat_parser.py " . escapeshellarg($tmpout);
exec($command, $out, $err);
$parsed = json_decode(implode("", $out), true);
$_SESSION['pats'] = array();

echo "<div class='content'>";

// Define the path to the summary plot
$img = "/tmp/pat_plot.png";

echo "<div class='sub_box'><h1 align='center'>Motif Report</h1></div>";

echo <<<NAV
<!-- Navigation Menu -->
<nav>
<p>Browse through the following:</p>
<div class='vert_line_s'>
<ul>
        <li><a href="#sum">PROSITE Summary</a></li>
        <li><a href="#hits">PROSITE Hits</a></li>
</ul>
</div>
</nav>

<p>The <b>PROSITE Summary</b> pie chart visualizes the types of PROSITE motifs identified in the input protein sequences</p>
<ul>
	<li><b>Note:</b> This may take a couple seconds to generate</li>
</ul>
<p>The <b>PROSITE Hits</b> data table contains all the PROSITE motifs identified in the input protein sequences. The columns represent:</p>
<ul>
	<li><b>ID:</b> ID of the protein sequence containing motif.</li>
	<li><b># Hits:</b> The number of PROSITE motifs (hits) identified <i>for a given ID and motif.</i></li>
	<li><b>Length:</b> Length of matched motif sequence.</li>
	<li><b>Start:</b> Start position of motif in input protein sequence.</li>
	<li><b>End:</b> End position of motif in input protein sequence.</li>
	<li><b>Motif:</b> Name of the motif.</li>
	<li><b>Motif Sequence:</b> The sequence of the motif in the input protein sequence.</li>
</ul>
NAV;

echo "<hr>";

echo "<h3 align='center' id='sum'>PROSITE Summary</h3>";

// Print the summary data to the screen if the file exists
if (file_exists($img)) {
	echo '<img src=get_pat_plot.php alt="PROSITE Motif Summary" width="500" height="600" class="center">';
} else {
        echo '<p align="center">No PROSITE Motif Summary</p>';
}

echo "</hr>";

// Initializethe patmat session variable
$_SESSION['pats'] = [];

// Print the parsed patmatmotif data to the website as a table, if output was successfully generated
echo "<hr>";
echo "<h3 align='center' id='hits'>PROSITE Hits</h3>";

if (file_exists($tmpout)) {
	echo "<div class='data'>";
        echo "<table align='center'>";
                echo "<tr><th>ID</th><th># Hits</th><th>Length</th><th>Start</th><th>End</th><th>Motif</th><th>Motif Sequence</th></tr>";
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
} else {
	echo "<div class='sub_box'><h1 align='center'>Motif Report</h1></div><p align='center'>Sorry, I've got nothing for you :(</p>";
echo "</hr>";
echo "</div>";
}
?>
