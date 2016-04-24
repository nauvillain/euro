<?php
require 'auth.php';
require 'lib.php';
require 'head.php';
require 'header_foot.php';

connect_to_database();

echo "<h2> Odds of predicted winners on this site</h2>";

$winner=array();
$res=mysql_query("SELECT winner FROM users WHERE player=1");
$num=mysql_num_rows($res);

for ($i=0;$i<$num;$i++){
	$team_id=mysql_result($res,$i,'winner');
	$winner[$team_id]++;

}
echo "<table>";
arsort($winner);
foreach ($winner as $key=>$val){
	
	$t=mysql_query("SELECT team_name,code FROM teams where id=$key");
	$name=mysql_result($t,0,'team_name');
	$code=mysql_result($t,0,'code');

	 echo "<tr><td><img src='img/$code.gif'/></td><td><div class='team'>$name </div></td><td> ".round($num/$val,2)."</td></tr>\n";
}
echo "</table>";
echo "<p><a href='javascript:history.back()'>Back</a></p>";
require 'footer.php';
?>
