<?php
require 'php_header.php';
require 'admin.php';
echo "<div id='foot_main'>";
connect_to_eurodb();

$res=mysql_query("SELECT id from matches");
$num=mysql_numrows($res);

if ($num==0) echo "No users registered yet!";
//echo "<table border='0' bordercolor=grey>\n";


for($i=0;$i<$num;$i++){

  //  echo "<tr>\n";
  //  echo "<td>\n".$p_id;
		$id=mysql_result($res,$i,'id');
		$arr=odds($id);
		$query="UPDATE matches SET odds1=".($arr[0]).",oddsD=".($arr[1]).",odds2=".($arr[2])." WHERE id=$id";
		$re=mysql_query($query);
  //  echo "</td>";
  //  echo "</tr>\n";
}


?>
