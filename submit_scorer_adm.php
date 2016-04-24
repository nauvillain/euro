<?php
require 'conf.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
require 'class/autoload.php';
require 'admin.php';
$DB = DB::Open();

$id=$_POST['id'];
$top=$_POST['top'];

connect_to_eurodb();

$query="INSERT INTO players SET top='$top' where id='$id'";
//echo $query."<br>";
$sql=mysql_query($query) or mysql_die();
header('location:enter_scorer_adm.php');
?>
