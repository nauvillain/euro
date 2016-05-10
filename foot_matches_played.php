<?php
require 'lib/lib_rankings.php';

$played=mysql_query("SELECT *  FROM matches WHERE played=1  ORDER BY
		id DESC") or die(mysql_error());
if($played) $num=mysql_num_rows($played);
//show matches played
$prev_matches=$matches_showed;
if($num<$matches_showed) $prev_matches=$num;
$total=get_total_players();
if($num) echo "\n<div class='title_main_played' ><a href='results.php'>".toUpper(get_word_by_id(36))."\n</a></div>\n";
else {
	echo "<div id='temp_items'>";
	display_remaining_time();
	display_total_users($login_id);
	echo "\n</div>";
	}
if(is_being_played(1)){
	echo "<div id='temp_items'>";
	echo $tournament_has_started[$language];	
	echo "\n</div>";

}
if($num){
	echo "\n<div class='display_match_results'>";
	echo "\n<table class='matches_played_table'>";
	for ($i = 0; $i <$prev_matches; $i++) { 

		$match_id=mysql_result($played,$i,"id");
		$arr=get_match_details($match_id,$login_id);
		$coef=compute_coefficients($arr['odds1'],$arr['oddsD'],$arr['odds2'],$total);
		$t1=get_team_name_link($arr['t_id1'],4);
		$t2=get_team_name_link($arr['t_id2'],4);
		$pick_index=$arr['pick']-1;
		$round=$arr['round_id']
;		$p=$coef_round[$round];
		$odds=display_odds($arr["odds1"],$arr["oddsD"],$arr["odds2"],$match_id);
					echo "\n<tr>";
		echo "<td ><img src='img/".$arr["code1"].".png' class='image_pad' alt='".$arr["code1"]."'/></td>\n<td class='column_left'>".$t1."</td>";
					echo "<td class='score'> ".fscore($arr["goals1"])."&nbsp;-&nbsp;".fscore($arr["goals2"])."</td>\n";

					echo "<td class='column_right'>".$t2."</td>\n";
					echo "<td><img src='img/".$arr["code2"].".png' class='image_pad' alt='".$arr["code2"]."'/></td>\n";
					echo "<td> ".f_bet_result(bet_result($arr["pick"],$arr["goals1"],$arr["goals2"]))." ".(bet_result($arr["pick"],$arr['goals1'],$arr['goals2'])?"+".round($coef[$pick_index]*$p,2):"&nbsp;-&nbsp;")."</td>\n";
		echo "<td>".$odds."</td>\n";
					echo "</tr>\n";
					//if($temp) echo "<font color=red>My bet:&nbsp;&nbsp".$arr["gt1"]."-".$arr["gt2"]."<img src='img/".$arr["code2"].".gif'></font><br>\n";
	//				display_odds($arr["odds1"],$arr["oddsD"],$arr["odds2"],$match_id);
				//echo "\n</div>";
	}
	echo "\n</table>";
	echo "\n</div>";
	}	
echo "<div class='divider_played'><img src='img/divider_flourish.png'></div>\n";
	echo "\n<div class='display_match_results_rankings'>";
if($num) {
		echo "\n<div class='title_main_played' ><a href='rankings.php'>".strtoupper(get_word_by_id(124))."\n</a></div>\n";
		$test=new user;
		$data=$test->getUserRankingList();
		$test->displayUserRankings($data);
}
		echo "</div>";
	
//display_top_left($login_id);

?>
