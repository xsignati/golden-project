<?php
include 'Database.php';
include 'databaseInfo.php';

$database = new Database($serverName, $userName, $password, $dbName);
$database->connectDatabase();
$database->createDatabase();
?>