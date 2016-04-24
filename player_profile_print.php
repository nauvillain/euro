<?php
require 'lib_gen.php';
require 'lib_foot.php';
require 'javascript.php';
echo "<div id='main'>";

//we need to make sure that we can show the winner & top_scorer
//require 'auth_bets2.php';

$id= $_REQUEST['id'];
$FR_M=48;
connect_to_eurodb();
$query="SELECT * FROM users
WHERE id='$id'";
//echo $query;

$result=mysql_query($query);
$num=mysql_num_rows($result);

$player=mysql_result($result,0,"player");

if($player==1){
$first_name=mysql_result($result,0,"first_name");
$last_name=mysql_result($result,0,"last_name");
$nickname=mysql_result($result,0,"nickname");
$country=mysql_result($result,0,"country");
$city=mysql_result($result,0,"city");
$comments=mysql_result($result,0,"comments");
$age=mysql_result($result,0,"age");
$fav_player=mysql_result($result,0,"fav_player");
$fav_team=mysql_result($result,0,"fav_team");
$top_scorer=mysql_result($result,0,"top_scorer");

//take the top_scorer name

$top=mysql_query("SELECT top_scorer,winner FROM users WHERE
id='$id'") or die(mysql_error());
$top_scorer_id=mysql_result($top,0,'top_scorer');
$winner_id=mysql_result($top,0,'winner');
if ($top) {
	$sco=mysql_query("SELECT top_scorer FROM scorer WHERE id=$top_scorer_id");
	$winn=mysql_query("SELECT team_name FROM teams WHERE id=$winner_id");
	$top_scorer=mysql_result($sco,0);
	$winner=mysql_result($winn,0);
	}
if(!$top_scorer_id) $top_scorer="None chosen yet";
if(!$winner_id) $winner="None chosen yet";
echo "<table width=70% border=0  cellspacing=2	 cellpadding=0>\n
<tr><td><table><tr><td><font color=green>";
echo "<b>".$first_name." ".$last_name."</b></font>\n";
if ($nickname){echo "...alias <b>".$nickname."</b><br><br></td></tr>\n";}
echo "</td></tr>";
if((!still_time(1))||($id==$login_id)) {
		echo "<tr><td><b>Top scorer:</b> ".$top_scorer."</td></tr>";
		echo "<tr><td><b>World Cup Winner: ".strtoupper($winner)."</b></td></tr>";
		}
echo "</table></td>
<td>";
echo "</td></tr></table>";

echo "<table width=95% border=0 cellspacing=0 cellpadding=0>";

echo "<tr>\n";
echo "<td><font color=green>";
if(!$nickname) echo "<p><i>".$first_name."'s first round bets:</i><p>";
else echo "<p><i>".$nickname."'s first round bets:</i><p>";
echo "</font></td>\n";
echo "<td><font color=green>";
if(!$nickname) echo "<p><i>".$first_name."'s second round bets:</i><p>";
else echo "<p><i>".$nickname."'s second round bets:</i><p>";
echo "</font></td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td>\n";
echo "<table border=0 cellspacing=0 cellpadding=0>";

//see what has been already entered by the user

$query="SELECT * FROM bets  WHERE player_id='$id' ORDER BY match_id";
$res=mysql_query($query)
or mysql_die();
$num=mysql_num_rows($res);

if ($id!=$login_id) {
	if(still_time(1)) {
						echo "Bets from other players will be visible after kick-off.";
						exit;	
	}
}
//echo date("M d Y H:i",time());
//take matches that correspond to the first round

$result=mysql_query("SELECT * FROM matches WHERE id<=$FR_M");
$num_first=mysql_num_rows($result);


$mm=mysql_query("SELECT * FROM matches where played=1 ORDER BY id");



//show what has been entered so far
//$num10=min($num,$num_first);

for($i=0;$i<$num;$i++){

	$match_id=mysql_result($res,$i,"match_id");

	$num1=mysql_query("SELECT team1 FROM matches WHERE
	$match_id=id");
	$tmp1=mysql_result($num1,0);
	$rez1=mysql_query("SELECT team_name FROM teams WHERE
	$tmp1=teams.id") or mysql_die();
	$team1=mysql_result($rez1,0);
	

	$num2=mysql_query("SELECT team2 FROM matches WHERE
	$match_id=id");
	$tmp2=mysql_result($num2,0);
	$rez2=mysql_query("SELECT team_name FROM teams WHERE
	$tmp2=teams.id") or mysql_die();
	$team2=mysql_result($rez2,0);

	$goals1=mysql_result($res,$i,"goals_team1");
	$goals2=mysql_result($res,$i,"goals_team2");

	$g1=mysql_result($mm,$i,"goals1");
	$g2=mysql_result($mm,$i,"goals2");
 	$played=mysql_result($mm,$i,"played");
//if($goals1==null) $goals1=0;
//if($goals2==null) $goals2=0;
$t1=sc($g1,$g2);
$t2=sc($goals1,$goals2);

		if ($t1==$t2) {
			if($g1==$goals1&&$g2==$goals2) {
							$str="checkmark2";
			}
			else 				{
							$str="checkmark3";
			}
		}
		else $str="x";

echo "<tr>\n";
echo "<td width=33% align=right>".$team1."&nbsp; </td>\n";
echo "<td width=10% align=right> ".$goals1." -</td>\n";
echo "<td width=10%>- ".$goals2." </td>\n";
echo "<td width=33%>&nbsp; ".$team2."</td>\n";
if($played) echo "<td width=14%> <img src='$str.gif'> ($g1-$g2)</td>";
echo "</tr>\n";

}

echo "</table>";
echo "</td>\n";

$query="SELECT * FROM matches WHERE played=1";
$sql=mysql_query($query) or mysql_die();
$num_matches_played=mysql_num_rows($sql);


if($num_matches_played<$num_first){
echo "<td valign=top><i>";
echo "These will be entered<br>after the first round</i>";
}
else{
if(($num_matches_played==$num_first)&&($num==$num_first)){
echo "<td valign=top><i>";
echo "None entered yet</i>";
}
else{
echo "<td valign=top>";
echo "<table border=0 cellspacing=0 cellpadding=0>";
//take matches that correspond to the second round

$result=mysql_query("SELECT * FROM matches WHERE id>$FR_M");
$num_second=mysql_num_rows($result);

$num_tot=$first+$num_second;



//show what has been entered so far

for($i=$num_first;$i<$num_tot;$i++){

	$match_id=mysql_result($res,$i,"match_id");

	$num1=mysql_query("SELECT team1 FROM matches WHERE
	$match_id=id");
	$tmp1=mysql_result($num1,0);
	$rez1=mysql_query("SELECT team_name FROM teams WHERE
	$tmp1=teams.id") or mysql_die();
	$team1=mysql_result($rez1,0);
	

	$num2=mysql_query("SELECT team2 FROM matches WHERE
	$match_id=id");
	$tmp2=mysql_result($num2,0);
	$rez2=mysql_query("SELECT team_name FROM teams WHERE
	$tmp2=teams.id") or mysql_die();
	$team2=mysql_result($rez2,0);

	$goals1=mysql_result($res,$i,"goals_team1");
	$goals2=mysql_result($res,$i,"goals_team2");

//if($goals1==null) $goals1=0;
//if($goals2==null) $goals2=0;

	$g1=mysql_result($mm,$i,"goals1");
	$g2=mysql_result($mm,$i,"goals2");
 	$played=mysql_result($mm,$i,"played");

$t1=sc($g1,$g2);
$t2=sc($goals1,$goals2);

		if ($t1==$t2) {
			if($g1==$goals1&&$g2==$goals2) {
							$str="checkmark2";
			}
			else 				{
							$str="checkmark3";
			}
		}
		else $str="x";
echo "<tr>\n";
echo "<td width=40% align=right>".$team1."&nbsp;</td>\n";
echo "<td width=10% align=right> ".$goals1."-</td>\n";
echo "<td width=10%>-".$goals2." </td>\n";
echo "<td width=40%>&nbsp;".$team2."</td>\n";
if($played) echo "<td width=10%> <img src='$str.gif'>($g1-$g2)</td>";

echo "</tr>\n";

}

}
echo "</table>";}

}
else echo "This id is not a player's id.";
?>
<?php
?>
