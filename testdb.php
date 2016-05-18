<?php
require_once("dbcontroller.php");
$db_handle = new DBController();


			$query ="SELECT * FROM forum WHERE id = '2520'";
			$post = $db_handle->runQuery($query);
			$likes=$post[0]['likes'];
print_r($post);
echo "likes:".$likes;
?>
