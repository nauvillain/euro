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
global $link;
  connect_to_eurodb();

  $query=sprintf("select id,username, password,player,sweet from users  where username='%s' and password=password('%s')",mysqli_real_escape_string($link,$username),mysqli_real_escape_string($link,$password));
 // echo $query;
 // break;
  $rez=mysqli_query($link,$query) or die(mysql_error());
  if(mysqli_num_rows($rez)==1){
      $login_id;

      $login_id=mysqli_result($rez,0,"id");
      $_SESSION["login_id"]=$login_id;
      
      $sql = mysqli_query($link,"UPDATE users SET last_login=\"".date("d M Y H:i",time())."\" WHERE id='$login_id'") or die (mysql_error());

      return $login_id;	
  }else{	
      return 0;
  }
}

function is_player($id){
global $link;
  connect_to_eurodb();

  $rez=mysqli_query($link,"select player,sweet,language from users  where id=$id") or die(mysql_error());

  $arr['player']=mysqli_result($rez,0,'player');
  $arr['sweet']=mysqli_result($rez,0,'sweet');
  $arr['language']=mysqli_result($rez,0,'language');
  return $arr;
}
function admin($id){
	global $link;
	$res=mysqli_query($link,"SELECT id FROM users WHERE admin='1' AND id='$id'") or die(mysql_error());
	return mysqli_num_rows($res);
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
