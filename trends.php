<?php
require 'php_header.php';
require 'javascript.php';

global $TOT_WEIGHTS;
?>
<?
$tri=$_REQUEST['sort'];

connect_to_eurodb();

function get_final_winner($id){
	if($id) $res=mysql_query("SELECT winner FROM users WHERE id='$id'") or die(mysql_error());
	return mysql_result($res,0,'winner');
}
function count_matches($played){
	$query="select count(*) from matches where played='$played'";
	$res=mysql_query($query) or die(mysql_error());
	return $res;
}

function current_total_points_bet($player_id){
	$query="select sum(weight) as sumw from bets where match_id in (SELECT id as match_id FROM matches where played=1) and player_id='$player_id'";
	$res=mysql_query($query) or die(mysql_error());
	return mysql_result($res,0,'sumw');
	
}
function display_table($arr,$arr2,$arrmax,$arravgp,$col){
global $login_id;
$j=-1;
$url='player_profile.php';

	$num=sizeof($arr);
	$len=floor($num/$col);
	?>
	<table style='margin:0 auto;border:20px;'><tr><td><table>
	<tr><td></td><td></td><td>Name</td><td><a href='trends.php?sort=1'>Current avg</a></td><td><a href='trends.php?sort=1'>Est. pts</a></td><td><a href='trends.php?sort=2'>Max</a></td></tr>
	<?php
	for($i=0;$i<$num;$i++){
		echo "<tr>\n";
		echo "<td>".($j!=$temp?($i+1):"")."</td>\n";
		$j=$temp;
		player_link(array_pop($arr2),$url);
		echo "<td>".array_pop($arravgp)."</td>\n";
		echo "<td>".($temp=floor(array_pop($arr)))."</td>\n";
		echo "<td>".array_pop($arrmax)."</td></tr>\n";
		if($i==$len) echo "</table></td><td><table>\n";
		}
	?>
	</table></td></tr></table>
<?php
}

function player_link($id,$url){
global $login_id;
	$code=get_country_code(get_final_winner($id));
	echo "<td>\n";
	if($code) echo "<img src='img/".$code.".gif' />\n";
	echo "</td><td>\n";
	echo "<a href='$url?id=$id'><div ".($id==$login_id?"class='emphasize'":"").">".substr(get_player_name($id),0,25)."</div></a>";	
	echo "</td>\n";
}
?>
<div id='main'>;
<div id='title_main'>Current trend</div>
<div> Note: this does not take any bonus (final winner, top scorer) into account.</div>
<?php
$query="SELECT id,current_points FROM users WHERE player=1";
//echo $query;
$result=mysql_query($query) or die(mysql_error());
$num=mysql_num_rows($result);

//$rem_matches=count_matches(0);
//$played_matches=count_matches(1);
if($num){
	for($i=0;$i<$num;$i++){
		$player_id=mysql_result($result,$i,'id');
		$pts=mysql_result($result,$i,'current_points');
			$current_total_bet=current_total_points_bet($player_id);
			if($current_total_bet) $avg_played=$pts/$current_total_bet;	
//		$rem=$TOT_WEIGHTS-$current_total_bet;	
		$rem=get_remaining_weights($player_id,$TOT_WEIGHTS,0);
		$est=$pts+$avg_played*$rem;
		$es['es'][$i]=$est;
		$es['id'][$i]=$player_id;
		$es['max'][$i]=$pts+$rem;
		$es['avgp'][$i]=round($avg_played,3)*100;
		$avg_pl[$player_id]=$avg_played;
		if($player_id==$login_id) {
			echo "<div id='trend_summary'><br/>I have $pts points so far, out of $current_total_bet (".$es['avgp'][$i]."%).<br/> I have $rem points left to allocate, so my final score is estimated at $pts+".round($avg_played,3)."*$rem : about ".round($est,0)."pts.<br/>
Below is the current estimate for everyone:</div>";
		
		}
		
}

if($tri==2) array_multisort($es['max'],$es['id'],$es['es'],$es['avgp']);
else array_multisort($es['es'],$es['id'],$es['max'],$es['avgp']);
?>
<br/><br/>
<?php
display_table($es['es'],$es['id'],$es['max'],$es['avgp'],1);
//foreach($es as $key=>$val){
//	echo	get_username($key)." ".round($val,2).", <br/>";
//}
}
?>
</div>
