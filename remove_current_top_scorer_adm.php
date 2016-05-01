<?php
require 'authAdm.php';
require 'lib.php';
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';


connect_to_database();
$rest=mysql_query("SELECT * FROM scorer WHERE top=1");
$numt=mysql_num_rows($rest);
echo "<h3>Remove current top scorer</h3>";
echo "<b>Current top scorer </b><br/>";
for ($i=0;$i<$numt;$i++){
	$topsc=mysql_result($rest,$i,'top_scorer');
	echo $topsc."<br/>";
}
$res=mysql_query("SELECT * FROM scorer");
$num=mysql_num_rows($res);

echo "<br/>
<form name='form1' method='post' onLoad=\"document.getElementById('scorer').focus()\"  action='submit_remove_current_tsc_adm.php'>";
echo "<select name='scorer' size=1>";

//if there is a top scorer, display it



for($i=0;$i<$num;$i++){
	$tsc=mysql_result($res,$i,'top_scorer');
	$scorer_id=mysql_result($res,$i,'id');
	echo "<option ".($top_scorer==$scorer_id?"selected":"")." value='$scorer_id'>$tsc</option>\n";
}
echo "</select>";
echo "
<input type=submit name='submit' type='submit' value='submit scorer'>
</form>";



require 'footer.php';
?>
