<?php
require 'php_header.php';
require 'admin.php';


$id= $_REQUEST['id'];
connect_to_eurodb();
echo "<div id='main'>\n";
if ($id){
	$query="UPDATE users SET player='1' WHERE id='$id'";
	//echo $query;
	$result=mysql_query($query);

	echo 'Player added';

 }
 else echo "No id provided!";
?>
