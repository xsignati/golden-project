<?php
class Database{
	protected $serverName;
	protected $userName;
	protected $password;
	protected $dbName;
	protected $connection;

	public function __construct($serverName, $userName, $password, $dbName){
		$this->serverName = $serverName;
		$this->userName = $userName;
		$this->password = $password;
		$this->dbName = $dbName;
	}
	
	public function createDatabase(){
		//try to connect to DB
		if($this->connection->connect_error) return false;
		//Create a new DB if it doesnt exist
		$selectedDB= mysqli_select_db($this->connection,$this->dbName);
		if(!$selectedDB){
			// Create database
			$sql = "CREATE DATABASE `$this->dbName`";
			if ($this->connection->query($sql) === TRUE) {
				echo "Database created successfully";
			} else {
				echo "Error creating database: " . $this->connection->error;
				return false;
			}
			mysqli_select_db($this->connection,$this->dbName);
			
			$this->createTables();
		}
		$this->createTables();
	}
	
	public function connectDatabase(){
		// Connect to database
		$this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);
		if ($this->connection->connect_error) {
			die("Connection failed: " . $this->connection->connect_error);
			return false;
		} 
		else return true;
	}
	
	public function createTables(){
		$sql = "CREATE TABLE IF NOT EXISTS news DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci (
		id int NOT NULL AUTO_INCREMENT,
		type VARCHAR(255),
		date DATETIME DEFAULT CURRENT_TIMESTAMP,
		title VARCHAR(255),
		content TEXT,
		PRIMARY KEY (id)
		)";

		if ($this->connection->query($sql) === TRUE) {
			echo "Table news created successfully";
		} else {
			echo "Error creating table news: " . $this->connection->error;
			return false;
		}
		
		$sql = "CREATE TABLE IF NOT EXISTS images DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci (
		id int NOT NULL AUTO_INCREMENT,
		type VARCHAR(255),
		path VARCHAR(255),
		PRIMARY KEY (id)
		)";

		if ($this->connection->query($sql) === TRUE) {
			echo "Table images created successfully";
		} else {
			echo "Error creating table images: " . $this->connection->error;
			return false;
		}
		
		$sql = "CREATE TABLE IF NOT EXISTS index_texts DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci(
		id int NOT NULL AUTO_INCREMENT,
		type VARCHAR(255),
		content TEXT,
		path TEXT,
		PRIMARY KEY (id)
		)";

		if ($this->connection->query($sql) === TRUE) {
			echo "Table index_texts created successfully";
		} else {
			echo "Error creating table index_texts: " . $this->connection->error;
			return false;
		}
	}
	
	public function getConnection()
    {
          return $this->connection;
    }
}
?>