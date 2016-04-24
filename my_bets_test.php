<?php
require 'auth.php';
require 'head.php';
require 'header_foot.php';
require 'lib.php';
require 'javascript.php';

$FR_M=48;
connect_to_database();
echo "<div id='rankings'>";
if(still_time(1)) echo "<br><b><i>".remaining_time(0)." day".(remaining_time(0)==1?"":"s")." to go!</i></b><br>";

//see what has been already entered by the user
echo "<div id='print'><a href='my_bets_print.php' target='content'>Printable version</a></div>";
$query="SELECT * FROM bets  WHERE player_id='$login_id' ORDER BY match_id";
$res=mysql_query($query) or mysql_die();
$num=mysql_num_rows($res);

//take matches that correspond to the first round

$result=mysql_query("SELECT * FROM matches WHERE id<=$FR_M ORDER BY id");
$num_first=mysql_num_rows($result);

//check if player has entered any bets
//if he has but hasn't entered them all
if(($num<$num_first)&&($num))$rem1=1;
else $rem1=0;
if ($rem1==1)	{
		echo "<p>You still need to bet on ".($num_first-$num)." matches.</p><br>";
if(still_time(1))		echo "<a href='edit_bets1.php'> Enter remaining first round bets</a><br>";
}
//take the top scorer & World Cup Winner
if(still_time(1)) echo "<a href='edit_bets1.php'> Edit my 1st round bets</a><br>";
$top=mysql_query("SELECT top_scorer,winner FROM users WHERE
id='$login_id'") or mysql_die();
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
echo "<p><font color=red> World cup winner:<b> ".$winner."</b></font></p>";
echo "<p><font color=red> Best scorer: ".$top_scorer."</font></p>";

echo "<table width=95% border=0 cellspacing=0 cellpadding=0>";

echo "<tr>\n";
echo "<td><font color=green>";
echo "<p><i> My first round bets:</i><p>";
echo "</font></td>\n";
echo "<td><font color=green>";
echo "<p><i>My second round bets:</i><p>";
echo "</font></td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td>\n";
echo "<table border=0 cellspacing=0 cellpadding=0>";

$mm=mysql_query("SELECT * FROM matches where played=1 ORDER BY id");

//show what has been entered so far

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
echo "<td align=right>".$team1."&nbsp; </td>\n";
echo "<td align=right> ".$goals1." -</td>\n";
echo "<td >- ".$goals2." </td>\n";
echo "<td >&nbsp; ".$team2."</td>\n";
if($played) echo "<td > <img src='$str.gif'> ($g1-$g2)</td>";

echo "</tr>\n";

}

echo "</table>";
echo "</td>\n";

$query="SELECT * FROM matches WHERE played=1";
$sql=mysql_query($query) or mysql_die();
$num_matches_played=mysql_num_rows($sql);


if($num_matches_played<42){
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

$num_tot=$num_first+$num_second;



for($i=$num_first;$i<$num_tot;$i++){

	$match_id=mysql_result($res,$i,"match_id");

	$num1=mysql_query("SELECT team1 FROM matches WHERE
	$match_id=id");
	$tmp1=mysql_result($num1,0);
	if($tmp1) $rez1=mysql_query("SELECT team_name FROM teams WHERE teams.id=$tmp1") or mysql_die();
	$team1=mysql_result($rez1,0);
	

	$num2=mysql_query("SELECT team2 FROM matches WHERE
	$match_id=id");
	$tmp2=mysql_result($num2,0);
	if($tmp2) $rez2=mysql_query("SELECT team_name FROM teams WHERE
	teams.id=$tmp2") or mysql_die();
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
if($tmp1) echo "<td width=33% align=right>".$team1."&nbsp;</td>\n";
echo "<td width=10% align=right> ".$goals1."-</td>\n";
echo "<td width=10%>".$goals2." </td>\n";
if($tmp2) echo "<td width=33%>&nbsp;".$team2."</td>\n";
if($played) echo "<td width=14%> <img src='$str.gif'> ($g1-$g2)</td>";

echo "</tr>\n";

}


}
echo "</table>";}

echo "</td>";
echo "</tr>";
echo "</table>";
//echo "</div>";
?>
<?php
require 'footer.php';
?>
