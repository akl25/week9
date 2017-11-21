<?php
class User {

	var $id;
	var $email;
	var $fname;
	var $lname;
	var $phone;
	var $birhtday;
	var $gender;
	var $password;

	function __construct() 
	{
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
	private function runQuery($query) 
	{
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

	private function http_error($message) 
	{
		header("Content-type: text/plain");
		die($message);
	}

	public function select() 
	{
		$sql = "select * from accounts";
		$results = self::runQuery($sql);
		if(count($results) > 0)
		{
			echo "<table border=\"1\"><tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Birthday</th><th>Gender</th><th>Pass</th></tr>";
			foreach ($results as $row) 
			{
				echo "<tr><td>".$row["id"]."</td><td>".$row["email"]."</td><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["phone"]."</td><td>".$row["birthday"]."</td><td>".$row["gender"]."</td><td>".$row["password"]."</td></tr>";
			}
			
		}
		else
		{
		    echo '0 results';
		}
	}

	public function insert($id, $email, $fname, $lname, $phone, $birthday, $gender, $password) 
	{
		$this->$id = $id;
		$this->$email = $email;
		$this->$fname = $fname;
		$this->$lname = $lname;
		$this->$phone = $phone;
		$this->$birthday = $birthday;
		$this->$gender = $gender;
		$this->$password = $password;

		$sql = "insert into accounts values (".$id.",".$email.",".$fname.",".$lname.",".$phone.",".$birthday.",".$gender.",".$password.")";
		$results = $this->runQuery($sql);
		if(count($results) > 0)
		{
			echo "<table border=\"1\"><tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Birthday</th><th>Gender</th><th>Pass</th></tr>";
			foreach ($results as $row) 
			{
				echo "<tr><td>".$row["id"]."</td><td>".$row["email"]."</td><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["phone"]."</td><td>".$row["birthday"]."</td><td>".$row["gender"]."</td><td>".$row["password"]."</td></tr>";
			}
			
		}
		else
		{
		    echo '0 results';
		}
	}

	public function delete($email) 
	{
		$this->$email = $email;

		$sql = "delete from accounts where email=".$email;
		$results = $this->runQuery($sql);
		if(count($results) > 0)
		{
			echo "<table border=\"1\"><tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Birthday</th><th>Gender</th><th>Pass</th></tr>";
			foreach ($results as $row) 
			{
				echo "<tr><td>".$row["id"]."</td><td>".$row["email"]."</td><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["phone"]."</td><td>".$row["birthday"]."</td><td>".$row["gender"]."</td><td>".$row["password"]."</td></tr>";
			}
			
		}
		else
		{
		    echo '0 results';
		}
	}

	function update($fname, $lname, $password) 
	{
		$this->$fname = $fname;
		$this->$lname = $lname;
		$this->$password = $password;

		$sql = "update accounts set password=".$password." where fname=".$fname." and lname=".$lname;
		$results = $this->runQuery($sql);
		if(count($results) > 0)
		{
			echo "<table border=\"1\"><tr><th>ID</th><th>Email</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Birthday</th><th>Gender</th><th>Pass</th></tr>";
			foreach ($results as $row) 
			{
				echo "<tr><td>".$row["id"]."</td><td>".$row["email"]."</td><td>".$row["fname"]."</td><td>".$row["lname"]."</td><td>".$row["phone"]."</td><td>".$row["birthday"]."</td><td>".$row["gender"]."</td><td>".$row["password"]."</td></tr>";
			}
			
		}
		else
		{
		    echo '0 results';
		}
	}
}

$user = new User();
echo $user->select();
echo $user->insert(13,"akl25@njit.edu","Alex","Lee","732-555-1234","1994-08-16","male", "test1234");
echo $user->delete("akl25@njit.edu");
echo $user->update("Alex","Lee","pw123");
?>