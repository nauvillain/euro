<?php
require 'auth/auth.php';
require 'conf.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';

$t1=getIfSet($_POST['t1']);
$t2=getIfSet($_POST['t2']);
$g1=getIfSet($_POST['g1']);
$g2=getIfSet($_POST['g2']);
$last=getIfSet($_POST['last_team']);

global $link;
echo "team $team_name";
connect_to_eurodb();
if(is_admin($login_id)){

	echo "test";
	$query="INSERT INTO qualifiers (t1,t2,g1,g2) VALUES ($t1,$t2,$g1,$g2)";
	$sql=mysqli_query($link,$query) or mysqli_error($link);

	header('location:enter_qualifiers_score.php?team_id='.$last);
}
?>
