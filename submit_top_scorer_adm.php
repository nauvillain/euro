<?php
require 'php_header.php';
require 'admin.php';
connect_to_eurodb();
$id=$_POST['id'];
foreach ($_POST as $var => $value) { 
	if(is_int($var)) mysql_query("UPDATE players SET top=0 where id='$var'") or die(mysql_error());
	else {
		if($var=='new') {
			$flag=1;
		}
		if($var=='id'&&$flag) {
			$query="UPDATE players SET top=1 where id='$id'";
				//echo $query."<br>";
			$sql=mysql_query($query) or die(mysql_error());
		}
	}
} 
header('location:mark_top_scorer_adm.php');
?>
