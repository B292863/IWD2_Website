<?php
session_start();
// Purpose: Set up the Help page
require_once 'login.php';
echo<<<_HEAD1
<html>
<body>
<link rel="stylesheet" href=style.css>
_HEAD1;
include 'menuf.php';
echo<<<_BODY1
<div class="content">
<div class="sub_box">
<center><h1> Website Help Page: a User Guide</h1></center>
</div>
<p>This website hosts a suite of tools for analyzing a user selected protein family. </p>
<hr></hr>
<h2>Functionality</h2>
<div id="div1"
<p>The following functions are hosted on this website</p>
<p>1. <a href="https://bioinfmsc8.bio.ed.ac.uk/~s2901468/iwd2_website/a1.php">Protein conservation analysis</a></p>
<ul>
	<li>This tool allows users to visualize conservation of amino acid residues at each position in a specified protein across the set of input protein sequences</li>
	<li>The conservation plot is generated via plotcon, which calculates sequence conservation across windows in the Multiple Sequence Alignment. The resulting visual represents the average postion similarity across each window.</li>
	<li>In plotcon, position similarity is computed as the averaged over all pairwise substitution scores at that position.</p>
</ul>
<p>2. <a href="https://bioinfmsc8.bio.ed.ac.uk/~s2901468/iwd2_website/a2.php">Multiple Sequence Alignment</a></p>
<ul>
	<li>The Multiple Sequence Alignment (MSA) and consensus sequence generated using CLUSTALO for a set of inputted protein sequences are visualized</li>
	<li>The underlying MSA can be downloaded as a multi-line MSA FASTA file, for any additional external analyses</li>
	<li>Several statistics are visualized for the MSA:</li>
<ul>
		<li>Amino Acid Substitutions - Heatmap</li>
		<li>Sequence Lengths - Input Protein Sequence lengths across the included individuals. The average, minimum, maximum, and associated IDs are printed, so users can identify aspects about the biology of this protein across a given family of organisms</li>
		<li>Gap Distribution - Another common approach for quantifying the quality of the MSA and probing the MSA for interesting biological features is characterizing the number and gap composition across aligned sequences. A histogram of gap composition across protein sequences is displayed here. Additionally, the average, minimum, maximum gap composition with associated sequence IDs are printed.</li>
</ul>
</ul>
<p>3. <a href="https://bioinfmsc8.bio.ed.ac.uk/~s2901468/iwd2_website/a3.php">Motif Analysis</a></p>
<ul>
	<li>The requested input protein sequences are scanned for motifs from PROSITE.</li>
	<li>If a sequence contained a PROSITE, details regarding the motif are reported along with the sequence ID.</li>
</ul>
<p>4. <a href="https://bioinfmsc8.bio.ed.ac.uk/~s2901468/iwd2_website/a4.php">Phylogenetic Analysis</a></p>
<ul>
	<li>The output is a phylogenetic tree that evaluates the sequence similarity of the input protein sequences and and infers evolutionary relationships between them.</li>
	<li>The substitution matrix used in generating the tree is <a target="_blank" rel="noopener noreferrer" href="https://www.pnas.org/doi/epdf/10.1073/pnas.89.22.10915">BLOSUM62</a>, which is a commonly used substitution matrix (e.g., the default substitution matrix in BLASTP)</li>
	<li>Note: since implementation is server-side, this may take a little while to run.</li>
</ul>
<p>5. <a href="https://bioinfmsc8.bio.ed.ac.uk/~s2901468/iwd2_website/fasta.php">Data Download</a></p>
<ul>
	<li>This page allows users to examine the data by organism, sequence ID, and the sequence itself.</li>
	<li>The requested input data can be downloaded as a multi-line FASTA file from this page, allowing any external analyses</li>
</ul>
</body>
</html>
</div>
<hr></hr>
<h2>How to Use this Website</h2>

<p>The home page is the data selection page. Here, users have the option to search for a specific protein from a specific taxonomic group, select a previous search, or use the example dataset, Glucose-6-Phosphatase Proteins from Aves.</p>

<p><b>Data Selection Options:</b></p>
<ol>
	<li>Select taxonomic group and protein</li>
	<li>Use a previous search</li>
	<li>Example Data: Glucose-6-Phosphatase Proteins from Aves</li>
</ol>

<p>Once a selection has been made, the tools are populated with this data. Users can browse through the different functions as listed above for their selected data.</p>
<p><b>Note:</b> If a selection has not been made, attempting to access the functionality pages (Conservation Analysis, MSA, Phylogenetic Analysis, Data Download) will redirect the user back to the home page.</p>
</div>
_BODY1;
?>
