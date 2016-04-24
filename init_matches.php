<?php
require 'php_header_adm.php';

connect_to_eurodb();

$query="UPDATE matches SET team1='',team2='',goals1='',goals2='' ";
$res=mysql_query($query);
if ($res) header('location:adManage.php');
else echo "issue with sql syntax";





require 'footer.php';
?>
