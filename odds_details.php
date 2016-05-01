<?php
require 'php_header.php';

connect_to_eurodb();
echo "<div id='foot_main'>";


$type=$_REQUEST['type'];
$match_id=$_REQUEST['match_id'];
if(!still_time($match_id)||is_played($match_id)){

if($type=='v1') $showp=1;
if($type=='draw') $showp=2;
if($type=='v2') $showp=3;


$q="SELECT * FROM bets WHERE match_id=$match_id";
$res=mysql_query($q);
$num=mysql_num_rows($res);

$m="SELECT t1,t2 FROM matches where id=$match_id";
$resm=mysql_query($m);
$team1=mysql_result($resm,0,'t1');
$team2=mysql_result($resm,0,'t2');

$rest=mysql_query("SELECT team_name FROM teams WHERE team_id=$team1");
$team_name1=mysql_result($rest,0,0);
$rest=mysql_query("SELECT team_name FROM teams WHERE team_id=$team2");
$team_name2=mysql_result($rest,0,0);

if ($type=='v1') $winn=$team_name1;
else $winn=$team_name2;


echo "<div id='odds'>\n";
if($type=='v1' || $type=='v2') echo "List of players having bet on <h4>a victory for $winn</h4>";
if ($type=='draw') echo "List of players having bet on <h4>a TIE</h4>";
echo " for the match <h4><font color=red> $team_name1 vs. $team_name2 </font></h4><br>";
echo "<table><tr><td valign=top><table style='border:none;'>";
for($i=0;$i<$num;$i++){
	$pick=mysql_result($res,$i,'pick');
	$weight=mysql_result($res,$i,'weight');
	$p_id=mysql_result($res,$i,'player_id');
	$nick[$i]=substr(get_player_name($p_id),0,30)." (".get_ranking($p_id).")";
	$gp[$i]=$pick;
	$gw[$i]=$weight;
	$gi[$i]=$p_id;
	$gr[$i]=get_ranking($p_id);
$k+=1;	
}
$count=0;
$size=count($nick);
if($size>10) $limit=round($size/3)+1;
else $limit=5;
array_multisort($gr,SORT_ASC,$gp,SORT_DESC,$nick,SORT_DESC,$gi,SORT_DESC);

$temp=0;

foreach($gw as $key=>$value){
	
	if($gp[$key]==$showp){
		//echo (($gw[$key]!=$temp)?"<tr><td>&nbsp;-".$gw[$key]."-&nbsp;</td><td></td></tr>":"");
		echo "<tr><td><a href='player_profile.php?id=".$gi[$key]."'>".$nick[$key]."</td>\n";
		//echo "<td> ".$gw[$key]."</td>\n";
		echo "</tr>\n";
		$temp=$gw[$key];
		$count++;
		if($count==$limit) {
			echo "</table></td><td valign=top><table style='border:none;'>\n";
			$count=0;
		}
	}
}
echo "</table></td></tr></table>";
if (!$k) echo "<h4>NO ONE</h4> did bet this result";
echo "</div>";
}
echo "<p><a href='javascript:history.back()' style='float:right'>Back</a></p>";

 
?>
