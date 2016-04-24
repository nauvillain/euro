<?php
require 'authAdm.php';
require 'lib.php';
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';

connect_to_database();
$FSR_M=56;

$count=0;

$count_m=0;
$res=mysql_query("SELECT id,username,last_login FROM users WHERE player=1");
$num=mysql_num_rows($res);
echo "<table><tr><td>";
for($i=0;$i<$num;$i++){

	$p_id=mysql_result($res,$i,'id');
	$quer=mysql_query("SELECT count(*) as count  FROM bets WHERE player_id=$p_id GROUP BY player_id");
	$bets=mysql_result($quer,0,'count');
	$name=mysql_result($res,$i,'username');
	$last=mysql_result($res,$i,'last_login');
	if($bets<$FSR_M-4){
		echo "<p><font color=red>$name:".($FSR_M-$bets)." bets to place</font> - $last</p>";
	$count++;
	}
	else {
		echo "<p>$name is ok. - $last</p>";
		$count_m++;
	}

}
echo "</td><td valign=top>";
echo "still $count players need to bet.";
echo "<p> and $count_m players have bet already.</p>";
echo "</td></tr></table>";



require 'footer.php';
?>
