<?php

function format_date($date){
global $language,$language_array,$link;
	$loc=setloc();
	setlocale(LC_ALL,$loc);
	if($language=='en') return strftime("%a %b %d",strtotime($date));
	else return strftime("%a %d %b",strtotime($date));
//	return date("l M dS",strtotime($date));
}
//echo "<div id='title_main' class='boldf'> Matches</div>";
//echo "<div id='sa_menu_title' style='top:-30px;left:280px;'><img src='img/matches.gif'/></div>\n";
//echo "<div id='display_greetings'>";
//echo "<p><a href='javascript:history.back()'>Back</a></p>";
//echo "</div>\n";
if(isset($grp)) $grp=$_REQUEST['group'];
else $grp="";
//echo "<br/><div class='middle'><a href='http://www.marca.com/deporte/futbol/mundial/sudafrica-2010/calendario-english.html' target='new'>".get_word_by_id(150)."</a></div><br/>\n";
echo "<div id='matches'>\n";
if($grp!='') echo "<a href='matches.php' style='margin:0 0 0 280px;'>All matches</a>";
echo "<table align='center' >";

connect_to_eurodb();
$phase=get_current_phase();
$m=mysqli_query($link,"SELECT * FROM matches ORDER BY id") or die(mysql_error($link));
$num_m=mysqli_num_rows($m);

//	echo "<div class='match_euro_day'>\n"; 
	$flag_date=mysqli_result($m,0,'date');
	$descr=mysqli_result($m,0,'descr');
	$dated=format_date($flag_date);
//	echo "<div class='match_euro_day_border'>\n";
	echo "<tr><td class='date_display'>".$dated." </td>";
	echo "<td>";
	//".$descr." 
	echo "</td>";
for ($i=0;$i<$num_m;$i++){

$match_id=mysqli_result($m,$i,'id');
$phase=get_phase($match_id);
$arr=get_match_details($match_id,$login_id);
$place=get_word_by_id($DB::qry("SELECT trans FROM places WHERE place_id='".$arr['place_id']."'",3));
if($grp==$arr['group']||$grp==''){
if($flag_date!=$arr["date"]) {
	//echo "</div>"
	echo "</td></tr><tr><td>\n";
	//<div class='match_euro_day'>"; 
	$dated=format_date($arr["date"]);
	//echo "<div class='match_euro_day_border'>\n";
	echo "<tr><td class='date_display'>".$dated." </td><td>";
//".$arr["summary"].
	echo " </td>";
	}
	else if($i) echo "</tr><tr><td>&nbsp;</td><td>&nbsp;</td>";
//echo "<div class='match_board'>\n";
$flag_date=$arr["date"];

$odds1=mysqli_result($m,$i,'odds1');
$odds2=mysqli_result($m,$i,'odds2');
$oddsD=mysqli_result($m,$i,'oddsD');
$short_desc=mysqli_result($m,$i,'short_desc');

	echo "<td class='mb_place_display' class='standardfont'>";
	echo "<i>".$place.", ".substr($arr["time"],0,5)." </i>\n";
	echo "</td>";
	echo "<td align='right'>";
	echo display_matches($match_id,$phase,1,get_team_name_link($arr['t_id1'],0),$arr["code1"],0)."</td><td>-</td> <td align='left'> ".display_matches($match_id,$phase,2,get_team_name_link($arr["t_id2"],0),$arr["code2"],0);
//	echo "arrcode:".$arr["code1"];
	echo "</td>";
	echo "<td align='right'>".($match_id<=$fr_m?"<a href='matches.php?group=".$arr['group']."'>(".$arr['group'].")</a>":"&nbsp;$short_desc")."</td>";
//	echo "<td class='mb_bet_display'>";
//	if (is_bet($match_id,$login_id)) echo "".f_pick($arr["pick"],$arr["code1"],$arr["code2"])."&nbsp;-&nbsp;".(bet_result($arr["pick"],$arr['goals1'],$arr['goals2'])?"+".$arr['weight']:"0")."&nbsp;\n";
	if($odds1==-1) $o1="inf.";
	else $o1=round($odds1,2);
	if($oddsD==-1) $oD="inf.";
	else $oD=round($oddsD,2);
	if($odds2==-1) $o2="inf.";
	else $o2=round($odds2,2);



		}
}
//echo "</table>";	
echo "</td></tr></table>";
echo "</div>\n";
echo "<div id='final_round_chart'>\n";
echo "<table border=0 cellspacing='3' cellpadding='5' frame='below'>\n";
make_final_round_chart($tournament_type);
echo "</table>\n";
echo "</div>\n";
//echo "<p><a href='javascript:history.back()'>Back</a></p>";


?>

