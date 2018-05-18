<?php
require 'php_header.php';
require 'javascript.php';

connect_to_eurodb();
echo "<div id='foot_main'>";
//echo "<div id='sa_menu_title' style='top:-30px;left:278px;'><img src='img/picks.gif'/></div>\n";
if(still_time(1)) echo "<br><b><i>".remaining_time(0)." day".(remaining_time(0)==1?"":"s")." to go!</i></b><br>";

//see what has been already entered by the user
echo "<div id='display_greetings'><a href='my_bets_print.php' target='content'>->".get_word_by_id(141)."</a></div>";

//take matches that correspond to the first round

$res=mysqli_query($link,"SELECT * FROM matches ORDER BY id");
$num_first=mysqli_num_rows($res);

//check if player has entered any bets
//if he has but hasn't entered them all
//take the top scorer & World Cup Winner
echo "<div ><a href='edit_bets1.php'>".get_word_by_id(94)."</a></div>";
$top=mysqli_query($link,"SELECT winner FROM users WHERE
id='$login_id'") or mysqli_error($link);
$winner_id=mysqli_result($top,0,'winner');
if ($top) {
	$winn=mysqli_query($link,"SELECT team_id FROM teams WHERE team_id=$winner_id");
	if(mysqli_num_rows($winn)) $winner=get_team_name(mysqli_result($winn,0));
	}
if(!$winner_id) $winner="None chosen yet";
echo "<p><font color=red> ".get_word_by_id(91).":<b> ".$winner."</b>";
echo "  --  ".get_word_by_id(109).":<b> ".find_scorer($login_id)."</b></font></p>";

echo "<div id='bets_table'>\n";
echo "<table>\n";

for($i=0;$i<$num_first;$i++){
	$match_id=mysqli_result($res,$i,"id");
	$arr=get_match_details($match_id,$login_id);
	
	echo "<tr class='bet_match_row'>\n";
	echo "<td class='bet_desc'>".$arr["descr"]."</td>";
	echo "<td class='bet_team1_display'>". $arr["team1"]."</td>\n";
	echo "<td class='bet_score_display'>\n";
			if ($arr["played"]) echo " ".fscore($arr["goals1"])."&nbsp;-&nbsp;".fscore($arr["goals2"])."\n";
			else echo "---";
	echo "\n</td>\n";
	echo "<td class='bet_team2_display'>";
		echo $arr["team2"];
	echo "</td>";
	echo "<td class='bet_bet_display'>";
		echo f_pick($arr["pick"],$arr["code1"],$arr["code2"]);
	echo "</td>";
	echo "<td id='weight".$match_id."' class='bet_bet_display'>";
//		echo $arr["weight"];

		echo "</td>";
	echo "<td class='bet_bet_display'>";
		if($arr["played"]) show_gain($match_id,$login_id);
//echo f_bet_result(bet_result($arr["pick"],$arr["goals1"],$arr["goals2"]));

		echo "</td>";
	echo "</tr>\n";
	



}
echo "</table>\n";

echo "</div>\n";

?>
<?php
require 'foot_foot.php';
?>
