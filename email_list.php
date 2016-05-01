<?php
require 'php_header.php';

connect_to_eurodb();

$que=mysql_query("select email FROM users WHERE player=1 order by last_login DESC");
$num=mysql_num_rows($que);
echo "<div id='foot_main'>\n";
for($i=0;$i<$num;$i++){

$name=mysql_result($que,$i,'email');

if($name) echo "$name"."; ";

}
echo "</div>";
?>
