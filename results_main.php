<?php


//echo "<div id='sa_menu_title' style='top:-30px;left:278px;'><img src='img/results.gif' alt='results'/></div>\n";
//echo "<div id='title_main' class='boldf'> Matches</div>";
//echo "<div id='display_greetings'><a href='matches_print.php' target='content'>Printable version</a>\n</div>\n";
echo "<div id='foot_main'>";
connect_to_eurodb();
	
//set locale
$loc=setloc();
setlocale(LC_ALL,$loc);

$m=mysqli_query($link,"SELECT * FROM matches WHERE played=1 ORDER BY id") or mysqli_error($link);
$num_m=mysqli_num_rows($m);
if($num_m){
	echo "<div class='euro_day'>\n"; 
	$flag_date=mysqli_result($m,0,'date');
	$descr=mysqli_result($m,0,'descr');
	$place_id=mysqli_result($m,0,"place");
	$rezp=mysqli_query($link,"SELECT * from places WHERE place_id='$place_id'") or mysqli_error($link);
	$place=mysqli_result($rezp,0,'city');
	$time=mysqli_result($m,0,"time");
	if($language=='en')	$dated=strftime("%A %B %e",strtotime($flag_date));
	else	$dated=strftime("%A %e %B",strtotime($flag_date));
}
	if($num_m) {
		echo "<div class='date_display'><div style='float:left;max-width=300px;'>".$dated;
		echo "</div>";
		echo "<div>&nbsp;".mysqli_result($m,0,"descr")."</div></div>";
		echo "<table class='euro_day_border'>\n";
	}
	else echo "<div class='middle'>".get_word_by_id(89).".</div>";
	//set the locale$loc=setloc();
for ($i=0;$i<$num_m;$i++){

$match_id=mysqli_result($m,$i,'id');
$arr=get_match_details($match_id,$login_id);
$phase=get_phase($match_id);
$first=getIfSet($first);
$temp_summary=getIfSet($temp_summary);
if($flag_date!=$arr["date"]||($temp_summary!=$arr["summary"]&&$first)) {
	echo "</table>";
	echo "</div>\n<div class='euro_day'>"; 
	if($language=='en') $dated=strftime("%A %B %e",strtotime($arr["date"]));
	else $dated=strftime("%A %e %B",strtotime($arr["date"]));
	echo "<div class='date_display'><div style='float:left;'>".$dated;
	echo "<div style='display:inline;width:100px;'>";
	echo "</div>";
	echo "</div>";
	echo "<div >&nbsp;".($phase?"Match ".$match_id." ":"")." ".$arr["summary"]."</div></div>";
	$temp_summary=$arr["summary"];
	$first=1;
	echo "<table class='euro_day_border'>\n";
	}
echo "<tr class='match_board'>\n";
	$flag_date=$arr["date"];
$odds1=mysqli_result($m,$i,'odds1');
$odds2=mysqli_result($m,$i,'odds2');
$oddsD=mysqli_result($m,$i,'oddsD');



		echo "<td class='mb_team1_display'>";
			echo get_team_name_link($arr["t_id1"],0);
		echo "</td>\n";
		echo "<td>\n";
		echo "<img src='img/".$arr["code1"].".png' class='image_pad'  alt=\"".$arr['team1']."\" />";
		echo "\n</td>\n";
		echo "<td class='display_score'>";
				if (is_played($match_id)) echo " ".fscore($arr["goals1"])."&nbsp;-&nbsp;".fscore($arr["goals2"])."\n";
				else echo "<b>&nbsp;</b>";
				echo "\n</td>\n";
				echo "<td><img src='img/".$arr["code2"].".png' class='image_pad' alt=\"".$arr['team2']."\"/></td>\n<td class='mb_team2_display'>";
			echo get_team_name_link($arr["t_id2"],0);
			echo "</td>";
		echo "<td style='width:80px;font:bold 13px lucida;'>";
			if (is_bet($match_id,$login_id)) show_gain($match_id,$login_id); 
			echo "</td>\n";	
		echo "<td class='mb_odds'>";
			echo display_odds($odds1,$oddsD,$odds2,$match_id);
		echo "</td>\n";

echo "</tr>\n";


		}
echo "</table>";
echo "</div>";	
echo "</div>";

?>
