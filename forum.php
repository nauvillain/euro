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
$chrono=$_GET['type'];
$sort=$_GET['sort'];

$selected=array('minutes'=>$minutes,'type'=>$chrono,'sort'=>$sort);

if(!$sort){
	if ($chrono=='threads') $sort='desc';
	else $sort='asc';
}
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
		$arr=array('minutes'=>$times[$i],'type'=>$chrono,'sort'=>$sort);
		make_forum_link($arr,${$temp}[$i],$selected);
//		echo "<a href='forum.php?minutes=".$times[$i]."&type=".$chrono."'> ".${$temp}[$i]."</a>\n";
		echo "&nbsp;  / &nbsp;";
	}
	$arr=array('minutes'=>'0','type'=>$chrono,'sort'=>$sort);
	make_forum_link($arr,get_word_by_id(106),$selected);
	
	echo "&nbsp;  / &nbsp;";
	$arr=array('minutes'=>$archive_forum,'type'=>$chrono,'sort'=>$sort);
	make_forum_link($arr,get_word_by_id(214),$selected);
//	echo "<a href='forum.php?minutes=$archive_forum&type=$chrono'>Brazil</a>\n";
	echo "&nbsp;   &nbsp;";
	echo "&nbsp;   &nbsp;";
	echo "&nbsp;   &nbsp;";
	echo "&nbsp;   &nbsp;";
	echo "&nbsp;   &nbsp;";
	$arr=array('minutes'=>$minutes,'type'=>'threads','sort'=>$sort);
	make_forum_link($arr,get_word_by_id(210),$selected);
	echo "&nbsp;  / &nbsp;";
	$arr=array('minutes'=>$minutes,'type'=>'flat','sort'=>$sort);
	make_forum_link($arr,get_word_by_id(211),$selected);
	//echo "<a href='forum.php?minutes=$minutes&type=threads'>Threads</a>\n";
//	echo "&nbsp;  / &nbsp;";
//	echo "<a href='forum.php?minutes=$minutes&type=flat'>Flat</a>\n";
	echo "&nbsp;   &nbsp;";
	echo "&nbsp;   &nbsp;";
	echo "&nbsp;   &nbsp;";
	echo "&nbsp;   &nbsp;";
	echo "&nbsp;   &nbsp;";
	$arr=array('minutes'=>$minutes,'type'=>$chrono,'sort'=>'asc');
	make_forum_link($arr,'asc',$selected);
	echo "&nbsp;  / &nbsp;";
	$arr=array('minutes'=>$minutes,'type'=>$chrono,'sort'=>'desc');
	make_forum_link($arr,'desc',$selected);
	echo "<br/>\n";
	?>
	<!--[if IE]> 
	<?php
	if($language=='en') echo "You are using Internet Explorer, so you can post messages with  a maximum size of 2048 characters.";
	?>
	 <![endif]--> 
	<?php
	echo "<br/>\n";
	//echo $message;
	echo "</div>\n";

	echo "<div id='forum'>";
	echo "<div id='new_thread'><div id='0_0'><a href='#' onclick=\"javascript:addPost('0_0')\">".get_word_by_id(96)."</a></div></div>\n";
	echo "<br/><br/>\n";
if($chrono=='threads') {
	$threads=display_threads($minutes,$sort);
}
if($chrono=='flat'){
	$threads=display_threads_flat($minutes,$sort);
}

if(!$threads) {
	if($minutes) echo "<br/>".get_word_by_id(95).": <b>".$period[$minutes]."</b>.";
	else echo "";
	}
echo "</div>";
//echo "</table>";
// end of new stuff

?>
