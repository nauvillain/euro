<?php
require 'php_header.php';


$display=$_GET['display'];

$title[0]="Rankings";
$title[1]="Pot Race";
$title[2]="Rankings by correct bets";
$title[3]="Rankings by points/correct bet";
connect_to_eurodb();

echo "<div id='main'>";


echo "<div class='middle'><h2>".$title[$display]."</h2></div>";
//select top_scorer, if any

//$query="SELECT top_scorer FROM scorer WHERE top=1";
//$sco=mysql_query($query) or die("Problem with the scorer table");
//$tot=mysql_num_rows($sco);

//select winner, if applicable 

//$query="SELECT team_name FROM teams WHERE winner=1";
//$win_te=mysql_query($query) or die("Problem with the winner table");
//$test_win=mysql_num_rows($win_te);

$money=bet_money($login_id);

if($money&&($display==1)) $flagm=1;
else $flagm=0;
if($display==2) $vic=1;
else $vic=0;

$res=mysql_query("SELECT id,first_name,nickname,city,top_scorer,winner,current_points,current_correct,bet_money FROM users WHERE player=1 ".($flagm?"AND bet_money=1":"").($vic?"ORDER BY current_correct DESC,nickname":" ORDER BY current_points DESC,nickname"));
$num=mysql_num_rows($res) or die(mysql_error());
echo "<div id='title_main' class='boldf'>Players' rankings</div>";
if($flagm) {
	echo "<a href='rankings.php?display=0'>Rankings</a>&nbsp; &nbsp;&nbsp;";
	echo "<a href='rankings.php?display=2'>rankings per correct bet</a><br/>";
	}
else {
	if($money) echo "<a href='rankings.php?display=1'>Pot race</a>&nbsp;&nbsp;&nbsp;";
	if($display==0) echo "<a href='rankings.php?display=2'>rankings per correct bet</a><br/>";
	else echo "<a href='rankings.php?display=0'>Rankings</a><br/>";}

if ($num==0) echo "No players registered yet!";
function disp_table(){
	echo "<table border='0' bordercolor=grey>\n";
	echo "<tr>\n";
	echo "<td>rank\n";
	echo "</td>";
	echo "<td>Name</td>\n"; 
	echo "<td>Pts</td>\n"; 
	//echo "<td>&euro;</td>\n"; 
	echo "</tr>\n";
}

$max_rank=36;
echo "<table><tr><td valign=top>";
$flag=0;
for ($i=0;$i<$num;$i++){

	if((floor($i/$max_rank))==($i/$max_rank)) disp_table();
	$p_id=mysql_result($res,$i,"id");
	$nickname=mysql_result($res,$i,"nickname");
	$first_name=mysql_result($res,$i,"first_name");
	if($nickname=="") $nickname=$first_name;
	$pts=mysql_result($res,$i,"current_points");
	$eur=mysql_result($res,$i,"bet_money");
	$curr=mysql_result($res,$i,"current_correct");
	$rem_weights=get_remaining_weights($p_id,$TOT_WEIGHTS,0);
  	$rank[$p_id]['rem']=$rem_weights;
	$rank[$p_id]['pts']=$pts;
	$rank[$p_id]['name']=$nickname;
	$rank[$p_id]['curr']=$curr;	
	$rank[$p_id]['lost']=$TOT_WEIGHTS-$pts-$rem_weights;	
	echo "<tr>\n";
	if($display==2){
		if($temp!=$curr) {
			if($i)	$flag=1;
			echo "<td>\n".($i+1);
		}
		else echo "<td>"; 
		}
	else {
		if($temp!=$pts) {
			if($i)	$flag=1;
			echo "<td>\n".($i+1);
		}
		else echo "<td>"; 
	
	}
	echo "</td>";
	echo "<td><a href='player_profile.php?id=".$p_id."' ".($flag!=1?"class='first'":"").">&nbsp;".$nickname."</a></td>\n"; 
	echo "<td>&nbsp;".($display==2?"$curr":"".$pts." (".$rem_weights.")")."</td>\n"; 
	//echo "<td>".($eur==1?"<img src='checkmark3.gif' height=12>":"")."</td>\n"; 
	echo "</tr>\n";
	if($display==2) $temp=$curr;
	else $temp=$pts;
	if((floor(($i+1)/$max_rank))==(($i+1)/$max_rank)) echo "</table>\n</td><td valign=top>";
	
}
echo "</div></td></tr></table>";


foreach($rank as $v2){
	 $sortpts[]=$v2['pts'];
	 $sortrem[]=$v2['rem'];
	 $sortlost[]=$v2['lost'];

}
if($display==0) array_multisort($sortpts,SORT_DESC,$sortgd,SORT_DESC,$rank);
if($display==2) array_multisort($sortlost,SORT_ASC,$rank);

unset($sortpts) ;
unset($sortgd);

$i=1;
echo "</td></tr></table>";
foreach($rank as $row){
//if($display==0)	echo $row['name']." - ".$row['pts']."/".$row['rem']."<br/>";
//if($display==2) echo $row['name']."-".$row['lost']."<br/>";
}
echo "</div>";
?>
<?php
require 'foot_foot.php';
?>
