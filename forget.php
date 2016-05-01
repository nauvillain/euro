<?php
session_destroy("euro2008");
setcookie("login_id",$login_id,time()-24*3600);
$login_id="";
header("location:login.php");
?>
