<?php
require 'auth_foot.php';
require 'lib_foot.php';

echo "<body bgcolor=white>\n";
echo "<form name=myform method=post action=\"submit_password.php\">\n";
echo "<table>\n";
echo "<tr><td>Old password:</td><td><input type=password name=old_password></td></tr>\n";
echo "<tr><td>New password:</td><td><input type=password name=new_password></td></tr>\n";
echo "<tr><td>Re-type new password:</td><td><input type=password name=new_password1></td></tr>\n";
echo "<tr><td><input type=submit value=\"Change\"></td></tr>\n";
echo "</table>\n";
echo "</body></html>\n";
