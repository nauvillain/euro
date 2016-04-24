<?php

echo "<div class='title_main'>".get_word_by_id(85)."\n</div>\n";
$upcoming=mysql_query("SELECT id,t1,t2,date,place,odds1,odds2,oddsD, time FROM
		matches WHERE played=0  ORDER BY
		id ASC");
$num=mysql_numrows($upcoming);
if ($num<$matches_showed) $matches_showed=$num;
if ($num==0) echo "<br/><br/><div class='foot_match_board'>No more matches...</div>";
for ($i = 0; $i <$matches_showed; $i++) { 
	$match_id=mysql_result($upcoming,$i,'id');
	$arr=get_match_details($match_id,$login_id);
	$loc=setloc();
	setlocale(LC_ALL,$loc);
//print_r($arr);
	echo "<div class='foot_match_board'>";
		echo "<div class='foot_mb_place_display'>".$arr["place"].", ".substr($arr["time"],0,5)."   ".strftime("%A",strtotime($arr["date"]));
		echo "\n</div>\n";
		echo "<div class='foot_mb_match_display'>\n";
			echo "<div class='foot_mb_team_display'>";
			$phase=get_phase($match_id);
			echo display_matches($match_id,$phase,1,$arr["team1"],$arr["code1"])." - ".display_matches($match_id,$phase,2,$arr["team2"],$arr["code2"]);
			echo "</div>\n";
			echo "<div class='foot_mb_bet_display'>";
			if (is_bet($match_id,$login_id)) {
				echo get_word_by_id(100).":&nbsp;&nbsp;".f_pick($arr["pick"],$arr["code1"],$arr["code2"])."&nbsp;(".$arr["weight"].")&nbsp;\n";
				if (still_time($match_id)) echo "<a href='change_bet.php?id=$match_id'>".get_word_by_id(108)."</a>";
			}
			else {
				if(still_time($match_id)) echo "&nbsp;&nbsp;&nbsp<a href='ch_bet.php?id=$match_id'>".get_word_by_id(99)."</a>";
			
			}
			echo "\n</div>";
		echo "\n</div>";
	 if($arr["odds1"]){
		 if($arr["odds1"]==-1) $arr["odds1"]=get_word_by_id(101);
	 	else $o1=$arr["odds1"];
		}
	 if($arr["oddsD"]){
	 if($arr["oddsD"]==-1) $arr["oddsD"]=get_word_by_id(101);
	 else $arr["oddsD"]=$arr["oddsD"];
		}
	 if($arr["odds2"]){
	 if($arr["odds2"]==-1) $arr["odds2"]=get_word_by_id(101);
	 else $arr["odds2"]=$arr["odds2"];
		}
		
	if (!still_time($match_id)) display_odds($arr["odds1"],$arr["oddsD"],$arr["odds2"],$match_id);
//echo "<div><a href='odds_all.php?match_id=$match_id'>odds</a>: <a href='odds_details.php?type=v1&match_id=$match_id'>1&nbsp;</a> / <a href='odds_details.php?type=draw&match_id=$match_id'>&nbsp;X&nbsp;</a>/ <a href='odds_details.php?type=v2&match_id=$match_id'>&nbsp;2&nbsp;</a>\n</div>";
	echo "\n</div>\n";
	
	}

?>
