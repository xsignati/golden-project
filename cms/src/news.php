<?php
/**
 * Templates' and sheets' paths
 */
$hypertextPath	= "../tpl/news.phtml";
$sheetPath		= "../tpl/news.pcss";
$sheetTarget	= "../css/news.css";

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
 * Fetch news
 */
$query = "SELECT id, title
		FROM news
		ORDER BY date";
$result = $connection->query($query);
$news = array();
while($resultSet = mysqli_fetch_assoc($result)) {
	$news[] = ['id' => $resultSet['id'], 'title' => $resultSet['title']];
}
$template->replace('news',$news);
?>