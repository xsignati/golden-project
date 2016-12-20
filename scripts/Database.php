<?php
public class Database{
private $serverName = "localhost";
private $userName = "root";
private $password = "";
private $dbName = "db";
private $connection;
//$conn = new mysqli($serverName, $userName, $password, $dbName);
	public createDatabase(){
		//try to connect to DB
		if($connection->connect_error) return false;
		//Create a new DB if it doesnt exist
		$selectedDB= mysqli_select_db($connection,$dbName);
		if(!$selectedDB){
			// Create database
			$sql = "CREATE DATABASE `$dbName`";
			if ($conn->query($sql) === TRUE) {
				echo "Database created successfully";
			} else {
				echo "Error creating database: " . $conn->error;
				return false;
			}
			mysqli_select_db($conn,$dbName);
		}
	}
	
	public connectDatabase(){
		// Connect to database
		$this->connection = new mysqli($serverName, $userName, $password);
		if ($connection->connect_error) {
			die("Connection failed: " . $conn->connect_error);
			return null;
		} 
		else return $connection;
	}
	
	public createTables(){
		
		$sql = "CREATE TABLE news (
		id int NOT NULL AUTO_INCREMENT,
		type VARCHAR(30),
		date VARCHAR(30) NOT NULL,
		title VARCHAR(255)
		content TEXT,
		PRIMARY KEY (ID)
		)";

		if ($conn->query($sql) === TRUE) {
			echo "Table created successfully";
		} else {
			echo "Error creating table General: " . $conn->error;
			return false;
		}
	}
	
	
}
?>