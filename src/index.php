<?php
/**
 * Templates' and sheets' paths
 */
$hypertextPath	= "../tpl/index.phtml";
$sheetPath		= "../tpl/index.pcss";
$sheetTarget	= "../css/index.css";

/**
 * Load templates
 */
$template -> load($hypertextPath, $sheetPath);

/**
 * fill html and css templates
 */
$sheets		=  array($sheetTarget);
$template	-> replace("sheets", $sheets);
$scripts	=  array();
$scripts[]	=  array(
	"scriptPath" => '../scripts/NewsLoader.js',
);
$template  -> replace("scripts", $scripts);

/**
 * Fetch elemental page content
 */
$query  = "SELECT name, content, destination
		  FROM maincontents
		  WHERE siteID = 'home'";
$result = $connection->query($query);
while($resultSet = mysqli_fetch_assoc($result)) {
	if	($resultSet['destination'] == 'css'){
		$cssPath = "\t"."background-image: url(\"".$resultSet['content']."\");";
		$template->add($resultSet['name'], $cssPath);
	}
	else
		$template->replace($resultSet['name'],$resultSet['content']);
}

/**
 * Get paws menu elements
 */
$query  = "SELECT id, subpageUrl, imgUrl, subpageText
		   FROM menu";
$result =  $connection->query($query);
while($resultSet = mysqli_fetch_assoc($result)) {
	foreach ($resultSet as $key => $value){
		if	($key == 'imgUrl'){
			$cssPath = "\t"."background-image: url(\"".$value."\");";
			$template->add($key.$resultSet['id'], $cssPath);
		}
		else
			$template->replace($key.$resultSet['id'],$value);
	}
}
$template -> push($sheetTarget);
$result	  -> close();
?>