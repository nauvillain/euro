<?php
session_name("russia");
session_start();
if (!isset($_SESSION['count_sessions'])) {
   $_SESSION['count_sessions'] = 0;
} else {
   $_SESSION['count_sessions']++;
}

if(!$_SESSION['login_id']){
	header("Location:login.php?url=".rawurlencode($REQUEST_URI));
} else $login_id=$_SESSION['login_id'];

?>
