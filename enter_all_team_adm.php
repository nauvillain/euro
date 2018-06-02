<?php
require 'php_header.php';
//require 'admin.php';
global $link;
if(is_admin($login_id)){

	$team_id=getIfSet($_REQUEST['team_id']);

	connect_to_database();

	$res=mysql_query("SELECT * FROM teams ORDER BY team_name");
	$num=mysql_num_rows($res);

	echo "<div id='foot_main'><br/><br/><br/>";
	echo "<form name='form1' method='post' action='submit_all_team_adm.php'>";
	echo "<input type='text' id='team' name='team' value='$team_id' autofocus>";
	echo "
	<input type=submit name='submit' type='submit' value='submit team_name'>
	</form><br/>";
	$res=mysqli_query($link,"SELECT team_id,team_name from all_teams ORDER by team_id DESC") or mysqli_error($link);
	$num=mysqli_num_rows($res);
	echo "<table><tr>\n";
	for ($i=0;$i<$num;$i++){
		if($i % 10 == 0) echo "<td><table>\n";
		echo "<tr><td>\n";
		$team_id=mysqli_result($res,$i,'team_id');
		$team_name=mysqli_result($res,$i,'team_name');
		echo "$team_name<br/>";
		echo "</td></tr>\n";
		if($i % 10 == 9) echo "</table></td>\n";
	}
	echo "</tr></table>\n";
	echo "</div>\n";
	}
?>
