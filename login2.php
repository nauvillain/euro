<?php
require 'lib.php';

$username=$HTTP_POST_VARS['username'];
$password=$HTTP_POST_VARS['password'];

function verify_password($username,$password)
{
  connect_to_database();

  $rez=mysql_query("select id from admin where username='$username' and password=password('$password')") or mysql_die();

  if(mysql_num_rows($rez)>=1){
      return 1;	
  }else{	
      return 0;
  }
}

//*****************
session_name("euro2008");
session_start();

if($username){
    if(verify_password($username,$password)){
	session_register("admin"); 
	if($url){
	    header("Location: $url");
	    exit;
	}else{ 
	    header("Location: adManage.php");
	    exit;
	}
    }else{
	header("Location: sorryAdm.php");
	exit;
    }
}
header("Location: login.php");
exit;
?>
