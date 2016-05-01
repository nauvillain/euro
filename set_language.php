<?php
require 'conf.php';
require 'lib_foot.php';
session_name($session_n);
session_start();
$lan=$_REQUEST['langi'];
$_SESSION['language']=$lan;
set_language($lan);
header("Location:".$_SERVER['HTTP_REFERER']);
?>
