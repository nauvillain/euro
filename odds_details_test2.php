<?php
require 'auth.php';
require 'lib.php';
require 'head.php';
require 'header_foot.php';
connect_to_database();

$type=$_REQUEST['type'];
$match_id=$_REQUEST['match_id'];


$q="SELECT * FROM bets WHERE match_id=$match_id and player_id<>5";
$res=mysql_query($q);
$num=mysql_num_rows($res);

$m="SELECT team1,team2 FROM matches where id=$match_id";
$resm=mysql_query($m);
$team1=mysql_result($resm,0,'team1');
$team2=mysql_result($resm,0,'team2');

$rest=mysql_query("SELECT team_name FROM teams WHERE id=$team1");
$team_name1=mysql_result($rest,0,0);
$rest=mysql_query("SELECT team_name FROM teams WHERE id=$team2");
$team_name2=mysql_result($rest,0,0);


if ($type=='v1') $winn=$team_name1;
else $winn=$team_name2;
$nickname=array();

function list_players_for_bet($res,$i){

			$p_id=mysql_result($res,$i,'player_id');
			$resp=mysql_query("select nickname from users where id=$p_id");
			$nickname[$p_id]=ucfirst(strtolower(mysql_result($resp,0,0)));
}

if($type=='v1' || $type=='v2') echo "List of players having bet on <h4>a victory for $winn</h4>";
if ($type=='draw') echo "List of players having bet on <h4>a draw</h4>";
echo " for the match <h4><font color=red> $team_name1 vs. $team_name2 </font></h4><br>";

echo "<table>";
for($i=0;$i<$num;$i++){
	$goals1=mysql_result($res,$i,'goals_team1');
	$goals2=mysql_result($res,$i,'goals_team2');
	
	switch ($type){
	case 'v1':
		if($goals1>$goals2) list_players_for_bet($res,$i);
		break;
	case 'v2':	
		if($goals2>$goals1) list_players_for_bet($res,$i);
		break;
	case 'draw':
		if($goals2==$goals1) list_players_for_bet($res,$i);
		break;
		
		
	}

}
asort($nickname);

foreach($nickname as $key=>$value){
	echo "<tr><td><a href='player_profile.php?id=$key'>$value</td><td> $goals1 - $goals2</td></tr>\n";
}
echo "</table>";
if (!$resp) echo "<h4>NO ONE</h4> did bet this result";

echo "<p><a href='javascript:history.back()'>Back</a></p>";

 
?>
