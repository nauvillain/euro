<?php
require 'php_header.php';
//require 'config/config_foot.php';
function total_players($match_id){
	
	$res=mysql_query("SELECT count(*) FROM bets  WHERE match_id=$match_id and pick !=0  ");
//	echo mysql_result($res,0);
	return(mysql_result($res,0));	
}
$formula="odds: total players (".get_total_players().")/numbers of players who picked this outcome";
echo "<div id='foot_main'>";

$match_id=$_REQUEST['match_id'];
if(!still_time($match_id)||is_played($match_id)){


$q="SELECT * FROM bets WHERE match_id=$match_id";
$res=mysql_query($q);
$num=mysql_num_rows($res);

$m="SELECT t1,t2,res FROM matches where id=$match_id";
$resm=mysql_query($m);
$team1=mysql_result($resm,0,'t1');
$team2=mysql_result($resm,0,'t2');
$resul=mysql_result($resm,$i,'res');

$team_name1=get_team_name($team1);
$team_name2=get_team_name($team2);
$victory=get_word_by_id(102);
$tie=get_word_by_id(103);
$arr[1]['result']=$victory.": ".$team_name1;
$arr[2]['result']=$tie;
$arr[3]['result']=$victory.": ".$team_name2;

echo " <h1><font color=red> $team_name1 vs. $team_name2 </font></h4>";
for($i=0;$i<$num;$i++){

		$p_id=mysql_result($res,$i,'player_id');
		$resp=mysql_query("select first_name,nickname from users where id=$p_id") or die(mysql_error());
		$pick=mysql_result($res,$i,'pick');
		$weight=mysql_result($res,$i,'weight');
		if(mysql_num_rows($resp)){
			$temp_nick=mysql_result($resp,0,'nickname');
			if(!$temp_nick) $temp_nick=mysql_result($resp,0,'first_name');
		}
		$rank=get_ranking($p_id);
		if($pick){
			$arr[$pick]['rank'][$i]=$rank;
			$arr[$pick]['nick'][$i]=ucfirst(strtolower($temp_nick))." (".$rank.")";
			$arr[$pick]['id'][$i]=$p_id;
			$arr[$pick]['weight'][$i]=$weight;
		}
}
//for($i=0;$i<sizeof($arr);$i++) asort(); 
for($i=1;$i<sizeof($arr_pick)+1;$i++){
if((!get_phase($match_id)||$i!=2)&&sizeof($arr_pick)) {
array_multisort($arr[$i]['rank'],SORT_ASC,$arr[$i]['weight'],SORT_DESC,$arr[$i]['nick'],SORT_DESC,$arr[$i]['id'],SORT_DESC);
}
}
for($i=1;$i<=3;$i++){

if(!get_phase($match_id)||$i!=2) {
	echo "<div id='odds'>\n";
	
	echo "<div class='odds_cap'>Max odds: $max_odds</div>\n";
	$total=get_total_players($match_id);
	$co=count($arr[$i]['id']);
	if($total) $percent=$total/$co;
	echo "<h4 title='".$formula." (".$co.")'>".$arr[$i]['result']." (".round($percent,2).")</h4>\n";
	echo "<table>";
	echo "<tr>";
	echo "<td>";
	echo "<table style='border:none;'>";

	$count=0;
	$size=count($arr[$i]['id']);
	if($size>10) $limit=round($size/3)+1;
	else $limit=5;
	$temp=0;
	if($size){
//		arsort($arr[$i]['weight']);	
		foreach($arr[$i]['weight'] as $key=>$value){
//		if(($value!=$temp)) echo "<tr><td>-$value-</td><td></td></tr>\n";
		//echo "<tr><td><a href='player_profile.php?id=".($arr[$i]['id'][$key])."'>".$arr[$i]['nick'][$key]."</td><td>". $arr[$i]['pick'][$key]." - ".$value."</td></tr>\n";
		echo "<tr><td><a href='player_profile.php?id=".($arr[$i]['id'][$key])."'>".$arr[$i]['nick'][$key]."</td><td>". $arr[$i]['pick'][$key]."</td></tr>\n";
		$temp=$value;
		$count++;
		if($count==$limit) {
			echo "</table></td><td valign=top><table style='border:none;'>\n";
			$count=0;
		}
	}
	}
	if (!sizeof($arr[$i]['id'])) echo "<tr><td><b>".get_word_by_id(104)."!</b></td></tr>\n";
	echo "</table>";
	echo "</td>";
	echo "</tr>\n";
	echo "</table>";
	echo "</div>\n";
}
}
}
echo "<p><a href='javascript:history.back()' style='float:right'>Back</a></p>";

 
?>
