<?php
require 'php_header.php';
if(is_admin($login_id)){
	$id= getIfSet($_REQUEST['id']);
	connect_to_eurodb();
	echo "<div id='main'>\n";
	if ($id){
		$query="UPDATE users SET player='0' WHERE id='$id'";
		echo $query;
		$res=mysqli_query($link,$query) or mysqli_error($link);
		 echo 'Player removed!';

	 }
	 else echo "No id provided!";
	}
?>
