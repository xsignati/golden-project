<?php
include 'Database.php';
include 'databaseInfo.php';

$database = new Database($serverName, $userName, $password, $dbName);
if ($database->connectDatabase()){
	$connection = $database->getConnection();
	$query = "SELECT 
	index_texts.type, index_texts.content, index_texts.path
	FROM index_texts
	LEFT JOIN
	images
	ON index_texts.type = images.type";
	$result = $connection->query($query);
	$dataToSend = array();
	$i=0;
	while($resultSet = mysqli_fetch_assoc($result)) {
		$dataToSend[$i++] = ['type' => $resultSet['type'], 'content' => $resultSet['content'], 'path' => $resultSet['path']];
	}
	
	echo json_encode($dataToSend);
}

?>