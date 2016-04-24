<?php
require 'php_header.php';
require 'javascript.php';


echo "<div id='foot_main'>";
echo "Your group has been saved.";
//echo "<br><br><a href='javascript:history.back()'>Back</a>";

//if($sql) echo "Matches have been updated.<br><br>";
//echo "<br><a href='adManage.php'>Main page</a>";
echo "<br><br><a href='index.php'>Main page</a>&nbsp;&nbsp;";
echo "<a href='set_user_group.php?id=$login_id'>Go back to setting my group</a>&nbsp;&nbsp;\n";
echo "<a href='point_history.php?group=".$login_id."&".graph_link($id,0)."'>Point graph for my group</a>\n";
echo "</div>";

?>
