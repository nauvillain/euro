<?php
require 'conf.php';
function connect_to_eurodb()
{
  global $db_database, $db_username, $db_password, $db_hostname;
  mysql_pconnect($db_hostname,$db_username,$db_password) or die(mysql_error());
  mysql_select_db($db_database) or mysql_error("Error connecting to the database :(");
}


function create_groups()
{

$result=mysql_query("SELECT * FROM euro_2008.teams ORDER BY team_id") or die(mysql_error());
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


$matches=mysql_query("SELECT id,t1, t2, g1, g2, played
FROM matches WHERE played=1 ") or die(mysql_error());
$num_matches_played=mysql_num_rows($matches);

//count the points for each team

for($j=0;$j<$num_matches_played;$j++){

    $team1_id=mysql_result($matches,$j,"t1")-1;
    $team2_id=mysql_result($matches,$j,"t2")-1;
    $goals1=mysql_result($matches,$j,"g1");
    $goals2=mysql_result($matches,$j,"g2");

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

$letter=array("A","B","C","D");
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

function show_team($letter,$num){

	
	
	$res=mysql_query("SELECT * FROM teams WHERE group_name='$letter' ORDER BY current_pos ASC LIMIT 1".($num?",$num":"")) or die(mysql_error());
	$grp=mysql_fetch_array($res);
//pts DESC,gf-ga DESC,gf 
	 if(group_over($letter)){
		
		$st['id']=$grp['team_id'];
		$st['name']=get_team_name($grp['team_id']);
		$st['def']=1;
		}
	 else { 
			 if($num==0) $st['name']= get_word_by_id(91)." ".$letter; 
			 if($num==1) $st['name']=get_word_by_id(92)." ".$letter;
			 if($num==2) $st['name']=get_word_by_id(208)." ".get_3rd_place_groups($letter);
		 }
		$st['def']=0;

	return $st;
}
/*
function return_team($letter,$grp,$num){

	 $grp=g_sort($grp[$letter]);
	 if(($grp[0]['pld']==3)&&($grp[1]['pld']==3)&&($grp[2]['pld']==3)&&($grp[3]['pld']==3)){
		
		return $grp[$num]['team'];
		}
	 else { if(!$num) {return "Winner ".$letter;} 
	      else {return "Runner-up ".$letter;} }
		
}
*/

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
$sql=mysql_query($query) or die(mysql_error());
if(mysql_num_rows($sql))$played=mysql_result($sql,0,"played");

if($played){

	$goals1=mysql_result($sql,0,"g1");
	$goals2=mysql_result($sql,0,"g2");
	$team1=mysql_result($sql,0,"t1");
	$team2=mysql_result($sql,0,"t2");

	if($goals1>$goals2) return $team1;
	if($goals2>$goals1) return $team2;
}
else return 0;
}

function find_team($team_id){

if($team_id!="not played yet"){

$query="SELECT team_id FROM teams WHERE team_id='$team_id'";
$res=mysql_query($query) or die(mysql_error());
$team=mysql_result($res,0);
$team=get_team_name_link($team,0);
return $team;
}
else return "------------";
}

function get_player_name($id){

if($id){

$query="SELECT nickname,first_name FROM users WHERE id='$id'";
$res=mysql_query($query) or mysql(die);
$rez=mysql_result($res,0,"nickname");
if(!strlen($rez)) $rez=mysql_result($res,0,"first_name");
if(!strlen($rez)) $rez=get_username($id);
if(!strlen($rez)) $rez="-";
return $rez;
}

}
function get_player_full_name($id){

if($id){

$query="SELECT first_name,last_name FROM users WHERE id='$id'";
$res=mysql_query($query) or mysql(die);
$last=mysql_result($res,0,"last_name");
$rez=mysql_result($res,0,"first_name");
return $rez." ".$last;
}
}
function check_uniqueness($field,$value){

$query="SELECT * FROM players WHERE $field='$value'";
$sql=mysql_query($query) or die(mysql_error());
$num=mysql_num_rows($sql);
if ($num) return false;
else return true;
}

function display_win1($group,$num){
global $sr_l;
$total=$sr_l+1;
$t=show_team($group,$num);
echo "<tr>";
for ($i=0;$i<$total;$i++){

echo "<td>\n";
if ($i==0) {
	if($t['def']) $text=get_team_name_link($t['id'],0);
	else $text=$t['name'];
	 echo "<b>".$text."</b>";
}
echo "</td>\n"; 

}
echo "</tr>";
}

function display_win2($match_id,$stage){
global $sr_l;
$total=$sr_l+1;
echo "<tr>";
for($i==0;$i<$total;$i++){

echo "<td>";
if($i==$stage-1) echo match_info($match_id);
if($i==$stage) { 
	echo "<b>".find_team(winner($match_id)).find_score($match_id)."</b>";
	}
echo "</td>\n"; 

}
echo "</tr>";
}

function display_all_rounds(){
global $sr_l;
$total=$sr_l+1;
echo "<tr>";
for ($i=0;$i<$sr_l;$i++){

echo "<td><b>\n";
if($i!=$sr_l-1) echo "&nbsp;&nbsp;&nbsp;1/".pow(2,$sr_l-$i-1)."";
else echo get_word_by_id(93);
echo "</b></td>\n"; 

}
echo "</tr>";
echo "<tr>";
for ($i=0;$i<$total;$i++){

echo "<td><b>\n";
echo "&nbsp;";
echo "</b></td>\n"; 

}
echo "</tr>";
}
function match_info($match_id){
connect_to_eurodb();
$query="select time,date,place from matches where id='$match_id'";
$res=mysql_query($query) or die(mysql_error());
if(mysql_num_rows($res)){
	$time=mysql_result($res,0,"time");
	$date=mysql_result($res,0,"date");
	$place=mysql_result($res,0,"place");
}
$query_place="select acronym from places where place_id='$place'";
$res_place=mysql_query($query_place);
if(mysql_num_rows($res_place)) $place=mysql_result($res_place,0,'acronym');
//$place=substr($place,0,5);
$date=date("D M j",strtotime($date));
$str=$date.", ".$place."";
return $str;
}

function loser($match_id){

$query="SELECT * FROM matches WHERE id='$match_id'";
$sql=mysql_query($query) or die(mysql_error());
$played=mysql_result($sql,0,"played");

if($played){

$goals1=mysql_result($sql,0,"g1");
$goals2=mysql_result($sql,0,"g2");
$team1=mysql_result($sql,0,"t1");
$team2=mysql_result($sql,0,"t2");

if($goals1>$goals2) return $team2;
if($goals2>$goals1) return $team1;
}
else return "not played yet";
}
function find_score($match_id){
connect_to_eurodb();
$query="select g1,g2,played from matches where id='$match_id'";
$res=mysql_query($query) or die(mysql_error());
if(mysql_num_rows($res)){
	$goals1=mysql_result($res,0,"g1");
	$goals2=mysql_result($res,0,"g2");
	$played=mysql_result($res,0,"played");
}
if($played)$str="(".$goals1."-".$goals2.")";
return $str;
}

function remaining_time($match_id){

if (!$match_id) {
	$query="select time,date,place from matches where id='1'";
	$res=mysql_query($query);
	$time=mysql_result($res,0,"time");
	$date=mysql_result($res,0,"date");
	$arr=date_parse($date);
	$start=mktime(0,0,0,$arr['month'],$arr['day'],$arr['year']);
	$res=ceil(($start-tournament_time())/86400);
	return $res;
}
else	{
	connect_to_eurodb();
	$query="select time,date,place from matches where id='$match_id'";
	$res=mysql_query($query) or die(mysql_error());
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

}

function count_points($p_id){
global $coef_round;
	$res=mysql_query("SELECT * from matches WHERE played=1 ORDER BY id") or die(mysql_error());
	$num=mysql_num_rows($res);
	$pts=0;
	$total=get_total_players();	
	for($i=0;$i<$num;$i++){
		$match_id=mysql_result($res,$i,'id');
		$arr=get_match_details($match_id,$p_id);
		$round=$arr['round_id'];
		$p=$coef_round[$round];
		$coef=compute_coefficients($arr['odds1'],$arr['oddsD'],$arr['odds2'],$total);
		if(isset($arr['pick'])){
			$index=$arr['pick']-1;
//			$pts+=bet_result($arr["pick"],$arr["goals1"],$arr["goals2"])*($arr["weight"]);		
			$pts+=bet_result($arr["pick"],$arr["goals1"],$arr["goals2"])*$coef[$index]*$p;		
			update_hist_points($pts,$match_id,$p_id);	
			}
		}
	if(no_matches_left()) {
			$pts+=compute_bonus($p_id);
			update_hist_points($pts,$match_id,$p_id);	
	}
		
	return $pts;
}
function update_hist_points($pts,$m_id,$p_id){

	$res=mysql_query("SELECT id FROM history WHERE player_id='$p_id' AND match_id='$m_id'");
	$id=mysql_result($res,0);
	if(mysql_num_rows($res)) mysql_query("UPDATE history SET current_points='$pts' WHERE player_id='$p_id' and match_id='$m_id'") or die(mysql_error());	
	else mysql_query("INSERT INTO history SET player_id='$p_id',match_id='$m_id',current_points='$pts'") or die(mysql_error());
		
	

}
function no_matches_left(){
	$res=mysql_query("select id from matches where played=0");
	$num=mysql_num_rows($res);
	if(!$num) return 1;
	else return 0;
}
function count_correct($p_id){

	$res=mysql_query("SELECT * from matches WHERE played=1") or die(mysql_error());
	$num=mysql_num_rows($res);
	$pts=0;
	for($i=0;$i<$num;$i++){
		$match_id=mysql_result($res,$i,'id');
		$arr=get_match_details($match_id,$p_id);
		$pts+=bet_result($arr["pick"],$arr["goals1"],$arr["goals2"]);		
		}
	
	return $pts;
}
function starting_time($match_id){
	connect_to_eurodb();

	$upcoming=mysql_query("SELECT id,t1,t2,date,place, time FROM
			matches WHERE id=$match_id");

	$time=mysql_result($upcoming,0,"time");
	$date=mysql_result($upcoming,0,"date");
	$date=date("l, F dS",strtotime($date));
	$test=strtotime($date);
	$test4=strtotime($time);
	$seconds_that_day=$test4-mktime(0,0,0,date('m',$test4),date('d',$test4),date('Y',$test4));
	$full_time=$test+$seconds_that_day;

	return($full_time);
}
function still_time($match_id) {

	$starting_time=starting_time($match_id);
	$actual_time=tournament_time();
	if($actual_time<$starting_time) return $starting_time;
	else return 0;
}
function tournament_time(){
global $server_time_zone,$tournament_time_zone;

	$time_difference=($tournament_time_zone-$server_time_zone)*3600;
	$actual_time=time()+$time_difference;

	return($actual_time);	
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

connect_to_eurodb();

$query="select * from bets where match_id='$match_id' and pick!='0'";
$res=mysql_query($query) or die(mysql_error());
$num_betters=mysql_num_rows($res);
//echo "betters:$num_betters";
$m1=0;
$m2=0;
$mD=0;
	for ($i=0;$i<$num_betters;$i++){

		$pick=mysql_result($res,$i,'pick');

		if($pick==1) $m1++;
		if($pick==2) $mD++;
		if($pick==3) $m2++;

	}
$arr[0]=$m1;
$arr[1]=$mD;
$arr[2]=$m2;
/*
if($m1)	{
		$a=$m1;
		$b=($mD+$m2);
		$gcd1=gcd($a,$b);
		if($gcd1) $arr[0]=($a/$gcd1)."/".($b/$gcd1);
		else $arr[0]="-1";
	}
else $arr[0]="-1";
if($mD) {
		$a=$mD;
		$b=($m1+$m2);
		$gcdD=gcd($a,$b);
		if($gcdD) $arr[1]=($a/$gcdD)."/".($b/$gcdD);
		else $arr[1]="-1";
}

else $arr[1]="-1";
if($m2) {
		$a=$m2;
		$b=$m1+$mD;
		/*$gcd2=gcd($a,$b);
		if($gcd2) $arr[2]=($a/$gcd2)."/".($b/$gcd2);
		else $arr[2]="-1";*/
		 		

//else $arr[2]="-1";


	$query="UPDATE matches SET odds1='".$arr[0]."',odds2='".$arr[2]."',oddsD='".$arr[1]."' WHERE id='$match_id'";
//	echo $query;
	mysql_query($query) or die(mysql_error());
	

}
function gcd($a,$b){
	if($a&&$b){

	if($a==$b){
		$s=$a;
	}
	else{
	do
         {
            $rest=$a%$b;
            $a=$b;
            $b=$rest;
         }
         while($rest!==0);
         $s=$a;
	}
	}
else $s=1;
return($s);
}
function timestamp_access($login_id){
mysql_query("UPDATE users SET last_login=\"".date("d M Y H:i",time())."\" WHERE id='$login_id'") or die (mysql_error());
}
function display_greetings($login_id){
global $language_array,$language;
	echo "<div id='display_greetings'>\n";
	echo get_word_by_id(38)." <b>".toUpper(get_user_info($login_id,"first_name"))."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></br>\n";
	echo "<a href='rules.php'>".toUpper(get_word_by_id(87))."</a> /  <a href='help.php'>".toUpper(get_word_by_id(88))."</a>/<a href='logout.php'> ".toUpper(get_word_by_id(86))."</a> -- ";
	//echo "<br><a href='forget.php'><font size=1> click here if you are not ".get_user_info($login_id,"first_name")."</font></a>";
for($i=0;$i<sizeof($language_array);$i++) {
		if ($language!=$language_array[$i]) 	echo "   <a href='set_language.php?langi=".$language_array[$i]."'>".toUpper($language_array[$i])."</a>&nbsp;&nbsp;&nbsp;";
	}
	echo "\n</div>\n";
}
function display_total_users($login_id){
global $language;

	echo "<div class='standardfont'>\n";
	if(still_time(1)){
		echo "<br/><b>".mysql_result(mysql_query("SELECT count(*) FROM users WHERE player=1"),0)." ".get_word_by_id(84)."</b><br/>\n";
		$top_scorer=find_scorer($login_id);
		$winner=find_winner_bet($login_id);
		if($top_scorer) echo get_word_by_id(109).": ".$top_scorer;
		if($winner) echo "<br/> ".get_word_by_id(91).": ".$winner;
		if($top_scorer&&$winner) {
			echo "<p/><a href='edit_bets1.php'>".get_word_by_id(108)."</a></i><br/><br/>";
		}
		else { 
			echo "<br/><i>".get_word_by_id(151)."&nbsp;";
			echo "<a href='edit_bets1.php'>".get_word_by_id(152)."</a></i><br/><br/>";
		}
	echo "<br>Money pool - 10 € - via Paypal to vilnico@gmail.com, or in person, before the start of the tournament";
/*	switch($language) {
			case 'en': echo "This <a href='pronosafter.xls'>Excel sheet</a> can help you see who'd qualify according to your picks\n";
			break; 
			case 'fr': echo "Cette <a href='pronosafter.xls'>feuille Excel</a> peut vous aider à voir qui sera qualifié en fonction de vos paris sur les matches du premier tour.\n";
			break;
			case 'hu': echo "Ez az <a href='pronosafter.xls'>Excel táblázat</a> segíthet neked a fogadások áttekintésében.\n";
			break;
		}
*/
	}
	//echo "<br><a href='forget.php'><font size=1> click here if you are not ".get_user_info($login_id,"first_name")."</font></a>";
	echo "\n</div>\n";
}
function get_user_info($key,$field){

$us=mysql_query("select ".$field." from users where id=$key");

if(mysql_num_rows($us)) {
	$t= mysql_result($us,0,$field);
	return $t;
}

}
function display_remaining_time(){
	$remaining_time=remaining_time(0);
	if (still_time(1)>0) {
		if($remaining_time<1) echo get_word_by_id(169);
		else echo get_word_by_id(81)." ".remaining_time(0)." ".get_word_by_id(82).(remaining_time(0)==1?"":get_word_by_id(83))."!";
		
	}
}

function get_total_players(){

$tui=mysql_query("SELECT count(*) FROM users WHERE player=1");
return(mysql_result($tui,0));

}

function display_ranking($login_id){
$us=mysql_query("select * from users where id='$login_id'");
$ranking=mysql_result($us,0,'current_ranking');
$tui=mysql_query("SELECT count(*) FROM users WHERE player=1");
$num_players_total=mysql_result($tui,0);
if (!still_time(2)||is_played(1)) {
	echo "<div id='ranking_links'> My current ranking (in points): $ranking&nbsp;/&nbsp;$num_players_total\n";
		echo "<br/><a href='trends.php'>".get_word_by_id(153)."</a>";		
		echo "</div>";
	
}
}
function display_top_left($login_id){
	if(still_time(1)) ;
	//display_remaining_time();
	else  {
		if(!still_time(2)||is_played(1)) display_ranking($login_id);

}
}
function get_match_details($match_id,$login_id){
	
	$upcoming=mysql_query("SELECT id,t1,t2,g1,g2,date,place,descr,odds1,odds2,oddsD,time,played,no_tie,round_id FROM matches WHERE id='$match_id' ORDER BY id ASC") or die(mysql_error());
	if($upcoming) {
		$team1=utf8_encode(mysql_result($upcoming,0,"t1"));
		$rez1=mysql_query("SELECT team_name,code FROM teams WHERE
				$team1=teams.team_id");
		if(mysql_num_rows($rez1)){
			$arr["team1"]=get_team_name($team1);
			$arr["code1"]=mysql_result($rez1,0,'code');
		}

		$temp=mysql_query("SELECT pick,weight FROM bets WHERE match_id='$match_id'
				AND player_id='$login_id'") or die(mysql_error());
		$cond=mysql_num_rows($temp);
		if($cond){
			//$arr["goals_team1"]=mysql_result($temp,0,"bgt1");
			//$arr["goals_team2"]=mysql_result($temp,0,"bgt2");
			$arr["pick"]=mysql_result($temp,0,"pick");
	// token method: the weight is what the user wages
	//		$arr["weight"]=mysql_result($temp,0,"weight");
	// odds method: the weight is the odds.
		}

		$team2=mysql_result($upcoming,0,"t2");
		$rez2=mysql_query("SELECT team_name,code FROM teams WHERE
				$team2=teams.team_id");
		if(mysql_num_rows($rez2)){
			$arr["team2"]=get_team_name($team2);
			$arr["code2"]=mysql_result($rez2,0,'code');
		}
		
		$arr["t_id1"]=$team1;
		$arr["t_id2"]=$team2;
		$arr["goals1"]=mysql_result($upcoming,0,"g1");
		$arr["goals2"]=mysql_result($upcoming,0,"g2");
		//$odds=odds($match_id);
		$arr["odds1"]=mysql_result($upcoming,0,"odds1");
		$arr["odds2"]=mysql_result($upcoming,0,"odds2");
		$arr["oddsD"]=mysql_result($upcoming,0,"oddsD");
	//get weight for the odds method	
		if(isset($arr['pick']) )$arr["weight"]=get_match_odds($arr['pick'],$arr['odds1'],$arr['oddsD'],$arr['odds2']);
		
		$arr["time"]=mysql_result($upcoming,0,"time");
		$arr["played"]=mysql_result($upcoming,0,"played");
		$round_id=mysql_result($upcoming,0,"round_id");
		if($round_id) $arr["descr"]=mysql_result(mysql_query("SELECT descr FROM rounds WHERE round_id='$round_id'"),0,"descr");
		else $arr["descr"]='S1.';
		$arr['round_id']=$round_id;
		$arr["summary"]=mysql_result($upcoming,0,"descr");
		$arr["no_tie"]=mysql_result($upcoming,0,"no_tie");
		$arr["date"]=mysql_result($upcoming,0,"date");
		$date=date("l, F dS",strtotime($arr["date"]));
		$place_id=mysql_result($upcoming,0,"place");
		$rezp=mysql_query("SELECT * from places WHERE place_id='$place_id'") or die(mysql_error());
		$arr["place"]=mysql_result($rezp,0,'city');
		$arr["place_id"]=mysql_result($rezp,0,'place_id');
		$test=strtotime($arr["date"]);
		$test4=strtotime($arr["time"]);	
		$seconds_that_day=$test4-mktime(0,0,0,date('m',$test4),date('d',$test4),date('Y',$test4));
		$arr["full_time"]=$test+$seconds_that_day;
		$arr["cond"]=$cond;
		$arr['group']=substr($arr["summary"],-1);
		$arr['m_id']=$match_id;
}
return($arr);
}
function get_match_odds($pick,$odds1,$oddsD,$odds2){

	switch ($pick){
		case 1: 
			if(($oddsD+$odds2)!=0) return ($odds1/($oddsD+$odds2));
			else return 1;
			break;
		case 2:
			if(($odds1+$odds2)!=0) return ($oddsD/($odds1+$odds2));
			else return 1;
			break;
		case 3:
			if(($oddsD+$odds1)!=0) return ($odds2/($odds1+$oddsD));
			else return 1;
			break;
		}
}



function get_match_teams($match_id){
	
	$upcoming=mysql_query("SELECT id,t1,t2,g1,g2,played FROM matches WHERE id='$match_id' ORDER BY id ASC") or die(mysql_error());
	$arr['team1']=mysql_result($upcoming,0,'t1');
	$arr['team2']=mysql_result($upcoming,0,'t2');
	$arr['goals1']=mysql_result($upcoming,0,"g1");
	$arr['goals2']=mysql_result($upcoming,0,"g2");
	$arr['played']=mysql_result($upcoming,0,"played");

	return($arr);
}

function make_final_round_chart($type) {

switch($type){

case 'euro':

echo display_all_rounds();
echo display_win1('A',0);
echo display_win2(25,1); 		//2
echo display_win1('B',1); 		//3

echo display_win2(29,2); 		//4

echo display_win1('C',0);		//9
echo display_win2(27,1);		//10
echo display_win1('D',1);		//11

echo display_win2(31,3);		//8

echo display_win1('B',0);		//5
echo display_win2(26,1);		//6
echo display_win1('A',1);		//7


echo display_win2(30,2);		//12

echo display_win1('D',0);		//13
echo display_win2(28,1);		//14
echo display_win1('C',1);		//15

//echo display_win2(32,3);		//8
break;

case 'worldcup':

// World cup
echo display_all_rounds();
echo display_win1('A',0);
echo display_win2(49,1); 		//2
echo display_win1('B',1); 		//3

echo display_win2(58,2); 		//4

echo display_win1('C',0);		//5
echo display_win2(50,1);		//6
echo display_win1('D',1);		//7

echo display_win2(61,3);		//8

echo display_win1('E',0);		//9
echo display_win2(53,1);		//10
echo display_win1('F',1);		//11

echo display_win2(57,2);		//12

echo display_win1('G',0);		//13
echo display_win2(54,1);		//14
echo display_win1('H',1);		//15

echo display_win2(64,4);		//8


echo display_win1('B',0);
echo display_win2(52,1); 		//2
echo display_win1('A',1); 		//3

echo display_win2(59,2); 		//4

echo display_win1('D',0);		//5
echo display_win2(51,1);		//6
echo display_win1('C',1);		//7

echo display_win2(62,3);		//8

echo display_win1('F',0);		//9
echo display_win2(55,1);		//10
echo display_win1('E',1);		//11

echo display_win2(60,2);		//12

echo display_win1('H',0);		//13
echo display_win2(56,1);		//14
echo display_win1('G',1);		//15
break;


case 'big_euro':

echo display_all_rounds();
echo display_win1('A',1);
echo display_win2(37,1); 		//2
echo display_win1('C',1); 		//3

echo display_win2(45,2); 		//4

echo display_win1('D',0);		//9
echo display_win2(39,1);		//10
echo display_win1('D',2);		//11

echo display_win2(49,3);		//8

echo display_win1('B',0);		//5
echo display_win2(38,1);		//6
echo display_win1('B',2);		//7


echo display_win2(46,2);		//12

echo display_win1('F',0);		//13
echo display_win2(42,1);		//14
echo display_win1('E',1);		//15

echo display_win2(51,4);		//12

echo display_win1('C',0);		//13
echo display_win2(41,1);		//14
echo display_win1('C',2);		//15

echo display_win2(47,2);		//12

echo display_win1('E',0);		//13
echo display_win2(43,1);		//14
echo display_win1('D',1);		//15

echo display_win2(50,3);		//12

echo display_win1('A',0);		//13
echo display_win2(40,1);		//14
echo display_win1('A',2);		//15

echo display_win2(48,2);		//12

echo display_win1('B',1);		//13
echo display_win2(44,1);		//14
echo display_win1('F',1);		//15
//echo display_win2(32,3);		//8
break;

}
	
}
function is_bet($match_id,$login_id) {
$res=mysql_query("SELECT * FROM bets WHERE player_id='$login_id' AND match_id='$match_id'") or die (mysql_error());
$num=mysql_num_rows($res);
if($num) return 1;
else return 0;}

function fscore($val){
if(empty($val)) $val="0";
return $val;
}
function set_res($match_id,$g1,$g2){
	if($g1>$g2) $res=1;
	if($g2>$g1) $res=2;
	if($g2==$g1) $res=0;

	$wri=mysql_query("UPDATE matches SET (g1,g2,res) VALUES ($g1,$g2,$res)") or die(mysql_error());
}
function display_weight($weight,$rem_pts,$unbet,$last,$tot_matches){
	if(!$weight) $weight=0;
	echo "<div class='boldf' style='display:inline;'>Pts</div>";
	echo "<div id='weights' class='weight'>\n";
	for($i=1;$i<6;$i++){
		echo "<input type='radio' name='weight' value='$i' ".(($i==$weight)||(!$weight&&$i==1)?"checked":"")." onClick=\"javascript:comp_bet('".$rem_pts."','".$weight."','".$unbet."','".$last."','".$tot_matches."')\">$i&nbsp;";	
	
	}	
	echo "</div>\n";
	
}
function display_pick($pick,$arr_pick,$no_tie){

	if(!$pick) $pick=2;	
	echo "<div class='pick'>\n";
	for($i=1;$i<4;$i++){
		if(!(($i==2)&&$no_tie)) echo "<input type='radio' name='pick' value='$i' ".($i==$pick?"checked":"").">".$arr_pick[$i]."&nbsp;&nbsp;\n";	
	}	
	echo "</div>\n";
	
}
function f_pick($pick,$t1,$t2){
	if($pick==1) return $t1;
	if($pick==2) return get_word_by_id(103);
	if($pick==3) return $t2;
}
function bet_result($pick,$g1,$g2) {

	if(($g1>$g2)&&($pick==1)) return 1;
	if(($g2>$g1)&&($pick==3)) return 1;
	if(($g1==$g2)&&($pick==2)) return 1;

	return 0;

}
function f_bet_result($result){
	return "<img src='img/".($result?"checkmark3.gif":"b_drop.png")."' height=12px />\n";
}
function display_pick_row($pick,$arr_pick,$match_id,$class,$no_tie){

	echo "<div class='$class'>\n";
	for($i=1;$i<4;$i++){
		if (!(($i==2)&&$no_tie))echo "<input type='radio' id='pick".$match_id."' name='pick".$match_id."' value='$i' ".($i==$pick?"checked":"")." onClick=\"check_row('".$match_id."')\">".$arr_pick[$i]."";	
	}	
	echo "</div>\n";
	
}
function display_weight_row($weight,$match_id,$class){
	echo "<div class='$class'>\n";
	for($i=1;$i<6;$i++){
		echo "<input type='radio' id='weight".$match_id."' name='weight".$match_id."' value='$i' ".($i==$weight?"checked":"")." onClick=\"comp_total('weight".$match_id."')\">$i";	
	
	}	
	echo "</div>\n";
	
}
function drop_down_euro_winner($team){
	$res=mysql_query("SELECT team_id,team_name from teams ORDER by team_name") or die(mysql_error());
	$num=mysql_num_rows($res);

	echo "<select name='winning_team'>\n";
	for ($i=0;$i<$num;$i++){
		$team_id=mysql_result($res,$i,'team_id');
		$team_name=mysql_result($res,$i,'team_name');
		echo "<option  value='$team_id' ".($team_id==$team?"selected":"").">".get_team_name($team_id)."</option>\n";
	}
	echo "</select>\n";
}
function display_score_row($match_id,$class,$g1,$g2){

	echo "<div class='$class'>\n";
	for($i=0;$i<2;$i++){
		echo "<div id='score$i' style='display:inline;width:40px;'><input style='display:inline;width:20px;' type='text' id='score".$i.$match_id."' name='score".$i.$match_id."' value='".($i==0?$g1:$g2)."' size=1></div>\n";	
	}	
	echo "</div>\n";
	
}
function display_checkbox($match_id,$played){

		echo "<input type='checkbox' name='scorec".$match_id."' ".($played?"checked":"")." />\n";	
	
}
function get_bet_details($res,$i){
	$arrb["pick"]=mysql_result($res,$i,'pick');
	$arrb["weight"]=mysql_result($res,$i,'weight');
	$arrb["match_id"]=mysql_result($res,$i,'match_id');
	$arrb["bet_id"]=mysql_result($res,$i,'bet_id');
	return $arrb;
	}
function is_admin($id){
	$res=mysql_query("SELECT id FROM users WHERE admin='1' AND id='$id'") or die(mysql_error());
	return mysql_num_rows($res);
}
function clear_pick_weight($match_id,$type,$text){
	echo "<input type='button' value='$text'
	onclick=\"clearCheckbox('$type',$match_id)\"/>";
}
function update_matches_2ndr($team1,$team2,$match_id){

  
   if($team1){
	   $query="UPDATE matches SET t1='$team1' WHERE id='$match_id'";
  //echo "$query 2 ";
   	   $res=mysql_query($query) or die(mysql_error());
	   }

   if($team2){
	   $query="UPDATE matches SET t2='$team2' WHERE id='$match_id'";
	   //echo "$query 3 ";
	   $res=mysql_query($query) or die(mysql_error());
   }

}

function init_team_data(){
	global $fr_m;
	$query="UPDATE teams SET winner=0,m_played=0,current_pos=0,W=0,D=0,L=0,gf=0,ga=0,pts=0 ";;
//	echo $query.'<br/>';
	mysql_query($query) or die(mysql_error());
	$query="UPDATE groups SET over=0 ";;
//	echo $query.'<br/>';
	mysql_query($query) or die(mysql_error());
	if($fr_m) {
		$query="UPDATE matches SET t1=0,t2=0 WHERE id>'$fr_m' ";
//		echo $query.'<br/>';
		mysql_query($query) or die(mysql_error());
	}	
		
}
function reset_matches_played(){
	$query="UPDATE matches SET played=0 ";
//	echo $query.'<br/>';
	mysql_query($query) or die(mysql_error());
	$query="UPDATE users SET current_points=0,current_correct=0,current_incorrect=0,current_ranking=0 WHERE player=1";
//	echo $query.'<br/>';
	mysql_query($query) or die(mysql_error());
}
function reset_bets_and_users_rankings(){
	$query="DELETE from bets ";
//	echo $query.'<br/>';
	mysql_query($query) or die(mysql_error());
	$query="UPDATE users SET current_points=0,current_correct=0,current_incorrect=0,bet_money=0,current_ranking=0,winner=0,top_scorer=0";
//	echo $query.'<br/>';
	mysql_query($query) or die(mysql_error());
}
function update_team_data($id,$gf,$ga,$pts_v,$pts_d){

	
	if(!processed($id)){
		$r=result_match($gf,$ga,$pts_v,$pts_d);
		$query="UPDATE teams SET ".$r['rm']."=".$r['rm']."+1, gf=gf+".$gf.",ga=ga+".$ga."".($r['rp']?",pts=pts+".$r["rp"]:"").",m_played=m_played+1 WHERE team_id='$id'";
	//	echo $query.'<br/>';
		mysql_query($query) or die(mysql_error());
	}		
}
function processed($m_id){
	$query=mysql_query("SELECT processed=processed+1 FROM matches WHERE id='$m_id'") or die(mysql_error());
	return(mysql_result($query,0));
}
function set_processed($m_id){
	mysql_query("UPDATE matches SET processed='1' WHERE id='$m_id'") or die(mysql_error());
}
function result_match($gf,$ga,$pts_v,$pts_d){
	if($gf>$ga) {
		$arr["rm"]= "W";
		$arr["rp"]=$pts_v;
	}
	if($ga>$gf) {
		$arr["rm"]= "L";
		$arr["rp"]="0";
	}
	if($ga==$gf) {
		$arr["rm"]= "D";
		$arr["rp"]=$pts_d;
	}
return $arr;
}

function display_all_groups($letter){
echo "<table width='98%' cellspacing='10' cellpadding='' align='center'>";

?>

<table width="98%" cellspacing="10" cellpadding="" align="center">

<?php
echo "<tr>";

for ($i=0;$i<sizeof($letter);$i++){
if(floor(($i+1)/2)==($i+1)/2) $t=1;
else $t=0;
$group_name=$letter[$i];

echo "<td> <b>".get_word_by_id(90)." ".$group_name."</b><br><br>\n";
echo "<div id='team_ranking'>";
echo "<table cellspacing=0px>\n

        <tr>
        <td width=10><b></b></td>\n
	<td width=150 ><b> </b></td>\n
        <td width=10><b>".get_word_by_id(136)."</b></td>\n
        <td width=8><b>".get_word_by_id(133)."&nbsp;</b></td>\n
        <td width=8><b>".get_word_by_id(134)."&nbsp;</b></td>\n
        <td width=8><b>".get_word_by_id(135)."&nbsp;</b></td>\n
        <td width=10><b>".get_word_by_id(137)."</b></td>\n
        <td width=10><b>".get_word_by_id(138)."</b></td>\n
        <td width=10><b>".get_word_by_id(139)."</b></td>\n
        <td width=10><b>".get_word_by_id(140)."</b></td>\n
        </tr>\n";
	$arr_teams=get_teams($group_name);
	for($j=0;$j<$arr_teams["count"];$j++){
		echo "
		<tr><td><a href=\"teams.php?id=".$arr_teams[$j]['team_id']."\" class='no_dec'><img src='img/".$arr_teams[$j]['code'].".png' height='20px' alt='".$arr_teams[$j]['code']."' /></a></td>";
		echo "<td width=100 ";
		if(group_over($group_name)&&$j<2) echo "class='boldf'";
		echo ">&nbsp;&nbsp;<a href='team_sheet.php?id=".$arr_teams[$j]['team_id']."'>".get_team_name($arr_teams[$j]['team_id'])."</a></td>\n";
		echo "<td width=10>".$arr_teams[$j]['pld']."</td>\n
		<td width=10>".$arr_teams[$j]['W']."</td>\n
		<td width=10>".$arr_teams[$j]['D']."</td>\n
		<td width=10>".$arr_teams[$j]['L']."</td>\n
		<td width=10>".$arr_teams[$j]['gf']."</td>\n
		<td width=10>".$arr_teams[$j]['ga']."</td>\n
		<td width=10>".$arr_teams[$j]['gd']."</td>\n
		<td width=10>".$arr_teams[$j]['pts']."</td>\n
		</tr>\n";
		
	}
	echo "</table></div></td>";
//	if($t==1) echo "</tr><tr>";
	echo "</tr><tr>";
}
?>
</tr>
</table>
<br>
</div>
<?php
	}

function display_groups_links(){
global $groups;
	echo "<div class='display_groups'>\n";
	for($i=0;$i<sizeof($groups);$i++){
			echo "<a href=''>Group ".$groups[$i]."</a>&nbsp;\n";
	}
	echo "</div>";
}

function get_teams($group){
	$q=mysql_query("SELECT * FROM teams WHERE group_name='".$group."' ORDER by current_pos") or die(mysql_error());
	$ro=mysql_num_rows($q);
	
	for($i=0;$i<$ro;$i++){
		$arr_team[$i]['team']=mysql_result($q,$i,'team_name');
		$arr_team[$i]['pld']=mysql_result($q,$i,'m_played');
		$arr_team[$i]['W']=mysql_result($q,$i,'W');
		$arr_team[$i]['D']=mysql_result($q,$i,'D');
		$arr_team[$i]['L']=mysql_result($q,$i,'L');
		$arr_team[$i]['gf']=mysql_result($q,$i,'gf');
		$arr_team[$i]['ga']=mysql_result($q,$i,'ga');
		$arr_team[$i]['gd']=$arr_team[$i]['gf']-$arr_team[$i]['ga'];
		$arr_team[$i]['pts']=mysql_result($q,$i,'pts');
		$arr_team[$i]['code']=mysql_result($q,$i,'code');
		$arr_team[$i]['team_id']=mysql_result($q,$i,'team_id');	
	}
	$arr_team["count"]=$ro;	
return $arr_team;
}
function display_odds($o1,$oD,$o2,$match_id){
	
			$a1=$o2+$oD;
			$aD=$o1+$o2;
			$a2=$oD+$o1;
		
			$total=get_total_players();
		
		
			if($o1)	$d1=round($total/$o1,2);
			else $d1='n/a';
			if($oD) $dD=round($total/$oD,2);
			else $dD='n/a';
			if($o2) $d2=round($total/$o2,2);	
			else $d2='n/a';

			$str1='total players';
			$str2='players who picked this result';
			$t1=$str1." ($total)/".$str2." ($o1)";
			$tD=$str1." ($total)/".$str2." ($oD)";
			$t2=$str1." ($total)/".$str2." ($o2)";
	

			 return("<a href='odds_all.php?match_id=$match_id' >".get_word_by_id(98)."</a>: <a href='odds_details.php?type=v1&match_id=$match_id' title='$t1'>".$d1."</a> ".(get_phase($match_id)?"":"- <a href='odds_details.php?type=draw&match_id=$match_id' title='$tD'>".$dD."</a>")." - <a href='odds_details.php?type=v2&match_id=$match_id' title='$t2'>".$d2."</a>");

}
function compute_coefficients($o1,$oD,$o2,$total){
		
//			$a1=$o2+$oD;
//			$aD=$o1+$o2;
//			$a2=$oD+$o1;
			
				
			if($o1) $r1=$total/$o1;
			else $r1=0;

			if($oD) $rD=$total/$oD;
			else $rD=0;

			if($o2) $r2=$total/$o2;
			else $r2=0;			
			$result=array($r1,$rD,$r2);

			return($result);
}
function find_round($m){
	$res=mysql_query("SELECT round_id FROM matches WHERE id='$m'") or die(mysql_error());
	$round_id=mysql_result($res,0);
	if($round_id) return log($round_id)/log(2);	
}
function next_match($m,$ro){
	global $fr_m,$sr_l;
	
	$t=$fr_m; 
	for($i=$sr_l-1;$i>$ro;$i--){
		$t+=pow(2,$i);
	}
	$ind=floor(($m-$t-1)/2);
	$nt=$t+pow(2,$i)+1;
	
	return ($nt+$ind);
}
function get_current_phase(){
	$query=mysql_query("SELECT round_id FROM matches WHERE played=0 ORDER by id") or die(mysql_error());
	return mysql_result($query,0);
}
function format_phase($m_id,$phase,$rank,$team,$code,$disp){
	//is being used by the display_matches function
	//origin is either of the format A1:B2 or 25:26 which means winner match 25 / winner match 26
	global $third_place_match,$sr_l;
	$query=mysql_query("SELECT origin FROM matches WHERE id='$m_id'");
	$or=mysql_result($query,0);
	$ind=$rank-1;
	$show['defined']=1;
	if($phase==pow(2,$sr_l-1)){
		$str1=substr($or,3*$ind,1);
		$nat1=substr($or,1+3*$ind,1);
		$winn1="1st";
		$runn1="2nd";
		$third="3rd";

		if(group_over($str1)) {
			$show['str']=find_team(get_team($str1,$nat1));
			$show['defined']=1;
			if($disp) {
				if(get_code($str1,$nat1))$show['code']=get_code($str1,$nat1);
			}
		}
		else {
			if($nat1==1) $show['str']=$winn1." $str1";	
			if($nat1==2) $show['str']=$runn1." $str1";	
			if($nat1==3) $show['str']=$third." ".get_3rd_place_groups($str1);
			$show['defined']=0;
		}	
		return $show; 
	}
	if($phase&&($phase<pow(2,$sr_l-1))){
		//get match number
		$str1=substr($or,3*$ind,2);
		if($m_id==$third_place_match) $origins="L";
		else $origins="W";
		$winn1=$origins.$str1;
		//if match is played, show actual winner
		if(is_played($str1)) {
		//if match is 3rd place match, take the loser of the match, else take the winner
			if($m_id==$third_place_match) $winn1=loser($str1);
			else $winn1=winner($str1);
		//get the flag code
			$code=mysql_result(mysql_query("SELECT code FROM teams WHERE team_id='$winn1'"),0);
			$show['str']=get_team_name_link($winn1,0);
			if($disp) $show['code']=$code;
		}
		else {
			$show['str']=$winn1;
			$show['code']='';
			$show['defined']=0;
		}
		return $show;
	}
	if(!$phase){
		$show['str']=$team;
		$show['code']=$code;
		return $show;	
	}
}
function submit_winners($m_id,$phase){
	//is being used by the display_matches function
	//is being used by the submit_matches page
	//origin is either of the format A1:B2 or 25:26 which means winner match 25 / winner match 26
	global $sr_l;
	$query=mysql_query("SELECT origin FROM matches WHERE id='$m_id'");
	$or=mysql_result($query,0);
	if($phase==pow(2,$sr_l-1)){
		$str1=substr($or,0,1);
		$str2=substr($or,3,1);
		$nat1=substr($or,1,1);
		$nat2=substr($or,4,1);
	//	echo "str1:".$str1."str2".$str2."nat1".$nat1."nat2".$nat2;
		$show['str1']=get_team($str1,$nat1);
		$show['str2']=get_team($str2,$nat2);
		return $show; 
	}
	if($phase&&($phase<pow(2,$sr_l-1))){
		//get match number
		$str1=substr($or,0,2);
		$str2=substr($or,3,2);
		if($winn1) $code=mysql_result(mysql_query("SELECT code FROM teams WHERE team_id='$winn1'"),0);
		$show['str1']=winner($str1);
		$show['str2']=winner($str2);
		return $show;
	}
}
function third_place($phase,$m,$next_phase){

if (isset($third_place_match)){				
		if($phase==2){
								$teams=submit_losers($m,$next_phase);
								update_matches_2ndr($teams['str1'],$teams['str2'],$m);
								$m+=1;
							}

	}
		return($m);
}

function submit_losers($m_id,$phase){
	//is being used by the display_matches function
	//is being used by the submit_matches page
	//currently used for the 3rd place match 
	//origin is either of the format A1:B2 or 25:26 which means winner match 25 / winner match 26
	global $sr_l;
	$query=mysql_query("SELECT origin FROM matches WHERE id='$m_id'");
	$or=mysql_result($query,0);
	if($phase==pow(2,$sr_l-1)){
		$str1=substr($or,0,1);
		$str2=substr($or,3,1);
		$nat1=substr($or,1,1);
		$nat2=substr($or,4,1);
	//	echo "str1:".$str1."str2".$str2."nat1".$nat1."nat2".$nat2;
		$show['str1']=get_team($str1,$nat1);
		$show['str2']=get_team($str2,$nat2);
		return $show; 
	}
	if($phase&&($phase<pow(2,$sr_l-1))){
		//get match number
		$str1=substr($or,0,2);
		$str2=substr($or,3,2);
		if($winn1) $code=mysql_result(mysql_query("SELECT code FROM teams WHERE team_id='$winn1'"),0);
		$show['str1']=loser($str1);
		$show['str2']=loser($str2);
		return $show;
	}
}
function display_matches($m_id,$phase,$rank,$team,$code){
	global $sr_l;
	
	$arr=format_phase($m_id,$phase,$rank,$team,$code,1);
	if($rank==2) $str=($arr['defined']?"<img src='img/".$arr['code'].".png' class='image_pad'>":"").$arr['str'];
	if($rank==1) $str=$arr['str'].($arr['defined']?"<img src='img/".$arr['code'].".png' class='image_pad'>":"");

	return $str;
}
function get_phase($m){
	$res=mysql_query("SELECT round_id FROM matches WHERE id='$m'") or die(mysql_error());
	$phase= mysql_result($res,0,'round_id') ;
	return $phase;
}
function get_group($m){
	$res=mysql_query("SELECT group_name FROM teams WHERE team_id='$m'") or die(mysql_error());
	$letter= mysql_result($res,0) ;
	return $letter;
}
function is_played($m){
	return mysql_result(mysql_query("SELECT played FROM matches WHERE id='$m'"),0);
}
function is_being_played($m){
    if(!still_time($m)&&!is_played($m)) $s=1;
    else $s=0;
    return $s;
}
function get_team_name($id){
	if($id) {
		$res=mysql_query("SELECT trans FROM teams WHERE team_id='$id'");
		$res2=get_team_translation(mysql_result($res,0,'trans'));
		return $res2;
	}
}
function get_team_name_link($id,$class_type){
	if($class_type==0) $string="team_display_normal";
	if($class_type==1) $string="team_display_big";
	if($class_type==2) $string="team_display_small";
	if($class_type==3) $string="team_display_normal_nobold";
	if($class_type==4) $string="team_display_medium";
	$str= "<a href='team_sheet.php?id=".$id."' class='".$string."'>".get_team_name($id)."</a>";
	return($str);
}
function get_team_name_link_nobold($id){
	$str= "<a href='team_sheet.php?id=".$id."' style='font:11px lucida,sans-serif;text-decoration:none;color:black;'>".get_team_name($id)."</a>";
	return($str);
}
function get_team_translation($trans){
global $language;
	$lang='word_'.$language;
	$name='';
	if($language) {
		$query="SELECT ".$lang." FROM language where id='$trans'";
//		echo $query;
		$res=mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($res)) $name= mysql_result($res,0,0); 
		else $name='translation error';
	}
	return ($name);
}
function get_team($group,$pos){
		
	if(($pos==1)||($pos==2)) {
		$res=mysql_query("SELECT team_id FROM teams WHERE group_name='$group' AND current_pos='$pos'") or die(mysql_error());
		$team=mysql_result($res,0);
	}
	if($pos==3) $team=find_best_third($group);
	return $team;
}
function find_best_third($group){
	global $big_euro_3rd_place;
	$temp=array("A"=>0,"B"=>1,"C"=>2,"D"=>3);

	//collect teams in 3rd place
	$result=mysql_query("SELECT group_name FROM teams WHERE current_pos=3 ORDER by pts DESC,(gf-ga) DESC,gf DESC") or die(mysql_error);
	while($row=mysql_fetch_array($result,MYSQL_NUM)){
		if(strlen($combo)<4) $combo=$combo.$row[0];
	}
   	//create the string like 'BDCF' that determines the groups which contain the best 3rds
	$combo=sort_string($combo); //sort the groups in alphabetical order, like BCDF
	//print_r($combo);
	$ind=$big_euro_3rd_place[$combo][$temp[$group]]; // find the group that contains the 3rd that is qualified
	$team=mysql_query("SELECT team_id FROM teams WHERE current_pos=3 and group_name='$ind'") or die(mysql_error);
	$team_id=mysql_result($team,0);
	return $team_id;

	//
}
function sort_string($string){
	$stringParts = str_split($string);
	sort($stringParts);
	return implode('', $stringParts); // abc

}
function get_code($group,$pos){
		
	$res=mysql_query("SELECT code FROM teams WHERE group_name='$group' AND current_pos='$pos'") or die(mysql_error());
	return mysql_result($res,0,'code');
}
function group_over($group){
	$res=mysql_query("SELECT over FROM groups WHERE letter='$group'");
	if(mysql_num_rows($res)) return mysql_result($res,0);
}
//function last_match(){

//	return mysql_result(mysql_query("SELECT id FROM matches WHERE id='$last_match'"),0);
//}
function set_winner($team){
	mysql_query("UPDATE teams SET winner=1 WHERE team_id='$team'") or die(mysql_error());
}

function get_picked_winner($login_id){
	$query="SELECT winner FROM users WHERE id='$login_id'";
	$res=mysql_query($query) or die(mysql_error());

	return mysql_result($res,0);
}

function get_remaining_weights($login_id,$totalw,$m_id){
	
	global $max_points_per_match;
	if(!$m_id){
		$res=mysql_query("SELECT sum(bets.weight) FROM bets,matches WHERE bets.player_id='$login_id' AND matches.id=bets.match_id AND matches.played=1") or die(mysql_error());
		$rem_w=mysql_result($res,0);
	
		$res2=mysql_query("SELECT count(*) FROM matches where played=0");
		$tp=mysql_result($res2,0);
	
		$mp=$max_points_per_match*$tp;	
		$rem=min($mp,$totalw-$rem_w);
//		return ($totalw-$rem_w);
		return($rem);
		}
	else {
		$res=mysql_query("SELECT sum(bets.weight) FROM bets,matches WHERE bets.player_id='$login_id' AND matches.id=bets.match_id") or die(mysql_error());
		$rem_w=mysql_result($res,0);
		
		$tm=mysql_result(mysql_query("SELECT count(*) FROM matches"),0);
		//return($totalw);
		$rem_1=num_unbet_matches($login_id,$tm);	
		return($totalw-$rem_w-$rem_1);	
	}
}
function get_weight($login_id,$m_id){
	$res=mysql_query("SELECT weight FROM bets where player_id='$login_id' AND match_id='$m_id'");
	if(mysql_num_rows($res)) $weight=mysql_result($res,0);
	else $weight=0;
	return $weight;
}
function check_bets($p_id){
	
	$res=mysql_query("SELECT id FROM matches WHERE played=1");
	$num_played=mysql_num_rows($res);
	for($i=0;$i<$num_played;$i++){
		$m_id=mysql_result($res,$i,'id');
		$weight=get_weight($p_id,$m_id);
		if(!$weight) mysql_query("INSERT INTO bets SET player_id='$p_id',match_id='$m_id',weight='1',pick='0'");
	}
}
function matches_played(){

	$res=mysql_query("SELECT count(*) FROM matches WHERE played=1");
	if($res) return mysql_result($res,0);
	else return 0;
}
function num_unbet_matches($login_id,$tot){
		$res1=mysql_query("SELECT count(*) FROM matches,bets WHERE bets.player_id='$login_id' AND matches.id=bets.match_id") or die(mysql_error());
		$bet=mysql_result($res1,0);
		$rem_1=$tot-$bet;
		return $rem_1;
}
function is_new($login_id,$match_id){
	$res=mysql_query("SELECT bet_id FROM bets WHERE match_id='$match_id' AND player_id='$login_id'");
        if(mysql_num_rows($res)) return 0;
	else return 1;	
}
function display_drop_down_scorer($top){
	
	echo "<table><tr><td>";
	echo "<font color='red'>Top scorer:</font>    team";
	echo "</td>\n";
	echo "<td width='150px'>";
	//check whether there is a top scorer
	if ($top) {
		//look for his team_id
		$te=mysql_query("SELECT * FROM players WHERE id='$top'");
		$cts=mysql_result($te,0,'id');
		$team_ts=mysql_result($te,0,'team_id');
	}
	echo "<select name='top_sc' size='1' onChange='redirect(this.options.selectedIndex)'>";
	 
	$query="SELECT * FROM teams ORDER BY team_name";
	$res=mysql_query($query);
	$num_teams=mysql_num_rows($res);
	//echo "num:$num_teams;";
	//echo "fr:$first_code";

	for($i=0;$i<$num_teams;$i++){
		$team_name[$i]=mysql_result($res,$i,'team_name');
		$team_id[$i]=mysql_result($res,$i,'team_id');
		echo "<option ".($team_ts==$team_id[$i]?'selected':'')." value=1>".(get_team_name($team_id[$i]))."</option>\n";
	}

	echo "</select>";
	echo "</td>\n<td>&nbsp;Name:&nbsp;</td><td width='150px'>\n";
	echo "<select name='stage2' size=1>";

	//if there is a top scorer, display it

	if ($top) $first_id=$team_ts;
	else $first_id=mysql_result($res,0,'id');


	$query="SELECT * FROM players WHERE team_id='$first_id' ORDER BY substring_index(TRIM(name), ' ', -1) ";
	$resa=mysql_query($query);
	$num_players=mysql_num_rows($resa);


	for($i=0;$i<$num_players;$i++){
		$player_name=mysql_result($resa,$i,'name');
		$player_id=mysql_result($resa,$i,'id');
		echo "<option ".($player_id==$top?"selected":"")." value='$player_id'>".($player_name)."</option>\n";
	}
	echo "\n</select>\n";
	echo "</td></tr></table>\n";
}

function find_scorer($login_id){
	$res=mysql_query("SELECT top_scorer FROM users WHERE id='$login_id'");
	$top_id=mysql_result($res,0);
	$res2=mysql_query("SELECT name FROM players WHERE id='$top_id'");
	if(mysql_num_rows($res2)) return mysql_result($res2,0);
	else return 0;
}
function find_winner_bet($login_id){
	$res=mysql_query("SELECT winner FROM users WHERE id='$login_id'");
	$top_id=mysql_result($res,0);
	$res2=mysql_query("SELECT team_name FROM teams WHERE team_id='$top_id'");
	if(mysql_num_rows($res2)) return mysql_result($res2,0);
	else return 0;
}
function check_forum(){
	if($_SERVER['SCRIPT_NAME']=='/euro2008/forum.php'){
		echo "<ul class='menu_link'>\n";
		echo "<li>All threads\n";
		echo "</li>\n";
		echo "</ul>\n";
	}

}
function make_forum_link($arr,$text,$selected){

	$res=count(array_intersect($arr,$selected));
//	print_r($res);
	if($res==count($arr)) $class="class='boldf'";
	else $class="";
	foreach($arr as $key=>$val){
		$str=$str.$key."=".$val."&";
	}

	echo "<a href='forum.php?$str' $class>$text</a>\n";

}
function admin_links($login_id){
	if(is_admin($login_id)) {
		echo "<li><a href='update_matches.php' style='color:gray;'>Enter score</a></li>";
		echo "<li><a href='update_points.php' style='color:gray;'>re-count points</a></li>";
		echo "<li><a href='email_list.php' style='color:gray;'>email list</a></li>";

		echo "<li><a href='create_user.php' style='color:gray;'>Create user</a></li>";
		echo "<li><a href='adlist_users.php' style='color:gray;'>List users</a></li>";
//		echo "<li><a href='adlist_players.php' style='color:gray;'>List players</a></li>";
		echo "<li><a href='enter_player_adm.php' style='color:gray;'>Add scorer</a></li>";
		echo "<li><a href='init_all.php' style='color:gray;'>reset tournament</a></li>";
		echo "<li><a href='last_accessed.php' style='color:gray;'>Last accessed</a></li>";
		echo "<li><a href='list_translations.php' style='color:gray;'>List translations</a></li>";
		echo "<li><a href='mark_top_scorer_adm.php' style='color:gray;'>Enter top scorer</a></li>";
		echo "<li><a href='list_bet_times.php' style='color:gray;'>Bet times</a></li>";
	//	echo "<li><a href='set_pot_race.php' style='color:gray;'>Pot race</a></li>";
		//echo "<li><a href='set_team_players_list_flag.php' style='color:gray;'>Team players list flag</a></li>";
		}
}
function admin_pot_race_links($login_id){
global $pot_admin,$site_admin;

if (($login_id==$pot_admin)||($login_id==$site_admin)) {
		echo "<li><a href='set_pot_race.php' style='color:gray;'>Money pool</a></li>";
		
	}
	

}
function get_username($id){
	if($id){
	$res=mysql_query("SELECT username FROM users WHERE id='$id'");
	return mysql_result($res,0);
	}
}
function get_nick($id){
	$res=mysql_query("SELECT nickname FROM users WHERE id='$id'");
	return mysql_result($res,0);
}
function update_last_login($id){

      $sql = mysql_query("UPDATE users SET last_login=\"".date("d M Y H:i",time())."\" WHERE id='$id'") or die (mysql_error());
}

function get_random_profile($login_id){
	
	$sql=mysql_query("SELECT id,nickname FROM users WHERE player=1 and id<>'$login_id'");
	$num=mysql_num_rows($sql);
	$ran=rand(0,$num-1);
	$res['id']=mysql_result($sql,$ran,'id');
	$res['nick']=mysql_result($sql,$ran,'nickname');

	return $res;
}
function display_bet_history($id){

	$hist=mysql_query("SELECT * FROM matches ORDER by id ASC");
	
	$num_m=mysql_num_rows($hist);
	$total=get_total_players();
	for($i=0;$i<$num_m;$i++){
	
		$m_id=mysql_result($hist,$i,'id');
		if(is_played($m_id)||is_being_played($m_id)) {
			$arr=get_match_details($m_id,$id);
	//	echo $arr["team1"]." - ".$arr["team2"]." : ".bet_result($arr["pick"],$arr["goals1"],$arr["goals2"])."<br/>";		
		$hist1[$m_id]["t1"]=$arr["team1"];
		$hist1[$m_id]["t2"]=$arr["team2"];
		$hist1[$m_id]["res"]=bet_result($arr["pick"],$arr["goals1"],$arr["goals2"]);
		$hist1[$m_id]["weight"]=$arr["weight"];
		$hist1[$m_id]["pick"]=$arr["pick"];
		$hist1[$m_id]["m_id"]=$m_id;
		$coef=compute_coefficients($arr['odds1'],$arr['oddsD'],$arr['odds2'],$total);
		$hist1[$m_id]['coef1']=$coef[0];
		$hist1[$m_id]['coefD']=$coef[1];
		$hist1[$m_id]['coef2']=$coef[2];	
		$hist1[$m_id]['round_id']=$arr['round_id'];	
		
		}
	}
	if($num_m) return $hist1;
	else return 0;
}
function bet_money($login_id){
	$res=mysql_query("SELECT bet_money FROM users WHERE id='$login_id'");
	return mysql_result($res,0);
}
function find_scorer_name($top_id){

	$res2=mysql_query("SELECT name FROM players WHERE id='$top_id'");
	if(mysql_num_rows($res2)) return mysql_result($res2,0);
}
function drop_down_contact($contact){
	$res=mysql_query("SELECT id,first_name,last_name from users WHERE player='1' ORDER by first_name") or die(mysql_error());
	$num=mysql_num_rows($res);
	echo "<tr><td>";
	echo "Contact</td><td>\n";
	echo "<select name='contact'>\n";
	for ($i=0;$i<$num;$i++){
		$id=mysql_result($res,$i,'id');
		$first_name=mysql_result($res,$i,'first_name');
		$last_name=mysql_result($res,$i,'last_name');
		$name=$first_name." ".$last_name;
		echo "<option  value='$id' ".($id==$contact?"selected":"").">".$name."</option>\n";
	}
	echo "</select>\n";
	echo "</tr></td>\n";
}
function parent_chain($id){
//creates an array consisting of all the contacts
//..until the admin_id contact, who is connected to all users ultimately
global $admin_id;
$stack=array();
$stack[]=$id;
//loop until it finds the admin_id
do {
	$query="SELECT contact FROM users WHERE id='$id' and player='1'";
	$res=mysql_query($query) or die(mysql_error());
	if($res) $id=mysql_result($res,0);
	array_push($stack,$id);
} while ($id!=$admin_id);

return $stack;
}
function create_shortest_chain($id1,$id2){
//returns an array consisting of the shortest chain of contact between id1 and id2
global $admin_id;
if($id1!=$admin_id)	{
	$stack1=parent_chain($id1);
}
else return parent_chain($id2);
if($id2!=$admin_id)	$stack2=parent_chain($id2);
else return parent_chain($id1);
	if ($id1==$id2) return 0;
//find the shortest parent_chain
//Compare the last 2 elements of each. If they have identical last elements and different second elements, stop the counter.
$size1=sizeof($stack1);
$size2=sizeof($stack2);
if($size1>1&&$size2>1)	do {
		$last1=array_pop($stack1);
		$last2=array_pop($stack2);
	} while (!(($last1==$last2)&&(end($stack1)!=end($stack2)))); 
//the common parent element (that is the lowest in the tree) is $last1
//construct the chain
	$stack1[]=$last1;
	$reverse2=array_reverse($stack2);
return(array_merge($stack1,$reverse2));
}

function contact_chain($id1,$id2){
$test=create_shortest_chain($id1,$id2);
while (list($key,$val)=each($test)){
	$test2[]=get_player_full_name($val);
}
return($test2);	
}
function get_words(){
global $language_array;
	for($i=0;$i<sizeof($language_array);$i++){
		$wordi='word_'.$language_array[$i];
		$word[$i]=$_POST[$wordi];
	}
return $word;
}
function get_word_array($word_id){
global $language_array;

	if ($word_id) {
		$res=mysql_query("SELECT * FROM language WHERE id='$word_id'");
		for($i=0;$i<sizeof($language_array);$i++){
			$lan="word_".$language_array[$i];
			$arr[$i]=mysql_result($res,0,$lan);
		}

	}
return $arr;
}
function get_word($language,$english_word) {
//gets a word according to the set language session variable ; based on the english word
	$la_q="SELECT word_".$language." FROM language WHERE LOWER(word_en) LIKE LOWER(\"".$english_word."\")";
	//echo $la_q;
	$la=mysql_query($la_q) or die(mysql_error());
/*	
	if($english_word=="all recipes") {
		echo $la_q;
		exit;
	}
*/
	if(mysql_num_rows($la)) $result=mysql_result($la,0,0);
	if($result!="") return ($result);
	else return $english_word;
	
}
function get_word_by_id($id) {
//gets a word according to the set language session variable ; based on the english word
global $language;
	$la_q="SELECT word_".$language." FROM language WHERE id='$id' ";
	//$la_q="SELECT word_en FROM language WHERE id='$id' ";
	//echo $la_q;
	mysql_query("SET NAMES 'utf8'");
	$la=mysql_query($la_q) or die(mysql_error());
	if(mysql_num_rows($la)) $result=mysql_result($la,0,0);
	$result=str_replace("?","&#337;",$result);
	if($result!="") return $result;
	else return $english_word;
	
}
function disp_col($col,$label,$manage) {
	echo "<td align='center'><font color='green'><b><a href='list_recipes.php?order=".$col.($manage?"&manage=$manage":"")."'>".$label."</a></b></font></td>\n";
}

function set_language($lan){
global $cookie_life,$session_n,$language_locale;

	session_name($session_n);
	if (!isset($_SESSION)) {
			 session_start();
	}
	$_SESSION['language']=$lan;
	setcookie('language',$lan,time()+$cookie_life);
//	echo "lang:".$language_locale[$lan];
	//setlocale(LC_ALL,$language_locale[$lan]);
}
function sqlutf(){
	mysql_query("SET NAMES utf8");
}
function setloc(){
global $language;
	switch($language){
		case 'en':$loc='en_US.UTF8';
		break;
		case 'fr':$loc='fr_FR.UTF8';
		break;
		case 'hu':$loc='hu_HU.UTF8';
		break;
	}	
return $loc;	
}
function display_connected_users($login_id,$min){
if(is_admin($login_id)){
	echo "connected: ";
	$res=mysql_query("SELECT id,username FROM users WHERE DATE_SUB(NOW(),INTERVAL $min MINUTE)< last_log AND player=1 ORDER BY last_log desc") or die(mysql_error());
	$num=mysql_num_rows($res);	
	if(is_admin($login_id)) echo "$num - ";
	for($i=0;$i<$num;$i++){
		if(!is_admin(mysql_result($res,$i,'id'))) echo mysql_result($res,$i,'username').", ";
	}
}
	
}
function get_country_code($winner){
global $DB;
if($winner) {
	$query="SELECT code FROM teams WHERE team_id=$winner";
	$code=$DB::qry($query,3);
}
return $code;
}

function back(){
	echo "<a href='javascript:history.back()'>back</a>\n";
	
}
function css($link){
global $docroot;
echo "<link rel='stylesheet' type='text/css'
href='css/".$link."' />";
}

function get_ranking($id){
	if($id){
	$query="SELECT current_ranking from users where id='$id'";
	$res=mysql_query($query) or die(mysql_error());
	$rank=mysql_result($res,0,'current_ranking');
	}
return $rank;
}

function compute_bonus($login_id){	
global $bonus_scorer,$bonus_final_winner;

	$fwq=mysql_query("select top_scorer,winner FROM users where id='$login_id'");
	$topsc=mysql_result($fwq,0,'top_scorer');
	$fw=mysql_result($fwq,0,'winner');
//bonus scorer
	$res=mysql_query("select * from players where top=1");
	$num=mysql_num_rows($res);
	if($num){
		for($i=0;$i<$num;$i++){
			$cur=mysql_result($res,$i,'id');
			if($cur==$topsc) $flag_scorer=1;
		}		
	}
	if($flag_scorer) $bonus=$bonus_scorer;

//bonus final winner

	$wq=mysql_query("select team_id from teams where winner=1");
	$winner=mysql_result($wq,0,'team_id');
	
	if($fw==$winner) $bonus+=$bonus_final_winner;

return $bonus;
 

	
	
}
function display_top_scorers() {
	
	echo "<div id='display_top_scorers'>\n";	
	$query=mysql_query("select * from matches where played=0") or die(mysql_error());
	$num=mysql_num_rows($query);
	if($num<3){
		$res=mysql_query("select name from players where top=1");
		$numsc=mysql_num_rows($res);
		if($num) $str="current";
		else $str="final";
		echo $str." top scorers: ";
		for($i=0;$i<$numsc;$i++){
			echo ($i?", ":"").mysql_result($res,$i,'name')."";
		}	
	}
	echo "<br/>(bonuses will be counted after the final)\n";
	echo "</div>\n";

}

function display_when_live($str){
if(!still_time(1)||matches_played()) echo $str;
}

function convertCase($str, $case = 'upper')
{ //yours, courtesy of table4.com  :)
  switch($case)
  {
    case "upper" :
    default:
      $str = strtoupper($str);
      $pattern = '/&([A-Z])(UML|ACUTE|CIRC|TILDE|RING|';
      $pattern .= 'ELIG|GRAVE|SLASH|HORN|CEDIL|TH);/e';
      $replace = "'&'.'\\1'.strtolower('\\2').';'"; //convert the important bit back to lower
    break;
   
    case "lower" :
      $str = strtolower($str);
    break;
  }
 
  $str = preg_replace($pattern, $replace, $str);
  return $str;
}
function toUpper($string) {
	    return (strtoupper(strtr($string, 'ęóąśłżźćńéóáűüöí','ĘÓĄŚŁŻŹĆŃÉÓÁŰÜÖÍ' ))); 
	}; 

function pick_to_bet($pick){
	switch($pick){
		case 1 : 
			return('1');
			break;
		case 2 : 
			return('D');
			break;
		case 3 : 
			return('2');
			break;

		
	}
}

function show_gain($m_id,$login_id){

	
	$arr=get_match_details($m_id,$login_id);
	$total=get_total_players();
	$coef=compute_coefficients($arr['odds1'],$arr['oddsD'],$arr['odds2'],$total);
	$pick_index=$arr['pick']-1;
	echo "".f_pick($arr["pick"],$arr["code1"],$arr["code2"])."&nbsp;".(bet_result($arr["pick"],$arr['goals1'],$arr['goals2'])?"+".round($coef[$pick_index],2)."&nbsp;<img src='img/icon_smile.gif' style='margin-bottom:-3px;'/>":"")."\n";
	
}

function graph_link($group_id,$type=0){

	$query=mysql_query("SELECT member FROM usergroups WHERE user_id='$group_id'");
	$num=mysql_num_rows($query);
	$str="";
	$key="key";
	$flag=0;
	if(($num==0)||$type) $str="key".$group_id."=".$group_id;
	else {
		for($i=0;$i<$num;$i++){
			$id=mysql_result($query,$i,'member');
			$str.=($flag?"&":"").$key.$id."=".$id;
			$flag=1;
		}
	}
	return($str);
	
}

function get_team_code($id){
		$code=mysql_result(mysql_query("SELECT code FROM teams WHERE team_id='$id'"),0);
		return($code);
}

function get_3rd_place_groups($letter){
	global $big_euro_3rd_place;

	$corr=array("A"=>0,"B"=>1,"C"=>2,"D"=>3);
	$num_col=$corr[$letter];
	$col=array_unique(array_column($big_euro_3rd_place,$num_col));
	asort($col);
	$str="";
	foreach ($col as $key=>$value){
		$str=$str.$value;
	}
	//print "groups are $str";
	//print_r($col);	
return($str);
}
?>
