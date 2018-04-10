<?php
require 'php_header.php';
if(is_admin($login_id)){
	echo "<div id='foot_main'>\n";

	$win=getIfSet($_REQUEST['win']);


	connect_to_eurodb();
	echo "<a href='last_accessed.php?win=1'>no scorer or winner</a>\n";

	$res=mysqli_query($link,"SELECT * FROM users WHERE DATE_SUB(NOW(),INTERVAL 12000 MINUTE)< last_log AND player=1 ORDER BY last_log desc") or mysql_error($link);	
	$num=mysqli_num_rows($res);
	echo $num."<br/>";
	for($i=0;$i<$num;$i++){
	$top_scorer=mysqli_result($res,$i,'last_log');
	$code=mysqli_result($res,$i,'username');
	$id=mysqli_result($res,$i,'id');
	$email=mysqli_result($res,$i,'email');
	$b_sql=mysqli_query($link,"SELECT count(*) FROM bets WHERE player_id='$id'");
	$num_bets=mysqli_result($b_sql,0);
	$winner=mysqli_result($res,$i,'winner');
	$scorer=mysqli_result($res,$i,'top_scorer');
	if($win) {
		if(!$winner||!$scorer) echo $email."; <br/>";
	}
	else echo "<p>$top_scorer, $code, $num_bets bets ".($winner?"winner":"")."-".($scorer?"scorer":"")."</p>";


	}
}
?>
