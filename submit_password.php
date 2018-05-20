<?php
require 'auth_foot.php';
require 'lib/lib_gen.php';
require 'config/config_foot.php';
require 'lib_foot.php';
require 'conf.php';
  connect_to_eurodb();


$new_password=getIfSet($_POST['new_password']);
$new_password1=getIfSet($_POST['new_password1']);
$old_password=getIfSet($_POST['old_password']);


if($new_password!=$new_password1){
  echo "Passwords don't match. Please go <a href=\"javascript:history.back()\">back</a> and complete again.\n";
  exit;
}
$query=sprintf("SELECT username,password FROM users WHERE id='%s' and password=password('%s')",$login_id,mysqli_real_escape_string($link,$old_password));
//echo $query;
//echo "pass.".$old_password;

$result=mysqli_query($link,$query) or mysqli_error($link);
if(mysqli_num_rows($result)==0){
  echo "The old password is not correct. Please go <a href=\"javascript:history.back()\">back</a> and complete again.\n";
  exit;
}	
$rez=mysqli_query($link,"update users set password=password('$new_password') where id='$login_id'") or mysqli_error($link);
if($rez){
	echo "Your password has been changed. <br><a href=\"javascript:close();\">Close</a> this window.\n";}
else{
	echo "Error updating your password. Please contact the administrator. <a href=\"javascript:close();\">Close</a> this window.\n";}
?>
