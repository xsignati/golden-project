<?php
$action = 'index';

if(!empty($_GET['action'])){
	$reqAction = basename($_GET['action']);
	if(file_exists($reqAction.".php")){
		$action = $reqAction;
	}
}
include ($action.".php")
?>