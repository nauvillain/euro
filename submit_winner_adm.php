<?php
require 'authAdm.php';
require 'lib.php';

$team_id=$_POST['winner'];

connect_to_database();
$query="UPDATE teams SET winner=0";
$sql=mysql_query($query);

$query="UPDATE teams SET winner=1 WHERE id=$team_id";
//echo $query."<br>";
$sql=mysql_query($query) or mysql_die();
header('location:adManage.php');
?>
