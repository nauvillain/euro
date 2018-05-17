<?php
require 'auth_foot.php';
require 'conf.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
connect_to_eurodb();
if(is_admin($login_id)){
		$id=getIfSet($_POST['id']);
		$flag=0;
	foreach ($_POST as $var => $value) { 
		if(is_int($var)) mysqli_query($link,"UPDATE players SET top=0 where id='$var'") or die(mysqli_error($link)());
		else {
			if($var=='new') {
				$flag=1;
			}
			if($var=='id'&&$flag) {
				$query="UPDATE players SET top=1 where id='$id'";
					//echo $query."<br>";
				$sql=mysqli_query($link,$query) or die(mysqli_error($link));
			}
		}
	} 
	header('location:mark_top_scorer_adm.php');
}
?>
