<?php
require 'authAdm.php';
require 'lib.php';
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';

connect_to_database();

$query="UPDATE matches SET played=0";
$res=mysql_query($query) or die();

if ($res) echo "ok.";







require 'footer.php';
?>
