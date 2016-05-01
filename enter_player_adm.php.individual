<?php
require 'php_header.php';
require 'admin.php';
echo "<div id='foot_main'>\n";

$last_team=$_REQUEST['last_team'];
?>
<form name='form1' method='post' onLoad=\"document.getElementById('scorer').focus()\"  action='submit_foot_player_adm.php'>
<input name='player' id='player' type='text' size=30>
<input name='team' id='team' type='text' value='<?php echo $last_team;?>' size=5>
<input type=submit name='submit' type='submit' value='submit scorer'>
</form>
<?php

sqlutf();
$res=mysql_query("SELECT * FROM players ORDER BY id desc LIMIT 10");
$num=mysql_num_rows($res);
//echo $num."<br/>";
for($i=0;$i<$num;$i++){
$top_scorer=mysql_result($res,$i,'name');
$code=mysql_result($res,$i,'team_id');
echo "<p>".$top_scorer.", ".get_team_name($code)."</p>";

}
?>
