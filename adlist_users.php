<?php
require 'php_header.php';
$flag=1;
if(is_admin($login_id)){
		echo "<div id='foot_main'>";
	connect_to_eurodb();
	sqlutf();
	$res=mysqli_query($link,"SELECT id,username,first_name,nickname,city,player FROM users ORDER BY player DESC,first_name");
	$num=mysqli_num_rows($res);

	if ($num==0) echo "No users registered yet!";
	echo "<table border='0' bordercolor=grey style='vertical-align:top'>\n<tr><td>\n";


	for($i=0;$i<$num;$i++){
		if($i % 25 == 0 ) echo "<td><table>\n";
	  $p_id=mysqli_result($res,$i,"id");
	  $nickname=mysqli_result($res,$i,"nickname");
	  $first_name=mysqli_result($res,$i,"first_name");
	  $player=mysqli_result($res,$i,"player");
	  if($nickname=="") $nickname=$first_name;
	  if(trim($first_name=="")) $first_name=mysqli_result($res,$i,"username");
	  if(!$player&&$flag) {
		  echo "</td></tr></table></td><td></td><td><table>\n";
	      $flag=0;
	  }

	  echo "<tr><td>\n".$p_id;
	  echo "</td>";
	  echo "<td><a href='ad_user_profile.php?id=".$p_id."' class='user_name'>&nbsp;".$first_name.($player?"+":"")."\n</a>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>"; 
	  if(($i+1) % 25 == 0) echo "</table></td>\n";
	}
	echo "</table>\n";

}
?>
