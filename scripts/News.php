<?php
include 'Database.php';
include '../scripts/DatabaseInfo.php';
/*
 * How many rows obtain
 */
$rowCount = 4;

/*
 * Connect to database to obtain news
 */
$database = new Database($serverName, $userName, $password, $dbName);
$connection = $database->connectDatabase();

$rowStart = $connection->real_escape_string($_POST['rowStart']); //< 
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
	echo json_encode($dataToSend); //< send news to client
}

?>