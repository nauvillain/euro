<?php
require 'authAdm.php';
require 'lib.php';
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';


$error=0;
for($j=1;$j<65;$j++){
	$arr=odds($j);
	$query="UPDATE matches SET odds1=".($arr[0]).",oddsD=".($arr[1]).",odds2=".($arr[2])." WHERE id=$j";
	$re=mysql_query($query);
	if(!$re) $error=1;
}
if(!$error) header('location:adManage.php');
else echo "An error occurred updating the database.";
 
//echo "odds for the first match:".(round($arr[0],2))."/".($arr[1])."/".($arr[2]).".";





require 'footer.php';
?>
