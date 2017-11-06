<?php
class User {

	$hostname = "sql2.njit.edu";
	$username = "akl25";
	$password = "9TCE4kP41";
	$conn = NULL;
	try 
	{
	    $conn = new PDO("mysql:host=$hostname;dbname=akl25",
	    $username, $password);
	    echo "<p>Connected successfully<br></p>";
	}
	catch(PDOException $e)
	{
		// echo "Connection failed: " . $e->getMessage();
		http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage().'<br>');
	}
}

// Runs SQL query and returns results (if valid)
function runQuery($query) {
	global $conn;
    try {
		$q = $conn->prepare($query);
		$q->execute();
		$results = $q->fetchAll();
		$q->closeCursor();
		return $results;	
	} catch (PDOException $e) {
		http_error("500 Internal Server Error\n\n"."There was a SQL error:\n\n" . $e->getMessage()."<br>");
	}	  
}

function http_error($message) 
{
	header("Content-type: text/plain");
	die($message);
}

$sql = "select * from accounts where id < 6  ";
$results = runQuery($sql);
if(count($results) > 0)
{
	echo "Number of records: ".count($results)."<br><br>";
	echo "<table border=\"1\"><tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Birthday</th><th>Gender</th><th>Pass</th></tr>";
	foreach ($results as $row) {
		echo "<tr><td>".$row["id"]."</td><td>".$row["email"]."</td><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["phone"]."</td><td>".$row["birthday"]."</td><td>".$row["gender"]."</td><td>".$row["password"]."</td></tr>";
	}
	
}else{
    echo '0 results';
}
?>