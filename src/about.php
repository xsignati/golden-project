<?php
/**
 * Templates' and sheets' paths
 */
$hypertextPath	= "../tpl/about.phtml";
$sheetPath		= "../tpl/about.pcss";
$sheetTarget	= "../css/about.css";

/**
 * Load templates
 */
$template -> load($hypertextPath, $sheetPath, $sheetTarget);

/**
 * fill html and css templates
 */
$sheets		=  array();
$sheets[]	=  array(
	"sheetTarget" => $sheetTarget,
);
$template	-> replace("sheets", $sheets);
$scripts	=  array();
$scripts[]	=  array(
	"scriptPath" => '../scripts/IdChanger.js'
);
$template  -> replace("scripts", $scripts);

/**
 * Get elementar site elements (title, background, etc.)
 */
$query 	= "SELECT name, content, destination
		   FROM maincontents
		   WHERE siteID = 'about'";
$result = $connection->query($query);
while ($resultSet = mysqli_fetch_assoc($result)) {
	if($resultSet['destination'] == 'css'){
		$cssPath = "\t"."background-image: url(\"".$resultSet['content']."\");";
		$template->add($resultSet['name'], $cssPath);
	}
	else
		$template->replace($resultSet['name'],$resultSet['content']);
}

?>