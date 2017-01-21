<?php
/*
 * Array to store errors
 */
$error = null;

/*
 * Get form data. Default values will be set if some data doesn't exist.
 * Images are resized and saved into the files.
 */
$title = " ";
$text = " ";
$imgUrl = '/resources/defaultNewsImg.jpg';

if(isset($_POST["title"]))
	$title = $connection->real_escape_string($_POST["title"]);

if(isset($_POST["text"]))
	$text = $connection->real_escape_string($_POST["text"]);

if(is_uploaded_file($_FILES['image']['tmp_name'])){
	$img = $connection->real_escape_string($_FILES['image']['name']);
	$resImg = $_FILES['image']['tmp_name'];
	echo(filesize($resImg));
	$validExt= array('jpeg', 'jpg', 'png', 'gif');
	$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
	if(in_array($ext, $validExt)){
		$url = '../resources/'.$img;
		$resWidth = 108;
		$resHeight = 88;
		if(smart_resize_image(null , file_get_contents($resImg), $resWidth, $resHeight, false , "../".$url , false , false ,100)){
			$imgUrl = $url;
		}
		else{
			$error .= "2,";
		}
	}
}

/*
 * Save a news in database
 */
$query = "INSERT INTO 
		news (title, newsText, imgUrl)
		VALUES ('".$title."', '".$text."', '".$imgUrl."' )";
if (!$connection->query($query) === TRUE)
	$error .= "1,";

/*
 * Change location depending of error status
 */
if($error == null)
	header("Location: run.php?action=news");
else
	header("Location: run.php?action=news&option=error&error=".$error);
?>