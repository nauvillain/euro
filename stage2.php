<?php
require 'php_header.php';
require 'javascript.php';
require 'hide_script_java.php';


connect_to_eurodb();


//show the teams in their different groups
//show the standings per group, sorted
//show the final round chart, with qualified teams
?>
<div id='foot_main'>
<?php
echo "<div id='sa_menu_title' style='top:-30px;left:275px;'><img src='img/stage2.gif'/></div>\n";
?>
<div style='margin-left:20px;'>
<br>
<div id='display_final_round'>
<table width="100%" border=0 cellspacing="1" cellpadding="1" align="center" frame="below">
<?php
make_final_round_chart_euro();
?>
</table>
</div>
</div>
<?php
require 'foot_foot.php';
?>
