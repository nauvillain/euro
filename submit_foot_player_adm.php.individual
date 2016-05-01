<?php

require 'php_admin.php';
sqlutf();
$scorer=$_POST['player'];
$code=$_POST['team'];

mysql_query("SET NAMES utf8");
$query="INSERT INTO players SET name=\"".$scorer."\", team_id='$code'";
//echo $query."<br>";
$sql=mysql_query($query) or die(mysql_error());
header("location:enter_player_adm.php?last_team=".$code);
?>
