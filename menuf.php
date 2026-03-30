<html>
<head>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<title>Protein Family Analyzer</title>
</head>
<body>
<?php
require_once 'login.php';
echo <<<_MENU1
<div class="sidenav">
    <a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/home.php"> Home </a>
    <a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/about.php"> About </a>
    <a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/help.php"> Help </a>
    <a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/credits.php"> Statement of Credits </a>
    <a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/a1.php"> Conservation Analysis </a>
    <div class="subnav">
    <button class="subnavbtn"> Multiple Sequence Analysis <i class="fa fa-caret-down"></i></button> 
	<div class="subnav-content">
		<a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/a2.php">Multiple Sequence Alignment</a>
		<a href="a2.php?tab=MSA_stats">Multiple Sequence Alignment Statistics</a>
	</div>	
    </div>
    <a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/a3.php"> Motif Analysis </a>
    <a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/a4.php"> Phylogenetic Analysis </a>
    <a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/a5.php"> InterPro Functionality </a>
    <a href="https://bioinfmsc8.bio.ed.ac.uk/~{$username}/iwd2_website/fasta.php"> Data Download </a>
</div>
_MENU1;
?>
<div class="content">
<div class="head_box">
<center><h1><b>Protein Family Analyzer!</b></h1></center>
<center>Welcome to the Protein Family Analyzer, your one stop shop for all things Protein!</center>
</div>
</div>
</body>
</html>
