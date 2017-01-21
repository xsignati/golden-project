<?php
/*
 * Array to store errors
 */
$error = null;

/*
 * Get form data.
 */
if(isset($_POST["psName"]))
	$psName = $connection->real_escape_string($_POST["psName"]);
else
	$error .= "3,";

/*
 * Save data to database. Safe transaction is performed to create an url with
 * autoincrement id.
 */
 if($error == null){
	$connection -> autocommit(FALSE);
		$query = "INSERT INTO 
				photosets (name)
				VALUES ('".$psName."')";
		$connection -> query($query);		
				
		$id = $connection -> insert_id;
		$query="UPDATE photosets
				SET url = '../gallery/".$id."'
				WHERE id=".$id." limit 1";
		$connection -> query($query);

		if (!$connection->commit()){
			$error .= "1,";
		}
	$connection -> autocommit(TRUE);
 }

/*
 * Change location depending of error status
 */
if($error == null)
	header("Location: run.php?action=gallery");
else
	header("Location: run.php?action=gallery&option=error&error=".$error);
?>