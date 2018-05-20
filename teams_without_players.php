<?php
require 'php_header.php';
css('teams.css');
//echo "<div id='sa_menu_title' style='top:140px;left:480px;'><img src='img/teams.gif'/></div>\n";

?>
<div id="foot_main">

<?php
//echo "<div id='title_main' class='boldf'>Teams</div>";
connect_to_eurodb();
global $DB;
$team_id=$_REQUEST['id'];
echo "<div >";
echo "<p> Teams without players </p>";
$sql=mysqli_query($link,"SELECT * FROM teams") or mysqli_error($link);
$num_teams=mysqli_num_rows($sql);
echo "<table align='center'> \n";
for($i=0;$i<$num_teams;$i++){
	$team_id=mysqli_result($sql,$i,'team_id');
	$sqlt=mysqli_query($link,"SELECT * FROM players where team_id='$team_id'") or mysqli_error($link);
	$num_players=mysqli_num_rows($sqlt);
	if($num_players==0){
		echo "<tr><td>\n";
		$name=mysqli_result($sql,$i,'team_name');
		echo "<a href='teams.php?id=$team_id'>".$name."</a>\n";
		echo "</td></tr>\n";
	
	}
}
		echo "</table>\n</div>\n";
echo "</div>";
?>
