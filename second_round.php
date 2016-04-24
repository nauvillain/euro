<?php
require 'php_header.php';
echo "<div id='main'>";
//this page is intended to enable the players to bet on the round of sixteen matches
connect_to_eurodb();

$upcoming=mysql_query("SELECT id,t1,t2,date,place,odds1,odds2,oddsD,time FROM
		matches  ORDER BY
		id ASC") or die(mysql_error());
$num=mysql_num_rows($upcoming);
for ($i = 0; $i <$num; $i++) { 

	$match_id=mysql_result($upcoming,$i,"id");
	$arr=get_match_details($match_id,$login_id);

	echo "<div id='sr_bets'>\n";
	//echo "<i>".utf8_encode($arr["place"]).", ".$arr["time"]."   ".$arr["date"]."</i>\n";
	echo "<div class='boldf'><img src='img/".$arr["code1"].".gif'>".$arr["team1"]." - ".$arr["team2"]."<img src='img/".$arr["code2"].".gif'></div>\n";
	if ($arr["cond"]) {
		echo "<font color=red>My bet:&nbsp;&nbsp;".$arr["goals_team1"]."-".$arr["goals_team2"]."&nbsp;&nbsp;</font>\n";
		if(still_time($match_id)) echo "<font color=red>&nbsp;&nbsp;&nbsp<a href='change_bet.php?id=$match_id'>Change it</a></font>";
		echo "<br>";
	}
	else {
		echo "<p><font color=red>No bet on this match yet</font>\n";
		echo "<font color=red>&nbsp;&nbsp;&nbsp<a href='change_bet.php?id=$match_id'>Bet on it now</a></font>";
		echo "</p>";
	}
	 if($odds1==-1) $o1="inf.";
	 else $o1=round($odds1,2);
	 if($oddsD==-1) $oD="inf.";
	 else $oD=round($oddsD,2);
	 if($odds2==-1) $o2="inf.";
	 else $o2=round($odds2,2);
		
	if (!still_time($match_id)) echo "<b><a href='odds_all.php?match_id=$match_id'>odds</a>: <a href='odds_details.php?type=v1&match_id=$match_id'>$o1</a> / <a href='odds_details.php?type=draw&match_id=$match_id'>$oD</a>/ <a href='odds_details.php?type=v2&match_id=$match_id'>$o2</a></b>";

	echo "</div>\n";
		
}
echo "</div>";
require 'foot_foot.php';

?>
