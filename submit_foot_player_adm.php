<?php
$delimiters=array(",",";","\n");

function multiexplode ($delimiters,$string) {
	    
	    $ready = str_replace($delimiters, $delimiters[0], $string);
		    $launch = explode($delimiters[0], $ready);
		    return  $launch;
}

require 'php_admin.php';
sqlutf();
$scorers=$_POST['player'];
$arr = multiexplode($delimiters, $scorers);
$arr=array_filter($arr);
$code=$_POST['team'];

mysql_query("SET NAMES utf8");

if($code){
	$q="DELETE FROM players WHERE team_id='$code'";
	mysqli_query($link,$q) or mysql_error($link);
	foreach($arr as $value){
		$scorer=trim($value);
		$query="INSERT INTO players SET name=\"".$scorer."\", team_id='$code'";
		$sql=mysqli_query($link,$query) or mysql_error($link);
	}
}

header("location:enter_player_adm.php?last_team=".$code);
?>
