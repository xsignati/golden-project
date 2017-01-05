<?php
	$prefix = "../";
	include $prefix."scripts/Template.php";
	include $prefix."scripts/Database.php";
	include $prefix."scripts/DatabaseInfo.php";
	$hypertextPath = $prefix."tpl/gallery.phtml";
	$sheetPath = $prefix."tpl/gallery.pcss";
	$sheetTarget = $prefix."css/gallery.css";

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
		"scriptPath" => '',
	);
	$template->replace("scripts", $scripts);

	//fetch elementar database values
	$query = "SELECT elements.type as tag, minitexts.minitext as title, links.link 
			FROM elements 
			LEFT JOIN minitexts 
			ON elements.type = minitexts.type 
			LEFT JOIN links 
			ON elements.type = links.type 
			Where elements.type = 'logo_title' 
			OR elements.type = 'gal' 
			OR elements.type = 'title' 
			OR elements.type = 'padOption4'";
	$result = $connection->query($query);
	while($resultSet = mysqli_fetch_assoc($result)) {
		if($resultSet['title'] != null){
			$template->replace($resultSet['tag'],$resultSet['title']);
		}
		if($resultSet['link'] != null){
			$cssPath = "\t" . "background-image: url(\"" .$prefix . $resultSet['link'] . "\");";
			$template->add($resultSet['tag'], $cssPath);
		}
	}
	//fetch images links
	$query = "SELECT e1.type, l1.link as maxLink, e2.type, l2.link as minLink
			FROM elements e1
			JOIN
			images i1
			ON e1.type = i1.type
			AND i1.size = 'max'
			LEFT JOIN
			links l1
			ON e1.type = l1.type
			LEFT JOIN
			elements e2
			ON e1.subtype = e2.subtype
			JOIN
			images i2
			ON e2.type=i2.type
			AND i2.size = 'min'
			LEFT JOIN
			links l2
			ON e2.type = l2.type
			WHERE e1.destination = 'gallery'";
	$result = $connection->query($query);
	while($resultSet = mysqli_fetch_assoc($result)) {
		$images[] = ['maxLink' => $prefix.$resultSet['maxLink'], 'minLink' => $prefix.$resultSet['minLink']];
	}
	$template->replace("images", $images);
	
	//fetch photoSets
	$query = "SELECT elements.type as tag, dates.date, minitexts.miniText as photoSet, links.link
			FROM elements
			LEFT JOIN
			dates
			ON elements.type = dates.type
			LEFT JOIN
			minitexts
			ON elements.type = minitexts.type
			LEFT JOIN
			links
			ON elements.type = links.type
			WHERE elements.subtype = 'photoSet'";
	$result = $connection->query($query);
	while($resultSet = mysqli_fetch_assoc($result)) {
		$photoSet[] = ['date' => $resultSet['date'], 'photoSet' => $resultSet['photoSet'], 'link' => $prefix.$resultSet['link']];
	}
	$template->replace("photoSet", $photoSet);

	$template->push($sheetTarget);
?>