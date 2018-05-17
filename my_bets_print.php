<?php
require 'auth_foot.php';
require 'session_language.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
require 'javascript.php';
require 'session_language.php';
connect_to_eurodb();

echo "<div style='width:500px;margin:0 auto;'>";
//take matches that correspond to the first round

$res=mysqli_query($link,"SELECT * FROM matches ORDER BY id");
$num_first=mysqli_num_rows($res);
echo "<h2>$tournament_name</h2>";
//check if player has entered any bets
//if he has but hasn't entered them all
//take the top scorer & World Cup Winner
$top=mysqli_query($link,"SELECT winner FROM users WHERE
id='$login_id'") or die(mysql_error());
$winner_id=mysqli_result($top,0,'winner');
if ($top) {
	$winn=mysqli_query($link,"SELECT team_id FROM teams WHERE team_id=$winner_id");
	$winner=get_team_name(mysqli_result($winn,0));
	}
if(!$winner_id) $winner="None chosen yet";
echo "<p><font color=red>".get_word_by_id(91)." :<b> ".$winner."</b></font></p>";

echo "<div id='bets_table'>\n";
echo "<table>\n";

for($i=0;$i<$num_first;$i++){

	$match_id=mysqli_result($res,$i,"id");
	$arr=get_match_details($match_id,$login_id);
	
	echo "<tr class='bet_match_row'>\n";
	echo "<td class='bet_desc'>".substr($arr["descr"],0,11)."</td>";
	echo "<td class='bet_team1_display'>". $arr["team1"]."</td>\n";
	echo "<td class='bet_score_display'>\n";
			if ($arr["played"]) echo " ".fscore($arr["goals1"])."&nbsp;-&nbsp;".fscore($arr["goals2"])."\n";
			else echo " - &nbsp;&nbsp;&nbsp;&nbsp;";
	echo "\n</td>\n";
	echo "<td class='bet_team2_display'>";
		echo $arr["team2"];
	echo "</td>";
	echo "<td class='bet_bet_display'>";
		echo f_pick($arr["pick"],$arr["code1"],$arr["code2"]);
	echo "</td>";
	echo "<td class='bet_bet_display'>";
		echo $arr["weight"];

		echo "</td>";
	echo "<td class='bet_bet_display'>";
		if($arr["played"]) echo f_bet_result(bet_result($arr["pick"],$arr["goals1"],$arr["goals2"]));

		echo "</td>";
	echo "</tr>\n";
	



}
echo "</table>\n";

echo "</div>\n";

?>

