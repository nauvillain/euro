<?php
require 'conf.php';
require 'php_header.php';

connect_to_eurodb();
function display_user_list(){
global $login_id;

	$res=mysql_query("SELECT id FROM users where player='1' order by first_name");
	$count=mysql_num_rows($res);
	echo "<table class='user_groups'><tr>\n";
	$k=0;
	$columns=4;
	for($i=0;$i<$count;$i++){
		$k+=1;
		echo "<td class='table_right'>";
		$id=mysql_result($res,$i,'id');
		$res2=mysql_query("SELECT * FROM usergroups WHERE user_id='$login_id' AND member='$id'") or die(mysql_error());
		//if the person is already in the user group, mark as checked
		echo get_player_full_name($id)."<input type='checkbox' name='v$id' ".(mysql_num_rows($res2)||($id==$login_id)?"checked":"")." style='float:right;'>";
		echo "</td>";
		if($k==$columns) {
			echo "</tr><tr>\n";
			$k=0;
		}
	}	
	echo "</tr></table>";	

}
?>
<div id='foot_main'>
<div class='boldf'>Select the members of your group:<br/><br/></div>
<form name='form1' method='post' action='submit_user_group.php'>
<?php display_user_list();?>
<input type='submit' value='submit'>
</form>
</div>
<?php
require 'foot_foot.php';
?>
