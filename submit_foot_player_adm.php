<?php

require 'php_admin.php';
sqlutf();
$scorers=$_POST['player'];
$arr = explode("\n", $scorers);
$code=$_POST['team'];

mysql_query("SET NAMES utf8");

if($code){
	$q="DELETE FROM players WHERE team_id='$code'";
	mysql_query($q) or die(mysql_error());
	foreach($arr as $value){
		$scorer=trim($value);
		$query="INSERT INTO players SET name=\"".$scorer."\", team_id='$code'";
		$sql=mysql_query($query) or die(mysql_error());
	}
}

header("location:enter_player_adm.php?last_team=".$code);
?>
