<?php

require 'auth.php';
require 'lib_foot.php';
echo "<link rel='stylesheet' type='text/css' href='/css/euro.css' />";
echo "<h4> Matches played </h4>";
connect_to_eurodb();
$m=mysql_query("SELECT * FROM matches ORDER BY id") or die(mysql_error());
$num_m=mysql_num_rows($m);

for ($i=0;$i<$num_m;$i++){

echo "<div id='match_board_print'>\n";

	$match_id=mysql_result($m,$i,'id');
	
	$team1=mysql_result($m,$i,'t1');
	$team2=mysql_result($m,$i,'t2');
	$goals1=mysql_result($m,$i,'g1');
	$goals2=mysql_result($m,$i,'g2');

	$rez1=mysql_query("SELECT team_name,code FROM teams WHERE $team1=team_id") or die(mysql_error());
	$team_name1=mysql_result($rez1,0);

	$rez2=mysql_query("SELECT team_name,code FROM teams WHERE $team2=team_id") or die(mysql_error());
	$team_name2=mysql_result($rez2,0);

	$date=mysql_result($m,$i,'date');
	$place=mysql_result($m,$i,'place');
	$time=mysql_result($m,$i,'time');

	$odds1=mysql_result($m,$i,'odds1');
	$odds2=mysql_result($m,$i,'odds2');
	$oddsD=mysql_result($m,$i,'oddsD');

	
	$code1=mysql_result($rez1,0,"code");
	$code2=mysql_result($rez2,0,"code");
	$temp=mysql_query("SELECT bgt1,bgt2 FROM bets WHERE match_id='$match_id'
			AND player_id='$login_id'") or die(mysql_error());

	if($temp){
		$goals_team1=mysql_result($temp,0,"bgt1");

		$goals_team2=mysql_result($temp,0,"bgt2");
	}

	$bet=correct_bet($goals1,$goals2,$goals_team1,$goals_team2);


	echo "<i>".$place.", ".$time."   ".$date."</i>\n";
	echo "<p class='boldf'>".$team_name1." - ".$team_name2.":<b> ".$goals1."-".$goals2."</b></p>\n";
		if($goals_team1&&$goals_team2) echo "<font color=red>My bet:<img src='img/$code1.gif'>&nbsp;&nbsp;".$goals_team1."-".$goals_team2."&nbsp;&nbsp;<img src='img/$code2.gif'></font>\n";
		echo "<br>";
	 if($odds1==-1) $o1="inf.";
	 else $o1=round($odds1,2);
	 if($oddsD==-1) $oD="inf.";
	 else $oD=round($oddsD,2);
	 if($odds2==-1) $o2="inf.";
	 else $o2=round($odds2,2);
		
		echo "<b><a href='odds_all.php?match_id=$match_id'>odds</a>: <a href='odds_details.php?type=v1&match_id=$match_id'>$o1</a> / <a href='odds_details.php?type=draw&match_id=$match_id'>$oD</a>/ <a href='odds_details.php?type=v2&match_id=$match_id'>$o2</a></b>\n";
	 if(!still_time($match_id)) echo "<div id='match_bet'><img src='$bet'></div>\n";	
echo "</div>\n";


}
echo "</div>";
?>
