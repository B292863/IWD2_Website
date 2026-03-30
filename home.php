<?php
session_start();
// include 'redir.php';
require_once 'login.php';

// Reference: https://stackoverflow.com/questions/6500654/php-cookies-and-session-variables-and-ip-address
// Reference: https://www.php.net/manual/en/reserved.variables.server.php
$_SESSION['user'] = $_SERVER['HTTP_USER_AGENT'];
// https://www.tutorialspoint.com/php/php_function_session_id.htm
$_SESSION['session_id'] = session_id(); 

include 'available_databases.php';

// Initialize session variables
// $_SESSION['selection'] = $_SESSION['selection'] ?? null;
// $_SESSION['family'] = $_SESSION['family'] ?? null;
// $_SESSION['protein'] = $_SESSION['protein'] ?? null;

// $_SESSION['host'] = get_browser($_SERVER['REMOTE_HOST']);
// $browsername = $browserinfo['browser'];
// $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
// echo $_SESSION['user'];

// Reference: https://www.w3schools.com/html/html_table_borders.asp
// FINISH
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
  height: 500px;
}
</style>
_HEAD1;
include 'menuf.php';
echo<<<_BODY1
<div class="content">
<div class="sub_box">
<center><h1>Home Page</h1></center>
</div>
<p> </p>
<hr></hr>
<h2>Data Selection: </h2>

<table style="width:100%">
	<tr>
		<th><div class="div2"><h3><b>Option 1:</b> Make your Search</h3></div></th>
		<th><div class="div2"><h3><b>Option 2:</b> Select Previous Searches</h3></div></th>
		<th><div class="div2"><h3><b>Option 3:</b> Use Example Dataset</h3></div></th>
	</tr>
	<tr>
		<td><div id="div3"><form action="data_choice.php" method="post">
			<p><b>Family (Taxonomic):</b> <input type="text" name="family"><br> <i>e.g., Aves</i></p>
			<p><b>Protein Name:</b> <input type="text" name="protein"><br> <i>e.g., Glucose-6-Phosphatase</i></p>
		<input type="submit">
		</form>
_BODY1;
		
		if (!empty($_SESSION['message'])) {
			echo $_SESSION['message'];
			// Reset session variable
			unset($_SESSION['message']);
		}
		echo "</div>";
		echo "</td>";
		echo "<td>";

		// https://www.php.net/manual/en/function.empty.php
		echo "<div id='div3'>";
		if (!empty($_SESSION['previous_rows'])) { // Check if the first row exists
			foreach ($_SESSION['previous_rows'] as $row) {
				if (!empty($row)) {
					echo "<div>";
					echo "<p><b>Previous Search Dataset:</b>";
					echo htmlspecialchars($row['family']) . " " . htmlspecialchars($row['protein']);
					$_SESSION['previous'] = $row['table_name'];
					echo '<form action="data_choice.php" method="post">';
						echo '<button type="submit" name="old_search">Previous Search</button>';
					echo "</form>";
					echo "</p>";
					echo "</div>";
				}
			}
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
