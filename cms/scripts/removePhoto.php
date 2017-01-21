<?php
/*
 * Array to store errors
 */
$error = null;

if(!empty($_POST["id"]))
	$id = $connection->real_escape_string($_POST["id"]);
if(!empty($_POST["id"]))
	$photosetId = $connection->real_escape_string($_POST["photosetId"]);

/*
 * Remove photos files
 */
$query= "SELECT imgUrlMax, imgUrlMin
		FROM photos
		WHERE id =".$id."
		AND photosetId = ".$photosetId;
$result = $connection->query($query);
$resultSet = mysqli_fetch_assoc($result);
	if (file_exists("../".$resultSet['imgUrlMax']) && file_exists("../".$resultSet['imgUrlMin'])) {
        unlink("../".$resultSet['imgUrlMax']);
		unlink("../".$resultSet['imgUrlMin']);
    } 

/*
 * Remove photo info from database
 */
$query="DELETE from photos
		WHERE id =".$id."
		AND photosetId = ".$photosetId;
if (!$connection->query($query) === TRUE)
    $error .= "1,";

/*
 * Change location depending of error status
 */
if($error == null)
	header("Location: run.php?action=gallery&ps=".$photosetId);
else
	header("Location: run.php?action=gallery&option=error&error=".$error);

?>