<?php
session_start();
require_once 'login.php';
// require_once 'redir.php';

// Purpose: Add the data to a MySQL data table

$tmpfa = '/tmp/search_fasta.fa';
$family = $_SESSION['family'];
$protein = $_SESSION['protein'];

if (file_exists($tmpfa) && is_readable($tmpfa)) {

	// Adding data to MySQL
	// Making the connection
	try {
        	$pdo = new PDO(
                	"mysql:host=$hostname;dbname=$database",
                	$username,
                	$password,
                	[
                        	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                	]
        	);

	} catch (PDOException $e) {
        	die("Database error " . $e->getMessage());
	}

	$str_family = str_replace(" ", "", $family);
	$str_family = str_replace("-", "", $str_family);
	$str_pro = str_replace(" ", "", $protein);
	$str_pro = str_replace("-", "", $str_pro);
	$table = $str_family . "_" . $str_pro;

	// Removing the data table if it already exists
	try {
		$dropmysql = "DROP TABLE IF EXISTS `$table`";
		$pdo->exec($dropmysql);
	} catch (PDOException $e) {
		echo "Error removing table: " . $dropmysql . "<br>" . $e->getMessage();
	}

	// Creating the data table: https://www.w3schools.com/php/php_mysql_create_table.asp
	// https://stackoverflow.com/questions/1650946/mysql-create-table-if-not-exists-error-1050
	try {
		$mysql1 = "CREATE TABLE IF NOT EXISTS `$table` (
		`id` VARCHAR(255) NOT NULL PRIMARY KEY,
		`protein` VARCHAR(255)  NOT NULL,
		`organism` VARCHAR(255)  NOT NULL,
		`sequence` TEXT  NOT NULL
		);";
		$pdo->exec($mysql1);
		// Troubleshooting comment
		// echo "$table created successfully";
	} catch (PDOException $e) {
		echo "Error creating table: " . $mysql1 . "<br>" . $e->getMessage();
	}

	// Process the FASTA data: https://stackoverflow.com/questions/54980654/parse-a-fasta-file-using-php?utm_source=chatgpt.com
	
	// Initialize variables
	$id = '';
	$prot = '';
	$org = '';
	$seq = '';

	$lines = file($tmpfa); //or die("Unable to open file)

	foreach ($lines as $line) {
		$line = trim($line); // trim() = https://www.w3schools.com/php/func_string_trim.asp
	
		// Header line
		if (strpos($line, '>') === 0) {
			if (!$line) continue;

			// Add previous entry to the table
			if ($id) {
			// Add data, row by row
				try {
					$mysql2 = "INSERT INTO `$table` VALUES ('$id', '$prot', '$org', '$seq');";
					$pdo->exec($mysql2);
					// Troubleshooting
					// echo "New record succesfully added";
				} catch (PDOException $e) {
					echo $mysql2 . "<br>" . $e->getMessage();
				}
			}

			// Obtain data from header
			$seq = ''; // empty variable
			$header = substr($line, 1);
			$description = explode(" ",$header);
			$id = $description[0];
			$prot = $description[1];
			$org_bits = array_slice($description,2,);
			$org1 = implode(" ", $org_bits);
			$org2 = str_replace("[","",$org1);
			$org3 = str_replace("]","",$org2);
			$org = str_replace("'", "\\'",$org3); // UPDATED
		} else {
			$seq .= $line; // get sequence data
		}
	}
	
	// Last sequence
	if ($id) {
		try {
			$mysql2 = "INSERT INTO `$table` VALUES ('$id', '$prot', '$org', '$seq');";
			$pdo->exec($mysql2);
			// Troubleshooting statement
			// echo "New record succesfully added";
		} catch (PDOException $e) {
			echo $mysql2 . "<br>" . $e->getMessage();
		}
	}

	// echo "success";

	// Add the info into the metadata table
	// https://www.geeksforgeeks.org/php/how-to-extract-day-month-and-year-in-php/
	// https://www.php.net/manual/en/datetime.format.php
	$datetime = new DateTime();
	$date = $datetime->format('Y-m-d H:i:s');
	$user = $_SESSION['user'];
	$session_id = $_SESSION['session_id'];
	
	try {
		$metasql = "INSERT INTO `tables` VALUES ('$table', '$user', '$family', '$protein', '$date', '$session_id');";
                $pdo->exec($metasql);
                // Troubleshooting comment
                // echo "$table created successfully";
        } catch (PDOException $e) {
                echo $metasql . "<br>" . $e->getMessage();
	}

	$pdo = null;
	
// Set the session variable table
	$_SESSION['table'] = $table;
	$_SESSION['search_message'] = 'Results Generated!';
	header("Location: home.php");
	exit();
}

// FINISH!!
?>
