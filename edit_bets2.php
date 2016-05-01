<?php
require 'auth.php';
require 'lib.php';
require 'head.php';
require 'javascript.php';
require 'javascript_form.php';
require 'javascript_final_round.php';
require 'header_foot.php';

echo "<p><h2>Final round bets!</h2></p>";
$FR_M=48;
$tbl=array("round of 16 - match 1","round of 16 - match 2","round of 16 - match 3","round of 16 - match 4","round of 16 - match 5","round of 16 - match 6","round of 16 - match 7","round of 16 - match 8","1st quarter","2nd quarter","3rd quarter","4th
quarter","1st semi","2nd semi","3rd place","final");
connect_to_database();
//see what has been already entered by the user

$query="SELECT * FROM bets  WHERE player_id='$login_id' AND match_id>$FR_M ORDER BY match_id";

$res=mysql_query($query) or mysql_die();
$num=mysql_num_rows($res);


//take matches that correspond to the second  round

$result=mysql_query("SELECT * FROM matches WHERE id>$FR_M");
$num_second=mysql_num_rows($result);

if(!$num) echo "<i>No bets have been entered yet for the second round.</i><br><br>";

if(($num!=$num_second)&&($num))	echo "<p>You still need to bet on ".($num_second-$num)." matches.</p><br>";
echo "<![if IE]>
<form name='form1' method='post' onchange='javascript:check_all_scores()' onsubmit=\"javascript:return checkForm2(this)\"  action='submit_bets2.php' >";
echo "<![endif]>";
echo "<![if !IE]>
<form name='form1' method='post' onsubmit=\"javascript:return checkForm2(this)\"  action='submit_bets2.php' >";
echo "<![endif]>";
echo "<table width=80% border=2 cellspacing=0 cellpadding=0>";

//show what has been entered so far

for($i=0;$i<$num_second;$i++){

	$match_id=$FR_M+$i+1;
	$num1=mysql_query("SELECT team1,team2 FROM matches WHERE id=$match_id");
	$team1=mysql_result($num1,0,'team1');
	$team1_name=find_team($team1);
	$team2=mysql_result($num1,0,'team2');
	//echo "$team1.$team2";
	$team2_name=find_team($team2);

	$userbets=mysql_query("SELECT goals_team1,goals_team2 FROM bets where player_id='$login_id' AND match_id='$match_id'");
	if (!mysql_num_rows($userbets)) {
		$flag='true';
		$goals1='';
		$goals2='';
	}
	else {
		$goals1=mysql_result($userbets,0,"goals_team1");
		$goals2=mysql_result($userbets,0,"goals_team2");
		$flag='false';
	}
if ($goals1==-1) $goals1="";
if ($goals2==-1) $goals2="";
echo "<tr id='tr$i'>\n";
echo "<td width=20%><i><b><font size=1 color=red>".$tbl[$i]."\n";
echo "</font></b></i></td>\n";
echo "
<script type='text/javascript'>
<!--
loadTD('1','$i','$team1','$team1_name','$flag');
loadInpTD('1','$i','$goals1','$team1');
loadInpTD('2','$i','$goals2','$team2');
loadTD('2','$i','$team2','$team2_name','$flag');
//-->
</script>";
echo "</tr>\n";

}
?>
<![if !IE]>
<script type='text/javascript'>
<!--
complete=true;

check_all_scores();
//-->
</script>
<![endif]>
</table>
<br>

<table>
<tr>
      <td></td><td><input type="button" value="Cancel changes"
      onClick="javascript:history.back()">&nbsp;&nbsp;&nbsp;</td><td><input type="submit" name="Submit" value="Submit" ></td>

    </tr>
  </table>
</form>

<?php
require 'footer.php';
?>






