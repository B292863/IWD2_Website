<?php
require_once 'login.php';
require_once 'redir.php';
include 'menuf.php';
include 'cons_plot.php';
?>
<html>
<body>
<link rel="stylesheet" href="style.css">
<div class="content">
<div class="sub_box">
<h1 align="center">Residue Conservation Plot</h1>
</div>
<p> </p>

<div id="div1">
<p>A sequence conservation plot represents the degree of conservation across residues in the inputted protein sequences</p>
<--! FINISH -->
<p>Regions of elevated residue similarity represents homology, which can indicate something about the </p>

<?php
$img = "/tmp/plotcon.1.png";

if (file_exists($img)) {
	echo '<img src=get_cons_plot.php alt="Residue Conservation Plot" width="500" height="600" class="center">';
} else {
	echo '<p align="center">No Residue Conservation Plot Exists</p>';
}
?>
</div>
</div>
</body>
</html>
