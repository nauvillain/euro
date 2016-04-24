<?php
require 'auth_foot.php';
require 'conf.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
require 'class/autoload.php';
$DB = DB::Open();
global $login_id;
connect_to_eurodb();

mysql_query("DELETE FROM usergroups WHERE user_id='$login_id'") or die(mysql_error());
while(list($key,$val)=each($_POST)){
//		echo $val."<br>";
	
	if(($val!="")&&($key!='Submit')){
		$id=substr($key,1);
		
		mysql_query("INSERT INTO usergroups SET user_id='$login_id',member='$id'");	
		}
}
header("Location:user_groups_saved.php");
?>
