<?php
require 'config.php';

function connect_to_zincous_database()
{
  global $db_database, $db_username, $db_password, $db_hostname;
  mysql_pconnect($db_hostname,$db_username,$db_password) or mysql_die();
  mysql_select_db($db_database) or mysql_die();
}

function display_zincous_form($event_id) {

echo "<form method='post' action='enter_zincou_result.php'>\n";
connect_to_zincous_database();

$query=select_event($event_id);
display_events($query);
display_zincous_list();
echo "<input name='submit' type='submit' id='submit' value='enregistrer' style='height:25px;'/>";
echo "</form>\n";
}

function select_event($event_group_id) {
  return mysql_query("SELECT * FROM events.event WHERE group_id=$event_group_id ORDER BY id");
}

function display_events($res) {

	$count=mysql_num_rows($res);
	echo "<div id=events>\n";
	for($i=0;$i<$count;$i++){
		$event=mysql_result($res,$i,'description');
		$e=mysql_result($res,$i,'id');
		echo "<p>$event";
		echo "<input type='checkbox' id='checkbox[]' name='checkbox[]' value='$i'/></p><br/>\n";
		echo "<input type='hidden' id='event_id$i' name='event_id$i' value='$e'/>\n";
	}
	$g_id=mysql_result($res,0,'group_id');
	echo "<input type='hidden' id='group_id' name='group_id' value='$g_id'/>\n";
	echo "<input type='hidden' id='num' name='num' value='$count'/>\n";
	echo "</div>\n";


}

function display_zincous_list() {
	
	$query="SELECT * FROM website.users WHERE zincou=1";
	$res=mysql_query($query) or die(mysql_error);
	echo "<select name='zincou' id='zincou'>\n";
	for($i=0;$i<mysql_num_rows($res);$i++){
		$zincou=mysql_result($res,$i,'username');
		$id=mysql_result($res,$i,'id');
		
		echo "<option value='$id' name='zincou' id='zincou'>$zincou</option>";
		
	}
	echo "</select>";
}

function check_zincous_data($g_id,$zincou) {
	connect_to_zincous_database();
	$que=mysql_query("SELECT count(*) FROM events.agenda WHERE group_id='$g_id' AND user_id='$zincou'");
	return mysql_num_rows($que);

}
function get_zincou_name($get_zincous,$i) {
	$username=mysql_result($get_zincous,$i,'username');
	return $username;
}
function get_zincou_id($get_zincous,$i){
	$id=mysql_result($get_zincous,$i,'id');
	return $id;
}
?>
