<?php
require 'conf.php';
session_name($session_n);
//session_start(); 
//cehck session language first - if there is a session variable called language, take its value 
if (isset($_SESSION['language'])) $language=$_SESSION['language'];
//else, fi there is a language cookie, take that
  else	{
	if(isset($_COOKIE['language'])) $language=$_COOKIE['language'];
//	if there is nothing, take the default
	else $language='en';
}


?>
