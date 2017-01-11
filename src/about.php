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
$template -> load($hypertextPath, $sheetPath);

/**
 * Set CSS sheets and JS scripts
 */
$sheets		=  array($sheetTarget);
$template	-> replace("sheets", $sheets);
$scripts	=  array();
$scripts[]	=  array(
	"scriptPath" => '../scripts/IdChanger.js',
);
$template->replace("scripts", $scripts);

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

/**
 * Open a namespace to apply all changes to template
 */
$template->push($sheetTarget);

/**
 * Close query result
 */
$result->close();
?>