<?php
include 'Database.php';
include 'databaseInfo.php';

$rowCount = 3;
$rowStart = $_POST['rowStart'];
$database = new Database($serverName, $userName, $password, $dbName);
if((isset($rowStart) || !empty($rowStart)) && $database->connectDatabase()){
	$connection = $database->getConnection();
	$query = "SELECT date, title, content
			FROM news
			ORDER BY date 
			LIMIT $rowStart, $rowCount";
	$result = $connection->query($query);
	$dataToSend = array();
	$i=0;
	while($resultSet = mysqli_fetch_assoc($result)) {
		$dataToSend[$i++] = ['date' => $resultSet['date'], 'title' => $resultSet['title'], 'content' => $resultSet['content']];
	}
	
	echo json_encode($dataToSend);
}

?>