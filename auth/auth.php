<?php
session_name("euro2008");
session_start();
$_SESSION['url']='main';
if (!isset($_SESSION['count_sessions'])) {
   $_SESSION['count_sessions'] = 0;
} else {
   $_SESSION['count_sessions']++;
}

if((!isset($_COOKIE['login_id']))&&(!$_SESSION['login_id'])){
	header("Location: login.php?url=".rawurlencode($REQUEST_URI));
} else {
  if (isset($_COOKIE['login_id'])) $login_id=$_COOKIE['login_id'];
  else $login_id=$_SESSION['login_id'];
}

?>
