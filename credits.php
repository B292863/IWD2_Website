<?php
session_start();
#include 'redir.php';
require_once 'login.php';
echo<<<_HEAD1
<html>
<body>
_HEAD1;
include 'menuf.php';

// References: https://stackoverflow.com/questions/15551779/open-link-in-new-tab-or-window

echo<<<_BODY1
<div class="content">
<div class="sub_box">
<center><h1> Statement of Credit</h1></center>
</div>
<hr>
<h2>Code Resources:</h2>
<ul>
	<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com">W3Schools</a></li>
	<li><a target="_blank" rel="noopener noreferrer" href="https://www.php.net/manual/en/function.proc-open.php">Running Command Line Programs Through PHP</a></li>
	<li><a target="_blank" rel="noopener noreferrer" href="https://biopython.org/docs/dev/Tutorial/chapter_msa.html">BioPython Modules</a></li>
	<ul>
		<li>Multiple Sequence Alignment Statistics</li>
	</ul>
	<li>EMBOSS Tools:</li>
	<ul>
		<li><a target="_blank" rel="noopener noreferrer" href="https://emboss.sourceforge.net/apps/release/6.0/emboss/apps/plotcon.html">EMBOSS plotcon</a></li>
		<li><a target="_blank" rel="noopener noreferrer" href="https://emboss.sourceforge.net/apps/cvs/emboss/apps/showalign.html">EMBOSS showalign</a></li>
	</ul>
	<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/css//default.asp">CSS Style Sheet References</a></li>
	<ul>
		<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/Css/tryit.asp?filename=trycss_template4">CSS Side Bar Style (Template 4)</a></li>
	</ul>
</ul>
</hr>
<hr>
<h2>AI Statement:</h2>
<p>AI was used for general troubleshooting:</p>
<ul>
	<li>For some of the initial PDO connections.</li>
	<li>Fixing download bugs: FASTA download page.</li>
	<li>Fixing issues with printing output to the website.</li>
	<ul>
		<li>Image output: Residue Conservation Plot</li>
		<li>Image output: Amino Acid Heatmap</li>
	</ul>
	<li>Also used to find resources for particularly tricky bugs.</li>
	<li>Used to find specific resources when I couldn't find the exact fix when troubleshooting via Google searches</li>
</ul>
</hr>
<hr>
<h2>Citations:</h2>
<ul>
	<div style=“text-indent: -36px; padding-left: 36px;”>Rice P., Longden I. and Bleasby A. EMBOSS: The European Molecular Biology Open Software Suite. Trends in Genetics. 2000 16(6):276-277</div>
	<div style=“text-indent: -36px; padding-left: 36px;”>Nguyen, L.-T., Schmidt, H. A., Von Haeseler, A., & Minh, B. Q. (2015). IQ-TREE: A Fast and Effective Stochastic Algorithm for Estimating Maximum-Likelihood Phylogenies. Molecular Biology and Evolution, 32(1), 268–274. https://doi.org/10.1093/molbev/msu300</div>
	<div style=“text-indent: -36px; padding-left: 36px;”>Cock, P. J. A., Antao, T., Chang, J. T., Chapman, B. A., Cox, C. J., Dalke, A., Friedberg, I., Hamelryck, T., Kauff, F., Wilczynski, B., & De Hoon, M. J. L. (2009). Biopython: Freely available Python tools for computational molecular biology and bioinformatics. Bioinformatics, 25(11), 1422–1423. https://doi.org/10.1093/bioinformatics/btp163</div>
</ul>
</hr>
</div>
</body>
</html>
_BODY1;
?>
