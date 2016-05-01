<?php
require 'lib.php';
require 'head.php';
require 'header.php';

connect_to_database();
$result=mysql_query("SELECT * FROM users ORDER BY id") or mysql_die();
$num=mysql_num_rows($result);
echo $num;
?>
