<?php
require 'conf.php';
require 'php_header.php';
connect_to_eurodb();
$type=$_GET['type'];
function create_user_tree($id,$type){
global $admin_id;
	echo "<table style='border-bottom:1px solid;border-right:1px solid;'>\n";
	echo "<tr><td>\n";
	echo "<a href='player_profile.php?id=$id'>".($type==1?get_player_name($id):get_player_full_name($id))."</a>";
	echo "</td><td>\n";
	$res=mysql_query("SELECT id FROM users WHERE contact='$id' and player='1'");
	$count=mysql_num_rows($res);
	if($count){
		for($i=0;$i<$count;$i++){
			$new_id=mysql_result($res,$i,'id');
			if($new_id!=$admin_id) create_user_tree($new_id,$type);
		}
	}
	echo "</td></tr></table>\n";
	}
	
	
//creates an array consisting of all the contacts
//..until the admin_id contact, who is connected to all users ultimately

?>
<div id='foot_main'>
	
<?php
	echo "<a href='display_user_tree.php?type=0'>By full name</a>&nbsp;/&nbsp;";
	echo "<a href='display_user_tree.php?type=1'>By nickname</a>";
	create_user_tree(1,$type);
?>

</div>
<?php
require 'foot_foot.php';
?>
