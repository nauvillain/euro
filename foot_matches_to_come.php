<?php
require 'lib/lib_bonus.php';
global $link;
echo "<div class='title_main'><a href='matches.php'>".toUpper(get_word_by_id(33))."\n</a></div>\n";
$upcoming=mysqli_query($link,"SELECT id,t1,t2,date,place,odds1,odds2,oddsD, time FROM
		matches WHERE played=0  ORDER BY
		id ASC");
$num=mysqli_num_rows($upcoming);
if ($num<$matches_showed) $matches_showed=$num;
if ($num==0) {
	echo "<br/><br/><div class='foot_match_board'>No more matches...</div>";
	display_winners_final_winner();
	display_championship_winner();
	display_championship_top_scorers();
}
for ($i = 0; $i <$matches_showed; $i++) { 
	$match_id=mysqli_result($upcoming,$i,'id');
	$arr=get_match_details($match_id,$login_id);
	$t1=get_team_name_link($arr['t_id1'],0);
	$t2=get_team_name_link($arr['t_id2'],0);
	$loc=setloc();
	setlocale(LC_ALL,$loc);
//print_r($arr);
	/* $res_title1=extractrsstitle($title[$arr['m_id']]);
if($res_title1['score']){
	if(get_english_team_name($arr['t_id1'])==$res_title1['t1']) $strlive1=$res_title1['g1'];
	if(get_english_team_name($arr['t_id2'])==$res_title1['t1']) $strlive2=$res_title1['g1'];
		if(get_english_team_name($arr['t_id1'])==$res_title1['t2']) $strlive1=$res_title1['g2'];
		if(get_english_team_name($arr['t_id2'])==$res_title1['t2']) $strlive2=$res_title1['g2'];
}
else {
	if(is_being_played($match_id)) $strlive1=$strlive2=0;
	else $strlive1=$strlive2="";
}*/

		echo "\n<div class='foot_match_panel'>\n";
			$place=get_word_by_id($DB::qry("SELECT trans FROM places WHERE place_id='".$arr['place_id']."'",3));
	echo "<div class='foot_match_board'>";
	echo "<div class='img_stadium'>\n";
	echo "<img src='img/st".$arr["place_id"].".png' alt='".$arr['place']."' />";
	echo "<a href='".$stadium[$arr["place_id"]]."' style='text-decoration:none;' target='new_window'>".$place."</a></div>\n";
		if(still_time(1)) $date_format="%A - %d %B";
		else $date_format="%A";
		echo "<div class='foot_mb_place_display' title='".date("d F",strtotime($arr['date']))."'>".substr($arr["time"],0,5)."   ".strftime($date_format,strtotime($arr["date"]));
		echo "\n</div>\n";
		echo "<div class='foot_mb_match_display'>\n";
			echo "<div class='foot_mb_team_display'>";
			$phase=get_phase($match_id);
			echo "<div class='team_name_left'>\n";
	//		echo display_matches($match_id,$phase,1,$t1,$arr["code1"])."</div>\n<div class='separator'>".$strlive1." - ".$strlive2."</div>\n<div class='team_name_right'>".display_matches($match_id,$phase,2,$t2,$arr["code2"])."</div>\n";
			
			echo display_matches($match_id,$phase,1,$t1,$arr["code1"])."</div>\n<div class='separator'>"."</div>\n<div class='team_name_right'>".display_matches($match_id,$phase,2,$t2,$arr["code2"])."</div>\n";
			echo "</div>\n";
			echo "<div class='foot_mb_bet_display'>";
			if (is_bet($match_id,$login_id)) {
				echo get_word_by_id(100).":&nbsp;&nbsp;".f_pick($arr["pick"],$arr["code1"],$arr["code2"])."&nbsp;";
		//echo "(".$arr["weight"].")&nbsp;\n"; when weights are being used, display them
				if (still_time($match_id)) echo "<a href='change_bet.php?id=$match_id'>".get_word_by_id(108)."</a>";
			}
			else {
				if(still_time($match_id)) echo "&nbsp;&nbsp;&nbsp<a href='ch_bet.php?id=$match_id'>".get_word_by_id(99)."</a>";
			
			}
	if (!still_time($match_id)) {
		
		echo "<div id='odds_matches_to_come'>\n";
		echo display_odds($arr["odds1"],$arr["oddsD"],$arr["odds2"],$match_id);
		echo "</div>";
	}
			echo "\n</div>";
		echo "\n</div>";
/*	 if($arr["odds1"]){
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
		}*/
		
//echo "<div><a href='odds_all.php?match_id=$match_id'>odds</a>: <a href='odds_details.php?type=v1&match_id=$match_id'>1&nbsp;</a> / <a href='odds_details.php?type=draw&match_id=$match_id'>&nbsp;X&nbsp;</a>/ <a href='odds_details.php?type=v2&match_id=$match_id'>&nbsp;2&nbsp;</a>\n</div>";
	echo "<div class='divider'><img src='img/divider_flourish.png'></div>\n";
	echo "\n</div>\n";
	echo "\n</div>\n";
	
	}


?>
