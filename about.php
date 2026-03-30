<?php
session_start();
#include 'redir.php';
require_once 'login.php';
echo<<<_HEAD1
<html>
<body>
_HEAD1;
include 'menuf.php';
echo<<<_BODY1
<div class="content">
<div class="sub_box">
<center><h1> About this Website</h1></center>
</div>

<p>This website hosts a suite of tools for analyzing a user selected protein family. </p>

<hr></hr>

<h2>Flow Chart of Website Functionality</h2>

<--! ADD UPDATED FLOW CHART -->
<img src=ex_flowchart.png alt="Flow Chart" width="1000" height="600" class="center" usemap="#flowmap">
<map name="flowmap">
  <area shape="rect" coords="600,450,650,500"
     href="https://bioinfmsc8.bio.ed.ac.uk/~s2901468/website/home.php"
     target="_blank" title="Home">
</map>

<p>The NCBI search is conducted using the following format:</p>

<ul>
<pre>**protein**[Protein Name] AND **family**[Organism] NOT partial[Title] NOT PREDICTED[Title]</pre>
</ul>

<p>However, in instances where this search returns no IDs, the following search is then carried out:</p>

<ul>
<pre>**protein** AND **family** NOT partial[Title] NOT PREDICTED[Title]</pre>
</ul>

<h2>Implementation</h2>

<ul>
	<li>The Protein Family Analyzer is implemented using MySQL as the underlying relational database management system and Apache as the web server.</li>
	<li>The website's user interface is implemented using HTML for most of the functionality and webpage structure, with some JavaScript for handling subpages.</li>
	<li>A CSS layer is used for styling, with a global CSS sheet used for consistency.
	<li>Secure interactions with the underlying MySQL database are handled in PHP. Data extractions, processing, and analysis are all conducted server-side in PHP.</li>
	<ul>
		<li>When the user submits a query, data is extracted from NBCI and processed using BioPython's Entrez package.</li>
		<li>Previous searches and the example dataset are extracted from a MySQL database by actioning MySQL queries via PDO within PHP.</li>
	</ul>
	<li>Data manipulations are done in PHP scripts.</li>
	<li>Data analyses are conducted using EMBOSS packages (plotcon, patmatmotifs) and IQ-TREE. Outputs are summarized and post-processed using scripts written in Python.</li>
	<li>User selections are stored as session variables in PHP.</li>
</ul>

<h3>GitHub</h3>

<p><a target="_blank" rel="noopener noreferrer" href="https://github.com/B292863/IWD2_Website">Protein Family Analyzer GitHub Page</a></p>

</div>
</body>
</html>
_BODY1;
?>
