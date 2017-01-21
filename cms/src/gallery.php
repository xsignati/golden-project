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
 * Set CSS sheets and JS scripts
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
$template->replace("scripts", $scripts);

/**
 * Fetch photosets
 */
$query = "SELECT id, date, name
		FROM photosets
		ORDER BY date";
$result = $connection->query($query);
$photosets = array();
while($resultSet = mysqli_fetch_assoc($result)) {
	$photosets[] = ['id' => $resultSet['id'], 'date' => $resultSet['date'], 'name' => $resultSet['name']];
}
$template->replace('photosets',$photosets);

/**
 * Fetch images
 */
$photos = array();
$ps = -1;
if(!empty($_GET['ps'])){
	$ps = basename($_GET['ps']);
	$query = "SELECT id, photosetId, imgUrlMin
			FROM photos
			WHERE photosetId =".$ps;
	$result = $connection->query($query);
	while($resultSet = mysqli_fetch_assoc($result)) {
		$photos[] = ['id' => $resultSet['id'], 'photosetId' => $resultSet['photosetId'], 'imgUrlMin' => $resultSet['imgUrlMin']];
	}
}
$template->replace("ps", $ps);
$template->replace('photos',$photos);
?>