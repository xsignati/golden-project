<?php
include 'Database.php';
include 'databaseInfo.php';

$rowCount = 3;
$rowStart = $_POST['rowStart'];
$database = new Database($serverName, $userName, $password, $dbName);
if((isset($rowStart) || !empty($rowStart)) && $database->connectDatabase()){
	$connection = $database->getConnection();
	$query = "SELECT
	news.type, news.date, news.title, news.content, images.path
	FROM news
	LEFT JOIN
	images
	ON news.type = images.type
	ORDER BY news.date
	LIMIT $rowStart, $rowCount";
	$result = $connection->query($query);
	$dataToSend = array();
	$i=0;
	while($resultSet = mysqli_fetch_assoc($result)) {
		$dataToSend[$i++] = ['type' => $resultSet['type'], 'date' => $resultSet['date'], 'title' => $resultSet['title'], 'content' => $resultSet['content'], 'path' => $resultSet['path']];
	}
	
	echo json_encode($dataToSend);
}

?>