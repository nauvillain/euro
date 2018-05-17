<?php // content="text/plain; charset=utf-8"
require 'php_header.php';
require 'js/all_checkboxes.js';
$total_players=get_total_players();
$min_height=600+floor($total_players*3);
echo "<div id='foot_main' style='min-height:".$min_height."px'>\n";
if(!is_played(3)) echo "Graphs will be displayed after the 3rd match\n";
else {

	echo "\t<div id='history_graph_title'>\n";
	echo "\t<h2>Points graph</h2>\n";
	back();
	echo "\t</div'>\n";
	$str="";
	$flag=0;
	echo " <form name='update_graph' method='get' action='point_history.php'>";
	sqlutf();
	?>

	<?php
	if(isset($_REQUEST['group'])) {
		$graph_placement=1;
		echo "<div id='graph_members'>\n";
		echo "<table>\n";
		$group=$_REQUEST['group'];
		$query=mysqli_query($link,"SELECT member FROM usergroups WHERE user_id='$group'");
		$num=mysqli_num_rows($query);
		echo "<tr><td><a href='set_user_group.php?id=$id'>Set my group</a>&nbsp;</td></tr>\n";
		for($i=0;$i<$num;$i++){
			echo "<tr><td>\n";
			$val=mysqli_result($query,$i,'member');
			$key='key'.$val;
			if(isset($_REQUEST[$key])) {
				$checked=1;
				$str.=($flag?"&":"").$key."=".$val;
			}
			else $checked=0;
			echo "<input type='checkbox' name='key".$val."' value='$val' ".($checked?"checked":"")."/>".get_nick($val)."\n";	
			$flag=1;
			echo "</td></tr>\n";
		}
			echo "<input type='hidden' name='group' value='$group'/>";	
		echo "<tr><td>\n";
		echo "<input type='button' onclick='SetAllCheckBoxes(false);' value='Uncheck all'>\n";
		echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='Submit' value='Submit' style='float:right;'>";
		echo "</td></tr>\n";
		
		
		echo "</table>\n";
		echo "</div>\n";
	?>
	<?php
	}
	else {
		$graph_placement=2;
		$max=$total_players/9;
		echo "<div id='other_users'>\n";
		echo "<table>\n";
		echo "<tr>\n";
		echo "<td>\n";
		echo "<table valign=top>\n";

		$query=mysqli_query($link,"SELECT id FROM users WHERE player=1 ORDER by nickname");
		$num=mysqli_num_rows($query);
		$td_count=0;
		for($i=0;$i<$num;$i++){
			$val=mysqli_result($query,$i,'id');
			$key='key'.$val;
			if(isset($_REQUEST[$key])) {
				$checked=1;
				$str.=(strlen($str)==0?"":"&").$key."=".$val;
			}
			else $checked=0;
			echo "<tr><td><input type='checkbox' name='key".$val."' value='$val' ".($checked?"checked":"")."/>".substr(get_nick($val),0,13)."\n";
			echo "</td></tr>\n";	
			if($td_count>$max){
				echo "</table></td><td><table valign=top>";
				$td_count=0;
			}
			$td_count++;
		}
		echo "</table>\n";
		echo "</td>\n";
		echo "</tr>\n";
		echo "</table>\n";
	?>
		<input type="button" onclick="SetAllCheckBoxes(false);" value="Uncheck all">
	<?php
		echo "<input type='submit' name='Submit' value='Submit' style='float:right;'>";
		echo "</div>\n";
	}	/*while(list($key,$val)=each($_REQUEST)){

		
		echo "<input type='checkbox' name='key".$val."' value='$val' ".($group||$checked?"checked":"")."/>".get_nick($val)."\n<br/>";	
		$str.=($flag?"&":"").$key."=".$val;
		$flag=1;

	}*/
	?>
	</form>
	<?php
	if($graph_placement==1)	echo "\t<div id='history_graph'>\n";
	else	echo "\t<div id='history_graph_points'>\n";
	echo "\t<img src='point_history_graph.php?$str'/>\n";
	echo "\t</div>\n";
	
}
echo "</div>\n";
?>
