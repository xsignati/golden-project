<?php
include 'Database.php';
include 'databaseInfo.php';

$rowCount = 3;
$rowStart = $_POST['rowStart'];
$database = new Database($serverName, $userName, $password, $dbName);
$connection = $database->connectDatabase();
if((isset($rowStart) || !empty($rowStart)) && !$connection->connect_error){
	$query = "SELECT 
			elements.type as tag, dates.date, minitexts.miniText as title, texts.text, links.link as imageLink
			FROM elements
			LEFT JOIN
			links
            ON elements.type = links.type
            LEFT JOIN
            dates
            ON elements.type = dates.type
            LEFT JOIN
            minitexts
            ON elements.type = minitexts.type
            LEFT JOIN
            texts
            ON elements.type = texts.type
            WHERE elements.destination = 'news'
            ORDER BY dates.date
            LIMIT $rowStart, $rowCount";
	$result = $connection->query($query);
	$dataToSend = array();
	while($resultSet = mysqli_fetch_assoc($result)) {
		$dataToSend[] = ['tag' => $resultSet['tag'], 'date' => $resultSet['date'], 'title' => $resultSet['title'], 'text' => $resultSet['text'], 'imageLink' => $resultSet['imageLink']];
	}
	
	echo json_encode($dataToSend);
}

?>