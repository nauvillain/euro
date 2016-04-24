<?php
require 'php_header_ru.php';
//require 'header_forum.php';
require 'lib_forum.php';
echo "<script type='text/javascript' src='js/sarissa.js'>\n";
echo "</script>\n";
echo "<script type='text/javascript' src='js/forum.js'>\n";
echo "</script>\n";
connect_to_eurodb();
echo "<script type='text/javascript' src='js/domcollapse.js'></script>\n";
echo "<div id='main'>";

$minutes=$_GET['minutes'];

//echo "<img src='forum.gif'>";
$times=array("30","120","240","1440","7200");
$labels=array("half-hour","2 hours","4 hours","day","5 days");
$period=array_combine($times,$labels);
echo "<div class='middle' style='font-size:14px;font-weight:bold;color:#8B2323'>Forum</div>\n";
echo "<div class='middle'>\n";
for($i=0;$i<sizeof($times);$i++){
	echo "<a href='forum.php?minutes=".$times[$i]."'>Last ".$labels[$i]."</a>\n";
	echo "&nbsp;  / &nbsp;";
	}
echo "<a href='forum.php?minutes=0'>All</a>\n";
echo "<br/>\n";
echo "You can post messages with  a maximum size of 2048 characters if you are using Internet Explorer\n";
echo "<br/>\n";
if(!$minutes) $message="Showing all messages";
else $message="Highlighting messages posted in the last <div style='font-weight:800;font-size:11px; display:inline'>".$period[$minutes]."</div>.";
echo $message;
echo "</div>\n";

echo "<div id='forum'>";
echo "<div id='new_thread'><div id='0_0'><a href='#' onclick=\"javascript:addPost('0_0')\">Add new thread</a></div></div>\n";
echo "<br/><br/>\n";
$threads=display_threads($minutes);
if(!$threads) {
	echo "<br/>No new post within the last <b>".$period[$minutes]."</b>.";
	}
echo "</div>";
//echo "</table>";
// end of new stuff

require 'foot_foot.php';
?>
