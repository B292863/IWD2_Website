<?php
require_once 'login.php';
require_once 'redir.php';
include 'menuf.php';
include 'phylo_tree.php';

$tree = "/tmp/tree.png";
// if (!file_exists($tree)) {
//	echo "Tree is still being generated, thank you for your patience!";
// }

echo <<<HEAD_
<!-- Resource: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_image_center -->
<html>
<body>
<link rel="stylesheet" href="style.css">
<div class='content'>
<div class="sub_box">
<h1 align=center>Phylogenetic Analysis</h1>
</div>
</div>
HEAD_;

// Reference: https://www.w3schools.com/tags/tag_meta.asp
//
if (!file_exists($tree)) {
	echo "<div class='content'>";
	echo '<meta http-equiv="refresh" content="30">';
	echo "</div";
} else {
	echo "<div class='content'>";
	echo '<img src="get_phylo_tree.php" alt="Gene Tree" width="500" height="600" class="center">';
	echo "</div>";
}

echo <<<END_
</html>
</body>
END_
?>
