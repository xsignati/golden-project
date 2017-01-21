<?php
if(isset($_GET['error'])){
	$error = basename($_GET['error']);
	$error = rtrim($error, ",");
}
$query = "SELECT error
	FROM cms_errors
	WHERE id in (".$error.")";

$result = $connection->query($query);
$errors = array();
while($resultSet = mysqli_fetch_assoc($result)) {
	$errors[] = ['error' => $resultSet['error']];
};

$template->replace('errors',$errors);
?>