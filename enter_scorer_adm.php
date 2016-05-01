<?php
require 'php_header.php';
require 'admin.php';
require 'javascript.php';
?>
<div id='main'>
<?php


echo "
<form name='form1' method='post' onLoad=\"document.getElementById('scorer').focus()\"  action='submit_scorer_adm.php'>
<input name='scorer' id='scorer' type='text' size=30>
<input name='code' id='code' type='text' size=5>
<input type=submit name='submit' type='submit' value='submit scorer'>
</form>";


$res=mysql_query("SELECT * FROM players where top='1'");
$num=mysql_num_rows($res);

for($i=0;$i<$num;$i++){
$top_scorer=mysql_result($res,$i,'name');
$code=mysql_result($res,$i,'team_id');
echo "<p>$top_scorer, $code</p>";

}
?>
</div>
