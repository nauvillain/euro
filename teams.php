<?php
require 'php_header.php';
css('teams.css');
//echo "<div id='sa_menu_title' style='top:140px;left:480px;'><img src='img/teams.gif'/></div>\n";

?>
<div id="foot_main_team">

<?php
//echo "<div id='title_main' class='boldf'>Teams</div>";
connect_to_eurodb();
global $DB;
$team_id=$_REQUEST['id'];
echo "<div id='teams_list'>";

$sql=mysql_query("SELECT * FROM teams") or die(mysql_error());
$num_teams=mysql_num_rows($sql);
	echo "<div id='team_banner' >";
echo "<table id='big_table'><tr><td>\n";
echo "<table class='teams_table'> \n";
for($i=0;$i<$num_teams;$i++){
	$grp=intval($i/4);
	
	if(($i)%4==0&&$i) echo "</table></td><td><table class='teams_table'>\n";
	echo "<tr><td style='border-bottom: 1px solid black;' >";
	if($i%4==0) echo "<span style='font-weight:800;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$groups[$grp]."</span></td></tr><tr><td style='border-bottom: 1px solid black;' >";
//	$name=mysql_result($sql,$i,'team_name');
	$id=mysql_result($sql,$i,'team_id');
	$name=substr(get_team_name($id),0,23);
	echo "<a href='teams.php?id=$id'>".$name."</a>\n";
	echo "</td></tr>\n";
	
}
echo "</table></td></tr></table>\n";
echo "</div>\n";
echo "</div>\n";
if($team_id){
//	$spl=mysql_query("SELECT * FROM players WHERE team_id='$team_id' ORDER by id");
//	$spl=$DB::qry("SELECT * FROM players WHERE team_id='$team_id' ORDER by id");
	$spl=mysql_query("SELECT * FROM players WHERE team_id='$team_id' ORDER by id");
	$num_pl=mysql_num_rows($spl);
	$query_team="select team_id,team_name,players_list from teams where team_id='$team_id'";
	$res_team=mysql_query($query_team);
	if(mysql_num_rows($res_team)){
		$team_name=get_team_name(mysql_result($res_team,0,'team_id'));
		$players_list=mysql_result($res_team,0,'players_list');
	}	
	echo "<br/>";
	echo "<div id='team_details'>";
	echo "<div id='team_content'>\n";
	echo "<div id='team_name'>".$team_name."</div>\n";
	$log=$DB::qry("SELECT code FROM teams WHERE team_id='$team_id'",3);
//	echo "<div id='team_banner' style='background:url(img/".$log."_b.jpg) no-repeat;'>".$team_name."</div>";
	echo "<div class=players_list><table>";
	//check if players have been entered for that team
	if($players_list){
		//sqlutf();
		for($i=0;$i<$num_pl;$i++){
			echo "<tr>\n";
			//<td>".($i+1)." -</td>
			echo "<td align='left'> ".mysql_result($spl,$i,'name')."</td></tr>";
		}
		echo "</table>\n</div>\n";
	}
	else echo "<tr><td>players not entered yet</td></tr>";
		echo "</table>\n</div>\n";
//		echo "<div id='team_logo'>";
	//	echo "<img src='img/".$log."_t.gif' alt='code'/>&nbsp;<br/>\n";
//		echo "</div>";
//		echo "<div id='team_kit'>";
	//	echo "<img src='img/".$log."_k.gif' alt='code'/>&nbsp;\n";
//		echo "</div>";
		echo "<div id='team_coach'>";
		echo "<img src='img/".$log."_c.jpg' alt='coach' height='200px'/>&nbsp;\n";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		
}

if(!still_time(2)){
?>
<div id='team_history'><?php echo "<a href='team_sheet.php?id=$team_id'>Team history</a>";?></div>
</div>
<?php
}
?>
