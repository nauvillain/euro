<?php
require 'php_header.php';


$res=mysql_query("SELECT * FROM forum where id=505");
$string=mysql_result($res,0,'content');
$id=mysql_result($res,0,'id');
echo "<div id='main'>";
//$string= "the lazy dog jumps the  http://vilnico.homelinux.net barrier";
$string= preg_replace("/(http:\/\/[^\s]+)/", "<a href='$1'>$1</a>", $string);
//echo urltolink($string);
//echo $string;
//$string=str_replace("(","( ",$string);
//$string=str_replace(")"," )",$string);

mysql_query("UPDATE forum SET content=\"$string\" where id='$id'") or die(mysql_error());
?>
