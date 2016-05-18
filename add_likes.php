<?php
require 'auth_foot.php';
require_once("dbcontroller.php");
$db_handle = new DBController();

if(!empty($_POST["id"])) {


	switch($_POST["action"]){

		case "like":

			$query = "INSERT INTO likes (user_id,post_id) VALUES ('$login_id','".$_POST["id"]."')";

			$result = $db_handle->insertQuery($query);

			if(!empty($result)) {
				
				$query ="select id FROM post_meta WHERE post_id='" . $_POST["id"] . "'";

				$count = $db_handle->numRows($query);

				if($count){

					$query ="UPDATE post_meta SET likes = likes + 1 WHERE post_id='" . $_POST["id"] . "'";

					$result = $db_handle->updateQuery($query);				

				}
				else{
					
					$query ="INSERT INTO post_meta SET likes = 1, post_id='" . $_POST["id"] . "'";

					$result = $db_handle->insertQuery($query);				

					
				}
			}			

		break;		

		case "unlike":

			$query = "DELETE FROM likes WHERE user_id = '" . $login_id . "' and post_id = '" . $_POST["id"] . "'";

			$result = $db_handle->deleteQuery($query);

			if(!empty($result)) {

				$query ="UPDATE post_meta SET likes = likes - 1 WHERE post_id='" . $_POST["id"] . "' and likes > 0";

				$result = $db_handle->updateQuery($query);

			}

		break;		

	}

}

?>
