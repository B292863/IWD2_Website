<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

// Purpose: access the names of data tables corresponding to the previous search

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
	
	// https://dev.mysql.com/doc/refman/8.4/en/information-schema.html
	$user = $_SESSION['user'];
	$session_id = $_SESSION['session_id'];
	
	// https://www.tutorialspoint.com/article/get-the-second-last-row-of-a-table-in-mysql#:~:text=You%20need%20to%20use%20ORDER,let%20us%20create%20a%20table.
	$sql = "SELECT table_name,family,protein FROM tables WHERE browser_info = '$user' AND session_id = '$session_id' ORDER BY date_created DESC limit 5;";

	$stmt = $pdo->query($sql);
	
	// Return Array of values: https://www.php.net/manual/en/pdostatement.fetch.php	
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// var_dump($rows);
	if ($rows) { // Testing if there is a previous database available in this session
		$i = 0;
		
		// Reference ?: = https://www.w3schools.com/php/php_operators.asp
		$_SESSION['previous_rows'] = $rows ?: [];
	} else {
		$_SESSION['previous'] = null;
		$_SESSION['previous_fam'] = null;
		$_SESSION['previous_prot'] = null;
	}

} catch (PDOException $e) {
	die("Database error " . $e->getMessage());

}
?>
