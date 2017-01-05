<?php
	$prefix = "../";
	include $prefix."scripts/Template.php";
	include $prefix."scripts/Database.php";
	include $prefix."scripts/DatabaseInfo.php";
	$hypertextPath = $prefix."tpl/index.phtml";
	$sheetPath = $prefix."tpl/index.pcss";
	$sheetTarget = $prefix."css/index.css";

	//create required class instances
	$template = new Template;
	$database = new Database($serverName, $userName, $password, $dbName);
	
	//load templates' paths
	$template->load($hypertextPath, $sheetPath);
	
	//connect to db
	$connection = $database->connectDatabase();
	if($connection->connect_error){
		die("Couldn't connect to db " . $connection->connect_error);
	}
	
	//fill html and css templates
	//sheets
	$sheets = array();
	$sheets[] = array(
		"cssPath" => $sheetTarget,
	);
	$template->replace("sheets", $sheets);
	
	//scripts
	$scripts = array();
	$scripts[] = array(
		"scriptPath" => $prefix.'scripts/NewsLoader.js',
	);
	$template->replace("scripts", $scripts);

	//data
	$query = "SELECT 
			elements.type as tag, minitexts.miniText as description, links.link
			FROM elements
			LEFT JOIN
			minitexts
            ON elements.type = minitexts.type
            LEFT JOIN
            links
            ON elements.type = links.type
            WHERE elements.destination = 'home'";
	$result = $connection->query($query);
	while($resultSet = mysqli_fetch_assoc($result)) {
		if($resultSet['description'] != null){
			$template->replace($resultSet['tag'],$resultSet['description']);
		}
		if($resultSet['link'] != null){
			$cssPath = "\t" . "background-image: url(\"" . $prefix . $resultSet['link'] . "\");";
			$template->add($resultSet['tag'], $cssPath);
		}
	}
	$template->push($sheetTarget);
?>