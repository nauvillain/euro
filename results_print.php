<?php
require 'auth.php';
require 'lib.php';
echo "<div id='rankings'>";
echo "Correct bet: <img src='checkmark3.gif'>&nbsp; (with bonus for correct score: <img src='checkmark2.gif'>)&nbsp;&nbsp; - wrong bet: <img src='x.gif'>";

connect_to_database();
$res=mysql_query("SELECT team1,team2,goals1,goals2,date,place FROM matches WHERE played=1 ORDER BY id");
$num=mysql_num_rows($res);

$sco=mysql_query("SELECT top_scorer FROM scorer WHERE top=1") or mysql_die();
$num_scorer=mysql_num_rows($sco);

echo "<p><h2 align=center> Results </h2></p>";

echo "<table align=center><tr><td>\n";
echo "<b>Best scorer".($num_scorer>1?"s":"")."</b>";
for($k=0;$k<$num_scorer;$k++){
	$scorer=mysql_result($sco,$k);
	echo "<li>".$scorer;
}


if (!$num) echo "No results yet!";
else {
	echo "<table border=0 cellspacing=3 cellpadding=0 bordercolor=grey>\n";
	echo "<tr><td valign=top align=center>";
	echo "<b>Matches</b><br><br>";
	echo "<table border='3' bordercolor=grey>\n";
	echo "<tr><td>&nbsp;</td><td><b>Score</b></td><td>&nbsp;</td><td>&nbsp;</td></tr>";
	for ($i=0;$i<$num;$i++) {
		$team1=mysql_result($res,$i,"team1");
		$rez1=mysql_query("SELECT team_name,code FROM teams WHERE
				$team1=teams.id");
		$team1=mysql_result($rez1,0,'team_name');
		$code1=mysql_result($rez1,0,'code');

		$team2=mysql_result($res,$i,"team2");
		$rez2=mysql_query("SELECT team_name,code FROM teams WHERE
				$team2=teams.id");
		$team2=mysql_result($rez2,0,'team_name');
		$code2=mysql_result($rez2,0,'code');

		$goals1=mysql_result($res,$i,"goals1");
		$goals2=mysql_result($res,$i,"goals2");

		$sc=sc($goals1,$goals2);

		echo "<tr>\n";
		echo "<td><img src='img/$code1.gif'>&nbsp;&nbsp;$team1</td>\n";
		echo "<td align=center>&nbsp;".$goals1."-".$goals2."</td>\n";
		//  echo "<td>&nbsp;$goals2</td>\n";
		echo "<td align=right>&nbsp;$team2&nbsp;&nbsp;<img src='img/$code2.gif'></td>\n";    
		echo "<td><b>&nbsp;$sc&nbsp</b></td>";
		echo "</tr>\n";

	}

	echo "</table><br>\n";
	echo "</td>\n";

	//show player's results

	$bets=mysql_query("SELECT goals_team1,goals_team2 FROM bets WHERE
			player_id='$login_id' ORDER BY match_id") or mysql_die();
	$num_bets=mysql_num_rows($bets);

	if($num_bets!=$num) $num_bets=$num;
	
	echo "<td valign=top align=center>";
	echo "<table border=3 bordercolor=red>";
	//echo "<tr><td>Your</td><td>bets</td></tr>";
	echo "<b>My bets</b><br><br>";
	$perso_sc=0;
	echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td><b>Score</b></td><td><b>Total Pts</b></td</tr>";
	for($i=0;$i<$num_bets;$i++){
		$m_id=$i+1;
		$ma=mysql_query("SELECT * FROM bets where match_id=$m_id AND player_id=$login_id");
		
		$goals1=mysql_result($ma,0,'goals_team1');
		$goals2=mysql_result($ma,0,'goals_team2');

		//score bet
		$sc=sc($goals1,$goals2);

		//actual score
		$g1=mysql_result($res,$i,"goals1");
		$g2=mysql_result($res,$i,"goals2");

		$a_sc=sc($g1,$g2);
		$pts_m=init_points_array();
		
		if ($a_sc==$sc) {
			if($g1==$goals1&&$g2==$goals2) {
							$str="checkmark2";
							$perso_sc+=$pts_m[$i]+1;
			}
			else 				{
							$str="checkmark3";
							$perso_sc+=$pts_m[$i];
			}
		}
		else $str="x";

		echo "<tr>\n";
		echo "<td><b>&nbsp;$sc&nbsp;</b></td>";
		echo "<td><img src='$str.gif' height=12></td>";

		echo "<td align=center>&nbsp;".$goals1."-".$goals2."</td>\n";
		echo "<td align=center>".$perso_sc."</td>\n";    
		echo "</tr>\n";  

	}
	echo "</table>";
}
echo "</td></tr></table>";
echo "<div>\n";
?>
<?php
require 'footer.php';
?>
