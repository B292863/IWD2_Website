<?php
session_start();
require_once 'login.php';
// Purpose: Set up the About page
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

<!-- Navigation Menu -->
<nav>
<p>Navigate to:</p>
<div class='vert_line'>
<ul>
        <li><a href="#flow">Website Flowchart</a></li>
	<li><a href="#imp">Implementation</a></li>
	<li><a href="#git">GitHub</a></li>
</ul>
</div>
</nav>

<hr></hr>

<h2 id='flow'>Flow Chart of Website Functionality</h2>

<img src="flowchart_4.1.png" alt="Flow Chart" width="1000" height="600" class="center">

<p>The NCBI search is conducted using the following format:</p>

<ul>
<pre>**protein**[Protein Name] AND **family**[Organism] NOT partial[Title] NOT PREDICTED[Title]</pre>
</ul>

<p>However, users may also use the following <u>less stringent</u> search criteria:</p>

<ul>
<pre>**protein** AND **family** NOT partial[Title] NOT PREDICTED[Title]</pre>
</ul>

<p>The top 50 results are returned from the NCBI search.</p>

<hr>

<h2 id='imp'>Implementation</h2>

<ul>
	<li>The Protein Family Analyzer is implemented using MySQL as the underlying relational database management system and Apache as the web server.</li>
	<li>The user interface is implemented in HTML for most of the functionality and webpage structure, with some JavaScript for handling subpages.</li>
	<li>A CSS layer is used for styling, with a global CSS sheet used for consistency.</li>
	<li>Secure interactions with the underlying MySQL database are handled via PDO. Data extractions, processing, and analysis are all conducted server-side in PHP.</li>
	<ul>
		<li>When the user submits a query, data is extracted from NBCI and processed using BioPython's Entrez package.</li>
		<li>Previous searches and the example dataset are extracted from a MySQL database by actioning MySQL queries via PDO.</li>
	</ul>
	<li>Data is processed and manipulated in PHP.</li>
	<li>Data analyses are conducted using EMBOSS packages (plotcon, patmatmotifs, showalign) and IQ-TREE. Outputs are summarized and post-processed using scripts written in Python.</li>
	<li>User selections are stored as session variables in PHP.</li>
</ul>

</hr>

<hr>

<h3 id='git'>GitHub</h3>

<p><a target="_blank" rel="noopener noreferrer" href="https://github.com/B292863/IWD2_Website">Protein Family Analyzer GitHub Page</a></p>

</hr>
</div>
</body>
</html>
_BODY1;
?>
