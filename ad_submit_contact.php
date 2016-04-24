<?php
require 'php_header.php';
require 'admin.php';
require 'javascript.php';
$id= $_REQUEST['id'];
$contact=$_REQUEST['contact'];
$language=$_REQUEST['lan'];
connect_to_eurodb();
echo "<div id='main'>\n";
if ($id){
	$sq=mysql_query("SELECT id FROM users WHERE username='$username'");
	if(mysql_num_rows($sq)) {
		echo "username taken!";
		$id=mysql_result($sq,0);
	}

	$query="UPDATE users SET contact='$contact',language='$language' WHERE id='$id'";
	echo $query;
	$result=mysql_query($query);
	$name="SELECT username from users WHERE id='$id'";
	$n=mysql_result(mysql_query($name),0);
	echo "<br>Contact & language set - <br/>username :$n<br/>id=$id";

 }
 else echo "No id provided!";
?>
