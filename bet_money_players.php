<?php
require 'auth.php';
require 'head.php';
require 'header_foot.php';
require 'lib.php';
require 'javascript.php';

connect_to_database();




$res=mysql_query("SELECT id,first_name,nickname,country FROM users WHERE bet_money=1 ORDER BY first_name");
$num=mysql_num_rows($res);
echo "<h2>Players betting 10 euros</h2>";

if ($num==0) echo "No players registered yet!";
echo "

<p><b>The winner will get 60% of the pot, the second 30% and the 3rd 10%.</b></p>
";
echo "<table border='0' bordercolor=grey>\n";
for ($i=0;$i<$num;$i++){

	$p_id=mysql_result($res,$i,"id");
	$nickname=mysql_result($res,$i,"nickname");
	$first_name=mysql_result($res,$i,"first_name");
	if($nickname=="") $nickname=$first_name;
  	$cty=mysql_result($res,$i,"country");
	
	echo "<tr>\n";
	echo "<td>\n".($i+1);
	echo "</td>";
	echo "<td><a href='player_profile.php?id=".$p_id."'>&nbsp;$nickname</a></td>\n"; 
	echo "<td>$cty</td>";
	echo "</tr>\n";
}



echo "</table><br>\n";

?>
<?php
?>
