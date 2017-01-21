<?php
/*
 * Array to store errors
 */
$error = null;

if(isset($_POST["id"])){
	$newsId = $connection->real_escape_string($_POST["id"]);
}

/*
 * Delete image file
 */
$query = "SELECT imgUrl 
		FROM news 
		WHERE id = '".$newsId."'";
$result = $connection->query($query);
$resultSet = mysqli_fetch_assoc($result);
	if (file_exists("../".$resultSet['imgUrl'])) {
        unlink("../".$resultSet['imgUrl']);
    } 

/*
 * Remove news from databae
 */
$query = "DELETE 
		FROM news 
		WHERE id = '".$newsId."'";
if (!$connection->query($query) === TRUE) {
     $error .= "1,";
}

/*
 * Change location depending of error status
 */
if($error == null)
	header("Location: run.php?action=news");
else
	header("Location: run.php?action=news&option=error&error=".$error);
?>