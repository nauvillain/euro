<?php
require 'auth_foot.php';
require 'lib/lib_gen.php';
require 'config/config_foot.php';
require 'lib_foot.php';
require 'conf.php';
  connect_to_eurodb();


$new_password=$_POST['new_password'];
$new_password1=$_POST['new_password1'];
$old_password=$_POST['old_password'];


if($new_password!=$new_password1){
  echo "Passwords don't match. Please go <a href=\"javascript:history.back()\">back</a> and complete again.\n";
  exit;
}
$query=sprintf("SELECT username,password FROM users WHERE id='%s' and password=password('%s')",$login_id,mysql_real_escape_string($old_password));
//echo $query;

$result=mysql_query($query) or die(mysql_error());
if(mysql_num_rows($result)==0){
  echo "The old password is not correct. Please go <a href=\"javascript:history.back()\">back</a> and complete again.\n";
  exit;
}	
$rez=mysql_query("update users set password=password('$new_password') where id='$login_id'") or die(mysql_error());
if($rez){
	echo "Your password has been changed. <br><a href=\"javascript:close();\">Close</a> this window.\n";}
else{
	echo "Error updating your password. Please contact the administrator. <a href=\"javascript:close();\">Close</a> this window.\n";}
?>
