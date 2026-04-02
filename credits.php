<?php
session_start();
// Purpose: Set up the Statement of Credits page
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
<!-- Navigation Menu -->
<nav>
<p>Navigate to:</p>
<div class='vert_line'>
<ul>
	<li><a href="#code">Code Resource</a></li>
	<li><a href="#ai">AI Statement</a></li>
	<li><a href="#cite">Citations</a></li>
</ul>
</div>
</nav>
<hr>
<h2 id='code'>Code Resources:</h2>

<p>In addition to the following references (provided via linkout), the code files in this website's <a target="_blank" rel="noopener noreferrer" href="https://github.com/B292863/IWD2_Website">GitHub repository</a> have commented references above the code where the resources were used.</p>

<ul>
	<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com">W3Schools</a></li>
	<ul>
		<li>This resource was used for quite a bit of the styling components, specific references are commented in the code files in the <a target="_blank" rel="noopener noreferrer" href="https://github.com/B292863/IWD2_Website">GitHub repository</a> (e.g., the styling of the side bar and the drop down menu are adapted from <a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/Css/tryit.asp?filename=trycss_template4">Template 4</a>)</li> 
		<li>W3 was used to identify and use the right syntax for a variety of HTML tags</li>
		<ul>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/html/html_iframe.asp">iframe tag</a></li>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/tags/tag_meta.asp">meta tag</a></li>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/html/html_table_borders.asp">Table borders</a></li>
			<li>Radio Buttons</li>
			<ul>
				<li>Set up <a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/tags/att_input_type_radio.asp">buttons</a></li>
				<li><a target="_blank" rel="noopener noreferrer" href="https://stackoverflow.com/questions/5419459/how-can-i-allow-only-one-radio-button-to-be-checked">Do not allow multiple buttons</a> to be pressed at one time</li>
			</ul>
			<li>Opening a link in a <a target="_blank: rel="noopener noreferrer" href="https://www.w3schools.com/html/html_links.asp">new tab</a></li>
		</ul>
		<li>Identifying PHP and PDO commands, functions, looping constructs, and verifying syntax:</li>
		<ul>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/php/func_var_intval.asp">intval()</li>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/php/php_looping_foreach.asp">foreach loop</a></li>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/php/func_string_implode.asp">implode()</a></li>
			<li>Return certain rows from MySQL searchs via <a target="_blank" rel="noopener noreferrer" href="https://www.ibm.com/docs/en/db2/11.5.x?topic=rqrs-fetching-rows-columns-from-result-sets">PDO</a></li>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/php/php_operators.asp">PHP operators</a></li>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/PhP/func_json_decode.asp">json_decode()</a></li>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/php/func_string_chunk_split.asp">chunk_split()</a></li>
		</ul>
		<li>The JavaScript tab functionalities was adapted from W3 Schools</li>
		<ul>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/howto/howto_js_tabs.asp">Tabs</a></li>
			<li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/howto/howto_js_vertical_tabs.asp">Vertical Tabs</a></li> 
		</ul>
		<li>For CSS Styling:</li>
		<ul>
			<li>Create a <a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/howto/howto_css_vertical_line.asp">vertical line</a> for page navigation menus</li>
			<li>Allow navigation menus to <a target="_blank" rel="noopener noreferrer" href="https://stackoverflow.com/questions/14390979/how-do-i-keep-a-nav-bar-at-the-top-of-the-page">remain at the top of the screen</a> while scrolling</li>
		</ul>
	</ul>
	<li><a target="_blank" rel="noopener noreferrer" href="https://www.php.net/manual/en/function.proc-open.php">Running Command Line Programs Through PHP</a></li>
	<li><a target="_blank" rel="noopener noreferrer" href="https://www.php.net/manual/en/function.header.php">Cache Directives</a> in PHP</li>
	<li>PHP session variables:</li>
	<ul>
		<li><a target="_blank" rel="noopener noreferrer" href="https://stackoverflow.com/questions/6500654/php-cookies-and-session-variables-and-ip-address">PHP variables</a> and cookies</li>
		<li><a target="_blank" rel="noopener noreferrer" href="https://www.php.net/manual/en/reserved.variables.server.php">SERVER array</a></li>
	</ul>	
        <li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/css//default.asp">CSS Style Sheet References</a></li>
        <ul>
                <li><a target="_blank" rel="noopener noreferrer" href="https://www.w3schools.com/Css/tryit.asp?filename=trycss_template4">CSS Side Bar Style (Template 4)</a></li>
        </ul>
        <li>Error trapping functions and syntax in PHP:</li>
        <ul>
                <li><a target="_blank" rel="noopener noreferrer" href="https://code.tutsplus.com/php-isset-vs-empty-vs-is_null--cms-37162t#">envato tuts+</a></li>
        </ul>
        <li>For tab linkout functionality, a <a target="_blank" rel="noopener noreferrer" href="https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams">URL API</a> was used</li>
	<li>Syntax in <a> tag to <a target="_blank" rel="noopener noreferrer" href="https://stackoverflow.com/questions/15551779/open-link-in-new-tab-or-window">open a website in a new tab.</a></li>
	<li><a target="_blank" rel="noopener noreferrer" href="https://resilienteducator.com/instructional-design/hanging-indents-in-html-and-css-for-instructional-designers/#:~:text=The%20style%20attribute%20value%20%E2%80%9Cpadding,negative%20value%20of%20%2D36px).">Hanging indents</a> in HTML</li>
	<li><a target="_blank" rel="noopener noreferrer" href="https://stackoverflow.com/questions/67467383/php-parse-dict-output-from-python-script">Parsing Python dictionaries</a> in PHP</li>
	<li>Using <a target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/watch?v=xHFzQ8QRjGU">sublinks</a> to easily navigate to different parts of a page.</li>
	<li><a target="_blank" rel="noopener noreferrer" href="https://biopython.org/docs/dev/Tutorial/chapter_msa.html">BioPython Modules</a></li>
	<ul>
		<li>Multiple Sequence Alignment Statistics</li>
		<li>Drawing the <a target="_blank" rel="noopener noreferrer" href="https://biopython.org/wiki/Phylo">Phylogenetic Tree</a></li>
		<li><a target="_blank" rel="noopener noreferrer" href="https://biopython.org/docs/1.76/api/Bio.Entrez.html">Entrez</a></li>
	</ul>
	<li>EMBOSS Tools:</li>
	<ul>
		<li><a target="_blank" rel="noopener noreferrer" href="https://emboss.sourceforge.net/apps/release/6.0/emboss/apps/plotcon.html">EMBOSS plotcon</a></li>
		<li><a target="_blank" rel="noopener noreferrer" href="https://emboss.sourceforge.net/apps/cvs/emboss/apps/showalign.html">EMBOSS showalign</a></li>
	</ul>
	<li>Multiple Sequence Alignment: <a target="_blank" rel="noopener noreferrer" href="https://github.com/hybsearch/clustalo">CLUSTALO</a></li>
	<li>Matplotlib</li>
	<ul>
		<li><a target="_blank" rel="noopener noreferrer" href="https://matplotlib.org/stable/gallery/pie_and_polar_charts/pie_and_donut_labels.html">Pie Chart</a></li>
	</ul>
</ul>
</hr>
<hr>
<h2 id='ai'>AI Statement:</h2>
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
	<li>Used to determine why certain programs were or were not running and generating output when written in PHP proc_open() vs exec() (e.g., proc_open() worked well for generating the MSA, but exec() was used to run IQ-TREE).</li>
	<li>To identify why the CSS stylesheet was only sometimes resetting the style for particular elements.</li>
	<li>Used to find specific resources when I couldn't find the exact fix for particularly tricky bugs when troubleshooting via Google searches.</li>
	<li>Used to help safely transfer all files required to run this webpage from a personal GitHub account to an anonymized GitHub.</li>
	<li>Used to help (troubleshoot) manage PHP session and session variables.</li>
	<li>Troubleshooting BioPython's Entrez.</li>
	<li>Troubleshooting website navigation (HTML buttons and reactivity, subtabs, dropdowns).</li>
</ul>
</hr>
<hr>
<h2 id='cite'>Citations:</h2>
	<div style="text-indent: -36px; padding-left: 36px;">Cock, P. J. A., Antao, T., Chang, J. T., Chapman, B. A., Cox, C. J., Dalke, A., Friedberg, I., Hamelryck, T., Kauff, F., Wilczynski, B., & De Hoon, M. J. L. (2009). Biopython: Freely available Python tools for computational molecular biology and bioinformatics. Bioinformatics, 25(11), 1422–1423. https://doi.org/10.1093/bioinformatics/btp163</div>
	<div style="text-indent: -36px; padding-left: 36px;">Krick, T., Verstraete, N., Alonso, L. G., Shub, D. A., Ferreiro, D. U., Shub, M., & Sánchez, I. E. (2014). Amino Acid metabolism conflicts with protein diversity. Molecular Biology and Evolution, 31(11), 2905–2912. https://doi.org/10.1093/molbev/msu228</div>
	<div style="text-indent: -36px; padding-left: 36px;">Nguyen, L.-T., Schmidt, H. A., Von Haeseler, A., & Minh, B. Q. (2015). IQ-TREE: A Fast and Effective Stochastic Algorithm for Estimating Maximum-Likelihood Phylogenies. Molecular Biology and Evolution, 32(1), 268–274. https://doi.org/10.1093/molbev/msu300</div>
	<div style="text-indent: -36px; padding-left: 36px;">Rice P., Longden I. and Bleasby A. EMBOSS: The European Molecular Biology Open Software Suite. Trends in Genetics. 2000 16(6):276-277</div>
	<div style="text-indent: -36px; padding-left: 36px;">Sigrist, C. J. A. (2002). PROSITE: A documented database using patterns and profiles as motif descriptors. Briefings in Bioinformatics, 3(3), 265–274. https://doi.org/10.1093/bib/3.3.265</div>
	<div style="text-indent: -36px; padding-left: 36px;">Zhang, C., Wang, Q., Li, Y., Teng, A., Hu, G., Wuyun, Q., & Zheng, W. (2024). The Historical Evolution and Significance of Multiple Sequence Alignment in Molecular Structure and Function Prediction. Biomolecules, 14(12), 1531. https://doi.org/10.3390/biom14121531</div>
</hr>
</div>
</body>
</html>
_BODY1;
?>
