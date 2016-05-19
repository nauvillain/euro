<?php
require 'auth_foot.php';
require_once("dbcontroller.php");
$db_handle = new DBController();

//$post_id=$_POST["post_id"];

if(!empty($_POST["post_id"])) {



			$query = "SELECT username FROM users WHERE id in (SELECT user_id FROM likes WHERE post_id='".$_POST["post_id"]."');";

			$result = $db_handle->runQuery($query);
//			echo json_encode($result);
			foreach($result as $row){
				echo "<span class='list_likes'>".$row['username']." </span>\n";
			
			}

}

?>
