<?php
require 'conf.php';
require 'php_header.php';

connect_to_eurodb();
function display_user_list(){
global $login_id,$link;

	$res=mysqli_query($link,"SELECT id,bet_money FROM users where player='1' ORDER by first_name");
	$count=mysqli_num_rows($res);
	echo "<table class='user_groups'>\n";
	echo "<tr><td><table>\n";
	$k=0;
	$columns=25;
	for($i=0;$i<$count;$i++){
		$k+=1;
		echo "<tr>\n<td class='table_right'>";
		$id=mysqli_result($res,$i,'id');
		$pot=mysqli_result($res,$i,'bet_money');//if the person is already in the user group, mark as checked
		echo get_player_full_name($id)."<input type='checkbox' name='v$id' ".($pot?"checked":"")." style='float:right;'>";
		echo "</td></tr>";
		if($k==$columns) {
			echo "</table></td><td><table>\n";
			$k=0;
		}
	}	
	echo "</td></tr></table>";	

}
?>
<div id='foot_main'>
<div class='boldf'>Select the members of your group:<br/><br/></div>
<form name='form1' method='post' action='submit_pot_race_group.php'>
<?php display_user_list();?>;
<input type='submit' value='submit'>
</form>
</div>
<?php
require 'foot_foot.php';
?>
