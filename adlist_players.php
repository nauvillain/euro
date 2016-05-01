<?php
require 'php_header.php';
require 'admin.php';
echo "<div id='foot_main'>";
connect_to_eurodb();

$res=mysql_query("SELECT id,first_name,nickname,city,player FROM users ORDER BY player DESC,first_name");
$num=mysql_numrows($res);
$count=0;
if ($num==0) echo "No users registered yet!";
//echo "<table border='0' bordercolor=grey>\n";


for($i=0;$i<$num;$i++){
  $p_id=mysql_result($res,$i,"id");
  $nickname=mysql_result($res,$i,"nickname");
  $first_name=mysql_result($res,$i,"first_name");
  $player=mysql_result($res,$i,"player");
  if($nickname=="") $nickname=$first_name;

  //  echo "<tr>\n";
  //  echo "<td>\n".$p_id;
  //  echo "</td>";
    echo "<a href='ad_set_contact.php?id=".$p_id."' class='user_name'>&nbsp;".$first_name."\n</a>".($count==5?"<br/>":"");
	if($count==5) $count=0;
	$count+=1; 
  //  echo "</tr>\n";
}


?>
<?php
require 'foot_foot.php';
?>
