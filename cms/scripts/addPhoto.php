<?php
/*
 * Array to store errors
 */
$error = null;

/*
 * Get form data.
 * Images are saved into the files. 
 */
if(isset($_POST["id"])){
	$psId = $connection->real_escape_string($_POST["id"]);
	if($psId < 0){
		$error .= "3,";
	}
}
else
	$error .= "3,";

if($error == null && is_uploaded_file($_FILES['image']['tmp_name'])){
	$img = $connection->real_escape_string($_FILES['image']['name']);
	$tmpImg = $_FILES['image']['tmp_name'];
	$validExt= array('jpeg', 'jpg', 'png', 'gif');
	$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
	if(in_array($ext, $validExt)){
		$imgUrlMax = '../resources/'.$img;
		$imgUrlMin = '../resources/'.'min_'.$img;
		$resWidth = 296;
		$resHeight = 168;
		smart_resize_image(null , file_get_contents($tmpImg), $resWidth, $resHeight, false , "../".$imgUrlMin , false , false ,100 );
		if(!move_uploaded_file($tmpImg,"../".$imgUrlMax)) 
		{
		echo "error saving";
		}
	}
}

/*
 * Save a photo in database
 */
$query = "INSERT into photos (photosetId, imgUrlMax, imgUrlMin)
		VALUES (".$psId.",'".$imgUrlMax."','".$imgUrlMin."')";
if ($error != null || !$connection->query($query) === TRUE) {
    $error .= "1,";
}

/*
 * Change location depending of error status
 */
if($error == null)
	header("Location: run.php?action=gallery&ps=".$psId);
else
	header("Location: run.php?action=gallery&option=error&error=".$error);
?>