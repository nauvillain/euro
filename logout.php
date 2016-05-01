<?php
setcookie("login_id","",time()-3600);
$name="wc2010";
session_start();
session_unset();
session_destroy();
unset($_SESSION['login_id']);

header("Location:login.php");
?>
