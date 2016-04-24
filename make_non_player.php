<?php
require 'php_header.php';
require 'admin.php';

$id= $_REQUEST['id'];
connect_to_eurodb();
echo "<div id='main'>\n";
if ($id){
	$query="UPDATE users SET player='0' WHERE id='$id'";
	echo $query;
	$res=mysql_query($query) or die(mysql_error());
	 echo 'Player removed!';

 }
 else echo "No id provided!";
?>
