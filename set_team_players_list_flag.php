<?php
require 'conf.php';
require 'php_header.php';

connect_to_eurodb();
function display_teams_list(){

	$res=mysql_query("SELECT team_id,players_list FROM teams");
	$count=mysql_num_rows($res);
	echo "<table class='user_groups'><tr>\n";
	$k=0;
	$columns=4;
	for($i=0;$i<$count;$i++){
		$k+=1;
		echo "<td class='table_right'>";
		$id=mysql_result($res,$i,'team_id');
		$list=mysql_result($res,$i,'players_list');
		echo get_team_name($id)."<input type='checkbox' name='v$id' ".($list?"checked":"")." style='float:right;'>";
		echo "</td>";
		if($k==$columns) {
			echo "</tr><tr>\n";
			$k=0;
		}
	}	
	echo "</tr></table>";	

}
?>
<div id='main'>
<div class='boldf'>Select the teams that have a full list of players:<br/><br/></div>
<form name='form1' method='post' action='submit_teams_list_flags.php'>
<?php display_teams_list();?>;
<input type='submit' value='submit'>
</form>
</div>
<?php
require 'foot_foot.php';
?>
