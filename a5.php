<?php
include 'menuf.php';
echo <<<HEAD_
<body>
<link rel="stylesheet" href="style.css">
<div class="content">
<div class="sub_box">
<h1 align=center>InterPro</h1>
</div>
<p> </p>

<iframe src="https://www.ebi.ac.uk/interpro/search/sequence/" width="100%" height="1000" frameBorder = "0" class="center"></iframe>
</div>
</body>
HEAD_
?>
