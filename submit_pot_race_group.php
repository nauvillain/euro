<?php
require 'auth_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
require 'conf.php';
require 'config/config_foot.php';

connect_to_eurodb();
mysqli_query($link,"UPDATE users SET bet_money=0") or mysqli_error($link);

while(list($key,$val)=each($_POST)){
//		echo $val."<br>";
	
	if(($val!="")&&($key!='Submit')){
		$id=substr($key,1);
		
		mysqli_query($link,"UPDATE users SET bet_money=1 WHERE id='$id'");	
		}
}
header("Location:pot_race_group_saved.php");
?>
