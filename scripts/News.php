<?php
include 'Database.php';
include 'databaseInfo.php';

$rowCount = 4;
$rowStart = $_POST['rowStart'];
$database = new Database($serverName, $userName, $password, $dbName);
$connection = $database->connectDatabase();
if((isset($rowStart) || !empty($rowStart)) && !$connection->connect_error){
	$query = "SELECT id, date, title, imgUrl, newsText
			FROM news
            ORDER BY date
            LIMIT $rowStart, $rowCount";
	$result = $connection->query($query);
	$dataToSend = array();
	while($resultSet = mysqli_fetch_assoc($result)) {
		$dataToSend[] = ['tag' => $resultSet['id'].$resultSet['title'], 'date' => $resultSet['date'], 'title' => $resultSet['title'], 'text' => $resultSet['newsText'], 'imageLink' => $resultSet['imgUrl']];
	}
	
	echo json_encode($dataToSend);
}

?>