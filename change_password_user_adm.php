<?php
require 'authAdm.php';
require 'lib.php';

$id= $_REQUEST['login_id'];
echo $id;
echo "<body bgcolor=white>\n";
echo "<form name=myform method=post action=\"submit_password_user_adm.php\">\n";
echo "<table>\n";
echo "<tr><td><b>New password:</b></td><td><input type=password name=new_password></td></tr>\n";
echo "<tr><td><b>Re-type new password:</b></td><td><input
type=password name=new_password1></td></tr>\n";
echo "<tr><td><input type=submit value=\"Change\"></td></tr>\n";
echo "</table>\n";
echo "<input type=hidden name=login value='$id'>";
echo "</form>";
echo "</body></html>\n";
