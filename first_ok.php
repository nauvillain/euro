<?php
require 'php_header_adm.php';

echo "<div id='main'>\n";


connect_to_eurodb();

$res=mysql_query("SELECT * FROM users WHERE (winner='' OR top_scorer='') AND player=1 ORDER BY last_log desc") or die(mysql_error());	
$num=mysql_num_rows($res);
echo $num."<br/>";
for($i=0;$i<$num;$i++){
$top_scorer=mysql_result($res,$i,'last_log');
$code=mysql_result($res,$i,'username');
$id=mysql_result($res,$i,'id');
$b_sql=mysql_query("SELECT count(*) FROM bets WHERE player_id='$id'");
$num_bets=mysql_result($b_sql,0);
echo "<p>$top_scorer, $code, $num_bets bets</p>";


}
require 'foot_foot.php';
?>
