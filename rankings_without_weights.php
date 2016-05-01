<?php
require 'php_header.php';

connect_to_eurodb();

echo "<div id='main'>";
//select top_scorer, if any

//$query="SELECT top_scorer FROM scorer WHERE top=1";
//$sco=mysql_query($query) or die("Problem with the scorer table");
//$tot=mysql_num_rows($sco);

//select winner, if applicable 

//$query="SELECT team_name FROM teams WHERE winner=1";
//$win_te=mysql_query($query) or die("Problem with the winner table");
//$test_win=mysql_num_rows($win_te);



$res=mysql_query("SELECT id,first_name,nickname,city,top_scorer,winner,current_points,bet_money FROM users WHERE player=1 ORDER BY current_points DESC");
$num=mysql_num_rows($res) or die(mysql_error());
echo "<div id='title_main' class='boldf'>Players' rankings</div>";
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

$max_rank=30;
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

	$rem_weights=get_remaining_weights($p_id,$TOT_WEIGHTS,0);
  		
	echo "<tr>\n";
	if($temp!=$pts) {
		if($i)	$flag=1;
		echo "<td>\n".($i+1);
	}
	else echo "<td>"; 
	echo "</td>";
	echo "<td><a href='player_profile.php?id=".$p_id."' ".($flag!=1?"class='first'":"").">&nbsp;".$nickname."</a></td>\n"; 
	echo "<td>&nbsp;".$pts." (".$rem_weights.")</td>\n"; 
	//echo "<td>".($eur==1?"<img src='checkmark3.gif' height=12>":"")."</td>\n"; 
	echo "</tr>\n";
	$temp=$pts;
	if((floor(($i+1)/$max_rank))==(($i+1)/$max_rank)) echo "</table>\n</td><td valign=top>";
	
}
echo "</div></td></tr></table>";


arsort($pts);
reset($pts);

$i=1;
while (list ($key, $val) = each ($pts)) {

	$i++;
}

echo "</td></tr></table>";
echo "</div>";
?>
<?php
require 'foot_foot.php';
?>
