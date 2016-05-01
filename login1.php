<?php
require 'lib/lib_gen.php';
require 'config/config_foot.php';
require 'lib_foot.php';
require 'conf.php';

$username=$_POST['username'];
$password=$_POST['password'];
$public=$_POST['public'];
$url=$_REQUEST['url'];
function verify_password($username,$password)
{
  connect_to_eurodb();

  $query=sprintf("select id,username, password,player,sweet from users  where username='%s' and password=password('%s')",mysql_real_escape_string($username),mysql_real_escape_string($password));
 // echo $query;
 // break;
  $rez=mysql_query($query) or die(mysql_error());
  if(mysql_num_rows($rez)==1){
      $login_id;

      $login_id=mysql_result($rez,0,"id");
      $_SESSION["login_id"]=$login_id;
      
      $sql = mysql_query("UPDATE users SET last_login=\"".date("d M Y H:i",time())."\" WHERE id='$login_id'") or die (mysql_error());

      return $login_id;	
  }else{	
      return 0;
  }
}

function is_player($id){

  connect_to_eurodb();

  $rez=mysql_query("select player,sweet,language from users  where id=$id") or die(mysql_error());

  $arr['player']=mysql_result($rez,0,'player');
  $arr['sweet']=mysql_result($rez,0,'sweet');
  $arr['language']=mysql_result($rez,0,'language');
  return $arr;
}
function admin($id){
	$res=mysql_query("SELECT id FROM users WHERE admin='1' AND id='$id'") or die(mysql_error());
	return mysql_num_rows($res);
}

//*****************
session_name($session_n);
session_start();
$life=40*86400;
if($username){

    if($login_id=verify_password($username,$password)){
	$_SESSION['login_id']=$login_id;
    	$arr=is_player($login_id);
	if(!$public){	setcookie("login_id",$login_id,time()+$cookie_life);
			if($language!="") setcookie("language",$arr['language'],time()+$cookie_life);
			else setcookie("language",$language,time()+$cookie_life);
	}
	else {  
		setcookie("login_id",$login_id,time()-24*3600);
		if(admin($login_id)) setcookie("login_id",$login_id,time()-24*3600);
	}

	if($url){
	    header("Location: $url");
	    exit;
	}else{ 
	    if($arr['player']==1) {
			header("Location:index.php");
		}
	    else			 header("Location:index.php");
	    exit;
	}
    }else{
	header("Location: sorry.php");
	exit;
    }
}
header("Location: login.php");
exit;
?>
