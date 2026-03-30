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
	<ul>
		<li>This resource was used for quite a bit of the styling components, specific references are commented in the code files in the <a target="_blank" rel="noopener noreferrer" href="https://github.com/B292863/IWD2_Website">GitHub repository</a> (e.g., the styling of the side bar and the drop down menu are adapted from <a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/Css/tryit.asp?filename=trycss_template4">Template 4</a>)</li> 
		<li>W3 was also used to identify and use the right syntax for a variety of HTML tags</li>
		<li>Some of the PHP commands (e.g., <a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/php/func_string_implode.asp">implode()</a>) were identified via W3.</li> 
	</ul>
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
<p><a target="_blank" rel="noopener noreferrer" href="https://chatgpt.com/?utm_source=google&utm_medium=paid_search&utm_campaign=GOOG_C_SEM_GBR_Core_CHT_BAU_ACQ_PER_MIX_ALL_EMEA_GB_EN_052725&c_id=22601529282&c_agid=178867152694&c_crid=754784350981&c_kwid=kwd-1927227100722&c_ims=&c_pms=9046891&c_nw=g&c_dvc=c&gad_source=1&gad_campaignid=22601529282&gbraid=0AAAAA-I0E5crsS6IpNwd9wdtJeCeq7xfy&gclid=EAIaIQobChMIsZu47erHkwMVFZFQBh0LgBbfEAAYASAAEgKXHPD_BwE">ChatGPT</a> was used for general troubleshooting:</p>
<ul>
	<li>For some of the initial PDO connections.</li>
	<li>Fixing download bugs: FASTA download page.</li>
	<li>Fixing issues with printing output to the website (e.g., caching issues).</li>
	<ul>
		<li>Image output: Residue Conservation Plot</li>
		<li>Image output: Amino Acid Heatmap</li>
		<li>Image output: Phylogenetic Tree</li>
	</ul>
	<li>Used to determine why certain programs were or were not running and generating output when written in PHP proc_open() vs exec() (e.g., proc_open() worked well for generating the MSA, but exec() was used to run IQ-TREE)</li>
	<li>To identify why the CSS stylesheet was only sometimes resetting the style for particular elements</li>
	<li>Used to find specific resources when I couldn't find the exact fix for particularly tricky bugs when troubleshooting via Google searches</li>
	<li>Used to help safely transfer all files required to run this webpage from a personal GitHub account to an anonymized GitHub</li>
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
