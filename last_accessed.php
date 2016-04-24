<?php
require 'php_header.php';
require 'admin.php';

echo "<div id='foot_main'>\n";

$win=$_REQUEST['win'];


connect_to_eurodb();
echo "<a href='last_accessed.php?win=1'>no scorer or winner</a>\n";

$res=mysql_query("SELECT * FROM users WHERE DATE_SUB(NOW(),INTERVAL 12000 MINUTE)< last_log AND player=1 ORDER BY last_log desc") or die(mysql_error());	
$num=mysql_num_rows($res);
echo $num."<br/>";
for($i=0;$i<$num;$i++){
$top_scorer=mysql_result($res,$i,'last_log');
$code=mysql_result($res,$i,'username');
$id=mysql_result($res,$i,'id');
$email=mysql_result($res,$i,'email');
$b_sql=mysql_query("SELECT count(*) FROM bets WHERE player_id='$id'");
$num_bets=mysql_result($b_sql,0);
$winner=mysql_result($res,$i,'winner');
$scorer=mysql_result($res,$i,'top_scorer');
if($win) {
	if(!$winner||!$scorer) echo $email."; <br/>";
}
else echo "<p>$top_scorer, $code, $num_bets bets ".($winner?"winner":"")."-".($scorer?"scorer":"")."</p>";


}
?>
