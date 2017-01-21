<?php
include '../scripts/Database.php';
include '../scripts/databaseInfo.php';

$database = new Database($serverName, $userName, $password, $dbName);
$database->connectServer();
$database->createDatabase();
?>