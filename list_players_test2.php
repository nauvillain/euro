<?php
require 'auth.php';
require 'head.php';
require 'header_foot.php';
require 'lib.php';
require 'javascript.php';

connect_to_database();

echo "<div id='top_scorer_list'>";
//select top_scorer, if any

$query="SELECT top_scorer FROM scorer WHERE top=1";
$sco=mysql_query($query) or die("Problem with the scorer table");
$tot=mysql_num_rows($sco);

//select winner, if applicable 

$query="SELECT team_name FROM teams WHERE winner=1";
$win_te=mysql_query($query) or die("Problem with the winner table");
$test_win=mysql_num_rows($win_te);



$res=mysql_query("SELECT id,first_name,nickname,city,top_scorer,winner,current_points,bet_money FROM users WHERE player=1 ORDER BY current_points DESC");
$num=mysql_num_rows($res);
echo "<h2>Players' rankings</h2>";
echo "the <img src='checkmark3.gif'> sign shows next to players who bet money";
if ($num==0) echo "No players registered yet!";


for ($i=0;$i<$num;$i++){

	$p_id=mysql_result($res,$i,"id");
	$nickname=mysql_result($res,$i,"nickname");
	$first_name=mysql_result($res,$i,"first_name");
	if($nickname=="") $nickname=$first_name;
	$pts=mysql_result($res,$i,"current_points");
	$eur=mysql_result($res,$i,"bet_money");
	echo "<div id='rankings'>\n";		
  
	if($temp!=$pts) {
			echo ($i+1);
	}
	else echo ""; 
	echo "<a href='player_profile.php?id=".$p_id."'>&nbsp;$nickname</a>\n"; 
	echo "&nbsp;$pts pts\n"; 
	echo ($eur==1?"<img src='checkmark3.gif' height=12>":"")."\n"; 
	echo "</div>\n";
	$temp=$pts;
}
echo "</div>";
?>
<?php
require 'footer.php';
?>
