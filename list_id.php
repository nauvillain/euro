<?php
require 'authAdm.php';
require 'lib.php';
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';

connect_to_database();

$query="SELECT username, id FROM users where player=1";
$res=mysql_query($query);
$num=mysql_num_rows($res);

for($i=0;$i<$num;$i++){

$id=mysql_result($res,$i,'id');
$name=mysql_result($res,$i,'username');

echo "$id - $name <br>";


}






require 'footer.php';
?>
