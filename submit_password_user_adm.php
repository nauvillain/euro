<?php
require 'authAdm.php';
require 'lib.php';

$id=$_POST['login'];
$new_password=$_POST['new_password'];
$new_password1=$_POST['new_password1'];

connect_to_database();

echo "<body bgcolor=white>\n";
if($new_password!=$new_password1){
  echo "Passwords don't match. Please go <a href=\"javascript:history.back()\">back</a> and complete again.\n";
  exit;
}
$rez=mysql_query("update users set password=password('$new_password') where id='$id'") or mysql_die();
if($rez){
	echo "The user's password has been changed. <br><a href=\"javascript:close();\">Close</a> this window.\n";
} else
{echo "Error updating the user's password (ID=$id). <br><a href=\"javascript:close();\">Close</a> this window.\n";
}
?>
