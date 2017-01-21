<?php
/*
 * Array to store errors
 */
$error = null;

/*
 * Get form data. Default values will be set if some data doesn't exist.
 * If image is not uploaded original portrait will be applied.
 * In other case, original image is destroyed and a new one is resized and saved
 */
$title = " ";
$text = " ";

/*
 * Fetch old portrait url
 */
$query = "SELECT content 
		FROM maincontents
		WHERE name = 'aboutImage'";
$result = $connection->query($query);
$resultSet = mysqli_fetch_assoc($result);
$imgUrl = $resultSet['content'];


if(isset($_POST["title"]))
	$title = $connection->real_escape_string($_POST["title"]);

if(isset($_POST["text"]))
	$text = $connection->real_escape_string($_POST["text"]);

if(is_uploaded_file($_FILES['image']['tmp_name'])){
	if (file_exists("../".$imgUrl)) 
		unlink("../".$resultSet['content']);
	/*
	 * Create new portrait
	 */
	$img = $connection->real_escape_string($_FILES['image']['name']);
	$resImg = $_FILES['image']['tmp_name'];
	$validExt= array('jpeg', 'jpg', 'png', 'gif');
	$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
	if(in_array($ext, $validExt)){
		$imgUrl = '../resources/'.$img;
		$resWidth = 450;
		$resHeight = 400;
		if(!smart_resize_image(null , file_get_contents($resImg), $resWidth, $resHeight, false , "../".$imgUrl , false , false ,100 )){
			$error .= "2,";
		};
	}
}

$aboutConst = array(
	"aboutTitle" => $title,
	"aboutContent" => $text,
	"aboutImage" => $imgUrl,
);

foreach($aboutConst as $key => $value){
	$query = "UPDATE maincontents
			SET content = '".$value."'
			WHERE name = '".$key."'";
	if (!$connection->query($query) === TRUE){
		$error .= "1,";
		break;
	}
}

/*
 * Change location depending of error status
 */
if($error == null)
	header("Location: run.php?action=about");
else
	header("Location: run.php?action=about&option=error&error=".$error);
?>