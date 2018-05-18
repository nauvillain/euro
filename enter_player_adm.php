<?php
require 'php_header.php';
//require 'admin.php';
if(is_admin($login_id)){
	echo "<div id='foot_main'>\n";

	if(isset($last_team)) $last_team=$_REQUEST['last_team'];
	else $last_team="";
?>
<form name='form1' method='post' onLoad=\"document.getElementById('scorer').focus()\"  action='submit_foot_player_adm.php'>
<textarea name='player' id='player' type='text' rows=30 cols=50>
</textarea>
<?php
	global $link;
	$res=mysqli_query($link,"SELECT team_id,team_name from teams ORDER by team_name") or die(mysqli_error($link));
	$num=mysqli_num_rows($res);

	echo "<select name='team'>\n";
	for ($i=0;$i<$num;$i++){
		$team_id=mysqli_result($res,$i,'team_id');
		$team_name=mysqli_result($res,$i,'team_name');
		echo "<option  value='$team_id' ".($team_id==$team?"selected":"").">".get_team_name($team_id)."</option>\n";
	}
	echo "</select>\n";

?>

<input type=submit name='submit' type='submit' value='submit scorer'>
</form>
<?php

sqlutf();
$res=mysqli_query($link,"SELECT * FROM players ORDER BY id desc LIMIT 10");
$num=mysqli_num_rows($res);
//echo $num."<br/>";
for($i=0;$i<$num;$i++){
$top_scorer=mysqli_result($res,$i,'name');
$code=mysqli_result($res,$i,'team_id');
echo "<p>".$top_scorer.", ".get_team_name($code)."</p>";

}
}
?>
