<?php
/*
 * Usercake protection
 */

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
/*
 * GP required classes and scripts
 */
include "../scripts/Template.php";
include "../scripts/Database.php";
include "../scripts/DatabaseInfo.php";
include "../lib/smart_resize_image.function.php";
$template = new Template;
$database = new Database($serverName, $userName, $password, $dbName);
$connection = $database->connectDatabase();
/**
 * Add header content
 */
$staticSheet = "../css/static.css";
$jQuery = "../lib/jquery-1.12.1.min.js";
$template->replace("jQuery", $jQuery);
$template->replace("scripts", $staticSheet);
include("../tpl/header.phtml");

/**
 * Add a choosen subpage
 */
$action = 'news';
if(!empty($_GET['action'])){
	$reqAction = basename($_GET['action']);
	if(file_exists($reqAction.".php")){
		$action = $reqAction;
	}
}
include ($action.".php");

/*
 * Check if there was an option associated with photos adding/removing or error
 */
if(!empty($_GET['option'])){
	$option = basename($_GET['option']);
	if(file_exists("../scripts/".$option.".php")){
		include ("../scripts/".$option.".php");
	}
}

/**
 * Add a template content
 */
$template -> push();

/**
 * Add right menu
 */
include("../tpl/rightmenu.phtml");
 
/**
 * Add a footer
 */
include("../tpl/footer.phtml");

/**
 * Close query result and database connection
 */
$result->close();
$connection->close();
?>