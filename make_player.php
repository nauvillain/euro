<?php
require 'php_header.php';
if(is_admin($login_id)){

	$id= getIfSet($_REQUEST['id']);
	connect_to_eurodb();
	echo "<div id='main'>\n";
	if ($id){
		$query="UPDATE users SET player='1' WHERE id='$id'";
		//echo $query;
		$result=mysqli_query($link,$query);

		echo 'Player added';

	 }
	 else echo "No id provided!";

}
?>
