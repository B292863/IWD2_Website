<?php
require_once 'login.php';
require_once 'redir.php';
include 'menuf.php';
// Purpose: Sets up the Conservation Analysis Page

echo<<<HEAD_
<html>
<body>
<link rel="stylesheet" href="style.css">
<div class="content">
<div class="sub_box">
<h1 align="center">Residue Conservation Plot</h1>
</div>
<p> </p>

<div id="div1">
<p>A sequence conservation plot represents the degree of conservation across residues in the inputted protein sequences.</p>
<p>For further analysis, the conservation plot can be altered by increasing or decreasing the window size in which the sequence similarity is computed and averaged over. If the default (4) seems too noisy, the window size can be increased to smooth the conservation plot to more accurately identify conserved regions.</p>
HEAD_;

// Assign the name of the conservation plot output to a variable
$img = "/tmp/plotcon.1.png";

// Set up the form to allow users to change the window size
echo<<<FORM_
<form action="a1.php" method="post">
  <p><b>Window Size:</b> <input type="text" name="win_size"></p><p style="font-size: 10px;"><i>Default: 4</i></p>
  <input type="submit">
</form>
FORM_;

// Send window size request to the file that generates the conservation plot
// Reference: https://www.w3schools.com/php/func_var_intval.asp
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['win_size'])) {
	// Making the sure the input is a valid integer, else default window size is chosen	
	if (!is_int($_SESSION['win_size']) || ($_SESSION['win_size'] < 1 || trim($_POST['win_size']) == '')) {
		$_SESSION['win_size'] = 4;
		include 'cons_plot.php';
	} else {
		$_SESSION['win_size'] = intval($_POST['win_size']);
		include 'cons_plot.php';
	}
} else {
	$_SESSION['win_size'] = 4;
	include 'cons_plot.php';
}

// Print the plot the screen if it was generated!
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
