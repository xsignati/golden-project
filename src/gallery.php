<?php
/**
 * Templates' and sheets' paths
 */
$hypertextPath	= "../tpl/gallery.phtml";
$sheetPath		= "../tpl/gallery.pcss";
$sheetTarget	= "../css/gallery.css";

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
 * Get elementar site elements (title, background, etc.)
 */
$query 	= "SELECT name, content, destination
		   FROM maincontents
		   WHERE siteID = 'gallery'";
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
 * Photoset parameter. The first one is a default set in database table. 
 * An appropriate value is taken from URL
 */
$selectedPhotoset = 1; //< default value
if (!empty($_GET['photoset'])){
	$selectedPhotoset = $connection->real_escape_string(basename($_GET['photoset']));
}

/**
 * Get image miniatures and URLs to their full size versions.
 */
$query = "SELECT photosetId, imgUrlMax, imgUrlMin
		  FROM photos
		  WHERE photosetId = '$selectedPhotoset'";
$result = $connection->query($query);
$images = array();
while ($resultSet = mysqli_fetch_assoc($result)) {
	  $images[] = ['imgUrlMax' =>$resultSet['imgUrlMax'], 'imgUrlMin' => $resultSet['imgUrlMin']];
}
$template->replace("images", $images);

/**
 * Get photoset list
 */
$query	  = "SELECT *
			 FROM photosets";
$result	  = $connection->query($query);
$photoSet = array();
while ($resultSet = mysqli_fetch_assoc($result)){
	  $photoSet[] = ['date' => $resultSet['date'], 'name' => $resultSet['name'], 'url' => $resultSet['url']];
}
$template->replace("photoSet", $photoSet);
?>