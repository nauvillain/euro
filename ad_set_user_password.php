<?php
require 'php_header.php';
require 'admin.php';
require 'javascript.php';
$pw=$_REQUEST['pass'];
$id= $_REQUEST['id'];
$email= $_REQUEST['email'];
$username=$_REQUEST['username'];
$contact=$_REQUEST['contact'];
$language=$_REQUEST['lan'];
$player=$_REQUEST['player'];

if($player=='on')$player=1;
connect_to_eurodb();
echo "<div id='foot_main'>\n";
sqlutf();
if ($id){
	$sq=mysql_query("SELECT id FROM users WHERE username='$username'");
//	if(mysql_result($sq,0,'id')) {
//		echo "username taken!";
//		$id=mysql_result($sq,0);
//	}

	$query="UPDATE users SET username='".$username."'".($pw!=""?",password=password(\"".$pw."\")":"").",contact='$contact'".($email?",email='$email'":"").",language='$language',player='$player' WHERE id='$id'";
	echo $query;
	$result=mysql_query($query);
	$name="SELECT username from users WHERE id='$id'";
	$n=mysql_result(mysql_query($name),0);
	echo "Player added - <br/>username =$n<br/>password=$pw<br/>http://euro.zitaoravecz.net/<br/>id=$id";

 }
 else echo "No id provided!";
require 'foot_foot.php';
?>
