<?php
require 'php_header.php';
require 'javascript.php';

$error=$_GET['m_id'];
$err=$_GET['error'];
echo "<div id='main'>";
if($error==1) {
	$str="Your bets have NOT been saved.<br/>You have somehow exceeded the total amount of points you can bet for all matches. Please go 
	back and enter your bets so that the sum of the points you bet on all matches is less than ".$TOT_WEIGHTS.". Thanks!<br/><br/>
	Feel free to let me know as well, as this should not have happened (obviously). ERR=".$err;
}
//echo "<br><br><a href='javascript:history.back()'>Back</a>";
echo $str;
//if($sql) echo "Matches have been updated.<br><br>";
//echo "<br><a href='adManage.php'>Main page</a>";
echo "<br><br><a href='edit_bets1.php'>Edit your bets</a>";
echo "</div>";

require 'foot_foot.php';
?>
