<?php
session_start();
require_once 'login.php';
require_once 'redir.php';
include 'menuf.php';
include 'aa_heat.php';
include 'lens.php';
include 'gaps.php';
// include 'menuf.php';
// Reference: https://www.w3schools.com/howto/howto_js_vertical_tabs.asp
// Based my tabs on this: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_vertical_tabs
echo<<<_HEAD1
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class='content'>
<div class="sub_box">
<h1 align='center'>Multiple Sequence Alignment</h1>
</div>
</div>

<div id="MSA" class="tabcontent">
<div class='content'>
<h2 align='center'>Multiple Sequence Alignment</h2>
</div>
_HEAD1;

// This is in case there are any fatal issues with the data
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

// Make sure the FASTA input actually contains something, print the following
// References: https://code.tutsplus.com/php-isset-vs-empty-vs-is_null--cms-37162t#
if (empty($fasta_stdin)) {
	echo "<p align='center'>FASTA was empty - NO Input Sequences</p>";
	exit();
}	

// Run the MSA command: https://stackoverflow.com/questions/6014819/how-to-get-output-of-proc-open
$descriptorspec = array(
    0 => array("pipe", "r"), // stdin
    1 => array("pipe", "w"), // stdout
    2 => array("pipe", "w") // stderrors
);

$process = proc_open("clustalo -i - -t Protein --force",
	$descriptorspec,
	$pipes);

fwrite($pipes[0], $fasta_stdin);
fclose($pipes[0]);

// Capture the alignment
$msa = stream_get_contents($pipes[1]);
$tmpmsa = "/tmp/align.aln";
file_put_contents($tmpmsa, $msa);
$error = stream_get_contents($pipes[2]);

fclose($pipes[1]);
fclose($pipes[2]);

// Terminate the process
proc_close($process);

$tmppmsa = "/tmp/prettyalign";

// Generate a pretty alignment for printing
// Reference: http://emboss.open-bio.org/rel/dev/apps/showalign.html
$process_pretty_align = proc_open("showalign -sequence $tmpmsa -show=a -show=i -show=s -outfile $tmppmsa",
	$descriptorspec,
        $pipes);

fclose($pipes[0]);

// Capture the alignment
// $output_align = stream_get_contents($pipes[1]);
// $error_align = stream_get_contents($pipes[2]);
// fclose($pipes[1]);
// fclose($pipes[2]);

$pmsa = stream_get_contents($pipes[1]);
$error = stream_get_contents($pipes[2]);

fclose($pipes[1]);
fclose($pipes[2]);

// Terminate the process
proc_close($process_pretty_align);

// Simple print to screen
// echo "<h1 align='center'>Multiple Sequence Alignment:</h1>";

echo <<<_DOWNLOAD
<div class="content">
<div>
<form action="msa_download.php" method="post">
        <button type="submit" class="button">Download Data</button>
</form>
</div>
</div>
_DOWNLOAD;

// Reference: https://www.w3schools.com/html/html_iframe.asp
if (file_exists($tmppmsa)) {
        echo '<iframe src=get_pretty_align.php width="100%" height="1000" frameBorder = "0" class="center"></iframe>';
} else {
        echo '<p align="center">No MSA Exists</p>';
}

// Troubleshooting: echo "<h3>Error:</h3><pre>$error</pre>";
echo "</div>";
echo<<<_TAB2
<div id="MSA_stats" class="tabcontent">
<style>
table {
  border-collapse: collapse;
}
td {
  padding: 0;
}
</style>
<div class="content">
<h2 align='center'>Multiple Sequence Alignment Statistics</h2>
<p>Browse through the following: Amino Acid Substitution Matrix, Sequence Length Distribution, Gap Composition.</p>
<hr>
<h3 align='center'>Amino Acid Substitution Heatmap</h3>
_TAB2;
// Added this to be specific
$img = "/tmp/heatmap.png";

