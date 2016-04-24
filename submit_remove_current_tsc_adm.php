<?php
require 'authAdm.php';
require 'lib.php';

$scorer=$_POST['scorer'];

connect_to_database();

$query="UPDATE scorer SET top=0 where id=$scorer";
//echo $query."<br>";
$sql=mysql_query($query) or mysql_die();
header('location:enter_scorer_adm.php');
?>
