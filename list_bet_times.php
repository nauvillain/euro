<?php
require 'php_header.php';
require 'admin.php';

echo "<div id='foot_main'>\n";



connect_to_eurodb();
echo "<a href='last_accessed.php?win=1'>no scorer or winner</a>\n";

$res=mysql_query("SELECT * FROM bets WHERE DATE_SUB(NOW(),INTERVAL 12000 MINUTE)< time_entered ORDER BY time_entered desc") or die(mysql_error());	
$num=mysql_num_rows($res);
echo $num."<br/>";
for($i=0;$i<$num;$i++){
	$time=mysql_result($res,$i,'time_entered');
	$player_id=mysql_result($res,$i,'player_id');
	$id=mysql_result($res,$i,'bet_id');
	$match_id=mysql_result($res,$i,'match_id');

	$player=get_username($player_id);
	$arr=get_match_details($match_id,$player_id);

	$team1=get_team_name($arr['t_id1']);
	$team2=get_team_name($arr['t_id2']);


	if($arr['pick']==1) $pick=$team1;

	if($arr['pick']==2) $pick="tie";

	if($arr['pick']==3) $pick=$team2;

	echo "$player - ".$team1."vs. $team2 for $pick- at $time <br/>";

	}
?>
