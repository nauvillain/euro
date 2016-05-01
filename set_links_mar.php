<?php
require './auth_mar.php';
session_name("mariage");
session_start();

$_SESSION['link']=$_REQUEST['link'];
header("Location:".$_SERVER['HTTP_REFERER']);
?>
