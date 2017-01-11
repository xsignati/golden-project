<?php
include "../scripts/Template.php";
include "../scripts/Database.php";
include "../scripts/DatabaseInfo.php";

$template = new Template;
$database = new Database($serverName, $userName, $password, $dbName);

/**
 * Load data for header from database
 */
$preloads	= array();
$connection = $database->connectDatabase();
if($connection->connect_error){
	die("Couldn't connect to db " . $connection->connect_error);
}
$query = "SELECT name, content, destination
		  FROM maincontents
		  WHERE siteID = 'header'";
$result = $connection->query($query);
while($resultSet = mysqli_fetch_assoc($result)){
	$preloads[$resultSet['name']] = $resultSet['content'];
}
extract($preloads);
$result->close();


/**
 * Add a header
 */
include("../tpl/header.phtml");

/**
 * Add a choosen subpage
 */
$action = 'index';
if(!empty($_GET['action'])){
	$reqAction = basename($_GET['action']);
	if(file_exists($reqAction.".php")){
		$action = $reqAction;
	}
}
include ($action.".php");

/**
 * Add a footer
 */
include("../tpl/footer.phtml");

/**
 * Close database connection
 */
$connection->close();
?>