<?php
require 'php_header.php';
echo date("M d, h:m");
echo "<div id='foot_main'>";
$res=mysql_query("DELETE from bets where player_id NOT IN (SELECT id FROM users WHERE player=1)") or die(mysql_error());


echo "</div>";
?>
