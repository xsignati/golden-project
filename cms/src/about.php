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
	"scriptPath" => '',
);
$template  -> replace("scripts", $scripts);

/**
 * Fetch about informations
 */
$query = "SELECT name, content, destination
		FROM maincontents
		WHERE name = 'aboutImage'
		OR name = 'aboutContent'
		OR name = 'aboutTitle'";
$result = $connection->query($query);
$about= array();
while($resultSet = mysqli_fetch_assoc($result)) {
	$template->replace($resultSet['name'],$resultSet['content']);
}

?>