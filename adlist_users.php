<?php
require 'php_header.php';
if(is_admin($login_id)){
		echo "<div id='foot_main'>";
	connect_to_eurodb();
	sqlutf();
	$res=mysqli_query($link,"SELECT id,first_name,nickname,city,player FROM users ORDER BY player DESC,first_name");
	$num=mysqli_num_rows($res);

	if ($num==0) echo "No users registered yet!";
	//echo "<table border='0' bordercolor=grey>\n";


	for($i=0;$i<$num;$i++){
	  $p_id=mysqli_result($res,$i,"id");
	  $nickname=mysqli_result($res,$i,"nickname");
	  $first_name=mysqli_result($res,$i,"first_name");
	  $player=mysqli_result($res,$i,"player");
	  if($nickname=="") $nickname=$first_name;

	  //  echo "<tr>\n";
	  //  echo "<td>\n".$p_id;
	  //  echo "</td>";
	    echo "<a href='ad_user_profile.php?id=".$p_id."' class='user_name'>&nbsp;".$first_name.($player?"+":"")."\n</a>&nbsp;&nbsp;&nbsp;&nbsp;"; 
	  //  echo "</tr>\n";
	}


}
?>
