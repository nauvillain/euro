<?php
require 'php_header.php';
require 'lib/lib_rankings.php';
css('rankings.css');


connect_to_eurodb();
$money=bet_money($login_id);

$display=$_GET['display'];
if($display=="") $display=0;

$title[0]=get_word_by_id(129); //"Rankings";
//$title[1]="Pot Race";
$title[1]=get_word_by_id(125);//correct bets
$title[2]=get_word_by_id(126);//"Rankings by lost points";
$title[3]=get_word_by_id(127);//"Rankings by points/correct bet";
$title[4]=get_word_by_id(128);//"Rankings by lost points/wrong bet";
$group=$_GET['group'];
$pot=$_GET['pot'];

echo "<div id='foot_main'>";
//	display_top_scorers();
echo "<div id='rankings_previous_winners'>\n";
require 'previous_winners.php';
echo "</div>\n";

echo "<div class='middle'><h2>".$title[$display]." ".($group?"(".get_word_by_id(131).")":"")."&nbsp;&nbsp;".($pot?get_word_by_id(149):"")."</h2></div>";
$member_query=mysql_query("SELECT id FROM usergroups WHERE user_id='$login_id'");
if(mysql_num_rows($member_query)) $group_flag=1; 
else $group_flag=0;
echo "<a href='rankings.php?display=0&group=$group&pot=$pot'>".$title[0]."</a>&nbsp; &nbsp;&nbsp;";
echo "<a href='rankings.php?display=1&group=$group&pot=$pot'>".$title[1]."</a>&nbsp; &nbsp;&nbsp;";


$sql_query="SELECT id,first_name,nickname,city,top_scorer,winner,current_points,current_correct,bet_money FROM users WHERE player=1".(($pot&&$money)?" AND bet_money=1":"");
if($group) $sql_query=$sql_query." AND id IN (SELECT member FROM usergroups WHERE user_id='$login_id')";

$res=mysql_query($sql_query);
$num=mysql_num_rows($res) or die(mysql_error());

$num_m=mysql_result(mysql_query("SELECT count(*) FROM matches WHERE played=1"),0);
if ($group==0&&$num==0) echo "No players registered yet!";
for ($i=0;$i<$num;$i++){

	$p_id=mysql_result($res,$i,"id");
	$nickname=mysql_result($res,$i,"nickname");
	$first_name=mysql_result($res,$i,"first_name");
	if($nickname=="") $nickname=$first_name;
	$nickname=get_player_name($p_id);
	$pts=mysql_result($res,$i,"current_points");
	$eur=mysql_result($res,$i,"bet_money");
	$curr=mysql_result($res,$i,"current_correct");
	$final_winner=mysql_result($res,$i,"winner");
	$rem_weights=get_remaining_weights($p_id,$TOT_WEIGHTS,0);
	$rank[$p_id]['tot']=$num_m;
  	$rank[$p_id]['rem']=$rem_weights;
	$rank[$p_id]['pts']=$pts;
	$rank[$p_id]['name']=$nickname;
	$rank[$p_id]['curr']=$curr;	
	$rank[$p_id]['curr_w']=$num_m-$rank[$p_id]['curr'];
	$rank[$p_id]['lost']=$TOT_WEIGHTS-$pts-$rem_weights;	
	$rank[$p_id]['p_id']=$p_id;
	$rank[$p_id]['winner']=$final_winner;
	if($curr) $rank[$p_id]['ppcb']=round($pts/$curr,2);
	 else $rank[$p_id]['ppcb']='undef.';
	if($rank[$p_id]['curr_w']) $rank[$p_id]['lppwb']=round($rank[$p_id]['lost']/$rank[$p_id]['curr_w'],2);
	 else $rank[$p_id]['lppwb']='undef.';
}
if($group) echo "<a href='rankings.php?display=$display&group=0&pot=$pot'>".get_word_by_id(130)."</a>&nbsp; &nbsp;&nbsp;";
else echo "<a href='rankings.php?display=$display&group=1&pot=$pot'>".get_word_by_id(131)."</a>&nbsp; &nbsp;&nbsp;";

if($money){
	if($pot) echo "<a href='rankings.php?display=$display&group=$group&pot=0'>".get_word_by_id(130)."</a>&nbsp; &nbsp;&nbsp;";
	else  echo "<a href='rankings.php?display=$display&group=$group&pot=1'>".get_word_by_id(149)."</a>&nbsp; &nbsp;&nbsp;";
	display_pot_numbers();
}

display_ranks($rank,$title,$display,$login_id);
?>
