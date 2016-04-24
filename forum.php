<?php
require 'php_header.php';
//require 'header_forum.php';
require 'lib_forum.php';
echo "<script type='text/javascript'>
var replystr='".get_word_by_id(105)."';
var newthreadstr='".get_word_by_id(96)."';
</script>\n";
echo "<script type='text/javascript' src='js/sarissa.js'>\n";
echo "</script>\n";
echo "<script type='text/javascript' src='js/forum.js'>\n";
echo "</script>\n";
connect_to_eurodb();
echo "<script type='text/javascript' src='js/domcollapse.js'></script>\n";
echo "<div id='foot_main'>";
//echo "<div id='sa_menu_title' style='top:-30px;left:275px;'><img src='img/forum.gif'/></div>\n";

$minutes=$_GET['minutes'];

//echo "<img src='forum.gif'>";
$times=array("30","120","240","1440","7200");
$labels_en=array("last half-hour","last 2 hours","last 4 hours","last day","5 days");
$labels_fr=array("Dernière demi-heure","2 dernières heures","4 dernières heures","dernier jour","5 derniers jours");
$labels_hu=array("elmúlt fél orá","elmúlt 2 orá","elmúlt 4 orá","elmúlt nap","elmúlt 5 nap");
$temp="labels_".$language;
$period=array_combine($times,$$temp);
//echo "<div class='middle' style='font-size:14px;font-weight:bold;color:#8B2323'>Forum</div>\n";
echo "<div class='middle'>\n";
for($i=0;$i<sizeof($times);$i++){
	echo "<a href='forum.php?minutes=".$times[$i]."'> ".${$temp}[$i]."</a>\n";
	echo "&nbsp;  / &nbsp;";
	}
echo "<a href='forum.php?minutes=0'>".get_word_by_id(106)."</a>\n";
echo "<br/>\n";
?>
<!--[if IE]> 
<?php
if($language=='en') echo "You are using Internet Explorer, so you cannot post messages with  a maximum size of 2048 characters.";
?>
 <![endif]--> 
<?php
echo "<br/>\n";
//echo $message;
echo "</div>\n";

echo "<div id='forum'>";
echo "<div id='new_thread'><div id='0_0'><a href='#' onclick=\"javascript:addPost('0_0')\">".get_word_by_id(96)."</a></div></div>\n";
echo "<br/><br/>\n";
$threads=display_threads($minutes);
if(!$threads) {
	if($minutes) echo "<br/>".get_word_by_id(95).": <b>".$period[$minutes]."</b>.";
	else echo "";
	}
echo "</div>";
//echo "</table>";
// end of new stuff

?>
