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
<div>
<div id='temp_items'><?php //echo get_word_by_id(132);?></div>
<?php
//echo "<div id='sa_menu_title' style='top:-30px;left:275px;'><img src='img/groups.gif'/></div>\n";
?>
<a name="first_round">
<div id='team_ranking_all'>
<?php

display_all_groups($groups);
?>
</div>
</div>
</div>
<?php
?>
