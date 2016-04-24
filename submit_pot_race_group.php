<?php
require 'auth_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
require 'conf.php';
require 'config/config_foot.php';

connect_to_eurodb();
mysql_query("UPDATE users SET bet_money=0") or die (mysql_error());

while(list($key,$val)=each($_POST)){
//		echo $val."<br>";
	
	if(($val!="")&&($key!='Submit')){
		$id=substr($key,1);
		
		mysql_query("UPDATE users SET bet_money=1 WHERE id='$id'");	
		}
}
header("Location:pot_race_group_saved.php");
?>
