<?php
require 'php_header.php';
require 'admin.php';
require 'javascript.php';
echo "<div id='foot_main'>\n";


$rest=mysql_query("SELECT * FROM players where TOP=1 ");
$numt=mysql_num_rows($rest);


echo "<br/>
<form name='form1' method='post' onLoad=\"document.getElementById('scorer').focus()\"  action='submit_top_scorer_adm.php'>";

//if there is a top scorer, display it
echo "<b>Current top scorer </b><br/>";
for ($i=0;$i<$numt;$i++){
	$topsc=mysql_result($rest,$i,'name');
	echo $topsc."(remove:<input type='checkbox' name='".mysql_result($rest,$i,'id')."'>)\n<br/>";
}

$res=mysql_query("SELECT * FROM players ORDER BY name");
$num=mysql_num_rows($res);
	echo "Add new top scorer <input type='checkbox' name='new'>\n-->";
echo "<select name='id' size=1>";


for($i=0;$i<$num;$i++){
	$tsc=mysql_result($res,$i,'name');
	$scorer_id=mysql_result($res,$i,'id');
	echo "<option ".($top_scorer==$scorer_id?"selected":"")." value='$scorer_id'>$tsc</option>\n";
}
echo "</select>\n";
echo "
<input type=submit name='submit' type='submit' value='submit scorer'>\n
</form>\n";



?>
