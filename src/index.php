<?php
include "../scripts/Template.php";
include "../scripts/Database.php";
include "../scripts/DatabaseInfo.php";
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
$action = 'home';
if(!empty($_GET['action'])){
	$reqAction = basename($_GET['action']);
	if(file_exists($reqAction.".php")){
		$action = $reqAction;
	}
}
include ($action.".php");

/**
 * Add a template content
 */
$template -> push();

/**
 * Add a footer
 */
include("../tpl/footer.phtml");

/**
 * Close database connection
 */
$connection->close();
$result->close();
?>