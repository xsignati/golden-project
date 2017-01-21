<?php
/*
 * Array to store errors
 */
$error = null;

if(isset($_POST["id"]))
	$psId = $connection->real_escape_string($_POST["id"]);

$query= "SELECT imgUrlMax as img
		FROM photos
		WHERE photosetId =".$psId."
		UNION
		SELECT imgUrlMin
		FROM photos
		WHERE photosetId =".$psId;

$result = $connection->query($query);

/*
 * Remove all photo files from set
 */
$photos = array();
while($resultSet = mysqli_fetch_assoc($result)) {
	if (file_exists("../".$resultSet['img'])) {
        unlink("../".$resultSet['img']);
    } 
}

/*
 * Remove photo info from database
 */
$query="DELETE from photos
		WHERE photosetId =".$psId;
$connection->query($query);

/*
 * Remove photoset from database
 */
$query="DELETE from photosets
		WHERE id =".$psId;
$connection->query($query);

/*
 * Change location depending of error status
 */
if($error == null)
	header("Location: run.php?action=gallery");
else
	header("Location: run.php?action=gallery&option=error&error=".$error);
?>