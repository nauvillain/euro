<?php
require 'config.php';

function mysql_die()
{
echo mysql_error();
echo "</table></table></table>\n";
exit;
}


function create_groups()
{

$result=mysql_query("SELECT * FROM website.teams ORDER BY id") or mysql_die();
$num=mysql_num_rows($result);
for ($i=0;$i<$num;$i++) {
$pld[$i]=0;
$ga[$i]=0;
$gf[$i]=0;
$pts[$i]=0;
$wins[$i]=0;
$ties[$i]=0;
$defs[$i]=0;
$team[$i]=mysql_result($result,$i,"team_name");
$code[$i]=mysql_result($result,$i,"code");
}


$matches=mysql_query("SELECT id,team1, team2, goals1, goals2, played
FROM website.matches WHERE played=1 AND id<49");
$num_matches_played=mysql_num_rows($matches);

//count the points for each team

for($j=0;$j<$num_matches_played;$j++){

    $team1_id=mysql_result($matches,$j,"team1")-1;
    $team2_id=mysql_result($matches,$j,"team2")-1;
    $goals1=mysql_result($matches,$j,"goals1");
    $goals2=mysql_result($matches,$j,"goals2");

    $pld[$team1_id]+=1; $pld[$team2_id]+=1; $gf[$team1_id]+=$goals1;
    $gf[$team2_id]+=$goals2; $ga[$team1_id]+=$goals2;
    $ga[$team2_id]+=$goals1;

    if($goals1>$goals2) { 	$pts[$team1_id]+=3;
				$wins[$team1_id]+=1;
				$defs[$team2_id]+=1;
				} 
    if($goals1<$goals2) { 	$pts[$team2_id]+=3;
				$wins[$team2_id]+=1;
                                $defs[$team1_id]+=1;
} 
    if($goals1==$goals2){ 	$pts[$team1_id]+=1; $pts[$team2_id]+=1;
				$ties[$team1_id]+=1;$ties[$team2_id]+=1; 
}

}

$letter=array("A","B","C","D","E","F","G","H");
for($j=0;$j<sizeof($letter);$j++){
	for($i=0;$i<4;$i++){ 
		     $u=$i+4*$j;
		     $arr[$letter[$j]][$i]["team"]=$team[$u];
		     $arr[$letter[$j]][$i]["pld"]=$pld[$u];
		     $arr[$letter[$j]][$i]["gf"]=$gf[$u];
		     $arr[$letter[$j]][$i]["ga"]=$ga[$u];
		     $arr[$letter[$j]][$i]["gd"]=$gf[$u]-$ga[$u];
		     $arr[$letter[$j]][$i]["pts"]=$pts[$u];
		     $arr[$letter[$j]][$i]["code"]=$code[$u];
		     $arr[$letter[$j]][$i]["wins"]=$wins[$u];
		     $arr[$letter[$j]][$i]["defs"]=$defs[$u];
		     $arr[$letter[$j]][$i]["ties"]=$ties[$u];
		     
	}		     
}
return $arr;
}


function g_sort($array){		
		foreach($array as $v2){
			 $sortpts[]=$v2['pts'];
			 $sortgd[]=$v2['gd'];
			 $sortgf[]=$v2['gf'];
		
}
		array_multisort($sortpts,SORT_DESC,$sortgd,SORT_DESC,$sortgf,SORT_DESC,$array);
		unset($sortpts) ;
		unset($sortgd);
		unset($sortgf);
return $array;
}

function show_team($letter,$grp,$num){

	 $grp=g_sort($grp[$letter]);
	 if(($grp[0]['pld']==3)&&($grp[1]['pld']==3)&&($grp[2]['pld']==3)&&($grp[3]['pld']==3)){
		
		$st=strtoUpper($grp[$num]['team']);
		}
	 else { if(!$num) {$st= "Winner ".$letter;} 
	      else {$st="Runner-up ".$letter;} }
	return $st;
}

function return_team($letter,$grp,$num){

	 $grp=g_sort($grp[$letter]);
	 if(($grp[0]['pld']==3)&&($grp[1]['pld']==3)&&($grp[2]['pld']==3)&&($grp[3]['pld']==3)){
		
		return $grp[$num]['team'];
		}
	 else { if(!$num) {return "Winner ".$letter;} 
	      else {return "Runner-up ".$letter;} }
		
}


function show_standings($grp){
	foreach($grp as $temp){
		echo "<tr><td align=left><img src='img/$temp[code].gif'>&nbsp;&nbsp;".$temp[team];"</td>";
		echo "<td align=center>".$temp[pld]."</td>\n";
		echo "<td align=center>".$temp[wins]."</td>\n";
		echo "<td align=center>".$temp[ties]."</td>\n";
		echo "<td align=center>".$temp[defs]."</td>\n";
		echo "<td align=center>".$temp[gf]."</td>\n";
		echo "<td align=center>".$temp[ga]."</td>\n";
		echo "<td align=center>".$temp[gd]."</td>\n";
		echo "<td align=center><b>".$temp[pts]."</b></td>\n";
		echo "</tr>";
	}

}

function winner($match_id){

$query="SELECT * FROM matches WHERE id='$match_id'";
$sql=mysql_query($query) or mysql_die();
$played=mysql_result($sql,0,"played");

if($played){

$goals1=mysql_result($sql,0,"goals1");
$goals2=mysql_result($sql,0,"goals2");
$team1=mysql_result($sql,0,"team1");
$team2=mysql_result($sql,0,"team2");

if($goals1>$goals2) return $team1;
if($goals2>$goals1) return $team2;
}
else return "not played yet";
}

function find_team($team_id){

if($team_id!="not played yet"){

$query="SELECT team_name FROM teams WHERE id='$team_id'";
$res=mysql_query($query) or mysql(die);
$team=mysql_result($res,0);

return $team;
}
else return "------------";
}

function get_player_name($id){

if($id){

$query="SELECT nickname,first_name FROM users WHERE id='$id'";
$res=mysql_query($query) or mysql(die);
$rez=mysql_result($res,0,"nickname");
if(!$rez) $rez=mysql_result($res,0,"first_name");
return $rez;
}

}

function check_uniqueness($field,$value){

$query="SELECT * FROM players WHERE $field='$value'";
$sql=mysql_query($query) or mysql_die();
$num=mysql_num_rows($sql);
if ($num) return false;
else return true;
}

function display_win1($group,$num,$total,$arr){
$t=show_team($group,$arr,$num);
echo "<tr>";
for ($i==0;$i<$total;$i++){

echo "<td>\n";
if ($i==0) echo "<b>".$t."</b>";
echo "</td>\n"; 

}
echo "</tr>";
}

function display_win2($match_id,$stage,$total){

echo "<tr>";
for ($i==0;$i<$total;$i++){

echo "<td>";
if($i==$stage-1) echo match_info($match_id);
if($i==$stage) { 
	echo "<b>".strtoUpper(find_team(winner($match_id))).find_score($match_id)."</b>";
	}
echo "</td>\n"; 

}
echo "</tr>";
}
function match_info($match_id){
connect_to_database();
$query="select time,date,place from matches where id='$match_id'";
$res=mysql_query($query) or mysql(die);
$time=mysql_result($res,0,"time");
$date=mysql_result($res,0,"date");
$place=mysql_result($res,0,"place");
$place=substr($place,0,3);
$date=date("D M j",strtotime($date));
$str=$date.", ".$place.".";
return $str;
}

function loser($match_id){

$query="SELECT * FROM matches WHERE id='$match_id'";
$sql=mysql_query($query) or mysql_die();
$played=mysql_result($sql,0,"played");

if($played){

$goals1=mysql_result($sql,0,"goals1");
$goals2=mysql_result($sql,0,"goals2");
$team1=mysql_result($sql,0,"team1");
$team2=mysql_result($sql,0,"team2");

if($goals1>$goals2) return $team2;
if($goals2>$goals1) return $team1;
}
else return "not played yet";
}
function find_score($match_id){
connect_to_database();
$query="select goals1,goals2,played from matches where id='$match_id'";
$res=mysql_query($query) or mysql(die);
$goals1=mysql_result($res,0,"goals1");
$goals2=mysql_result($res,0,"goals2");
$played=mysql_result($res,0,"played");
if($played)$str="(".$goals1."-".$goals2.")";
return $str;
}

function remaining_time($match_id){

if (!$match_id) {
	$start=mktime(0,0,0,6,10,2006);
	$res=floor(($start-time())/86400);
	return $res;
}
else	{
	connect_to_database();
	$query="select time,date,place from matches where id='$match_id'";
	$res=mysql_query($query) or mysql(die);
	$time=mysql_result($res,0,"time");
	$date=mysql_result($res,0,"date");
	$now=time();
	$match_date=$date+$time;
	return date('m-d',$match_date-$now);
}

}
function spacer($w,$h){
	return "<img src='spacer.gif' width=$w height=$h>";
}

function init_points_array(){

$PTS_FR=2;
$PTS_R16=3;
$PTS_QRT=4;
$PTS_SEM=6;
$PTS_FIN=8;
$PTS_THP=2;
$PTS_BON=1;
$PTS_TOP_SCORER=5;

$PTS_W=10;

$FR_M=48;
$R16_M=8;
$QRT_M=4;
$SEM_M=2;
$FIN_THP_M=1;
$FIN_M=1;
$TOTAL_M=$FR_M+$R16_M+$QRT_M+$SEM_M+$FIN_THP_M+$FIN_M;
$m_counter=0;


for($j=0;$j<$FR_M;$j++) {
	$pts_m[$m_counter]=$PTS_FR;
	$m_counter++;
}
for($j=0;$j<$R16_M;$j++) {
	$pts_m[$m_counter]=$PTS_R16;
	$m_counter++;
}
for($j=0;$j<$QRT_M;$j++) {
	$pts_m[$m_counter]=$PTS_QRT;
	$m_counter++;
}
for($j=0;$j<$SEM_M;$j++) {
	$pts_m[$m_counter]=$PTS_SEM;
	$m_counter++;
}

for($j=0;$j<$FIN_THP_M;$j++) {
	$pts_m[$m_counter]=$PTS_THP;
	$m_counter++;
}
for($j=0;$j<$FIN_M;$j++) {
	$pts_m[$m_counter]=$PTS_FIN;
	$m_counter++;
}
return $pts_m;
}

function count_points($goals1,$goals2,$played,$p_id,$j,$val,$bonus){

	$pts=0;
	$match_id=$j+1;
	
	
	$res2=mysql_query("SELECT * FROM bets WHERE player_id=$p_id AND match_id=$match_id");
	$numb=mysql_num_rows($res2);
	$goals_team1=mysql_result($res2,0,"goals_team1");
	$goals_team2=mysql_result($res2,0,"goals_team2");

	if ($goals1>$goals2) $result="victory1";
	if ($goals1==$goals2) $result="tie";
	if ($goals2>$goals1) $result="victory2";

	if ($goals_team1>$goals_team2) $bet="victory1";
	if ($goals_team1==$goals_team2) $bet="tie";
	if ($goals_team2>$goals_team1) $bet="victory2";
	//echo "p_id=$p_id;match_id=$match_id;".$result."-$goals1-$goals2,".$bet."-$goals_team1,$goals_team2;<br> ";
	if(($played!=0)&&($numb!=0)){
		if($result==$bet) $pts=$val;
		if(($goals1==$goals_team1)&&($goals2==$goals_team2)) $pts+=$bonus; 
	}
	return $pts;
}

function still_time($match_id) {

	connect_to_database();

	$upcoming=mysql_query("SELECT id,team1,team2,date,place, time FROM
			matches WHERE id=$match_id");

	$time=mysql_result($upcoming,0,"time");
	$date=mysql_result($upcoming,0,"date");
	$date=date("l, F dS",strtotime($date));
	$test=strtotime($date);
	$test4=strtotime($time);
	$seconds_that_day=$test4-mktime(0,0,0,date('m',$test4),date('d',$test4),date('Y',$test4));
	$full_time=$test+$seconds_that_day;

	if(time()<$full_time) return $full_time;
	else return 0;
}

function sc($g1,$g2){

	if($g1==$g2) $sc="D";
	else {
		if ($g1>$g2) $sc="1";
		else $sc="2";
	}
	return $sc;
}
function correct_bet($g1,$g2,$g3,$g4){

$exact="checkmark2.gif";
$correct="checkmark3.gif";
$wrong="x.gif";

$a=sc($g1,$g2);
$b=sc($g3,$g4);

if(($g1==$g3)&&($g2==$g4)) return $exact;
else {
	if($a==$b) return $correct;
	else return $wrong;
}

}

function odds($match_id){
	connect_to_database();

	$query="select * from bets where match_id=$match_id and player_id<>5 and player_id<>12";
	$res=mysql_query($query);
	$num_betters=mysql_num_rows($res);
	$m1=0;
	$m2=0;
	$mD=0;
	for ($i=0;$i<$num_betters;$i++){

		$g1=mysql_result($res,$i,'goals_team1');
		$g2=mysql_result($res,$i,'goals_team2');

		if($g1>$g2) $m1++;
		if($g2>$g1) $m2++;
		if($g2==$g1) $mD++;

	}
if($m1)	$arr[0]=$num_betters/$m1;
else $arr[0]=-1;
if($mD)	$arr[1]=$num_betters/$mD;
else $arr[1]=-1;
if($m2)	$arr[2]=$num_betters/$m2;
else $arr[2]=-1;

	return $arr;

}
?>
