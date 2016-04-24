<?php
require 'php_header.php';
connect_to_eurodb();

$res=mysql_query("SELECT winner,id,top_scorer,nickname,first_name,last_name FROM users WHERE player=1");
$num=mysql_num_rows($res);
echo "<div id='foot_main'>\n";
echo "<div id='top_scorer_list'>";
echo "<h3> List of top scorers bets</h3>";

echo "<table>\n";
echo "<tr><td>Player</a></td><td>Top Scorer</td><td></td><td>From</td><td>Tournament Winner</td><td>flag</td></tr>\n";
if(!still_time(1)){
	for($i=0;$i<$num;$i++){
	
	$first=mysql_result($res,$i,'first_name');
	$last=mysql_result($res,$i,'last_name');
	$nick=mysql_result($res,$i,'nickname');
	$top=mysql_result($res,$i,'top_scorer');
	$p_id=mysql_result($res,$i,'id');

	$rest=mysql_query("SELECT * FROM players WHERE id=$top");
	$top_name=mysql_result($rest,0,'name');
	$team_id=mysql_result($rest,0,'team_id');
	$best=mysql_result($rest,0,'top');
	
	$resw=mysql_query("SELECT * FROM teams WHERE team_id=$team_id");
	$code1=mysql_result($resw,0,'code');

	$team_name=get_team_name($team_id);

	$win=mysql_result($res,$i,'winner');
	$resw=mysql_query("SELECT * FROM teams WHERE team_id=$win");
	$winner=mysql_result($resw,0,'team_name');
	$code2=mysql_result($resw,0,'code');

	echo "<tr><td><a href='player_profile.php?id=$p_id'>$nick</a></td><td>$top_name (from</td><td>".($code1?"<img src='img/$code1.png' height=20px alt=''/>":"")."</td><td>$team_name)</td><td>$winner</td><td>".($code2?"<img src='img/$code2.png' height=20px alt=''/>":"")."</td></tr>\n";

}
}
echo "</table>";
echo "</div>";
?>