if (file_exists($img)) {
	clearstatcache(true, $img);
	// echo "<pre>";
	//echo $img;
	// echo "</pre>";
	echo "<table><tr>";
	echo "<td width=100%>";
	echo '<img src=get_aa_heat.php alt="Amino Acid Substitution Heatmap" width="500" height="600" class="center">';
	echo "</td>";
	echo "<td width=50%>";
	echo "<h3>Interpretation:</h3>";
	echo "<p>This heatmap counts the number of amino acid substitutions (mismatches) across the MSA</p>";
	echo "<p>The diagonal represents the positions in the MSA that were identical between a pair of sequences (matches)</p>";
	echo "<p>Off-diagonals represent mismatches</p>";
	echo "<p>Warmer colors represent a larger count of those matches</p>";
	echo "<p>Notes:</p>";
	echo "<ul>";
	echo "<li>Amino acids do not occur at equal frequencies, note the larger counts of certain amino acids in the diagonal (e.g., Leucine (L) is the most abundant amino acid).</li>";
	echo "<li>There are certain mismatches that are more or less common depending on the input set of proteins, which can be identified by cells in the heatmap that are <u>less blue</u>.</li>";
	echo "</ul>";
	echo "</td>";
	echo "</table></tr>";
} else {
        echo '<p align="center">No Amino Acid Substitution Heatmap Exists</p>';
}

// Sequence Lengths
$lenimg = "/tmp/lens_hist.png";

echo "</hr>";

echo "<hr>";

echo "<h3 align='center'>Sequence Length Distribution</h3>";

echo "<table>";
if (file_exists($lenimg)) {
        clearstatcache(true, $lenimg);
        // echo "<pre>";
        //echo $img;
	// echo "</pre>";
	echo "<td>";
	//echo "<div class='row' style='width:200%'>";
	//	echo "<div class='column'>";
	echo '<img src=get_lens.php alt="Sequence Length Distribution" width="500" height="600" class="center">';
	echo "</td>";
	// echo "</div>";
	// echo "<div class='column'>";
	echo "<td>";
	echo "<p>For the set of input protein sequences, explore the distribution of sequence lengths</p>";

	echo "<div class='data'>";
	echo "<table>";
		echo "<tr><th>Type</th><th>Value</th></tr>";
		// Reference: https://www.w3schools.com/php/php_looping_foreach.asp
		foreach ($_SESSION['vals'] as $key => $value) {
			echo "<tr><td>$key</td><td>$value</td></tr>";
		}
		echo "</table>";
		echo "</div>";
		// echo "</div>";
		echo "</td>";
} else {
        echo '<p align="center">No Sequence Length Distributions Exists</p>';
}

// Gaps
$gapimg = "/tmp/gaps_hist.png";
echo "</table>";
echo "</hr>";
echo "<hr>";
echo "<h3 align='center'>Gap Distribution</h3>";

echo "<table>";
if (file_exists($gapimg)) {
        clearstatcache(true, $gapimg);
        // echo "<pre>";
        //echo $img;
	// echo "</pre>";
        //echo "<div class='row' style='width:200%'>";
	//        echo "<div class='column'>";
	echo "<tr><td>";
	echo '<p><img src=get_gaps.php alt="Sequence Gap Composition" width="500" height="600" class="center"></p>';
	echo "</td>";
	//echo "</div>";
	echo "<td>";
	if (!empty($_SESSION['gap_vals'])) {
	//echo "<div class='column'>";
	// echo var_dump($_SESSION['gap_vals']);
	echo "<div class='data'>";
        echo "<table>";
                echo "<tr><th>Type</th><th>Value</th></tr>";
                // Reference: https://www.w3schools.com/php/php_looping_foreach.asp
                foreach ($_SESSION['gap_vals'] as $key => $value) {
                        echo "<tr><td>$key</td><td>$value</td></tr>";
                }
		echo "</table>";
		echo "</td></tr>";
		echo "</div>";
		// echo "</div>";
	}
		// echo "</div>";
} else {
        echo '<p align="center">No Sequence Gap Composition Histogram Exists</p>';
}
echo "</hr>";
echo "</div>";
echo "</div>";
echo <<<_TAIL
<script>
function openTab(evt, tab_name) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tab_name).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
//document.getElementById("defaultOpen").click();

// Make sure that MSA is the default 
// Reference: mixture of online resources on JS and ChatGPT
window.onload = function() {
  openTab(null, 'MSA');
};
</script>
</body>
</html> 
_TAIL;
?>

