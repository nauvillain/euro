<?php
require 'php_header.php';

connect_to_eurodb();

//$que=mysqli_query($link,"select email FROM users WHERE player=1 order by last_login DESC");
$que=mysqli_query($link,"select email FROM users order by last_login DESC");
$num=mysqli_num_rows($que);
echo "<div id='foot_main'>\n";
for($i=0;$i<$num;$i++){

$name=mysqli_result($que,$i,'email');

if($name) echo "$name"."; ";

}
echo "</div>";
?>
