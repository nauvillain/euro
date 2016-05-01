<?php
require 'auth.php';
require 'lib_gen.php';
require 'lib_foot.php';
require 'conf.php';

connect_to_eurodb();

mysql_query("UPDATE teams set players_list=0") or die(mysql_error());
while(list($key,$val)=each($_POST)){
//		echo $val."<br>";
	
	if(($val!="")&&($key!='Submit')){
		$id=substr($key,1);
		
		mysql_query("UPDATE teams SET players_list=1 WHERE team_id='$id'");	
		}
}
header("Location:team_list_flags_saved.php");
?>
