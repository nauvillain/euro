<?php
require 'auth/auth.php';
require 'conf.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';

$team_name=getIfSet($_POST['team']);

global $link;
echo "team $team_name";
connect_to_eurodb();
if(is_admin($login_id)){

	echo "test";
	$query="INSERT INTO all_teams (team_name) VALUES (\"$team_name\")";
	$sql=mysqli_query($link,$query) or mysqli_error($link);

	header('location:enter_all_team_adm.php');
}
?>
