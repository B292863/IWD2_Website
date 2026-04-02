<?php
session_start();
require_once 'login.php';

// Unique ID for the browser and the session, to uniquely identify this individuals browser session
// Reference: https://stackoverflow.com/questions/6500654/php-cookies-and-session-variables-and-ip-address
// Reference: https://www.php.net/manual/en/reserved.variables.server.php
$_SESSION['user'] = $_SERVER['HTTP_USER_AGENT'];
// https://www.tutorialspoint.com/php/php_function_session_id.htm
$_SESSION['session_id'] = session_id(); 

include 'available_databases.php';

// Overwrite the stylesheet for home page specific style options
// Reference: https://www.w3schools.com/html/html_table_borders.asp
echo<<<_HEAD1
<html>
<body>
<style>
.div2 {
  border-radius: 25px;
  background-color: AntiqueWhite;
  padding: 20px;
  width: 100%;
  height: 100px;
}
#div3 {
  border-radius: 25px;
  background-color: AntiqueWhite; 
  padding: 20px;
  width: 100%;
  height: 270px;
}
</style>
_HEAD1;
include 'menuf.php';
// The different data selection options submission boxes are generated here
echo<<<_BODY1
<div class="content">
<div class="sub_box">
<center><h1>Home Page</h1></center>
</div>
<p> </p>

<hr></hr>
<h2>Data Selection: </h2>

<p><i><b>Note:</b> If a selection has not been made, attempting to access the functionality pages (Conservation Analysis, MSA, Phylogenetic Analysis, Data Download) will redirect the user back to the home page.</i></p>

<table style="width:100%">
	<tr>
		<th><div class="div2"><h3><b>Option 1:</b> Make a Search</h3></div></th>
		<th><div class="div2"><h3><b>Option 2:</b> Select Previous Searches</h3></div></th>
		<th><div class="div2"><h3><b>Option 3:</b> Use Example Dataset</h3></div></th>
	</tr>
	<tr>
		<td><div id="div3"><form action="data_choice.php" method="post">
			<p><b>Family (Taxonomic):</b> <input type="text" name="family"><br> <i>e.g., Aves</i></p>
			<p><b>Protein Name:</b> <input type="text" name="protein"><br> <i>e.g., Glucose-6-Phosphatase</i></p>
		<!-- Reference: https://www.w3schools.com/tags/tryit.asp?filename=tryhtml5_input_type_checkbox -->
		<input type="checkbox" id="string" name="string" value="string">
		<label for="string">Conduct NCBI Search without Tags (Less Stringent)</label><br>
		<p></p>
		<input type="submit">
		</form>
_BODY1;
		// If the NCBI search returned 0 results, return that as a message to the user		
		if (!empty($_SESSION['message'])) {
			echo $_SESSION['message'];
			// Reset session variable
			unset($_SESSION['message']);
		}

		// If either a protein or a family was not specified, print a message to the screen
                if (!empty($_SESSION['message1'])) {
                        echo $_SESSION['message1'];
                        // Reset session variable
                        unset($_SESSION['message1']);
		}

		echo "</div>";
		echo "</td>";
		echo "<td>";
		
		// Only allow users to see and use previous data searches if previous searches were actually made
		// https://www.php.net/manual/en/function.empty.php
		echo "<div id='div3'>";
		if (!empty($_SESSION['previous_rows'])) { // Check if the first row exists
			echo "<p><b>Previous Search Datasets:</b></p>";
			echo '<form action="data_choice.php" method="post">';
			foreach ($_SESSION['previous_rows'] as $row) {
				if (!empty($row)) {
					echo "<div>";
					echo '<input type="radio" id="t" name="table_name" value="'. htmlspecialchars($row['table_name']) .'">';
					echo '<label for="t">' . htmlspecialchars($row['family']) . " " . htmlspecialchars($row['protein']) . '</label><br>';
				}
			}
			echo "<p></p>";
			echo '<button type="submit" name="old_search">Use Previous Search</button>';
			echo "</form>";
		} else {
			echo "No previous database to select from";
		}
		echo "</td>";
		echo "</div>";
		?>
<?php
echo<<<_BODY2
		<td><div id="div3"><form action="data_choice.php" method="post">
			<p><b>Family:</b> Aves</p>
			<p><b>Protein:</b> Glucose-6-Phosphatase</p>
			<button type="submit" name="example_data">Example Data</button>
		</form></div></td>
	</tr>

</table>
</div>
</body>
</html>
_BODY2;
?>
