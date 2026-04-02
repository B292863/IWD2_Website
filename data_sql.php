<?php
session_start();
require_once 'login.php';

// Purpose: Add the data to a MySQL data table

// Set up filename and take relevant session variables
$tmpfa = '/tmp/search_fasta.fa';
$family = $_SESSION['family'];
$protein = $_SESSION['protein'];

// Make sure that the search fasta file (NCBI) exists (search successful)
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
	// Set unique names to stringent/non stringent search so same search term will not be overwritten
	if (isset($_SESSION['stringent']) && !empty($_SESSION['stringent'])) {
		$table = $str_family . "_" . $str_pro . "_gensearch";
		// Unset the 'stringent' variable after the search has been made
                unset($_SESSION['stringent']);
	}
	else {
		$table = $str_family . "_" . $str_pro;
	}

	// Removing the data table if it already exists
	try {
		$dropmysql = "DROP TABLE IF EXISTS `$table`";
		$pdo->exec($dropmysql);
	} catch (PDOException $e) {
		echo "Error removing table: " . $dropmysql . "<br>" . $e->getMessage();
	}

	// Creating the data table: https://www.w3schools.com/php/php_mysql_create_table.asp
	// https://stackoverflow.com/questions/1650946/mysql-create-table-if-not-exists-error-1050
	// Organism data type was changed to be more flexible and not break the table
	try {
		$mysql1 = "CREATE TABLE IF NOT EXISTS `$table` (
		`id` VARCHAR(255) NOT NULL PRIMARY KEY,
		`protein` VARCHAR(255)  NOT NULL,
		`organism` TEXT  NOT NULL,
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

	$lines = file($tmpfa);
	
	// For loop to extract all the data from each line in the fasta file
	foreach ($lines as $line) {
		$line = trim($line); // trim() = https://www.w3schools.com/php/func_string_trim.asp
	
		// Header line: 
		if (strpos($line, '>') === 0) {
			if (!$line) continue;

			// Add previous entry to the table
			if ($id) {
			// Add data, row by row
				try {
					$mysql2 = "INSERT INTO `$table` VALUES ('$id', '$prot', '$org', '$seq');";
					$pdo->exec($mysql2);
				} catch (PDOException $e) {
					echo $mysql2 . "<br>" . $e->getMessage();
				}
			}

			// Obtain data from header
			$seq = ''; // empty variable
			$header = substr($line, 1);
			// Safely extract 
			// Reference: https://www.w3schools.com/php/func_regex_preg_match.asp
			if (preg_match('/^(\S+)\s+\[(.*?)]\s+\[(.*?)]/', $header, $hit)) {
				// Ensure that all the entries can be safely put into a MySQL table
				$id = str_replace("'","\\'",$hit[1]);
				$prot = str_replace("'","\\'",$hit[2]);
				$org = str_replace("'","\\'",$hit[3]);
	
			}
		} else {
			$seq .= $line; // get sequence data
		}
	}
	
	// Last sequence
	if ($id) {
		try {
			$mysql2 = "INSERT INTO `$table` VALUES ('$id', '$prot', '$org', '$seq');";
			$pdo->exec($mysql2);
		} catch (PDOException $e) {
			echo $mysql2 . "<br>" . $e->getMessage();

		}
	}

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
        } catch (PDOException $e) {
                echo $metasql . "<br>" . $e->getMessage();
	}

	$pdo = null;
	
// Set the session variable table and return to home page
	$_SESSION['table'] = $table;
	$_SESSION['search_message'] = 'Results Generated!';
	header("Location: home.php");
	exit();
}

// FINISH!!
?>
