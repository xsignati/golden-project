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
			$sql = "CREATE DATABASE `$this->dbName` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
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
		$this->loadDefault();
	}
	
	public function connectDatabase(){
		// Connect to database
		$this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);
		mysqli_set_charset($this->connection,"UTF8");
		return $this->connection;
	}
	
		public function connectServer(){
		// Connect to server
		$this->connection = new mysqli($this->serverName, $this->userName, $this->password);
		mysqli_set_charset($this->connection,"UTF8");
		return $this->connection;
	}
	
	public function createTables(){
		$sql = "CREATE TABLE IF NOT EXISTS news (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		date DATETIME DEFAULT CURRENT_TIMESTAMP,
		title VARCHAR(255),
		newsText TEXT,
		imgUrl VARCHAR(255),
		PRIMARY KEY (id)
		)";

		if ($this->connection->query($sql) === TRUE) {
			echo "Table news created successfully";
		} else {
			echo "Error creating table news: " . $this->connection->error;
			return false;
		}
		
		$sql = "CREATE TABLE IF NOT EXISTS photos (
		id bigint(20) NOT NULL AUTO_INCREMENT,
		photosetId bigint(20),
		imgUrlMax VARCHAR(255),
		imgUrlMin VARCHAR(255),
		PRIMARY KEY (id)
		)";

		if ($this->connection->query($sql) === TRUE) {
			echo "Table photos created successfully";
		} else {
			echo "Error creating table photos: " . $this->connection->error;
			return false;
		}
		
		$sql = "CREATE TABLE IF NOT EXISTS photosets(
		id int NOT NULL AUTO_INCREMENT,
		name VARCHAR(255),
		url TEXT,
		date DATETIME DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
		)";

		if ($this->connection->query($sql) === TRUE) {
			echo "Table photosets created successfully";
		} else {
			echo "Error creating table photosets: " . $this->connection->error;
			return false;
		}
		
		$sql = "CREATE TABLE IF NOT EXISTS maincontents(
		id bigint(20) NOT NULL AUTO_INCREMENT,
		siteID VARCHAR(255),
		content VARCHAR(255),
		name VARCHAR(255),
		destination VARCHAR(255),
		PRIMARY KEY (id)
		)";

		if ($this->connection->query($sql) === TRUE) {
			echo "Table maincontents created successfully";
		} else {
			echo "Error creating table maincontents: " . $this->connection->error;
			return false;
		}
		
		$sql = "CREATE TABLE IF NOT EXISTS menu(
		id bigint(20) NOT NULL AUTO_INCREMENT,
		subpageUrl VARCHAR(255),
		imgUrl VARCHAR(255),
		subpageText VARCHAR(255),
		PRIMARY KEY (id)
		)";

		if ($this->connection->query($sql) === TRUE) {
			echo "Table menu created successfully";
		} else {
			echo "Error creating table menu: " . $this->connection->error;
			return false;
		}
		
		$sql = "CREATE TABLE IF NOT EXISTS cms_errors(
		id bigint(20) NOT NULL AUTO_INCREMENT,
		error VARCHAR(255),
		PRIMARY KEY (id)
		)";

		if ($this->connection->query($sql) === TRUE) {
			echo "Table cms_errors created successfully";
		} else {
			echo "Error creating table cms_errors: " . $this->connection->error;
			return false;
		}
	}
	
	public function loadDefault(){
		$json = file_get_contents("../install/maincontents.json");
		$json = json_decode($json, true);
		foreach($json as $key => $value){
			$query 	= "INSERT INTO maincontents (siteID, name, content, destination)
					   VALUES ('".$value['siteID']."','".$value['name']."','".$value['content']."','".$value['destination']."')";
			$this->connection->query($query);
		}
		
		$json = file_get_contents("../install/menu.json");
		$json = json_decode($json, true);
		foreach($json as $key => $value){
			$query 	= "INSERT INTO menu (subpageUrl, imgUrl, subpageText)
					   VALUES ('".$value['subpageUrl']."','".$value['imgUrl']."','".$value['subpageText']."')";
			$this->connection->query($query);
		}
		
		$json = file_get_contents("../install/cms_errors.json");
		$json = json_decode($json, true);
		foreach($json as $key => $value){
			$query 	= "INSERT INTO cms_errors (error)
					   VALUES ('".$value['error']."')";
			$this->connection->query($query);
		}
	}
}
?>